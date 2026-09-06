<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan extends Model
{
  /**
   * Id layanan untuk survei umum, yaitu survei kepuasan yang tidak terikat
   * fitur tertentu (diisi lewat halaman /skm). Layanan lain seperti Hantu Banyu
   * memakai idnya masing-masing sehingga rekapnya bisa dipisah.
   */
  public const ID_UMUM = 0;

  protected $table = 'layanan';

  protected $fillable = [
    'nama',
    'struktur_organisasi_id',
  ];

  public function strukturOrganisasi(): BelongsTo
  {
    return $this->belongsTo(StrukturOrganisasi::class, 'struktur_organisasi_id', 'id_struktur_organisasi');
  }

  public function skm(): HasMany
  {
    return $this->hasMany(SKM::class, 'layanan_id');
  }
}
