<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepalaDinasJenjangKarir extends Model
{
    use HasFactory;

    protected $table = 'kepala_dinas_jenjang_karir';

    protected $primaryKey = 'id_karir';

    protected $fillable = [
        'nama_karir',
        'tanggal_masuk',
        'id_kepala_dinas',
    ];

    public function kepalaDinas()
    {
        return $this->belongsTo(KepalaDinas::class, 'id_kepala_dinas', 'id');
    }
}
