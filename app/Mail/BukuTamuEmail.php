<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BukuTamuEmail extends Mailable
{
	use Queueable, SerializesModels;

	public $idBukuTamu;
	public $data;

	public function __construct($idBukuTamu, $data)
	{
		$this->idBukuTamu = $idBukuTamu;
		$this->data = $data;
	}

	public function build()
	{
		return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
			->view('guest.pages.buku-tamu.email')
			->subject('Konfirmasi Pengajuan Buku Tamu')
			->with([
				'data' => $this->data,
				'idBukuTamu' => $this->idBukuTamu,
			]);
	}
}
