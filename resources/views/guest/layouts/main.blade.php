<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <meta name="description" content="{{ $meta_description }}" />

  <title>
    {{ $page_title ? $page_title . ' |' : '' }} Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda
  </title>

  <x-favicon-links />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  @vite('resources/css/app.css')

  @yield('document.start')
</head>

<body>
  @include('guest.components.navbar')

  @yield('document.body')

  @include('guest.components.footer')

  @include('guest.components.privacy-policy-notification')
  
  @vite('resources/js/app.js')
  @vite('resources/js/clock.js')
  @vite('resources/js/navbar-guest.js')
  @vite('resources/js/shared/flowbite-modal.js')

  @yield('document.end')
</body>

</html>
