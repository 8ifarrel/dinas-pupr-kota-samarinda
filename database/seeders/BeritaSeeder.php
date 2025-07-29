<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        DB::table('berita')->insert([
            [
                'uuid_berita' => (string) Str::uuid(),
                'judul_berita' => 'Berita Pertama',
                'slug_berita' => 'berita-pertama',
                'id_berita_kategori' => 14,
                'foto_berita' => 'berita1.jpg',
                'sumber_foto_berita' => 'Dinas PUPR',
                'isi_berita' => 'Isi berita pertama.',
                'preview_berita' => 'Preview berita pertama.',
                'views_count' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid_berita' => (string) Str::uuid(),
                'judul_berita' => 'Berita Kedua',
                'slug_berita' => 'berita-kedua',
                'id_berita_kategori' => 17,
                'foto_berita' => 'berita2.jpg',
                'sumber_foto_berita' => 'Dinas PUPR',
                'isi_berita' => 'Isi berita kedua.',
                'preview_berita' => 'Preview berita kedua.',
                'views_count' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
