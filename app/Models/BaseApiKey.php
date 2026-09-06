<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Kolom dan relasi bersama untuk setiap jenis kunci API (Jalan Peduli,
 * Hantu Banyu, dst). Tiap fitur punya tabelnya sendiri supaya kunci satu
 * fitur tidak bisa dipakai untuk mengautentikasi fitur lain.
 */
abstract class BaseApiKey extends Model
{
  use HasFactory;

  protected $fillable = [
    'key',
    'name',
    'is_active',
    'generated_by_user_id',
  ];

  public function generator()
  {
    return $this->belongsTo(User::class, 'generated_by_user_id');
  }
}
