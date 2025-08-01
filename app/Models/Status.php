<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = 'status';
    public $timestamps = false;

     protected $primaryKey = 'status_id';
    protected $fillable = ['nama_status'];

    public function laporan()
    {
        return $this->hasMany(Laporan::class);
    }
}