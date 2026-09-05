<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan extends Model
{
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
