<?php

namespace App\Support\Shared;

use App\Models\User;

/**
 * Label ringkas akun admin untuk ditampilkan di dropdown navbar: baris
 * "singkatan" (singkatan unit organisasi, atau "Super Admin") dan baris
 * "kategori" (peran ringkas: "Admin" atau "Super Admin").
 */
class LabelAdminNavbar
{
  /** @return array{singkatan: string, kategori: string} */
  public static function untuk(User $admin): array
  {
    if ($admin->is_super_admin) {
      return ['singkatan' => 'Super Admin', 'kategori' => 'Super Admin'];
    }

    $unit = $admin->susunanOrganisasi;
    $singkatan = $unit?->singkatan_susunan_organisasi
      ?? $unit?->nama_susunan_organisasi
      ?? $admin->fullname;

    return ['singkatan' => $singkatan, 'kategori' => 'Admin'];
  }
}
