<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tupoksi extends Model
{
    protected $table = 'tupoksi';
    protected $fillable = [
        'tugas', 'pokok', 'fungsi',
    ];
}
