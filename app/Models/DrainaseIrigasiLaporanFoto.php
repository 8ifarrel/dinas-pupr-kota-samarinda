<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DrainaseIrigasiLaporanFoto extends Model
{
    use SoftDeletes;

    protected $table = 'drainasei_irigasi_laporan_foto';

    protected $fillable = [
        'laporan_id',
        'foto',
    ];

    public function laporan()
    {
        return $this->belongsTo(DrainaseIrigasiLaporan::class, 'laporan_id');
    }
}
