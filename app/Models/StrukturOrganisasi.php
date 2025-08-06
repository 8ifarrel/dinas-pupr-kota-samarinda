<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SusunanOrganisasi;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StrukturOrganisasi extends Model
{
    protected $table = 'struktur_organisasi';
    protected $primaryKey = 'id_struktur_organisasi';
    public $incrementing = true;

    protected $fillable = [
        'id_susunan_organisasi',
        'ikon_jabatan',
        'nomor_urut_jabatan',
    ];

    public function susunanOrganisasi()
    {
        return $this->belongsTo(SusunanOrganisasi::class, 'id_susunan_organisasi', 'id_susunan_organisasi');
    }

    public function slider()
    {
        return $this->hasMany(StrukturOrganisasiSlider::class, 'id_struktur_organisasi', 'id_struktur_organisasi');
    }

    public function strukturOrganisasiDiagram()
    {
        return $this->hasOne(StrukturOrganisasiDiagram::class, 'id_struktur_organisasi', 'id_struktur_organisasi');
    }

    public function layanan(): HasMany
    {
        return $this->hasMany(Layanan::class, 'struktur_organisasi_id', 'id_struktur_organisasi');
    }
}

