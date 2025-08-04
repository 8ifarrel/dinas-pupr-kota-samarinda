<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    use HasFactory;

    protected $table = 'api_keys';

    protected $fillable = [
        'key',
        'name',
        'is_active',
        'generated_by_user_id',
    ];

    // Jika Anda memiliki model User yang relevan, Anda bisa definisikan relasinya
    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by_user_id');
    }
}
