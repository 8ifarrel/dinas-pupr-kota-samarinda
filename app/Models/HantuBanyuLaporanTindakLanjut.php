<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HantuBanyuLaporanTindakLanjut extends Model
{
  use SoftDeletes;

  protected $table = 'hantu_banyu_laporan_tindak_lanjut';

  protected $fillable = [
    'laporan_id',
    'status',
    'deskripsi',
    'jenis',
  ];

  public function laporan()
  {
    return $this->belongsTo(HantuBanyuLaporan::class, 'laporan_id');
  }

  public function foto()
  {
    return $this->hasMany(HantuBanyuLaporanTindakLanjutFoto::class, 'tindak_lanjut_id');
  }
}
