<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DrainaseIrigasiLaporan extends Model
{
    use SoftDeletes;

    protected $table = 'drainase_irigasi_laporan';

    protected $fillable = [
        'pelapor_id',
        'nama_jalan',
        'detail_lokasi',
        'kecamatan_id',
        'kelurahan_id',
        'longitude',
        'latitude',
        'deskripsi_pengaduan',
    ];

    public function pelapor()
    {
        return $this->belongsTo(DrainaseIrigasiPelapor::class, 'pelapor_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }

    public function tindakLanjut()
    {
        return $this->hasMany(DrainaseIrigasiLaporanTindakLanjut::class, 'laporan_id');
    }

    public function foto()
    {
        return $this->hasMany(DrainaseIrigasiLaporanFoto::class, 'laporan_id');
    }
}
