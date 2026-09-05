<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DrainaseIrigasiLaporanTindakLanjutFoto extends Model
{
    use SoftDeletes;

    protected $table = 'drainase_irigasi_laporan_tindak_lanjut_foto';

    protected $fillable = [
        'tindak_lanjut_id',
        'foto',
    ];

    public function tindakLanjut()
    {
        return $this->belongsTo(DrainaseIrigasiLaporanTindakLanjut::class, 'tindak_lanjut_id');
    }
}
