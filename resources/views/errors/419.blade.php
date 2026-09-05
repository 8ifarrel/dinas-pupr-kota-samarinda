@extends('errors.layout', [
    'kode' => '419',
    'judul' => 'Sesi Telah Berakhir',
    'pesan' => 'Halaman dibiarkan terbuka terlalu lama sehingga sesi Anda berakhir demi keamanan. Silakan muat ulang halaman lalu kirim ulang isian Anda.',
])

@section('ikon')
  <circle cx="12" cy="12" r="9" />
  <path d="M12 7v5l3 2" />
@endsection
