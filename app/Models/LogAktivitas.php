<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Satu baris jejak audit. Bersifat catatan sejarah: hanya ditulis sekali oleh
 * LogAktivitasObserver, lalu tidak pernah diubah - karena itu updated_at tidak
 * dipakai dan model ini sendiri dikecualikan dari pengamatan observer.
 */
class LogAktivitas extends Model
{
  protected $table = 'log_aktivitas';

  public const UPDATED_AT = null;

  protected $fillable = [
    'pelaku_tipe',
    'pelaku_id',
    'pelaku_nama',
    'pelaku_username',
    'aksi',
    'model',
    'model_label',
    'record_id',
    'record_label',
    'perubahan',
    'ip_address',
    'metode',
    'url',
    'user_agent',
  ];

  protected $casts = [
    'perubahan' => 'array',
    'created_at' => 'datetime',
  ];

  public const AKSI = [
    'tambah' => 'Tambah',
    'ubah' => 'Ubah',
    'hapus' => 'Hapus',
    'pulihkan' => 'Pulihkan',
  ];

  public const PELAKU_TIPE = [
    'super_admin' => 'Super Admin',
    'admin' => 'Admin',
    'kelurahan' => 'Akun Kelurahan',
    'publik' => 'Pengunjung Publik',
    'sistem' => 'Sistem',
  ];

  public function labelAksi(): string
  {
    return self::AKSI[$this->aksi] ?? $this->aksi;
  }

  public function labelPelakuTipe(): string
  {
    return self::PELAKU_TIPE[$this->pelaku_tipe] ?? $this->pelaku_tipe;
  }

  /** Nama pelaku siap tampil, termasuk saat aksi datang dari publik atau sistem. */
  public function namaPelakuTampil(): string
  {
    if ($this->pelaku_nama) {
      return $this->pelaku_nama;
    }

    return $this->labelPelakuTipe();
  }

  /** Warna lencana aksi, mengikuti palet yang dipakai halaman admin lain. */
  public function warnaAksi(): string
  {
    return match ($this->aksi) {
      'tambah' => 'bg-green-100 text-green-800',
      'ubah' => 'bg-blue-100 text-blue-800',
      'hapus' => 'bg-red-100 text-red-800',
      'pulihkan' => 'bg-yellow-100 text-yellow-800',
      default => 'bg-gray-100 text-gray-800',
    };
  }

  public function jumlahPerubahan(): int
  {
    return is_array($this->perubahan) ? count($this->perubahan) : 0;
  }
}
