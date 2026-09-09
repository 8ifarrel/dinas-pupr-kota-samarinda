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
      <img src="{{ asset('image/hero/hantu-banyu.jpeg') }}" alt="Peta Samarinda"
        class="w-full h-full object-cover opacity-25 blur-[2px]" />
      <div class="absolute inset-0 bg-gradient-to-b from-brand-blue/70 via-white/10 to-white"></div>
    </div>

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
          {{-- Membuat laporan hanya untuk akun kelurahan dan admin unit
               pengelola layanan ini; admin unit lain tetap bisa melihat
               seluruh data lewat tombol-tombol di sebelahnya. --}}
          @if ($boleh_kelola)
            <a href="{{ route('guest.hantu-banyu.pengaduan.create') }}"
              class="inline-flex justify-center items-center px-4 py-2 3xl:py-3 3xl:px-6 text-sm 2xl:text-base font-semibold text-white rounded-lg bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue shadow-lg transition">
              Buat Pengaduan
              <i class="fa-solid fa-paper-plane ms-1.5"></i>
            </a>
          @endif
          <a href="{{ route('guest.hantu-banyu.pengaduan.index') }}"
            class="inline-flex justify-center items-center px-4 py-2 3xl:py-3 3xl:px-6 text-sm 2xl:text-base font-medium text-brand-blue rounded-lg border border-brand-blue hover:bg-brand-blue hover:text-white shadow-lg transition">
            Lihat Semua Pengaduan
            <i class="fa-solid fa-list-ol ms-1.5"></i>
          </a>
          <a href="{{ route('guest.hantu-banyu.peta-sebaran.index') }}"
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
      {{-- Penegas wilayah yang sedang ditampilkan: satu kelurahan untuk akun
           kelurahan, seluruh kota untuk admin UPTD. --}}
      <p class="text-gray-500 text-base lg:text-lg">{{ $statistik_subjudul }}</p>
    </div>

{{--
  Statistik pengaduan Hantu Banyu. Butuh variabel yang disiapkan controller
  (lihat method compute() di controller ini).
--}}
@if ($total === 0)
  <div class="bg-white rounded-lg shadow-lg border p-10 text-center">
    <i class="fa-solid fa-chart-pie text-gray-300 text-5xl mb-3"></i>
    <p class="text-gray-500">Belum ada laporan yang masuk. Statistik akan tampil setelah ada data.</p>
  </div>
@else
  {{-- ===================== KPI ===================== --}}
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-lg shadow-lg border p-5">
      <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">Total Laporan</span>
        <i class="fa-solid fa-file-lines text-blue-500"></i>
      </div>
      <div class="text-2xl font-bold text-gray-900 mt-2">{{ $total }}</div>
    </div>
    <div class="bg-white rounded-lg shadow-lg border p-5">
      <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">Sedang Diproses</span>
        <i class="fa-solid fa-spinner text-indigo-500"></i>
      </div>
      <div class="text-2xl font-bold text-gray-900 mt-2">{{ $total_berjalan }}</div>
    </div>
    <div class="bg-white rounded-lg shadow-lg border p-5">
      <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">Selesai</span>
        <i class="fa-solid fa-circle-check text-green-500"></i>
      </div>
      <div class="text-2xl font-bold text-gray-900 mt-2">{{ $total_selesai }}</div>
      <div class="text-xs text-gray-400 mt-1">{{ round($total_selesai / $total * 100) }}% dari total</div>
    </div>
    <div class="bg-white rounded-lg shadow-lg border p-5">
      <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">Belum Diproses</span>
        <i class="fa-solid fa-clock text-yellow-500"></i>
      </div>
      <div class="text-2xl font-bold text-gray-900 mt-2">{{ $belum_diproses }}</div>
    </div>
  </div>

  @php
    $selectCls = 'text-sm border border-gray-300 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-200';
  @endphp

  {{-- ===================== Laporan Masuk (bar, kuartal + tahun) ===================== --}}
  <div class="bg-white rounded-lg shadow-lg border p-6 mt-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
      <div>
        <h3 class="font-semibold text-gray-900">Laporan Masuk</h3>
      </div>
      <div class="flex gap-2">
        <select id="masukQuarter" class="{{ $selectCls }}">
          <option value="1">Kuartal I (Jan–Mar)</option>
          <option value="2">Kuartal II (Apr–Jun)</option>
          <option value="3">Kuartal III (Jul–Sep)</option>
          <option value="4">Kuartal IV (Okt–Des)</option>
        </select>
        <select id="masukYear" class="{{ $selectCls }}">
          @foreach ($years as $y)
            <option value="{{ $y }}">{{ $y }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="relative h-72">
      <canvas id="chartMasuk"></canvas>
      <div id="nodataMasuk"
        class="absolute inset-0 hidden items-center justify-center text-gray-400 text-sm bg-white">
        Tidak ada data pada periode ini
      </div>
    </div>
  </div>

  {{-- ===================== Diproses & Jenis (doughnut, bulan + tahun) ===================== --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <div class="bg-white rounded-lg shadow-lg border p-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
        <div>
          <h3 class="font-semibold text-gray-900">Laporan sedang Diproses</h3>
        </div>
        <div class="flex gap-2">
          <select id="diprosesMonth" class="{{ $selectCls }}"></select>
          <select id="diprosesYear" class="{{ $selectCls }}">
            @foreach ($years as $y)
              <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="relative h-72">
        <canvas id="chartDiproses"></canvas>
        <div id="nodataDiproses"
          class="absolute inset-0 hidden items-center justify-center text-gray-400 text-sm bg-white">
          Tidak ada data pada periode ini
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg border p-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
        <div>
          <h3 class="font-semibold text-gray-900">Jenis Laporan</h3>
        </div>
        <div class="flex gap-2">
          <select id="jenisMonth" class="{{ $selectCls }}"></select>
          <select id="jenisYear" class="{{ $selectCls }}">
            @foreach ($years as $y)
              <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="relative h-72">
        <canvas id="chartJenis"></canvas>
        <div id="nodataJenis"
          class="absolute inset-0 hidden items-center justify-center text-gray-400 text-sm bg-white">
          Tidak ada data pada periode ini
        </div>
      </div>
    </div>
  </div>

  {{-- ===================== Kecamatan (bar, bulan + tahun) =====================
       Hanya untuk admin UPTD. Bagi akun kelurahan, grafik ini selalu berisi
       satu batang saja (kecamatan tempat kelurahannya berada), jadi tidak
       memberi informasi apa pun. --}}
  @if ($tampilkan_kecamatan)
    <div class="bg-white rounded-lg shadow-lg border p-6 mt-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
        <div>
          <h3 class="font-semibold text-gray-900">Sebaran Laporan per Kecamatan</h3>
        </div>
        <div class="flex gap-2">
          <select id="kecMonth" class="{{ $selectCls }}"></select>
          <select id="kecYear" class="{{ $selectCls }}">
            @foreach ($years as $y)
              <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="relative" style="height: {{ max(288, $kecamatan_list->count() * 34) }}px">
        <canvas id="chartKecamatan"></canvas>
        <div id="nodataKec"
          class="absolute inset-0 hidden items-center justify-center text-gray-400 text-sm bg-white">
          Tidak ada data pada periode ini
        </div>
      </div>
    </div>
  @endif

  {{-- ===================== Sebaran per Kelurahan (bar, kecamatan + bulan + tahun)
       Melengkapi tampilan admin supaya sama dengan statistik di E-Panel. --}}
  @if ($tampilkan_kelurahan)
    <div class="bg-white rounded-lg shadow-lg border p-6 mt-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
        <div>
          <h3 class="font-semibold text-gray-900">Sebaran Laporan per Kelurahan</h3>
        </div>
        <div class="flex flex-wrap gap-2">
          <select id="kelKecamatan" class="{{ $selectCls }}">
            @foreach ($kelurahan_map as $namaKec => $daftarKel)
              <option value="{{ $namaKec }}">{{ $namaKec }}</option>
            @endforeach
          </select>
          <select id="kelMonth" class="{{ $selectCls }}"></select>
          <select id="kelYear" class="{{ $selectCls }}">
            @foreach ($years as $y)
              <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="relative" id="kelChartWrap" style="height: 288px">
        <canvas id="chartKelurahan"></canvas>
        <div id="nodataKel"
          class="absolute inset-0 hidden items-center justify-center text-gray-400 text-sm bg-white">
          Tidak ada data pada periode ini
        </div>
      </div>
    </div>
  @endif
@endif
  </section>
@endsection

@section('document.end')
  <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module" defer>
  </script>

  {{--
    Grafik statistik dirender oleh resources/js/hantu-banyu/statistik-chart.js
    (dipakai bersama dengan halaman statistik E-Panel) - lihat berkas itu
    untuk logikanya. Datanya dioper lewat atribut data-* di bawah supaya
    skrip itu tidak perlu tahu apa pun tentang controller/halaman ini.
  --}}
  @if ($total > 0)
    @vite(['resources/js/chartjs.js', 'resources/js/hantu-banyu/statistik-chart.js'])
    <div id="statistik-hantu-banyu-data" class="hidden"
      data-by-ym="{{ json_encode($by_ym) }}"
      data-kecamatan-list="{{ json_encode($kecamatan_list) }}"
      data-kelurahan-map="{{ json_encode($kelurahan_map) }}"
      data-now-year="{{ $now_year }}"
      data-now-month="{{ $now_month }}"
      data-now-quarter="{{ $now_quarter }}"
    ></div>
  @endif
@endsection
