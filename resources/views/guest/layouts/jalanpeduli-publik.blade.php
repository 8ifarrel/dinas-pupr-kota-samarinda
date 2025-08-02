<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Layanan Laporan Publik')</title>

    
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="description" content="{{ $meta_description }}" />

    <title>
        {{ $page_title ? $page_title . ' |' : '' }} Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda
    </title>

    {{-- Google Fonts (Inter) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon/favicon-32x32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('image/favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('image/favicon/site.webmanifest') }}">
    <link rel="shortcut icon" href="{{ asset('image/favicon/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('image/favicon/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('image/favicon/android-chrome-512x512.png') }}">

    {{-- Tailwind CSS (dikompilasi melalui Vite/Mix) --}}
    @vite('resources/css/app.css')
    {{-- Jika tidak menggunakan Vite, sesuaikan dengan path CSS Anda: <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}

    {{-- Font Awesome (opsional, jika masih digunakan di navbar/footer/tempat lain) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite('resources/css/app.css')

    {{-- Page-specific Styles (jika ada css custom yang tidak bisa di-tailwind-kan) --}}
    @yield('styles')
</head>
<body class="flex flex-col min-h-screen bg-gray-50 text-gray-800">

    <!-- 1. Navbar -->
    @include('guest.components.jalanpeduli-navbar')

    <!-- 2. Konten Utama (akan mengisi ruang yang tersedia) -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- 3. Footer (akan didorong ke bawah) -->
    @include('guest.components.footer')

    <!-- Script JS -->
    @yield('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>

    @include('guest.components.privacy-policy-notification')

    @vite('resources/js/app.js')
    @vite('resources/js/clock.js')
    @vite('resources/js/navbar-guest.js')

    
    {{-- Jika menggunakan Livewire --}}
</body>

</html>