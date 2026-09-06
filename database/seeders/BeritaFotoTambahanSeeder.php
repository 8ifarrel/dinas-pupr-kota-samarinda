<?php

namespace Database\Seeders;

use Database\Seeders\Support\DummyMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Foto pendukung di dalam isi berita. Hanya sebagian berita yang diberi foto
 * tambahan supaya kondisi "berita tanpa foto tambahan" ikut teruji.
 */
class BeritaFotoTambahanSeeder extends Seeder
{
  private const FOTO_PER_BERITA = 2;

  public function run(): void
  {
    $berita = DB::table('berita')
      ->orderBy('created_at', 'desc')
      ->get(['uuid_berita', 'judul_berita', 'created_at']);

    $baris = [];
    $id = 1;

    foreach ($berita as $index => $b) {
      // Ambil tiap berita kedua saja.
      if ($index % 2 !== 0) {
        continue;
      }

      $terbit = Carbon::parse($b->created_at);

      for ($i = 1; $i <= self::FOTO_PER_BERITA; $i++) {
        $namaBerkas = Str::uuid() . '.png';
        $folder = 'Berita/' . $terbit->format('Y-m') . '/' . $terbit->format('d') . '/foto_tambahan/';

        $baris[] = [
          'id_berita_foto_tambahan' => $id++,
          'uuid_berita' => $b->uuid_berita,
          'foto_path' => DummyMedia::gambar(
            $folder . $namaBerkas,
            1280,
            720,
            'FOTO TAMBAHAN ' . $i,
            'berita'
          ),
          'caption' => 'Dokumentasi kegiatan (' . $i . ') - ' . Str::limit($b->judul_berita, 60),
          'created_at' => $terbit,
          'updated_at' => $terbit,
        ];
      }
    }

    DB::table('berita_foto_tambahan')->insert($baris);
  }
}
