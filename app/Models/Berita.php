<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BeritaKategori;

class Berita extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'uuid_berita';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'judul_berita', 
        'slug_berita', 
        'id_berita_kategori', 
        'foto_berita',
        'sumber_foto_berita', 
        'isi_berita', 
        'preview_berita',
        'views_count',
        'created_at',
    ];

    public function kategori()
    {
        return $this->belongsTo(BeritaKategori::class, 'id_berita_kategori');
    }
}
