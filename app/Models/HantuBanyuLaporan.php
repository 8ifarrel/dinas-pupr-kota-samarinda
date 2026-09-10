<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class HantuBanyuLaporan extends Model
{
  use SoftDeletes;

  /** Label pendek untuk laporan yang dibuat admin UPTD, dipakai di tabel & filter. */
  public const LABEL_ADMIN = 'Admin UPTD PSDI';

  protected $table = 'hantu_banyu_laporan';

  /** `kode` (HB-YYYY-NNNN), bukan `id`, yang dipakai pada URL & route-model-binding. */
  public function getRouteKeyName(): string
  {
    return 'kode';
  }

  /** Beri nomor laporan otomatis saat dibuat, kalau belum diisi pemanggil. */
  protected static function booted(): void
  {
    static::creating(function (self $laporan): void {
      if (blank($laporan->kode)) {
        $laporan->kode = self::kodeBerikutnya($laporan->created_at ?: now());
      }
    });
  }

  /**
   * Nomor laporan berikutnya untuk tahun pada $waktu, format HB-YYYY-NNNN.
   * Urutan reset tiap tahun. Baris penghitung dikunci selama transaksi
   * supaya tidak ada dua laporan yang mendapat nomor sama; index unik pada
   * kolom `kode` menjadi penjaga terakhir bila tetap terjadi.
   */
  public static function kodeBerikutnya($waktu): string
  {
    $tahun = (int) Carbon::parse($waktu)->year;

    return DB::transaction(function () use ($tahun) {
      $terakhir = (int) (DB::table('hantu_banyu_laporan_counter')
        ->where('tahun', $tahun)
        ->lockForUpdate()
        ->value('terakhir') ?? 0);

      $berikut = $terakhir + 1;

      DB::table('hantu_banyu_laporan_counter')->updateOrInsert(
        ['tahun' => $tahun],
        ['terakhir' => $berikut]
      );

      return sprintf('HB-%d-%04d', $tahun, $berikut);
    });
  }

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
