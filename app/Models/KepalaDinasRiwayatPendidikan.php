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
        'id_pegawai',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
}
