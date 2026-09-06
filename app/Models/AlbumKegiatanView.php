<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumKegiatanView extends Model
{
  protected $table = 'album_kegiatan_views';

  /** Baris ini tidak pernah diubah setelah dibuat, jadi updated_at tidak berguna. */
  public $timestamps = false;

  protected $fillable = [
    'visitor_id',
    'id_album_kegiatan',
    'viewed_at',
  ];

  public function albumKegiatan()
  {
    return $this->belongsTo(AlbumKegiatan::class, 'id_album_kegiatan', 'id');
  }
}
