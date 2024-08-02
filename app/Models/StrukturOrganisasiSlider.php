<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasiSlider extends Model
{
    use HasFactory;

    protected $table = 'struktur_organisasi_slider';

    protected $primaryKey = 'id_slider';

    protected $fillable = [
        'id_struktur_organisasi',
        'foto',
        'keterangan',
    ];

    public function struktur_organisasi()
    {
        return $this->belongsTo(StrukturOrganisasi::class, 'id_struktur_organisasi', 'id_struktur_organisasi');
    }
}
