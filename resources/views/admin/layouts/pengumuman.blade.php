<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>
    {{ $page_title }} | E-Panel {{ config('app.nama_dinas') }}
  </title>

  {{-- JQuery --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  {{-- Flowbite --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

  {{-- Fontawesome --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  {{-- Tailwind --}}
  @vite('resources/css/app.css')

  @yield('css')
</head>

<body>
  @include('admin.components.navbar')

  @include('admin.components.aside')

  <div class="p-8 mt-14 md:ml-64">
    <h1 class="font-semibold text-2xl mb-5 md:text-3xl">
      {{ $page_title }}
    </h1>

@if (session('success'))
  <div id="alert-success" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-100" role="alert">
    <svg class="flex-shrink-0 w-4 h-4 me-2" fill="currentColor" viewBox="0 0 20 20">
      <path d="M16.707 5.293a1 1 0 0 0-1.414 0L8 12.586l-3.293-3.293A1 1 0 0 0 3.293 10.707l4 4a1 1 0 0 0 1.414 0l8-8a1 1 0 0 0 0-1.414z"/>
    </svg>
    <div class="ms-3 text-sm font-medium">
      {{ session('success') }}
    </div>
    <button type="button" class="ms-auto bg-green-100 text-green-500 rounded-lg p-1.5 hover:bg-green-200" data-dismiss-target="#alert-success" aria-label="Close">
      <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
        <path stroke="currentColor" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13"/>
      </svg>
    </button>
  </div>
@endif


    @yield('slot')
  </div>

  {{-- Flowbite --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

  @yield('js')
</body>

</html>