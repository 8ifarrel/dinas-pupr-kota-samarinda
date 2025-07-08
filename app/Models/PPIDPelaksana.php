<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPIDPelaksana extends Model
{
    use HasFactory;

    protected $table = 'ppid_pelaksana';

    protected $fillable = [
        'judul',
        'slug',
        'file',
        'id_kategori',
        'download_count',
    ];

    public function kategori()
    {
        return $this->belongsTo(PPIDPelaksanaKategori::class, 'id_kategori');
    }
}
