@extends('guest.layouts.main')

@section('document.start')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('document.body')
  <div class="py-5 md:py-12 px-6 lg:px-24 3xl:px-48">
    <!-- Mobile-friendly breadcrumbs with responsive design -->
    <nav aria-label="Breadcrumb" class="max-w-[940px] mx-auto mb-2.5">
      <!-- Small/XS Mobile: Back link + Current page only -->
      <div class="md:hidden flex items-center">
        <a href="{{ route('guest.drainase-irigasi.index') }}"
          class="inline-flex items-center text-blue-600 hover:underline">
          <i class="fa-solid fa-caret-left fa-sm mb-0.5"></i>
          <div class="underline">Kembali</div>
        </a>
        <span class="mx-2 text-gray-400">|</span>
        <button id="breadcrumb-menu-button" type="button" class="text-sm text-gray-500 hover:text-gray-700">
          Lihat jalur lengkap
          <svg class="w-2.5 h-2.5 ml-1 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m1 1 4 4 4-4" />
          </svg>
        </button>
      </div>

      <!-- Small Mobile: Truncated breadcrumbs -->
      <ol class="hidden md:inline-flex items-center text-sm">
        <li class="inline-flex items-center">
          <a href="{{ route('guest.beranda.index') }}" class="text-blue-600 underline">
            Beranda
          </a>
        </li>
        <li>
          <div class="flex items-center">
            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 9 4-4-4-4" />
            </svg>
            <a href="#" class="text-blue-600 underline">
              Layanan
            </a>
          </div>
        </li>
        <li>
          <div class="flex items-center">
            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 9 4-4-4-4" />
            </svg>
            <a href="{{ route('guest.drainase-irigasi.index') }}" class="text-blue-600 underline">
              Hantu Banyu
            </a>
          </div>
        </li>
        <li aria-current="page">
          <div class="flex items-center">
            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 9 4-4-4-4" />
            </svg>
            <span class="text-gray-500 font-medium">
              <span>Formulir Pengaduan Hantu Banyu</span>
            </span>
          </div>
        </li>
      </ol>

      <!-- Mobile breadcrumb dots menu (optional) -->
      <div class="md:hidden mt-1">
        <div id="breadcrumb-dropdown"
          class="hidden z-10 absolute mt-2 bg-white divide-y divide-gray-100 rounded-lg shadow w-auto min-w-44">
          <ol class="py-2 text-sm text-gray-700">
            <li>
              <a href="{{ route('guest.beranda.index') }}" class="block px-4 py-2 hover:bg-gray-100">Beranda</a>
            </li>
            <li>
              <a href="#" class="block px-4 py-2 hover:bg-gray-100">Layanan</a>
            </li>
            <li>
              <a href="{{ route('guest.drainase-irigasi.index') }}" class="block px-4 py-2 hover:bg-gray-100">Hantu
                Banyu</a>
            </li>
            <li>
              <span class="block px-4 py-2 font-semibold text-gray-600">Formulir Pengaduan Hantu Banyu</span>
            </li>
          </ol>
        </div>
      </div>
    </nav>

    <div class="max-w-[940px] mx-auto border shadow-lg p-4 sm:p-8 rounded-lg space-y-8">
      {{-- Header --}}
      <div class="text-center space-y-2.5">
        <h1 class="text-2xl md:text-3xl font-bold">
          Formulir Pengaduan Drainase dan Irigasi
        </h1>
        <p class="text-gray-700 text-base md:text-lg">
          Silakan isi formulir di bawah ini untuk melaporkan masalah Hantu Banyu di Kota Samarinda.
        </p>
      </div>

      {{-- Stepper --}}
      <div class="mb-8">
        <div class="relative flex items-center justify-between" style="height:56px;">
          <!-- Garis stepper -->
          <div id="stepper-line-left"
            class="absolute left-[calc(50%/3)] right-1/2 top-1/2 transform -translate-y-1/2 h-1 bg-gray-200 z-0 transition-colors">
          </div>
          <div id="stepper-line-right"
            class="absolute left-1/2 right-[calc(50%/3)] top-1/2 transform -translate-y-1/2 h-1 bg-gray-200 z-0 transition-colors">
          </div>
          <ol id="stepper-bar" class="flex w-full z-10 relative">
            <li class="flex-1 flex flex-col items-center stepper-step stepper-step-active relative">
              <span class="flex items-center justify-center w-10 h-10 bg-brand-blue text-white rounded-full z-10">
                <i class="fa-solid fa-address-card"></i>
              </span>
            </li>
            <li class="flex-1 flex flex-col items-center stepper-step relative">
              <span class="flex items-center justify-center w-10 h-10 bg-gray-100 text-gray-500 rounded-full z-10">
                <i class="fa-solid fa-clipboard-list"></i>
              </span>
            </li>
            <li class="flex-1 flex flex-col items-center stepper-step relative">
              <span class="flex items-center justify-center w-10 h-10 bg-gray-100 text-gray-500 rounded-full z-10">
                <i class="fa-solid fa-paper-plane"></i>
              </span>
            </li>
          </ol>
        </div>
        <div class="flex w-full mt-2">
          <div class="flex-1 flex flex-col items-center">
            <span class="font-semibold text-brand-blue text-xs sm:text-sm text-center">Data Diri</span>
          </div>
          <div class="flex-1 flex flex-col items-center">
            <span class="font-semibold text-gray-500 text-xs sm:text-sm text-center">Detail Laporan</span>
          </div>
          <div class="flex-1 flex flex-col items-center">
            <span class="font-semibold text-gray-500 text-xs sm:text-sm text-center">Konfirmasi</span>
          </div>
        </div>
      </div>

      <form id="stepper-form" method="POST" action="{{ route('guest.drainase-irigasi.pengaduan.store') }}"
        enctype="multipart/form-data" novalidate>
        @csrf

        @if ($errors->any())
          <div id="alert-2"
            class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
            role="alert">
            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
              viewBox="0 0 20 20">
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            <button type="button"
              class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
              data-dismiss-target="#alert-2" aria-label="Close">
              <span class="sr-only">Close</span>
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
            </button>
          </div>

          <div id="alert-5"
            class="hidden flex items-center p-4 mb-4 text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300"
            role="alert">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span class="sr-only">Warning</span>
            <div class="ms-3 text-sm font-medium">
              Lokasi dari GPS masih tidak akurat? Silakan pilih lokasi dari peta atau isi lokasi secara manual
            </div>
            <button type="button"
              class="ms-auto -mx-1.5 -my-1.5 bg-yellow-50 text-yellow-500 rounded-lg focus:ring-2 focus:ring-yellow-400 p-1.5 hover:bg-yellow-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-yellow-300 dark:hover:bg-gray-700"
              data-dismiss-target="#alert-5" aria-label="Close">
              <span class="sr-only">Close</span>
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
            </button>
          </div>
        @endif

        {{-- Langkah 1: Data Diri Pelapor --}}
        <div class="stepper-content" data-step="0">
          <div class="space-y-6">
            <div>
              <h2 class="text-xl font-medium text-gray-700 mb-3">Langkah 1: <span class="font-semibold">Data Diri
                  Pelapor</span>
              </h2>
              <hr>
            </div>
            <div class="space-y-4">
              <div class="space-y-1.5">
                <label for="pelapor__nama_lengkap" class="block text-sm font-medium text-gray-900 required">Nama
                  Lengkap</label>
                <input type="text" id="pelapor__nama_lengkap" name="nama_lengkap"
                  class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Contoh: Muhammad Farrel Sirah" required>
                <p id="pelapor__nama_lengkap-explanation" class="text-sm text-gray-500 dark:text-gray-400">Masukkan nama
                  lengkap Anda</p>
                <p class="text-xs text-red-600 mt-1 hidden" id="error_nama_lengkap"></p>
              </div>
              <div class="space-y-1.5">
                <label for="pelapor__pekerjaan"
                  class="block text-sm font-medium text-gray-900 required">Pekerjaan</label>
                <input type="text" id="pelapor__pekerjaan" name="pekerjaan"
                  class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Contoh: Pelajar/Mahasiswa" required>
                <p id="pelapor__pekerjaan-explanation" class="text-sm text-gray-500 dark:text-gray-400">Masukkan
                  pekerjaan Anda</p>
                <p class="text-xs text-red-600 mt-1 hidden" id="error_pekerjaan"></p>
              </div>
              <div class="space-y-1.5">
                <label for="pelapor__alamat" class="block text-sm font-medium text-gray-900 required">Alamat Tempat
                  Tinggal</label>
                <input type="text" id="pelapor__alamat" name="alamat"
                  class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Contoh: Jalan Haji Achmad Amins, no. 123, RT 18, Kelurahan Gunung Lingai, Kecamatan Sungai Pinang"
                  required>
                <p id="pelapor__alamat-explanation" class="text-sm text-gray-500 dark:text-gray-400">Masukkan alamat
                  tempat tinggal Anda</p>
                <p class="text-xs text-red-600 mt-1 hidden" id="error_alamat"></p>
              </div>
              <div class="space-y-1.5">
                <label for="pelapor__nomor_telepon" class="block text-sm font-medium text-gray-900 required">Nomor
                  Telepon</label>
                <input type="text" id="pelapor__nomor_telepon" name="nomor_telepon"
                  class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Contoh: 08123456789" required>
                <p id="pelapor__nomor_telepon-explanation" class="text-sm text-gray-500 dark:text-gray-400">Masukkan
                  nomor telepon Anda yang dapat dihubungi</p>
                <p class="text-xs text-red-600 mt-1 hidden" id="error_nomor_telepon"></p>
              </div>
            </div>
            <div class="flex justify-end">
              <button type="button"
                class="stepper-next flex justify-center items-center gap-1 text-white bg-brand-blue hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg p-2.5 focus:outline-none text-xs xs:text-sm sm:text-base">
                <i class="fa-solid fa-circle-right"></i> Selanjutnya
              </button>
            </div>
          </div>
        </div>

        {{-- Langkah 2: Detail Laporan --}}
        <div class="stepper-content hidden" data-step="1">
          <div class="space-y-6">
            <div>
              <h2 class="text-xl font-medium text-gray-700 mb-3">Langkah 2: <span class="font-semibold">Detail
                  Laporan</span>
              </h2>
              <hr>
            </div>

            <div class="space-y-4">
              <div class="border-dashed border-2 bg-gray-50 p-4 rounded-lg">
                <div id="alert-2"
                  class="hidden flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                  role="alert">
                  <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                  </svg>
                  <span class="sr-only">Info</span>
                  <div class="ms-3 text-sm font-medium">
                    Ini jika gagal mengambil data secara otomatis
                  </div>
                  <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-2" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                      viewBox="0 0 14 14">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                  </button>
                </div>
                <div id="alert-3"
                  class="hidden flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                  role="alert">
                  <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                  </svg>
                  <span class="sr-only">Info</span>
                  <div class="ms-3 text-sm font-medium">
                    Ini jika berhasil mengambil data secara otomatis
                  </div>
                  <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-3" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                      viewBox="0 0 14 14">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                  </button>
                </div>
                <div id="alert-4"
                  class="hidden flex items-center p-4 mb-4 text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-300"
                  role="alert">
                  <i class="fa-solid fa-spinner"></i>
                  <span class="sr-only">Info</span>
                  <div class="ms-3 text-sm font-medium">
                    Pengambilan data sedang diproses
                  </div>
                </div>

                <div id="alert-5"
                  class="hidden flex items-center p-4 mb-4 text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300"
                  role="alert">
                  <i class="fa-solid fa-triangle-exclamation"></i>
                  <span class="sr-only">Warning</span>
                  <div class="ms-3 text-sm font-medium">
                    Lokasi dari GPS masih tidak akurat? Silakan pilih lokasi dari peta atau isi lokasi secara manual
                  </div>
                  <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-yellow-50 text-yellow-500 rounded-lg focus:ring-2 focus:ring-yellow-400 p-1.5 hover:bg-yellow-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-yellow-300 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-5" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                      viewBox="0 0 14 14">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                  </button>
                </div>

                <div class="space-y-4">
                  <div class="flex flex-col gap-1.5">
                    <p class="text-sm sm:text-base text-gray-600">
                      Anda dapat <b>memilih lokasi secara otomatis</b> menggunakan <b>posisi Anda saat ini (GPS)</b>
                      maupun
                      <b>dari peta</b>
                    </p>
                    <div class="flex flex-col sm:flex-row gap-2">
                      <button type="button" id="detect-location-gps-btn"
                        class="flex-1 items-center px-3 py-2 rounded-lg border border-primary-500 text-white bg-brand-blue hover:opacity-90 transition text-sm font-medium"
                        title="Gunakan lokasi sekarang">
                        <i class="fa-solid fa-location-crosshairs mr-1.5"></i>
                        Gunakan lokasi sekarang
                      </button>
                      <button type="button" id="select-location-map-btn"
                        class="flex-1 items-center px-3 py-2 rounded-lg border border-primary-500 text-white bg-brand-blue hover:opacity-90 transition text-sm font-medium"
                        data-modal-target="modal-pilih-lokasi-peta" data-modal-toggle="modal-pilih-lokasi-peta"
                        aria-haspopup="dialog" aria-expanded="false" aria-controls="modal-pilih-lokasi-peta"
                        title="Pilih lokasi dari peta">
                        <i class="fa-solid fa-map-location-dot mr-1.5"></i>
                        Pilih lokasi dari peta
                      </button>
                    </div>
                    <p class="text-sm sm:text-base text-gray-600">
                      atau <b>mengisi lokasi secara manual</b> di bawah ini.
                    </p>
                  </div>

                  <div class="flex flex-col md:flex-row gap-4">
                    <div class="space-y-1 flex-1">
                      <label for="laporan__kecamatan" class="block text-sm font-medium text-gray-900 required">
                        Kecamatan
                      </label>
                      <select id="laporan__kecamatan" name="kecamatan_id"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                        <option selected disabled>Pilih kecamatan</option>
                        @foreach ($kecamatan as $kec)
                          <option value="{{ $kec->id }}">{{ $kec->nama }}</option>
                        @endforeach
                      </select>
                      <p id="laporan__kecamatan-explanation" class="text-sm text-gray-500 dark:text-gray-400">
                        Pilih kecamatan lokasi kerusakan.
                      </p>
                      <p class="text-xs text-red-600 mt-1 hidden" id="error_kecamatan_id"></p>
                    </div>

                    <div class="space-y-1 flex-1">
                      <label for="laporan__kelurahan" class="block text-sm font-medium text-gray-900 required">
                        Kelurahan
                      </label>
                      <select id="laporan__kelurahan" name="kelurahan_id"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:bg-gray-100"
                        required disabled>
                        <option selected disabled>Pilih kecamatan terlebih dahulu</option>
                        @foreach ($kelurahan as $kel)
                          <option value="{{ $kel->id }}" data-kecamatan="{{ $kel->kecamatan_id }}">
                            {{ $kel->nama }}
                          </option>
                        @endforeach
                      </select>
                      <p id="laporan__kelurahan-explanation" class="text-sm text-gray-500 dark:text-gray-400">
                        Pilih kelurahan lokasi kerusakan.
                      </p>
                      <p class="text-xs text-red-600 mt-1 hidden" id="error_kelurahan_id"></p>
                    </div>
                  </div>

                  <div class="space-y-1.5">
                    <label for="laporan__nama_jalan" class="block text-sm font-medium text-gray-900 required">
                      Nama Jalan
                    </label>
                    <div class="relative">
                      <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                      </div>
                      <input type="search" id="laporan__nama_jalan" name="nama_jalan"
                        class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:bg-gray-100"
                        placeholder="Pilih kelurahan terlebih dahulu" autocomplete="off" required disabled />
                      <ul id="nama-jalan-autocomplete"
                        class="absolute z-20 bg-white border border-gray-300 rounded-lg mt-1 w-full hidden"></ul>
                    </div>
                    <p id="laporan__nama_jalan-explanation" class="text-sm text-gray-500 dark:text-gray-400">
                      Ketik nama jalan lokasi kerusakan.
                    </p>
                    <p class="text-xs text-red-600 mt-1 hidden" id="error_nama_jalan"></p>
                  </div>

                  <div class="space-y-1.5">
                    <label for="laporan__koordinat" class="block text-sm font-medium text-gray-900 required">Link Titik
                      Koordinat Google Maps</label>
                    <input type="text" id="laporan__koordinat" name="koordinat"
                      class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                      placeholder="Contoh: https://maps.google.com/maps?q=-0.1234567,117.1234567" required>
                    <p id="laporan__koordinat-explanation" class="text-sm text-gray-500 dark:text-gray-400">
                      Masukkan link Google Maps yang mengarahkan ke titik lokasi kerusakan.
                    </p>
                    <p class="text-xs text-red-600 mt-1 hidden" id="error_koordinat"></p>

                    <!-- Hidden fields for longitude and latitude to be submitted to backend -->
                    <input type="hidden" id="laporan__longitude" name="longitude">
                    <input type="hidden" id="laporan__latitude" name="latitude">
                  </div>

                  <div class="flex gap-1.5 flex-row text-sm sm:text-base">
                    <i class="fa-solid fa-circle-question text-gray-600 mt-1"></i>
                    <p class="text-gray-600">
                      <b>Data yang dipilih secara otomatis tidak akurat?</b> Silakan isi data tersebut secara manual.
                    </p>
                  </div>
                </div>
              </div>

              <!-- Modal Pilih Lokasi dari Peta (Flowbite style) -->
              <div id="modal-pilih-lokasi-peta" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                  <!-- Modal content -->
                  <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex justify-between items-center p-5 border-b rounded-t">
                      <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        Pilih Lokasi dari Peta
                      </h3>
                      <button type="button"
                        class="text-gray-400 hover:bg-gray-100 hover:text-gray-900 rounded-lg p-1.5 ml-auto inline-flex items-center"
                        data-modal-hide="modal-pilih-lokasi-peta" aria-label="Close">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                          viewBox="0 0 14 14">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                      </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-4">
                      <div class="w-full h-60 sm:h-80 rounded-lg border overflow-hidden">
                        <div id="map-container" class="w-full h-full"></div>
                      </div>
                      <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                          <label for="modal-koordinat" class="block text-sm font-medium text-gray-900 required mb-1">
                            Link Titik Koordinat Google Maps
                          </label>
                          <input type="text" id="modal-koordinat" name="modal_koordinat"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Akan diisi otomatis saat memilih titik pada peta" readonly>
                        </div>
                      </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex justify-start gap-3 p-4 md:p-5 border-t border-gray-200 rounded-b flex-col sm:flex-row">
                      <button type="button" id="btn-set-location-from-map"
                        class="text-white bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 disabled:opacity-80 flex items-center"
                        disabled>
                        <i class="fa-solid fa-location-dot mr-1"></i>Pilih Lokasi Ini
                      </button>
                      <button type="button"
                        class="text-gray-600 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:ring-gray-300 rounded-lg text-sm px-4 py-2.5 inline-flex items-center"
                        data-modal-hide="modal-pilih-lokasi-peta">
                        <i class="fa-solid fa-xmark mr-1"></i>Tutup
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div id="laporan__foto_group">
                <label class="block text-sm font-medium text-gray-700 mb-1 required" for="laporan__foto_input[]">
                  Foto Kerusakan
                </label>

                <div id="laporan__foto_input_list" class="flex flex-row gap-2 overflow-x-auto">
                  <div
                    class="relative group laporan__foto_item_wrapper h-28 sm:h-32 mb-2 min-w-[calc(7rem*16/9)] max-w-[calc(8rem*16/9)] flex-shrink-0 aspect-[16/9]">
                    <label
                      class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0 aspect-[16/9]">
                      <div class="laporan__foto_placeholder flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor"
                          viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
                        </svg>
                        <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload foto</p>
                        <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (maks 2MB)</p>
                      </div>
                      <img
                        class="laporan__foto_preview hidden absolute inset-0 w-full h-full object-contain rounded-lg bg-white aspect-[16/9]" />
                      <input name="laporan__foto_input[]" type="file" accept="image/*"
                        class="hidden laporan__foto_file_input" />
                    </label>

                    <button type="button"
                      class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove_laporan__foto_btn hidden"
                      title="Hapus foto">
                      <i class="fa-solid fa-xmark"></i>
                    </button>

                    <button type="button"
                      class="w-[30px] h-[30px] bg-white rounded-full text-green-600 hover:text-green-800 shadow-lg border border-black flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-10 revert_laporan__foto_btn hidden"
                      title="Kembalikan foto sebelumnya">
                      <i class="fa-solid fa-rotate-right"></i>
                    </button>

                    <a type="button"
                      class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 edit_laporan__foto_btn hidden"
                      title="Edit foto">
                      <i class="fa-solid fa-crop-simple"></i>
                    </a>

                    <button type="button"
                      class="w-[30px] h-[30px] bg-white rounded-full text-blue-600 hover:text-blue-800 shadow-lg border border-black flex items-center justify-center absolute top-2 left-2 z-10 add_laporan__foto_btn"
                      title="Tambah foto">
                      <i class="fa-solid fa-plus"></i>
                    </button>
                  </div>
                </div>

                <p id="laporan__foto_explanation" class="text-sm text-gray-500 dark:text-gray-400">
                  Anda dapat mengunggah lebih dari satu foto dengan menekan tombol "+".
                </p>
                <p class="text-xs text-red-600 mt-1 hidden" id="error_foto"></p>
              </div>

              <div class="space-y-1.5">
                <label for="laporan__detail_lokasi" class="block text-sm font-medium text-gray-900 required">
                  Detail Lokasi
                </label>
                <textarea id="laporan__detail_lokasi" name="detail_lokasi"
                  class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Contoh: Dekat toko roti Amansa, gang 4, no. 123" rows="2" required></textarea>
                <p id="laporan__detail_lokasi-explanation" class="text-sm text-gray-500 dark:text-gray-400">
                  Masukkan detail lengkap lokasi, sertakan juga patokan bangunan terdekat untuk memudahkan
                  pencarian.
                </p>
                <p class="text-xs text-red-600 mt-1 hidden" id="error_detail_lokasi"></p>
              </div>

              <div class="space-y-1.5">
                <label for="laporan__deskripsi" class="block text-sm font-medium text-gray-900 required">Deskripsi
                  Pengaduan</label>
                <textarea id="laporan__deskripsi" name="deskripsi_pengaduan"
                  class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Contoh: Parit tersumbat sampah, air tidak mengalir dengan baik" rows="3" required></textarea>
                <p id="laporan__deskripsi-explanation" class="text-sm text-gray-500 dark:text-gray-400">Jelaskan kondisi
                  pengaduan.</p>
                <p class="text-xs text-red-600 mt-1 hidden" id="error_deskripsi_pengaduan"></p>
              </div>
            </div>
            <div class="flex justify-between">
              <button type="button"
                class="stepper-prev flex justify-center items-center gap-1 text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-blue-300 rounded-lg p-2.5 focus:outline-none text-xs xs:text-sm sm:text-base">
                <i class="fa-solid fa-circle-left"></i> Sebelumnya
              </button>
              <button type="button"
                class="stepper-next flex justify-center items-center gap-1 text-white bg-brand-blue hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg p-2.5 focus:outline-none text-xs xs:text-sm sm:text-base">
                <i class="fa-solid fa-circle-right"></i> Selanjutnya
              </button>
            </div>
          </div>
        </div>

        {{-- Langkah 3: Konfirmasi --}}
        <div class="stepper-content hidden" data-step="2">
          <div class="space-y-6">
            <div>
              <h2 class="text-xl font-medium text-gray-700 mb-3">Langkah 3: <span
                  class="font-semibold">Konfirmasi</span>
              </h2>
              <hr>
            </div>
            <div class="space-y-1.5">
              <p class="block text-sm font-medium text-gray-900 required">Rating</p>
              <div class="flex">
                <div class="flex items-center me-4">
                  <input id="rating-1" type="radio" value="1" name="skm__rating"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                  <label for="rating-1"
                    class="ms-2 text-xs xs:text-sm sm:text-base font-medium text-gray-900 dark:text-gray-300">
                    Tidak Puas
                  </label>
                </div>
                <div class="flex items-center me-4">
                  <input id="rating-2" type="radio" value="2" name="skm__rating"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                  <label for="rating-2"
                    class="ms-2 text-xs xs:text-sm sm:text-base font-medium text-gray-900 dark:text-gray-300">
                    Biasa Saja
                  </label>
                </div>
                <div class="flex items-center me-4">
                  <input id="rating-3" type="radio" value="3" name="skm__rating"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                  <label for="rating-3"
                    class="ms-2 text-xs xs:text-sm sm:text-base font-medium text-gray-900 dark:text-gray-300">
                    Puas
                  </label>
                </div>
                <div class="flex items-center me-4">
                  <input id="rating-4" type="radio" value="4" name="skm__rating"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                  <label for="rating-4"
                    class="ms-2 text-xs xs:text-sm sm:text-base font-medium text-gray-900 dark:text-gray-300">
                    Sangat Puas
                  </label>
                </div>
              </div>
              <p id="skm__rating" class="text-sm text-gray-500 dark:text-gray-400">
                Gunakan skala 1-4 untuk menilai seberapa puas Anda terhadap aplikasi layanan kami.
              </p>
              <p class="text-xs text-red-600 mt-1 hidden" id="error_skm__rating"></p>
            </div>
            <div class="space-y-1.5">
              <label for="skm__kritik" class="block text-sm font-medium text-gray-900 required">
                Kritik
              </label>
              <textarea id="skm__kritik" name="skm__kritik"
                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Contoh: Tampilan aplikasi masih membingungkan" rows="2" required></textarea>
              <p id="skm__kritik" class="text-sm text-gray-500 dark:text-gray-400">
                Masukkan kritik terkait aplikasi layanan ini.
              </p>
              <p class="text-xs text-red-600 mt-1 hidden" id="error_skm__kritik"></p>
            </div>
            <div class="space-y-1.5">
              <label for="skm__saran" class="block text-sm font-medium text-gray-900 required">
                Saran
              </label>
              <textarea id="skm__saran" name="skm__saran"
                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Contoh: Sediakan buku panduan untuk mengisi formulir ini" rows="2" required></textarea>
              <p id="skm__saran" class="text-sm text-gray-500 dark:text-gray-400">
                Masukkan saran terkait aplikasi layanan ini.
              </p>
              <p class="text-xs text-red-600 mt-1 hidden" id="error_skm__saran"></p>
            </div>
            <div class="space-y-1.5">
              <p class="block text-sm font-medium text-gray-900 required">Silakan centang kotak di bawah ini</p>
              <div class="flex items-center ps-4 border border-gray-200 rounded-lg">
                <input id="bordered-checkbox-2" type="checkbox" value="1" name="bordered-checkbox"
                  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                <label for="bordered-checkbox-2" class="w-full py-4 ms-2 text-gray-900 text-sm">Saya menyatakan bahwa
                  informasi yang saya berikan benar dan dapat dipertanggungjawabkan.</label>
              </div>
              <p class="text-xs text-red-600 mt-1 hidden" id="error_bordered-checkbox"></p>
            </div>
            <div class="flex justify-between">
              <button type="button"
                class="stepper-prev flex justify-center items-center gap-1 text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-blue-300 rounded-lg p-2.5 focus:outline-none text-xs xs:text-sm sm:text-base">
                <i class="fa-solid fa-circle-left"></i> Sebelumnya
              </button>
              <button type="submit"
                class="stepper-submit flex justify-center items-center gap-1 text-white bg-brand-blue hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg p-2.5 focus:outline-none disabled:opacity-80 text-xs xs:text-sm sm:text-base"
                disabled>
                <i class="fa-solid fa-paper-plane fa-sm"></i> Kirim
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="max-w-[940px] mx-auto mt-3 ps-1 text-sm text-gray-500">
      <span class="text-red-500">*</span> Wajib diisi
    </div>
  </div>

  <!-- Tambahkan modal cropperjs untuk foto kerusakan -->
  <div id="cropperModalFoto" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl relative mx-4 md:mx-5">
      <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
        <h3 class="text-xl font-semibold text-gray-900">
          Crop Foto
        </h3>
      </div>
      <div class="m-4 md:m-5 flex justify-center items-center" style="min-height:200px;">
        <img id="image-to-crop-foto" src="" class="max-h-[50vh] max-w-full block rounded border"
          alt="Image to crop" style="background:#f3f4f6;" />
      </div>
      <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b space-x-3">
        <button type="button" id="crop-foto-confirm-btn" class="px-4 py-2 bg-blue-700 text-white rounded">
          Crop & Gunakan
        </button>
        <button type="button" id="crop-foto-cancel-btn" class="px-4 py-2 bg-gray-300 rounded">
          Batal
        </button>
      </div>
    </div>
  </div>
@endsection

@section('document.end')
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.3/viewer.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.3/viewer.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Enable/disable submit button based on checkbox
      const agreementCheckbox = document.getElementById('bordered-checkbox-2');
      const submitButton = document.querySelector('.stepper-submit');

      if (agreementCheckbox && submitButton) {
        // Initial state - check if checkbox is already checked when page loads
        submitButton.disabled = !agreementCheckbox.checked;

        // Listen for changes to checkbox
        agreementCheckbox.addEventListener('change', function() {
          submitButton.disabled = !this.checked;
        });
      }

      // Filter kelurahan sesuai kecamatan (tanpa API)
      const kecSelect = document.getElementById('laporan__kecamatan');
      const kelSelect = document.getElementById('laporan__kelurahan');
      const namaJalanInput = document.getElementById('laporan__nama_jalan');
      const kelOptions = Array.from(kelSelect.querySelectorAll('option[data-kecamatan]'));

      // Inisialisasi: kelurahan dan nama jalan disabled
      kelSelect.disabled = true;
      kelSelect.classList.add('disabled:bg-gray-100');
      kelSelect.innerHTML = '<option selected disabled>Pilih kecamatan terlebih dahulu</option>' +
        kelOptions.map(opt => opt.outerHTML).join('');
      namaJalanInput.disabled = true;
      namaJalanInput.classList.add('disabled:bg-gray-100');
      namaJalanInput.placeholder = 'Pilih kelurahan terlebih dahulu';

      kecSelect.addEventListener('change', function() {
        const kecId = this.value;
        kelSelect.innerHTML = '<option selected disabled>Pilih kelurahan</option>';
        kelOptions.forEach(opt => {
          if (opt.getAttribute('data-kecamatan') === kecId) {
            kelSelect.appendChild(opt.cloneNode(true));
          }
        });
        kelSelect.disabled = false;
        kelSelect.classList.remove('disabled:bg-gray-100');
        // Reset nama jalan
        namaJalanInput.value = '';
        namaJalanInput.disabled = true;
        namaJalanInput.classList.add('disabled:bg-gray-100');
        namaJalanInput.placeholder = 'Pilih kelurahan terlebih dahulu';
      });

      kelSelect.addEventListener('change', function() {
        if (kelSelect.value) {
          namaJalanInput.disabled = false;
          namaJalanInput.classList.remove('disabled:bg-gray-100');
          namaJalanInput.placeholder = 'Contoh: Insinyur Haji Juanda';
        } else {
          namaJalanInput.value = '';
          namaJalanInput.disabled = true;
          namaJalanInput.classList.add('disabled:bg-gray-100');
          namaJalanInput.placeholder = 'Pilih kelurahan terlebih dahulu';
        }
      });

      // Nama jalan autocomplete langsung dari Overpass API OSM
      let jalanTimeout;
      document.getElementById('laporan__nama_jalan').addEventListener('input', function() {
        clearTimeout(jalanTimeout);
        const query = this.value;
        const kelSelect = document.getElementById('laporan__kelurahan');
        const kelurahanNama = kelSelect.options[kelSelect.selectedIndex]?.text;
        if (query.length < 3 || !kelSelect.value) {
          document.getElementById('nama-jalan-autocomplete').classList.add('hidden');
          return;
        }
        jalanTimeout = setTimeout(() => {
          // Query Overpass API: cari jalan di kelurahan, LIKE %namajalan%
          const overpassQuery = `
            [out:json][timeout:25];
            area["name"="${kelurahanNama}"]["boundary"="administrative"];
            (
              way(area)["highway"]["name"~".*${query}.*",i];
            );
            out tags center;
          `;
          fetch('https://overpass-api.de/api/interpreter', {
              method: 'POST',
              body: overpassQuery,
              headers: {
                'Content-Type': 'text/plain'
              }
            })
            .then(res => res.json())
            .then(data => {
              const ul = document.getElementById('nama-jalan-autocomplete');
              ul.innerHTML = '';
              if (!data.elements || data.elements.length === 0) {
                ul.classList.add('hidden');
                return;
              }
              // Tampilkan nama jalan unik, filter yang bukan "Gang"
              const names = [...new Set(
                data.elements
                .map(e => e.tags.name)
                .filter(nama => nama && !/gang/i.test(nama))
              )];
              names.forEach(nama => {
                const li = document.createElement('li');
                li.textContent = nama;
                li.className = 'px-3 py-2 cursor-pointer hover:bg-gray-100';
                li.addEventListener('click', function() {
                  document.getElementById('laporan__nama_jalan').value = nama;
                  ul.classList.add('hidden');
                });
                ul.appendChild(li);
              });
              ul.classList.toggle('hidden', names.length === 0);
            });
        }, 400);
      });

      // Hide autocomplete on blur
      document.getElementById('laporan__nama_jalan').addEventListener('blur', function() {
        setTimeout(() => document.getElementById('nama-jalan-autocomplete').classList.add('hidden'), 200);
      });

      // Helper untuk alert (gunakan hidden/flex, timeout reset)
      const alertTimeouts = {};

      function showAlert(id, message) {
        const el = document.getElementById(id);
        if (!el) return;
        if (message !== undefined && el.querySelector('.font-medium')) {
          el.querySelector('.font-medium').textContent = message;
        }
        // Jika alert-4 (loading), tutup alert lain
        if (id === 'alert-4') {
          hideAlert('alert-2');
          hideAlert('alert-3');
          hideAlert('alert-5');
        }
        el.classList.replace('hidden', 'flex');
        // Clear previous timeout if exists
        if (alertTimeouts[id]) {
          clearTimeout(alertTimeouts[id]);
        }
        // Only set timeout for alert-2 and alert-3 (not for loading alert-4)
        if (id === 'alert-2' || id === 'alert-3') {
          alertTimeouts[id] = setTimeout(() => {
            el.classList.replace('flex', 'hidden');
            alertTimeouts[id] = null;
          }, 5000);
        }
      }

      function hideAlert(id) {
        const el = document.getElementById(id);
        if (el) el.classList.replace('flex', 'hidden');
        if (alertTimeouts[id]) {
          clearTimeout(alertTimeouts[id]);
          alertTimeouts[id] = null;
        }
      }
      // Tombol close alert
      document.querySelectorAll('[data-dismiss-target]').forEach(btn => {
        btn.addEventListener('click', function() {
          const target = btn.getAttribute('data-dismiss-target');
          hideAlert(target.replace('#', ''));
        });
      });

      // GPS detection + auto fill kecamatan, kelurahan, nama jalan + alert
      document.getElementById('detect-location-gps-btn').addEventListener('click', function() {
        showAlert('alert-4'); // tampilkan loading
        if (navigator.geolocation) {
          const positionOptions = {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
          };

          navigator.geolocation.getCurrentPosition(function(pos) {
            // Check if accuracy is acceptable (less than 100 meters is considered accurate enough)
            if (pos.coords.accuracy > 100) {
              hideAlert('alert-4');
              showAlert('alert-2', 'GPS gagal mendapatkan lokasi akurat. Periksa pengaturan lokasi Anda.');
              showAlert('alert-5'); // Show the yellow suggestion alert
              return; // Stop processing if location isn't accurate enough
            }

            const lon = pos.coords.longitude.toFixed(7); // Format to 7 decimal places
            const lat = pos.coords.latitude.toFixed(7); // Format to 7 decimal places

            // Set hidden fields
            document.getElementById('laporan__longitude').value = lon;
            document.getElementById('laporan__latitude').value = lat;

            // Generate and set Google Maps URL
            const mapsUrl = generateGoogleMapsUrl(lat, lon);
            document.getElementById('laporan__koordinat').value = mapsUrl;

            // Call our backend endpoint instead of Nominatim directly
            fetch(`/api/reverse-geocode?lat=${lat}&lon=${lon}`)
              .then(res => res.json())
              .then(data => {
                hideAlert('alert-4'); // hide loading
                // Kecamatan
                if (data.address && data.address.suburb) {
                  selectKecamatanByName(data.address.suburb);
                } else if (data.address && data.address.city_district) {
                  selectKecamatanByName(data.address.city_district);
                }
                // Kelurahan
                if (data.address && data.address.village) {
                  selectKelurahanByName(data.address.village);
                } else if (data.address && data.address.neighbourhood) {
                  selectKelurahanByName(data.address.neighbourhood);
                }
                // Nama jalan: enable dan isi
                const namaJalanInput = document.getElementById('laporan__nama_jalan');
                namaJalanInput.disabled = false;
                namaJalanInput.classList.remove('disabled:bg-gray-100');
                if (data.address && data.address.road) {
                  namaJalanInput.value = data.address.road;
                }
                showAlert('alert-3',
                  'Data berhasil diisi secara otomatis menggunakan posisi Anda saat ini (GPS)');
              })
              .catch(function() {
                hideAlert('alert-4');
                showAlert('alert-2', 'Gagal mengambil data otomatis dari GPS. Silakan isi manual.');
              });
          }, function(error) {
            hideAlert('alert-4');
            // More detailed error message based on the error code
            let errorMessage = 'Gagal mendeteksi lokasi GPS. Silakan isi manual.';

            if (error.code === 1) {
              errorMessage = 'Akses lokasi ditolak. Mohon berikan izin lokasi dan coba lagi.';
            } else if (error.code === 2) {
              errorMessage = 'Posisi tidak tersedia. Silakan isi manual.';
            } else if (error.code === 3) {
              errorMessage = 'Waktu deteksi lokasi habis. Silakan coba lagi.';
            }

            showAlert('alert-2', errorMessage);
          }, positionOptions);
        } else {
          hideAlert('alert-4');
          showAlert('alert-2', 'Browser tidak mendukung geolokasi. Silakan isi manual.');
        }
      });

      // Modal pilih lokasi dari peta (Flowbite + Leaflet) + auto fill + alert
      let map, marker;
      let mapSelectedLatLng = null;

      function showMapModal() {
        if (!map) {
          map = L.map('map-container').setView([-0.5, 117.15], 12);
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
          }).addTo(map);
          map.on('click', function(e) {
            if (marker) map.removeLayer(marker);
            marker = L.marker(e.latlng).addTo(map);
            const lat = e.latlng.lat.toFixed(7);
            const lng = e.latlng.lng.toFixed(7);

            // Generate Google Maps URL for modal
            const mapsUrl = generateGoogleMapsUrl(lat, lng);
            document.getElementById('modal-koordinat').value = mapsUrl;

            mapSelectedLatLng = e.latlng; // simpan latlng, belum fetch reverse
            document.getElementById('btn-set-location-from-map').disabled = false;
          });
        }
        setTimeout(() => map.invalidateSize(), 300);
      }
      // Tambahkan pengecekan elemen sebelum addEventListener
      const selectLocationMapBtn = document.getElementById('select-location-map-btn');
      if (selectLocationMapBtn) {
        selectLocationMapBtn.addEventListener('click', function() {
          showMapModal();
        });
      }

      const btnSetLocationFromMap = document.getElementById('btn-set-location-from-map');
      if (btnSetLocationFromMap) {
        btnSetLocationFromMap.addEventListener('click', function() {
          // Set the main form Google Maps URL field
          document.getElementById('laporan__koordinat').value = document.getElementById('modal-koordinat').value;

          // Set the hidden longitude/latitude fields
          const lat = mapSelectedLatLng.lat.toFixed(7);
          const lng = mapSelectedLatLng.lng.toFixed(7);
          document.getElementById('laporan__longitude').value = lng;
          document.getElementById('laporan__latitude').value = lat;

          // Mulai proses reverse geocoding setelah tombol ditekan
          if (mapSelectedLatLng) {
            showAlert('alert-4'); // tampilkan loading

            // Call our backend endpoint instead of Nominatim directly
            fetch(`/api/reverse-geocode?lat=${lat}&lon=${lng}`)
              .then(res => res.json())
              .then(data => {
                hideAlert('alert-4');
                // Kecamatan
                if (data.address && data.address.suburb) {
                  selectKecamatanByName(data.address.suburb);
                } else if (data.address && data.address.city_district) {
                  selectKecamatanByName(data.address.city_district);
                }
                // Kelurahan
                if (data.address && data.address.village) {
                  selectKelurahanByName(data.address.village);
                } else if (data.address && data.address.neighbourhood) {
                  selectKelurahanByName(data.address.neighbourhood);
                }
                // Nama jalan: enable dan isi
                const namaJalanInput = document.getElementById('laporan__nama_jalan');
                namaJalanInput.disabled = false;
                namaJalanInput.classList.remove('disabled:bg-gray-100');
                if (data.address && data.address.road) {
                  namaJalanInput.value = data.address.road;
                }
                showAlert('alert-3', 'Data berhasil diisi secara otomatis melalui peta');
              })
              .catch(function() {
                hideAlert('alert-4');
                showAlert('alert-2', 'Gagal mengambil data otomatis dari peta. Silakan isi manual.');
              });
          }
          // Tutup modal jika ada
          const modalHideBtn = document.querySelector('[data-modal-hide="modal-pilih-lokasi-peta"]');
          if (modalHideBtn) modalHideBtn.click();
        });
      }

      // Helper: pilih kecamatan berdasarkan nama
      function selectKecamatanByName(name) {
        const kecSelect = document.getElementById('laporan__kecamatan');
        for (const opt of kecSelect.options) {
          if (opt.text.trim().toLowerCase() === name.trim().toLowerCase()) {
            kecSelect.value = opt.value;
            kecSelect.dispatchEvent(new Event('change'));
            break;
          }
        }
      }
      // Helper: pilih kelurahan berdasarkan nama
      function selectKelurahanByName(name) {
        const kelSelect = document.getElementById('laporan__kelurahan');
        for (const opt of kelSelect.options) {
          if (opt.text.trim().toLowerCase() === name.trim().toLowerCase()) {
            kelSelect.value = opt.value;
            break;
          }
        }
      }

      // === STEPPER VALIDATION LOGIC ===
      function showError(input, message) {
        if (!input) return;

        // Add only a simple red border - no rings or backgrounds
        input.classList.add('border-red-500');

        // No special styling for selects and textareas anymore
        // Remove any existing ring classes to ensure consistency
        input.classList.remove('ring', 'ring-1', 'ring-2', 'ring-red-300', 'ring-red-400');

        if (input.type === 'file') {
          const label = input.closest('label');
          if (label) label.classList.add('border-red-500');
        }

        // Find the error message element - handle special cases first
        let errorElement = null;

        // Special cases
        if (input.id === 'laporan__kecamatan' || input.name === 'kecamatan_id') {
          errorElement = document.getElementById('error_kecamatan_id');
        } else if (input.id === 'laporan__kelurahan' || input.name === 'kelurahan_id') {
          errorElement = document.getElementById('error_kelurahan_id');
        } else if (input.id === 'laporan__detail_lokasi') {
          errorElement = document.getElementById('error_detail_lokasi');
        } else if (input.id === 'laporan__deskripsi') {
          errorElement = document.getElementById('error_deskripsi_pengaduan');
        }

        // Standard cases
        else if (input.name && document.getElementById('error_' + input.name)) {
          errorElement = document.getElementById('error_' + input.name);
        } else if (input.id && document.getElementById('error_' + input.id)) {
          errorElement = document.getElementById('error_' + input.id);
        }

        // Display the error message
        if (errorElement) {
          errorElement.textContent = message;
          errorElement.classList.remove('hidden');
        }
      }

      function clearError(input) {
        if (!input) return;

        // Remove all error styling completely
        input.classList.remove('border-red-500', 'bg-red-50');

        // Remove any ring classes that might be present
        input.classList.remove('ring', 'ring-1', 'ring-2', 'ring-red-300', 'ring-red-400');

        // Restore default border color
        input.classList.remove('border-red-500');
        input.classList.add('border-gray-300');

        if (input.type === 'file') {
          const label = input.closest('label');
          if (label) {
            label.classList.remove('border-red-500');
            label.classList.add('border-gray-300');
          }
        }

        // Find the error message element - handle special cases first
        let errorElement = null;

        // Special cases
        if (input.id === 'laporan__kecamatan' || input.name === 'kecamatan_id') {
          errorElement = document.getElementById('error_kecamatan_id');
        } else if (input.id === 'laporan__kelurahan' || input.name === 'kelurahan_id') {
          errorElement = document.getElementById('error_kelurahan_id');
        } else if (input.id === 'laporan__detail_lokasi') {
          errorElement = document.getElementById('error_detail_lokasi');
        } else if (input.id === 'laporan__deskripsi') {
          errorElement = document.getElementById('error_deskripsi_pengaduan');
        }

        // Standard cases
        else if (input.name && document.getElementById('error_' + input.name)) {
          errorElement = document.getElementById('error_' + input.name);
        } else if (input.id && document.getElementById('error_' + input.id)) {
          errorElement = document.getElementById('error_' + input.id);
        }

        // Hide the error message
        if (errorElement) {
          errorElement.textContent = '';
          errorElement.classList.add('hidden');
        }
      }

      function validateStep(stepIdx) {
        let valid = true;
        // Step 0: Data Diri
        if (stepIdx === 0) {
          const nama = document.getElementById('pelapor__nama_lengkap');
          const pekerjaan = document.getElementById('pelapor__pekerjaan');
          const alamat = document.getElementById('pelapor__alamat');
          const telp = document.getElementById('pelapor__nomor_telepon');
          // Nama
          if (!nama.value.trim()) {
            showError(nama, 'Nama lengkap wajib diisi.');
            valid = false;
          } else {
            clearError(nama);
          }
          // Pekerjaan
          if (!pekerjaan.value.trim()) {
            showError(pekerjaan, 'Pekerjaan wajib diisi.');
            valid = false;
          } else {
            clearError(pekerjaan);
          }
          // Alamat
          if (!alamat.value.trim()) {
            showError(alamat, 'Alamat wajib diisi.');
            valid = false;
          } else {
            clearError(alamat);
          }
          // Nomor telepon
          if (!telp.value.trim()) {
            showError(telp, 'Nomor telepon wajib diisi.');
            valid = false;
          } else if (!/^08[0-9]{8,13}$/.test(telp.value.trim())) {
            showError(telp, 'Nomor telepon harus diawali 08 dan terdiri dari 10-15 digit.');
            valid = false;
          } else {
            clearError(telp);
          }
        }
        // Step 1: Detail Laporan

        if (stepIdx === 1) {
          const kec = document.getElementById('laporan__kecamatan');
          const kel = document.getElementById('laporan__kelurahan');
          const jalan = document.getElementById('laporan__nama_jalan');
          const koordinat = document.getElementById('laporan__koordinat');
          const detail = document.getElementById('laporan__detail_lokasi');
          const desk = document.getElementById('laporan__deskripsi');

          // Kecamatan validation - improved messaging
          if (!kec.value || kec.selectedIndex === 0) {
            showError(kec, 'Kecamatan wajib dipilih.');
            valid = false;
          } else {
            clearError(kec);
          }

          // Kelurahan validation - improved messaging
          if (!kel.value || kel.selectedIndex === 0) {
            showError(kel, 'Kelurahan wajib dipilih.');
            valid = false;
          } else {
            clearError(kel);
          }

          // Nama jalan
          if (!jalan.value.trim()) {
            showError(jalan, 'Nama jalan wajib diisi.');
            valid = false;
          } else {
            clearError(jalan);
          }

          // Koordinat validation - validate Google Maps link and extract coordinates
          if (!koordinat.value.trim()) {
            showError(koordinat, 'Link titik koordinat wajib diisi.');
            valid = false;
          } else {
            const coords = parseGoogleMapsUrl(koordinat.value.trim());
            if (!coords) {
              showError(koordinat,
                'Format link Google Maps tidak valid. Contoh: https://maps.google.com/maps?q=-0.1234567,117.1234567'
              );
              valid = false;
            } else {
              // Set hidden fields when valid
              document.getElementById('laporan__longitude').value = coords.longitude.toFixed(7);
              document.getElementById('laporan__latitude').value = coords.latitude.toFixed(7);
              clearError(koordinat);
            }
          }

          // Detail lokasi - explicit validation
          if (!detail.value.trim()) {
            showError(detail, 'Detail lokasi wajib diisi.');
            valid = false;
          } else {
            clearError(detail);
          }

          // Deskripsi pengaduan - explicit validation
          if (!desk.value.trim()) {
            showError(desk, 'Deskripsi pengaduan wajib diisi.');
            valid = false;
          } else {
            clearError(desk);
          }

          // Foto (minimal 1)
          const fotoInputs = document.querySelectorAll('input[name="laporan__foto_input[]"]');
          let fotoValid = false;
          fotoInputs.forEach(fi => {
            if (fi.files && fi.files.length > 0) {
              fotoValid = true;
              const file = fi.files[0];
              if (file.size > 2 * 1024 * 1024) {
                showError(fi, 'Ukuran foto maksimal 2MB.');
                valid = false;
              } else if (!/^image\/(jpeg|jpg|png)$/i.test(file.type)) {
                showError(fi, 'Format foto harus JPG, JPEG, atau PNG.');
                valid = false;
              } else {
                clearError(fi);
              }
            } else {
              showError(fi, '');
            }
          });
          if (!fotoValid) {
            const fotoErr = document.getElementById('error_foto');
            fotoErr.textContent = 'Minimal 1 foto kerusakan harus diunggah.';
            fotoErr.classList.remove('hidden');
            valid = false;
          } else {
            document.getElementById('error_foto').classList.add('hidden');
          }
        }
        // Step 2: Konfirmasi
        if (stepIdx === 2) {
          // Rating, kritik, saran, checkbox
          const rating = document.querySelector('input[name="skm__rating"]:checked');
          const kritik = document.getElementById('skm__kritik');
          const saran = document.getElementById('skm__saran');
          const cek = document.getElementById('bordered-checkbox-2');
          let valid2 = true;

          // Rating validation - show specific error
          const ratingError = document.getElementById('error_skm__rating');
          if (!rating) {
            if (ratingError) {
              ratingError.textContent = 'Silakan pilih salah satu rating.';
              ratingError.classList.remove('hidden');
              // Add red border to rating options container
              const ratingContainer = document.querySelector('.flex.items-center.me-4').parentNode;
              ratingContainer.classList.add('border', 'border-red-500', 'rounded-lg', 'p-2');
            }
            valid2 = false;
            valid = false;
          } else if (ratingError) {
            ratingError.classList.add('hidden');
            const ratingContainer = document.querySelector('.flex.items-center.me-4').parentNode;
            ratingContainer.classList.remove('border', 'border-red-500', 'rounded-lg', 'p-2');
          }

          // Kritik validation - use existing showError/clearError functions
          if (!kritik.value.trim()) {
            showError(kritik, 'Kritik wajib diisi.');
            valid2 = false;
            valid = false;
          } else {
            clearError(kritik);
          }

          // Saran validation - use existing showError/clearError functions
          if (!saran.value.trim()) {
            showError(saran, 'Saran wajib diisi.');
            valid2 = false;
            valid = false;
          } else {
            clearError(saran);
          }

          // Checkbox validation
          const checkboxError = document.getElementById('error_bordered-checkbox');
          if (!cek.checked) {
            if (checkboxError) {
              checkboxError.textContent = 'Anda harus menyetujui pernyataan ini.';
              checkboxError.classList.remove('hidden');
              // Add red border to checkbox container
              const checkboxContainer = cek.closest('.flex.items-center');
              checkboxContainer.classList.add('border-red-500');
            }
            valid2 = false;
            valid = false;
          } else if (checkboxError) {
            checkboxError.classList.add('hidden');
            const checkboxContainer = cek.closest('.flex.items-center');
            checkboxContainer.classList.remove('border-red-500');
          }

          // Still show general alert if any validation fails
          if (!valid2) {
            showAlert('alert-2', 'Mohon isi semua data pada langkah ini.');
          }
        }
        return valid;
      }

      // Stepper next/prev logic override
      const stepperContents = Array.from(document.querySelectorAll('.stepper-content'));
      let currentStep = 0;

      // Tambahkan fungsi ini agar error hilang dan stepper bisa berpindah
      function showStepperStep(idx) {
        stepperContents.forEach((el, i) => {
          el.classList.toggle('hidden', i !== idx);
        });
        // Update stepper bar dan label jika ada
        const stepperBar = document.querySelectorAll('#stepper-bar .stepper-step');
        stepperBar.forEach((el, i) => {
          const iconSpan = el.querySelector('span');
          if (iconSpan) {
            if (i <= idx) {
              iconSpan.classList.add('bg-brand-blue', 'text-white');
              iconSpan.classList.remove('bg-gray-100', 'text-gray-500');
            } else {
              iconSpan.classList.remove('bg-brand-blue', 'text-white');
              iconSpan.classList.add('bg-gray-100', 'text-gray-500');
            }
          }
          // Update label color below stepper
          const labelBar = document.querySelectorAll('.mb-8 > .flex.w-full.mt-2 > div > span');
          if (labelBar[i]) {
            if (i <= idx) {
              labelBar[i].classList.add('text-brand-blue');
              labelBar[i].classList.remove('text-gray-500');
            } else {
              labelBar[i].classList.remove('text-brand-blue');
              labelBar[i].classList.add('text-gray-500');
            }
          }
        });
        // Garis penghubung dinamis
        const stepperLineLeft = document.getElementById('stepper-line-left');
        const stepperLineRight = document.getElementById('stepper-line-right');
        if (stepperLineLeft && stepperLineRight) {

          if (idx === 0) {
            stepperLineLeft.classList.remove('bg-brand-blue');
            stepperLineLeft.classList.add('bg-gray-200');
            stepperLineRight.classList.remove('bg-brand-blue');
            stepperLineRight.classList.add('bg-gray-200');
          } else if (idx === 1) {
            stepperLineLeft.classList.remove('bg-gray-200');
            stepperLineLeft.classList.add('bg-brand-blue');
            stepperLineRight.classList.remove('bg-brand-blue');
            stepperLineRight.classList.add('bg-gray-200');
          } else if (idx === 2) {
            stepperLineLeft.classList.remove('bg-gray-200');
            stepperLineLeft.classList.add('bg-brand-blue');
            stepperLineRight.classList.remove('bg-gray-200');
            stepperLineRight.classList.add('bg-brand-blue');
          }
        }
      }

      showStepperStep(currentStep);

      document.querySelectorAll('.stepper-next').forEach(btn => {
        btn.addEventListener('click', function() {
          if (validateStep(currentStep)) {
            if (currentStep < stepperContents.length - 1) {
              currentStep++;
              showStepperStep(currentStep);
            }
          }
        });
      });
      document.querySelectorAll('.stepper-prev').forEach(btn => {
        btn.addEventListener('click', function() {
          if (currentStep > 0) {
            currentStep--;
            showStepperStep(currentStep);
          }
        });
      });
      // Submit: validasi semua step
      document.getElementById('stepper-form').addEventListener('submit', function(e) {
        // Always prevent the default submission first to use our custom validation
        e.preventDefault();

        // Validate the current step (likely step 2)
        if (validateStep(currentStep)) {
          // If we're not on the final step, move to it
          if (currentStep < 2) {
            currentStep = 2;
            showStepperStep(currentStep);
            return;
          }

          // If all steps validate, submit the form
          if (validateStep(0) && validateStep(1) && validateStep(2)) {
            this.submit();
          } else {
            showAlert('alert-2', 'Mohon lengkapi seluruh data sebelum mengirim.');
          }
        }
      });
    });

    // Implementasi Foto Kerusakan
    document.addEventListener('DOMContentLoaded', function() {
      // Global variables
      const fotoInputList = document.getElementById('laporan__foto_input_list');
      const cropperModalFoto = document.getElementById('cropperModalFoto');
      const imageToCropFoto = document.getElementById('image-to-crop-foto');
      const cropFotoConfirmBtn = document.getElementById('crop-foto-confirm-btn');
      const cropFotoCancelBtn = document.getElementById('crop-foto-cancel-btn');
      let cropperFoto = null;
      let lastFotoFile = null;
      let currentFotoInput = null;

      // Initialize ViewerJS for all photo wrappers
      function initFotoViewer(wrapper) {
        if (wrapper && window.Viewer) {
          // Remove previous instance if exists
          if (wrapper._fotoViewer) {
            wrapper._fotoViewer.destroy();
            wrapper._fotoViewer = null;
          }

          wrapper._fotoViewer = new Viewer(wrapper, {
            navbar: false,
            toolbar: true,
            title: false,
            tooltip: false,
            movable: false,
            zoomable: true,
            scalable: false,
            transition: true,
            fullscreen: false,
            filter(image) {
              return image.classList.contains('laporan__foto_preview') &&
                !image.classList.contains('hidden') &&
                image.src &&
                image.src !== '#';
            }
          });
        }
      }

      // Initialize all existing wrappers
      document.querySelectorAll('.laporan__foto_item_wrapper').forEach(wrapper => {
        initFotoViewer(wrapper);
      });

      // Helper function to store and retrieve history for each photo
      function getFotoHistoryStore(item) {
        if (!item._fotoHistory) {
          item._fotoHistory = {
            history: [],
            pointer: -1
          };
        }
        return item._fotoHistory;
      }

      function pushFotoHistory(item, src) {
        const store = getFotoHistoryStore(item);
        if (store.pointer < store.history.length - 1) {
          store.history = store.history.slice(0, store.pointer + 1);
        }
        store.history.push(src);
        store.pointer = store.history.length - 1;
        updateRevertFotoBtn(item);
      }

      function updateRevertFotoBtn(item) {
        const store = getFotoHistoryStore(item);
        const revertBtn = item.querySelector('.revert_laporan__foto_btn');
        if (store.pointer > 0) {
          revertBtn.classList.remove('hidden');
          revertBtn.style.display = '';
        } else {
          revertBtn.classList.add('hidden');
          revertBtn.style.display = 'none';
        }
      }

      // Set preview and update history
      function setFotoPreviewAndHistory(item, src) {
        const preview = item.querySelector('.laporan__foto_preview');
        const placeholder = item.querySelector('.laporan__foto_placeholder');
        const removeBtn = item.querySelector('.remove_laporan__foto_btn');
        const editBtn = item.querySelector('.edit_laporan__foto_btn');

        preview.src = src;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
        removeBtn.classList.remove('hidden');
        editBtn.classList.remove('hidden');

        pushFotoHistory(item, src);

        // Update viewer

        if (item._fotoViewer) item._fotoViewer.update();
      }

      // Reset a photo input to empty state
      function resetFotoPreview(item) {
        const preview = item.querySelector('.laporan__foto_preview');
        const placeholder = item.querySelector('.laporan__foto_placeholder');
        const removeBtn = item.querySelector('.remove_laporan__foto_btn');
        const editBtn = item.querySelector('.edit_laporan__foto_btn');
        const fileInput = item.querySelector('.laporan__foto_file_input');

        preview.src = '#';
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
        removeBtn.classList.add('hidden');
        editBtn.classList.add('hidden');

        // Clear file input
        fileInput.value = '';
      }

      // Create new photo input item
      function createFotoInputItem() {
        const template = document.querySelector('.laporan__foto_item_wrapper').cloneNode(true);

        // Reset the cloned element
        const preview = template.querySelector('.laporan__foto_preview');
        const placeholder = template.querySelector('.laporan__foto_placeholder');
        const fileInput = template.querySelector('.laporan__foto_file_input');
        const removeBtn = template.querySelector('.remove_laporan__foto_btn');
        const editBtn = template.querySelector('.edit_laporan__foto_btn');

        preview.src = '#';
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
        removeBtn.classList.add('hidden');
        editBtn.classList.add('hidden');
        fileInput.value = '';

        return template;
      }

      // Event delegation for all photo input controls
      fotoInputList.addEventListener('click', function(e) {
        // Add new photo button
        if (e.target.closest('.add_laporan__foto_btn')) {
          e.preventDefault();
          const newItem = createFotoInputItem();
          fotoInputList.appendChild(newItem);
          initFotoViewer(newItem);
          updateAddFotoBtnVisibility();
        }

        // Remove photo button
        if (e.target.closest('.remove_laporan__foto_btn')) {
          e.preventDefault();
          const item = e.target.closest('.laporan__foto_item_wrapper');
          if (item) {
            if (fotoInputList.children.length > 1) {
              item.remove();
              updateAddFotoBtnVisibility();
            } else {
              // Just reset the preview if it's the last item
              resetFotoPreview(item);
              item._fotoHistory = {
                history: [],
                pointer: -1
              };
              updateRevertFotoBtn(item);
            }
          }
        }

        // Revert photo button
        if (e.target.closest('.revert_laporan__foto_btn')) {
          e.preventDefault();
          const item = e.target.closest('.laporan__foto_item_wrapper');
          const store = getFotoHistoryStore(item);

          if (store.pointer > 0) {
            store.pointer--;
            const prevSrc = store.history[store.pointer];

            const preview = item.querySelector('.laporan__foto_preview');
            const placeholder = item.querySelector('.laporan__foto_placeholder');
            const removeBtn = item.querySelector('.remove_laporan__foto_btn');
            const editBtn = item.querySelector('.edit_laporan__foto_btn');

            if (prevSrc && prevSrc !== '#') {
              preview.src = prevSrc;
              preview.classList.remove('hidden');
              placeholder.classList.add('hidden');
              removeBtn.classList.remove('hidden');
              editBtn.classList.remove('hidden');
            } else {
              resetFotoPreview(item);
            }

            updateRevertFotoBtn(item);
          }
        }

        // Edit (crop) photo button
        if (e.target.closest('.edit_laporan__foto_btn')) {
          e.preventDefault();
          const item = e.target.closest('.laporan__foto_item_wrapper');
          const preview = item.querySelector('.laporan__foto_preview');

          if (!preview.classList.contains('hidden') && preview.src && preview.src !== '#') {
            imageToCropFoto.src = preview.src;
            cropperModalFoto.classList.remove('hidden');
            currentFotoInput = item.querySelector('.laporan__foto_file_input');

            if (cropperFoto) cropperFoto.destroy();
            cropperFoto = new Cropper(imageToCropFoto, {
              viewMode: 1,
              autoCropArea: 1,
            });
          }
        }

        // When clicking on a preview image, open the viewer
        const preview = e.target.closest('.laporan__foto_preview');
        if (preview && !preview.classList.contains('hidden') && preview.src && preview.src !== '#') {
          e.preventDefault();
          e.stopPropagation();

          const item = preview.closest('.laporan__foto_item_wrapper');
          if (item && item._fotoViewer) {
            item._fotoViewer.show();
          }
          return false;
        }
      });

      // File input change handler (using event delegation)
      fotoInputList.addEventListener('change', function(e) {
        const fileInput = e.target.closest('.laporan__foto_file_input');
        if (fileInput && fileInput.files && fileInput.files[0]) {
          lastFotoFile = fileInput.files[0];
          currentFotoInput = fileInput;

          const reader = new FileReader();
          reader.onload = function(ev) {
            imageToCropFoto.src = ev.target.result;
            cropperModalFoto.classList.remove('hidden');

            if (cropperFoto) cropperFoto.destroy();
            cropperFoto = new Cropper(imageToCropFoto, {
              viewMode: 1,
              autoCropArea: 1,
            });
          };
          reader.readAsDataURL(fileInput.files[0]);
        }
      });

      // Only show add button on the last item
      function updateAddFotoBtnVisibility() {
        const items = Array.from(fotoInputList.querySelectorAll('.laporan__foto_item_wrapper'));
        items.forEach((item, idx) => {
          const addBtn = item.querySelector('.add_laporan__foto_btn');
          if (addBtn) {
            addBtn.style.display = (idx === items.length - 1) ? '' : 'none';
          }
        });
      }

      // Initialize visibility
      updateAddFotoBtnVisibility();

      // Cropper modal confirm button
      cropFotoConfirmBtn.addEventListener('click', function() {
        if (cropperFoto && currentFotoInput) {
          cropperFoto.getCroppedCanvas().toBlob(function(blob) {
            const croppedFile = new File([blob], lastFotoFile ? lastFotoFile.name : 'cropped_foto.jpg', {
              type: blob.type
            });

            // Update the file input with cropped file
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            currentFotoInput.files = dataTransfer.files;

            // Update preview
            const item = currentFotoInput.closest('.laporan__foto_item_wrapper');
            const reader = new FileReader();
            reader.onload = function(ev) {
              setFotoPreviewAndHistory(item, ev.target.result);
            };
            reader.readAsDataURL(croppedFile);

            // Close modal and cleanup
            cropperFoto.destroy();
            cropperFoto = null;
            cropperModalFoto.classList.add('hidden');
            currentFotoInput = null;
          }, lastFotoFile ? lastFotoFile.type : 'image/jpeg');
        }
      });

      // Cropper modal cancel button
      cropFotoCancelBtn.addEventListener('click', function() {
        cropperModalFoto.classList.add('hidden');
        if (cropperFoto) {
          cropperFoto.destroy();
          cropperFoto = null;
        }
        currentFotoInput = null;
      });
    });

    // Helper function to parse Google Maps URL and extract coordinates
    function parseGoogleMapsUrl(url) {
      try {
        // Try to extract coordinates from various Google Maps URL formats
        // Format 1: https://www.google.com/maps?q=-0.1234567,117.1234567
        // Format 2: https://maps.google.com/?q=-0.1234567,117.1234567
        // Format 3: https://maps.app.goo.gl/abc123 (shortened URL)
        // Format 4: https://goo.gl/maps/abc123 (shortened URL)
        // Format 5: https://www.google.com/maps/place/Samarinda/.../@-0.1234567,117.1234567,15z/...

        // First, try the simple q parameter format
        let qMatch = url.match(/[?&]q=(-?\d+\.\d+),(-?\d+\.\d+)/);
        if (qMatch) {
          return {
            latitude: parseFloat(qMatch[1]),
            longitude: parseFloat(qMatch[2])
          };
        }

        // Try the @lat,lon format used in place URLs
        let atMatch = url.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/);
        if (atMatch) {
          return {
            latitude: parseFloat(atMatch[1]),
            longitude: parseFloat(atMatch[2])
          };
        }

        // If direct extraction failed, look for any pair of coordinates in the URL
        let coordsMatch = url.match(/(-?\d+\.\d{7}),(-?\d+\.\d{7})/);
        if (coordsMatch) {
          return {
            latitude: parseFloat(coordsMatch[1]),
            longitude: parseFloat(coordsMatch[2])
          };
        }

        // If URL doesn't contain coordinates, see if it's just raw coordinates
        // Format: -0.1234567,117.1234567
        let rawMatch = url.match(/^(-?\d+\.\d{7}),(-?\d+\.\d{7})$/);
        if (rawMatch) {
          return {
            latitude: parseFloat(rawMatch[1]),
            longitude: parseFloat(rawMatch[2])
          };
        }

        return null;
      } catch (error) {
        console.error("Error parsing Google Maps URL:", error);
        return null;
      }
    }

    // Function to generate Google Maps URL from coordinates
    function generateGoogleMapsUrl(lat, lon) {
      return `https://maps.google.com/maps?q=${lat},${lon}`;
    }

    document.addEventListener('DOMContentLoaded', function() {
      // Update hidden longitude/latitude when Google Maps URL changes
      document.getElementById('laporan__koordinat').addEventListener('input', function() {
        const url = this.value.trim();
        const coords = parseGoogleMapsUrl(url);

        if (coords) {
          document.getElementById('laporan__longitude').value = coords.longitude.toFixed(7);
          document.getElementById('laporan__latitude').value = coords.latitude.toFixed(7);
          clearError(this);
        } else {
          // Don't clear values immediately to allow user to finish typing
          // But we could add visual feedback that the URL isn't valid yet
        }
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      // Breadcrumb dropdown functionality for mobile
      const breadcrumbButton = document.getElementById('breadcrumb-menu-button');
      const breadcrumbDropdown = document.getElementById('breadcrumb-dropdown');

      if (breadcrumbButton && breadcrumbDropdown) {
        breadcrumbButton.addEventListener('click', function() {
          breadcrumbDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
          if (!breadcrumbButton.contains(e.target) && !breadcrumbDropdown.contains(e.target)) {
            breadcrumbDropdown.classList.add('hidden');
          }
        });
      }
    });
  </script>
@endsection
