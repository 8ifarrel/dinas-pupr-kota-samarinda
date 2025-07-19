<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaFotoTambahan extends Model
{
    protected $table = 'berita_foto_tambahan';
    protected $primaryKey = 'id_berita_foto_tambahan';
    public $incrementing = true;

    protected $fillable = [
        'uuid_berita',
        'foto_path',
        'caption',
        'created_at',
        'updated_at',
    ];

    public function berita()
    {
        return $this->belongsTo(Berita::class, 'uuid_berita', 'uuid_berita');
    }
}
