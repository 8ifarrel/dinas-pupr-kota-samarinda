<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DrainaseIrigasiSeeder extends Seeder
{
    public function run()
    {
        // ------------------------------------------------------------------
        // 1. BERSIHKAN FILE GAMBAR LAMA DI STORAGE
        // ------------------------------------------------------------------
        Storage::deleteDirectory('public/drainase-irigasi');

        // ------------------------------------------------------------------
        // 2. KOSONGKAN TABEL (TRUNCATE) & RESET AUTO-INCREMENT ID
        // ------------------------------------------------------------------
        Schema::disableForeignKeyConstraints();

        DB::table('drainase_irigasi_laporan_tindak_lanjut_foto')->truncate();
        DB::table('drainase_irigasi_laporan_tindak_lanjut')->truncate();
        DB::table('drainasei_irigasi_laporan_foto')->truncate();
        DB::table('drainase_irigasi_laporan')->truncate();
        DB::table('drainase_irigasi_pelapor')->truncate();

        Schema::enableForeignKeyConstraints();

        // ------------------------------------------------------------------
        // 3. GENERATE DATA BARU
        // ------------------------------------------------------------------

        $kecamatanIds = DB::table('kecamatan')->pluck('id')->toArray();
        $kelurahanIds = DB::table('kelurahan')->pluck('id')->toArray();

        // Seeder Pelapor
        $pelaporIds = [];
        for ($i = 1; $i <= 28; $i++) {
            $pelaporIds[] = DB::table('drainase_irigasi_pelapor')->insertGetId([
                'nama_lengkap' => 'Pelapor ' . $i,
                'kelurahan_asal_id' => !empty($kelurahanIds) ? $kelurahanIds[array_rand($kelurahanIds)] : null,
                'alamat' => 'Alamat Pelapor ' . $i,
                'nomor_telepon' => '0812345678' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seeder Laporan (satu laporan untuk satu pelapor)
        $laporanIds = [];
        foreach ($pelaporIds as $i => $pelaporId) {
            $laporanIds[] = DB::table('drainase_irigasi_laporan')->insertGetId([
                'pelapor_id' => $pelaporId,
                'nama_jalan' => 'Jalan Laporan ' . ($i + 1),
                'kecamatan_id' => !empty($kecamatanIds) ? $kecamatanIds[array_rand($kecamatanIds)] : null,
                'kelurahan_id' => !empty($kelurahanIds) ? $kelurahanIds[array_rand($kelurahanIds)] : null,
                'longitude' => mt_rand(1170000000, 1172000000) / 10000000,
                'latitude' => mt_rand(-1000000, 1000000) / 100000,
                'detail_lokasi' => 'Detail lokasi laporan ' . ($i + 1),
                'deskripsi_pengaduan' => 'Deskripsi pengaduan laporan ke-' . ($i + 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seeder Foto Laporan
        foreach ($laporanIds as $laporanId) {
            $jumlahFoto = rand(1, 3);
            for ($j = 1; $j <= $jumlahFoto; $j++) {
                $now = Carbon::now();
                $namaFoto = "foto{$j}_" . $now->format('HisdmY') . ".jpg";
                $path = "drainase-irigasi/{$laporanId}/foto_laporan/{$namaFoto}";
                $url = "https://picsum.photos/600/400?random=" . rand(1, 10000);
                usleep(500000); // delay sebelum request
                $image = @file_get_contents($url);
                if ($image !== false) {
                    Storage::put("public/{$path}", $image);

                    DB::table('drainasei_irigasi_laporan_foto')->insert([
                        'laporan_id' => $laporanId,
                        'foto' => $path,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Seeder Tindak Lanjut & Foto Tindak Lanjut
        $statusList = [
            "pending",
            "diterima",
            "menunggu_survei",
            "sudah_disurvei",
            "menunggu_jadwal_pengerjaan",
            "sedang_dikerjakan",
            "selesai"
        ];
        $jenisList = ["darurat", "biasa", "rutin"];

        foreach ($laporanIds as $laporanId) {
            $maxStatus = rand(1, count($statusList));
            $tindakLanjutIds = [];

            // Jenis penanganan berlaku sama untuk SELURUH tahap dalam satu laporan
            // (mengikuti perilaku aplikasi yang menyinkronkan jenis ke semua tahap).
            // "belum_diklasifikasikan" hanya untuk laporan yang masih di tahap
            // "pending" (Menunggu Verifikasi); begitu maju ke tahap berikutnya,
            // laporan pasti sudah diklasifikasikan.
            $jenisLaporan = $maxStatus === 1
                ? 'belum_diklasifikasikan'
                : $jenisList[array_rand($jenisList)];

            for ($s = 0; $s < $maxStatus; $s++) {
                $status = $statusList[$s];
                if ($status === "pending") {
                    $deskripsi = 'Laporan telah masuk. Mohon menunggu proses lebih lanjut';
                } else {
                    $deskripsi = "Tindak lanjut status {$status} laporan {$laporanId}";
                }
                $tindakLanjutId = DB::table('drainase_irigasi_laporan_tindak_lanjut')->insertGetId([
                    'laporan_id' => $laporanId,
                    'status' => $status,
                    'deskripsi' => $deskripsi,
                    'jenis' => $jenisLaporan,
                    'created_at' => now()->addMinutes($s),
                    'updated_at' => now()->addMinutes($s),
                ]);
                $tindakLanjutIds[] = $tindakLanjutId;

                // Foto hanya untuk status tertentu
                if (in_array($status, ["sudah_disurvei", "sedang_dikerjakan", "selesai"])) {
                    $jumlahFoto = rand(1, 2);
                    for ($f = 1; $f <= $jumlahFoto; $f++) {
                        $now = Carbon::now()->addMinutes($s)->addSeconds($f);
                        $namaFoto = "foto{$f}_" . $now->format('HisdmY') . ".jpg";
                        $path = "drainase-irigasi/{$laporanId}/foto_tindak_lanjut/{$status}/{$namaFoto}";
                        $url = "https://picsum.photos/600/400?random=" . rand(1, 10000);
                        usleep(500000); // delay sebelum request
                        $image = @file_get_contents($url);
                        if ($image !== false) {
                            Storage::put("public/{$path}", $image);

                            DB::table('drainase_irigasi_laporan_tindak_lanjut_foto')->insert([
                                'tindak_lanjut_id' => $tindakLanjutId,
                                'foto' => $path,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            }
        }
    }
}