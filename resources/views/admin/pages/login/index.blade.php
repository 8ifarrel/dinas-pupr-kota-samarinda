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
</head>

<body>
  <div class="w-screen h-dvh flex items-center justify-center bg-gray-50 dark:bg-gray-800 px-4 sm:px-6 lg:px-8">
    <div class="relative py-3 sm:max-w-xs sm:mx-auto">
      <div class="min-h-96 px-8 py-6 bg-white dark:bg-gray-900 rounded-xl shadow-lg">
        <div class="flex flex-col justify-center items-center h-full select-none">
          <div class="flex flex-col items-center justify-center gap-2 mb-6">
            <div class="flex gap-2">
              <a href="{{ route('guest.beranda.index') }}">
                <img src="{{ config('app.logo_pemkot') }}" alt="{{ config('app.nama_pemkot') }}" class="h-12" />
              </a>
              <a href="{{ route('guest.beranda.index') }}">
                <img src="{{ config('app.logo_dinas') }}" alt="{{ config('app.nama_dinas') }}" class="h-12" />
              </a>
            </div>
            <p class="m-0 text-[16px] font-semibold dark:text-white">Hai, Administrator!</p>
            <span class="m-0 text-xs text-center text-[#8B8E98]">
              Silakan login ke E-Panel untuk mengelola website {{ config('app.nama_dinas') }}
            </span>
          </div>

          <!-- Form login -->
          <form class="w-full" method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="flex flex-col gap-2">
                <label class="font-semibold text-xs text-gray-400">Username</label>
                <input type="text" name="name"
                    class="border border-gray-300 focus:border-blue-500 focus:border-2 rounded-lg px-3 py-2 mb-2 text-sm w-full outline-none"
                    placeholder="name" value="{{ old('name') }}" required />
                <!-- Menampilkan error untuk username -->
                @if(session('error'))
                    <span class="text-red-500 text-xs">{{ session('error') }}</span>
                @endif
            </div>

            <div class="flex flex-col gap-2">
                <label class="font-semibold text-xs text-gray-400">Password</label>
                <input type="password" name="password"
                    class="border border-gray-300 focus:border-blue-500 focus:!border-2 rounded-lg px-3 py-2 mb-2 text-sm w-full outline-none"
                    placeholder="••••••••" required />
                <!-- Bisa juga menambahkan error spesifik untuk password -->
                {{-- @error('password')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror --}}
            </div>

            <button type="submit"
                class="py-1 px-8 bg-brand-blue hover:bg-blue-800 focus:ring-offset-blue-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg cursor-pointer select-none">
                LOGIN
            </button>
        </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
