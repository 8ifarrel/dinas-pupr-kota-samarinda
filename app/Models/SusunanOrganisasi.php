<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SusunanOrganisasi extends Model
{
    protected $table = 'susunan_organisasi';
    protected $primaryKey = 'id_susunan_organisasi';
    public $incrementing = true;

    protected $fillable = [
        'nama_susunan_organisasi',
        'id_susunan_organisasi_parent',
        'slug_susunan_organisasi',
        'tupoksi_susunan_organisasi',
        'deskripsi_susunan_organisasi',
        'kelompok_susunan_organisasi',
        'is_subbagian',
        'is_susunan_organisasi_fungsional',
    ];

    public function parent()
    {
        return $this->belongsTo(SusunanOrganisasi::class, 'id_susunan_organisasi_parent');
    }

    public function children()
    {
        return $this->hasMany(SusunanOrganisasi::class, 'id_susunan_organisasi_parent');
    }

    public function strukturOrganisasi()
    {
        return $this->hasOne(StrukturOrganisasi::class, 'id_susunan_organisasi', 'id_susunan_organisasi');
    }

    public function beritaKategori()
    {
        return $this->hasMany(BeritaKategori::class, 'id_susunan_organisasi', 'id_susunan_organisasi');
    }
}
