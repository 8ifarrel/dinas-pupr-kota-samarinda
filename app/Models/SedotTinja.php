<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SedotTinja extends Model
{
    use HasFactory;

    protected $table = 'sedot_tinja';

    protected $fillable = [
        'nama_pelanggan',
        'nomor_telepon_pelanggan',
        'alamat',
        'layanan',
        'detail_laporan',
        'kabkota_id',
        'kecamatan_id',
        'kelurahan_id',
        'latitude',
        'longitude',
        'jenis_bangunan',
        'alamat_detail',
        'nomor_bangunan',
        'rt',
        'rating',
        'saran_dan_masukan',
        'captcha',
        'status_pengerjaan',
        'setuju',
    ];
}
