<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SKM extends Model
{
    protected $table = 'skm';

    protected $fillable = [
        'nilai',
        'ip_address',
    ];
}

