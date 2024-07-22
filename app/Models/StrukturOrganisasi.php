<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{
    protected $table = 'struktur_organisasi';
    protected $primaryKey = 'id_jabatan';
    public $incrementing = false;

    protected $fillable = [
        'id_jabatan',
        'ikon_jabatan',
        'nomor_urut_jabatan',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }
}
