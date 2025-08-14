@extends('guest.layouts.main')

@section('document.start')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <style>
    #map-sebaran {
      height: calc(100vh - 88px - 92px - 16px - 16px - 16px - 2.222px - 59.965px);
      min-height: 400px;
      width: 100%;
      z-index: 30;
    }

    .leaflet-control.custom-filter {
      background: #fff;
      border: 2px solid oklch(87.2% 0.01 258.338);
      border-radius: 4px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
      padding: 0;
      margin: 0;
      font-size: 16px;
      position: relative;
      z-index: 1000;
      display: inline-block;
      vertical-align: top;
    }

    .leaflet-control.custom-filter-group {
      display: flex;
      background: none;
      box-shadow: none;
      border: none;
      padding: 0;
      gap: 6px;
      margin: 8px 8px 0 8px;
      /* urutan: basemap, status, jenis */
    }

    .filter-status-btn {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 4px;
      background: #fff;
      border: none;
      outline: none;
      cursor: pointer;
      font-weight: 600;
      padding: 4px 8px;
      border-radius: 4px;
      transition: background 0.15s;
    }

    .filter-status-btn:hover,
    .filter-status-btn.active {
      background: #f3f4f6;
    }

    .filter-status-dropdown {
      display: none;
      position: absolute;
      right: 0;
      top: 110%;
      min-width: 265px;
      background: #fff;
      border: 1.5px solid #e5e7eb;
      border-radius: 4px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
      padding: 10px 12px 8px 12px;
      z-index: 9999;
    }

    .filter-status-dropdown.open {
      display: block;
      animation: fadeIn 0.13s;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-8px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .filter-status-dropdown .status-label {
      display: flex;
      align-items: center;
      margin-bottom: 6px;
      margin-right: 0;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      user-select: none;
    }

    .filter-status-dropdown .status-checkbox {
      accent-color: currentColor;
      margin-right: 7px;
      vertical-align: middle;
    }

    .filter-status-dropdown .dropdown-actions {
      margin-top: 6px;
      text-align: right;
    }

    .filter-status-dropdown .dropdown-actions button {
      font-size: 16px !important;
      padding: 4px 10px;
      border-radius: 4px;
      border: 1px solid #e5e7eb;
      background: #f3f4f6;
      cursor: pointer;
      font-size: medium;
    }

    .leaflet-control.custom-search {
      background: #fff;
      border: 2px solid oklch(87.2% 0.01 258.338);
      border-radius: 4px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
      font-size: 16px;
      padding: 4.75px 8px 4.75px 8px;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .custom-search-input {
      border: none;
      outline: none;
      background: transparent;
      font-size: 15px;
      width: 180px;
    }

    .custom-search-icon {
      color: #888;
      font-size: 16px;
      margin-right: 4px;
    }

    .leaflet-popup-content {
      min-width: 220px;
    }

    .status-badge {
      display: inline-block;
      padding: 2px 8px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 600;
      color: #fff;
      margin-bottom: 2px;
    }

    .status-pending {
      background: #f59e42;
    }

    .status-diterima {
      background: #3b82f6;
    }

    .status-menunggu_survei {
      background: #6366f1;
    }

    .status-sudah_disurvei {
      background: #06b6d4;
    }

    .status-menunggu_jadwal_pengerjaan {
      background: #eab308;
    }

    .status-sedang_dikerjakan {
      background: #f43f5e;
    }

    .status-selesai {
      background: #22c55e;
    }

    .status-checkbox {
      accent-color: currentColor;
      margin-right: 4px;
      vertical-align: middle;
    }

    .status-label {
      margin-right: 10px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      user-select: none;
    }

    .filter-jenis-btn {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 4px;
      background: #fff;
      border: none;
      outline: none;
      cursor: pointer;
      font-weight: 600;
      padding: 4px 8px;
      border-radius: 4px;
      transition: background 0.15s;
    }

    .filter-jenis-btn:hover,
    .filter-jenis-btn.active {
      background: #f3f4f6;
    }

    .filter-jenis-dropdown {
      display: none;
      position: absolute;
      right: 0;
      top: 110%;
      min-width: 210px;
      background: #fff;
      border: 1.5px solid #e5e7eb;
      border-radius: 4px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
      padding: 10px 12px 8px 12px;
      z-index: 9999;
    }

    .filter-jenis-dropdown.open {
      display: block;
      animation: fadeIn 0.13s;
    }

    .filter-jenis-dropdown .jenis-label {
      display: flex;
      align-items: center;
      margin-bottom: 6px;
      margin-right: 0;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      user-select: none;
    }

    .filter-jenis-dropdown .jenis-checkbox {
      accent-color: #6366f1;
      margin-right: 7px;
      vertical-align: middle;
    }

    .filter-jenis-dropdown .dropdown-actions {
      margin-top: 6px;
      text-align: right;
    }

    .filter-jenis-dropdown .dropdown-actions button {
      font-size: 16px;
      padding: 4px 10px;
      border-radius: 4px;
      border: 1px solid #e5e7eb;
      background: #f3f4f6;
      cursor: pointer;
      font-size: medium;
    }

    .leaflet-control.custom-basemap {
      background: #fff;
      border: 2px solid oklch(87.2% 0.01 258.338);
      border-radius: 4px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
      padding: 0;
      margin: 0;
      font-size: 16px;
      position: relative;
      z-index: 1000;
      display: inline-block;
      vertical-align: top;
    }

    .basemap-btn {
      display: flex;
      align-items: center;
      gap: 6px;
      background: #fff;
      border: none;
      outline: none;
      cursor: pointer;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 4px;
      transition: background 0.15s;
    }

    .basemap-btn:hover,
    .basemap-btn.active {
      background: #f3f4f6;
    }

    .basemap-dropdown {
      display: none;
      position: absolute;
      right: 0;
      top: 110%;
      min-width: 150px;
      background: #fff;
      border: 1.5px solid #e5e7eb;
      border-radius: 4px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
      padding: 8px 0;
      z-index: 9999;
    }

    .basemap-dropdown.open {
      display: block;
      animation: fadeIn 0.13s;
    }

    .basemap-dropdown .basemap-option {
      display: flex;
      align-items: center;
      width: 100%;
      padding: 7px 16px;
      font-size: 15px;
      color: #333;
      background: none;
      border: none;
      cursor: pointer;
      transition: background 0.13s;
    }

    .basemap-dropdown .basemap-option.active,
    .basemap-dropdown .basemap-option:hover {
      background: #f3f4f6;
      color: #2563eb;
    }

    /* Add styles for jenis badges */
    .jenis-badge {
      display: inline-block;
      padding: 2px 8px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 600;
      color: #fff;
      margin-bottom: 2px;
    }

    .jenis-belum_diklasifikasikan {
      background: #6b7280;
    }

    .jenis-darurat {
      background: #ef4444;
    }

    .jenis-biasa {
      background: #eab308;
    }

    .jenis-rutin {
      background: #3b82f6;
    }
  </style>
@endsection

@section('document.body')
  <div class="py-4 px-2 md:px-8">
    <div>
      <!-- Breadcrumb Navigation -->
      <nav aria-label="Breadcrumb" class="mb-1">
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
                <span>Peta Sebaran Hantu Banyu</span>
              </span>
            </div>
          </li>
        </ol>

        <!-- Mobile breadcrumb dots menu -->
        <div class="md:hidden mt-1">
          <div id="breadcrumb-dropdown"
            class="hidden z-50 absolute mt-2 bg-white divide-y divide-gray-100 rounded-lg shadow w-auto min-w-44">
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
                <span class="block px-4 py-2 font-semibold text-gray-600">Peta Sebaran Hantu Banyu</span>
              </li>
            </ol>
          </div>
        </div>
      </nav>
      <h1 class="text-2xl md:text-3xl font-bold mb-1">{{ $page_title }}</h1>
      <p class="mb-4 text-gray-600">{{ $meta_description }}</p>
    </div>
    <div id="map-sebaran" class="shadow border border-black"></div>
  </div>

  <!-- Hidden button to trigger the modal (needed for Flowbite initialization) -->
  <button id="modal-trigger-btn" data-modal-target="detail-laporan-modal" data-modal-toggle="detail-laporan-modal"
    class="hidden"></button>

  <!-- Detail Laporan Modal -->
  <div id="detail-laporan-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow">
        <!-- Modal header -->
        <div id="modal-header" class="flex items-center justify-between p-4 md:p-5 rounded-t border-b">
          <h3 class="text-xl font-semibold text-gray-900">
            <span id="modal-title">Nama Jalan</span>
          </h3>
          <button type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
            data-modal-hide="detail-laporan-modal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Tutup modal</span>
          </button>
        </div>

        <!-- Modal body -->
        <div class="p-4 md:p-5 space-y-3">
          <div class="grid grid-cols-3 gap-2">
            <div class="text-sm font-medium text-gray-500">Status:</div>
            <div class="col-span-2">
              <span id="modal-status-badge"
                class="text-sm font-medium py-0.5 px-2 rounded-full text-white inline-block">Status</span>
            </div>

            <div class="text-sm font-medium text-gray-500">Jenis:</div>
            <div class="col-span-2">
              <span id="modal-jenis-badge"
                class="text-sm font-medium py-0.5 px-2 rounded-full text-white inline-block">Jenis</span>
            </div>

            <div class="text-sm font-medium text-gray-500">Kecamatan:</div>
            <div id="modal-kecamatan" class="col-span-2 text-gray-900"></div>

            <div class="text-sm font-medium text-gray-500">Kelurahan:</div>
            <div id="modal-kelurahan" class="col-span-2 text-gray-900"></div>
          </div>
        </div>

        <!-- Modal footer -->
        <div class="flex justify-start gap-3 p-4 md:p-5 border-t border-gray-200 rounded-b flex-col sm:flex-row">
          <a id="modal-detail-link" href="#"
            class="text-white bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5">
            <i class="fa-solid fa-info-circle mr-1"></i>Lihat Foto & Detail
          </a>
          <a id="modal-gmaps-link" href="#" target="_blank"
            class="text-gray-600 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 rounded-lg text-sm px-4 py-2.5 inline-flex items-center">
            <i class="fa-solid fa-map-location-dot mr-1"></i>Lihat di Google Maps
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('document.end')
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <!-- Pastikan Font Awesome sudah di-load di layout utama -->

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

  <script>
    // --- Deklarasi jenisList di awal agar global ---
    const jenisList = [{
        value: "belum_diklasifikasikan",
        label: "Belum Diklasifikasikan"
      },
      {
        value: "darurat",
        label: "Darurat"
      },
      {
        value: "biasa",
        label: "Biasa"
      },
      {
        value: "rutin",
        label: "Rutin"
      }
    ];

    // Data laporan dari backend
    const laporanData = @json($laporan);
    const statusList = @json($statusList);

    // Warna pin per status
    const statusColors = {
      pending: "#f59e42",
      diterima: "#3b82f6",
      menunggu_survei: "#6366f1",
      sudah_disurvei: "#06b6d4",
      menunggu_jadwal_pengerjaan: "#eab308",
      sedang_dikerjakan: "#f43f5e",
      selesai: "#22c55e"
    };

    // Label status
    const statusLabels = {
      pending: "Pending",
      diterima: "Diterima",
      menunggu_survei: "Menunggu Survei",
      sudah_disurvei: "Sudah Disurvei",
      menunggu_jadwal_pengerjaan: "Menunggu Jadwal Pengerjaan",
      sedang_dikerjakan: "Sedang Dikerjakan",
      selesai: "Selesai"
    };

    // Label jenis
    const jenisLabels = {
      belum_diklasifikasikan: "Belum Diklasifikasikan",
      darurat: "Darurat",
      biasa: "Biasa",
      rutin: "Rutin"
    };

    // Warna jenis laporan
    const jenisColors = {
      belum_diklasifikasikan: "#6b7280", // gray
      darurat: "#ef4444", // red
      biasa: "#eab308", // yellow
      rutin: "#3b82f6" // blue
    };

    // Custom pin icon generator
    function pinIcon(color) {
      return L.divIcon({
        className: '',
        html: `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="40" viewBox="0 0 32 40">
          <path d="M16 0C7.163 0 0 7.163 0 16c0 10.667 16 24 16 24s16-13.333 16-24C32 7.163 24.837 0 16 0z" fill="${color}" stroke="#333" stroke-width="1"/>
          <circle cx="16" cy="16" r="7" fill="#fff" stroke="#333" stroke-width="1"/>
        </svg>`,
        iconSize: [32, 40],
        iconAnchor: [16, 40],
        popupAnchor: [0, -36]
      });
    }

    // --- Basemap Layer Definitions ---
    // Hanya 2 pilihan: Default (OpenStreetMap) & Satellite (World Imagery + Street)
    const baseLayers = {
      'Default': L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
      }),
      'Satellite': L.layerGroup([
        L.tileLayer(
          'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 19,
            attribution: 'Tiles &copy; Esri'
          }),
        L.tileLayer(
          'https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Transportation/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 19,
            attribution: 'Streets &copy; Esri'
          }),
        L.tileLayer(
          'https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 19,
            attribution: 'Labels &copy; Esri'
          }),
      ]),
    };
    let currentBaseLayer = baseLayers['Default'];

    // Inisialisasi peta
    const map = L.map('map-sebaran', {
      zoomControl: false
    }).setView([-0.4957, 117.1436], 13);
    currentBaseLayer.addTo(map);

    // Ensure map is centered on Samarinda and set a minimum zoom level
    map.setMinZoom(10);

    // Force center map on Samarinda after a brief delay to ensure proper initialization
    setTimeout(() => {
      map.setView([-0.4957, 117.1436], 13);
    }, 100);

    // Tambahkan zoom control ke kiri bawah
    L.control.zoom({
      position: 'bottomleft'
    }).addTo(map);

    // Layer group untuk marker
    const markerLayer = L.featureGroup().addTo(map);

    // Render semua marker
    function renderMarkers(filterStatusArr = [], searchNamaJalan = "", filterJenisArr = [], preserveView = false) {
      markerLayer.clearLayers();
      let found = false;
      laporanData.forEach(lap => {
        // Filter status (multi)
        if (filterStatusArr.length > 0 && !filterStatusArr.includes(lap.status_laporan)) return;
        // Filter jenis (multi)
        if (filterJenisArr.length > 0 && !filterJenisArr.includes(lap.jenis_laporan)) return;
        // Filter nama jalan
        if (searchNamaJalan && !(lap.nama_jalan || '').toLowerCase().includes(searchNamaJalan.toLowerCase())) return;

        // Pastikan ada koordinat
        if (!lap.latitude || !lap.longitude) return;

        // Pin color
        const color = statusColors[lap.status_laporan] || "#888";
        const icon = pinIcon(color);

        // Detail laporan
        const statusText = statusLabels[lap.status_laporan] || lap.status_laporan;
        const jenisText = jenisLabels[lap.jenis_laporan] || lap.jenis_laporan || "-";
        const kelurahan = lap.kelurahan?.nama || "-";
        const kecamatan = lap.kecamatan?.nama || "-";
        const namaJalan = lap.nama_jalan || "-";
        const deskripsi = lap.deskripsi_pengaduan || "-";
        const gmapsUrl = `https://maps.google.com/maps?q=${lap.latitude},${lap.longitude}`;

        // Create marker with click handler for modal
        const marker = L.marker([lap.latitude, lap.longitude], {
          icon
        });

        // When marker is clicked, update modal content and trigger it with Flowbite
        marker.on('click', function() {
          // Set modal content
          document.getElementById('modal-title').textContent = namaJalan;
          document.getElementById('modal-kelurahan').textContent = kelurahan;
          document.getElementById('modal-kecamatan').textContent = kecamatan;

          // Update status badge with appropriate color
          const statusBadge = document.getElementById('modal-status-badge');
          statusBadge.textContent = statusText;
          statusBadge.style.backgroundColor = color;

          // Update jenis badge with appropriate color
          const jenisBadge = document.getElementById('modal-jenis-badge');
          jenisBadge.textContent = jenisText;
          const jenisColor = jenisColors[lap.jenis_laporan] || "#6b7280"; // Default to gray
          jenisBadge.style.backgroundColor = jenisColor;

          // Set links
          document.getElementById('modal-gmaps-link').href = gmapsUrl;
          document.getElementById('modal-detail-link').href = `/drainase-irigasi/pengaduan/lihat/${lap.id}`;

          // Trigger the modal using the hidden button
          document.getElementById('modal-trigger-btn').click();
        });

        markerLayer.addLayer(marker);
        found = true;
      });

      // Only adjust map view if preserveView is false
      if (!preserveView) {
        // Jika ada hasil, fit bounds
        if (found) {
          try {
            const bounds = markerLayer.getBounds();
            if (bounds && bounds.isValid()) {
              map.fitBounds(bounds, {
                padding: [40, 40],
                maxZoom: 15 // Prevent zooming in too much
              });
            } else {
              // If no valid bounds, reset to Samarinda
              map.setView([-0.4957, 117.1436], 13);
            }
          } catch (error) {
            // On error, reset to Samarinda
            map.setView([-0.4957, 117.1436], 13);
            console.error("Error fitting bounds:", error);
          }
        } else {
          // If no markers found, reset to Samarinda
          map.setView([-0.4957, 117.1436], 13);
        }
      }
    }

    // --- Basemap Switcher Control ---
    L.Control.BasemapSwitcher = L.Control.extend({
      onAdd: function(map) {
        const div = L.DomUtil.create('div', 'leaflet-control custom-basemap');
        div.innerHTML = `
          <button type="button" class="basemap-btn" id="basemap-btn">
            <i class="fa-solid fa-layer-group"></i>
            <span>Basemap</span>
            <i class="fa-solid fa-chevron-down fa-xs"></i>
          </button>
          <div class="basemap-dropdown" id="basemap-dropdown">
            ${Object.keys(baseLayers).map(key => `
                    <button type="button" class="basemap-option" data-basemap="${key}">
                      ${key}
                    </button>
                  `).join('')}
          </div>
        `;
        L.DomEvent.disableClickPropagation(div);
        return div;
      }
    });

    // --- Filter Status & Jenis Control (Dropdown Checkbox) ---
    L.Control.FilterGroup = L.Control.extend({
      onAdd: function(map) {
        const groupDiv = L.DomUtil.create('div', 'leaflet-control custom-filter-group');
        // Basemap switcher (paling kiri)
        const basemapDiv = (new L.Control.BasemapSwitcher()).onAdd(map);
        // Status filter
        const statusDiv = document.createElement('div');
        statusDiv.className = 'leaflet-control custom-filter';
        statusDiv.style.position = 'relative';
        statusDiv.innerHTML = `
          <button type="button" class="filter-status-btn" id="filter-status-btn">
            <i class="fa-solid fa-filter"></i>
            <span>Status</span>
            <i class="fa-solid fa-chevron-down fa-xs"></i>
          </button>
          <div class="filter-status-dropdown" id="filter-status-dropdown">
            <div class="font-semibold mb-1">Pilih Status</div>
            <div id="status-filter-checkboxes">
              ${statusList.map(s => `
                            <label class="status-label" style="color:${statusColors[s] || '#333'}">
                              <input type="checkbox" class="status-checkbox" value="${s}" ${s !== 'pending' && s !== 'selesai' ? 'checked' : ''} />
                              ${statusLabels[s] || s}
                            </label>
                          `).join('')}
            </div>
            <div class="dropdown-actions">
              <button type="button" id="filter-status-clear">Reset</button>
            </div>
          </div>
        `;
        // Jenis filter
        const jenisDiv = document.createElement('div');
        jenisDiv.className = 'leaflet-control custom-filter';
        jenisDiv.style.position = 'relative';
        jenisDiv.innerHTML = `
          <button type="button" class="filter-jenis-btn" id="filter-jenis-btn">
            <i class="fa-solid fa-filter"></i>
            <span>Jenis</span>
            <i class="fa-solid fa-chevron-down fa-xs"></i>
          </button>
          <div class="filter-jenis-dropdown" id="filter-jenis-dropdown">
            <div class="font-semibold mb-1">Pilih Jenis</div>
            <div id="jenis-filter-checkboxes">
              ${jenisList.map(j => `
                <label class="jenis-label" style="color:${
                  j.value === 'belum_diklasifikasikan' ? '#222' :
                  j.value === 'darurat' ? '#ef4444' :
                  j.value === 'biasa' ? '#eab308' :
                  j.value === 'rutin' ? '#3b82f6' : '#222'
                }">
                  <input type="checkbox" class="jenis-checkbox" value="${j.value}" checked />
                  ${j.label}
                </label>
              `).join('')}
            </div>
            <div class="dropdown-actions">
              <button type="button" id="filter-jenis-clear">Reset</button>
            </div>
          </div>
        `;
        // Urutan: basemap, status, jenis
        groupDiv.appendChild(basemapDiv);
        groupDiv.appendChild(statusDiv);
        groupDiv.appendChild(jenisDiv);
        L.DomEvent.disableClickPropagation(groupDiv);
        return groupDiv;
      }
    });
    map.addControl(new L.Control.FilterGroup({
      position: 'topright'
    }));

    // --- Search Nama Jalan Control ---
    L.Control.NamaJalanSearch = L.Control.extend({
      onAdd: function(map) {
        const div = L.DomUtil.create('div', 'leaflet-control custom-search');
        div.innerHTML = `
          <i class="fa-solid fa-magnifying-glass custom-search-icon"></i>
          <input type="text" id="search-nama-jalan" placeholder="Cari nama jalan..." class="custom-search-input" />
        `;
        L.DomEvent.disableClickPropagation(div);
        return div;
      }
    });
    map.addControl(new L.Control.NamaJalanSearch({
      position: 'topleft'
    }));

    // --- Event listeners for filter & search & basemap ---
    let currentStatusArr = [];
    let currentJenisArr = [];
    let currentSearch = "";

    // Initialize filter arrays with all values except pending and selesai
    statusList.forEach(status => {
      if (status !== 'pending' && status !== 'selesai') {
        currentStatusArr.push(status);
      }
    });
    
    jenisList.forEach(jenis => {
      currentJenisArr.push(jenis.value);
    });

    document.addEventListener('DOMContentLoaded', function() {
      // Basemap switcher logic
      const basemapBtn = document.getElementById('basemap-btn');
      const basemapDropdown = document.getElementById('basemap-dropdown');
      const basemapOptions = basemapDropdown.querySelectorAll('.basemap-option');

      // Status
      const statusBtn = document.getElementById('filter-status-btn');
      const statusDropdown = document.getElementById('filter-status-dropdown');
      const statusClearBtn = document.getElementById('filter-status-clear');
      // Jenis
      const jenisBtn = document.getElementById('filter-jenis-btn');
      const jenisDropdown = document.getElementById('filter-jenis-dropdown');
      const jenisClearBtn = document.getElementById('filter-jenis-clear');
      
      // Function to close all dropdowns
      function closeAllDropdowns() {
        basemapDropdown.classList.remove('open');
        basemapBtn.classList.remove('active');
        statusDropdown.classList.remove('open');
        statusBtn.classList.remove('active');
        jenisDropdown.classList.remove('open');
        jenisBtn.classList.remove('active');
      }

      // Toggle basemap dropdown
      basemapBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        // Close all dropdowns first
        closeAllDropdowns();
        // Then open this one
        basemapDropdown.classList.toggle('open');
        basemapBtn.classList.toggle('active', basemapDropdown.classList.contains('open'));
      });

      // Toggle status dropdown
      statusBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        // Close all dropdowns first
        closeAllDropdowns();
        // Then open this one
        statusDropdown.classList.toggle('open');
        statusBtn.classList.toggle('active', statusDropdown.classList.contains('open'));
      });
      
      // Toggle jenis dropdown
      jenisBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        // Close all dropdowns first
        closeAllDropdowns();
        // Then open this one
        jenisDropdown.classList.toggle('open');
        jenisBtn.classList.toggle('active', jenisDropdown.classList.contains('open'));
      });

      // Close dropdown on outside click
      document.addEventListener('click', function(e) {
        if (!basemapDropdown.contains(e.target) && !basemapBtn.contains(e.target) &&
            !statusDropdown.contains(e.target) && !statusBtn.contains(e.target) &&
            !jenisDropdown.contains(e.target) && !jenisBtn.contains(e.target)) {
          closeAllDropdowns();
        }
      });

      // Basemap option click
      basemapOptions.forEach(opt => {
        opt.addEventListener('click', function() {
          const selected = this.getAttribute('data-basemap');
          // Remove current base layer
          map.removeLayer(currentBaseLayer);
          // Add new base layer
          currentBaseLayer = baseLayers[selected];
          currentBaseLayer.addTo(map);
          // Highlight active
          basemapOptions.forEach(o => o.classList.remove('active'));
          this.classList.add('active');
          // Close dropdown
          basemapDropdown.classList.remove('open');
          basemapBtn.classList.remove('active');
        });
      });

      // Set default active
      basemapOptions[0].classList.add('active');

      // Checkbox filter event (status)
      statusDropdown.addEventListener('change', function(e) {
        if (e.target && e.target.classList.contains('status-checkbox')) {
          const checked = Array.from(statusDropdown.querySelectorAll('.status-checkbox:checked')).map(cb => cb
            .value);
          currentStatusArr = checked;
          renderMarkers(currentStatusArr, currentSearch, currentJenisArr, true);
        }
      });
      // Checkbox filter event (jenis)
      jenisDropdown.addEventListener('change', function(e) {
        if (e.target && e.target.classList.contains('jenis-checkbox')) {
          const checked = Array.from(jenisDropdown.querySelectorAll('.jenis-checkbox:checked')).map(cb => cb
            .value);
          currentJenisArr = checked;
          renderMarkers(currentStatusArr, currentSearch, currentJenisArr, true);
        }
      });

      // Reset filter status
      statusClearBtn.addEventListener('click', function() {
        // Reset checkboxes to default state (all checked except pending and selesai)
        statusDropdown.querySelectorAll('.status-checkbox').forEach(cb => {
          cb.checked = cb.value !== 'pending' && cb.value !== 'selesai';
        });
        
        // Reset currentStatusArr to default state
        currentStatusArr = [];
        statusList.forEach(status => {
          if (status !== 'pending' && status !== 'selesai') {
            currentStatusArr.push(status);
          }
        });
        
        // Re-render markers with default filter state but preserve the current map view
        renderMarkers(currentStatusArr, currentSearch, currentJenisArr, true);
      });
      
      // Reset filter jenis
      jenisClearBtn.addEventListener('click', function() {
        // Reset checkboxes to default state (all checked)
        jenisDropdown.querySelectorAll('.jenis-checkbox').forEach(cb => {
          cb.checked = true;
        });
        
        // Reset currentJenisArr to default state (all jenis included)
        currentJenisArr = [];
        jenisList.forEach(jenis => {
          currentJenisArr.push(jenis.value);
        });
        
        // Re-render markers with default filter state but preserve the current map view
        renderMarkers(currentStatusArr, currentSearch, currentJenisArr, true);
      });
    });

    document.getElementById('search-nama-jalan').addEventListener('input', function() {
      currentSearch = this.value;
      renderMarkers(currentStatusArr, currentSearch, currentJenisArr, true);
    });

    // --- Initial render ---
    // Pass the filter arrays to only show non-pending, non-selesai markers initially
    renderMarkers(currentStatusArr, currentSearch, currentJenisArr);
  </script>
@endsection
