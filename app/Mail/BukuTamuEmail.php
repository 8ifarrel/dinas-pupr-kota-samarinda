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
    // Dibaca lewat config, bukan env() langsung. Dengan env(), begitu
    // "php artisan config:cache" dijalankan di produksi nilainya menjadi null,
    // sehingga pengirim surel menjadi kosong dan pengiriman bisa ditolak
    // server SMTP.
    return $this->from(config('mail.from.address'), config('mail.from.name'))
      ->view('guest.pages.buku-tamu.email')
      ->subject('Konfirmasi Pengajuan Buku Tamu')
      ->with([
        'data' => $this->data,
        'idBukuTamu' => $this->idBukuTamu,
      ]);
  }
}

