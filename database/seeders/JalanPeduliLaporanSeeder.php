<?php

namespace Database\Seeders;

use App\Models\JalanPeduliLaporan;
use App\Models\JalanPeduliPelapor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Exception;

class JalanPeduliLaporanSeeder extends Seeder
{
    private function generateIdLaporan($kecamatan_id, $kelurahan_id)
    {
        $id_tahun = Carbon::now()->format('y');
        $id_kecamatan = substr(strval($kecamatan_id), -2);
        $id_kelurahan = substr(strval($kelurahan_id), -2);
        $prefix = $id_tahun . $id_kecamatan . $id_kelurahan;

        $existingIds = JalanPeduliLaporan::where('id_laporan', 'like', $prefix . '%')
            ->pluck('id_laporan')
            ->map(fn($id) => (int)substr($id, strlen($prefix)))
            ->toArray();

        for ($i = 1; $i <= 9999; $i++) {
            if (!in_array($i, $existingIds)) {
                return $prefix . str_pad($i, 4, '0', STR_PAD_LEFT);
            }
        }

        throw new Exception("ID laporan penuh untuk prefix $prefix");
    }

    public function run(): void
    {
        // Daftar kombinasi kelurahan-kecamatan yang valid
        $validCombinations = [
            ['kelurahan_id' => 44464, 'kecamatan_id' => 3139], // Rapak Dalam - Loa Janan Ilir
            ['kelurahan_id' => 44473, 'kecamatan_id' => 3141], // Sidodamai - Samarinda Ilir
            ['kelurahan_id' => 44492, 'kecamatan_id' => 3145], // Tanah Merah - Samarinda Utara
        ];

        $jenisKerusakanOptions = [
            'Lubang-lubang',
            'Ambles',
            'Retak buaya',
            'Permukaan tergerus',
            'Penurunan slab di sambungan',
            'Slab pecah/retak di sambungan',
            'Permukaan tidak rata',
            'Longsor',
        ];
        $tingkatKerusakanOptions = ['Ringan', 'Sedang', 'Berat'];

        $pelaporList = JalanPeduliPelapor::all();
        $totalLaporan = 0;

        foreach ($pelaporList as $pelapor) {
            foreach ($validCombinations as $lokasi) {
                for ($i = 1; $i <= 5; $i++) {
                    $jumlahFoto = rand(1, 5);
                    $fotoFilenames = [];

                    for ($j = 1; $j <= $jumlahFoto; $j++) {
                        $url = "https://picsum.photos/600/400?random=" . rand(1, 1000);
                        $now = now();
                        $filename = $j . '_' . $now->format('HisdmY') . '.jpg';
                        $id_laporan = $this->generateIdLaporan($lokasi['kecamatan_id'], $lokasi['kelurahan_id']);
                        $fotoPath = "jalan_peduli/{$id_laporan}/{$filename}";

                        $imageContents = file_get_contents($url);
                        Storage::disk('public')->put($fotoPath, $imageContents);

                        $fotoFilenames[] = $filename;
                    }

                    $id_laporan = $this->generateIdLaporan($lokasi['kecamatan_id'], $lokasi['kelurahan_id']);
                    $jenisKerusakan = $jenisKerusakanOptions[array_rand($jenisKerusakanOptions)];
                    $tingkatKerusakan = $tingkatKerusakanOptions[array_rand($tingkatKerusakanOptions)];

                    $totalLaporan++;

                    JalanPeduliLaporan::create([
                        'id_laporan' => $id_laporan,
                        'nomor_ponsel' => $pelapor->nomor_ponsel,
                        'alamat_lengkap_kerusakan' => "Jalan Rusak No. {$totalLaporan}",
                        'deskripsi_laporan' => "Laporan dummy no {$totalLaporan} dari pelapor {$pelapor->nama_lengkap}.",
                        'link_koordinat' => "https://maps.google.com/?q=" . (-0.5 + $totalLaporan * 0.001) . "," . (117.1 + $totalLaporan * 0.001),
                        'latitude' => -0.5 + $totalLaporan * 0.001,
                        'longitude' => 117.1 + $totalLaporan * 0.001,
                        'foto_kerusakan' => json_encode($fotoFilenames),
                        'kecamatan_id' => $lokasi['kecamatan_id'],
                        'kelurahan_id' => $lokasi['kelurahan_id'],
                        'jenis_kerusakan' => $jenisKerusakan,
                        'tingkat_kerusakan' => $tingkatKerusakan,
                        'feedback' => "Feedback untuk laporan no {$totalLaporan} dari pelapor {$pelapor->nama_lengkap}. Sudah diperiksa petugas.",
                        'rating_kepuasan' => rand(1, 5),
                        'status_id' => 1,
                    ]);
                }
            }
        }
    }
}