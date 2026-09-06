<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>
    {{ $page_title }} | E-Panel {{ config('app.nama_dinas') }}
  </title>

  <meta name="robots" content="noindex, nofollow">

  <!-- Favicon dan Icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon/favicon-16x16.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon/favicon-32x32.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('image/favicon/apple-touch-icon.png') }}">
  <link rel="manifest" href="{{ asset('image/favicon/site.webmanifest') }}">
  <link rel="shortcut icon" href="{{ asset('image/favicon/favicon.ico') }}">

  {{-- Fontawesome --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  @vite('resources/css/app.css')

  @yield('document.head')
</head>

<body>
  @include('admin.components.navbar')

  @include('admin.components.aside')

  <div class="p-8 mt-14 md:ml-64">
    @include('admin.components.heading')

    @include('admin.components.alert')

    @yield('document.body')
  </div>

  @vite('resources/js/app.js')

  @yield('document.end')
</body>

</html>
