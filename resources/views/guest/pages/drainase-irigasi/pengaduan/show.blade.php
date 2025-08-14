@extends('guest.layouts.main')

@section('document.start')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  <style>
    .timeline-connector {
      position: absolute;
      top: 0;
      bottom: 0;
      width: 2px;
      left: 19px;
      transform: translateX(-50%);
    }

    .swiper-pagination-bullet-active {
      background-color: #1d4ed8 !important;
    }

    .status-pulse {
      position: relative;
    }

    .status-pulse::before {
      content: "";
      position: absolute;
      border: 1px solid currentColor;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      top: calc(50% - 15px);
      left: calc(50% - 15px);
      animation: pulse 2s ease-out infinite;
      opacity: 0;
    }

    @keyframes pulse {
      0% {
        transform: scale(0.5);
        opacity: 0;
      }

      50% {
        opacity: 0.4;
      }

      100% {
        transform: scale(1.6);
        opacity: 0;
      }
    }
  </style>
@endsection

@section('document.body')
  @php
    $latestTindak = $laporan->tindakLanjut->first();

    // Simplified status styling
    $statusColor = 'gray';
    $statusIcon = 'fa-circle-info';

    if ($latestTindak) {
        switch ($latestTindak->status) {
            case 'pending':
                $statusColor = 'yellow';
                $statusIcon = 'fa-clock';
                break;
            case 'diterima':
                $statusColor = 'blue';
                $statusIcon = 'fa-clipboard-check';
                break;
            case 'menunggu_survei':
                $statusColor = 'pink';
                $statusIcon = 'fa-calendar-check';
                break;
            case 'sudah_disurvei':
                $statusColor = 'purple';
                $statusIcon = 'fa-magnifying-glass-location';
                break;
            case 'menunggu_jadwal_pengerjaan':
                $statusColor = 'orange';
                $statusIcon = 'fa-calendar-days';
                break;
            case 'sedang_dikerjakan':
                $statusColor = 'indigo';
                $statusIcon = 'fa-person-digging';
                break;
            case 'selesai':
                $statusColor = 'green';
                $statusIcon = 'fa-circle-check';
                break;
        }
    }

    // Simplified jenis styling
    $jenisColor = 'gray';
    $jenisIcon = 'fa-circle-question';
    $jenisLabel = 'Belum Diklasifikasikan';

    if ($latestTindak) {
        switch ($latestTindak->jenis) {
            case 'belum_diklasifikasikan':
                $jenisColor = 'gray';
                $jenisIcon = 'fa-circle-question';
                $jenisLabel = 'Belum Diklasifikasikan';
                break;
            case 'darurat':
                $jenisColor = 'red';
                $jenisIcon = 'fa-triangle-exclamation';
                $jenisLabel = 'Penanganan Darurat';
                break;
            case 'biasa':
                $jenisColor = 'teal';
                $jenisIcon = 'fa-list-check';
                $jenisLabel = 'Penanganan Biasa';
                break;
            case 'rutin':
                $jenisColor = 'blue';
                $jenisIcon = 'fa-rotate';
                $jenisLabel = 'Pemeliharaan Rutin';
                break;
        }
    }
  @endphp

  <!-- Main Content with Header Banner -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-12">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="Breadcrumb" class="mb-6">
      <!-- Small/XS Mobile: Back link + Current page only -->
      <div class="md:hidden flex items-center">
        <a href="{{ route('guest.drainase-irigasi.pengaduan.index') }}"
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
            <a href="{{ route('guest.drainase-irigasi.index') }}" class="text-blue-600 underline">Hantu Banyu
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
            <a href="{{ route('guest.drainase-irigasi.pengaduan.index') }}" class="text-blue-600 underline">
              Lihat Pengaduan Hantu Banyu
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
              <span>Detail Pengaduan Nomor {{ $laporan->id }}</span>
            </span>
          </div>
        </li>
      </ol>

      <!-- Mobile breadcrumb dots menu -->
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
              <a href="{{ route('guest.drainase-irigasi.index') }}" class="block px-4 py-2 hover:bg-gray-100">Hantu Banyu</a>
            </li>
            <li>
              <a href="{{ route('guest.drainase-irigasi.pengaduan.index') }}"
                class="block px-4 py-2 hover:bg-gray-100">Lihat Pengaduan Hantu Banyu</a>
            </li>
            <li>
              <span class="block px-4 py-2 font-semibold text-gray-600">Detail Pengaduan Nomor {{ $laporan->id }}</span>
            </li>
          </ol>
        </div>
      </div>
    </nav>

    <!-- Header Info Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
      <div class="p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div>
            <h1 class="text-2xl font-bold text-gray-900 mb-1 flex items-center gap-2">
              <i class="fa-solid fa-map-location-dot text-blue-600"></i>
              {{ $laporan->nama_jalan }}
            </h1>
            <p class="text-gray-600">
              {{ $laporan->kelurahan->nama ?? '-' }}, {{ $laporan->kecamatan->nama ?? '-' }}
            </p>
          </div>
          <div class="flex flex-col sm:flex-row gap-2">
            <!-- Status Badge -->
            <div
              class="text-{{ $statusColor }}-700 bg-{{ $statusColor }}-100 px-3 py-1 rounded-full flex items-center gap-1.5 text-sm">
              <i class="fa-solid {{ $statusIcon }}"></i>
              <span
                class="font-medium">{{ $latestTindak ? ucwords(str_replace('_', ' ', $latestTindak->status)) : 'Tidak diketahui' }}</span>
            </div>

            <!-- Jenis Badge -->
            <div
              class="text-{{ $jenisColor }}-700 bg-{{ $jenisColor }}-100 px-3 py-1 rounded-full flex items-center gap-1.5 text-sm">
              <i class="fa-solid {{ $jenisIcon }}"></i>
              <span class="font-medium">{{ $jenisLabel }}</span>
            </div>
          </div>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-100 text-gray-500">
          <b>Nomor Pengaduan</b>: {{ $laporan->id }} <span class="mx-0.5">•</span> <b>Dilaporkan</b>:
          {{ \Carbon\Carbon::parse($laporan->created_at)->translatedFormat('d F Y H:i') }} WITA
        </div>
      </div>
    </div>

    <!-- Grid Layout for Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Left Column - Details and Photos -->
      <div class="lg:col-span-2">
        <!-- Detail Lokasi & Koordinat Card (now includes photos) -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
          <div class="bg-gray-50 px-6 py-4 border border-gray-200 rounded-t-xl">
            <h2 class="font-semibold text-lg flex items-center gap-2">
              <i class="fa-solid fa-circle-info text-blue-600"></i>
              Detail Informasi
            </h2>
          </div>

          <div class="p-6 border border-gray-200 rounded-b-xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Detail Lokasi -->
              <div class="space-y-4">
                <h3 class="font-medium text-gray-900 flex items-center gap-2">
                  <i class="fa-solid fa-location-dot text-blue-600"></i>
                  Lokasi
                </h3>
                <dl class="grid grid-cols-[120px_1fr] gap-y-3 text-sm">
                  <dt class="font-medium text-gray-500">Nama Jalan</dt>
                  <dd>{{ $laporan->nama_jalan }}</dd>

                  <dt class="font-medium text-gray-500">Kelurahan</dt>
                  <dd>{{ $laporan->kelurahan->nama ?? '-' }}</dd>

                  <dt class="font-medium text-gray-500">Kecamatan</dt>
                  <dd>{{ $laporan->kecamatan->nama ?? '-' }}</dd>

                  <dt class="font-medium text-gray-500">Detail Lokasi</dt>
                  <dd>{{ $laporan->detail_lokasi }}</dd>
                </dl>
              </div>

              <!-- Google Maps Preview -->
              <div>
                <h3 class="font-medium text-gray-900 flex items-center gap-2 mb-4">
                  <i class="fa-solid fa-map-marker-alt text-red-600"></i>
                  Koordinat Lokasi
                </h3>

                <div class="bg-blue-50 rounded-lg overflow-hidden mb-3 relative h-[150px]">
                  <div class="absolute inset-0 flex items-center justify-center bg-blue-100">
                    <iframe
                      src="https://maps.google.com/maps?q={{ $laporan->latitude }},{{ $laporan->longitude }}&z=15&output=embed"
                      width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                      referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                  </div>
                </div>

                <a href="https://maps.google.com/?q={{ $laporan->latitude }},{{ $laporan->longitude }}"
                  target="_blank"
                  class="text-sm text-blue-600 hover:text-blue-800 flex items-center justify-center gap-1 font-medium">
                  <i class="fa-solid fa-external-link"></i>
                  Buka di Google Maps
                </a>
              </div>
            </div>

            <!-- Horizontal line -->
            <div class="border-t border-gray-100 my-6"></div>

            <!-- Deskripsi Pengaduan -->
            <div class="mb-6">
              <h3 class="font-medium text-gray-900 flex items-center gap-2 mb-4">
                <i class="fa-solid fa-clipboard-list text-blue-600"></i>
                Deskripsi Pengaduan
              </h3>

              <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                <p class="text-gray-700 whitespace-pre-line">{{ $laporan->deskripsi_pengaduan }}</p>
              </div>
            </div>

            <!-- Foto Laporan (moved from separate card) -->
            <div>
              <h3 class="font-medium text-gray-900 flex items-center gap-2 mb-4">
                <i class="fa-solid fa-images text-blue-600"></i>
                Foto Laporan
                <span class="text-sm font-normal text-gray-500 ml-auto">
                  <i class="fa-solid fa-arrow-pointer"></i>
                  Klik untuk memperbesar
                </span>
              </h3>

              @if (count($laporan->foto) > 0)
                <div class="swiper mySwiper rounded-lg overflow-hidden h-[300px]">
                  <div class="swiper-wrapper">
                    @foreach ($laporan->foto as $foto)
                      <div class="swiper-slide">
                        <a href="{{ asset('storage/' . $foto->foto) }}" data-lightbox="foto-laporan"
                          data-title="Foto Laporan #{{ $loop->iteration }}">
                          <img src="{{ asset('storage/' . $foto->foto) }}" alt="Foto Laporan #{{ $loop->iteration }}"
                            class="w-full h-full object-contain hover:opacity-90 transition-opacity cursor-pointer" />
                        </a>
                      </div>
                    @endforeach
                  </div>
                  <div class="swiper-button-next text-blue-600"></div>
                  <div class="swiper-button-prev text-blue-600"></div>
                  <div class="swiper-pagination"></div>
                </div>

                <!-- Thumbnails Row -->
                <div class="grid grid-cols-4 sm:grid-cols-6 gap-2 mt-3">
                  @foreach ($laporan->foto as $foto)
                    <a href="{{ asset('storage/' . $foto->foto) }}" data-lightbox="foto-laporan-thumb"
                      data-title="Foto Laporan #{{ $loop->iteration }}" class="cursor-pointer">
                      <img src="{{ asset('storage/' . $foto->foto) }}" alt="Thumbnail #{{ $loop->iteration }}"
                        class="h-16 w-full object-cover rounded border hover:border-blue-500 hover:opacity-90 transition" />
                    </a>
                  @endforeach
                </div>
              @else
                <div class="bg-gray-50 rounded-lg p-8 flex flex-col items-center justify-center">
                  <i class="fa-solid fa-image text-gray-300 text-5xl mb-2"></i>
                  <p class="text-gray-500 text-center">Tidak ada foto yang dilampirkan pada pengaduan ini</p>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column - Timeline Only -->
      <div>
        <!-- Timeline Card - renamed from "Riwayat Tindak Lanjut" to "Detail Tindak Lanjut" -->
        <div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">
          <div class="bg-gray-50 px-6 py-4 border border-gray-200 rounded-t-xl">
            <h2 class="font-semibold text-lg flex items-center gap-2">
              <i class="fa-solid fa-timeline text-blue-600"></i>
              Detail Tindak Lanjut
            </h2>
          </div>

          <div class="p-6 border border-gray-200 rounded-b-xl">
            @if (count($laporan->tindakLanjut) > 0)
              <div class="relative space-y-6">
                @foreach ($laporan->tindakLanjut as $tindak)
                  @php
                    // Update timeline styling to match index page status colors
                    switch ($tindak->status) {
                        case 'pending':
                            $iconColor = 'bg-yellow-100 text-yellow-600';
                            $lineColor = 'bg-yellow-400';
                            break;
                        case 'diterima':
                            $iconColor = 'bg-blue-100 text-blue-600';
                            $lineColor = 'bg-blue-400';
                            break;
                        case 'menunggu_survei':
                            $iconColor = 'bg-pink-100 text-pink-600';
                            $lineColor = 'bg-pink-400';
                            break;
                        case 'sudah_disurvei':
                            $iconColor = 'bg-purple-100 text-purple-600';
                            $lineColor = 'bg-purple-400';
                            break;
                        case 'menunggu_jadwal_pengerjaan':
                            $iconColor = 'bg-orange-100 text-orange-600';
                            $lineColor = 'bg-orange-400';
                            break;
                        case 'sedang_dikerjakan':
                            $iconColor = 'bg-indigo-100 text-indigo-600';
                            $lineColor = 'bg-indigo-400';
                            break;
                        case 'selesai':
                            $iconColor = 'bg-green-100 text-green-600';
                            $lineColor = 'bg-green-400';
                            break;
                        default:
                            $iconColor = 'bg-gray-100 text-gray-600';
                            $lineColor = 'bg-gray-400';
                    }

                    // Set appropriate icon based on status
                    $timelineIcon = 'fa-clock';

                    switch ($tindak->status) {
                        case 'pending':
                            $timelineIcon = 'fa-clock';
                            break;
                        case 'diterima':
                            $timelineIcon = 'fa-clipboard-check';
                            break;
                        case 'menunggu_survei':
                            $timelineIcon = 'fa-calendar-check';
                            break;
                        case 'sudah_disurvei':
                            $timelineIcon = 'fa-magnifying-glass-location';
                            break;
                        case 'menunggu_jadwal_pengerjaan':
                            $timelineIcon = 'fa-calendar-days';
                            break;
                        case 'sedang_dikerjakan':
                            $timelineIcon = 'fa-person-digging';
                            break;
                        case 'selesai':
                            $timelineIcon = 'fa-circle-check';
                            break;
                    }
                  @endphp

                  <div class="relative flex items-start pl-10">
                    <!-- Timeline Line -->
                    @if (!$loop->last)
                      <div class="timeline-connector {{ $lineColor }}"></div>
                    @endif

                    <!-- Timeline Icon -->
                    <div class="absolute left-0 top-0">
                      <div
                        class="flex h-10 w-10 items-center justify-center rounded-full {{ $iconColor }} ring-4 ring-white z-10">
                        <i class="fa-solid {{ $timelineIcon }}"></i>
                      </div>
                    </div>

                    <!-- Timeline Content -->
                    <div class="flex-1 ml-4">
                      <!-- Changed from horizontal to vertical layout -->
                      <div class="mb-2">
                        <h3 class="font-medium 
                          {{ $tindak->status === 'pending' ? 'text-yellow-700' : '' }}
                          {{ $tindak->status === 'diterima' ? 'text-blue-700' : '' }}
                          {{ $tindak->status === 'menunggu_survei' ? 'text-pink-700' : '' }}
                          {{ $tindak->status === 'sudah_disurvei' ? 'text-purple-700' : '' }}
                          {{ $tindak->status === 'menunggu_jadwal_pengerjaan' ? 'text-orange-700' : '' }}
                          {{ $tindak->status === 'sedang_dikerjakan' ? 'text-indigo-700' : '' }}
                          {{ $tindak->status === 'selesai' ? 'text-green-700' : '' }}">
                          {{ $statusLabels[$tindak->status] ?? ucwords(str_replace('_', ' ', $tindak->status)) }}
                        </h3>
                        <time class="text-xs text-gray-500 block">
                          {{ \Carbon\Carbon::parse($tindak->created_at)->translatedFormat('d F Y H:i') }}
                        </time>
                      </div>

                      <div class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100 
                                {{ str_replace('text-', 'border-l-4 border-l-', str_replace('-600', '-400', $iconColor)) }}">
                        {{ $tindak->deskripsi }}
                      </div>

                      <!-- Foto Tindak Lanjut if exists -->
                      @if ($tindak->foto && count($tindak->foto) > 0)
                        <div class="mt-2">
                          <div class="grid grid-cols-3 gap-1.5">
                            @foreach ($tindak->foto as $ft)
                              <a href="{{ asset('storage/' . $ft->foto) }}"
                                data-lightbox="tindak-lanjut-{{ $tindak->id }}"
                                data-title="Foto Tindak Lanjut {{ ucwords(str_replace('_', ' ', $tindak->status)) }}">
                                <img src="{{ asset('storage/' . $ft->foto) }}" alt="Foto Tindak Lanjut"
                                  class="h-14 w-full object-cover rounded hover:opacity-80 transition" />
                              </a>
                            @endforeach
                          </div>
                        </div>
                      @endif
                    </div>
                  </div>
                @endforeach
              </div>
            @else
              <div class="flex flex-col items-center justify-center py-10 text-center">
                <i class="fa-regular fa-clock text-gray-300 text-5xl mb-3"></i>
                <h3 class="font-medium text-gray-700 mb-1">Belum Ada Tindakan</h3>
                <p class="text-gray-500 text-sm">
                  Belum ada tindak lanjut yang dilakukan untuk pengaduan ini
                </p>
              </div>
            @endif
          </div>
        </div>

        <!-- Back Button -->
        {{-- <a href="{{ route('guest.drainase-irigasi.pengaduan.index') }}"
          class="flex justify-center items-center gap-2 bg-white border border-gray-300 text-gray-700 px-5 py-3 rounded-lg hover:bg-gray-50 transition shadow-sm">
          <i class="fa-solid fa-arrow-left"></i>
          Kembali ke Daftar Pengaduan
        </a> --}}
      </div>
    </div>
  </div>
@endsection

@section('document.end')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Configure lightbox
      lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'albumLabel': "Foto %1 dari %2",
        'disableScrolling': true
      });

      // Initialize Swiper
      var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: {{ count($laporan->foto ?? []) > 1 ? 'true' : 'false' }},
        keyboard: {
          enabled: true,
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        }
      });
    });
  </script>

  <script>
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
