<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\SusunanOrganisasi;

class BukuTamuSeeder extends Seeder
{
    public function run()
    {
        $id_kepala_dinas = 1;
        $jabatan = SusunanOrganisasi::where('id_susunan_organisasi_parent', 1)
            ->where('id_susunan_organisasi', '!=', $id_kepala_dinas)
            ->select('id_susunan_organisasi', 'nama_susunan_organisasi')
            ->get();

        $prefixes = [
            2 => 'S-', // Sekretariat
            6 => 'SDA-',
            7 => 'BM-',
            8 => 'CK-',
            9 => 'BK-',
            10 => 'PR-', // Penataan Ruang
            11 => 'P-',
            12 => 'PALD-',
            13 => 'PJJ-',
            14 => 'PSDI-',
        ];

        // Mapping jumlah antrean per bagian
        $antreanMap = [
            // id_susunan_organisasi => [selesai_kemarin, selesai_hari_ini, diterima, pending]
            2  => [16, 8, 1, 3],  // Sekretariat
            6  => [5, 4, 1, 2],
            7  => [8, 5, 1, 2],
            8  => [10, 6, 1, 2],
            9  => [7, 3, 1, 1],
            10 => [7, 6, 1, 2],   // Penataan Ruang
            11 => [4, 2, 1, 1],
            12 => [6, 3, 1, 2],
            13 => [5, 2, 1, 1],
            14 => [4, 2, 1, 1],
        ];

        $now = Carbon::now();
        $yesterday = Carbon::now()->subDay();

        foreach ($jabatan as $jab) {
            $id = $jab->id_susunan_organisasi;
            $prefix = $prefixes[$id] ?? 'X-';
            $map = $antreanMap[$id] ?? [3, 2, 1, 1];

            $i = 1;
            // status selesai (kemarin)
            for ($n = 0; $n < $map[0]; $n++, $i++) {
                DB::table('buku_tamu')->insert([
                    // 'id_buku_tamu' => auto-increment, jangan diisi
                    'nomor_urut' => $prefix . $i,
                    'nama_pengunjung' => "Tamu Selesai $i $jab->nama_susunan_organisasi",
                    'nomor_telepon' => '0812000000' . $i,
                    'email' => null,
                    'alamat' => 'Alamat Selesai ' . $i,
                    'jabatan_yang_dikunjungi' => $id,
                    'maksud_dan_tujuan' => 'Keperluan selesai ' . $i,
                    'status' => 'Selesai',
                    'deskripsi_status' => 'Sudah selesai',
                    'created_at' => $yesterday->copy()->addMinutes($i),
                    'updated_at' => $yesterday->copy()->addMinutes($i),
                ]);
            }

            // status selesai (hari ini, sebelum diterima)
            $start_selesai_hari_ini = $i;
            for ($n = 0; $n < $map[1]; $n++, $i++) {
                DB::table('buku_tamu')->insert([
                    'nomor_urut' => $prefix . $i,
                    'nama_pengunjung' => "Tamu Selesai $i $jab->nama_susunan_organisasi",
                    'nomor_telepon' => '0812000000' . $i,
                    'email' => null,
                    'alamat' => 'Alamat Selesai ' . $i,
                    'jabatan_yang_dikunjungi' => $id,
                    'maksud_dan_tujuan' => 'Keperluan selesai ' . $i,
                    'status' => 'Selesai',
                    'deskripsi_status' => 'Sudah selesai',
                    'created_at' => $now->copy()->subHours(4)->addMinutes($i),
                    'updated_at' => $now->copy()->subHours(4)->addMinutes($i),
                ]);
            }

            // 1 data status diterima (tengah, hari ini)
            DB::table('buku_tamu')->insert([
                'nomor_urut' => $prefix . $i,
                'nama_pengunjung' => "Tamu Diterima $jab->nama_susunan_organisasi",
                'nomor_telepon' => '0812000000' . $i,
                'email' => null,
                'alamat' => 'Alamat Diterima',
                'jabatan_yang_dikunjungi' => $id,
                'maksud_dan_tujuan' => 'Keperluan diterima',
                'status' => 'Diterima',
                'deskripsi_status' => 'Silakan masuk',
                'created_at' => $now->copy()->subHours(2),
                'updated_at' => $now->copy()->subHours(2),
            ]);
            $i++;

            // status pending (setelahnya, hari ini)
            for ($n = 0; $n < $map[3]; $n++, $i++) {
                DB::table('buku_tamu')->insert([
                    'nomor_urut' => $prefix . $i,
                    'nama_pengunjung' => "Tamu Pending $i $jab->nama_susunan_organisasi",
                    'nomor_telepon' => '0812000000' . $i,
                    'email' => null,
                    'alamat' => 'Alamat Pending ' . $i,
                    'jabatan_yang_dikunjungi' => $id,
                    'maksud_dan_tujuan' => 'Keperluan pending ' . $i,
                    'status' => 'Pending',
                    'deskripsi_status' => null,
                    'created_at' => $now->copy()->addMinutes($i),
                    'updated_at' => $now->copy()->addMinutes($i),
                ]);
            }
        }
    }
}