<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <meta name="description" content="{{ $meta_description }}" />

  <meta name="robots" content="noindex, nofollow">

  <title>
    Buku Tamu | Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda
  </title>

  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon/favicon-16x16.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon/favicon-32x32.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('image/favicon/apple-touch-icon.png') }}">
  <link rel="manifest" href="{{ asset('image/favicon/site.webmanifest') }}">
  <link rel="shortcut icon" href="{{ asset('image/favicon/favicon.ico') }}">
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('image/favicon/android-chrome-192x192.png') }}">
  <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('image/favicon/android-chrome-512x512.png') }}">

  @vite(['resources/js/app.js', 'resources/css/app.css'])

  @yield('document.head')
</head>

<body>
  @yield('document.body')
</body>

</html>
