@extends('guest.layouts.main')

@section('document.start')
  <link rel="dns-prefetch" href="https://lottie.host">
  <link rel="preconnect" href="https://lottie.host" crossorigin>

  @vite('resources/css/sweetalert2.css')
@endsection

@section('document.body')
  @if (session('success'))
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
          html: `
        <div class="flex flex-col items-center">
          <!-- ICON ATAS -->
          <dotlottie-player
            src="https://lottie.host/1e9820b7-84fe-45d5-ad40-14004aa784a9/N2PtNg9vHv.lottie"
            background="transparent"  
            speed="1"
            class="w-[100px] h-[100px] tv-vertical:w-[250px] tv-vertical:h-[250px]"
            loop autoplay>
          </dotlottie-player>

          <!-- TITLE -->
          <h2 class="text-brand-blue font-bold text-xl sm:text-2xl tv-vertical:text-5xl tv-vertical:mt-2 mb-4 text-center">
            Berhasil!
          </h2>

          <!-- TEXT SESSION -->
          <p class="tv-vertical:mt-4 text-gray-700 text-base sm:text-lg tv-vertical:text-3xl font-medium text-center">
            {{ session('success') }}
          </p>
        </div>
      `,
          icon: null,
          showConfirmButton: true,
          confirmButtonText: 'Oke',
          customClass: {
            popup: 'tv-vertical:w-full tv-vertical:max-w-2xl tv-vertical:pb-10 rounded-2xl',
            confirmButton: 'rounded-full bg-brand-blue text-brand-yellow px-4 py-2 text-lg font-bold transition-all duration-200 hover:bg-brand-yellow hover:text-brand-blue active:scale-95 focus:outline-none focus:ring-2 focus:ring-black disabled:opacity-50 disabled:cursor-not-allowed tv-vertical:text-2xl tv-vertical:px-10 tv-vertical:py-4'
          },
          buttonsStyling: false
        });
      });
    </script>
  @endif

  {{-- HERO SECTION: Interactive Map + Step Timeline --}}
  <section class="relative min-h-[calc(100vh-148px)] flex flex-col items-center justify-center overflow-hidden py-8 md:py-12">
    {{-- Map BG --}}
    <div class="absolute inset-0 z-0 pointer-events-none">
      <img src="{{ asset('image/hero/drainase-irigasi.jpeg') }}" alt="Peta Samarinda"
        class="w-full h-full object-cover opacity-25 blur-[2px]" />
      <div class="absolute inset-0 bg-gradient-to-b from-brand-blue/70 via-white/10 to-white"></div>
    </div>
    {{-- Main Card --}}
    <div class="relative z-10 flex flex-col items-center w-full px-4 sm:px-6 md:px-8 lg:gap-6 3xl:gap-10">
      <div class="text-center">
        <div class="flex justify-center gap-2 mb-2 lg:mb-2 3xl:mb-4">
          <span
            class="inline-block bg-brand-yellow text-brand-blue font-bold text-xs sm:text-sm 2xl:text-base 3xl:text-lg px-2 sm:px-3 py-0.5 sm:py-1 rounded-full shadow">Layanan</span>
        </div>
        <h1 class="mb-2 sm:mb-3 lg:mb-3 3xl:mb-5 text-2xl sm:text-3xl md:text-4xl lg:text-4xl 2xl:text-5xl 3xl:text-7xl font-semibold text-brand-blue px-0 sm:px-8 md:px-12 lg:px-24 max-w-[286px] xs:max-w-full mx-auto">
          Laporkan Masalah Drainase <br class="hidden sm:inline lg:hidden 2xl:inline"> dan Irigasi <br class="hidden lg:inline 2xl:hidden"> di Kota Samarinda
        </h1>
        <p
          class="mb-4 sm:mb-5 lg:mb-6 3xl:mb-10 text-sm sm:text-base lg:text-base 3xl:text-xl font-medium text-gray-700 px-1 sm:px-4 md:px-8 lg:max-w-4xl 3xl:max-w-7xl mx-auto">
          Partisipasi Anda membantu mencegah banjir dan kerusakan saluran! Laporkan permasalahan melalui aplikasi
          pengaduan <b>UPTD Pemeliharaan Saluran Drainase dan Irigasi</b> Dinas PUPR Kota Samarinda.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4">
          <a href="{{ route('guest.drainase-irigasi.create') }}"
            class="inline-flex justify-center items-center px-4 py-2 3xl:py-3 3xl:px-6 text-sm 2xl:text-base font-semibold text-white rounded-lg bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue shadow-lg transition">
            Buat Pengaduan
            <i class="fa-solid fa-paper-plane ms-1.5"></i>
          </a>
          <a href="{{ route('guest.drainase-irigasi.show') }}"
            class="inline-flex justify-center items-center px-4 py-2 3xl:py-3 3xl:px-6 text-sm 2xl:text-base font-medium text-brand-blue rounded-lg border border-brand-blue hover:bg-brand-blue hover:text-white shadow-lg transition">
            Lihat Semua Pengaduan
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
            <span class="mt-1 sm:mt-2 2xl:mt-3 font-bold text-brand-blue text-sm sm:text-sm lg:text-base 2xl:text-lg">Siapa yang bisa Melapor?</span>
            <span class="text-gray-700 text-xs sm:text-xs lg:text-sm 2xl:text-base text-center mt-0.5 2xl:mt-1 px-2">Seluruh warga Kota Samarinda</span>
          </div>
          <div class="hidden lg:block h-1 w-8 lg:w-10 xl:w-12 bg-brand-yellow rounded-full"></div>
          {{-- Jadwal Petugas Lapangan --}}
          <div class="flex flex-col items-center group flex-1 mb-5 sm:mb-0">
            <div
              class="bg-brand-yellow text-brand-blue rounded-full w-10 h-10 sm:w-10 sm:h-10 lg:w-12 lg:h-12 2xl:w-16 2xl:h-16 flex items-center justify-center text-lg sm:text-lg lg:text-xl 2xl:text-3xl shadow-lg group-hover:scale-110 transition">
              <i class="fa-solid fa-helmet-safety"></i>
            </div>
            <span class="mt-1 sm:mt-2 2xl:mt-3 font-bold text-brand-blue text-sm sm:text-sm lg:text-base 2xl:text-lg">Jadwal Petugas Lapangan</span>
            <span class="text-gray-700 text-xs sm:text-xs lg:text-sm 2xl:text-base text-center mt-0.5 2xl:mt-1 px-2">Libur setiap hari Jumat
              hari Sabtu & Minggu</span>
          </div>
          <div class="hidden lg:block h-1 w-8 lg:w-10 xl:w-12 bg-brand-yellow rounded-full"></div>
          {{-- Jadwal Petugas Kantor --}}
          <div class="flex flex-col items-center group flex-1 mb-5 sm:mb-0">
            <div
              class="bg-brand-yellow text-brand-blue rounded-full w-10 h-10 sm:w-10 sm:h-10 lg:w-12 lg:h-12 2xl:w-16 2xl:h-16 flex items-center justify-center text-lg sm:text-lg lg:text-xl 2xl:text-3xl shadow-lg group-hover:scale-110 transition">
              <i class="fa-solid fa-briefcase"></i>
            </div>
            <span class="mt-1 sm:mt-2 2xl:mt-3 font-bold text-brand-blue text-sm sm:text-sm lg:text-base 2xl:text-lg">Jadwal Petugas Kantor</span>
            <span class="text-gray-700 text-xs sm:text-xs lg:text-sm 2xl:text-base text-center mt-0.5 2xl:mt-1 px-2">Libur setiap hari Sabtu dan
              Minggu</span>
          </div>
          <div class="hidden lg:block h-1 w-8 lg:w-10 xl:w-12 bg-brand-yellow rounded-full"></div>
          {{-- Proses Laporan --}}
          <div class="flex flex-col items-center group flex-1">
            <div
              class="bg-brand-blue text-brand-yellow rounded-full w-10 h-10 sm:w-10 sm:h-10 lg:w-12 lg:h-12 2xl:w-16 2xl:h-16 flex items-center justify-center text-lg sm:text-lg lg:text-xl 2xl:text-3xl shadow-lg group-hover:scale-110 transition">
              <i class="fa-solid fa-list-check"></i>
            </div>
            <span class="mt-1 sm:mt-2 2xl:mt-3 font-bold text-brand-blue text-sm sm:text-sm lg:text-base 2xl:text-lg">Proses Laporan</span>
            <span class="text-gray-700 text-xs sm:text-xs lg:text-sm 2xl:text-base text-center mt-0.5 2xl:mt-1 px-2">Diurutkan berdasarkan waktu laporan
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
      <p class="text-gray-600">Data terakhir diperbarui pada {{ $tanggal_terakhir_update }}</p>
    </div>

    <div class="border rounded-xl shadow-lg p-5 xs:p-6 sm:p-8 space-y-5 mb-5">
      {{-- Laporan masuk --}}
      <div class="flex flex-col sm:flex-row justify-between items-center">
        <div class="mb-1.5 sm:mb-0 space-y-0.5 text-center sm:text-start">
          <h3 class="text-xl lg:text-2xl font-semibold">Laporan Masuk</h3>
          <p class="text-gray-600" id="totalLaporanMasukText">
            Total <b>{{ $total_laporan_masuk }} data</b> pada
            <span id="labelRentangMasuk"></span>
            <span id="labelTahunMasuk">{{ $tahun_statistik }}</span>
          </p>
        </div>
        <div class="flex gap-2">
          <!-- Dropdown Bulan (Rentang) -->
          <button id="dropdownLaporanMasukBulan" data-dropdown-toggle="dropdownLaporanMasukBulanMenu"
            class="text-black font-medium text-xs sm:text-sm px-3 py-1 sm:py-1.5 text-center inline-flex items-center border border-black rounded-xl"
            type="button">Januari-April <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
            </svg>
          </button>
          <div id="dropdownLaporanMasukBulanMenu"
            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg border shadow dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
              <li>
                <a href="#" data-rentang="0"
                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Januari-April</a>
              </li>
              <li>
                <a href="#" data-rentang="1"
                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mei-Agustus</a>
              </li>
              <li>
                <a href="#" data-rentang="2"
                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">September-Desember</a>
              </li>
            </ul>
          </div>
          <!-- Dropdown Tahun -->
          <button id="dropdownLaporanMasukTahun" data-dropdown-toggle="dropdownLaporanMasukTahunMenu"
            class="text-black font-medium text-xs sm:text-sm px-3 py-1 sm:py-1.5 text-center inline-flex items-center border border-black rounded-xl"
            type="button">{{ $tahun_statistik }} <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
            </svg>
          </button>
          <div id="dropdownLaporanMasukTahunMenu"
            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg border shadow dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
              <li><a href="#" data-tahun="{{ $tahun_statistik }}"
                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $tahun_statistik }}</a>
              </li>
              <!-- Tambahkan tahun lain jika perlu -->
            </ul>
          </div>
        </div>
      </div>

      <div class="w-full h-[250px] md:h-[350px] relative">
        <canvas id="statistikChart" class="w-full h-full"></canvas>
        <div id="nodataStatistikChart"
          class="absolute inset-0 flex items-center justify-center text-gray-500 text-lg font-semibold bg-white bg-opacity-80 hidden">
          Tidak ada data
        </div>
      </div>

    </div>

    <div class="lg:flex space-y-5 lg:gap-x-5 lg:space-y-0">
      {{-- Laporan sedang diproses --}}
      <div class="border rounded-xl shadow-lg p-5 xs:p-6 sm:p-8 space-y-5 flex-1">
        <div class="flex flex-col sm:flex-row justify-between items-center">
          <div class="mb-1.5 sm:mb-0 space-y-0.5 text-center sm:text-start">
            <h3 class="text-xl sm:text-2xl font-semibold">Laporan sedang Diproses</h3>
            <p class="text-gray-600" id="totalLaporanDiprosesText">
              Total <b>{{ $total_laporan_diproses }} data</b> pada
              <span id="labelBulanDiproses"></span>
              <span id="labelTahunDiproses">{{ $tahun_statistik }}</span>
            </p>
          </div>
          <div class="flex gap-2">
            <button id="dropdownLaporanDiprosesBulan" data-dropdown-toggle="dropdownLaporanDiprosesBulanMenu"
              class="text-black font-medium text-xs sm:text-sm px-3 py-1 sm:py-1.5 text-center inline-flex items-center border border-black rounded-xl"
              type="button">Januari <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 4 4 4-4" />
              </svg>
            </button>
            <div id="dropdownLaporanDiprosesBulanMenu"
              class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg border shadow dark:bg-gray-700">
              <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                @foreach ($periode_bulan as $idx => $b)
                  <li>
                    <a href="#" data-bulan="{{ $b['bulan'] }}" data-idx="{{ $idx }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $b['label'] }}</a>
                  </li>
                @endforeach
              </ul>
            </div>
            <button id="dropdownLaporanDiprosesTahun" data-dropdown-toggle="dropdownLaporanDiprosesTahunMenu"
              class="text-black font-medium text-xs sm:text-sm px-3 py-1 sm:py-1.5 text-center inline-flex items-center border border-black rounded-xl"
              type="button">{{ $tahun_statistik }} <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 4 4 4-4" />
              </svg>
            </button>
            <div id="dropdownLaporanDiprosesTahunMenu"
              class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg border shadow dark:bg-gray-700">
              <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                <li><a href="#" data-tahun="{{ $tahun_statistik }}"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $tahun_statistik }}</a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div>
          <div class="lg:max-w-full lg:max-h-[250px] relative">
            <canvas id="laporanDiprosesChart" class="lg:max-w-full lg:h-auto"></canvas>
            <div id="nodataLaporanDiprosesChart"
              class="absolute inset-0 flex items-center justify-center text-gray-500 text-lg font-semibold bg-white bg-opacity-80 hidden">
              Tidak ada data
            </div>
          </div>
        </div>
      </div>

      {{-- Jenis Laporan --}}
      <div class="border rounded-xl shadow-lg p-5 xs:p-6 sm:p-8 space-y-5 flex-1">
        <div class="flex flex-col sm:flex-row justify-between items-center">
          <div class="mb-1.5 sm:mb-0 space-y-0.5 text-center sm:text-start">
            <h3 class="text-xl lg:text-2xl font-semibold">Jenis Laporan</h3>
            <p class="text-gray-600" id="totalJenisLaporanText">
              Total <b>{{ $total_jenis_laporan }} data</b> pada
              <span id="labelBulanJenis"></span>
              <span id="labelTahunJenis">{{ $tahun_statistik }}</span>
            </p>
          </div>
          <div class="flex gap-2">
            <button id="dropdownJenisLaporanBulan" data-dropdown-toggle="dropdownJenisLaporanBulanMenu"
              class="text-black font-medium text-xs sm:text-sm px-3 py-1 sm:py-1.5 text-center inline-flex items-center border border-black rounded-xl"
              type="button">Januari <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 4 4 4-4" />
              </svg>
            </button>
            <div id="dropdownJenisLaporanBulanMenu"
              class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg border shadow dark:bg-gray-700">
              <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                @foreach ($periode_bulan as $idx => $b)
                  <li>
                    <a href="#" data-bulan="{{ $b['bulan'] }}" data-idx="{{ $idx }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $b['label'] }}</a>
                  </li>
                @endforeach
              </ul>
            </div>
            <button id="dropdownJenisLaporanTahun" data-dropdown-toggle="dropdownJenisLaporanTahunMenu"
              class="text-black font-medium text-xs sm:text-sm px-3 py-1 sm:py-1.5 text-center inline-flex items-center border border-black rounded-xl"
              type="button">{{ $tahun_statistik }} <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 4 4 4-4" />
              </svg>
            </button>
            <div id="dropdownJenisLaporanTahunMenu"
              class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg border shadow dark:bg-gray-700">
              <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                <li><a href="#" data-tahun="{{ $tahun_statistik }}"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $tahun_statistik }}</a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div>
          <div class="lg:max-w-full lg:max-h-[250px] relative">
            <canvas id="jenisLaporanChart" class="lg:max-w-full lg:h-auto"></canvas>
            <div id="nodataJenisLaporanChart"
              class="absolute inset-0 flex items-center justify-center text-gray-500 text-lg font-semibold bg-white bg-opacity-80 hidden">
              Tidak ada data
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('document.end')
  @vite('resources/js/chartjs.js')
  @vite('resources/js/sweetalert2.js')

  <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module" defer>
  </script>

  <script>
    // Dropdown toggle logic
    function setupDropdownToggle(buttonId, menuId) {
      const btn = document.getElementById(buttonId);
      const menu = document.getElementById(menuId);
      if (!btn || !menu) return;

      btn.addEventListener('click', function(e) {
        e.stopPropagation();
        menu.classList.toggle('hidden');
      });

      // Hide dropdown when clicking outside
      document.addEventListener('click', function(e) {
        if (!menu.contains(e.target) && !btn.contains(e.target)) {
          menu.classList.add('hidden');
        }
      });
    }

    // Call for each dropdown
    setupDropdownToggle('dropdownLaporanMasuk', 'dropdownLaporanMasukMenu');
    setupDropdownToggle('dropdownLaporanDiproses', 'dropdownLaporanDiprosesMenu');
    setupDropdownToggle('dropdownJenisLaporan', 'dropdownJenisLaporanMenu');

    // Data statistik dari backend
    const statistikLaporanMasuk = @json($statistik_laporan_masuk);
    const statistikLaporanDiproses = @json($statistik_laporan_diproses);
    const statistikJenisLaporan = @json($statistik_jenis_laporan);
    const periodeBulan = @json($periode_bulan);

    function getLegendPosition() {
      return window.innerWidth < 768 ? 'bottom' : 'right';
    }

    // Fungsi untuk menentukan index default berdasarkan bulan sekarang
    function getDefaultLaporanMasukIdx() {
      const now = new Date();
      const bulan = now.getMonth() + 1; // 1-12
      if (bulan >= 1 && bulan <= 4) return 0; // Jan-Apr
      if (bulan >= 5 && bulan <= 8) return 1; // Mei-Ags
      return 2; // Sep-Des
    }
    // Default bulan dan tahun
    function getDefaultBulanIdx() {
      const now = new Date();
      return now.getMonth(); // 0-based index
    }

    function getDefaultTahun() {
      const now = new Date();
      return now.getFullYear();
    }

    // Default rentang bulan untuk laporan masuk
    function getDefaultLaporanMasukRentangIdx() {
      const now = new Date();
      const bulan = now.getMonth() + 1;
      if (bulan >= 1 && bulan <= 4) return 0;
      if (bulan >= 5 && bulan <= 8) return 1;
      return 2;
    }

    // State bulan/tahun untuk masing-masing chart
    let bulanMasukIdx = getDefaultBulanIdx();
    let tahunMasuk = getDefaultTahun();
    let bulanDiprosesIdx = getDefaultBulanIdx();
    let tahunDiproses = getDefaultTahun();
    let bulanJenisIdx = getDefaultBulanIdx();
    let tahunJenis = getDefaultTahun();
    let laporanDiprosesChart, jenisLaporanChart, statistikChart;
    let rentangMasukIdx = getDefaultLaporanMasukRentangIdx();

    window.onload = function() {
      // Set default label dropdown
      setDefaultDropdownLabel('dropdownLaporanMasukBulan', 'dropdownLaporanMasukBulanMenu', rentangMasukIdx);
      setDefaultDropdownLabel('dropdownLaporanMasukTahun', 'dropdownLaporanMasukTahunMenu', 0);
      setDefaultDropdownLabel('dropdownLaporanDiprosesBulan', 'dropdownLaporanDiprosesBulanMenu', bulanDiprosesIdx);
      setDefaultDropdownLabel('dropdownLaporanDiprosesTahun', 'dropdownLaporanDiprosesTahunMenu', 0);
      setDefaultDropdownLabel('dropdownJenisLaporanBulan', 'dropdownJenisLaporanBulanMenu', bulanJenisIdx);
      setDefaultDropdownLabel('dropdownJenisLaporanTahun', 'dropdownJenisLaporanTahunMenu', 0);

      // Bar Chart Laporan Masuk
      const ctx = document.getElementById('statistikChart').getContext('2d');
      statistikChart = new Chart(ctx, {
        type: 'bar',
        data: getBarChartDataRentang(rentangMasukIdx, tahunMasuk),
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'top'
            },
            title: {
              display: false
            }
          },
          scales: {
            x: {
              stacked: true
            },
            y: {
              stacked: true,
              beginAtZero: true
            }
          }
        }
      });
      updateNoDataStatistikChart(statistikChart.data);

      // Doughnut chart for Laporan Diproses
      const ctxDiproses = document.getElementById('laporanDiprosesChart').getContext('2d');
      laporanDiprosesChart = new Chart(ctxDiproses, {
        type: 'doughnut',
        data: {
          labels: [
            'Laporan diterima',
            'Menunggu survei',
            'Sudah disurvei',
            'Menunggu jadwal',
            'Sedang dikerjakan'
          ],
          datasets: [{
            data: getDiprosesData(bulanDiprosesIdx + 1, tahunDiproses),
            backgroundColor: [
              '#9EDE73',
              '#F9A11A',
              '#009CE4',
              '#E63846',
              '#E4C900'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: getLegendPosition(),
              align: 'center',
              labels: {
                boxWidth: 20,
                padding: 16
              }
            },
            title: {
              display: false
            }
          }
        }
      });
      updateNoDataLaporanDiprosesChart(laporanDiprosesChart.data.datasets[0].data);

      // Doughnut chart for Jenis Laporan
      const ctxJenis = document.getElementById('jenisLaporanChart').getContext('2d');
      jenisLaporanChart = new Chart(ctxJenis, {
        type: 'doughnut',
        data: {
          labels: [
            'Belum Diklasifikasikan',
            'Penanganan Darurat',
            'Penanganan Biasa',
            'Pemeliharaan Rutin'
          ],
          datasets: [{
            data: getJenisData(bulanJenisIdx + 1, tahunJenis),
            backgroundColor: [
              '#6B7280', // abu-abu untuk belum diklasifikasikan
              '#E63846',
              '#f59e42',
              '#3b82f6'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: getLegendPosition(),
              align: 'center',
              labels: {
                boxWidth: 20,
                padding: 16
              }
            },
            title: {
              display: false
            }
          }
        }
      });
      updateNoDataJenisLaporanChart(jenisLaporanChart.data.datasets[0].data);

      // Handler dropdown bulan/tahun laporan masuk (khusus rentang)
      setupDropdownRentang('dropdownLaporanMasukBulanMenu', 'dropdownLaporanMasukBulan', (idx) => {
        rentangMasukIdx = idx;
        statistikChart.data = getBarChartDataRentang(rentangMasukIdx, tahunMasuk);
        statistikChart.update();
        updateNoDataStatistikChart(statistikChart.data);
        updateTotalLabels();
      });
      setupDropdownBulanTahun('dropdownLaporanMasukTahunMenu', 'dropdownLaporanMasukTahun', (idx, tahun) => {
        tahunMasuk = tahun;
        statistikChart.data = getBarChartDataRentang(rentangMasukIdx, tahunMasuk);
        statistikChart.update();
        updateNoDataStatistikChart(statistikChart.data);
        updateTotalLabels();
      });

      setupDropdownBulanTahun('dropdownLaporanDiprosesBulanMenu', 'dropdownLaporanDiprosesBulan', (idx) => {
        bulanDiprosesIdx = idx;
        laporanDiprosesChart.data.datasets[0].data = getDiprosesData(bulanDiprosesIdx + 1, tahunDiproses);
        laporanDiprosesChart.update();
        updateNoDataLaporanDiprosesChart(laporanDiprosesChart.data.datasets[0].data);
        updateTotalLabels();
      });
      setupDropdownBulanTahun('dropdownLaporanDiprosesTahunMenu', 'dropdownLaporanDiprosesTahun', (idx, tahun) => {
        tahunDiproses = tahun;
        laporanDiprosesChart.data.datasets[0].data = getDiprosesData(bulanDiprosesIdx + 1, tahunDiproses);
        laporanDiprosesChart.update();
        updateNoDataLaporanDiprosesChart(laporanDiprosesChart.data.datasets[0].data);
        updateTotalLabels();
      });

      setupDropdownBulanTahun('dropdownJenisLaporanBulanMenu', 'dropdownJenisLaporanBulan', (idx) => {
        bulanJenisIdx = idx;
        jenisLaporanChart.data.datasets[0].data = getJenisData(bulanJenisIdx + 1, tahunJenis);
        jenisLaporanChart.update();
        updateNoDataJenisLaporanChart(jenisLaporanChart.data.datasets[0].data);
        updateTotalLabels();
      });
      setupDropdownBulanTahun('dropdownJenisLaporanTahunMenu', 'dropdownJenisLaporanTahun', (idx, tahun) => {
        tahunJenis = tahun;
        jenisLaporanChart.data.datasets[0].data = getJenisData(bulanJenisIdx + 1, tahunJenis);
        jenisLaporanChart.update();
        updateNoDataJenisLaporanChart(jenisLaporanChart.data.datasets[0].data);
        updateTotalLabels();
      });

      // Set default label pada button dropdown sesuai waktu sekarang
      setDefaultDropdownLabel('dropdownLaporanMasuk', 'dropdownLaporanMasukMenu', bulanMasukIdx);
      setDefaultDropdownLabel('dropdownLaporanDiproses', 'dropdownLaporanDiprosesMenu', bulanDiprosesIdx);
      setDefaultDropdownLabel('dropdownJenisLaporan', 'dropdownJenisLaporanMenu', bulanJenisIdx);
    };

    // Fungsi untuk set label button dropdown sesuai default index
    function setDefaultDropdownLabel(buttonId, menuId, idx) {
      const button = document.getElementById(buttonId);
      const menu = document.getElementById(menuId);
      if (button && menu) {
        const items = menu.querySelectorAll('a');
        if (items[idx]) {
          button.innerHTML = items[idx].innerHTML +
            '<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" /></svg>';
        }
      }
    }

    // Fungsi handler dropdown bulan/tahun
    function setupDropdownBulanTahun(menuId, buttonId, callback) {
      const menu = document.getElementById(menuId);
      const button = document.getElementById(buttonId);
      if (!menu) return;
      menu.querySelectorAll('a').forEach((item, idx) => {
        item.addEventListener('click', function(e) {
          e.preventDefault();
          if (item.dataset.tahun) {
            callback(idx, parseInt(item.dataset.tahun));
          } else {
            callback(idx);
          }
          // Update button text
          if (button) {
            button.innerHTML = item.innerHTML +
              '<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" /></svg>';
          }
          menu.classList.add('hidden');
        });
      });
    }

    // Fungsi handler dropdown rentang bulan
    function setupDropdownRentang(menuId, buttonId, callback) {
      const menu = document.getElementById(menuId);
      const button = document.getElementById(buttonId);
      if (!menu) return;
      menu.querySelectorAll('a').forEach((item, idx) => {
        item.addEventListener('click', function(e) {
          e.preventDefault();
          callback(idx);
          // Update button text
          if (button) {
            button.innerHTML = item.innerHTML +
              '<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" /></svg>';
          }
          menu.classList.add('hidden');
        });
      });
    }

    // Update data chart sesuai bulan/tahun
    function getBarChartData(bulanIdx, tahun) {
      // Ambil data hanya untuk bulanIdx dan tahun
      const label = periodeBulan[bulanIdx].label;
      const data = statistikLaporanMasuk[bulanIdx] || {
        pending: 0,
        diproses: 0,
        selesai: 0
      };
      return {
        labels: [label],
        datasets: [{
            label: 'Belum diproses (pending)',
            data: [data.pending ?? 0],
            backgroundColor: '#E63846'
          },
          {
            label: 'Sedang diproses',
            data: [data.diproses ?? 0],
            backgroundColor: '#F9A11A'
          },
          {
            label: 'Selesai',
            data: [data.selesai ?? 0],
            backgroundColor: '#9EDE73'
          }
        ]
      };
    }

    // Fungsi untuk bar chart laporan masuk berdasarkan rentang bulan
    function getBarChartDataRentang(rentangIdx, tahun) {
      // rentangIdx: 0=Jan-Apr, 1=Mei-Ags, 2=Sep-Des
      let startIdx = 0,
        endIdx = 3;
      if (rentangIdx === 1) {
        startIdx = 4;
        endIdx = 7;
      }
      if (rentangIdx === 2) {
        startIdx = 8;
        endIdx = 11;
      }
      const labels = periodeBulan.slice(startIdx, endIdx + 1).map(x => x.label);
      const pending = [];
      const diproses = [];
      const selesai = [];
      for (let i = startIdx; i <= endIdx; i++) {
        const data = statistikLaporanMasuk[i] || {
          pending: 0,
          diproses: 0,
          selesai: 0
        };
        pending.push(data.pending ?? 0);
        diproses.push(data.diproses ?? 0);
        selesai.push(data.selesai ?? 0);
      }
      return {
        labels: labels,
        datasets: [{
            label: 'Belum diproses (pending)',
            data: pending,
            backgroundColor: '#E63846'
          },
          {
            label: 'Sedang diproses',
            data: diproses,
            backgroundColor: '#F9A11A'
          },
          {
            label: 'Selesai',
            data: selesai,
            backgroundColor: '#9EDE73'
          }
        ]
      };
    }

    function getDiprosesData(bulan, tahun) {
      const data = statistikLaporanDiproses[bulan];
      return [
        data ? data.diterima : 0,
        data ? data.menunggu_survei : 0,
        data ? data.sudah_disurvei : 0,
        data ? data.menunggu_jadwal_pengerjaan : 0,
        data ? data.sedang_dikerjakan : 0
      ];
    }

    function getJenisData(bulan, tahun) {
      const data = statistikJenisLaporan[bulan];
      return [
        data ? data.belum_diklasifikasikan : 0,
        data ? data.darurat : 0,
        data ? data.biasa : 0,
        data ? data.rutin : 0
      ];
    }

    // Fungsi cek apakah semua data chart nol
    function isAllZero(arr) {
      return arr.every(x => x === 0);
    }

    // Fungsi show/hide "Tidak ada data" untuk masing-masing chart
    function updateNoDataStatistikChart(data) {
      const el = document.getElementById('nodataStatistikChart');
      const allZero = isAllZero(data.datasets[0].data) && isAllZero(data.datasets[1].data) && isAllZero(data.datasets[2]
        .data);
      el.style.display = allZero ? 'flex' : 'none';
    }

    function updateNoDataLaporanDiprosesChart(data) {
      const el = document.getElementById('nodataLaporanDiprosesChart');
      el.style.display = isAllZero(data) ? 'flex' : 'none';
    }

    function updateNoDataJenisLaporanChart(data) {
      const el = document.getElementById('nodataJenisLaporanChart');
      el.style.display = isAllZero(data) ? 'flex' : 'none';
    }

    // Update legend position on resize
    window.addEventListener('resize', function() {
      const legendPos = getLegendPosition();
      if (laporanDiprosesChart) {
        laporanDiprosesChart.options.plugins.legend.position = legendPos;
        laporanDiprosesChart.update();
      }
      if (jenisLaporanChart) {
        jenisLaporanChart.options.plugins.legend.position = legendPos;
        jenisLaporanChart.update();
      }
    });

    // Helper untuk label rentang bulan
    const rentangLabels = ['Januari-April', 'Mei-Agustus', 'September-Desember'];

    // Set label total pada load awal sesuai waktu sekarang
    function setInitialTotalLabels() {
      // Laporan Masuk
      document.getElementById('labelRentangMasuk').textContent = rentangLabels[rentangMasukIdx];
      document.getElementById('labelTahunMasuk').textContent = tahunMasuk;

      // Laporan Diproses
      document.getElementById('labelBulanDiproses').textContent = periodeBulan[bulanDiprosesIdx].label;
      document.getElementById('labelTahunDiproses').textContent = tahunDiproses;

      // Jenis Laporan
      document.getElementById('labelBulanJenis').textContent = periodeBulan[bulanJenisIdx].label;
      document.getElementById('labelTahunJenis').textContent = tahunJenis;
    }

    // Update label total sesuai dropdown
    function updateTotalLabels() {
      document.getElementById('labelRentangMasuk').textContent = rentangLabels[rentangMasukIdx];
      document.getElementById('labelTahunMasuk').textContent = tahunMasuk;
      document.getElementById('labelBulanDiproses').textContent = periodeBulan[bulanDiprosesIdx].label;
      document.getElementById('labelTahunDiproses').textContent = tahunDiproses;
      document.getElementById('labelBulanJenis').textContent = periodeBulan[bulanJenisIdx].label;
      document.getElementById('labelTahunJenis').textContent = tahunJenis;
    }

    window.onload = function() {
      // Set default label dropdown
      setDefaultDropdownLabel('dropdownLaporanMasukBulan', 'dropdownLaporanMasukBulanMenu', rentangMasukIdx);
      setDefaultDropdownLabel('dropdownLaporanMasukTahun', 'dropdownLaporanMasukTahunMenu', 0);
      setDefaultDropdownLabel('dropdownLaporanDiprosesBulan', 'dropdownLaporanDiprosesBulanMenu', bulanDiprosesIdx);
      setDefaultDropdownLabel('dropdownLaporanDiprosesTahun', 'dropdownLaporanDiprosesTahunMenu', 0);
      setDefaultDropdownLabel('dropdownJenisLaporanBulan', 'dropdownJenisLaporanBulanMenu', bulanJenisIdx);
      setDefaultDropdownLabel('dropdownJenisLaporanTahun', 'dropdownJenisLaporanTahunMenu', 0);

      // Bar Chart Laporan Masuk
      const ctx = document.getElementById('statistikChart').getContext('2d');
      statistikChart = new Chart(ctx, {
        type: 'bar',
        data: getBarChartDataRentang(rentangMasukIdx, tahunMasuk),
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'top'
            },
            title: {
              display: false
            }
          },
          scales: {
            x: {
              stacked: true
            },
            y: {
              stacked: true,
              beginAtZero: true
            }
          }
        }
      });
      updateNoDataStatistikChart(statistikChart.data);

      // Doughnut chart for Laporan Diproses
      const ctxDiproses = document.getElementById('laporanDiprosesChart').getContext('2d');
      laporanDiprosesChart = new Chart(ctxDiproses, {
        type: 'doughnut',
        data: {
          labels: [
            'Laporan diterima',
            'Menunggu survei',
            'Sudah disurvei',
            'Menunggu jadwal',
            'Sedang dikerjakan'
          ],
          datasets: [{
            data: getDiprosesData(bulanDiprosesIdx + 1, tahunDiproses),
            backgroundColor: [
              '#9EDE73',
              '#F9A11A',
              '#009CE4',
              '#E63846',
              '#E4C900'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: getLegendPosition(),
              align: 'center',
              labels: {
                boxWidth: 20,
                padding: 16
              }
            },
            title: {
              display: false
            }
          }
        }
      });
      updateNoDataLaporanDiprosesChart(laporanDiprosesChart.data.datasets[0].data);

      // Doughnut chart for Jenis Laporan
      const ctxJenis = document.getElementById('jenisLaporanChart').getContext('2d');
      jenisLaporanChart = new Chart(ctxJenis, {
        type: 'doughnut',
        data: {
          labels: [
            'Belum Diklasifikasikan',
            'Penanganan Darurat',
            'Penanganan Biasa',
            'Pemeliharaan Rutin'
          ],
          datasets: [{
            data: getJenisData(bulanJenisIdx + 1, tahunJenis),
            backgroundColor: [
              '#6B7280', // abu-abu untuk belum diklasifikasikan
              '#E63846',
              '#f59e42',
              '#3b82f6'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: getLegendPosition(),
              align: 'center',
              labels: {
                boxWidth: 20,
                padding: 16
              }
            },
            title: {
              display: false
            }
          }
        }
      });
      updateNoDataJenisLaporanChart(jenisLaporanChart.data.datasets[0].data);

      setInitialTotalLabels();
      // Handler dropdown bulan/tahun laporan masuk (khusus rentang)
      setupDropdownRentang('dropdownLaporanMasukBulanMenu', 'dropdownLaporanMasukBulan', (idx) => {
        rentangMasukIdx = idx;
        statistikChart.data = getBarChartDataRentang(rentangMasukIdx, tahunMasuk);
        statistikChart.update();
        updateNoDataStatistikChart(statistikChart.data);
        updateTotalLabels();
      });
      setupDropdownBulanTahun('dropdownLaporanMasukTahunMenu', 'dropdownLaporanMasukTahun', (idx, tahun) => {
        tahunMasuk = tahun;
        statistikChart.data = getBarChartDataRentang(rentangMasukIdx, tahunMasuk);
        statistikChart.update();
        updateNoDataStatistikChart(statistikChart.data);
        updateTotalLabels();
      });

      setupDropdownBulanTahun('dropdownLaporanDiprosesBulanMenu', 'dropdownLaporanDiprosesBulan', (idx) => {
        bulanDiprosesIdx = idx;
        laporanDiprosesChart.data.datasets[0].data = getDiprosesData(bulanDiprosesIdx + 1, tahunDiproses);
        laporanDiprosesChart.update();
        updateNoDataLaporanDiprosesChart(laporanDiprosesChart.data.datasets[0].data);
        updateTotalLabels();
      });
      setupDropdownBulanTahun('dropdownLaporanDiprosesTahunMenu', 'dropdownLaporanDiprosesTahun', (idx, tahun) => {
        tahunDiproses = tahun;
        laporanDiprosesChart.data.datasets[0].data = getDiprosesData(bulanDiprosesIdx + 1, tahunDiproses);
        laporanDiprosesChart.update();
        updateNoDataLaporanDiprosesChart(laporanDiprosesChart.data.datasets[0].data);
        updateTotalLabels();
      });

      setupDropdownBulanTahun('dropdownJenisLaporanBulanMenu', 'dropdownJenisLaporanBulan', (idx) => {
        bulanJenisIdx = idx;
        jenisLaporanChart.data.datasets[0].data = getJenisData(bulanJenisIdx + 1, tahunJenis);
        jenisLaporanChart.update();
        updateNoDataJenisLaporanChart(jenisLaporanChart.data.datasets[0].data);
        updateTotalLabels();
      });
      setupDropdownBulanTahun('dropdownJenisLaporanTahunMenu', 'dropdownJenisLaporanTahun', (idx, tahun) => {
        tahunJenis = tahun;
        jenisLaporanChart.data.datasets[0].data = getJenisData(bulanJenisIdx + 1, tahunJenis);
        jenisLaporanChart.update();
        updateNoDataJenisLaporanChart(jenisLaporanChart.data.datasets[0].data);
        updateTotalLabels();
      });

      // Set default label pada button dropdown sesuai waktu sekarang
      setDefaultDropdownLabel('dropdownLaporanMasuk', 'dropdownLaporanMasukMenu', bulanMasukIdx);
      setDefaultDropdownLabel('dropdownLaporanDiproses', 'dropdownLaporanDiprosesMenu', bulanDiprosesIdx);
      setDefaultDropdownLabel('dropdownJenisLaporan', 'dropdownJenisLaporanMenu', bulanJenisIdx);
    };

    // Fungsi untuk set label button dropdown sesuai default index
    function setDefaultDropdownLabel(buttonId, menuId, idx) {
      const button = document.getElementById(buttonId);
      const menu = document.getElementById(menuId);
      if (button && menu) {
        const items = menu.querySelectorAll('a');
        if (items[idx]) {
          button.innerHTML = items[idx].innerHTML +
            '<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" /></svg>';
        }
      }
    }

    // Fungsi handler dropdown bulan/tahun
    function setupDropdownBulanTahun(menuId, buttonId, callback) {
      const menu = document.getElementById(menuId);
      const button = document.getElementById(buttonId);
      if (!menu) return;
      menu.querySelectorAll('a').forEach((item, idx) => {
        item.addEventListener('click', function(e) {
          e.preventDefault();
          if (item.dataset.tahun) {
            callback(idx, parseInt(item.dataset.tahun));
          } else {
            callback(idx);
          }
          // Update button text
          if (button) {
            button.innerHTML = item.innerHTML +
              '<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" /></svg>';
          }
          menu.classList.add('hidden');
        });
      });
    }

    // Fungsi handler dropdown rentang bulan
    function setupDropdownRentang(menuId, buttonId, callback) {
      const menu = document.getElementById(menuId);
      const button = document.getElementById(buttonId);
      if (!menu) return;
      menu.querySelectorAll('a').forEach((item, idx) => {
        item.addEventListener('click', function(e) {
          e.preventDefault();
          callback(idx);
          // Update button text
          if (button) {
            button.innerHTML = item.innerHTML +
              '<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" /></svg>';
          }
          menu.classList.add('hidden');
        });
      });
    }

    // Update data chart sesuai bulan/tahun
    function getBarChartData(bulanIdx, tahun) {
      // Ambil data hanya untuk bulanIdx dan tahun
      const label = periodeBulan[bulanIdx].label;
      const data = statistikLaporanMasuk[bulanIdx] || {
        pending: 0,
        diproses: 0,
        selesai: 0
      };
      return {
        labels: [label],
        datasets: [{
            label: 'Belum diproses (pending)',
            data: [data.pending ?? 0],
            backgroundColor: '#E63846'
          },
          {
            label: 'Sedang diproses',
            data: [data.diproses ?? 0],
            backgroundColor: '#F9A11A'
          },
          {
            label: 'Selesai',
            data: [data.selesai ?? 0],
            backgroundColor: '#9EDE73'
          }
        ]
      };
    }

    // Fungsi untuk bar chart laporan masuk berdasarkan rentang bulan
    function getBarChartDataRentang(rentangIdx, tahun) {
      // rentangIdx: 0=Jan-Apr, 1=Mei-Ags, 2=Sep-Des
      let startIdx = 0,
        endIdx = 3;
      if (rentangIdx === 1) {
        startIdx = 4;
        endIdx = 7;
      }
      if (rentangIdx === 2) {
        startIdx = 8;
        endIdx = 11;
      }
      const labels = periodeBulan.slice(startIdx, endIdx + 1).map(x => x.label);
      const pending = [];
      const diproses = [];
      const selesai = [];
      for (let i = startIdx; i <= endIdx; i++) {
        const data = statistikLaporanMasuk[i] || {
          pending: 0,
          diproses: 0,
          selesai: 0
        };
        pending.push(data.pending ?? 0);
        diproses.push(data.diproses ?? 0);
        selesai.push(data.selesai ?? 0);
      }
      return {
        labels: labels,
        datasets: [{
            label: 'Belum diproses (pending)',
            data: pending,
            backgroundColor: '#E63846'
          },
          {
            label: 'Sedang diproses',
            data: diproses,
            backgroundColor: '#F9A11A'
          },
          {
            label: 'Selesai',
            data: selesai,
            backgroundColor: '#9EDE73'
          }
        ]
      };
    }

    function getDiprosesData(bulan, tahun) {
      const data = statistikLaporanDiproses[bulan];
      return [
        data ? data.diterima : 0,
        data ? data.menunggu_survei : 0,
        data ? data.sudah_disurvei : 0,
        data ? data.menunggu_jadwal_pengerjaan : 0,
        data ? data.sedang_dikerjakan : 0
      ];
    }

    function getJenisData(bulan, tahun) {
      const data = statistikJenisLaporan[bulan];
      return [
        data ? data.belum_diklasifikasikan : 0,
        data ? data.darurat : 0,
        data ? data.biasa : 0,
        data ? data.rutin : 0
      ];
    }

    // Fungsi cek apakah semua data chart nol
    function isAllZero(arr) {
      return arr.every(x => x === 0);
    }

    // Fungsi show/hide "Tidak ada data" untuk masing-masing chart
    function updateNoDataStatistikChart(data) {
      const el = document.getElementById('nodataStatistikChart');
      const allZero = isAllZero(data.datasets[0].data) && isAllZero(data.datasets[1].data) && isAllZero(data.datasets[2]
        .data);
      el.style.display = allZero ? 'flex' : 'none';
    }

    function updateNoDataLaporanDiprosesChart(data) {
      const el = document.getElementById('nodataLaporanDiprosesChart');
      el.style.display = isAllZero(data) ? 'flex' : 'none';
    }

    function updateNoDataJenisLaporanChart(data) {
      const el = document.getElementById('nodataJenisLaporanChart');
      el.style.display = isAllZero(data) ? 'flex' : 'none';
    }
  </script>
@endsection
