<?php

namespace App\Observers;

use App\Models\LogAktivitas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Pencatat jejak audit untuk seluruh perubahan data.
 *
 * Dipasang sekali ke semua model lewat AppServiceProvider, sehingga controller
 * mana pun tidak perlu memanggil apa-apa: setiap create/update/delete otomatis
 * tercatat, termasuk yang dijalankan dari seeder maupun tinker.
 *
 * Prinsip yang dipegang: pencatatan tidak boleh pernah menggagalkan aksi
 * aslinya. Bila pencatatan bermasalah, kesalahannya ditulis ke laravel.log dan
 * proses utama tetap lanjut - lebih baik kehilangan satu baris log daripada
 * membuat admin gagal menyimpan data.
 */
class LogAktivitasObserver
{
  /**
   * Model yang tidak dicatat.
   *
   * LogAktivitas sendiri wajib dikecualikan agar pencatatan tidak memicu
   * pencatatan lagi tanpa henti. Sisanya adalah tabel penghitung trafik yang
   * bertambah pada hampir setiap kunjungan halaman; bila ikut dicatat, aksi
   * admin akan tenggelam di antara ribuan baris kunjungan per hari.
   */
  public const DIKECUALIKAN = [
    LogAktivitas::class,
    \App\Models\Visitor::class,
    \App\Models\PageVisit::class,
    \App\Models\JalanPeduliIPLog::class,
    \App\Models\BeritaView::class,
    \App\Models\PengumumanView::class,
    \App\Models\AlbumKegiatanView::class,
  ];

  /** Kolom yang nilainya tidak boleh ikut tersimpan di log. */
  private const KOLOM_RAHASIA = [
    'password',
    'remember_token',
    'key',
  ];

  /** Kolom yang selalu berubah namun tidak menambah informasi apa pun. */
  private const KOLOM_DIABAIKAN = [
    'created_at',
    'updated_at',
    // Naik sendiri saat pengunjung membuka berita/pengumuman/album kegiatan,
    // bukan hasil perbuatan admin. Bila ikut dicatat, log akan penuh baris
    // "ubah" atas nama publik yang tidak berguna bagi siapa pun. Perubahan
    // yang hanya berisi kolom ini otomatis tidak menghasilkan log sama sekali.
    'views_count',
  ];

  private const BATAS_PANJANG_NILAI = 500;

  public function created(Model $model): void
  {
    $this->catat('tambah', $model, $this->ringkasAtribut($model->getAttributes()));
  }

  public function updated(Model $model): void
  {
    // Memulihkan data bersoft delete secara teknis adalah pengubahan kolom
    // deleted_at, sehingga event "updated" ikut terpicu. Kejadian itu sudah
    // dicatat sebagai "pulihkan" lewat event restored, jadi di sini dilewati
    // agar satu tindakan tidak menghasilkan dua baris log.
    $kolomBerubah = array_values(array_diff(array_keys($model->getChanges()), self::KOLOM_DIABAIKAN));

    if ($kolomBerubah === [] || $kolomBerubah === ['deleted_at']) {
      return;
    }

    $perubahan = [];

    foreach ($model->getChanges() as $kolom => $nilaiBaru) {
      if (in_array($kolom, self::KOLOM_DIABAIKAN, true)) {
        continue;
      }

      $perubahan[$kolom] = [
        'dari' => $this->bersihkanNilai($kolom, $model->getOriginal($kolom)),
        'menjadi' => $this->bersihkanNilai($kolom, $nilaiBaru),
      ];
    }

    // Penyimpanan yang tidak mengubah kolom apa pun tidak perlu dicatat.
    if ($perubahan === []) {
      return;
    }

    $this->catat('ubah', $model, $perubahan);
  }

  /**
   * Penghapusan lunak maupun permanen sama-sama masuk lewat sini.
   *
   * Sengaja tidak ada handler forceDeleted terpisah: pada penghapusan permanen
   * Laravel memicu event "deleted" DAN "forceDeleted", sehingga satu tindakan
   * akan tercatat dua kali bila keduanya ditangani.
   */
  public function deleted(Model $model): void
  {
    $this->catat('hapus', $model, $this->ringkasAtribut($model->getAttributes()));
  }

  public function restored(Model $model): void
  {
    $this->catat('pulihkan', $model, $this->ringkasAtribut($model->getAttributes()));
  }

  // ------------------------------------------------------------------
  // Penulisan
  // ------------------------------------------------------------------

  private function catat(string $aksi, Model $model, array $perubahan): void
  {
    try {
      $pelaku = $this->pelaku();
      $permintaan = $this->konteksPermintaan();

      LogAktivitas::create([
        'pelaku_tipe' => $pelaku['tipe'],
        'pelaku_id' => $pelaku['id'],
        'pelaku_nama' => $pelaku['nama'],
        'pelaku_username' => $pelaku['username'],
        'aksi' => $aksi,
        'model' => get_class($model),
        'model_label' => $this->labelModel($model),
        'record_id' => $this->idRecord($model),
        'record_label' => $this->labelRecord($model),
        'perubahan' => $perubahan ?: null,
        'ip_address' => $permintaan['ip'],
        'metode' => $permintaan['metode'],
        'url' => $permintaan['url'],
        'user_agent' => $permintaan['user_agent'],
      ]);
    } catch (\Throwable $e) {
      // Sengaja ditelan: aksi pengguna tidak boleh gagal gara-gara pencatatan.
      Log::error('Gagal mencatat log aktivitas: ' . $e->getMessage(), [
        'aksi' => $aksi,
        'model' => get_class($model),
      ]);
    }
  }

  // ------------------------------------------------------------------
  // Pelaku
  // ------------------------------------------------------------------

  /**
   * Identitas pelaku aksi.
   *
   * Pengguna yang terautentikasi diperiksa lebih dulu, baru konteks konsol.
   * Urutan ini penting: perintah artisan pun bisa berjalan atas nama pengguna
   * tertentu, dan bila konsol diperiksa duluan, aksinya akan salah tercatat
   * sebagai "sistem" padahal ada manusia yang bertanggung jawab.
   *
   * @return array{tipe:string,id:?int,nama:?string,username:?string}
   */
  private function pelaku(): array
  {
    // Anotasi diperlukan karena guard mengembalikan kontrak Authenticatable,
    // sedangkan model sebenarnya baru ditentukan config/auth.php saat berjalan.
    /** @var \App\Models\User|null $admin */
    $admin = Auth::user();
    if ($admin) {
      return [
        'tipe' => ($admin->is_super_admin ?? false) ? 'super_admin' : 'admin',
        'id' => $admin->id ?? null,
        'nama' => $admin->fullname ?? null,
        'username' => $admin->name ?? null,
      ];
    }

    /** @var \App\Models\UserKelurahan|null $kelurahan */
    $kelurahan = Auth::guard('kelurahan')->user();
    if ($kelurahan) {
      return [
        'tipe' => 'kelurahan',
        'id' => $kelurahan->id ?? null,
        'nama' => $kelurahan->fullname ?? null,
        'username' => $kelurahan->name ?? null,
      ];
    }

    // Tanpa pengguna terautentikasi: perintah artisan dan seeder dicatat
    // sebagai "sistem", sedangkan permintaan web tanpa login (mis. warga
    // mengirim pengaduan) dicatat sebagai "publik".
    if (app()->runningInConsole()) {
      return ['tipe' => 'sistem', 'id' => null, 'nama' => null, 'username' => null];
    }

    return ['tipe' => 'publik', 'id' => null, 'nama' => null, 'username' => null];
  }

  /** @return array{ip:?string,metode:?string,url:?string,user_agent:?string} */
  private function konteksPermintaan(): array
  {
    if (app()->runningInConsole() || !app()->bound('request')) {
      return ['ip' => null, 'metode' => null, 'url' => null, 'user_agent' => null];
    }

    $request = request();

    return [
      'ip' => $request->ip(),
      'metode' => $request->method(),
      'url' => Str::limit($request->fullUrl(), 2000, ''),
      'user_agent' => Str::limit((string) $request->userAgent(), 500, ''),
    ];
  }

  // ------------------------------------------------------------------
  // Penamaan yang enak dibaca manusia
  // ------------------------------------------------------------------

  /** "App\Models\BeritaKategori" -> "Berita Kategori" */
  private function labelModel(Model $model): string
  {
    $nama = class_basename($model);

    // Awalan fitur ditulis utuh supaya tidak terpecah jadi "Hantu Banyu Laporan"
    // yang membingungkan saat disaring per fitur.
    return Str::headline($nama);
  }

  private function idRecord(Model $model): ?string
  {
    $kunci = $model->getKey();

    return $kunci === null ? null : (string) $kunci;
  }

  /**
   * Cari kolom yang paling mewakili identitas sebuah record, supaya baris log
   * terbaca "Berita: Perbaikan Jalan Ahmad Yani" alih-alih sekadar "Berita #12".
   */
  private function labelRecord(Model $model): ?string
  {
    $atribut = $model->getAttributes();

    // Urutan sengaja dari yang paling spesifik ke paling umum.
    $polaPrioritas = [
      '/^judul/',
      '/^nama_lengkap$/',
      '/^fullname$/',
      '/^nama/',
      '/^title$/',
      '/^name$/',
      '/^pertanyaan/',
      '/^deskripsi/',
    ];

    foreach ($polaPrioritas as $pola) {
      foreach ($atribut as $kolom => $nilai) {
        if (!preg_match($pola, $kolom)) {
          continue;
        }

        if (in_array($kolom, self::KOLOM_RAHASIA, true)) {
          continue;
        }

        if (is_string($nilai) && trim($nilai) !== '') {
          return Str::limit(trim($nilai), 200);
        }
      }
    }

    return null;
  }

  // ------------------------------------------------------------------
  // Pembersihan nilai
  // ------------------------------------------------------------------

  private function ringkasAtribut(array $atribut): array
  {
    $hasil = [];

    foreach ($atribut as $kolom => $nilai) {
      if (in_array($kolom, self::KOLOM_DIABAIKAN, true)) {
        continue;
      }

      $hasil[$kolom] = $this->bersihkanNilai($kolom, $nilai);
    }

    return $hasil;
  }

  /**
   * Nilai rahasia diganti penanda, nilai panjang dipotong. Log ini bisa dibaca
   * super admin lewat antarmuka, jadi kata sandi dan kunci API tidak boleh
   * pernah ikut tersimpan meski dalam bentuk hash.
   */
  private function bersihkanNilai(string $kolom, mixed $nilai): mixed
  {
    $kolomKecil = Str::lower($kolom);

    $rahasia = in_array($kolomKecil, self::KOLOM_RAHASIA, true)
      || Str::contains($kolomKecil, ['password', 'token', 'secret', 'api_key']);

    if ($rahasia) {
      return $nilai === null ? null : '••••••• (disembunyikan)';
    }

    if (is_string($nilai)) {
      return Str::limit($nilai, self::BATAS_PANJANG_NILAI);
    }

    if (is_array($nilai)) {
      return Str::limit(json_encode($nilai, JSON_UNESCAPED_UNICODE), self::BATAS_PANJANG_NILAI);
    }

    if ($nilai instanceof \DateTimeInterface) {
      return $nilai->format('Y-m-d H:i:s');
    }

    return $nilai;
  }
}
