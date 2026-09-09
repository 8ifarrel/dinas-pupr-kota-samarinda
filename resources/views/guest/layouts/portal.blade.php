<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <meta name="description" content="{{ $meta_description }}" />
  @yield('meta-extra')

  <title>
    @yield('title', 'Portal Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda')
  </title>

  <x-favicon-links />

  @vite('resources/css/app.css')

  @yield('document.start')
</head>

<body class="flex items-center justify-center min-h-screen">
  @yield('slot')

  @include('guest.components.privacy-policy-notification')

  @vite('resources/js/app.js')

  @hasSection('lottie')
    {{-- Lottiefiles --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  @endif

  @yield('document.end')
</body>
</html>
