<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Dynamic Title --}}
    <title>
        {{ $page_title ? $page_title . ' |' : '' }} Dinas PUPR Kota Samarinda
    </title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="{{ $meta_description ?? 'Layanan Sedot Tinja - PUPR Samarinda' }}" />

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Favicons --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon/favicon-32x32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('image/favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('image/favicon/site.webmanifest') }}">
    <link rel="shortcut icon" href="{{ asset('image/favicon/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('image/favicon/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('image/favicon/android-chrome-512x512.png') }}">

    {{-- Tailwind CSS (Vite) --}}
    @vite('resources/css/app.css')

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" />

    {{-- Page-specific styles --}}
    @yield('styles')
</head>
<body class="flex flex-col min-h-screen bg-gray-50 text-gray-800">

    @include('guest.components.navbar')

    {{-- 1. Navbar khusus Sedot Tinja --}}
    @include('guest.components.navbar-sedottinja')

    {{-- 2. Flash message (validasi / status) --}}
    @include('guest.components.flash-message')

    {{-- 3. Konten Utama --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- 4. Footer (pakai yang sudah ada) --}}
    @include('guest.components.footer')

    {{-- 5. Privacy Policy (pakai yang sudah ada) --}}
    @include('guest.components.privacy-policy-notification')

    {{-- 6. Scripts --}}
    @yield('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
    @vite('resources/js/app.js')
    @vite('resources/js/clock.js')
    @vite('resources/js/navbar-guest.js')

</body>
</html>
