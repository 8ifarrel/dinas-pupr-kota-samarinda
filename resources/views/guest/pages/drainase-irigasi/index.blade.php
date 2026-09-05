@extends('guest.layouts.main')

@section('document.start')
  <link rel="dns-prefetch" href="https://lottie.host">
  <link rel="preconnect" href="https://lottie.host" crossorigin>
@endsection

@section('document.body')
  {{-- HERO SECTION: Interactive Map + Step Timeline --}}
  <section
    class="relative min-h-[calc(100vh-148px)] flex flex-col items-center justify-center overflow-hidden py-8 md:py-12">
    {{-- Map BG --}}
    <div class="absolute inset-0 z-0 pointer-events-none">
      <img src="{{ asset('image/hero/drainase-irigasi.jpeg') }}" alt="Peta Samarinda"
        class="w-full h-full object-cover opacity-25 blur-[2px]" />
      <div class="absolute inset-0 bg-gradient-to-b from-brand-blue/70 via-white/10 to-white"></div>
    </div>

    {{-- Akun kelurahan (pojok kanan atas hero) --}}
    @auth('kelurahan')
      @php $akunKel = Auth::guard('kelurahan')->user(); @endphp
      <div class="absolute top-4 right-4 sm:top-6 sm:right-6 z-20">
        <button data-dropdown-toggle="dropdownAkunKelurahan" data-dropdown-placement="bottom-end" type="button"
          class="inline-flex items-center gap-2 text-brand-blue bg-white font-semibold rounded-xl text-sm px-3 py-2 shadow-lg hover:shadow-xl active:shadow-md transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-blue/40 focus-visible:ring-offset-2">
          <i class="fa-solid fa-circle-user"></i>
          <span class="hidden sm:inline">Akun Saya</span>
          <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
          </svg>
        </button>
        <div id="dropdownAkunKelurahan"
          class="z-50 hidden bg-white text-gray-700 divide-y divide-gray-100 rounded-lg shadow-lg border w-60">
          <div class="px-4 py-3">
            <p class="text-sm font-semibold text-gray-900 truncate">{{ $akunKel->fullname }}</p>
            <p class="text-xs text-gray-500 truncate">
              Kelurahan {{ optional($akunKel->kelurahan)->nama ?? '-' }}
            </p>
          </div>
          <ul class="py-1 text-sm">
            <li>
              <a href="{{ route('guest.drainase-irigasi.akun.edit') }}"
                class="block px-4 py-2 hover:bg-gray-100">Kelola Akun</a>
            </li>
            <li>
              <form method="POST" action="{{ route('guest.drainase-irigasi.logout') }}">
                @csrf
                <button type="submit" class="w-full text-left block px-4 py-2 text-red-600 hover:bg-gray-100">
                  Logout
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    @endauth

    {{-- Main Card --}}
    <div class="relative z-10 flex flex-col items-center w-full px-4 sm:px-6 md:px-8 lg:gap-6 3xl:gap-10">
      <div class="text-center">
        <div class="flex justify-center gap-2 mb-2 lg:mb-2 3xl:mb-4">
          <span
            class="inline-block bg-brand-yellow text-brand-blue font-bold text-xs sm:text-sm 2xl:text-base 3xl:text-lg px-2 sm:px-3 py-0.5 sm:py-1 rounded-full shadow">{{ $page_subtitle }}</span>
        </div>
        {{-- <h1
          class="mb-2 sm:mb-3 lg:mb-3 3xl:mb-5 text-2xl sm:text-3xl md:text-4xl lg:text-4xl 2xl:text-5xl 3xl:text-7xl font-semibold text-brand-blue px-0 sm:px-8 md:px-12 lg:px-24 max-w-[286px] xs:max-w-full mx-auto">
          Laporkan Masalah Drainase <br class="hidden sm:inline lg:hidden 2xl:inline"> dan Irigasi <br
            class="hidden lg:inline 2xl:hidden"> di Aplikasi Hantu Banyu
        </h1> --}}
        <h1
          class="mb-2 sm:mb-3 lg:mb-3 3xl:mb-5 text-3xl sm:text-4xl lg:text-5xl 2xl:text-6xl 3xl:text-7xl font-semibold text-brand-blue px-0 sm:px-8 md:px-12 lg:px-24 max-w-[286px] xs:max-w-full mx-auto">
          Hantu Banyu
        </h1>
        <p
          class="mb-4 sm:mb-5 lg:mb-6 3xl:mb-10 text-sm sm:text-base lg:text-base 3xl:text-2xl font-medium text-gray-700 sm:px-4 md:px-8 lg:px-0 lg:max-w-4xl 3xl:max-w-6xl mx-auto">
          Laporkan masalah <b>banjir dan kerusakan saluran drainase dan irigasi</b> melalui layanan <b>Hantu Banyu</b> dari <b>UPTD
            Pemeliharaan Saluran Drainase dan Irigasi</b> Dinas PUPR Kota Samarinda!
        </p>
        <div 
          class="
            flex flex-col 
            sm:grid sm:grid-cols-2 sm:gap-4 sm:w-full 
            md:grid md:grid-cols-2 md:gap-4 md:w-full
            lg:flex lg:flex-row lg:justify-center lg:gap-4
            justify-center gap-3
          "
        >
          <a href="{{ route('guest.drainase-irigasi.pengaduan.create') }}"
            class="inline-flex justify-center items-center px-4 py-2 3xl:py-3 3xl:px-6 text-sm 2xl:text-base font-semibold text-white rounded-lg bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue shadow-lg transition">
            Buat Pengaduan
            <i class="fa-solid fa-paper-plane ms-1.5"></i>
          </a>
          <a href="{{ route('guest.drainase-irigasi.pengaduan.index') }}"
            class="inline-flex justify-center items-center px-4 py-2 3xl:py-3 3xl:px-6 text-sm 2xl:text-base font-medium text-brand-blue rounded-lg border border-brand-blue hover:bg-brand-blue hover:text-white shadow-lg transition">
            Lihat Semua Pengaduan
            <i class="fa-solid fa-list-ol ms-1.5"></i>
          </a>
          <a href="{{ route('guest.drainase-irigasi.peta-sebaran.index') }}"
            class="inline-flex justify-center items-center px-4 py-2 3xl:py-3 3xl:px-6 text-sm 2xl:text-base font-medium text-brand-blue rounded-lg border border-brand-blue hover:bg-brand-blue hover:text-white shadow-lg transition">
            Lihat Peta Sebaran
            <i class="fa-solid fa-map-location-dot ms-1.5"></i>
          </a>
          <a href="https://wa.me/6281234567890" target="_blank"
            class="inline-flex justify-center items-center px-4 py-2 3xl:py-3 3xl:px-6 text-sm 2xl:text-base font-medium text-white rounded-lg bg-green-600 hover:bg-green-700 shadow-lg transition">
            Hubungi Kami di WhatsApp
            <i class="fa-brands fa-whatsapp fa-lg ms-1.5"></i>
          </a>
        </div>
      </div>

      {{-- Step Timeline --}}
      <div class="w-full flex flex-col items-center mt-8 sm:mt-10 md:mt-12 lg:mt-0">
        <div
          class="flex flex-col sm:grid lg:flex sm:grid-cols-2 items-center justify-center sm:gap-x-4 sm:gap-y-6 lg:flex-row lg:gap-2 xl:gap-6 3xl:gap-8 w-full max-w-[240px] sm:max-w-xl md:max-w-2xl lg:max-w-4xl xl:max-w-5xl 3xl:max-w-6xl text-center">
          {{-- Siapa yang bisa Melapor? --}}
          <div class="flex flex-col items-center group flex-1 mb-5 sm:mb-0">
            <div
              class="bg-brand-blue text-brand-yellow rounded-full w-10 h-10 sm:w-10 sm:h-10 lg:w-12 lg:h-12 2xl:w-16 2xl:h-16 flex items-center justify-center text-lg sm:text-lg lg:text-xl 2xl:text-3xl shadow-lg group-hover:scale-110 transition">
              <i class="fa-solid fa-users"></i>
            </div>
            <span
              class="mt-1 sm:mt-2 2xl:mt-3 font-bold text-brand-blue text-sm sm:text-sm lg:text-base 2xl:text-lg">Siapa
              yang bisa Melapor?</span>
            <span
              class="text-gray-700 text-xs sm:text-xs lg:text-sm 2xl:text-base text-center mt-0.5 2xl:mt-1 px-2">Seluruh
              warga Kota Samarinda</span>
          </div>
          <div class="hidden lg:block h-1 w-8 lg:w-10 xl:w-12 bg-brand-yellow rounded-full"></div>
          {{-- Jadwal Petugas Lapangan --}}
          <div class="flex flex-col items-center group flex-1 mb-5 sm:mb-0">
            <div
              class="bg-brand-yellow text-brand-blue rounded-full w-10 h-10 sm:w-10 sm:h-10 lg:w-12 lg:h-12 2xl:w-16 2xl:h-16 flex items-center justify-center text-lg sm:text-lg lg:text-xl 2xl:text-3xl shadow-lg group-hover:scale-110 transition">
              <i class="fa-solid fa-helmet-safety"></i>
            </div>
            <span
              class="mt-1 sm:mt-2 2xl:mt-3 font-bold text-brand-blue text-sm sm:text-sm lg:text-base 2xl:text-lg">Jadwal
              Petugas Lapangan</span>
            <span class="text-gray-700 text-xs sm:text-xs lg:text-sm 2xl:text-base text-center mt-0.5 2xl:mt-1 px-2">Libur
              setiap hari Jumat
              hari Sabtu & Minggu</span>
          </div>
          <div class="hidden lg:block h-1 w-8 lg:w-10 xl:w-12 bg-brand-yellow rounded-full"></div>
          {{-- Jadwal Petugas Kantor --}}
          <div class="flex flex-col items-center group flex-1 mb-5 sm:mb-0">
            <div
              class="bg-brand-yellow text-brand-blue rounded-full w-10 h-10 sm:w-10 sm:h-10 lg:w-12 lg:h-12 2xl:w-16 2xl:h-16 flex items-center justify-center text-lg sm:text-lg lg:text-xl 2xl:text-3xl shadow-lg group-hover:scale-110 transition">
              <i class="fa-solid fa-briefcase"></i>
            </div>
            <span
              class="mt-1 sm:mt-2 2xl:mt-3 font-bold text-brand-blue text-sm sm:text-sm lg:text-base 2xl:text-lg">Jadwal
              Petugas Kantor</span>
            <span class="text-gray-700 text-xs sm:text-xs lg:text-sm 2xl:text-base text-center mt-0.5 2xl:mt-1 px-2">Libur
              setiap hari Sabtu dan
              Minggu</span>
          </div>
          <div class="hidden lg:block h-1 w-8 lg:w-10 xl:w-12 bg-brand-yellow rounded-full"></div>
          {{-- Proses Laporan --}}
          <div class="flex flex-col items-center group flex-1">
            <div
              class="bg-brand-blue text-brand-yellow rounded-full w-10 h-10 sm:w-10 sm:h-10 lg:w-12 lg:h-12 2xl:w-16 2xl:h-16 flex items-center justify-center text-lg sm:text-lg lg:text-xl 2xl:text-3xl shadow-lg group-hover:scale-110 transition">
              <i class="fa-solid fa-list-check"></i>
            </div>
            <span
              class="mt-1 sm:mt-2 2xl:mt-3 font-bold text-brand-blue text-sm sm:text-sm lg:text-base 2xl:text-lg">Proses
              Laporan</span>
            <span
              class="text-gray-700 text-xs sm:text-xs lg:text-sm 2xl:text-base text-center mt-0.5 2xl:mt-1 px-2">Diurutkan
              berdasarkan waktu laporan
              masuk dan tingkat
              prioritas</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-6 sm:py-8 lg:py-16 px-4 sm:px-6 lg:px-16">
    <div class="text-center space-y-1.5 pb-5 lg:pb-10">
      <h2 class="text-3xl lg:text-4xl font-bold">Statistik Pengaduan</h2>
    </div>

    @include('partials.hantu-banyu-statistik')
  </section>
@endsection

@section('document.end')
  <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module" defer>
  </script>

  @if ($total > 0)
    @vite('resources/js/chartjs.js')
  @endif
  @include('partials.hantu-banyu-statistik-js')
@endsection
