<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPIDPelaksanaKategori extends Model
{
    use HasFactory;

    protected $table = 'ppid_pelaksana_kategori';

    protected $fillable = [
        'nama',
        'slug',
    ];

    public function ppid_pelaksana()
    {
        return $this->hasMany(PPIDPelaksana::class, 'id_kategori');
    }
}

