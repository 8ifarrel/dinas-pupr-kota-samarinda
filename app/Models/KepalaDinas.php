<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KepalaDinas extends Model
{
    protected $table = 'kepala_dinas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'foto',
        'id_susunan_organisasi',
        'tahun_mulai',
        'tahun_selesai',
    ];

    public function jenjangKarir()
    {
        return $this->hasMany(KepalaDinasJenjangKarir::class, 'id_kepala_dinas', 'id');
    }

    public function riwayatPendidikan()
    {
        return $this->hasMany(KepalaDinasRiwayatPendidikan::class, 'id_kepala_dinas', 'id');
    }

    public function susunanOrganisasi()
    {
        return $this->belongsTo(SusunanOrganisasi::class, 'id_susunan_organisasi', 'id_susunan_organisasi');
    }
}

