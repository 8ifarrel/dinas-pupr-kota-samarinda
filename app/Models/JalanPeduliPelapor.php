<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kecamatan;
use App\Models\Kelurahan;

class JalanPeduliPelapor extends Model
{
    protected $table = 'jalan_peduli_pelapor';

    protected $fillable = [
        'nama_lengkap',
        'nomor_ponsel',
        'email',
        'kecamatan_id',
        'kelurahan_id',
        'rt',
        'rw',
        'alamat_pelapor',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }
}
