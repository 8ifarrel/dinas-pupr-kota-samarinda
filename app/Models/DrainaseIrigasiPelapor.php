<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DrainaseIrigasiPelapor extends Model
{
    use SoftDeletes;

    protected $table = 'drainase_irigasi_pelapor';

    protected $fillable = [
        'nama_lengkap',
        'pekerjaan',
        'alamat',
        'nomor_telepon',
    ];

    public function laporan()
    {
        return $this->hasOne(DrainaseIrigasiLaporan::class, 'pelapor_id');
    }
}
