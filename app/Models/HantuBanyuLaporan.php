<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HantuBanyuLaporan extends Model
{
  use SoftDeletes;

  /** Label pendek untuk laporan yang dibuat admin UPTD, dipakai di tabel & filter. */
  public const LABEL_ADMIN = 'Admin UPTD PSDI';

  protected $table = 'hantu_banyu_laporan';

  protected $fillable = [
    'pelapor_id',
    'dibuat_oleh_tipe',
    'dibuat_oleh_user_id',
    'nama_jalan',
    'detail_lokasi',
    'kecamatan_id',
    'kelurahan_id',
    'longitude',
    'latitude',
    'deskripsi_pengaduan',
  ];

  /**
   * Nama pihak yang membuat laporan ini, mis. "Operator Kelurahan Air Putih"
   * atau "Admin UPTD PSDI". Butuh relasi kelurahan sudah dimuat.
   */
  public function getLabelPelaporAttribute(): string
  {
    if ($this->dibuat_oleh_tipe === 'admin') {
      return self::LABEL_ADMIN;
    }

    $namaKelurahan = optional($this->kelurahan)->nama;

    return $namaKelurahan
      ? 'Operator Kelurahan ' . $namaKelurahan
      : 'Operator Kelurahan';
  }

  public function pelapor()
  {
    return $this->belongsTo(HantuBanyuPelapor::class, 'pelapor_id');
  }

  /** Akun admin yang membuat laporan ini (kosong untuk laporan operator kelurahan). */
  public function dibuatOleh()
  {
    return $this->belongsTo(User::class, 'dibuat_oleh_user_id');
  }

  public function kecamatan()
  {
    return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
  }

  public function kelurahan()
  {
    return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
  }

  public function tindakLanjut()
  {
    return $this->hasMany(HantuBanyuLaporanTindakLanjut::class, 'laporan_id');
  }

  public function foto()
  {
    return $this->hasMany(HantuBanyuLaporanFoto::class, 'laporan_id');
  }
}
