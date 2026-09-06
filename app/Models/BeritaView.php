<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaView extends Model
{
  protected $table = 'berita_views';

  /** Baris ini tidak pernah diubah setelah dibuat, jadi updated_at tidak berguna. */
  public $timestamps = false;

  protected $fillable = [
    'visitor_id',
    'uuid_berita',
    'viewed_at',
  ];

  public function berita()
  {
    return $this->belongsTo(Berita::class, 'uuid_berita', 'uuid_berita');
  }
}
