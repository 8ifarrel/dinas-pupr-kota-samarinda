<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SusunanOrganisasi;

class BeritaKategori extends Model
{
    protected $table = 'berita_kategori';
    protected $primaryKey = 'id_berita_kategori';
    protected $fillable = [
        'id_susunan_organisasi',
        'ikon_berita_kategori',
    ];

    public function susunanOrganisasi()
    {
        return $this->belongsTo(SusunanOrganisasi::class, 'id_susunan_organisasi', 'id_susunan_organisasi');
    }
}
