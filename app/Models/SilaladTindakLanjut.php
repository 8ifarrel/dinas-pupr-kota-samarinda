<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Satu baris riwayat perubahan status pesanan SILALAD. Tidak pernah ditimpa -
 * tiap perubahan status menambah baris baru (lihat migrasi tabelnya).
 */
class SilaladTindakLanjut extends Model
{
  use SoftDeletes;

  protected $table = 'silalad_tindak_lanjut';

  protected $fillable = [
    'silalad_id',
    'status',
    'keterangan',
  ];

  public function pesanan()
  {
    return $this->belongsTo(Silalad::class, 'silalad_id');
  }
}
