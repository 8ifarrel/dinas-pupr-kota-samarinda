<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_laporan';
    public $incrementing = false;     // Karena bukan auto increment
    protected $keyType = 'string'; 
    protected $fillable = [
        'id_laporan',
        'nomor_ponsel',
        'alamat_lengkap_kerusakan',
        'deskripsi_laporan',
        'link_koordinat', 
        'latitude',
        'longitude',
        'foto_kerusakan', 
        'kecamatan_id', 
        'kelurahan_id',
        'jenis_kerusakan',
        'tingkat_kerusakan',  
        'dokumen_pendukung',
        'feedback',
        'rating_kepuasan',
        'keterangan',
        'status_id'
    ];
    public function pelapor()
    {
        return $this->belongsTo(Pelapor::class, 'nomor_ponsel', 'nomor_ponsel');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'status_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id', 'id');
    }
    // Di app/Models/Laporan.php
    // public function ipLogs()
    // {
    //     return $this->hasMany(IpLog::class, 'laporan_id', 'id_laporan');
    // }
}