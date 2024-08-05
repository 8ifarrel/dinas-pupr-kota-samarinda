<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MediaGaleri extends Model {
    use HasFactory;

    protected $table = 'media_galeri';

    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'uuid',
        'foto',
        'caption',
        'id_media_album',
    ];

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function album() {
        return $this->belongsTo(MediaAlbum::class, 'id_media_album');
    }
}