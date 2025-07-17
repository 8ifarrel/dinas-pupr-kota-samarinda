<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    public $timestamps = false;
    protected $table = 'visitors';
    protected $fillable = [
        'visitor_id',
        'ip_address',
        'user_agent',
        'first_visit_at',
    ];
    protected $dates = [
        'first_visit_at',
    ];
}
