<?php

namespace Database\Seeders;

use Database\Seeders\Support\DummyMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Isi foto tiap album kegiatan.
 *
 * Nama berkas memakai id foto (sesuai controller: "{id}.{ext}"), sehingga
 * baris disisipkan dulu untuk mendapat id, baru berkasnya ditulis.
 */
class FotoKegiatanSeeder extends Seeder
{
  private const FOTO_PER_ALBUM = 4;

  public function run(): void
  {
    $album = DB::table('album_kegiatan')->orderBy('id')->get(['id', 'judul', 'slug', 'created_at']);

    foreach ($album as $a) {
      for ($i = 1; $i <= self::FOTO_PER_ALBUM; $i++) {
        $id = DB::table('foto_kegiatan')->insertGetId([
          'foto' => '',
          'caption' => 'Dokumentasi ' . Str::limit($a->judul, 60) . ' (' . $i . ')',
          'id_album_kegiatan' => $a->id,
          'created_at' => $a->created_at,
          'updated_at' => $a->created_at,
        ]);

        $path = DummyMedia::gambar(
          "album-kegiatan/{$a->slug}/{$id}.png",
          1280,
          853,
          strtoupper(Str::limit($a->judul, 34, '')) . " {$i}",
          'album'
        );

        DB::table('foto_kegiatan')->where('id', $id)->update(['foto' => $path]);
      }
    }
  }
}
