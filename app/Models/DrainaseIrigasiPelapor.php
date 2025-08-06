<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\DrainaseIrigasiLaporan;
use App\Models\SKM;

class DrainaseIrigasiPelapor extends Model
{
    use SoftDeletes;

    protected $table = 'drainase_irigasi_pelapor';

    protected $fillable = [
        'nama_lengkap',
        'pekerjaan',
        'alamat',
        'nomor_telepon',
        'skm_id',
    ];

    public function laporan(): HasOne
    {
        return $this->hasOne(DrainaseIrigasiLaporan::class, 'pelapor_id');
    }

    public function skm(): BelongsTo
    {
        return $this->belongsTo(SKM::class, 'skm_id');
    }
}
