<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';

    protected $fillable = [
        'id_jabatan',
        'nama_pegawai',
        'foto_pegawai',
        'nomor_induk_pegawai',
        'nomor_telepon_pegawai',
        'golongan_pegawai',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }
    
    public function riwayat_pendidikan()
    {
        return $this->hasMany(KepalaDinasRiwayatPendidikan::class, 'id_pegawai', 'id_pegawai');
    }
}
