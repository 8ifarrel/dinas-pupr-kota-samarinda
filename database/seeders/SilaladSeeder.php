<?php

namespace Database\Seeders;

use App\Models\Silalad;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Pesanan SILALAD, lengkap dengan riwayat tindak lanjutnya.
 *
 * Ditulis lewat DB::table() langsung (bukan Silalad::create()) supaya setiap
 * tanggal - baik `created_at` pesanan maupun timestamp tiap baris
 * `silalad_tindak_lanjut` - bisa diatur presisi dan tetap runut secara
 * kronologis. Kalau dibuat lewat Eloquent, boot hook Silalad akan mengisi
 * `created_at` dan baris riwayat awal dengan `now()` yang sesungguhnya,
 * sehingga pesanan yang sengaja dibuat "beberapa hari lalu" akan punya baris
 * riwayat pertama bertanggal hari ini - tidak nyambung.
 *
 * Aturan yang dijaga di sini, meniru catatan yang sama di HantuBanyuSeeder:
 *  - kecamatan_id/kelurahan_id untuk Samarinda memakai id numerik dari tabel
 *    kecamatan/kelurahan situs ini sendiri (bukan nama), sesuai aturan yang
 *    sama dipakai formulir & API; untuk luar Samarinda dipakai NAMA wilayah
 *    apa adanya - lihat SilaladPesananController::normalisasiWilayah().
 *  - setiap pesanan hanya punya baris tindak lanjut sampai tahap yang benar-
 *    benar dicapai, dan tanggal tiap baris berurutan maju (tidak pernah
 *    baris tahap berikutnya bertanggal lebih awal dari tahap sebelumnya).
 *  - data operasional (nomor SPK, operator, dst.) hanya terisi bila
 *    pesanan memang sudah mencapai tahap "Dijadwalkan" atau lebih jauh -
 *    pesanan yang masih "Menunggu konfirmasi" tidak punya data itu sama
 *    sekali, dan yang dibatalkan langsung dari "Menunggu konfirmasi" pun
 *    demikian (belum sempat dijadwalkan).
 *  - `tanggal_pelaksanaan` untuk pesanan yang sudah "Selesai" atau
 *    "Sedang dikerjakan" selalu tanggal yang sudah lewat/hari ini, tidak
 *    pernah tanggal yang masih di masa depan - pekerjaan yang sudah
 *    berjalan tidak mungkin bertanggal pelaksanaan nanti.
 *  - rating/kritik/saran hanya diisi untuk pesanan yang sudah melewati
 *    sekadar "Menunggu konfirmasi", karena pelanggan yang laporannya belum
 *    disentuh siapa pun wajar belum punya sesuatu untuk dinilai.
 *  - nilai rating & saran_masukan sengaja TIDAK direkap ulang ke tabel
 *    `skm` di sini - rekap SKM lintas layanan (termasuk milik SILALAD)
 *    sudah dilakukan generik oleh SKMSeeder.
 */
class SilaladSeeder extends Seeder
{
    public function run(): void
    {
        $wilayah = $this->wilayahSamarinda();
        if ($wilayah === []) {
            // KecamatanSeeder/KelurahanSeeder belum jalan - jangan seed
            // dengan id wilayah palsu, lebih baik dilewati saja.
            return;
        }

        $nomorAwal = (int) (DB::table('silalad')
            ->whereYear('created_at', now()->year)
            ->count()) + 1;

        $baris = [
            $this->menungguBaru($wilayah, $nomorAwal),
            $this->menungguTerlantar($wilayah, $nomorAwal + 1),
            $this->dijadwalkanSesuaiPermintaan($wilayah, $nomorAwal + 2),
            $this->dijadwalkanLuarSamarinda($nomorAwal + 3),
            $this->sedangDikerjakan($wilayah, $nomorAwal + 4),
            $this->selesaiMemuaskan($wilayah, $nomorAwal + 5),
            $this->selesaiTerlambat($wilayah, $nomorAwal + 6),
            $this->dibatalkanDariMenunggu($wilayah, $nomorAwal + 7),
            $this->dibatalkanSetelahDijadwalkan($wilayah, $nomorAwal + 8),
        ];

        foreach ($baris as $b) {
            $silaladId = DB::table('silalad')->insertGetId($b['pesanan']);

            foreach ($b['riwayat'] as $r) {
                DB::table('silalad_tindak_lanjut')->insert($r + ['silalad_id' => $silaladId]);
            }
        }
    }

    /** [kecamatan_id, kelurahan_id, nama kecamatan, nama kelurahan] - dipetik dari data asli situs. */
    private function wilayahSamarinda(): array
    {
        return DB::table('kelurahan')
            ->join('kecamatan', 'kecamatan.id', '=', 'kelurahan.kecamatan_id')
            ->whereIn('kelurahan.nama', ['Sidodadi', 'Bukit Pinang', 'Sempaja Selatan', 'Pelita', 'Bugis'])
            ->get(['kelurahan.id as kelurahan_id', 'kelurahan.nama as kelurahan_nama', 'kecamatan.id as kecamatan_id'])
            ->keyBy('kelurahan_nama')
            ->all();
    }

    private function kodeBooking(int $nomor): string
    {
        return 'SIL-' . now()->year . '-' . str_pad((string) $nomor, 3, '0', STR_PAD_LEFT);
    }

    /** Kolom yang selalu ada di setiap pesanan, supaya tiap method di bawah cukup menimpa yang berbeda. */
    private function dasar(int $nomor, $waktuMasuk, array $override): array
    {
        return array_merge([
            'kode_booking' => $this->kodeBooking($nomor),
            'layanan' => 'sedot tinja', // satu-satunya opsi yang benar-benar bisa dipilih di formulir
            'setuju' => true,
            'captcha' => null,
            'status_pengerjaan' => Silalad::MENUNGGU,
            'created_at' => $waktuMasuk,
            'updated_at' => $waktuMasuk,
        ], $override);
    }

    private function riwayatMenunggu($waktu): array
    {
        return [
            'status' => Silalad::MENUNGGU,
            'keterangan' => 'Pesanan diterima dan menunggu dijadwalkan.',
            'created_at' => $waktu,
            'updated_at' => $waktu,
        ];
    }

    private function riwayatDijadwalkan($waktu, string $operator, string $kendaraan, $tanggalPelaksanaan): array
    {
        return [
            'status' => Silalad::DIJADWALKAN,
            'keterangan' => "Pesanan dikonfirmasi dan ditugaskan kepada {$operator} (kendaraan {$kendaraan}), dijadwalkan "
                . $tanggalPelaksanaan->translatedFormat('d F Y') . '.',
            'created_at' => $waktu,
            'updated_at' => $waktu,
        ];
    }

    private function riwayatDikerjakan($waktu): array
    {
        return [
            'status' => Silalad::DIKERJAKAN,
            'keterangan' => 'Petugas sedang mengerjakan penyedotan di lokasi.',
            'created_at' => $waktu,
            'updated_at' => $waktu,
        ];
    }

    private function riwayatSelesai($waktu, int $jumlahRit): array
    {
        return [
            'status' => Silalad::SELESAI,
            'keterangan' => "Penyedotan selesai dikerjakan sebanyak {$jumlahRit} rit.",
            'created_at' => $waktu,
            'updated_at' => $waktu,
        ];
    }

    private function riwayatDibatalkan($waktu, string $alasan): array
    {
        return [
            'status' => Silalad::DIBATALKAN,
            'keterangan' => "Pesanan dibatalkan. {$alasan}",
            'created_at' => $waktu,
            'updated_at' => $waktu,
        ];
    }

    // ------------------------------------------------------------------
    // Sembilan pesanan, tiap method = satu cerita pesanan yang berbeda.
    // ------------------------------------------------------------------

    /** Baru masuk tadi pagi, belum disentuh admin sama sekali. */
    private function menungguBaru(array $w, int $nomor): array
    {
        $masuk = now()->subHours(6);
        $diharapkan = now()->addDays(5);
        $lok = $w['Sidodadi'];

        return [
            'pesanan' => $this->dasar($nomor, $masuk, [
                'nama_pelanggan' => 'Andi Wijaya',
                'nomor_telepon_pelanggan' => '081234500101',
                'alamat' => 'Jl. Pahlawan No.5, Samarinda',
                'alamat_detail' => 'Rumah cat hijau, pagar besi',
                'detail_laporan' => 'Septic tank penuh, sudah 2 hari tidak bisa dipakai.',
                'kabkota_id' => 'Samarinda',
                'kecamatan_id' => $lok->kecamatan_id,
                'kelurahan_id' => $lok->kelurahan_id,
                'latitude' => -0.4881, 'longitude' => 117.1436,
                'jenis_bangunan' => 'Rumah',
                'nomor_bangunan' => 5, 'rt' => 4,
                'tanggal_diharapkan' => $diharapkan->toDateString(),
                // Belum ada yang bisa dinilai - laporan bahkan belum dibaca admin.
                'rating' => null, 'saran_masukan' => null,
            ]),
            'riwayat' => [$this->riwayatMenunggu($masuk)],
        ];
    }

    /**
     * Pesanan lama yang terlantar sebulan tanpa dikonfirmasi - contoh nyata
     * persoalan yang jadi alasan status "Menunggu konfirmasi" dipisah dari
     * "Dijadwalkan" (lihat README, bagian Alur Pengerjaan & Surat). Dibuat
     * sebelum isian "tanggal diharapkan" ditambahkan, jadi kolomnya kosong -
     * tampil sebagai "Tidak dicantumkan" di halaman admin.
     */
    private function menungguTerlantar(array $w, int $nomor): array
    {
        $masuk = now()->subDays(30);
        $lok = $w['Bugis'];

        return [
            'pesanan' => $this->dasar($nomor, $masuk, [
                'nama_pelanggan' => 'Marlina',
                'nomor_telepon_pelanggan' => '081234500102',
                'alamat' => 'Jl. Yos Sudarso Gang 3, Samarinda',
                'alamat_detail' => null,
                'detail_laporan' => 'WC mulai mampet, air susah surut.',
                'kabkota_id' => 'Samarinda',
                'kecamatan_id' => $lok->kecamatan_id,
                'kelurahan_id' => $lok->kelurahan_id,
                'latitude' => -0.4991, 'longitude' => 117.1372,
                'jenis_bangunan' => 'Rumah',
                'nomor_bangunan' => 3, 'rt' => 8,
                'tanggal_diharapkan' => null,
                'rating' => 2,
                'saran_masukan' => "Responsnya lama sekali, sampai saya cari yang lain.",
            ]),
            'riwayat' => [$this->riwayatMenunggu($masuk)],
        ];
    }

    /** Dijadwalkan persis sesuai tanggal yang diminta pelanggan (checkbox tercentang). Armada belum berangkat. */
    private function dijadwalkanSesuaiPermintaan(array $w, int $nomor): array
    {
        $masuk = now()->subDays(4);
        $dijadwalkanPada = now()->subDays(3);
        $diharapkan = now()->addDays(2); // dua hari lagi - armada memang belum berangkat
        $lok = $w['Bukit Pinang'];

        return [
            'pesanan' => $this->dasar($nomor, $masuk, [
                'nama_pelanggan' => 'Herman Susanto',
                'nomor_telepon_pelanggan' => '081234500103',
                'alamat' => 'Jl. Kemakmuran No.21, Samarinda',
                'alamat_detail' => 'Sebelah salon',
                'detail_laporan' => 'Septic tank penuh dan berbau menyengat.',
                'kabkota_id' => 'Samarinda',
                'kecamatan_id' => $lok->kecamatan_id,
                'kelurahan_id' => $lok->kelurahan_id,
                'latitude' => -0.4762, 'longitude' => 117.1481,
                'jenis_bangunan' => 'Rumah',
                'nomor_bangunan' => 21, 'rt' => 12,
                'tanggal_diharapkan' => $diharapkan->toDateString(),
                'status_pengerjaan' => Silalad::DIJADWALKAN,
                'nomor_spk' => '014/UPTD/IX/' . now()->year,
                'nama_operator' => 'Rudi Hartono',
                'nomor_kendaraan' => 'KT 8123 AB',
                'kapasitas_kendaraan' => '4.000 liter',
                'tanggal_pelaksanaan' => $diharapkan->toDateString(), // checkbox "sama dengan permintaan pelanggan"
                // Belum didata - armada baru berangkat 2 hari lagi.
                'jarak_tangki' => null, 'bisa_disedot' => null,
                'tanggal_pesanan' => $dijadwalkanPada->toDateString(),
                'tanggal_perintah' => $dijadwalkanPada->toDateString(),
                'rating' => null, 'saran_masukan' => null,
            ]),
            'riwayat' => [
                $this->riwayatMenunggu($masuk),
                $this->riwayatDijadwalkan($dijadwalkanPada, 'Rudi Hartono', 'KT 8123 AB', $diharapkan),
            ],
        ];
    }

    /**
     * Dijadwalkan dengan tanggal BERBEDA dari permintaan pelanggan (checkbox
     * dilepas admin, karena tanggal yang diminta sudah penuh) - sekaligus
     * contoh pesanan dari LUAR Samarinda, tempat kecamatan/kelurahan
     * tersimpan sebagai nama, bukan id (lihat normalisasiWilayah()).
     */
    private function dijadwalkanLuarSamarinda(int $nomor): array
    {
        $masuk = now()->subDays(6);
        $dijadwalkanPada = now()->subDays(5);
        $diminta = now()->subDays(1); // pelanggan minta secepatnya, dua hari lagi dari saat mendaftar
        $tanggalPelaksanaan = now()->addDays(1); // tapi baru bisa dilayani besok - armada masih di Samarinda

        return [
            'pesanan' => $this->dasar($nomor, $masuk, [
                'nama_pelanggan' => 'Yusuf Ramadhan',
                'nomor_telepon_pelanggan' => '081234500104',
                'alamat' => 'Jl. Wolter Monginsidi, Tenggarong',
                'alamat_detail' => 'Dekat Masjid Agung Sultan Sulaiman',
                'detail_laporan' => 'Septic tank rumah kos penuh, dihuni 6 orang.',
                'kabkota_id' => 'Kabupaten Kutai Kartanegara',
                'kecamatan_id' => 'Tenggarong',
                'kelurahan_id' => 'Timbau',
                'latitude' => -0.4008, 'longitude' => 117.0114,
                'jenis_bangunan' => 'Rumah',
                'nomor_bangunan' => 45, 'rt' => 6,
                'tanggal_diharapkan' => $diminta->toDateString(),
                'status_pengerjaan' => Silalad::DIJADWALKAN,
                'nomor_spk' => '015/UPTD/IX/' . now()->year,
                'nama_operator' => 'Rudi Hartono',
                'nomor_kendaraan' => 'KT 8123 AB',
                'kapasitas_kendaraan' => '4.000 liter',
                'tanggal_pelaksanaan' => $tanggalPelaksanaan->toDateString(),
                // Pelanggan menjelaskan posisi tangki lewat telepon saat
                // dikonfirmasi, jadi sudah bisa diperkirakan sebelum armada
                // benar-benar berangkat.
                'jarak_tangki' => 18, 'bisa_disedot' => 1,
                'tanggal_pesanan' => $dijadwalkanPada->toDateString(),
                'tanggal_perintah' => $dijadwalkanPada->toDateString(),
                'rating' => null, 'saran_masukan' => null,
            ]),
            'riwayat' => [
                $this->riwayatMenunggu($masuk),
                $this->riwayatDijadwalkan($dijadwalkanPada, 'Rudi Hartono', 'KT 8123 AB', $tanggalPelaksanaan),
            ],
        ];
    }

    /** Armada sedang di lokasi hari ini, baru saja melapor balik jarak tangki & kondisinya. */
    private function sedangDikerjakan(array $w, int $nomor): array
    {
        $masuk = now()->subDays(3);
        $dijadwalkanPada = now()->subDays(2);
        $tanggalPelaksanaan = now(); // hari ini
        $dikerjakanPada = now()->subHours(2);
        $lok = $w['Sempaja Selatan'];

        return [
            'pesanan' => $this->dasar($nomor, $masuk, [
                'nama_pelanggan' => 'Siti Nurhaliza',
                'nomor_telepon_pelanggan' => '081234500105',
                'alamat' => 'Jl. Pramuka No.8, Samarinda',
                'alamat_detail' => 'Rumah pojok, dekat lapangan',
                'detail_laporan' => 'WC meluap saat hujan, septic tank diduga penuh.',
                'kabkota_id' => 'Samarinda',
                'kecamatan_id' => $lok->kecamatan_id,
                'kelurahan_id' => $lok->kelurahan_id,
                'latitude' => -0.4453, 'longitude' => 117.1291,
                'jenis_bangunan' => 'Rumah',
                'nomor_bangunan' => 8, 'rt' => 15,
                'tanggal_diharapkan' => $tanggalPelaksanaan->toDateString(),
                'status_pengerjaan' => Silalad::DIKERJAKAN,
                'nomor_spk' => '013/UPTD/IX/' . now()->year,
                'nama_operator' => 'Slamet Riyadi',
                'nomor_kendaraan' => 'KT 9045 CD',
                'kapasitas_kendaraan' => '3.000 liter',
                'tanggal_pelaksanaan' => $tanggalPelaksanaan->toDateString(),
                // Armada baru tiba - jarak & kelayakan baru diketahui sekarang.
                'jarak_tangki' => 8, 'bisa_disedot' => 1,
                'tanggal_pesanan' => $dijadwalkanPada->toDateString(),
                'tanggal_perintah' => $dijadwalkanPada->toDateString(),
                'rating' => null, 'saran_masukan' => null,
            ]),
            'riwayat' => [
                $this->riwayatMenunggu($masuk),
                $this->riwayatDijadwalkan($dijadwalkanPada, 'Slamet Riyadi', 'KT 9045 CD', $tanggalPelaksanaan),
                $this->riwayatDikerjakan($dikerjakanPada),
            ],
        ];
    }

    /** Selesai sesuai jadwal, pelanggan puas. */
    private function selesaiMemuaskan(array $w, int $nomor): array
    {
        $masuk = now()->subDays(10);
        $dijadwalkanPada = now()->subDays(9);
        $tanggalPelaksanaan = now()->subDays(7);
        $dikerjakanPada = $tanggalPelaksanaan->copy()->setTime(9, 0);
        $selesaiPada = $tanggalPelaksanaan->copy()->setTime(11, 30);
        $lok = $w['Pelita'];

        return [
            'pesanan' => $this->dasar($nomor, $masuk, [
                'nama_pelanggan' => 'Dewi Kartika',
                'nomor_telepon_pelanggan' => '081234500106',
                'alamat' => 'Jl. Cendana No.14, Samarinda',
                'alamat_detail' => 'Komplek Griya Cendana Blok B',
                'detail_laporan' => 'Septic tank sudah 3 tahun tidak pernah disedot.',
                'kabkota_id' => 'Samarinda',
                'kecamatan_id' => $lok->kecamatan_id,
                'kelurahan_id' => $lok->kelurahan_id,
                'latitude' => -0.4699, 'longitude' => 117.1523,
                'jenis_bangunan' => 'Rumah',
                'nomor_bangunan' => 14, 'rt' => 9,
                'tanggal_diharapkan' => $tanggalPelaksanaan->toDateString(),
                'status_pengerjaan' => Silalad::SELESAI,
                'nomor_spk' => '008/UPTD/IX/' . now()->year,
                'nama_operator' => 'Rudi Hartono',
                'nomor_kendaraan' => 'KT 8123 AB',
                'kapasitas_kendaraan' => '4.000 liter',
                'tanggal_pelaksanaan' => $tanggalPelaksanaan->toDateString(),
                'jarak_tangki' => 12, 'bisa_disedot' => 1,
                'jumlah_rit' => 2,
                'tanggal_pesanan' => $dijadwalkanPada->toDateString(),
                'tanggal_perintah' => $dijadwalkanPada->toDateString(),
                'rating' => 5,
                'saran_masukan' => 'Pelayanan sangat memuaskan, petugas ramah dan tepat waktu.',
            ]),
            'riwayat' => [
                $this->riwayatMenunggu($masuk),
                $this->riwayatDijadwalkan($dijadwalkanPada, 'Rudi Hartono', 'KT 8123 AB', $tanggalPelaksanaan),
                $this->riwayatDikerjakan($dikerjakanPada),
                $this->riwayatSelesai($selesaiPada, 2),
            ],
        ];
    }

    /** Selesai, tapi jadwalnya mundur dari permintaan pelanggan - kritik ada isinya. */
    private function selesaiTerlambat(array $w, int $nomor): array
    {
        $masuk = now()->subDays(15);
        $diminta = now()->subDays(11); // yang diminta pelanggan
        $dijadwalkanPada = now()->subDays(13);
        $tanggalPelaksanaan = now()->subDays(9); // molor 2 hari dari permintaan (checkbox dilepas)
        $dikerjakanPada = $tanggalPelaksanaan->copy()->setTime(13, 0);
        $selesaiPada = $tanggalPelaksanaan->copy()->setTime(16, 0);
        $lok = $w['Sidodadi'];

        return [
            'pesanan' => $this->dasar($nomor, $masuk, [
                'nama_pelanggan' => 'CV Sumber Rezeki',
                'nomor_telepon_pelanggan' => '081234500107',
                'alamat' => 'Jl. Antasari Ruko No.3, Samarinda',
                'alamat_detail' => 'Ruko dua lantai, lantai dasar toko bangunan',
                'detail_laporan' => 'Septic tank kantor penuh, dipakai 15 karyawan.',
                'kabkota_id' => 'Samarinda',
                'kecamatan_id' => $lok->kecamatan_id,
                'kelurahan_id' => $lok->kelurahan_id,
                'latitude' => -0.4855, 'longitude' => 117.1398,
                'jenis_bangunan' => 'Kantor',
                'nomor_bangunan' => 3, 'rt' => 2,
                'tanggal_diharapkan' => $diminta->toDateString(),
                'status_pengerjaan' => Silalad::SELESAI,
                'nomor_spk' => '006/UPTD/IX/' . now()->year,
                'nama_operator' => 'Slamet Riyadi',
                'nomor_kendaraan' => 'KT 9045 CD',
                'kapasitas_kendaraan' => '3.000 liter',
                'tanggal_pelaksanaan' => $tanggalPelaksanaan->toDateString(),
                'jarak_tangki' => 6, 'bisa_disedot' => 1,
                'jumlah_rit' => 3,
                'tanggal_pesanan' => $dijadwalkanPada->toDateString(),
                'tanggal_perintah' => $dijadwalkanPada->toDateString(),
                'rating' => 3,
                'saran_masukan' => "Jadwal pengerjaan mundur dari yang diminta.\nMohon informasikan lebih awal bila jadwal berubah.",
            ]),
            'riwayat' => [
                $this->riwayatMenunggu($masuk),
                $this->riwayatDijadwalkan($dijadwalkanPada, 'Slamet Riyadi', 'KT 9045 CD', $tanggalPelaksanaan),
                $this->riwayatDikerjakan($dikerjakanPada),
                $this->riwayatSelesai($selesaiPada, 3),
            ],
        ];
    }

    /** Dibatalkan langsung dari "Menunggu konfirmasi" - tidak pernah sempat dijadwalkan sama sekali. */
    private function dibatalkanDariMenunggu(array $w, int $nomor): array
    {
        $masuk = now()->subDays(5);
        $diharapkan = now()->subDays(2);
        $dibatalkanPada = now()->subDays(4);
        $lok = $w['Bugis'];

        return [
            'pesanan' => $this->dasar($nomor, $masuk, [
                'nama_pelanggan' => 'Fajar Nugroho',
                'nomor_telepon_pelanggan' => '081234500108',
                'alamat' => 'Jl. Diponegoro No.30, Samarinda',
                'alamat_detail' => null,
                'detail_laporan' => 'WC mulai penuh, belum darurat.',
                'kabkota_id' => 'Samarinda',
                'kecamatan_id' => $lok->kecamatan_id,
                'kelurahan_id' => $lok->kelurahan_id,
                'latitude' => -0.5002, 'longitude' => 117.1355,
                'jenis_bangunan' => 'Rumah',
                'nomor_bangunan' => 30, 'rt' => 5,
                'tanggal_diharapkan' => $diharapkan->toDateString(),
                'status_pengerjaan' => Silalad::DIBATALKAN,
                // Tidak pernah dijadwalkan - kolom penugasan tetap kosong.
                'alasan_batal' => 'Pelanggan membatalkan karena sudah menggunakan jasa penyedia lain.',
                'rating' => null, 'saran_masukan' => null,
            ]),
            'riwayat' => [
                $this->riwayatMenunggu($masuk),
                $this->riwayatDibatalkan($dibatalkanPada, 'Pelanggan membatalkan karena sudah menggunakan jasa penyedia lain.'),
            ],
        ];
    }

    /**
     * Sudah sempat dijadwalkan, tapi dibatalkan tepat pada hari pelaksanaan
     * karena armada tidak sanggup menjangkau tangkinya - alasan pembatalan
     * konsisten dengan data "bisa disedot: Tidak" yang sudah terisi lebih
     * dulu di tahap Dijadwalkan.
     */
    private function dibatalkanSetelahDijadwalkan(array $w, int $nomor): array
    {
        $masuk = now()->subDays(8);
        $dijadwalkanPada = now()->subDays(7);
        $tanggalRencana = now()->subDays(5);
        $dibatalkanPada = $tanggalRencana->copy()->setTime(10, 0);
        $lok = $w['Bukit Pinang'];

        return [
            'pesanan' => $this->dasar($nomor, $masuk, [
                'nama_pelanggan' => 'Rahmat Hidayat',
                'nomor_telepon_pelanggan' => '081234500109',
                'alamat' => 'Jl. Gang Sepakat No.7, Samarinda',
                'alamat_detail' => 'Masuk gang sempit, motor saja yang bisa lewat',
                'detail_laporan' => 'Septic tank rumah penuh, akses masuk gang sempit.',
                'kabkota_id' => 'Samarinda',
                'kecamatan_id' => $lok->kecamatan_id,
                'kelurahan_id' => $lok->kelurahan_id,
                'latitude' => -0.4771, 'longitude' => 117.1469,
                'jenis_bangunan' => 'Rumah',
                'nomor_bangunan' => 7, 'rt' => 20,
                'tanggal_diharapkan' => $tanggalRencana->toDateString(),
                'status_pengerjaan' => Silalad::DIBATALKAN,
                'nomor_spk' => '007/UPTD/IX/' . now()->year,
                'nama_operator' => 'Rudi Hartono',
                'nomor_kendaraan' => 'KT 8123 AB',
                'kapasitas_kendaraan' => '4.000 liter',
                'tanggal_pelaksanaan' => $tanggalRencana->toDateString(),
                // Jarak tangki 25 meter dari titik parkir terdekat - inilah
                // yang membuat penyedotan akhirnya tidak bisa dilakukan.
                'jarak_tangki' => 25, 'bisa_disedot' => 0,
                'tanggal_pesanan' => $dijadwalkanPada->toDateString(),
                'tanggal_perintah' => $dijadwalkanPada->toDateString(),
                'alasan_batal' => 'Akses jalan menuju tangki septik terlalu sempit untuk mobil tinja, tidak bisa dijangkau selang.',
                'rating' => null, 'saran_masukan' => null,
            ]),
            'riwayat' => [
                $this->riwayatMenunggu($masuk),
                $this->riwayatDijadwalkan($dijadwalkanPada, 'Rudi Hartono', 'KT 8123 AB', $tanggalRencana),
                $this->riwayatDibatalkan(
                    $dibatalkanPada,
                    'Akses jalan menuju tangki septik terlalu sempit untuk mobil tinja, tidak bisa dijangkau selang.'
                ),
            ],
        ];
    }
}
