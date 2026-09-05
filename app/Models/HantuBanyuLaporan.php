<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HantuBanyuLaporan extends Model
{
  use SoftDeletes;

  protected $table = 'hantu_banyu_laporan';

  protected $fillable = [
    'pelapor_id',
    'nama_jalan',
    'detail_lokasi',
    'kecamatan_id',
    'kelurahan_id',
    'longitude',
    'latitude',
    'deskripsi_pengaduan',
  ];

  public function pelapor()
  {
    return $this->belongsTo(HantuBanyuPelapor::class, 'pelapor_id');
  }

  public function kecamatan()
  {
    return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
  }

  public function kelurahan()
  {
    return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
  }

  public function tindakLanjut()
  {
    return $this->hasMany(HantuBanyuLaporanTindakLanjut::class, 'laporan_id');
  }

  public function foto()
  {
    return $this->hasMany(HantuBanyuLaporanFoto::class, 'laporan_id');
  }
}
