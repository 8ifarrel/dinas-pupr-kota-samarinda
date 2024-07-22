<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SejarahKotaSamarinda extends Model
{
	use HasFactory;

	protected $table = 'sejarah_kota_samarinda';

	protected $primaryKey = 'id_sejarah_kota_samarinda';

	protected $fillable = [
		'deskripsi_sejarah_kota_samarinda'
	];
}