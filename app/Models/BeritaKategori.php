<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Jabatan;

class BeritaKategori extends Model
{
    protected $table = 'berita_kategori';
    protected $primaryKey = 'id_berita_kategori';
    protected $fillable = [
        'id_jabatan',
        'ikon_berita_kategori',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }
}
