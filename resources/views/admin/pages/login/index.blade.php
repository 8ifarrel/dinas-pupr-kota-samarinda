@extends('admin.layouts.login')

@section('slot')
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
              <label class="font-semibold text-xs text-gray-400">Email</label>
              <input type="email" name="email"
                class="border border-gray-300 focus:border-blue-500 focus:border-2 rounded-lg px-3 py-2 mb-5 text-sm w-full outline-none"
                placeholder="Email" value="{{ old('email') }}" required />
            </div>

            <div class="flex flex-col gap-2">
              <label class="font-semibold text-xs text-gray-400">Password</label>
              <input type="password" name="password"
                class="border border-gray-300 focus:border-blue-500 focus:!border-2 rounded-lg px-3 py-2 mb-5 text-sm w-full outline-none"
                placeholder="••••••••" required />
            </div>

            <button type="submit"
              class="py-1 px-8 bg-blue hover:bg-blue-800 focus:ring-offset-blue-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg cursor-pointer select-none">
              LOGIN
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
