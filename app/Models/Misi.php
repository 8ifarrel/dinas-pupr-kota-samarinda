<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Misi extends Model
{
    use HasFactory;

    protected $table = 'misi';

    protected $primaryKey = 'id_misi';

    protected $fillable = [
        'nomor_urut',
        'deskripsi_misi',
        'periode_mulai',
        'periode_selesai',
    ];
}

