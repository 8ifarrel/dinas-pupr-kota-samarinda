<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumKegiatan extends Model {
    use HasFactory;

    protected $table = 'album_kegiatan';

    protected $fillable = [
        'judul',
        'slug',
        'views_count',
    ];

    public function fotoKegiatan() {
        return $this->hasMany(FotoKegiatan::class, 'id_album_kegiatan');
    }
}
