<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FotoKegiatan extends Model
{
    use HasFactory;

    protected $table = 'foto_kegiatan';
    
    protected $fillable = [
        'foto',
        'caption',
        'id_album_kegiatan',
    ];

    public function albumKegiatan()
    {
        return $this->belongsTo(AlbumKegiatan::class, 'id_album_kegiatan');
    }
}
