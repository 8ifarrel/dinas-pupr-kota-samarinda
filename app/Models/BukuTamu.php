<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTamu extends Model
{
	use HasFactory;

	protected $table = 'buku_tamu';
	protected $primaryKey = 'id_buku_tamu';
	public $incrementing = false;

	protected $fillable = [
		'id_buku_tamu',
		'nama_pengunjung',
		'nomor_telepon',
		'email',
		'alamat',
		'jabatan_yang_dikunjungi',
		'maksud_dan_tujuan',
		'status',
		'deskripsi_status',
	];

	public function jabatan()
	{
		return $this->belongsTo(SusunanOrganisasi::class, 'jabatan_yang_dikunjungi', 'id_susunan_organisasi');
	}
}

