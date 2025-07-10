<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FotoKegiatan extends Model
{
    use HasFactory;

    protected $table = 'foto_kegiatan';

    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'uuid',
        'foto',
        'caption',
        'id_album_kegiatan',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function albumKegiatan()
    {
        return $this->belongsTo(AlbumKegiatan::class, 'id_album_kegiatan');
    }
}
