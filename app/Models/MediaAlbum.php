<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaAlbum extends Model {
    use HasFactory;

    protected $table = 'media_album';

    protected $fillable = [
        'judul',
        'slug',
        'views_count',
    ];

    public function galeri() {
        return $this->hasMany(MediaGaleri::class, 'id_media_album');
    }
}