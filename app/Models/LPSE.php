<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LPSE extends Model
{
    protected $table = 'lpse';

    protected $fillable = [
        'kode_paket',
        'nama_paket',
        'jenis_paket',
        'url_informasi_paket',
        'nilai',
    ];
}