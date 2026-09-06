@extends('errors.layout', [
    'kode' => '404',
    'judul' => 'Halaman Tidak Ditemukan',
    'pesan' => 'Maaf, halaman yang Anda tuju tidak ditemukan. Alamatnya mungkin salah ketik, atau halamannya sudah dipindahkan.',
])

@section('ikon')
  <circle cx="11" cy="11" r="7" />
  <path d="M21 21l-4.35-4.35" />
@endsection
