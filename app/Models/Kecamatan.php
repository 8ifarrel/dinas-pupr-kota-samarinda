<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'nama'];
    public $timestamps = false; // Karena data dari CSV dan tidak diubah

    public function kelurahans()
    {
        return $this->hasMany(Kelurahan::class);
    }
}