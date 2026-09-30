<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HantuBanyuPemeriksaanBerkala extends Model
{
  use SoftDeletes;

  protected $table = 'hantu_banyu_pemeriksaan_berkala';

  protected $fillable = [
    'tanggal_pemeriksaan',
    'kecamatan_id',
    'kelurahan_id',
    'nama_jalan',
    'nama_ruas_saluran',
    'dimensi_lebar_m',
    'dimensi_tinggi_m',
    'kondisi_fisik_struktur',
    'tingkat_sedimentasi_sampah_cm',
    'status_aliran_air',
    'tindakan_pemeliharaan',
    'hambatan_kendala',
    'rekomendasi_tindak_lanjut',
  ];

  protected $casts = [
    'tanggal_pemeriksaan' => 'date',
  ];

  /** Ambang baku kategori sedimentasi, dari persentase terhadap tinggi eksisting saluran. */
  public const KATEGORI_SEDIMENTASI_LABEL = [
    'normal' => 'Normal',
    'sedang' => 'Sedang',
    'tinggi' => 'Tinggi',
  ];

  /**
   * Persentase sedimentasi & sampah terhadap dimensi tinggi eksisting saluran
   * (tingkat_sedimentasi_sampah_cm / (dimensi_tinggi_m * 100) * 100).
   * Null bila salah satu datanya belum diisi - tidak bisa dihitung.
   */
  public function getPersenSedimentasiAttribute(): ?float
  {
    if ($this->tingkat_sedimentasi_sampah_cm === null || !$this->dimensi_tinggi_m) {
      return null;
    }

    $tinggiCm = (float) $this->dimensi_tinggi_m * 100;

    return round(((float) $this->tingkat_sedimentasi_sampah_cm / $tinggiCm) * 100, 1);
  }

  /**
   * Kategori sedimentasi (normal/sedang/tinggi) menurut persentase di atas:
   * 0-15% Normal, 16-30% Sedang, 31% ke atas Tinggi. Null bila persentasenya
   * belum bisa dihitung.
   */
  public function getKategoriSedimentasiAttribute(): ?string
  {
    $persen = $this->persen_sedimentasi;

    if ($persen === null) {
      return null;
    }

    return match (true) {
      $persen <= 15 => 'normal',
      $persen <= 30 => 'sedang',
      default => 'tinggi',
    };
  }

  public function kecamatan()
  {
    return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
  }

  public function kelurahan()
  {
    return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
  }
}
