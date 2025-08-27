@extends('guest.layouts.main')

@section('document.start')
@endsection

@section('document.body')


  <div class="px-6 pb-10 md:pb-12 pt-6 flex justify-center">
    <div>
      <!-- Header Banner -->
      <div class="pt-6 pb-6">
        <div class="container mx-auto">
          <div class="space-y-4">
            <!-- Mobile-friendly breadcrumbs with responsive design -->
            <nav aria-label="Breadcrumb">
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
                  <svg class="w-2.5 h-2.5 ml-1 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 10 6">
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
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                      xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                    </svg>
                    <a href="#" class="text-blue-600 underline">
                      Layanan Umum
                    </a>
                  </div>
                </li>
                <li>
                  <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                      xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
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
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                      xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="text-gray-500 font-medium">
                      <span>Lihat Pengaduan Hantu Banyu</span>
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
                      <a href="{{ route('guest.drainase-irigasi.index') }}"
                        class="block px-4 py-2 hover:bg-gray-100">Hantu
                        Banyu</a>
                    </li>
                    <li>
                      <span class="block px-4 py-2 font-semibold text-gray-600">Lihat Pengaduan Hantu Banyu</span>
                    </li>
                  </ol>
                </div>
              </div>
            </nav>
            <h1 class="text-2xl xs:text-3xl font-bold text-gray-900">Lihat Pengaduan Hantu Banyu</h1>
          </div>
        </div>
      </div>
      <div class="flex flex-col lg:flex-row gap-6">
        <!-- Left Panel: Search Form -->
        <div class="lg:w-96 flex-shrink-0 space-y-6 lg:order-1">
          <!-- Search Form - Accordion style on mobile -->
          <div>
            <p class="text-end text-sm text-gray-600 mr-1 mb-0.5 lg:hidden">Tekan untuk membuka</p>
            <div class="bg-white rounded-lg shadow-lg border overflow-hidden">
              <div
                class="px-6 py-4 border-b border-gray-200 flex items-center justify-between cursor-pointer lg:cursor-default mobile-accordion-header">
                <h2 class="text-lg font-medium text-gray-900">Cari Pengaduan</h2>
                <div class="lg:hidden">
                  <svg class="mobile-accordion-icon w-5 h-5 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd"></path>
                  </svg>
                </div>
              </div>
              <div class="mobile-accordion-content p-6">
                <form id="search-form" class="space-y-5" method="GET"
                  action="{{ route('guest.drainase-irigasi.pengaduan.index') }}">
                  <div class="space-y-4">
                    <div>
                      <label for="search_query" class="block font-medium text-gray-700 mb-1">
                        Nomor Pengaduan atau Nama Jalan
                      </label>
                      <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                          <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                              clip-rule="evenodd" />
                          </svg>
                        </div>
                        <input type="search" name="search_query" id="search_query" value="{{ $search_query }}"
                          class="pl-10 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base py-3"
                          placeholder="Ketik di sini">
                      </div>
                    </div>

                    <div>
                      <label for="status_filter" class="block font-medium text-gray-700 mb-1">
                        Status Pengaduan
                      </label>
                      <select id="status_filter" name="status_filter"
                        class="block w-full pl-3 pr-10 py-3 border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm text-base">
                        <option value="" {{ $status_filter === '' ? 'selected' : '' }}>Semua Status</option>
                        <option value="pending" {{ $status_filter === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ $status_filter === 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="menunggu_survei" {{ $status_filter === 'menunggu_survei' ? 'selected' : '' }}>
                          Menunggu Survei</option>
                        <option value="sudah_disurvei" {{ $status_filter === 'sudah_disurvei' ? 'selected' : '' }}>Sudah
                          Disurvei</option>
                        <option value="menunggu_jadwal_pengerjaan"
                          {{ $status_filter === 'menunggu_jadwal_pengerjaan' ? 'selected' : '' }}>Menunggu Jadwal
                        </option>
                        <option value="sedang_dikerjakan"
                          {{ $status_filter === 'sedang_dikerjakan' ? 'selected' : '' }}>
                          Sedang Dikerjakan</option>
                        <option value="selesai" {{ $status_filter === 'selesai' ? 'selected' : '' }}>Selesai</option>
                      </select>
                    </div>

                    <div>
                      <label for="jenis_filter" class="block font-medium text-gray-700 mb-1">
                        Jenis Pengaduan
                      </label>
                      <select id="jenis_filter" name="jenis_filter"
                        class="block w-full pl-3 pr-10 py-3 border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm text-base">
                        <option value="" {{ $jenis_filter === '' ? 'selected' : '' }}>Semua Jenis</option>
                        <option value="belum_diklasifikasikan"
                          {{ $jenis_filter === 'belum_diklasifikasikan' ? 'selected' : '' }}>Belum Diklasifikasikan
                        </option>
                        <option value="darurat" {{ $jenis_filter === 'darurat' ? 'selected' : '' }}>Darurat</option>
                        <option value="biasa" {{ $jenis_filter === 'biasa' ? 'selected' : '' }}>Biasa</option>
                        <option value="rutin" {{ $jenis_filter === 'rutin' ? 'selected' : '' }}>Rutin</option>
                      </select>
                    </div>

                    <div>
                      <input type="hidden" name="sort" value="{{ $sort_option }}">
                      <button type="submit"
                        class="w-full flex justify-center items-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-brand-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cari Pengaduan
                      </button>
                    </div>
                  </div>
                </form>

                <!-- Help Tips -->
                <div class="mt-6 pt-5 border-t border-gray-200">
                  <div class="bg-blue-50 rounded-md p-3">
                    <div class="flex">
                      <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                          fill="currentColor">
                          <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                        </svg>
                      </div>
                      <div class="ml-3 text-blue-700">
                        <p>
                          Masukkan nomor pengaduan untuk melihat proses laporan Anda. Jika Anda lupa nomor pengaduan, coba
                          cari dengan nama jalan.
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Map Distribution - Accordion style on mobile -->
          <div>
            <p class="text-end text-sm text-gray-600 mr-1 mb-0.5 lg:hidden">Tekan untuk membuka</p>
            <div class="bg-white rounded-lg shadow-lg border overflow-hidden">
              <div
                class="px-6 py-4 border-b border-gray-200 flex items-center justify-between cursor-pointer lg:cursor-default mobile-accordion-header">
                <h2 class="text-lg text-gray-900">Peta Sebaran</h2>
                <div class="lg:hidden">
                  <svg class="mobile-accordion-icon w-5 h-5 transition-transform" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd"></path>
                  </svg>
                </div>
              </div>
              <div class="mobile-accordion-content p-6">
                <p>
                  Ingin melihat lokasi kerusakan dalam bentuk peta? Silakan kunjungi halaman<a href="/peta-sebaran"
                    target="_blank" rel="noopener noreferrer"
                    class="text-blue-600 underline inline-flex items-center gap-1 align-middle ml-1"><span>Peta
                      Sebaran</span><i class="fa-solid fa-arrow-up-right-from-square fa-sm"></i></a>
                </p>
              </div>
            </div>
          </div>

          <!-- Warning Section - Regular yellow box on desktop, hidden on mobile -->
          <div class="bg-yellow-50 rounded-md p-3 shadow-lg hidden lg:block">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                  fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3 text-yellow-700">
                <p>
                  Pengaduan Anda masih berstatus pending selama lebih dari 3 hari kerja? Silakan hubungi petugas kami
                  melalui WhatsApp
                  <a href="https://wa.me/62123456789" target="_blank" rel="noopener noreferrer"
                    class="text-blue-600 underline whitespace-nowrap inline-flex items-center gap-1 align-middle">
                    +62 812-3456-7890 <i class="fa-solid fa-arrow-up-right-from-square fa-sm"></i>
                  </a>
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Panel: Results -->
        <div class="flex-1 flex flex-col gap-6 lg:order-2 w-fit ">
          <div class="bg-white rounded-lg shadow-lg border overflow-hidden w-fit">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between w-fit">
              <h2 class="text-lg font-medium text-gray-900">Daftar Pengaduan</h2>
              <div class="flex items-center">
                <div class="ml-2">
                  <button id="sort-dropdown" data-dropdown-toggle="dropdown-sort"
                    class="text-gray-500 hover:bg-gray-100 focus:outline-none rounded-lg text-sm p-1.5 flex items-center gap-1.5"
                    type="button">
                    <span class="text-gray-500 text-sm">Urutkan</span>
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h5a1 1 0 100-2H3z">
                      </path>
                    </svg>
                  </button>
                  <div id="dropdown-sort" class="hidden z-10 w-44 bg-white rounded-lg shadow-lg border">
                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="sort-dropdown">
                      <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100" data-sort="latest">Terbaru</a>
                      </li>
                      <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100" data-sort="oldest">Terlama</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <!-- Table for larger screens (hidden on mobile) -->
            <div class="hidden md:block">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-nowrap">
                      No. Pengaduan
                    </th>
                    <th scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Lokasi
                    </th>
                    <th scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Waktu Masuk
                    </th>
                    <th scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Status
                    </th>
                    <th scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Jenis
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                      <span class="sr-only">Detail</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  @forelse($laporan as $item)
                    <tr class="hover:bg-gray-50">
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $item->id }}</div>
                      </td>
                      <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                          {{ $item->nama_jalan }}
                          <br>
                          <a href="https://maps.google.com/?q={{ $item->latitude }},{{ $item->longitude }}"
                            target="_blank" rel="noopener noreferrer"
                            class="text-blue-600 underline whitespace-nowrap inline-flex items-center gap-1 align-middle">
                            Lihat di Google Maps <i class="fa-solid fa-arrow-up-right-from-square fa-sm"></i>
                          </a>
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">
                          {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}<br>
                          ({{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('H.i') }} WITA)
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span
                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                          {{ $item->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                          {{ $item->status === 'diterima' ? 'bg-blue-100 text-blue-800' : '' }}
                          {{ $item->status === 'menunggu_survei' ? 'bg-pink-100 text-pink-800' : '' }}
                          {{ $item->status === 'sudah_disurvei' ? 'bg-purple-100 text-purple-800' : '' }}
                          {{ $item->status === 'menunggu_jadwal_pengerjaan' ? 'bg-orange-100 text-orange-800' : '' }}
                          {{ $item->status === 'sedang_dikerjakan' ? 'bg-indigo-100 text-indigo-800' : '' }}
                          {{ $item->status === 'selesai' ? 'bg-green-100 text-green-800' : '' }}">
                          {{ $item->status === 'pending' ? 'Pending' : '' }}
                          {{ $item->status === 'diterima' ? 'Diterima' : '' }}
                          {{ $item->status === 'menunggu_survei' ? 'Menunggu Survei' : '' }}
                          {{ $item->status === 'sudah_disurvei' ? 'Sudah Disurvei' : '' }}
                          {{ $item->status === 'menunggu_jadwal_pengerjaan' ? 'Menunggu Jadwal' : '' }}
                          {{ $item->status === 'sedang_dikerjakan' ? 'Sedang Dikerjakan' : '' }}
                          {{ $item->status === 'selesai' ? 'Selesai' : '' }}
                        </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span
                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                          {{ $item->jenis === 'belum_diklasifikasikan' ? 'bg-gray-100 text-gray-800' : '' }}
                          {{ $item->jenis === 'darurat' ? 'bg-red-100 text-red-800' : '' }}
                          {{ $item->jenis === 'biasa' ? 'bg-teal-100 text-teal-800' : '' }}
                          {{ $item->jenis === 'rutin' ? 'bg-blue-100 text-blue-800' : '' }}">
                          {{ $item->jenis === 'belum_diklasifikasikan' ? 'Belum Diklasifikasi' : '' }}
                          {{ $item->jenis === 'darurat' ? 'Darurat' : '' }}
                          {{ $item->jenis === 'biasa' ? 'Biasa' : '' }}
                          {{ $item->jenis === 'rutin' ? 'Rutin' : '' }}
                        </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('guest.drainase-irigasi.pengaduan.show', $item->id) }}"
                          class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md border border-brand-blue bg-white text-brand-blue font-semibold hover:bg-brand-blue hover:text-white transition">
                          <span>Lihat Detail & Foto</span>
                          <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                              clip-rule="evenodd"></path>
                          </svg>
                        </a>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data pengaduan yang ditemukan.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- Simplified Mobile Layout (hidden on larger screens) - List View Only -->
            <div class="md:hidden divide-y divide-gray-200">
              <!-- List View -->
              <div id="mobile-list-view">
                @forelse($laporan as $item)
                  <div class="border-b">
                    <button type="button" class="accordion-header w-full flex justify-between items-center px-4 py-3">
                      <div class="flex flex-col items-start">
                        <span class="font-medium text-gray-900">{{ $item->id }}</span>
                        <span class="text-sm text-gray-600 truncate">{{ $item->nama_jalan }}</span>
                      </div>
                      <div class="flex items-center gap-2">
                        <span
                          class="inline-block w-3 h-3 rounded-full 
                          {{ $item->status === 'pending' ? 'bg-yellow-500' : '' }}
                          {{ $item->status === 'diterima' ? 'bg-blue-500' : '' }}
                          {{ $item->status === 'menunggu_survei' ? 'bg-pink-500' : '' }}
                          {{ $item->status === 'sudah_disurvei' ? 'bg-purple-500' : '' }}
                          {{ $item->status === 'menunggu_jadwal_pengerjaan' ? 'bg-orange-500' : '' }}
                          {{ $item->status === 'sedang_dikerjakan' ? 'bg-indigo-500' : '' }}
                          {{ $item->status === 'selesai' ? 'bg-green-500' : '' }}">
                        </span>
                        <svg class="accordion-icon transition-transform w-5 h-5" fill="currentColor"
                          viewBox="0 0 20 20">
                          <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                        </svg>
                      </div>
                    </button>
                    <div class="accordion-content hidden px-4 pb-3 pt-0">
                      <div class="space-y-3 text-sm">
                        <dl class="grid grid-cols-[auto_1fr] gap-y-2">
                          <dt class="text-gray-500 font-medium text-end pe-2 w-[55.16px]">Status</dt>
                          <dd
                            class="font-medium 
                            {{ $item->status === 'pending' ? 'text-yellow-800' : '' }}
                            {{ $item->status === 'diterima' ? 'text-blue-800' : '' }}
                            {{ $item->status === 'menunggu_survei' ? 'text-pink-800' : '' }}
                            {{ $item->status === 'sudah_disurvei' ? 'text-purple-800' : '' }}
                            {{ $item->status === 'menunggu_jadwal_pengerjaan' ? 'text-orange-800' : '' }}
                            {{ $item->status === 'sedang_dikerjakan' ? 'text-indigo-800' : '' }}
                            {{ $item->status === 'selesai' ? 'text-green-800' : '' }}">
                            {{ $item->status === 'pending' ? 'Pending' : '' }}
                            {{ $item->status === 'diterima' ? 'Diterima' : '' }}
                            {{ $item->status === 'menunggu_survei' ? 'Menunggu Survei' : '' }}
                            {{ $item->status === 'sudah_disurvei' ? 'Sudah Disurvei' : '' }}
                            {{ $item->status === 'menunggu_jadwal_pengerjaan' ? 'Menunggu Jadwal' : '' }}
                            {{ $item->status === 'sedang_dikerjakan' ? 'Sedang Dikerjakan' : '' }}
                            {{ $item->status === 'selesai' ? 'Selesai' : '' }}
                          </dd>

                          <dt class="text-gray-500 font-medium text-end pe-2 w-[55.16px]">Jenis</dt>
                          <dd
                            class="font-medium 
                            {{ $item->jenis === 'belum_diklasifikasikan' ? 'text-gray-800' : '' }}
                            {{ $item->jenis === 'darurat' ? 'text-red-800' : '' }}
                            {{ $item->jenis === 'biasa' ? 'text-teal-800' : '' }}
                            {{ $item->jenis === 'rutin' ? 'text-blue-800' : '' }}">
                            {{ $item->jenis === 'belum_diklasifikasikan' ? 'Belum Diklasifikasi' : '' }}
                            {{ $item->jenis === 'darurat' ? 'Darurat' : '' }}
                            {{ $item->jenis === 'biasa' ? 'Biasa' : '' }}
                            {{ $item->jenis === 'rutin' ? 'Rutin' : '' }}
                          </dd>

                          <dt class="text-gray-500 font-medium text-end pe-2 w-[55.16px]">Waktu Masuk</dt>
                          <dd>
                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}<br>
                            ({{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('H.i') }} WITA)
                          </dd>

                          <dt class="text-gray-500 font-medium text-end pe-2 w-[55.16px]">Lokasi</dt>
                          <dd>
                            <a href="https://maps.google.com/?q={{ $item->latitude }},{{ $item->longitude }}"
                              target="_blank" rel="noopener noreferrer"
                              class="text-blue-600 underline whitespace-nowrap inline-flex items-center gap-1 align-middle">
                              Lihat di Google Maps <i class="fa-solid fa-arrow-up-right-from-square fa-sm"></i>
                            </a>
                          </dd>
                        </dl>

                        <div class="flex justify-end items-center mt-3">
                          <a href="{{ route('guest.drainase-irigasi.pengaduan.show', $item->id) }}"
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md border border-brand-blue bg-white text-brand-blue font-semibold hover:bg-brand-blue hover:text-white transition text-sm">
                            <span>Lihat Detail & Foto</span>
                            <svg class="ml-1 w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                              <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                            </svg>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                @empty
                  <div class="px-6 py-4 text-center text-gray-500">
                    Tidak ada data pengaduan yang ditemukan.
                  </div>
                @endforelse
              </div>
            </div>

            <!-- Enhanced Pagination Design - Responsive version -->
            <div class="px-5 py-5 bg-white border-t flex flex-col sm:flex-row items-center justify-between">
              {{-- Pada mobile, pagination di atas, info di bawah --}}
              <div
                class="order-2 sm:order-1 w-full sm:w-auto text-sm text-gray-500 mb-3 sm:mb-0 text-center sm:text-left mt-3 sm:mt-0">
                Menampilkan <span class="font-semibold">{{ $laporan->firstItem() ?? 0 }}</span> sampai
                <span class="font-semibold">{{ $laporan->lastItem() ?? 0 }}</span> dari
                <span class="font-semibold">{{ $laporan->total() }}</span> pengaduan
              </div>

              <div class="order-1 sm:order-2 w-full sm:w-auto inline-flex gap-1 flex-wrap justify-center sm:justify-end">
                @if ($laporan->hasPages())
                  <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
                    {{-- Previous Page Link --}}
                    @if ($laporan->onFirstPage())
                      <span
                        class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default rounded-l-md">
                        <span class="sr-only">Previous</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                          fill="currentColor" aria-hidden="true">
                          <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                        </svg>
                      </span>
                    @else
                      <a href="{{ $laporan->previousPageUrl() }}" rel="prev"
                        class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50">
                        <span class="sr-only">Previous</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                          fill="currentColor" aria-hidden="true">
                          <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                        </svg>
                      </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($laporan->getUrlRange(1, $laporan->lastPage()) as $page => $url)
                      @if ($page == $laporan->currentPage())
                        <span aria-current="page"
                          class="z-10 bg-brand-blue border-brand-blue text-white relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                          {{ $page }}
                        </span>
                      @elseif ($page === 1 || $page === $laporan->lastPage() || abs($page - $laporan->currentPage()) < 2)
                        <a href="{{ $url }}"
                          class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium {{ abs($page - $laporan->currentPage()) >= 2 && $page !== 1 && $page !== $laporan->lastPage() ? 'hidden sm:inline-flex' : '' }}">
                          {{ $page }}
                        </a>
                      @elseif ($page === $laporan->currentPage() - 2 || $page === $laporan->currentPage() + 2)
                        <span
                          class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hidden sm:inline-flex">...</span>
                      @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($laporan->hasMorePages())
                      <a href="{{ $laporan->nextPageUrl() }}" rel="next"
                        class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50">
                        <span class="sr-only">Next</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                          fill="currentColor" aria-hidden="true">
                          <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                        </svg>
                      </a>
                    @else
                      <span
                        class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default rounded-r-md">
                        <span class="sr-only">Next</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                          fill="currentColor" aria-hidden="true">
                          <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                        </svg>
                      </span>
                    @endif
                  </nav>
                @endif
              </div>
            </div>
          </div>

          <!-- Warning Section - Mobile only, shown below Daftar Pengaduan -->
          <div class="bg-yellow-50 rounded-md p-3 shadow-lg lg:hidden">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                  fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3 text-yellow-700">
                <p>
                  Pengaduan Anda masih berstatus pending selama lebih dari 3 hari kerja? Silakan hubungi petugas kami
                  melalui WhatsApp
                  <a href="https://wa.me/62123456789" target="_blank" rel="noopener noreferrer"
                    class="text-blue-600 underline whitespace-nowrap inline-flex items-center gap-1 align-middle">
                    +62 812-3456-7890 <i class="fa-solid fa-arrow-up-right-from-square fa-sm"></i>
                  </a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('document.end')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Handle sort dropdown selection
      const sortLinks = document.querySelectorAll('[data-sort]');
      const sortInput = document.querySelector('input[name="sort"]');
      const searchForm = document.getElementById('search-form');

      sortLinks.forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          sortInput.value = this.getAttribute('data-sort');
          searchForm.submit();
        });
      });

      // Highlight current sort option
      const currentSort = sortInput.value;
      document.querySelectorAll(`[data-sort="${currentSort}"]`).forEach(el => {
        el.classList.add('font-bold', 'bg-gray-100');
      });

      // Handle accordion functionality for list view (unchanged)
      const accordionHeaders = document.querySelectorAll('.accordion-header');
      accordionHeaders.forEach(header => {
        header.addEventListener('click', function() {
          const content = this.nextElementSibling;
          const icon = this.querySelector('.accordion-icon');

          // Toggle current content
          content.classList.toggle('hidden');
          // Rotate icon when open
          icon.style.transform = content.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
        });
      });

      // Mobile accordion functionality - FIXED
      const mobileAccordionHeaders = document.querySelectorAll('.mobile-accordion-header');
      let mobileAccordionsInitialized = false;

      function setupMobileAccordions() {
        // If we're on mobile size (under lg breakpoint)
        if (window.innerWidth < 1024) {
          // Only collapse accordions on first initialization
          if (!mobileAccordionsInitialized) {
            document.querySelectorAll('.mobile-accordion-content').forEach((content) => {
              content.classList.add('hidden');
            });

            document.querySelectorAll('.mobile-accordion-icon').forEach((icon) => {
              icon.style.transform = 'rotate(0deg)';
            });

            mobileAccordionsInitialized = true;
          }

          // Add click handlers for mobile (safe to call multiple times)
          mobileAccordionHeaders.forEach(header => {
            header.removeEventListener('click', toggleMobileAccordion); // Remove first to avoid duplicates
            header.addEventListener('click', toggleMobileAccordion);
            header.style.cursor = 'pointer';
          });
        } else {
          // On desktop, ensure all are visible and remove click handlers
          document.querySelectorAll('.mobile-accordion-content').forEach(content => {
            content.classList.remove('hidden');
          });

          mobileAccordionHeaders.forEach(header => {
            header.removeEventListener('click', toggleMobileAccordion);
            header.style.cursor = 'default';
          });
        }
      }

      function toggleMobileAccordion() {
        // Only on mobile
        if (window.innerWidth < 1024) {
          const content = this.nextElementSibling;
          const icon = this.querySelector('.mobile-accordion-icon');

          // Toggle current content
          content.classList.toggle('hidden');
          // Rotate icon when open
          icon.style.transform = content.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
        }
      }

      // Initialize accordions
      setupMobileAccordions();

      // Update accordions state when resizing - but don't force collapse
      window.addEventListener('resize', setupMobileAccordions);

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
