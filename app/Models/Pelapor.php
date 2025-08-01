<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelapor extends Model
{
    use HasFactory;

    // Pastikan 'alamat_pelapor' ada di sini
    protected $fillable = ['nama_lengkap', 'nomor_ponsel', 'email', 'kecamatan_id', 'kelurahan_id', 'alamat_pelapor', 'rt', 'rw'];

    public function laporan()
    {
        return $this->hasMany(Laporan::class);
    }
    public function kecamatan() // Relasi untuk kecamatan pelapor
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id'); // Sesuaikan foreign key
    }

    public function kelurahan() // Relasi untuk kelurahan pelapor
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id'); // Sesuaikan foreign key
    }

    // public function ipLogs()
    // {
    //     return $this->hasMany(IpLog::class);
    // }
    // app/Models/Laporan.php
    public function pelapor()
    {
        return $this->belongsTo(Pelapor::class, 'nomor_ponsel', 'nomor_ponsel');
    }

}