<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BeritaKategori;
use App\Models\Pegawai;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan';
    protected $primaryKey = 'id_jabatan';

    protected $fillable = [
        'nama_jabatan',
        'id_jabatan_parent',
        'slug_nama_jabatan',
        'tupoksi_jabatan',
        'deskripsi_jabatan',
        'kelompok_jabatan',
        'is_punya_berita',
    ];

    public function parent()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan_parent');
    }
    
    public function children()
    {
        return $this->hasMany(Jabatan::class, 'id_jabatan_parent');
    }

    public function berita()
    {
    return $this->hasOne(BeritaKategori::class, 'id_jabatan');
    }

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id_jabatan');
    }

    public function jabatan()
    {
        return $this->hasMany(StrukturOrganisasi::class, 'id_jabatan', 'id_jabatan');
    }
}
