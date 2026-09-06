<?php

namespace Database\Seeders;

use Database\Seeders\Support\DummyMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Pengaduan drainase dan irigasi (Hantu Banyu), lengkap dengan alur tindak lanjutnya.
 *
 * Aturan yang dijaga di sini:
 *  - kecamatan_id SELALU diturunkan dari kelurahan yang dipilih, sehingga
 *    pasangan kecamatan-kelurahan tidak pernah bertentangan;
 *  - satu pelapor hanya punya satu laporan (kolom pelapor_id unik);
 *  - tindak lanjut mengikuti urutan tahap pada HantuBanyuLaporanAdminController::STATUS
 *    dan hanya diisi sampai tahap yang sudah dicapai, karena admin memang
 *    hanya boleh mengisi tahap secara berurutan;
 *  - kolom jenis sama untuk seluruh tahap dalam satu laporan, mengikuti
 *    perilaku sinkronisasi di controller.
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

  private const KETERANGAN_TAHAP = [
    'pending' => 'Laporan telah masuk dan menunggu verifikasi petugas.',
    'diterima' => 'Laporan diverifikasi dan diterima untuk ditindaklanjuti.',
    'menunggu_survei' => 'Laporan masuk antrean survei lapangan.',
    'sudah_disurvei' => 'Survei lapangan selesai dilaksanakan dan kondisi terdokumentasi.',
    'menunggu_jadwal_pengerjaan' => 'Menunggu penjadwalan pengerjaan sesuai ketersediaan alat dan personel.',
    'sedang_dikerjakan' => 'Pengerjaan perbaikan saluran sedang berlangsung di lokasi.',
    'selesai' => 'Pengerjaan selesai dan saluran kembali berfungsi normal.',
  ];

  /** [nama jalan, detail lokasi, deskripsi, jenis, tahap tercapai (indeks STATUS)]. */
  private const LAPORAN = [
    ['Jl. Ir. H. Juanda', 'Depan minimarket, sisi kiri jalan arah kota', 'Saluran drainase tersumbat sampah sehingga air meluap ke badan jalan saat hujan.', 'darurat', 6],
    ['Jl. Pangeran Antasari', 'Dekat simpang empat, seberang apotek', 'Gorong-gorong ambles dan menyebabkan genangan cukup dalam.', 'darurat', 5],
    ['Jl. Slamet Riyadi', 'Depan gang keluarga, RT 12', 'Sedimentasi lumpur pada saluran menyebabkan aliran air tersendat.', 'biasa', 4],
    ['Jl. Lambung Mangkurat', 'Sisi kanan jalan menuju perumahan', 'Penutup saluran pecah dan membahayakan pengendara.', 'biasa', 3],
    ['Jl. Kadrie Oening', 'Depan ruko blok C', 'Saluran irigasi meluap ke halaman warga saat hujan deras.', 'rutin', 2],
    ['Jl. Ahmad Yani', 'Belakang pasar, dekat jembatan kecil', 'Aliran air tersumbat akar pohon dan tumpukan ranting.', 'rutin', 1],
    ['Jl. M. Said', 'Depan sekolah dasar', 'Genangan air tidak surut lebih dari satu hari setelah hujan.', 'belum_diklasifikasikan', 0],
    ['Jl. Damanhuri', 'Ujung gang menuju masjid', 'Saluran drainase dangkal dan perlu pengerukan.', 'biasa', 6],
  ];

  private const PELAPOR = [
    ['Ahmad Fauzi', '081234500011'],
    ['Ratna Sari Dewi', '081234500022'],
    ['Joko Purnomo', '081234500033'],
    ['Maria Ulfa', '081234500044'],
    ['Hendra Gunawan', '081234500055'],
    ['Nurul Hidayah', '081234500066'],
    ['Bambang Iriawan', '081234500077'],
    ['Fitri Handayani', '081234500088'],
  ];

  public function run(): void
  {
    // Ambil kelurahan beserta kecamatan induknya sekaligus, supaya pasangan
    // wilayah pada laporan dijamin konsisten.
    $kelurahan = DB::table('kelurahan')
      ->join('kecamatan', 'kecamatan.id', '=', 'kelurahan.kecamatan_id')
      ->orderBy('kelurahan.id')
      ->get(['kelurahan.id as kelurahan_id', 'kelurahan.nama as kelurahan_nama', 'kecamatan.id as kecamatan_id']);

    if ($kelurahan->isEmpty()) {
      return;
    }

    $skm = DB::table('skm')
      ->join('layanan', 'layanan.id', '=', 'skm.layanan_id')
      ->where('layanan.nama', 'hantu_banyu')
      ->orderBy('skm.id')
      ->pluck('skm.id')
      ->all();

    foreach (self::LAPORAN as $index => [$jalan, $detail, $deskripsi, $jenis, $tahapTercapai]) {
      $wilayah = $kelurahan[$index % $kelurahan->count()];
      [$namaPelapor, $telepon] = self::PELAPOR[$index];

      $dilaporkan = now()->subDays((count(self::LAPORAN) - $index) * 3)->setTime(8, 45);

      $pelaporId = DB::table('hantu_banyu_pelapor')->insertGetId([
        'nama_lengkap' => $namaPelapor,
        // Kelurahan asal pelapor sengaja disamakan dengan lokasi laporan,
        // mencerminkan warga yang melapor di lingkungannya sendiri.
        'kelurahan_asal_id' => $wilayah->kelurahan_id,
        'alamat' => 'Kelurahan ' . $wilayah->kelurahan_nama . ', Samarinda',
        'nomor_telepon' => $telepon,
        'skm_id' => $skm[$index] ?? null,
        'created_at' => $dilaporkan,
        'updated_at' => $dilaporkan,
      ]);

      $laporanId = DB::table('hantu_banyu_laporan')->insertGetId([
        'pelapor_id' => $pelaporId,
        'nama_jalan' => $jalan,
        'kecamatan_id' => $wilayah->kecamatan_id,
        'kelurahan_id' => $wilayah->kelurahan_id,
        // Koordinat acak dalam rentang wilayah Kota Samarinda.
        'longitude' => round(117.10 + (random_int(0, 1400) / 10000), 7),
        'latitude' => round(-0.55 + (random_int(0, 1800) / 10000), 7),
        'detail_lokasi' => $detail,
        'deskripsi_pengaduan' => $deskripsi,
        'created_at' => $dilaporkan,
        'updated_at' => $dilaporkan,
      ]);

      $this->fotoLaporan($laporanId, $dilaporkan);
      $this->tindakLanjut($laporanId, $jenis, $tahapTercapai, $dilaporkan);
    }
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
  private function tindakLanjut(int $laporanId, string $jenis, int $tahapTercapai, $waktuLaporan): void
  {
    for ($tahap = 0; $tahap <= $tahapTercapai; $tahap++) {
      $status = self::STATUS[$tahap];
      $waktu = $waktuLaporan->copy()->addDays($tahap)->addHours(2);

      $tindakLanjutId = DB::table('hantu_banyu_laporan_tindak_lanjut')->insertGetId([
        'laporan_id' => $laporanId,
        'status' => $status,
        'deskripsi' => self::KETERANGAN_TAHAP[$status],
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
}
