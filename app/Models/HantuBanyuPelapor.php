<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\HantuBanyuLaporan;
use App\Models\Kelurahan;

class HantuBanyuPelapor extends Model
{
  use SoftDeletes;

  protected $table = 'hantu_banyu_pelapor';

  protected $fillable = [
    'nama_lengkap',
    'kelurahan_asal_id',
    'alamat',
    'nomor_telepon',
  ];

  public function laporan(): HasOne
  {
    return $this->hasOne(HantuBanyuLaporan::class, 'pelapor_id');
  }

  public function kelurahanAsal(): BelongsTo
  {
    return $this->belongsTo(Kelurahan::class, 'kelurahan_asal_id');
  }
}
