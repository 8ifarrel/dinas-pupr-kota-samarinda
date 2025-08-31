<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JalanPeduliPelapor;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\JalanPeduliStatus;

class JalanPeduliLaporan extends Model
{
    protected $table = 'jalan_peduli_laporan';

    protected $primaryKey = 'id_laporan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_laporan',
        'nomor_ponsel',
        'alamat_lengkap_kerusakan',
        'deskripsi_laporan',
        'link_koordinat',
        'latitude',
        'longitude',
        'foto_kerusakan',
        'kecamatan_id',
        'kelurahan_id',
        'kota',
        'feedback',
        'rating_kepuasan',
        'keterangan',
        'foto_lanjutan',
        'dokumen_pendukung',
        'dokumen_petugas',
        'status_id',
        'jenis_kerusakan',
        'tingkat_kerusakan',
    ];

    public function pelapor()
    {
        return $this->belongsTo(JalanPeduliPelapor::class, 'nomor_ponsel', 'nomor_ponsel');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }

    public function status()
    {
        return $this->belongsTo(JalanPeduliStatus::class, 'status_id', 'status_id');
    }

    public function ipLogs()
    {
        return $this->hasMany(JalanPeduliIPLog::class, 'laporan_id', 'id_laporan');
    }
}
