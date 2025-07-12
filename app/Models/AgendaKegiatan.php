<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgendaKegiatan extends Model
{
  use HasFactory;

  protected $table = 'agenda_kegiatan';

  protected $primaryKey = 'id';

  public $incrementing = true;

  protected $keyType = 'int';

  public $timestamps = true;

  protected $fillable = [
    'nama',
    'waktu_mulai',
    'tempat',
    'pelaksana',
    'dihadiri_oleh',
    'tanggal',
  ];

  protected $casts = [
    'waktu_mulai' => 'datetime:H:i:s',
    'tanggal' => 'date',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
  ];
}
