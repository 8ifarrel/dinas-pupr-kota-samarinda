<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'slider';
    protected $primaryKey = 'id_slider';

    protected $fillable = [
        'foto_slider',
        'nomor_urut_slider',
        'judul_slider',
        'is_visible'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];
}
