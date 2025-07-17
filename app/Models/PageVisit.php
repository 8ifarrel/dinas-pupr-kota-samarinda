<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    public $timestamps = false;
    protected $table = 'page_visits';
    protected $fillable = [
        'visitor_id',
        'visited_page_context',
        'visited_at',
    ];
    protected $dates = [
        'visited_at',
    ];
}
