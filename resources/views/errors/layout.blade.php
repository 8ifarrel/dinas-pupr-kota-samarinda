{{--
  Kerangka bersama seluruh halaman error.
  Halaman yang memakainya mengirim variabel lewat @extends:
    @extends('errors.layout', ['kode' => '404', 'judul' => '...', 'pesan' => '...'])
  lalu mengisi @section('ikon') dengan path SVG.
--}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>
    {{ $kode }} | Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda
  </title>

  <meta name="robots" content="noindex, nofollow">

  <!-- Favicon dan Icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon/favicon-16x16.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon/favicon-32x32.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('image/favicon/apple-touch-icon.png') }}">
  <link rel="manifest" href="{{ asset('image/favicon/site.webmanifest') }}">
  <link rel="shortcut icon" href="{{ asset('image/favicon/favicon.ico') }}">

  {{-- Tailwind --}}
  @vite('resources/css/app.css')
</head>

<body>
  <div class="flex h-[calc(100vh-30px)] items-center justify-center p-5 w-full bg-white">
    <div class="text-center">
      <div class="inline-flex rounded-full bg-sky-200 p-4">
        <div class="rounded-full stroke-brand-yellow bg-brand-blue p-4">
          <svg class="w-16 h-16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            @yield('ikon')
          </svg>
        </div>
      </div>
      <hgroup class="sm:max-w-xl lg:max-w-[850px]">
        <h1 class="mt-5 text-2xl xs:text-3xl sm:text-4xl font-bold text-slate-800 lg:text-5xl">
          {{ $kode }} - {{ $judul }}
        </h1>
        <p class="text-slate-600 mt-3 mb-5 sm:mt-5 sm:text-lg lg:text-xl">
          {{ $pesan }}
        </p>
      </hgroup>
      <a href="{{ route('guest.portal.index') }}"
        class="text-brand-blue bg-brand-yellow font-bold rounded-full text-sm px-5 py-2.5 text-center">
        Kembali ke Portal
      </a>
    </div>
  </div>
</body>

</html>
