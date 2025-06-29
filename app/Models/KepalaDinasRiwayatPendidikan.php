<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepalaDinasRiwayatPendidikan extends Model
{
    use HasFactory;

    protected $table = 'kepala_dinas_riwayat_pendidikan';

    protected $primaryKey = 'id_pendidikan';

    protected $fillable = [
        'nama_pendidikan',
        'tanggal_masuk',
        'id_kepala_dinas',
    ];

    public function kepalaDinas()
    {
        return $this->belongsTo(KepalaDinas::class, 'id_kepala_dinas', 'id');
    }
}
