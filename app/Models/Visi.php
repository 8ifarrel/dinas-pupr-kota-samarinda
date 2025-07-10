<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visi extends Model
{
    use HasFactory;

    protected $table = 'visi';

    protected $primaryKey = 'id_visi';

    protected $fillable = [
        'deskripsi_visi',
        'periode_mulai',
        'periode_selesai',
    ];
}

