<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
	use HasFactory;

	protected $table = 'pengumuman';

	protected $fillable = [
		'judul_pengumuman',
		'slug_pengumuman',
		'perihal',
		'file_lampiran',
		'created_at',
	];

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
	];
}
