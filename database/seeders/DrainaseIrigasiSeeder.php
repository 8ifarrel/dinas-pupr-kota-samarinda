<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DrainaseIrigasiSeeder extends Seeder
{
    public function run()
    {
        // Seeder Pelapor
        $pelaporIds = [];
        for ($i = 1; $i <= 28; $i++) {
            $pelaporIds[] = DB::table('drainase_irigasi_pelapor')->insertGetId([
                'nama_lengkap' => 'Pelapor ' . $i,
                'pekerjaan' => 'Pekerjaan ' . $i,
                'alamat' => 'Alamat Pelapor ' . $i,
                'nomor_telepon' => '0812345678' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seeder Laporan (satu laporan untuk satu pelapor)
        $kecamatanIds = DB::table('kecamatan')->pluck('id')->toArray();
        $kelurahanIds = DB::table('kelurahan')->pluck('id')->toArray();
        $laporanIds = [];
        foreach ($pelaporIds as $i => $pelaporId) {
            $laporanIds[] = DB::table('drainase_irigasi_laporan')->insertGetId([
                'pelapor_id' => $pelaporId,
                'nama_jalan' => 'Jalan Laporan ' . ($i + 1), // sebelumnya 'alamat'
                'kecamatan_id' => $kecamatanIds[array_rand($kecamatanIds)],
                'kelurahan_id' => $kelurahanIds[array_rand($kelurahanIds)],
                'longitude' => mt_rand(1170000000, 1172000000) / 10000000,
                'latitude' => mt_rand(-1000000, 1000000) / 100000,
                'detail_lokasi' => 'Detail lokasi laporan ' . ($i + 1), // field baru
                'deskripsi_kerusakan' => 'Deskripsi kerusakan laporan ke-' . ($i + 1), // sebelumnya 'deskripsi'
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
                $image = file_get_contents($url);
                Storage::put("public/{$path}", $image);

                DB::table('drainasei_irigasi_laporan_foto')->insert([
                    'laporan_id' => $laporanId,
                    'foto' => $path,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
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
            // Random sampai status keberapa, minimal 1 (pending)
            $maxStatus = rand(1, count($statusList));
            $tindakLanjutIds = [];
            for ($s = 0; $s < $maxStatus; $s++) {
                $status = $statusList[$s];
                if ($status === "pending") {
                    $jenis = 'belum_diklasifikasikan';
                    $deskripsi = 'Laporan telah masuk. Mohon menunggu proses lebih lanjut';
                } else {
                    $jenis = $jenisList[array_rand($jenisList)];
                    $deskripsi = "Tindak lanjut status {$status} laporan {$laporanId}";
                }
                $tindakLanjutId = DB::table('drainase_irigasi_laporan_tindak_lanjut')->insertGetId([
                    'laporan_id' => $laporanId,
                    'status' => $status,
                    'deskripsi' => $deskripsi,
                    'jenis' => $jenis,
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
                        $image = file_get_contents($url);
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
