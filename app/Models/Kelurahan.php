<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'nama', 'kecamatan_id'];
    public $timestamps = false; // Karena data dari CSV dan tidak diubah

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}