<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{
    protected $table = 'struktur_organisasi';
    protected $primaryKey = 'id_struktur_organisasi';
    public $incrementing = true;

    protected $fillable = [
        'id_jabatan',
        'ikon_jabatan',
        'nomor_urut_jabatan',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }

    public function slider()
    {
        return $this->hasMany(StrukturOrganisasiSlider::class, 'id_struktur_organisasi', 'id_struktur_organisasi');
    }
}
