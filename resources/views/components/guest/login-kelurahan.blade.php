{{--
  Kartu login akun kelurahan: template umum untuk fitur apa pun yang
  mewajibkan login akun kelurahan (username + kata sandi, guard "kelurahan"
  dan "web" dicoba bergantian oleh controller pemanggil).

  Props:
  - title   Judul halaman, mis. "Login Hantu Banyu".
  - action  URL tujuan submit form (route POST login fitur terkait).

  Slot (default): deskripsi singkat di bawah judul, boleh berisi HTML
  ringan (mis. <b>) untuk menekankan istilah tertentu.

  Contoh pemanggilan:
    <x-guest.login-kelurahan title="Login Hantu Banyu" :action="route('guest.hantu-banyu.login')">
      Masuk dengan <b>akun kelurahan</b> untuk melapor di wilayah Anda sendiri, atau dengan
      <b>akun admin E-Panel</b> untuk mengakses seluruh kelurahan.
    </x-guest.login-kelurahan>
--}}
@props(['title', 'action'])

<div class="w-screen min-h-screen flex items-center justify-center bg-gray-50 px-4 sm:px-6 lg:px-8 py-10">
  <div class="w-full sm:max-w-xs sm:mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="p-7">
        {{-- Header --}}
        <div class="flex flex-col items-center text-center mb-6 select-none">
          <div class="flex items-center gap-2 mb-4">
            <a href="{{ route('guest.portal.index') }}">
              <img src="{{ config('app.logo_pemkot') }}" alt="{{ config('app.nama_pemkot') }}" class="h-11" />
            </a>
            <a href="{{ route('guest.portal.index') }}">
              <img src="{{ config('app.logo_dinas') }}" alt="{{ config('app.nama_dinas') }}" class="h-11" />
            </a>
          </div>
          <p class="text-lg font-semibold text-brand-blue">{{ $title }}</p>
          <p class="text-sm text-gray-500 mt-2 leading-relaxed">
            {{ $slot }}
          </p>
        </div>

        {{-- Notifikasi --}}
        @if (session('error') || $errors->any())
          <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-700">
            @if (session('error'))
              <p>{{ session('error') }}</p>
            @endif
            @foreach ($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ $action }}" class="w-full">
          @csrf

          <div class="flex flex-col gap-2">
            <label for="name" class="font-semibold text-xs text-gray-400">Username</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" autofocus required
              autocomplete="username" placeholder="username kelurahan atau admin"
              class="border border-gray-300 focus:border-blue-500 focus:border-2 rounded-lg px-3 py-2 mb-5 text-sm w-full outline-none" />
          </div>

          <div class="flex flex-col gap-2">
            <label for="password" class="font-semibold text-xs text-gray-400">Kata Sandi</label>
            <input type="password" name="password" id="password" required autocomplete="current-password"
              placeholder="Masukkan kata sandi"
              class="border border-gray-300 focus:border-blue-500 focus:border-2 rounded-lg px-3 py-2 mb-4 text-sm w-full outline-none" />
          </div>

          <label class="flex items-center gap-2 mb-5 text-xs text-gray-500 select-none cursor-pointer">
            <input type="checkbox" name="remember" value="1" class="rounded border-gray-300" />
            Ingat saya di perangkat ini
          </label>

          <button type="submit"
            class="py-2 px-8 bg-brand-blue hover:bg-blue-800 text-white w-full transition ease-in duration-200 text-center text-sm font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg cursor-pointer select-none">
            MASUK
          </button>
        </form>
      </div>
    </div>

    <p class="text-center text-gray-500 mt-5">
      <a href="{{ route('guest.portal.index') }}" class="hover:text-brand-blue">&larr; Kembali ke Portal</a>
    </p>
  </div>
</div>
