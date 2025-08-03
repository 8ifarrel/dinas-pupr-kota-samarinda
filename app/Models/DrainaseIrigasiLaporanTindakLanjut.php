<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DrainaseIrigasiLaporanTindakLanjut extends Model
{
    use SoftDeletes;

    protected $table = 'drainase_irigasi_laporan_tindak_lanjut';

    protected $fillable = [
        'laporan_id',
        'status',
        'deskripsi',
        'jenis',
    ];

    public function laporan()
    {
        return $this->belongsTo(DrainaseIrigasiLaporan::class, 'laporan_id');
    }

    public function foto()
    {
        return $this->hasMany(DrainaseIrigasiLaporanTindakLanjutFoto::class, 'tindak_lanjut_id');
    }
}
