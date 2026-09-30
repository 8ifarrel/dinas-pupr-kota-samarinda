<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Pemeriksaan berkala saluran Hantu Banyu: log patroli/pemeriksaan rutin
 * UPTD PSDI, berdiri sendiri dari pengaduan warga (lihat migration/model
 * HantuBanyuPemeriksaanBerkala untuk alasannya) - sengaja tidak punya
 * keterkaitan apa pun ke tabel laporan pengaduan.
 *
 * Memakai titik geocoding nyata yang sama dengan HantuBanyuSeeder (lihat
 * HantuBanyuTitikGeocode.php) supaya kecamatan/kelurahan/nama jalannya tetap
 * data sungguhan, tanpa perlu memanggil ulang Nominatim/Overpass.
 *
 * Kedalaman sedimentasi (cm) dihitung MUNDUR dari target persentase per
 * tingkat keparahan terhadap tinggi eksisting yang di-generate untuk baris
 * itu sendiri (lihat simpanPemeriksaan()) - supaya kategori yang muncul dari
 * rumus HantuBanyuPemeriksaanBerkala::getKategoriSedimentasiAttribute() selalu
 * konsisten dengan tingkat keparahan yang dituju (tier "ringan" tidak pernah
 * berakhir sebagai kategori "Tinggi", dst).
 *
 * Tanggal pemeriksaan disebar mundur 3-180 hari dari sekarang (deterministik
 * lewat indeks, bukan acak, supaya hasil seed bisa diulang persis sama) agar
 * terlihat seperti riwayat patroli yang berjalan, bukan seluruhnya tercatat
 * pada hari yang sama.
 */
class HantuBanyuPemeriksaanBerkalaSeeder extends Seeder
{
  private const FILE_TITIK_BAKU = __DIR__ . '/Support/HantuBanyuTitikGeocode.php';

  /** Sinkron dengan HantuBanyuPemeriksaanBerkalaAdminController::RUAS_SALURAN. */
  private const RUAS_SALURAN = ['primer', 'sekunder', 'tersier'];

  /** Rentang dimensi (meter) realistis per tingkatan ruas: [lebar_min, lebar_max, tinggi_min, tinggi_max]. */
  private const DIMENSI_RUAS = [
    'primer' => [1.5, 2.5, 1.0, 1.8],
    'sekunder' => [0.8, 1.5, 0.6, 1.2],
    'tersier' => [0.4, 0.8, 0.4, 0.7],
  ];

  /**
   * Tiga tingkat keparahan kondisi, dirotasi lintas entri. Tiap tingkat
   * membawa target persentase sedimentasi (dikonversi ke cm sesuai tinggi
   * saluran masing-masing baris), status aliran, dan teks naratif yang
   * konsisten satu sama lain - tidak masuk akal kalau "kondisi baik" tapi
   * berstatus "macet total". Rentang persentasenya sengaja pas dengan ambang
   * kategori di HantuBanyuPemeriksaanBerkala (0-15 Normal, 16-30 Sedang,
   * 31 ke atas Tinggi).
   */
  private const TINGKAT = [
    'ringan' => [
      'persen_sedimentasi' => [5, 15],
      'status_aliran' => ['lancar'],
      'kondisi' => [
        'Baik dan utuh, tidak ada kerusakan struktur.',
        'Baik, kondisi dinding dan lantai saluran masih terawat.',
      ],
      'tindakan' => [
        'Pembersihan rumput liar di bahu saluran.',
        'Pembersihan ringan sampah dan dedaunan di permukaan saluran.',
      ],
      'hambatan' => [
        'Tidak ada hambatan berarti, akses lokasi mudah dijangkau petugas.',
        'Kesadaran warga membuang sampah pada tempatnya masih perlu ditingkatkan.',
      ],
      'rekomendasi' => [
        'Pemeliharaan rutin berkala sesuai jadwal, tidak ada tindakan mendesak.',
        'Lanjutkan pemantauan rutin, kondisi masih dalam batas normal.',
      ],
    ],
    'sedang' => [
      'persen_sedimentasi' => [16, 30],
      'status_aliran' => ['kurang_lancar', 'tersumbat_sebagian'],
      'kondisi' => [
        'Baik, ada retak rambut pada dinding saluran sepanjang beberapa meter.',
        'Sedimentasi lumpur cukup tebal mengendap di dasar saluran.',
      ],
      'tindakan' => [
        'Pengerukan lumpur secara manual oleh petugas Satgas.',
        'Pembersihan sampah dari grill/tangkapan air.',
      ],
      'hambatan' => [
        'Akses alat berat terhalang utilitas pipa milik instansi lain.',
        'Debit air masih cukup tinggi saat pelaksanaan pembersihan.',
      ],
      'rekomendasi' => [
        'Jadwalkan pengerukan menggunakan mini ekskavator dalam waktu dekat.',
        'Tingkatkan frekuensi pembersihan rutin pada ruas ini.',
      ],
    ],
    'berat' => [
      'persen_sedimentasi' => [45, 70],
      'status_aliran' => ['tersumbat_sebagian', 'macet_total'],
      'kondisi' => [
        'Dinding saluran ambles pada beberapa titik.',
        'Penutup/manhole saluran banyak yang hilang atau rusak.',
      ],
      'tindakan' => [
        'Pembongkaran sumbatan puing bangunan secara darurat.',
        'Perbaikan darurat pada bagian dinding yang ambles.',
      ],
      'hambatan' => [
        'Sedimen mengeras di dalam gorong-gorong, sulit dikeruk manual.',
        'Perlu koordinasi lintas instansi karena berdekatan dengan utilitas bawah tanah.',
      ],
      'rekomendasi' => [
        'Perbaikan permanen pada struktur dinding yang ambles.',
        'Pengadaan dan pemasangan kembali tutup manhole beton.',
      ],
    ],
  ];

  public function run(): void
  {
    $titikBaku = is_file(self::FILE_TITIK_BAKU) ? require self::FILE_TITIK_BAKU : [];
    if ($titikBaku === []) {
      return;
    }

    $kelurahanList = DB::table('kelurahan')
      ->join('kecamatan', 'kecamatan.id', '=', 'kelurahan.kecamatan_id')
      ->whereIn('kelurahan.id', array_keys($titikBaku))
      ->orderBy('kelurahan.id')
      ->get(['kelurahan.id as kelurahan_id', 'kecamatan.id as kecamatan_id']);

    foreach ($kelurahanList as $indeks => $wilayah) {
      $titikList = $titikBaku[$wilayah->kelurahan_id];
      $titik = $titikList[$indeks % count($titikList)];

      $this->simpanPemeriksaan($indeks, [
        'kecamatan_id' => $wilayah->kecamatan_id,
        'kelurahan_id' => $wilayah->kelurahan_id,
        'nama_jalan' => $titik['jalan'],
      ]);
    }
  }

  /** Susun & simpan satu baris pemeriksaan; isi naratifnya dirotasi deterministik lewat $indeks. */
  private function simpanPemeriksaan(int $indeks, array $lokasi): void
  {
    $ruas = self::RUAS_SALURAN[$indeks % count(self::RUAS_SALURAN)];
    $tingkatKeys = array_keys(self::TINGKAT);
    $tingkat = self::TINGKAT[$tingkatKeys[$indeks % count($tingkatKeys)]];

    [$lebarMin, $lebarMax, $tinggiMin, $tinggiMax] = self::DIMENSI_RUAS[$ruas];
    $lebar = round($lebarMin + ($indeks % 7) * (($lebarMax - $lebarMin) / 7), 2);
    $tinggi = round($tinggiMin + ($indeks % 5) * (($tinggiMax - $tinggiMin) / 5), 2);

    // Kedalaman sedimentasi (cm) = target persentase tingkat ini * tinggi
    // saluran (m -> cm) BARIS INI SENDIRI, supaya kategori hasil hitungnya
    // selalu jatuh persis pada tingkat yang dituju.
    [$persenMin, $persenMax] = $tingkat['persen_sedimentasi'];
    $targetPersen = $persenMin + ($indeks % ($persenMax - $persenMin + 1));
    $sedimentasiCm = round($tinggi * 100 * $targetPersen / 100, 1);

    $statusAliran = $tingkat['status_aliran'][$indeks % count($tingkat['status_aliran'])];
    $kondisi = $tingkat['kondisi'][$indeks % count($tingkat['kondisi'])];
    $tindakan = $tingkat['tindakan'][$indeks % count($tingkat['tindakan'])];
    $hambatan = $tingkat['hambatan'][$indeks % count($tingkat['hambatan'])];
    $rekomendasi = $tingkat['rekomendasi'][$indeks % count($tingkat['rekomendasi'])];

    $tanggal = now()->subDays(3 + ($indeks * 11) % 178)->toDateString();

    DB::table('hantu_banyu_pemeriksaan_berkala')->insert([
      'tanggal_pemeriksaan' => $tanggal,
      'kecamatan_id' => $lokasi['kecamatan_id'],
      'kelurahan_id' => $lokasi['kelurahan_id'],
      'nama_jalan' => $lokasi['nama_jalan'],
      'nama_ruas_saluran' => $ruas,
      'dimensi_lebar_m' => $lebar,
      'dimensi_tinggi_m' => $tinggi,
      'kondisi_fisik_struktur' => $kondisi,
      'tingkat_sedimentasi_sampah_cm' => $sedimentasiCm,
      'status_aliran_air' => $statusAliran,
      'tindakan_pemeliharaan' => $tindakan,
      'hambatan_kendala' => $hambatan,
      'rekomendasi_tindak_lanjut' => $rekomendasi,
      'created_at' => $tanggal,
      'updated_at' => $tanggal,
    ]);
  }
}
