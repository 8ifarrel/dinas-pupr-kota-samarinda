<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SKM extends Model
{
    protected $table = 'skm';

    protected $fillable = [
        'nilai',
        'ip_address',
        'kritik',
        'saran',
        'layanan_id',
    ];

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
}
