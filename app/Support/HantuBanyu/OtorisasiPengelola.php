<?php

namespace App\Support\HantuBanyu;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Menentukan bolehkah akun yang sedang login MENGELOLA Hantu Banyu - yaitu
 * membuat laporan dan memperbarui tindak lanjutnya.
 *
 * Melihat isi Hantu Banyu terbuka untuk seluruh admin - itu memang informasi
 * lintas unit. Yang dibatasi di sini hanya hak mengubahnya:
 *  - akun kelurahan: boleh, tapi tetap terkunci di wilayahnya sendiri
 *  - super admin: boleh (memang berwenang atas segalanya)
 *  - admin lain: hanya yang bernaung di unit pemilik layanan ini
 *
 * Buat satu instance per request (mis. disimpan di properti controller/
 * middleware) supaya query unit pemilik dicache dan tidak dijalankan dua
 * kali dalam siklus yang sama.
 */
class OtorisasiPengelola
{
  private ?int $pemilikCache = null;
  private bool $pemilikSudahDicari = false;

  public function bolehKelola(): bool
  {
    if (Auth::guard('kelurahan')->check()) {
      return true;
    }

    $user = Auth::guard('web')->user();

    if (!$user instanceof User) {
      return false;
    }

    if ($user->is_super_admin) {
      return true;
    }

    $pemilik = $this->susunanOrganisasiPemilik();

    return $pemilik !== null && (int) $user->id_susunan_organisasi === $pemilik;
  }

  /**
   * Unit organisasi pemilik layanan Hantu Banyu, ditelusuri dari data:
   * layanan 'hantu_banyu' -> struktur_organisasi -> susunan_organisasi.
   *
   * Sengaja tidak ditulis sebagai angka tetap supaya kalau kepemilikan
   * layanan dipindahkan lewat data, hak aksesnya ikut berpindah sendiri.
   *
   * Mengembalikan null bila rantai datanya putus. Dalam keadaan itu hak
   * kelola ditutup untuk semua admin biasa (super admin tetap bisa) -
   * lebih baik menutup akses daripada membukanya karena data hilang.
   */
  public function susunanOrganisasiPemilik(): ?int
  {
    if ($this->pemilikSudahDicari) {
      return $this->pemilikCache;
    }

    $id = DB::table('layanan')
      ->join('struktur_organisasi', 'struktur_organisasi.id_struktur_organisasi', '=', 'layanan.struktur_organisasi_id')
      ->where('layanan.nama', 'hantu_banyu')
      ->value('struktur_organisasi.id_susunan_organisasi');

    if ($id === null) {
      Log::warning('HantuBanyu: unit pemilik layanan tidak ditemukan, hak kelola ditutup untuk admin non-super.');
    }

    $this->pemilikSudahDicari = true;

    return $this->pemilikCache = ($id === null ? null : (int) $id);
  }

  /** Nama unit pemilik layanan, untuk ditampilkan di pesan penolakan. */
  public function namaUnitPemilik(): string
  {
    $id = $this->susunanOrganisasiPemilik();

    if ($id === null) {
      return 'unit pengelola layanan ini';
    }

    return DB::table('susunan_organisasi')
      ->where('id_susunan_organisasi', $id)
      ->value('nama_susunan_organisasi') ?? 'unit pengelola layanan ini';
  }
}
