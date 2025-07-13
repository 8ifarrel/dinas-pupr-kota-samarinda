<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  {{-- 
		Curhat part #1
		plis tolong bantu gua buatkan meta desc yang cocok untuk SEO
		tujuannya biar orang samarinda tau kalau pemerintahan 
		menyediakan layanan dan informasi terkait infrastruktur
		--}}
  <meta name="description" content="{{ $meta_description }}" />

  <title>
    Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda
  </title>

  <!-- Favicon dan Icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon/favicon-16x16.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon/favicon-32x32.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('image/favicon/apple-touch-icon.png') }}">
  <link rel="manifest" href="{{ asset('image/favicon/site.webmanifest') }}">
  <link rel="shortcut icon" href="{{ asset('image/favicon/favicon.ico') }}">

  <!-- Untuk Android -->
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('image/favicon/android-chrome-192x192.png') }}">
  <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('image/favicon/android-chrome-512x512.png') }}">

  {{-- Flowbite --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

  {{-- Fontawesome --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  {{-- Tailwind --}}
  @vite('resources/css/app.css')
</head>

<body class="flex items-center justify-center min-h-screen">
  @yield('slot')

  {{-- AOS --}}
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

  {{-- AOS --}}
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <script>
    AOS.init({
      duration: 800,
    });
  </script>

  {{-- Flowbite --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

  {{-- Lottiefiles --}}
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</body>

</html>


