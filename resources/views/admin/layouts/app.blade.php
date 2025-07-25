<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $page_title ?? 'Admin' }}</title>
    @vite('resources/css/app.css')
</head>
<body>
    @include('admin.layouts.navbar') {{-- opsional, jika kamu punya navbar --}}
    
    <main class="p-6">
        @yield('content')
    </main>

    @vite('resources/js/app.js')
</body>
</html>