@extends('admin.layout')

@section('document.head')
  @vite('resources/css/leaflet.css')
@endsection

@section('document.body')
  <div class="sticky top-[80px] z-30 w-full">
    <div class="container mx-auto">
      <div class="backdrop-blur-sm rounded-xl">
        <div class="flex justify-between items-center bg-white p-3 rounded-xl shadow-lg border">
          <div class="flex items-center gap-2 flex-wrap">
            <button id="toggleFilterBtn" type="button"
              class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-400 transition-all duration-200 transform hover:scale-105">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
              </svg>
              <span id="toggleFilterBtnLabel">Tampilkan Filter</span>
            </button>
          </div>
        </div>
        <div id="filterPanel" class="mt-4 hidden shadow-lg">
          <div class="bg-white p-4 rounded-xl shadow-md border flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <form method="GET" action="" class="w-full">
              <div class="flex flex-col md:flex-row md:flex-wrap items-end gap-3">
                <div class="w-full md:w-[250px] lg:w-auto">
                  <input type="text" name="search" value="{{ request('search') }}" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Cari Laporan (ID Laporan / No. HP)...">
                </div>
                <div class="w-full md:flex-1">
                  <select name="tingkat_kerusakan_filter" class="block w-full py-2.5 px-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">Semua Tingkat</option>
                    <option value="ringan" {{ request('tingkat_kerusakan_filter') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                    <option value="sedang" {{ request('tingkat_kerusakan_filter') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="berat" {{ request('tingkat_kerusakan_filter') == 'berat' ? 'selected' : '' }}>Berat</option>
                  </select>
                </div>
                <div class="w-full md:flex-1">
                  <select name="jenis_kerusakan_filter" class="block w-full py-2.5 px-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">Semua Jenis</option>
                    <option value="Lubang-lubang" {{ request('jenis_kerusakan_filter') == 'Lubang-lubang' ? 'selected' : '' }}>Lubang-lubang</option>
                    <option value="Ambles" {{ request('jenis_kerusakan_filter') == 'Ambles' ? 'selected' : '' }}>Ambles</option>
                    <option value="Retak buaya" {{ request('jenis_kerusakan_filter') == 'Retak buaya' ? 'selected' : '' }}>Retak buaya</option>
                    <option value="Permukaan tergerus" {{ request('jenis_kerusakan_filter') == 'Permukaan tergerus' ? 'selected' : '' }}>Permukaan tergerus</option>
                    <option value="Penurunan slab di sambungan" {{ request('jenis_kerusakan_filter') == 'Penurunan slab di sambungan' ? 'selected' : '' }}>Penurunan slab di sambungan</option>
                    <option value="Slab pecah/retak di sambungan" {{ request('jenis_kerusakan_filter') == 'Slab pecah/retak di sambungan' ? 'selected' : '' }}>Slab pecah/retak di sambungan</option>
                    <option value="Permukaan tidak rata" {{ request('jenis_kerusakan_filter') == 'Permukaan tidak rata' ? 'selected' : '' }}>Permukaan tidak rata</option>
                    <option value="Longsor" {{ request('jenis_kerusakan_filter') == 'Longsor' ? 'selected' : '' }}>Longsor</option>
                  </select>
                </div>
                <div class="w-full md:flex-1">
                  <select name="status_kerusakan_filter" class="block w-full py-2.5 px-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">Semua Status</option>
                    <option value="disposisi" {{ request('status_kerusakan_filter') == 'disposisi' ? 'selected' : '' }}>Disposisi</option>
                    <option value="telah_disurvei" {{ request('status_kerusakan_filter') == 'telah_disurvei' ? 'selected' : '' }}>Telah Disurvei</option>
                    <option value="belum_dikerjakan" {{ request('status_kerusakan_filter') == 'belum_dikerjakan' ? 'selected' : '' }}>Belum Dikerjakan</option>
                    <option value="sedang_dikerjakan" {{ request('status_kerusakan_filter') == 'sedang_dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                    <option value="telah_dikerjakan" {{ request('status_kerusakan_filter') == 'telah_dikerjakan' ? 'selected' : '' }}>Telah Dikerjakan</option>
                  </select>
                </div>
                <div>
                  <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-400 transition-all duration-200">
                    Terapkan
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Konten utama --}}
  <div class="container mx-auto py-4 sm:py-6 lg:py-8">
    {{-- TODO: Ganti dengan loop data laporan dari backend --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-8">
      {{-- Dummy laporan untuk semua status --}}
      @php
        $dummyLaporan = [
          [
            'id' => '2024-001',
            'status' => 'Belum Dikerjakan',
            'gradient' => 'from-amber-400 to-orange-500',
            'badge' => 'bg-amber-100 text-amber-800',
            'alamat' => 'Jl. Dummy Raya No. 101',
            'kecamatan' => 'Kec. Contoh',
            'kelurahan' => 'Kel. Dummy',
            'jenis' => 'Berlubang',
            'tingkat' => 'Ringan',
            'tanggal' => '12 Juni 2024',
            'link' => 'https://maps.google.com/?q=-0.502106,117.153709',
            'keterangan' => 'Belum ada keterangan.',
          ],
          [
            'id' => '2024-002',
            'status' => 'Sedang Dikerjakan',
            'gradient' => 'from-sky-400 to-cyan-500',
            'badge' => 'bg-sky-100 text-sky-800',
            'alamat' => 'Jl. Dummy Raya No. 102',
            'kecamatan' => 'Kec. Contoh',
            'kelurahan' => 'Kel. Dummy',
            'jenis' => 'Retak buaya',
            'tingkat' => 'Sedang',
            'tanggal' => '13 Juni 2024',
            'link' => 'https://maps.google.com/?q=-0.505,117.16',
            'keterangan' => 'Sedang proses pengerjaan.',
          ],
          [
            'id' => '2024-003',
            'status' => 'Telah Dikerjakan',
            'gradient' => 'from-green-400 to-emerald-500',
            'badge' => 'bg-green-100 text-green-800',
            'alamat' => 'Jl. Dummy Raya No. 103',
            'kecamatan' => 'Kec. Contoh',
            'kelurahan' => 'Kel. Dummy',
            'jenis' => 'Ambles',
            'tingkat' => 'Berat',
            'tanggal' => '14 Juni 2024',
            'link' => 'https://maps.google.com/?q=-0.51,117.17',
            'keterangan' => 'Sudah selesai dikerjakan.',
          ],
          [
            'id' => '2024-004',
            'status' => 'Telah di Survei',
            'gradient' => 'from-cyan-400 to-teal-500',
            'badge' => 'bg-cyan-100 text-cyan-800',
            'alamat' => 'Jl. Dummy Raya No. 104',
            'kecamatan' => 'Kec. Contoh',
            'kelurahan' => 'Kel. Dummy',
            'jenis' => 'Permukaan tergerus',
            'tingkat' => 'Sedang',
            'tanggal' => '15 Juni 2024',
            'link' => 'https://maps.google.com/?q=-0.515,117.18',
            'keterangan' => 'Sudah disurvei, menunggu tindak lanjut.',
          ],
          [
            'id' => '2024-005',
            'status' => 'Disposisi',
            'gradient' => 'from-purple-400 to-fuchsia-500',
            'badge' => 'bg-purple-100 text-purple-800',
            'alamat' => 'Jl. Dummy Raya No. 105',
            'kecamatan' => 'Kec. Contoh',
            'kelurahan' => 'Kel. Dummy',
            'jenis' => 'Longsor',
            'tingkat' => 'Berat',
            'tanggal' => '16 Juni 2024',
            'link' => 'https://maps.google.com/?q=-0.52,117.19',
            'keterangan' => 'Perlu disposisi ke bidang terkait.',
          ],
        ];
      @endphp
      @foreach ($dummyLaporan as $laporan)
        <div class="bg-white rounded-2xl shadow-lg transition-all duration-300 hover:shadow-2xl transform hover:-translate-y-1 overflow-hidden border border-gray-200/50 flex flex-col">
          <div class="h-2 bg-gradient-to-r {{ $laporan['gradient'] }}"></div>
          <div class="p-5 flex-grow">
            <div class="flex justify-between items-center mb-4">
              <span class="text-xs font-bold bg-blue-50 text-blue-800 px-3 py-1 rounded-full">ID: {{ $laporan['id'] }}</span>
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $laporan['badge'] }}">
                {{ $laporan['status'] }}
              </span>
            </div>
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
              <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-gray-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                <div>
                  <h3 class="text-lg font-bold text-gray-800 leading-tight">{{ $laporan['alamat'] }}</h3>
                  <p class="text-sm text-gray-500">{{ $laporan['kecamatan'] }}, {{ $laporan['kelurahan'] }}</p>
                </div>
              </div>
              <hr class="my-4 border-slate-200">
              <div class="space-y-3 text-sm">
                <div class="flex items-center">
                  <span class="w-24 text-gray-500">Jenis</span>
                  <span class="font-semibold text-gray-700">: {{ $laporan['jenis'] }}</span>
                </div>
                <div class="flex items-center">
                  <span class="w-24 text-gray-500">Tingkat</span>
                  <span class="font-semibold text-gray-700">: {{ $laporan['tingkat'] }}</span>
                </div>
                <div class="flex items-center">
                  <span class="w-24 text-gray-500">Tanggal</span>
                  <span class="font-semibold text-gray-700">: {{ $laporan['tanggal'] }}</span>
                </div>
                <div class="flex items-center">
                  <span class="w-24 text-gray-500">Link Peta</span>
                  <span class="font-semibold text-gray-700">: <a href="{{ $laporan['link'] }}" target="_blank" class="text-blue-600 hover:underline">Lihat di Peta</a></span>
                </div>
              </div>
              @if($laporan['status'] === 'Disposisi')
                <blockquote class="mt-4 p-3 bg-purple-50 border-l-4 border-purple-400 rounded-r-lg">
                  <p class="text-sm text-purple-800 italic">"{{ $laporan['keterangan'] }}"</p>
                </blockquote>
              @else
                <blockquote class="mt-4 p-3 bg-gray-50 border-l-4 border-gray-300 rounded-r-lg">
                  <p class="text-sm text-gray-700 italic">{{ $laporan['keterangan'] }}</p>
                </blockquote>
              @endif
            </div>
          </div>
          <div class="px-5 pb-5 mt-auto">
            <div class="flex flex-wrap justify-end gap-3">
              {{-- TODO: Ganti href dan aksi dengan route dan id laporan dari backend --}}
              <a href="#" class="btn-hover bg-blue-600 text-white font-bold px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center justify-center gap-2 text-sm">
                <i class="fa-solid fa-eye"></i> Lihat
              </a>
              <a href="#" class="btn-hover bg-yellow-500 text-white font-bold px-4 py-2 rounded-lg hover:bg-yellow-600 flex items-center justify-center gap-2 text-sm">
                <i class="fa-solid fa-download"></i> Unduh
              </a>
              <a href="{{ route('admin.jalan-peduli.tindaklanjuti-laporan.edit', 1) }}" class="btn-hover bg-green-600 text-white font-bold px-4 py-2 rounded-lg hover:bg-green-700 flex items-center justify-center gap-2 text-sm">
                <i class="fa-solid fa-pen-to-square"></i> Edit
              </a>
              <button type="button" class="btn-hover bg-red-600 text-white font-bold px-4 py-2 rounded-lg hover:bg-red-700 flex items-center justify-center gap-2 text-sm">
                <i class="fa-solid fa-trash-can"></i> Hapus
              </button>
              {{-- TODO: Tambahkan modal konfirmasi hapus, dan aksi edit sesuai backend --}}
            </div>
          </div>
        </div>
      @endforeach
      {{-- TODO: Loop data laporan dari backend --}}
    </div>

    {{-- Dummy Pagination --}}
    <div class="mt-12 flex justify-center fade-in">
      <nav class="inline-flex rounded-xl shadow-lg overflow-hidden border border-gray-200 bg-white" aria-label="Pagination">
        <span class="px-4 py-2 text-gray-400 bg-gray-50 cursor-not-allowed select-none flex items-center">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
          </svg>
        </span>
        <span class="px-4 py-2 bg-primary-navy text-white font-bold shadow-inner">1</span>
        <a href="#" class="px-4 py-2 text-primary-navy hover:bg-primary-navy/10 font-semibold transition-colors">2</a>
        <a href="#" class="px-4 py-2 text-primary-navy hover:bg-primary-navy/10 font-semibold transition-colors flex items-center">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
        </a>
      </nav>
      <div class="ml-4 flex items-center text-sm text-gray-500">
        Halaman <span class="font-bold text-primary-navy mx-1">1</span> dari <span class="font-bold text-primary-navy mx-1">2</span>
      </div>
    </div>

    {{-- Dummy Map --}}
    <div class="mt-10">
      <h4 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Peta Lokasi Laporan</h4>
      <div id="map" class="relative z-0 h-[50vh] sm:h-96 w-full rounded-lg"></div>
    </div>
  </div>
@endsection

@section('document.end')
  @vite('resources/js/leaflet.js')
  <script>
    // Toggle filter panel logic (tradisional, sama seperti statistik-laporan)
    document.addEventListener('DOMContentLoaded', function() {
      var btn = document.getElementById('toggleFilterBtn');
      var panel = document.getElementById('filterPanel');
      var label = document.getElementById('toggleFilterBtnLabel');
      var isOpen = false;
      btn.addEventListener('click', function() {
        isOpen = !isOpen;
        panel.classList.toggle('hidden', !isOpen);
        label.textContent = isOpen ? 'Sembunyikan Filter' : 'Tampilkan Filter';
      });
      // Dummy Leaflet map untuk semua status
      if (window.L) {
        var map = L.map('map').setView([-0.502106, 117.153709], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 18,
          attribution: '© OpenStreetMap'
        }).addTo(map);

        const iconBelumDikerjakan = new L.Icon({
          iconUrl: '/image/map/yellow-dot.png',
          iconSize: [32, 32],
          iconAnchor: [16, 32],
          popupAnchor: [0, -32],
        });
        const iconSedangDikerjakan = new L.Icon({
          iconUrl: '/image/map/orange-dot.png',
          iconSize: [32, 32],
          iconAnchor: [16, 32],
          popupAnchor: [0, -32],
        });
        const iconTelahDikerjakan = new L.Icon({
          iconUrl: '/image/map/green-dot.png',
          iconSize: [32, 32],
          iconAnchor: [16, 32],
          popupAnchor: [0, -32],
        });
        const iconTelahDisurvei = new L.Icon({
          iconUrl: '/image/map/blue-dot.png',
          iconSize: [32, 32],
          iconAnchor: [16, 32],
          popupAnchor: [0, -32],
        });
        const iconDisposisi = new L.Icon({
          iconUrl: '/image/map/purple-dot.png',
          iconSize: [32, 32],
          iconAnchor: [16, 32],
          popupAnchor: [0, -32],
        });

        // Dummy marker data dengan icon sesuai status
        var dummyMarkers = [
          {
            id: '2024-001',
            lat: -0.502106,
            lng: 117.153709,
            status: 'Belum Dikerjakan',
            alamat: 'Jl. Dummy Raya No. 101',
            keterangan: 'Belum ada keterangan.',
            icon: iconBelumDikerjakan
          },
          {
            id: '2024-002',
            lat: -0.505,
            lng: 117.16,
            status: 'Sedang Dikerjakan',
            alamat: 'Jl. Dummy Raya No. 102',
            keterangan: 'Sedang proses pengerjaan.',
            icon: iconSedangDikerjakan
          },
          {
            id: '2024-003',
            lat: -0.51,
            lng: 117.17,
            status: 'Telah Dikerjakan',
            alamat: 'Jl. Dummy Raya No. 103',
            keterangan: 'Sudah selesai dikerjakan.',
            icon: iconTelahDikerjakan
          },
          {
            id: '2024-004',
            lat: -0.515,
            lng: 117.18,
            status: 'Telah di Survei',
            alamat: 'Jl. Dummy Raya No. 104',
            keterangan: 'Sudah disurvei, menunggu tindak lanjut.',
            icon: iconTelahDisurvei
          },
          {
            id: '2024-005',
            lat: -0.52,
            lng: 117.19,
            status: 'Disposisi',
            alamat: 'Jl. Dummy Raya No. 105',
            keterangan: 'Perlu disposisi ke bidang terkait.',
            icon: iconDisposisi
          }
        ];

        dummyMarkers.forEach(function(item) {
          L.marker([item.lat, item.lng], { icon: item.icon })
            .addTo(map)
            .bindPopup(
              `<div style="font-size:14px;">
                <b>ID:</b> ${item.id}<br>
                <b>Status:</b> ${item.status}<br>
                <b>Alamat:</b> ${item.alamat}<br>
                <b>Keterangan:</b> ${item.keterangan}
              </div>`
            );
        });
      }
    });
  </script>
@endsection
