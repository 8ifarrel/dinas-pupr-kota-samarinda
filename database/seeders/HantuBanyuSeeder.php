<?php

namespace Database\Seeders;

use App\Support\Geocoding\OverpassJalanTerdekat;
use Database\Seeders\Support\DummyMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Pengaduan drainase dan irigasi (Hantu Banyu), lengkap dengan alur tindak lanjutnya.
 *
 * Setiap kelurahan Samarinda mendapat 7 laporan - satu untuk tiap tahap
 * penanganan (STATUS), sehingga papan status maupun peta sebaran punya
 * contoh laporan di semua kelurahan sekaligus di semua tahap. Jenis
 * penanganan (darurat/biasa/rutin) dirotasi dengan offset per kelurahan
 * supaya tidak ada dua kelurahan yang polanya identik persis.
 *
 * Koordinat & nama jalan BUKAN data karangan: seeder ini benar-benar
 * memanggil Nominatim (pencarian + reverse-geocode) untuk menemukan titik
 * nyata di dalam tiap kelurahan, dan Overpass API (lewat OverpassJalanTerdekat,
 * kelas yang sama yang dipakai GeocodingController di fitur peta sebaran)
 * sebagai fallback saat Nominatim tidak punya nama jalan di titik itu atau
 * cuma punya nama gang. Karena ini memanggil layanan publik yang dibatasi
 * ~1 request/detik, seeder ini butuh waktu beberapa menit dan koneksi
 * internet untuk selesai.
 *
 * Aturan yang dijaga di sini:
 *  - kecamatan_id/kelurahan_id SELALU cocok dengan hasil reverse-geocode
 *    titik yang dipakai (bukan cuma diasumsikan dari daftar kelurahan);
 *  - satu pelapor hanya punya satu laporan (kolom pelapor_id unik);
 *  - tindak lanjut mengikuti urutan tahap pada HantuBanyuLaporanAdminController::STATUS
 *    dan hanya diisi sampai tahap yang sudah dicapai, karena admin memang
 *    hanya boleh mengisi tahap secara berurutan;
 *  - kolom jenis sama untuk seluruh tahap dalam satu laporan, mengikuti
 *    perilaku sinkronisasi di controller;
 *  - laporan yang masih di tahap "pending" belum pernah dinilai petugas,
 *    jadi jenisnya tetap "belum_diklasifikasikan" - baru dapat jenis
 *    sungguhan begitu masuk tahap "diterima" atau lebih jauh;
 *  - laporan yang berumur lebih dari 5 bulan WAJIB berstatus "selesai" -
 *    tidak ada laporan yang dibiarkan menggantung berbulan-bulan. Sebagian
 *    mencapainya lewat alur normal (semua tahap terisi berurutan), sebagian
 *    lagi lewat jalur pintas administratif: langsung dari "pending" ke
 *    "selesai" tanpa tahap menengah tercatat, mencerminkan kasus lama yang
 *    ditutup petugas tanpa pencatatan rinci per tahap.
 */
class HantuBanyuSeeder extends Seeder
{
  /** Urutan tahap penanganan; harus sama dengan konstanta STATUS di controller admin. */
  private const STATUS = [
    'pending',
    'diterima',
    'menunggu_survei',
    'sudah_disurvei',
    'menunggu_jadwal_pengerjaan',
    'sedang_dikerjakan',
    'selesai',
  ];

  /** Template pesan tiap tahap. {jalan} dan {kelurahan} diganti per laporan. */
  private const KETERANGAN_TAHAP = [
    'pending' => 'Laporan warga terkait {jalan}, Kelurahan {kelurahan} telah masuk dan menunggu verifikasi petugas.',
    'diterima' => 'Laporan {jalan} diverifikasi dan diterima untuk ditindaklanjuti.',
    'menunggu_survei' => 'Laporan {jalan} masuk antrean survei lapangan.',
    'sudah_disurvei' => 'Survei lapangan di {jalan} selesai dilaksanakan dan kondisi terdokumentasi.',
    'menunggu_jadwal_pengerjaan' => 'Menunggu penjadwalan pengerjaan di {jalan} sesuai ketersediaan alat dan personel.',
    'sedang_dikerjakan' => 'Pengerjaan perbaikan saluran di {jalan} sedang berlangsung di lokasi.',
    'selesai' => 'Pengerjaan di {jalan}, Kelurahan {kelurahan} selesai dan saluran kembali berfungsi normal.',
  ];

  /** Dipakai laporan lama yang ditutup lewat jalur pintas (lihat buatLaporanTutupLangsung()). */
  private const KETERANGAN_TUTUP_LANGSUNG = 'Laporan {jalan}, Kelurahan {kelurahan} sudah melewati periode tindak lanjut standar dan diselesaikan langsung oleh petugas tanpa pencatatan tahap menengah.';

  /** Jenis penanganan sungguhan - "belum_diklasifikasikan" khusus laporan yang masih pending. */
  private const JENIS_TERKLASIFIKASI = ['darurat', 'biasa', 'rutin'];

  /** Deskripsi pengaduan per jenis, dipilih bergilir supaya tidak monoton. {jalan} diganti per laporan. */
  private const DESKRIPSI = [
    'belum_diklasifikasikan' => [
      'Warga melaporkan genangan air di {jalan}, kondisi belum sempat ditinjau petugas.',
      'Ada keluhan saluran tersumbat di {jalan}, menunggu petugas menilai tingkat keparahannya.',
    ],
    'darurat' => [
      'Saluran drainase di {jalan} tersumbat total sehingga air meluap ke badan jalan saat hujan.',
      'Gorong-gorong di {jalan} ambles dan menyebabkan genangan cukup dalam, membahayakan pengendara.',
      'Tanggul kecil di {jalan} jebol, air irigasi meluap deras ke permukiman warga.',
    ],
    'biasa' => [
      'Sedimentasi lumpur pada saluran di {jalan} menyebabkan aliran air tersendat.',
      'Penutup saluran di {jalan} retak dan sebagian pecah, berpotensi membahayakan pejalan kaki.',
      'Saluran irigasi di {jalan} meluap ke halaman warga tiap kali hujan deras.',
    ],
    'rutin' => [
      'Aliran air di {jalan} tersumbat akar pohon dan tumpukan ranting, perlu pembersihan berkala.',
      'Saluran drainase di {jalan} mulai dangkal akibat endapan dan perlu pengerukan rutin.',
      'Rumput liar menutupi saluran di {jalan}, mengurangi kapasitas tampung air hujan.',
    ],
  ];

  /** Detail lokasi, dirotasi lintas laporan. {kelurahan} dan {rt} diganti per laporan. */
  private const DETAIL_LOKASI = [
    'RT {rt}, dekat balai Kelurahan {kelurahan}',
    'Simpang menuju permukiman warga, Kelurahan {kelurahan}',
    'Depan gang keluarga, RT {rt} Kelurahan {kelurahan}',
    'Sisi jalan menuju pasar, Kelurahan {kelurahan}',
    'Belakang sekolah dasar, RT {rt} Kelurahan {kelurahan}',
    'Dekat jembatan kecil, Kelurahan {kelurahan}',
    'Seberang musala, RT {rt} Kelurahan {kelurahan}',
    'Ujung gang menuju perumahan, Kelurahan {kelurahan}',
  ];

  private const NAMA_DEPAN = [
    'Ahmad', 'Ratna', 'Joko', 'Maria', 'Hendra', 'Nurul', 'Bambang', 'Fitri', 'Siti', 'Dedi',
    'Wulan', 'Agus', 'Yuli', 'Rudi', 'Indah', 'Fajar', 'Dewi', 'Yusuf', 'Rahmat', 'Sri',
    'Andi', 'Lestari', 'Wahyu', 'Putri',
  ];

  private const NAMA_BELAKANG = [
    'Fauzi', 'Sari Dewi', 'Purnomo', 'Ulfa', 'Gunawan', 'Hidayah', 'Iriawan', 'Handayani',
    'Nurhaliza', 'Saputra', 'Ramadhan', 'Wijaya', 'Kartika', 'Susanto', 'Hasanah', 'Nugroho',
    'Setiawan', 'Anggraini', 'Pratama', 'Rahayu',
  ];

  /** Batas umur (hari) sebelum sebuah laporan wajib berstatus "selesai". Persis 5 bulan. */
  private const BATAS_HARI_WAJIB_SELESAI = 150;

  /** Kotak pembatas kasar Kota Samarinda: dipakai membatasi pencarian Nominatim (lon_min,lat_max,lon_max,lat_min). */
  private const VIEWBOX = '117.00,-0.30,117.35,-0.65';

  /**
   * Satu titik nyata untuk tiap laporan di sebuah kelurahan (7 tahap = 7
   * laporan = 7 titik), supaya tidak ada dua laporan yang jatuh di koordinat
   * yang sama persis dan menumpuk di peta sebaran.
   */
  private const TITIK_PER_KELURAHAN = 7;

  /** Jarak minimum antar titik dalam satu kelurahan (meter), supaya pin tidak berdempetan. */
  private const JARAK_MIN_ANTAR_TITIK = 120;

  /**
   * Jarak minimum terhadap titik milik kelurahan LAIN (meter). Ruas jalan
   * yang menjadi batas antar kelurahan bisa terambil dua kali; ambang ini
   * mencegah dua laporan dari kelurahan berbeda mendarat di simpul yang sama.
   */
  private const JARAK_MIN_ANTAR_KELURAHAN = 30;

  /** Koordinat & titik pusat yang sudah terpakai kelurahan lain selama proses ini berjalan. */
  private array $koordinatTerpakai = [];
  private array $pusatTerpakai = [];

  /** Akun admin yang dicatat sebagai pembuat laporan contoh dari sisi UPTD. */
  private ?int $adminId = null;

  public function run(): void
  {
    // Ambil kelurahan beserta kecamatan induknya sekaligus. Seluruh 66
    // kelurahan Samarinda dipakai - setiap kelurahan harus punya laporan.
    $kelurahanList = DB::table('kelurahan')
      ->join('kecamatan', 'kecamatan.id', '=', 'kelurahan.kecamatan_id')
      ->orderBy('kelurahan.id')
      ->get(['kelurahan.id as kelurahan_id', 'kelurahan.nama as kelurahan_nama', 'kecamatan.id as kecamatan_id', 'kecamatan.nama as kecamatan_nama']);

    if ($kelurahanList->isEmpty()) {
      return;
    }

    // Dipakai untuk sebagian laporan contoh yang berasal dari admin UPTD.
    // Boleh kosong (mis. database tanpa akun admin) - kolomnya nullable.
    $this->adminId = DB::table('users')->orderBy('id')->value('id');

    $skmTersedia = DB::table('skm')
      ->join('layanan', 'layanan.id', '=', 'skm.layanan_id')
      ->where('layanan.nama', 'hantu_banyu')
      ->orderBy('skm.id')
      ->pluck('skm.id')
      ->all();
    $skmDipakai = 0;

    $totalKelurahan = $kelurahanList->count();

    foreach ($kelurahanList as $ki => $wilayah) {
      $this->command?->getOutput()->write(sprintf(
        "\r  Geocoding kelurahan %d/%d: %s...          ",
        $ki + 1,
        $totalKelurahan,
        $wilayah->kelurahan_nama
      ));

      $titikList = $this->titikUntukKelurahan($wilayah);

      // ~20% kelurahan diberi satu laporan lama yang ditutup lewat jalur
      // pintas (langsung "pending" -> "selesai"), sisanya laporan "selesai"
      // dicapai lewat alur normal (semua tahap terisi berurutan).
      $tutupLangsung = ($ki % 5 === 0);

      foreach (self::STATUS as $tahap => $status) {
        $titik = $titikList[$tahap % count($titikList)];
        $jalan = $titik['jalan'];

        if ($status === 'selesai') {
          if ($tutupLangsung) {
            $this->buatLaporanTutupLangsung($wilayah, $ki, $titik, $skmTersedia, $skmDipakai);
            continue;
          }

          // Selesai lewat alur normal, tapi tetap laporan "lama" (2-5 bulan)
          // supaya rentang umur laporan bervariasi lintas bulan.
          $daysAgo = random_int(60, self::BATAS_HARI_WAJIB_SELESAI - 1);
        } else {
          // Tahap belum final: tetap harus di bawah batas 5 bulan (aturan di
          // atas), jadi jarak umurnya sengaja dibuat singkat.
          $daysAgo = $tahap * 6 + ($ki % 6) + 1;
        }

        $jenis = $tahap === 0
          ? 'belum_diklasifikasikan'
          : self::JENIS_TERKLASIFIKASI[($ki + $tahap) % count(self::JENIS_TERKLASIFIKASI)];

        $this->buatLaporanNormal($wilayah, $ki, $tahap, $jenis, $titik, $daysAgo, $skmTersedia, $skmDipakai);
      }
    }

    $this->command?->getOutput()->writeln("\r  Geocoding selesai." . str_repeat(' ', 40));
  }

  /** Laporan biasa: dibuat sekali, tindak lanjut diisi berurutan sampai tahap $tahapTercapai. */
  private function buatLaporanNormal(
    object $wilayah,
    int $ki,
    int $tahapTercapai,
    string $jenis,
    array $titik,
    int $daysAgo,
    array $skmTersedia,
    int &$skmDipakai
  ): void {
    $globalIndex = $ki * count(self::STATUS) + $tahapTercapai;
    $rt = ($globalIndex % 12) + 1;
    $detail = strtr(self::DETAIL_LOKASI[$globalIndex % count(self::DETAIL_LOKASI)], [
      '{kelurahan}' => $wilayah->kelurahan_nama,
      '{rt}' => $rt,
    ]);
    $deskripsiPool = self::DESKRIPSI[$jenis];
    $deskripsi = strtr($deskripsiPool[$globalIndex % count($deskripsiPool)], ['{jalan}' => $titik['jalan']]);

    $dilaporkan = now()->subDays($daysAgo)->setTime(8, 45);

    [$pelaporId, $laporanId] = $this->buatPelaporDanLaporan(
      $wilayah,
      $globalIndex,
      $titik,
      $detail,
      $deskripsi,
      $dilaporkan,
      $skmTersedia,
      $skmDipakai,
      self::STATUS[$tahapTercapai] === 'selesai'
    );

    $this->fotoLaporan($laporanId, $dilaporkan);
    $this->tindakLanjut($laporanId, $jenis, $tahapTercapai, $dilaporkan, $titik['jalan'], $wilayah->kelurahan_nama);
  }

  /**
   * Laporan lama (>5 bulan) yang ditutup langsung oleh petugas: hanya dua
   * baris tindak lanjut ("pending" saat masuk, "selesai" saat ditutup),
   * tanpa tahap menengah tercatat. Jenis disinkronkan ke KEDUA baris,
   * meniru perilaku sinkronisasi jenis di controller admin.
   */
  private function buatLaporanTutupLangsung(object $wilayah, int $ki, array $titik, array $skmTersedia, int &$skmDipakai): void
  {
    $globalIndex = $ki * count(self::STATUS) + (count(self::STATUS) - 1);
    $rt = ($globalIndex % 12) + 1;
    $jenis = self::JENIS_TERKLASIFIKASI[$ki % count(self::JENIS_TERKLASIFIKASI)];
    $detail = strtr(self::DETAIL_LOKASI[$globalIndex % count(self::DETAIL_LOKASI)], [
      '{kelurahan}' => $wilayah->kelurahan_nama,
      '{rt}' => $rt,
    ]);
    $deskripsiPool = self::DESKRIPSI[$jenis];
    $deskripsi = strtr($deskripsiPool[$globalIndex % count($deskripsiPool)], ['{jalan}' => $titik['jalan']]);

    // Umur bervariasi lintas bulan DAN tahun (5 sampai ~13 bulan lalu).
    $umurHari = random_int(self::BATAS_HARI_WAJIB_SELESAI + 1, 400);
    $dilaporkan = now()->subDays($umurHari)->setTime(8, 45);
    // Ditutup beberapa minggu setelah masuk - jauh sebelum "sekarang", jadi tidak akan pernah di masa depan.
    $ditutup = $dilaporkan->copy()->addDays(random_int(14, 45));

    [$pelaporId, $laporanId] = $this->buatPelaporDanLaporan(
      $wilayah,
      $globalIndex,
      $titik,
      $detail,
      $deskripsi,
      $dilaporkan,
      $skmTersedia,
      $skmDipakai,
      true
    );

    $keteranganTutup = strtr(self::KETERANGAN_TUTUP_LANGSUNG, [
      '{jalan}' => $titik['jalan'],
      '{kelurahan}' => $wilayah->kelurahan_nama,
    ]);

    $this->fotoLaporan($laporanId, $dilaporkan);

    DB::table('hantu_banyu_laporan_tindak_lanjut')->insert([
      'laporan_id' => $laporanId,
      'status' => 'pending',
      // Jenis disinkronkan ke tahap pending juga, sesuai perilaku sinkronisasi asli.
      'deskripsi' => 'Laporan warga terkait ' . $titik['jalan'] . ', Kelurahan ' . $wilayah->kelurahan_nama . ' telah masuk dan menunggu verifikasi petugas.',
      'jenis' => $jenis,
      'created_at' => $dilaporkan,
      'updated_at' => $dilaporkan,
    ]);

    $tindakLanjutId = DB::table('hantu_banyu_laporan_tindak_lanjut')->insertGetId([
      'laporan_id' => $laporanId,
      'status' => 'selesai',
      'deskripsi' => $keteranganTutup,
      'jenis' => $jenis,
      'created_at' => $ditutup,
      'updated_at' => $ditutup,
    ]);

    $nama = 'tl' . $tindakLanjutId . '_' . $ditutup->format('YmdHis') . '.png';
    DB::table('hantu_banyu_laporan_tindak_lanjut_foto')->insert([
      'tindak_lanjut_id' => $tindakLanjutId,
      'foto' => DummyMedia::gambar(
        "hantu-banyu/{$laporanId}/tindak_lanjut/{$nama}",
        1280,
        960,
        'SELESAI (TUTUP LANGSUNG)',
        'hantu-banyu'
      ),
      'created_at' => $ditutup,
      'updated_at' => $ditutup,
    ]);
  }

  /** Simpan baris pelapor + laporan yang dipakai kedua jalur (normal & tutup langsung). */
  private function buatPelaporDanLaporan(
    object $wilayah,
    int $globalIndex,
    array $titik,
    string $detail,
    string $deskripsi,
    $dilaporkan,
    array $skmTersedia,
    int &$skmDipakai,
    bool $sudahSelesai
  ): array {
    $namaPelapor = self::NAMA_DEPAN[$globalIndex % count(self::NAMA_DEPAN)]
      . ' ' . self::NAMA_BELAKANG[intdiv($globalIndex, count(self::NAMA_DEPAN)) % count(self::NAMA_BELAKANG)];
    $telepon = '0812' . str_pad((string) (3450000 + $globalIndex), 7, '0', STR_PAD_LEFT);
    $rt = ($globalIndex % 12) + 1;

    $pelaporId = DB::table('hantu_banyu_pelapor')->insertGetId([
      'nama_lengkap' => $namaPelapor,
      // Kelurahan asal pelapor sengaja disamakan dengan lokasi laporan -
      // mencerminkan aturan akun kelurahan: hanya boleh melapor di
      // kelurahannya sendiri, dan kelurahan tersebut sudah diverifikasi
      // lewat reverse-geocode titiknya (lihat titikUntukKelurahan()).
      'kelurahan_asal_id' => $wilayah->kelurahan_id,
      'alamat' => 'RT ' . $rt . ', Kelurahan ' . $wilayah->kelurahan_nama . ', Samarinda',
      'nomor_telepon' => $telepon,
      // SKM diisi hanya untuk sebagian laporan yang sudah "selesai" - wajar
      // hanya sebagian warga yang sempat mengisi survei kepuasan.
      'skm_id' => ($sudahSelesai && $skmDipakai < count($skmTersedia)) ? $skmTersedia[$skmDipakai++] : null,
      'created_at' => $dilaporkan,
      'updated_at' => $dilaporkan,
    ]);

    $laporanId = DB::table('hantu_banyu_laporan')->insertGetId([
      'pelapor_id' => $pelaporId,
      // Sebagian kecil laporan dicatat sebagai buatan admin UPTD, bukan
      // operator kelurahan - supaya kolom & filter "Pelapor" punya kedua
      // macam data untuk diuji. Pemilihannya tetap (bukan acak) agar hasil
      // seed bisa diulang dengan isi yang sama.
      'dibuat_oleh_tipe' => $globalIndex % 9 === 0 ? 'admin' : 'kelurahan',
      'dibuat_oleh_user_id' => $globalIndex % 9 === 0 ? $this->adminId : null,
      'nama_jalan' => $titik['jalan'],
      'kecamatan_id' => $wilayah->kecamatan_id,
      'kelurahan_id' => $wilayah->kelurahan_id,
      'longitude' => $titik['lon'],
      'latitude' => $titik['lat'],
      'detail_lokasi' => $detail,
      'deskripsi_pengaduan' => $deskripsi,
      'created_at' => $dilaporkan,
      'updated_at' => $dilaporkan,
    ]);

    return [$pelaporId, $laporanId];
  }

  /** Foto kondisi lokasi yang diunggah pelapor saat membuat laporan. */
  private function fotoLaporan(int $laporanId, $waktu): void
  {
    for ($i = 1; $i <= 2; $i++) {
      $nama = 'foto_' . $waktu->format('YmdHis') . '_' . $i . '.png';

      DB::table('hantu_banyu_laporan_foto')->insert([
        'laporan_id' => $laporanId,
        'foto' => DummyMedia::gambar(
          "hantu-banyu/{$laporanId}/foto_laporan/{$nama}",
          1280,
          960,
          'LAPORAN ' . $laporanId . ' - FOTO ' . $i,
          'hantu-banyu'
        ),
        'created_at' => $waktu,
        'updated_at' => $waktu,
      ]);
    }
  }

  /** Isi tahap penanganan secara berurutan sampai tahap yang sudah dicapai. */
  private function tindakLanjut(int $laporanId, string $jenis, int $tahapTercapai, $waktuLaporan, string $jalan, string $kelurahanNama): void
  {
    for ($tahap = 0; $tahap <= $tahapTercapai; $tahap++) {
      $status = self::STATUS[$tahap];
      $waktu = $waktuLaporan->copy()->addDays($tahap)->addHours(2);
      $keterangan = strtr(self::KETERANGAN_TAHAP[$status], [
        '{jalan}' => $jalan,
        '{kelurahan}' => $kelurahanNama,
      ]);

      $tindakLanjutId = DB::table('hantu_banyu_laporan_tindak_lanjut')->insertGetId([
        'laporan_id' => $laporanId,
        'status' => $status,
        'deskripsi' => $keterangan,
        'jenis' => $jenis,
        'created_at' => $waktu,
        'updated_at' => $waktu,
      ]);

      // Hanya tahap yang memang menghasilkan dokumentasi lapangan yang diberi foto.
      if (!in_array($status, ['sudah_disurvei', 'sedang_dikerjakan', 'selesai'], true)) {
        continue;
      }

      $nama = 'tl' . $tindakLanjutId . '_' . $waktu->format('YmdHis') . '.png';

      DB::table('hantu_banyu_laporan_tindak_lanjut_foto')->insert([
        'tindak_lanjut_id' => $tindakLanjutId,
        'foto' => DummyMedia::gambar(
          "hantu-banyu/{$laporanId}/tindak_lanjut/{$nama}",
          1280,
          960,
          strtoupper(str_replace('_', ' ', $status)),
          'hantu-banyu'
        ),
        'created_at' => $waktu,
        'updated_at' => $waktu,
      ]);
    }
  }

  // ------------------------------------------------------------------
  // Geocoding sungguhan: Nominatim (pencarian + reverse) + Overpass API.
  // ------------------------------------------------------------------

  /** Data hasil geocoding nyata yang sudah dibekukan (lihat kumpulkanTitikGeocode.php di README). */
  private const FILE_TITIK_BAKU = __DIR__ . '/Support/HantuBanyuTitikGeocode.php';

  private static ?array $titikBakuCache = null;

  /**
   * Titik geocoding tiap kelurahan. Dibekukan (bukan dipanggil ulang tiap
   * db:seed) karena Nominatim+Overpass dibatasi ~1 request/detik - seluruh
   * 66 kelurahan makan waktu puluhan menit kalau dipanggil langsung setiap
   * kali. Datanya tetap hasil geocoding sungguhan, cuma diambil sekali dan
   * ditempel di HantuBanyuTitikGeocode.php; kelurahan yang belum ada di
   * situ (mis. baru ditambahkan setelah data dibekukan) tetap di-geocode
   * langsung sebagai jalan terakhir.
   *
   * @return array<int,array{lat:float,lon:float,jalan:string}>
   */
  private function titikUntukKelurahan(object $wilayah): array
  {
    if (self::$titikBakuCache === null) {
      self::$titikBakuCache = is_file(self::FILE_TITIK_BAKU) ? require self::FILE_TITIK_BAKU : [];
    }

    if (isset(self::$titikBakuCache[$wilayah->kelurahan_id])) {
      return self::$titikBakuCache[$wilayah->kelurahan_id];
    }

    Log::warning("HantuBanyuSeeder: kelurahan id={$wilayah->kelurahan_id} ({$wilayah->kelurahan_nama}) belum ada di data geocoding beku, geocode langsung (lambat).");

    return $this->titikUntukKelurahanLive($wilayah);
  }

  /**
   * Cari beberapa titik nyata di dalam sebuah kelurahan lewat Nominatim +
   * Overpass langsung, lengkap dengan nama jalannya. Titik pertama = hasil
   * pencarian langsung kelurahan tersebut (paling akurat); titik berikutnya
   * = variasi kecil di sekitarnya, masing-masing diverifikasi dulu lewat
   * reverse-geocode supaya benar-benar berada di kelurahan yang sama
   * sebelum dipakai.
   *
   * @return array<int,array{lat:float,lon:float,jalan:string}>
   */
  private function titikUntukKelurahanLive(object $wilayah): array
  {
    $pusat = $this->cariPusatKelurahan($wilayah->kelurahan_nama, $wilayah->kecamatan_nama);

    if ($pusat === null) {
      // Nominatim tidak menemukan wilayahnya sama sekali - pakai titik acak
      // dalam kotak pembatas Samarinda sebagai jalan terakhir, supaya seeder
      // tetap bisa selesai walau satu kelurahan gagal digeocode.
      Log::warning("HantuBanyuSeeder: pusat kelurahan '{$wilayah->kelurahan_nama}' tidak ditemukan di Nominatim, pakai titik acak.");
      $pusat = [
        'lat' => -0.30 - (random_int(0, 3500) / 10000),
        'lon' => 117.00 + (random_int(0, 3500) / 10000),
        'presisi' => false,
      ];
    }

    // Kelurahan yang tidak dikenali OSM memakai titik pusat KECAMATAN-nya,
    // dan beberapa kelurahan bisa berbagi kecamatan yang sama - kalau
    // dibiarkan, laporan mereka semua menumpuk di satu koordinat. Digeser
    // dulu ke "pusat semu" yang berbeda-beda per kelurahan.
    if (($pusat['presisi'] ?? true) === false) {
      $pusat = $this->geserPusat($pusat, $wilayah->kelurahan_id);
    }

    // Sebagian kelurahan (mis. "Sungai Pinang I" vs "Sungai Pinang II")
    // dikenali Nominatim sebagai tempat yang sama, sehingga titik pusatnya
    // bertumpuk. Kalau pusatnya bertabrakan dengan kelurahan lain, geser
    // dulu supaya kumpulan jalan yang diambil tidak persis sama.
    foreach ($this->pusatTerpakai as $lama) {
      if ($this->jarakMeter($pusat['lat'], $pusat['lon'], $lama['lat'], $lama['lon']) < 50) {
        $pusat = $this->geserPusat($pusat, $wilayah->kelurahan_id);
        break;
      }
    }
    $this->pusatTerpakai[] = ['lat' => $pusat['lat'], 'lon' => $pusat['lon']];

    $titikList = $this->titikDiJalanSekitar($pusat, $wilayah);
    $this->periksaTitikPertama($titikList, $wilayah);

    foreach ($titikList as $t) {
      $this->koordinatTerpakai[] = ['lat' => $t['lat'], 'lon' => $t['lon']];
    }

    return $titikList;
  }

  /**
   * Ambil titik-titik contoh yang benar-benar berada DI ATAS ruas jalan
   * bernama di sekitar pusat kelurahan.
   *
   * Dibalik dari pendekatan sebelumnya ("geser titik acak, lalu tanya jalan
   * apa yang ada di situ"): di sini daftar jalan diambil dulu lewat SATU
   * panggilan Overpass, baru titiknya diletakkan pada simpul ruas jalan itu.
   * Hasilnya nama jalan dan koordinat pasti sinkron (titiknya memang simpul
   * jalan tersebut, bukan hasil tebakan reverse-geocode), sebarannya alami
   * karena tiap laporan ditaruh di ruas jalan yang berbeda, dan biayanya
   * jauh lebih murah - 1 panggilan per kelurahan, bukan belasan.
   *
   * @return array<int,array{lat:float,lon:float,jalan:string}>
   */
  private function titikDiJalanSekitar(array $pusat, object $wilayah): array
  {
    $kandidat = [];

    // Cara terbaik: minta Overpass hanya jalan yang berada DI DALAM batas
    // wilayah kelurahan itu (kalau Nominatim mengenalinya sebagai relation
    // batas administratif). Radius sekeliling titik pusat mau tidak mau ikut
    // menjaring jalan milik kelurahan tetangga.
    if (!empty($pusat['osm_relation_id'])) {
      foreach ([3, 10, 20, 40] as $jedaDetik) {
        $kandidat = OverpassJalanTerdekat::jalanDalamArea($pusat['lat'], $pusat['lon'], $pusat['osm_relation_id']);
        $permintaanGagal = OverpassJalanTerdekat::permintaanTerakhirGagal();
        sleep($jedaDetik);

        if ($kandidat !== []) {
          break;
        }

        // Jawaban sah tapi kosong = wilayahnya memang tidak punya jalan
        // bernama di dalam batas. Mengulanginya cuma buang waktu.
        if (!$permintaanGagal) {
          Log::warning("HantuBanyuSeeder: tidak ada jalan bernama di dalam batas '{$wilayah->kelurahan_nama}', dicoba lewat radius.");
          break;
        }

        Log::warning("HantuBanyuSeeder: Overpass menolak permintaan area untuk '{$wilayah->kelurahan_nama}', dicoba ulang.");
      }
    }

    // Kelurahan tanpa batas wilayah di OSM (kelompok pemekaran) atau query
    // area gagal terus: kembali ke pencarian berbasis radius. Kegagalan
    // sesaat TIDAK boleh langsung dianggap "tidak ada jalan di sini", jadi
    // tetap dicoba ulang dengan jeda lebih panjang sebelum menyerah.
    if ($kandidat === []) {
      foreach ([[1200, 3], [1200, 10], [2500, 20], [2500, 40], [4000, 60]] as [$radius, $jedaDetik]) {
        $kandidat = OverpassJalanTerdekat::jalanSekitar($pusat['lat'], $pusat['lon'], $radius);
        $permintaanGagal = OverpassJalanTerdekat::permintaanTerakhirGagal();
        sleep($jedaDetik);

        if (count($kandidat) >= self::TITIK_PER_KELURAHAN) {
          break;
        }

        if ($kandidat === []) {
          Log::warning($permintaanGagal
            ? "HantuBanyuSeeder: Overpass menolak permintaan untuk '{$wilayah->kelurahan_nama}' (radius {$radius}m), dicoba ulang."
            : "HantuBanyuSeeder: tidak ada jalan bernama dalam radius {$radius}m dari '{$wilayah->kelurahan_nama}', radius diperlebar.");
        }
      }
    }

    if ($kandidat === []) {
      Log::warning("HantuBanyuSeeder: tidak ada jalan bernama di sekitar '{$wilayah->kelurahan_nama}' setelah semua percobaan, pakai titik geseran biasa.");

      return $this->titikGeseranTanpaJalan($pusat);
    }

    $hasil = $this->pilihTitikDariKandidat($kandidat, $pusat);

    // Ada jalannya, tapi tidak satu simpul pun lolos penyaring batas wilayah.
    // Batas dari Nominatim-lah yang salah, bukan jalannya - lebih baik
    // penyaringnya dilepas daripada datanya jatuh ke titik tanpa nama jalan.
    if ($hasil === [] && (isset($pusat['bbox']) || isset($pusat['poligon']))) {
      Log::warning("HantuBanyuSeeder: semua simpul jalan di '{$wilayah->kelurahan_nama}' tertolak penyaring batas wilayah, penyaring dilepas.");
      unset($pusat['bbox'], $pusat['poligon']);
      $hasil = $this->pilihTitikDariKandidat($kandidat, $pusat);
    }

    // Masih kurang (jalan di sekitarnya terlalu sedikit/terlalu pendek) -
    // sisanya diisi titik geseran biasa supaya jumlahnya tetap genap.
    while (count($hasil) < self::TITIK_PER_KELURAHAN) {
      $tambahan = $this->jitter($pusat, 200 + count($hasil) * 120);
      $hasil[] = [
        'lat' => $tambahan['lat'],
        'lon' => $tambahan['lon'],
        'jalan' => $hasil[0]['jalan'] ?? 'Jalan tanpa nama (dekat titik laporan)',
      ];
    }

    return $hasil;
  }

  /**
   * Ambil sebanyak mungkin titik (maksimal TITIK_PER_KELURAHAN) dari daftar
   * ruas jalan kandidat.
   *
   * Putaran pertama mengejar variasi NAMA jalan (satu titik per jalan),
   * putaran kedua baru boleh mengambil simpul lain pada jalan yang sudah
   * dipakai - untuk kelurahan yang jalan bernamanya memang sedikit.
   *
   * @return array<int,array{lat:float,lon:float,jalan:string}>
   */
  private function pilihTitikDariKandidat(array $kandidat, array $pusat): array
  {
    $hasil = [];

    foreach ([true, false] as $namaHarusBaru) {
      $namaDipakai = array_column($hasil, 'jalan');

      foreach ($kandidat as $jalan) {
        if (count($hasil) >= self::TITIK_PER_KELURAHAN) {
          break 2;
        }
        if ($namaHarusBaru && in_array($jalan['name'], $namaDipakai, true)) {
          continue;
        }

        $simpul = $this->simpulTerpisah($jalan['geometry'], $pusat, $hasil);
        if ($simpul === null) {
          continue;
        }

        $hasil[] = ['lat' => $simpul['lat'], 'lon' => $simpul['lon'], 'jalan' => $jalan['name']];
        $namaDipakai[] = $jalan['name'];
      }
    }

    return $hasil;
  }

  /**
   * Pilih satu simpul pada sebuah ruas jalan yang jaraknya minimal
   * JARAK_MIN_ANTAR_TITIK dari semua titik yang sudah dipilih, dan sedekat
   * mungkin dengan pusat kelurahan (supaya tetap di wilayah yang benar).
   *
   * @return array{lat:float,lon:float}|null
   */
  private function simpulTerpisah(array $geometry, array $pusat, array $sudahDipilih): ?array
  {
    // Urutkan simpul dari yang paling dekat ke pusat kelurahan.
    usort($geometry, fn($a, $b) => $this->jarakMeter($pusat['lat'], $pusat['lon'], $a['lat'], $a['lon'])
      <=> $this->jarakMeter($pusat['lat'], $pusat['lon'], $b['lat'], $b['lon']));

    foreach ($geometry as $simpul) {
      // Satu ruas jalan bisa menjulur melewati batas kelurahan (Overpass
      // mengembalikan seluruh ruas yang MENYENTUH wilayah, bukan potongannya
      // saja). Simpul di luar batas dibuang: kotak pembatas dulu sebagai
      // saringan murah, lalu bentuk poligon aslinya sebagai penentu.
      if (isset($pusat['bbox'])) {
        $b = $pusat['bbox'];
        if (
          $simpul['lat'] < $b['lat_min'] || $simpul['lat'] > $b['lat_max']
          || $simpul['lon'] < $b['lon_min'] || $simpul['lon'] > $b['lon_max']
        ) {
          continue;
        }
      }

      if (isset($pusat['poligon']) && !$this->titikDiDalamPoligon((float) $simpul['lat'], (float) $simpul['lon'], $pusat['poligon'])) {
        continue;
      }

      foreach ($sudahDipilih as $titik) {
        if ($this->jarakMeter($simpul['lat'], $simpul['lon'], $titik['lat'], $titik['lon']) < self::JARAK_MIN_ANTAR_TITIK) {
          continue 2;
        }
      }

      // Jangan ambil simpul yang sudah dipakai kelurahan lain (biasanya
      // ruas jalan yang menjadi batas wilayah antar kelurahan).
      foreach ($this->koordinatTerpakai as $titik) {
        if ($this->jarakMeter($simpul['lat'], $simpul['lon'], $titik['lat'], $titik['lon']) < self::JARAK_MIN_ANTAR_KELURAHAN) {
          continue 2;
        }
      }

      return ['lat' => round((float) $simpul['lat'], 7), 'lon' => round((float) $simpul['lon'], 7)];
    }

    return null;
  }

  /** Cadangan terakhir: titik geseran biasa tanpa nama jalan sungguhan. */
  private function titikGeseranTanpaJalan(array $pusat): array
  {
    $hasil = [];
    for ($i = 0; $i < self::TITIK_PER_KELURAHAN; $i++) {
      $titik = $i === 0 ? $pusat : $this->jitter($pusat, 150 + $i * 120);
      $hasil[] = [
        'lat' => round((float) $titik['lat'], 7),
        'lon' => round((float) $titik['lon'], 7),
        'jalan' => 'Jalan tanpa nama (dekat titik laporan)',
      ];
    }

    return $hasil;
  }

  /**
   * Geser titik pusat secara tetap (bukan acak) berdasarkan id kelurahan,
   * dipakai untuk kelurahan yang terpaksa memakai pusat kecamatan bersama:
   * tiap kelurahan mendapat arah & jarak geseran sendiri sehingga tidak
   * mengambil kumpulan jalan yang sama persis dengan tetangganya.
   */
  private function geserPusat(array $pusat, int $kelurahanId): array
  {
    $sudut = (($kelurahanId * 137) % 360) * (M_PI / 180);
    $jarak = 500 + (($kelurahanId * 73) % 900);
    $meterPerDerajatLat = 111320.0;
    $meterPerDerajatLon = 111320.0 * cos(deg2rad($pusat['lat']));

    return [
      'lat' => $pusat['lat'] + ($jarak * sin($sudut)) / $meterPerDerajatLat,
      'lon' => $pusat['lon'] + ($jarak * cos($sudut)) / $meterPerDerajatLon,
      'presisi' => false,
    ];
  }

  /**
   * Ubah GeoJSON batas wilayah dari Nominatim jadi daftar poligon, tiap
   * poligon berisi daftar cincin (cincin pertama = tepi luar, sisanya
   * lubang), tiap cincin berisi pasangan [lon, lat].
   *
   * @return array<int,array<int,array<int,array{0:float,1:float}>>>
   */
  private function poligonDariGeojson($geojson): array
  {
    if (!is_array($geojson) || empty($geojson['coordinates'])) {
      return [];
    }

    return match ($geojson['type'] ?? '') {
      'Polygon' => [$geojson['coordinates']],
      'MultiPolygon' => $geojson['coordinates'],
      default => [],
    };
  }

  /**
   * Apakah sebuah titik berada di dalam batas wilayah? Memakai kaidah
   * ganjil-genap (ray casting): sebuah titik ada di dalam bila garis
   * mendatar dari titik itu memotong tepi poligon sebanyak jumlah ganjil.
   * Lubang di dalam poligon ikut tertangani karena perpotongannya menambah
   * hitungan jadi genap kembali.
   */
  private function titikDiDalamPoligon(float $lat, float $lon, array $daftarPoligon): bool
  {
    foreach ($daftarPoligon as $poligon) {
      $diDalam = false;

      foreach ($poligon as $cincin) {
        $jumlah = count($cincin);

        for ($i = 0, $j = $jumlah - 1; $i < $jumlah; $j = $i++) {
          // GeoJSON menyimpan pasangan sebagai [lon, lat].
          [$lonI, $latI] = [$cincin[$i][0], $cincin[$i][1]];
          [$lonJ, $latJ] = [$cincin[$j][0], $cincin[$j][1]];

          if ((($latI > $lat) !== ($latJ > $lat))
            && ($lon < ($lonJ - $lonI) * ($lat - $latI) / (($latJ - $latI) ?: 1e-12) + $lonI)
          ) {
            $diDalam = !$diDalam;
          }
        }
      }

      if ($diDalam) {
        return true;
      }
    }

    return false;
  }

  /** Jarak dua koordinat dalam meter (perkiraan equirectangular, cukup untuk jarak dalam kota). */
  private function jarakMeter(float $lat1, float $lon1, float $lat2, float $lon2): float
  {
    $dLat = ($lat2 - $lat1) * 111320.0;
    $dLon = ($lon2 - $lon1) * 111320.0 * cos(deg2rad($lat1));

    return sqrt($dLat * $dLat + $dLon * $dLon);
  }

  /** Geser sebuah titik lat/lon secara acak sejauh maksimum $meter, arah acak. */
  private function jitter(array $pusat, int $meter): array
  {
    $sudut = random_int(0, 359) * (M_PI / 180);
    $jarak = random_int((int) ($meter * 0.3), $meter);
    $meterPerDerajatLat = 111320.0;
    $meterPerDerajatLon = 111320.0 * cos(deg2rad($pusat['lat']));

    return [
      'lat' => $pusat['lat'] + ($jarak * sin($sudut)) / $meterPerDerajatLat,
      'lon' => $pusat['lon'] + ($jarak * cos($sudut)) / $meterPerDerajatLon,
    ];
  }

  /**
   * Titik representatif sebuah kelurahan lewat Nominatim search. Beberapa
   * kelurahan kecil/administratif murni (mis. sebagian pemekaran "Sungai
   * Pinang ...") tidak punya batas wilayah tersendiri di OSM, jadi dicoba
   * beberapa format kueri sebelum menyerah ke titik pusat kecamatannya.
   */
  private function cariPusatKelurahan(string $kelurahan, string $kecamatan): ?array
  {
    $namaBersih = $this->bersihkanNamaWilayah($kelurahan);

    // Format ini yang paling cocok dengan gaya penamaan display_name OSM
    // ("Bugis, Samarinda Kota, Samarinda, ..."), jadi dicoba duluan.
    $hasil = $this->nominatimSearch("{$namaBersih}, {$kecamatan}, Samarinda");
    if ($hasil !== null) {
      return $hasil + ['presisi' => true];
    }

    $hasil = $this->nominatimSearch("{$namaBersih}, Kota Samarinda, Kalimantan Timur");
    if ($hasil !== null) {
      return $hasil + ['presisi' => true];
    }

    // Kelurahan itu sendiri tidak dikenali OSM sebagai wilayah tersendiri -
    // pakai titik pusat kecamatannya saja, lebih baik daripada koordinat acak.
    // "presisi" ditandai false: tidak ada batas kelurahan sungguhan untuk
    // diverifikasi, jadi pemanggil (titikUntukKelurahanLive()) tidak perlu
    // mencoba mencocokkan nama kelurahan pada titik-titik di sekitarnya.
    Log::warning("HantuBanyuSeeder: kelurahan '{$kelurahan}' tidak dikenali Nominatim, pakai pusat kecamatan '{$kecamatan}'.");

    $hasil = $this->nominatimSearch("{$kecamatan}, Samarinda");

    return $hasil === null ? null : $hasil + ['presisi' => false];
  }

  /**
   * "Sei/Sungai Dama" -> "Sungai Dama" (utamakan varian resmi "Sungai ...");
   * "Simpang Tiga (Loa Janan Ilir)" -> "Simpang Tiga" (buang catatan kurung).
   */
  private function bersihkanNamaWilayah(string $nama): string
  {
    $nama = trim(preg_replace('/\s*\([^)]*\)\s*/', '', $nama) ?? $nama);

    if (str_contains($nama, '/')) {
      $bagian = array_map('trim', explode('/', $nama));
      foreach ($bagian as $b) {
        if (str_starts_with($b, 'Sungai')) {
          return $b;
        }
      }

      return $bagian[0];
    }

    return $nama;
  }

  /** @return array{lat:float,lon:float}|null */
  private function nominatimSearch(string $query): ?array
  {
    try {
      $res = Http::withHeaders(['User-Agent' => 'dinas-pupr-kota-samarinda/1.0 (seeder-hantu-banyu)'])
        ->timeout(10)
        ->get(rtrim(config('services.nominatim.base_url'), '/') . '/search', [
          'format' => 'jsonv2',
          'q' => $query,
          'limit' => 1,
          'countrycodes' => 'id',
          'viewbox' => self::VIEWBOX,
          'bounded' => 1,
          // Poligon batas wilayahnya sekalian diminta di panggilan yang sama,
          // supaya titik jalan bisa disaring tepat sesuai bentuk kelurahan.
          'polygon_geojson' => 1,
        ]);

      $this->jedaRateLimit();

      if (!$res->ok()) {
        return null;
      }

      $data = $res->json();
      if (!is_array($data) || empty($data[0]['lat']) || empty($data[0]['lon'])) {
        return null;
      }

      $hasil = ['lat' => (float) $data[0]['lat'], 'lon' => (float) $data[0]['lon']];

      // Kalau yang ditemukan memang batas wilayah administratif (relation),
      // id-nya dipakai untuk meminta Overpass hanya mengambil jalan DI DALAM
      // batas itu - jauh lebih tepat daripada radius sekeliling titik pusat.
      if (($data[0]['osm_type'] ?? null) === 'relation' && !empty($data[0]['osm_id'])) {
        $hasil['osm_relation_id'] = (int) $data[0]['osm_id'];
      }

      // Bentuk batas wilayah sesungguhnya (GeoJSON Polygon/MultiPolygon).
      $geojson = $data[0]['geojson'] ?? null;
      $poligon = $this->poligonDariGeojson($geojson);

      // Kotak pembatas + poligon HANYA dipakai kalau yang ditemukan memang
      // sebuah wilayah. Sebagian nama kelurahan pemekaran dikenali Nominatim
      // sebagai titik POI biasa, dan kotak pembatas titik semacam itu cuma
      // belasan meter - kalau dipakai menyaring, semua simpul jalan di
      // sekitarnya ikut terbuang dan datanya jatuh ke cadangan tanpa nama.
      $bbox = $data[0]['boundingbox'] ?? null;
      if ($poligon !== [] && is_array($bbox) && count($bbox) === 4) {
        $hasil['poligon'] = $poligon;

        // Penyaring kasar yang murah, dipakai sebelum uji poligon yang mahal.
        $hasil['bbox'] = [
          'lat_min' => (float) $bbox[0],
          'lat_max' => (float) $bbox[1],
          'lon_min' => (float) $bbox[2],
          'lon_max' => (float) $bbox[3],
        ];
      }

      return $hasil;
    } catch (\Throwable $e) {
      Log::warning('HantuBanyuSeeder: nominatim search gagal - ' . $e->getMessage());
      $this->jedaRateLimit();

      return null;
    }
  }

  /** @return array<string,mixed>|null field "address" dari Nominatim reverse-geocode. */
  private function nominatimReverse(float $lat, float $lon): ?array
  {
    try {
      $res = Http::withHeaders(['User-Agent' => 'dinas-pupr-kota-samarinda/1.0 (seeder-hantu-banyu)'])
        ->timeout(10)
        ->get(rtrim(config('services.nominatim.base_url'), '/') . '/reverse', [
          'format' => 'jsonv2',
          'lat' => $lat,
          'lon' => $lon,
          'addressdetails' => 1,
          'accept-language' => 'id',
        ]);

      $this->jedaRateLimit();

      if (!$res->ok()) {
        return null;
      }

      $alamat = $res->json('address');

      return is_array($alamat) ? $alamat : null;
    } catch (\Throwable $e) {
      Log::warning('HantuBanyuSeeder: nominatim reverse gagal - ' . $e->getMessage());
      $this->jedaRateLimit();

      return null;
    }
  }

  /** Nominatim & Overpass API mensyaratkan maksimal ~1 request/detik. */
  private function jedaRateLimit(): void
  {
    usleep(1100000);
  }

  /** Sama seperti HantuBanyuPengaduanGuestController::koordinatDiKelurahan() - dipakai memverifikasi hasil jitter. */
  private function wilayahCocok(array $alamat, string $namaKelurahan, string $namaKecamatan): bool
  {
    $kelurahanGeo = $alamat['village'] ?? $alamat['neighbourhood'] ?? $alamat['hamlet'] ?? '';
    $kecamatanGeo = $alamat['city_district'] ?? $alamat['municipality'] ?? $alamat['county'] ?? $alamat['suburb'] ?? '';

    if ($kelurahanGeo !== '') {
      return $this->namaCocok($kelurahanGeo, $namaKelurahan);
    }

    if ($kecamatanGeo !== '') {
      return $this->namaCocok($kecamatanGeo, $namaKecamatan);
    }

    return false;
  }

  private function namaCocok(string $dariGeocoder, string $dariDb): bool
  {
    if ($dariGeocoder === '' || $dariDb === '') {
      return false;
    }

    $a = $this->variasiNama($dariGeocoder);
    $b = $this->variasiNama($dariDb);

    foreach ($a as $x) {
      foreach ($b as $y) {
        if ($x === $y) {
          return true;
        }
        if (strlen($x) >= 4 && strlen($y) >= 4 && (str_contains($x, $y) || str_contains($y, $x))) {
          return true;
        }
      }
    }

    return false;
  }

  /** @return array<int,string> */
  private function variasiNama(string $nama): array
  {
    $nama = strtolower(trim($nama));
    $potongan = preg_split('/[\/()]+/', $nama) ?: [];
    $potongan[] = $nama;

    $hasil = [];
    foreach ($potongan as $p) {
      $p = trim($p);
      $p = preg_replace('/\bsei\b/', 'sungai', $p);
      $p = preg_replace('/^(kelurahan|desa|kecamatan)\s+/', '', $p);
      $p = preg_replace('/[^a-z0-9]+/', '', $p);
      if ($p !== '') {
        $hasil[$p] = true;
      }
    }

    return array_keys($hasil);
  }

  /**
   * Jaring pengaman saat pengumpulan data: periksa satu titik (yang terdekat
   * ke pusat) lewat reverse-geocode Nominatim, memastikan titik-titik yang
   * dipilih dari geometri jalan memang mendarat di kelurahan yang benar.
   * Hanya mencatat peringatan - dipakai untuk menemukan kelurahan yang perlu
   * dicek manual, bukan untuk menggagalkan seeding.
   */
  private function periksaTitikPertama(array $titikList, object $wilayah): void
  {
    if ($titikList === []) {
      return;
    }

    $alamat = $this->nominatimReverse($titikList[0]['lat'], $titikList[0]['lon']);

    if ($alamat === null) {
      Log::warning("HantuBanyuSeeder: titik '{$wilayah->kelurahan_nama}' tidak bisa diperiksa (reverse-geocode gagal).");

      return;
    }

    if (!$this->wilayahCocok($alamat, $wilayah->kelurahan_nama, $wilayah->kecamatan_nama)) {
      $geo = $alamat['village'] ?? $alamat['neighbourhood'] ?? $alamat['suburb'] ?? '?';
      Log::warning("HantuBanyuSeeder: titik untuk '{$wilayah->kelurahan_nama}' menurut Nominatim berada di '{$geo}' - perlu dicek manual.");
    }
  }
}
