@extends('guest.layouts.jalanpeduli-publik')

@section('title', 'Peta Sebaran Laporan')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .form-input {
            border: 2px solid #e5e7eb;
            background: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            width: 100%;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }

        .form-label {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem; /* Menambah jarak antara ikon dan teks */
        }

        .btn-primary {
            background: #1d3d9a;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center; /* Tombol center */
            gap: 0.5rem;
            transition: all 0.3s ease;
            width: 100%; /* Membuat tombol memenuhi kolom */
        }

        .btn-primary:hover {
            background: rgba(29, 61, 154, 0.9);
            transform: scale(1.05);
        }

        .legend-filter-btn {
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            margin: 0.25rem;
        }

        .legend-filter-btn.active {
            border-color: #2563eb;
            background: rgba(37, 99, 235, 0.1);
            color: #1e3a8a;
        }

        .leaflet-container a {
            color: rgba(255, 255, 255, 0.7);
        }

        .legend-filter-btn.inactive {
            background: rgba(255, 255, 255, 0.7);
            color: #4b5563;
            border-color: rgba(255, 255, 255, 0.4);
        }

        .legend-filter-btn:hover:not(.active):not(.inactive) {
            background: rgba(243, 244, 246, 0.5);
            border-color: rgba(209, 213, 219, 0.5);
        }

        .legend-filter-btn img {
            width: 1rem;
            height: 1rem;
        }

        .legend-filter-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.5rem;
            margin: 1rem 0 1.5rem;
        }

        .popup-image-container {
            display: none; /* Sembunyikan gambar secara default */
        }
        
        /* Tampilkan gambar hanya di layar yang lebih besar dari 768px (desktop) */
        @media (min-width: 768px) {
            .popup-image-container {
                display: block;
            }
        }
        #publicMap {
            z-index: 0;
            position: relative;
        }
        .leaflet-control-zoom a {
            color: #000;
            background: #fff;
            font-size: 18px;
        }

    </style>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto mt-8">
        <form id="mapFilterForm" method="GET" class="glass-effect rounded-2xl p-6 shadow-lg">
            <div class="text-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Filter Pencarian Laporan</h3>
                <p class="text-sm text-gray-500">Gunakan filter untuk menemukan laporan spesifik.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <div class="md:col-span-1">
                    <label for="search" class="form-label">
                        <i class="fas fa-search text-gray-500"></i>
                        <span>Cari Laporan</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        </span>
                        <input
                            type="text"
                            id="search"
                            name="search"
                            class="form-input pl-10"
                            placeholder="ID Laporan, Jalan..."
                            value="{{ request('search') }}"
                            autocomplete="off"
                        >
                    </div>
                </div>

                <div class="md:col-span-1">
                    <label for="tingkat_kerusakan_filter" class="form-label">
                        <i class="fas fa-exclamation-triangle text-gray-500"></i>
                        <span>Tingkat Kerusakan</span>
                    </label>
                    <select
                        name="tingkat_kerusakan_filter"
                        id="tingkat_kerusakan_filter"
                        class="form-input"
                    >
                        <option value="" {{ request('tingkat_kerusakan_filter') == '' ? 'selected' : '' }}>Semua Tingkat</option>
                        <option value="Ringan" {{ request('tingkat_kerusakan_filter') == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                        <option value="Sedang" {{ request('tingkat_kerusakan_filter') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="Berat" {{ request('tingkat_kerusakan_filter') == 'Berat' ? 'selected' : '' }}>Berat</option>
                    </select>
                </div>

                <div class="md:col-span-1">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-filter"></i>
                        <span>Cari</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="max-w-4xl mx-auto mt-8">
        <div class="glass-effect rounded-2xl p-6 shadow-lg">
            <div class="text-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Statistik Laporan</h3>
                <p class="text-sm text-gray-500">Ringkasan laporan infrastruktur terkini</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach([
                    ['id' => 'belum-dikerjakan', 'icon' => 'fa-hourglass-half', 'color' => 'red-500', 'label' => 'Belum Dikerjakan'],
                    ['id' => 'sedang-dikerjakan', 'icon' => 'fa-spinner', 'color' => 'orange-500', 'label' => 'Sedang Dikerjakan'],
                    ['id' => 'telah-dikerjakan', 'icon' => 'fa-check-circle', 'color' => 'green-500', 'label' => 'Telah Dikerjakan'],
                    ['id' => 'telah-disurvei', 'icon' => 'fa-search-location', 'color' => 'blue-500', 'label' => 'Telah Disurvei'],
                    ['id' => 'disposisi', 'icon' => 'fa-file-alt', 'color' => 'purple-500', 'label' => 'Disposisi']
                ] as $stat)
                    <div class="glass-effect rounded-xl p-100 text-center">
                        <div class="bg-gray-100/80 rounded-lg p-3 mb-3 inline-block">
                            <i class="fas {{ $stat['icon'] }} text-{{ $stat['color'] }} text-xl"></i>
                        </div>
                        <h4 id="stat-{{ $stat['id'] }}" class="text-2xl font-bold text-{{ $stat['color'] }}">0</h4>
                        <p class="text-sm font-semibold text-gray-700">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto mt-12 bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-blue-900 bg-brand-blue text-white p-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-globe-asia text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-2">Peta Sebaran Laporan</h3>
                <p class="text-gray-200 max-w-xl mx-auto text-sm">
                    Visualisasi interaktif laporan infrastruktur jalan di seluruh wilayah
                </p>
            </div>
        </div>

        <div class="p-6 bg-gradient-to-br from-blue-50 via-white to-purple-50 rounded-b-2xl">
            <div class="legend-filter-container" id="legendFilters">
            @foreach([
                ['status' => '', 'label' => 'Semua', 'icon' => 'red-dot.png', 'active' => true],
                ['status' => 'belum_dikerjakan', 'label' => 'Belum Dikerjakan', 'icon' => 'yellow-dot.png'],
                ['status' => 'sedang_dikerjakan', 'label' => 'Sedang Dikerjakan', 'icon' => 'orange-dot.png'],
                ['status' => 'telah_dikerjakan', 'label' => 'Telah Dikerjakan', 'icon' => 'green-dot.png'],
                ['status' => 'telah_disurvei', 'label' => 'Telah Disurvei', 'icon' => 'blue-dot.png'],
                ['status' => 'disposisi', 'label' => 'Disposisi', 'icon' => 'purple-dot.png']
            ] as $filter)
                <button
                type="button"
                data-filter-status="{{ $filter['status'] }}"
                class="legend-filter-btn {{ $filter['active'] ?? false ? 'active' : 'inactive' }} shadow-md hover:scale-105"
                title="Filter {{ $filter['label'] }}"
                >
                <img src="{{ asset('image/map/' . $filter['icon']) }}" alt="{{ $filter['label'] }}" class="drop-shadow" />
                <span class="font-semibold">{{ $filter['label'] }}</span>
                </button>
            @endforeach
            </div>
            <div
            id="publicMap"
            class="h-96 w-full rounded-xl border-2 border-gray-200 shadow-2xl bg-gradient-to-tr from-gray-50 via-white to-blue-100"
            data-maptiler-token="{{ config('app.maptiler_token', 'YOUR_FALLBACK_MAPTILER_KEY') }}"
            data-map-data-url="{{ route('laporan.public.map.coordinates') }}"
            data-storage-base-url="{{ rtrim(Storage::url(''), '/') }}"
            >
            <div class="flex items-center justify-center h-full text-gray-500 animate-pulse">
                <i class="fas fa-spinner fa-spin mr-2 text-blue-600 text-2xl"></i>
                <span class="font-semibold">Memuat peta...</span>
            </div>
            </div>

            <div class="mt-4 text-center">
            <p class="text-sm text-gray-500 bg-white/70 rounded-lg inline-block px-4 py-2 shadow">
                <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                <span class="font-medium">Zoom dan klik penanda untuk detail laporan</span>
            </p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite(['resources/js/jalan-peduli/publik-map.js'])
@endsection