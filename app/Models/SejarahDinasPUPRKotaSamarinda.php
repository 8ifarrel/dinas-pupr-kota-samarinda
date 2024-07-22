<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SejarahDinasPUPRKotaSamarinda extends Model
{
	use HasFactory;

	protected $table = 'sejarah_dinas_pupr_kota_samarinda';

	protected $primaryKey = 'id_sejarah_dinas_pupr_kota_samarinda';

	protected $fillable = [
		'deskripsi_sejarah_dinas_pupr_kota_samarinda'
	];
}