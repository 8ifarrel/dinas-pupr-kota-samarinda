@extends('errors.layout', [
    'kode' => '403',
    'judul' => 'Akses Ditolak',
    'pesan' => 'Anda tidak memiliki izin untuk membuka halaman ini. Bila merasa seharusnya punya akses, hubungi administrator.',
])

@section('ikon')
  <rect x="4" y="10" width="16" height="11" rx="2" />
  <path d="M8 10V7a4 4 0 0 1 8 0v3" />
@endsection
