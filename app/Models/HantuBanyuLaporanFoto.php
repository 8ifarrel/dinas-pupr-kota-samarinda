<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HantuBanyuLaporanFoto extends Model
{
  use SoftDeletes;

  protected $table = 'hantu_banyu_laporan_foto';

  protected $fillable = [
    'laporan_id',
    'foto',
  ];

  public function laporan()
  {
    return $this->belongsTo(HantuBanyuLaporan::class, 'laporan_id');
  }
}
