<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kecamatan;
use App\Models\JalanPeduliPelapor;
use App\Models\JalanPeduliLaporan;

class Kelurahan extends Model
{
    protected $table = 'kelurahan';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'nama',
        'kecamatan_id',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }
}