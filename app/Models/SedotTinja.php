<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SedotTinja extends Model
{
    use HasFactory;

    protected $table = 'sedot_tinja';

    protected $fillable = [
        'kode_booking',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // ambil tahun sekarang
            $tahun = date('Y');

            // ambil nomor urut terakhir
            $last = static::whereYear('created_at', $tahun)->orderBy('id', 'desc')->first();

            $nextNumber = $last ? ((int) substr($last->kode_booking, -3)) + 1 : 1;

            $model->kode_booking = 'STJ-' . $tahun . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        });
    }
}
