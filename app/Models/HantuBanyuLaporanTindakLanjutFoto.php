<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HantuBanyuLaporanTindakLanjutFoto extends Model
{
  use SoftDeletes;

  protected $table = 'hantu_banyu_laporan_tindak_lanjut_foto';

  protected $fillable = [
    'tindak_lanjut_id',
    'foto',
  ];

  public function tindakLanjut()
  {
    return $this->belongsTo(HantuBanyuLaporanTindakLanjut::class, 'tindak_lanjut_id');
  }
}
