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
  <x-favicon-links />

  {{-- Fontawesome --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
    integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg=="
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

  @vite(['resources/js/app.js', 'resources/js/shared/flowbite-modal.js'])

  @yield('document.end')
</body>

</html>
