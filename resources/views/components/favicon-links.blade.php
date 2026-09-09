{{--
  Kumpulan tag <link> favicon/icon situs, untuk ditaruh di dalam <head>.
  Tanpa props - cukup panggil <x-favicon-links /> di setiap layout/halaman
  yang merender <head> sendiri.
--}}
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon/favicon-16x16.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon/favicon-32x32.png') }}">
<link rel="apple-touch-icon" href="{{ asset('image/favicon/apple-touch-icon.png') }}">
<link rel="manifest" href="{{ asset('image/favicon/site.webmanifest') }}">
<link rel="shortcut icon" href="{{ asset('image/favicon/favicon.ico') }}">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('image/favicon/android-chrome-192x192.png') }}">
<link rel="icon" type="image/png" sizes="512x512" href="{{ asset('image/favicon/android-chrome-512x512.png') }}">
