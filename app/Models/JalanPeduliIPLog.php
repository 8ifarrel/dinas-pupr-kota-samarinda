<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JalanPeduliPelapor;
use App\Models\JalanPeduliLaporan;

class JalanPeduliIPLog extends Model
{
    protected $table = 'jalan_peduli_ip_log';

    protected $fillable = [
        'pelapor_id',
        'laporan_id',
        'ip_address',
        'latitude',
        'longitude',
        'kota',
        'provinsi',
    ];

    public function pelapor()
    {
        return $this->belongsTo(JalanPeduliPelapor::class, 'pelapor_id');
    }

    public function laporan()
    {
        return $this->belongsTo(JalanPeduliLaporan::class, 'laporan_id', 'id_laporan');
    }
}
