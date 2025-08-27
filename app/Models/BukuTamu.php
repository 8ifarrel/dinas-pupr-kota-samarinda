<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTamu extends Model
{
	use HasFactory;

	protected $table = 'buku_tamu';
	protected $primaryKey = 'id_buku_tamu';
	public $incrementing = true;
	protected $keyType = 'int';

	protected $fillable = [
		'nomor_urut',
		'nama_pengunjung',
		'nomor_telepon',
		'email',
		'alamat',
		'jabatan_yang_dikunjungi',
		'maksud_dan_tujuan',
		'status',
		'deskripsi_status',
	];

	public function susunanOrganisasi()
	{
		return $this->belongsTo(SusunanOrganisasi::class, 'jabatan_yang_dikunjungi', 'id_susunan_organisasi');
	}
}

