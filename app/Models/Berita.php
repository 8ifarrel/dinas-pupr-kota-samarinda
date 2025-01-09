<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\BeritaKategori;

class Berita extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'uuid_berita';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid_berita',
        'judul_berita', 
        'slug_berita', 
        'id_berita_kategori', 
        'foto_berita',
        'sumber_foto_berita', 
        'isi_berita', 
        'preview_berita',
        'views_count',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    public function kategori()
    {
        return $this->belongsTo(BeritaKategori::class, 'id_berita_kategori');
    }
}
