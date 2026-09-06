<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengumumanView extends Model
{
  protected $table = 'pengumuman_views';

  /** Baris ini tidak pernah diubah setelah dibuat, jadi updated_at tidak berguna. */
  public $timestamps = false;

  protected $fillable = [
    'visitor_id',
    'id_pengumuman',
    'viewed_at',
  ];

  public function pengumuman()
  {
    return $this->belongsTo(Pengumuman::class, 'id_pengumuman', 'id');
  }
}
