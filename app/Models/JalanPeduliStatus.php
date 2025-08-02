<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JalanPeduliStatus extends Model
{
    protected $table = 'jalan_peduli_status';

    protected $primaryKey = 'status_id';

    public $timestamps = false;

    protected $fillable = [
        'nama_status',
    ];
}
