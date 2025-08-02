@extends('guest.layouts.jalanpeduli-publik')

@section('title', 'Cek Status Laporan Anda')

@section('styles')
    {{-- CSS Leaflet untuk Peta --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* Animasi kustom untuk memberikan "kehidupan" pada antarmuka */
        .fade-in { animation: fadeIn 0.5s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Efek denyut halus untuk ikon yang butuh perhatian */
        .pulse-soft { animation: pulseSoft 2.5s infinite cubic-bezier(0.4, 0, 0.6, 1); }
        @keyframes pulseSoft { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.1); opacity: 0.8; } }
        
        /* Transisi halus untuk kartu laporan saat di-hover */
        .card-hover { transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; }
        .card-hover:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        
        /* Overlay gradien pada gambar saat di-hover */
        .image-overlay { position: relative; overflow: hidden; }
        .image-overlay::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.2), rgba(147, 51, 234, 0.2));
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            z-index: 1;
        }
        .image-overlay:hover::before { opacity: 1; }
        
        /* Efek kilau (shine) pada status badge saat di-hover */
        .status-badge { position: relative; overflow: hidden; }
        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.6s ease;
        }
        .status-badge:hover::before { left: 100%; }
        
        /* Latar belakang gradien untuk area pencarian */
        /* .search-container-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); } */
        
        /* Efek kaca buram (glassmorphism) untuk form pencarian */
        .glass-effect {
            backdrop-filter: blur(12px) saturate(150%);
            -webkit-backdrop-filter: blur(12px) saturate(150%);
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(209, 213, 219, 0.3);
        }

        .collapse-container {
        overflow: hidden;
        max-height: 0;
        transition: max-height 0.5s ease-in-out;
        will-change: max-height;
        }
        .collapse-container.open {
            max-height: 2000px; /* Adjust based on content size; large enough to cover most cases */
        }
        img[data-src] {
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        }
        img[data-src].loaded {
            opacity: 1;
        }
    </style>
@endsection

@section('content')
    <div class="min-h-screen bg-gray-50">
        {{-- Hero Section dengan Pencarian --}}
        <div class="search-container-bg bg-brand-blue p-4 relative overflow-hidden">
            {{-- Elemen dekoratif untuk menambah kedalaman visual --}}
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="absolute inset-0 bg-primary-navy/90"></div>
            
            <div class="relative container mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                        <i class="fas fa-search-location text-3xl text-white"></i>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold text-white tracking-tight mb-4">
                        Lacak Status Laporan Anda
                    </h1>
                    <p class="text-lg md:text-xl text-white/90 max-w-3xl mx-auto">
                        Pantau perkembangan laporan infrastruktur jalan yang telah Anda kirimkan dengan mudah dan transparan.
                    </p>
                </div>

                {{-- Form Pencarian dengan Efek Glassmorphism --}}
                <form method="GET" action="{{ route('laporan.data') }}" class="max-w-4xl mx-auto">
                    <div class="glass-effect rounded-2xl p-6 sm:p-8 shadow-2xl">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                            <div class="md:col-span-12 lg:col-span-7">
                                <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-search mr-2" style="color: #1e293b;"></i>
                                    Cari ID Laporan atau Nama Jalan
                                </label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                        <i class="fas fa-search text-gray-400 group-focus-within:text-blue-600"></i>
                                    </span>
                                    <input
                                        type="text"
                                        id="search"
                                        name="search"
                                        class="block w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 text-base bg-white/80"
                                        placeholder="e.g., LPRN-12345, Jl. Merdeka"
                                        value="{{ request('search') }}"
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                            
                            <div class="md:col-span-6 lg:col-span-3">
                                <label for="status_filter" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-filter mr-2" style="color: #1a237e;"></i>
                                    Filter Status
                                </label>
                                <select name="status_filter" id="status_filter"
                                    class="block w-full py-3 px-4 border-2 border-gray-200 bg-white/80 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 text-base">
                                    <option value="" {{ request('status_filter') == '' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="belum_dikerjakan" {{ request('status_filter') == 'belum_dikerjakan' ? 'selected' : '' }}>Belum Dikerjakan</option>
                                    <option value="sedang_dikerjakan" {{ request('status_filter') == 'sedang_dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                                    <option value="telah_dikerjakan" {{ request('status_filter') == 'telah_dikerjakan' ? 'selected' : '' }}>Telah Dikerjakan</option>
                                    <option value="telah_disurvei" {{ request('status_filter') == 'telah_disurvei' ? 'selected' : '' }}>Telah Disurvei</option>
                                    <option value="disposisi" {{ request('status_filter') == 'disposisi' ? 'selected' : '' }}>Disposisi</option>
                                </select>
                            </div>
                            
                            <div class="md:col-span-6 lg:col-span-2">
                                <button id="btnFilterServer" type="submit"
                                        class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-xl shadow-lg text-base font-semibold text-white bg-brand-blue hover:bg-brand-blue/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-navy transform hover:scale-105 transition-transform duration-300">
                                    <i class="fas fa-search mr-2"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Konten Utama --}}
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            {{-- Notifikasi Sukses dan Error --}}
            @if(session('success'))
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 p-5 mb-8 rounded-xl shadow-lg fade-in" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-2xl text-green-500"></i>
                        <div class="ml-4">
                            <p class="font-bold text-lg">Berhasil!</p>
                            <p class="mt-1 text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 text-red-800 p-5 mb-8 rounded-xl shadow-lg fade-in" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
                        <div class="ml-4">
                            <p class="font-bold text-lg">Ada error :(</p>
                            <p class="mt-1 text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Konten Dinamis: Hasil Pencarian atau Tampilan Awal --}}
            @if(isset($laporans))
                @if($laporans->isEmpty())
                    {{-- Tampilan Jika Laporan Tidak Ditemukan --}}
                    <div class="bg-white border-2 border-dashed border-yellow-300 text-center p-12 mt-8 rounded-2xl shadow-lg fade-in">
                        <div class="max-w-md mx-auto">
                            <div class="w-24 h-24 mx-auto mb-6 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-search-minus text-5xl text-yellow-500"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3">Laporan Tidak Ditemukan</h3>
                            <p class="text-gray-600 mb-6 leading-relaxed">
                                Maaf, kami tidak dapat menemukan laporan untuk pencarian: <br>
                                <span class="font-semibold text-gray-800 mt-2 inline-block px-3 py-1 bg-yellow-100 rounded-full">"{{ request('search') }}"</span>
                            </p>
                            <div class="bg-yellow-50 rounded-xl p-4 text-left">
                                <p class="text-sm text-yellow-800">
                                    <strong class="flex items-center mb-2"><i class="fas fa-lightbulb mr-2"></i>Tips Pencarian:</strong>
                                    <ul class="list-disc list-inside space-y-1 text-yellow-700">
                                        <li>Pastikan ID laporan atau nomor HP sudah benar.</li>
                                        <li>Coba gunakan kata kunci yang lebih umum.</li>
                                        <li>Periksa kembali filter status yang Anda pilih.</li>
                                    </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Ringkasan Hasil Pencarian --}}
                    <div class="bg-brand-blue rounded-2xl p-1 mb-8 fade-in shadow-xl border-2 border-primary-navy/60">
                        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-5">
                            <div class="flex flex-col sm:flex-row items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-brand-blue rounded-full flex items-center justify-center flex-shrink-0 border-2 border-primary-navy shadow">
                                        <i class="fas fa-list-alt text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Hasil Pencarian</h3>
                                        <p class="text-sm text-gray-500">
                                            Menampilkan {{ $laporans->firstItem() }}-{{ $laporans->lastItem() }} dari <strong>{{ $laporans->total() }}</strong> laporan ditemukan.
                                        </p>
                                    </div>
                                </div>
                                <div class="hidden sm:flex items-center space-x-2 text-sm text-gray-600 mt-4 sm:mt-0">
                                    <i class="fas fa-clock"></i>
                                    <span>Diperbarui {{ now()->locale('id')->isoFormat('DD MMMM YYYY, HH:mm') }} WITA</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Loop untuk Menampilkan Kartu Laporan --}}
                    @foreach ($laporans as $laporan)
    @php
        $fotoArray = json_decode($laporan->foto_kerusakan, true);
        $fotoArray = is_array($fotoArray) ? $fotoArray : [];
        $statusNama = $laporan->status ? strtolower($laporan->status->nama_status) : 'tidak diketahui';
    @endphp

    {{-- Kartu Khusus untuk Status "Pending" (Tidak diubah karena sudah minimalis) --}}
    @if ($statusNama == 'pending')
        <div class="bg-white border-l-8 border-primary-navy rounded-2xl shadow-xl overflow-hidden mb-8 card-hover fade-in">
            <div class="p-8">
                <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8">
                    <div class="flex-shrink-0">
                        <div class="w-20 h-20 bg-primary-navy rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-hourglass-half text-3xl text-white pulse-soft"></i>
                        </div>
                    </div>
                    <div class="flex-grow text-center lg:text-left">
                        <div class="flex flex-col-reverse lg:flex-row lg:items-center lg:justify-between mb-4">
                            <div class="flex items-center justify-center lg:justify-start space-x-2 text-sm text-gray-600 mt-2 lg:mt-0">
                                <i class="fas fa-hashtag"></i>
                                <span>ID Laporan: <strong class="text-gray-800">{{ $laporan->id_laporan }}</strong></span>
                            </div>
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-primary-navy text-white shadow-md status-badge">
                                <i class="fas fa-hourglass-half mr-2"></i>
                                Menunggu Verifikasi
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-primary-navy mb-3">Laporan Sedang Diverifikasi</h3>
                        <p class="text-gray-700 mb-6 leading-relaxed max-w-2xl bg-secondary-pale-blue rounded-xl px-4 py-3 mx-auto lg:mx-0">
                            Terima kasih! Laporan Anda sedang dalam proses verifikasi oleh tim kami. Ini biasanya memakan waktu 1-2 hari kerja. Status akan diperbarui setelah verifikasi selesai.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="{{ route('laporan.download', ['id_laporan' => $laporan->id_laporan]) }}" target="_blank"
                               class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-semibold rounded-xl shadow-lg text-white bg-primary-navy hover:bg-primary-yellow hover:text-primary-navy transform hover:scale-105 transition-transform duration-300">
                                <i class="fas fa-download mr-2"></i>
                                Unduh Bukti Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- ========================================================== --}}
        {{--              AWAL DARI KARTU LAPORAN YANG BARU              --}}
        {{-- ========================================================== --}}

        {{-- Kartu Laporan Reguler dengan Detail Tersembunyi --}}
        <div x-data="{
            open: false,
            showFullDescription: false,
            showFullNotes: false,
            toggleDetails() {
                // Debounce toggle to prevent rapid clicks
                if (this.isToggling) return;
                this.isToggling = true;
                this.open = !this.open;
                setTimeout(() => { this.isToggling = false; }, 500);
                // Trigger lazy loading of images and iframes when opening
                if (this.open) {
                    this.loadLazyContent();
                }
            },
            loadLazyContent() {
                // Lazy load images
                document.querySelectorAll('img[data-src]').forEach(img => {
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                    img.removeAttribute('data-src');
                });
                // Lazy load iframes
                document.querySelectorAll('iframe[data-src]').forEach(iframe => {
                    iframe.src = iframe.dataset.src;
                    iframe.removeAttribute('data-src');
                });
            },
            isToggling: false
        }" class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8 border border-gray-200/50 card-hover fade-in">
        @php
        // Definisikan warna dan ikon berdasarkan status untuk kemudahan pengelolaan
        $statusInfo = [
            'belum_dikerjakan' => ['gradient' => 'from-yellow-400 to-orange-400', 'icon' => 'fas fa-hourglass-start', 'text' => 'Belum Dikerjakan', 'badge_bg' => 'bg-yellow-100 text-yellow-800'],
            'telah_dikerjakan' => ['gradient' => 'from-green-400 to-emerald-400', 'icon' => 'fas fa-check-circle', 'text' => 'Telah Dikerjakan', 'badge_bg' => 'bg-green-100 text-green-800'],
            'sedang_dikerjakan' => ['gradient' => 'from-blue-400 to-cyan-400', 'icon' => 'fas fa-cogs', 'text' => 'Sedang Dikerjakan', 'badge_bg' => 'bg-blue-100 text-blue-800'],
            'telah_disurvei' => ['gradient' => 'from-cyan-400 to-teal-400', 'icon' => 'fas fa-binoculars', 'text' => 'Telah Disurvei', 'badge_bg' => 'bg-cyan-100 text-cyan-800'],
            'disposisi' => ['gradient' => 'from-purple-400 to-pink-400', 'icon' => 'fas fa-share-square', 'text' => 'Disposisi', 'badge_bg' => 'bg-purple-100 text-purple-800'],
            'reject' => ['gradient' => 'from-red-400 to-rose-400', 'icon' => 'fas fa-times-circle', 'text' => 'Ditolak', 'badge_bg' => 'bg-red-100 text-red-800'],
            'tidak diketahui' => ['gradient' => 'from-gray-400 to-slate-400', 'icon' => 'fas fa-info-circle', 'text' => 'Tidak Diketahui', 'badge_bg' => 'bg-gray-100 text-gray-800'],
        ];
        $currentStatus = $statusInfo[$statusNama] ?? $statusInfo['tidak diketahui'];
    @endphp
            {{-- Baris Status Berwarna di Atas Kartu --}}
            <div class="h-2 bg-gradient-to-r {{ $currentStatus['gradient'] }}"></div>
            
            {{-- BAGIAN RINGKASAN (SELALU TERLIHAT) --}}
            <div class="p-6 cursor-pointer" @click="toggleDetails()">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    {{-- Info Utama (ID, Lokasi, Tanggal) --}}
                    <div class="flex-grow w-full">
                        <div class="flex items-center mb-2 flex-wrap gap-2">
                            <span class="text-xs font-bold {{ $currentStatus['badge_bg'] }} px-2 py-1 rounded-full mr-3">{{ $laporan->id_laporan }}</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $currentStatus['badge_bg'] }}">
                                <i class="{{ $currentStatus['icon'] }} mr-2"></i>
                                {{ $currentStatus['text'] }}
                            </span>
                        </div>
                        
                        {{-- Tampilan Ringkas Saat Detail Tertutup --}}
                        <div x-show="!open" class="flex flex-col md:flex-row md:items-center w-full">
                            <h3 class="text-xl font-bold text-gray-800 leading-tight mr-4 mb-2 md:mb-0">
                                {{ $laporan->alamat_lengkap_kerusakan }}
                            </h3>
                            <div class="flex flex-col md:flex-row md:items-center flex-wrap gap-2 md:gap-4">
                                <p class="text-sm text-gray-500 flex items-center">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    {{ \Carbon\Carbon::parse($laporan->created_at)->isoFormat('DD MMMM YYYY') }}
                                </p>
                                <span class="flex items-center text-sm text-gray-500 truncate max-w-[180px] sm:max-w-[220px] md:max-w-none">
                                    <i class="fas fa-city mr-1"></i>
                                    {{ $laporan->rt }}, {{ $laporan->kelurahan->nama ?? 'N/A' }}, {{ $laporan->kecamatan->nama ?? 'N/A' }}
                                </span>
                                <span class="flex items-center text-sm text-gray-500 truncate max-w-[150px] sm:max-w-[180px] md:max-w-none">
                                    <i class="fas fa-exclamation-triangle text-orange-500 mr-1"></i>
                                    {{ $laporan->tingkat_kerusakan ? ucfirst($laporan->tingkat_kerusakan) : 'N/A' }}
                                </span>
                                <span class="flex items-center text-sm text-gray-500 truncate max-w-[180px] sm:max-w-[220px] md:max-w-none">
                                    <i class="fas fa-tools text-purple-500 mr-1"></i>
                                    {{ $laporan->jenis_kerusakan ? ucfirst($laporan->jenis_kerusakan) : 'N/A' }}
                                </span>
                            </div>
                        </div>

                        {{-- Tampilan Detail Saat Terbuka --}}
                        <div x-show="open" class="mt-4 text-sm text-gray-600">
                            <h3 class="text-xl font-bold text-gray-800 leading-tight mr-4 mb-2 md:mb-0">
                                {{ $laporan->alamat_lengkap_kerusakan }}
                            </h3>
                            <p class="text-sm text-gray-500 flex items-center">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                {{ \Carbon\Carbon::parse($laporan->created_at)->isoFormat('DD MMMM YYYY') }}
                            </p>
                        </div>
                    </div>
                    
                    {{-- Tombol Aksi (Lihat Detail) --}}
                    <div class="flex-shrink-0 flex items-center gap-4 w-full sm:w-auto mt-4 sm:mt-0">
                        <button class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 border-2 border-gray-300 text-sm font-semibold rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                            <span x-text="open ? 'Sembunyikan Detail' : 'Lihat Detail'"></span>
                            <i class="fas fa-chevron-down ml-2 transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- BAGIAN DETAIL (TERSEMBUNYI SECARA DEFAULT) --}}
            <div class="collapse-container" :class="{ 'open': open }">
                <div class="border-t border-gray-200">
                    <div class="p-6 sm:p-8">
                        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
                            {{-- Kolom Kiri: Konten Utama --}}
                            <div class="xl:col-span-8">
                                {{-- Info Lokasi Rinci --}}
                                <div class="mb-8">
                                    <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-map-signs text-gray-500 mr-3"></i>Lokasi Detail
                                    </h4>
                                    <p class="text-gray-600 flex items-center">
                                        <i class="fas fa-city mr-2 text-gray-400"></i>
                                        Kel. {{ $laporan->kelurahan->nama ?? 'N/A' }}, Kec. {{ $laporan->kecamatan->nama ?? 'N/A' }}
                                    </p>
                                </div>

                                {{-- Deskripsi --}}
                                <div class="mb-8">
                                    <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center"><i class="fas fa-file-alt text-blue-500 mr-3"></i>Deskripsi Laporan</h4>
                                    @php
                                        $deskripsi = $laporan->deskripsi_laporan;
                                        $limit = 150;
                                        $isLongDescription = strlen($deskripsi) > $limit;
                                        $shortDescription = $isLongDescription ? substr($deskripsi, 0, $limit) . '...' : $deskripsi;
                                    @endphp
                                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                        <div class="text-gray-700 leading-relaxed space-y-2 break-words">
                                            <p x-show="!showFullDescription">{{ $shortDescription }}</p>
                                            <p x-show="showFullDescription" x-collapse>{{ $deskripsi }}</p>
                                        </div>
                                        @if($isLongDescription)
                                            <button @click="showFullDescription = !showFullDescription" class="text-sm font-semibold text-blue-600 hover:text-blue-800 hover:underline mt-3">
                                                <span x-text="showFullDescription ? 'Tutup' : 'Baca Selengkapnya'"></span>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                {{-- Dokumen Pendukung --}}
                                @if($laporan->dokumen_pendukung)
                                    <div class="mb-8">
                                        <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                            <i class="fas fa-file-pdf text-red-500 mr-3"></i>Dokumen Pendukung
                                        </h4>
                                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                            <div class="flex items-center">
                                                <i class="fas fa-file-pdf text-red-500 text-3xl mr-4"></i>
                                                <div>
                                                    <p class="text-sm text-gray-600 mb-1">Dokumen Pendukung Laporan</p>
                                                    <a href="{{ Storage::url('dokumen_pendukung/' . $laporan->dokumen_pendukung) }}" 
                                                    target="_blank" 
                                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        <i class="fas fa-download mr-2"></i> Lihat Dokumen
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Dokumentasi Kerusakan --}}
                                @if(!empty($fotoArray))
                                    <div class="mb-8">
                                        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center"><i class="fas fa-camera text-purple-500 mr-3"></i>Dokumentasi Kerusakan ({{ count($fotoArray) }} Foto)</h4>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                                            @foreach ($fotoArray as $index => $foto)
                                                <a href="{{ Storage::url('foto_kerusakan/' . $foto) }}" data-fancybox="gallery-{{$laporan->id_laporan}}" data-caption="Foto Kerusakan {{ $index + 1 }}"
                                                class="group relative aspect-square rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 image-overlay">
                                                    <img data-src="{{ Storage::url('foto_kerusakan/' . $foto) }}" alt="Foto Kerusakan {{ $index + 1 }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center">
                                                        <i class="fas fa-expand text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform group-hover:scale-125"></i>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Peta Lokasi --}}
                                @if($laporan->latitude && $laporan->longitude)
                                    <div class="mb-6">
                                        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center"><i class="fas fa-map-marked-alt text-green-500 mr-3"></i>Lokasi pada Peta</h4>
                                        <div class="w-full h-80 rounded-xl overflow-hidden shadow-lg border-2 border-gray-200">
                                            <iframe data-src="https://maps.google.com/maps?q={{$laporan->latitude}},{{$laporan->longitude}}&hl=id&z=16&output=embed" class="w-full h-full" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Kolom Kanan: Sidebar Status --}}
                            <div class="xl:col-span-4 xl:border-l xl:border-gray-200 xl:pl-8">
                                {{-- Detail Laporan --}}
                                <div class="space-y-4 mb-8">
                                    <h4 class="text-base font-semibold text-gray-500 mb-3 text-center xl:text-left">DETAIL LAPORAN</h4>
                                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-gray-600 flex items-center"><i class="fas fa-exclamation-triangle text-orange-500 mr-2"></i>Tingkat Kerusakan</span>
                                            <span class="font-bold text-gray-800 px-3 py-1 bg-white rounded-full text-sm shadow-sm">{{ $laporan->tingkat_kerusakan ? ucfirst($laporan->tingkat_kerusakan) : 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-gray-600 flex items-center"><i class="fas fa-tools text-purple-500 mr-2"></i>Jenis Kerusakan</span>
                                            <span class="font-bold text-gray-800 px-3 py-1 bg-white rounded-full text-sm shadow-sm">{{ $laporan->jenis_kerusakan ? ucfirst($laporan->jenis_kerusakan) : 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Catatan Petugas --}}
                                @if($laporan->keterangan)
                                    <div class="mb-8">
                                        <h4 class="text-base font-semibold text-gray-500 mb-3 text-center xl:text-left">CATATAN PETUGAS</h4>
                                        @php
                                            $catatan = $laporan->keterangan;
                                            $limitCatatan = 120;
                                            $isLongNotes = strlen($catatan) > $limitCatatan;
                                            $shortNotes = $isLongNotes ? substr($catatan, 0, $limitCatatan) . '...' : $catatan;
                                        @endphp
                                        <div class="bg-blue-50 rounded-xl p-5 border border-blue-200">
                                            <div class="text-blue-800 italic leading-relaxed text-center xl:text-left space-y-2 break-words">
                                                <p x-show="!showFullNotes">"{{ $shortNotes }}"</p>
                                                <p x-show="showFullNotes" x-collapse>"{{ $catatan }}"</p>
                                            </div>
                                            @if($isLongNotes)
                                                <div class="text-center xl:text-left">
                                                    <button @click="showFullNotes = !showFullNotes" class="text-sm font-semibold text-blue-600 hover:text-blue-800 hover:underline mt-3">
                                                        <span x-text="showFullNotes ? 'Tutup' : 'Baca Selengkapnya'"></span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                {{-- Dokumentasi Petugas --}}
                                @php
                                    $allowed_statuses = ['telah_disurvei', 'sedang_dikerjakan', 'telah_dikerjakan'];
                                @endphp
                                @if($laporan->status && in_array($statusNama, $allowed_statuses) && !empty($laporan->foto_lanjutan))
                                    @php
                                        $fotoLanjutanArray = json_decode($laporan->foto_lanjutan, true);
                                        if (json_last_error() !== JSON_ERROR_NONE || !is_array($fotoLanjutanArray)) {
                                            $fotoLanjutanArray = [$laporan->foto_lanjutan];
                                        }
                                    @endphp
                                    <div class="mb-8">
                                        <h4 class="text-base font-semibold text-gray-500 mb-4 text-center xl:text-left">DOKUMENTASI PETUGAS ({{ count($fotoLanjutanArray) }} Foto)</h4>
                                        <div class="grid grid-cols-2 gap-4">
                                            @foreach ($fotoLanjutanArray as $index => $fotoLanjutan)
                                                <a href="{{ Storage::url('foto_lanjutan/' . $fotoLanjutan) }}" data-fancybox="gallery-petugas-{{$laporan->id_laporan}}" data-caption="Dokumentasi Petugas {{ $index + 1 }}"
                                                class="group relative aspect-square rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 image-overlay">
                                                    <img data-src="{{ Storage::url('foto_lanjutan/' . $fotoLanjutan) }}" alt="Dokumentasi Petugas {{ $index + 1 }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center">
                                                        <i class="fas fa-expand text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                                                    </div>
                                                    <div class="absolute top-2 right-2 bg-green-600 text-white text-xs px-2 py-1 rounded-full font-semibold shadow-lg">Petugas</div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Bagian Feedback Pengguna --}}
                                @if($laporan->status && $statusNama == 'telah_dikerjakan')
                                    <div class="mt-8">
                                        @if($laporan->feedback)
                                            <div class="bg-green-50 rounded-xl p-6 border border-green-200 text-center xl:text-left">
                                                <h5 class="font-bold text-green-800 mb-3 flex items-center justify-center xl:justify-start"><i class="fas fa-heart text-red-500 mr-2"></i>Terima Kasih atas Ulasan Anda!</h5>
                                                <p class="text-green-700 italic mb-4">"{{ $laporan->feedback }}"</p>
                                                <div class="flex items-center justify-center xl:justify-start">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star text-xl {{ $i <= $laporan->rating_kepuasan ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                    @endfor
                                                    <span class="ml-2 text-sm font-semibold text-gray-700">({{ $laporan->rating_kepuasan }}/5)</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="bg-green-50 rounded-xl p-6 border-2 border-dashed border-green-300 text-center">
                                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4"><i class="fas fa-comment-dots text-green-600 text-xl"></i></div>
                                                <h5 class="font-semibold text-gray-800 mb-2">Pekerjaan Telah Selesai</h5>
                                                <p class="text-sm text-gray-600 mb-4">Bagaimana penilaian Anda terhadap hasilnya?</p>
                                                <a href="{{-- route('laporan.feedback.form', $laporan->id_laporan) --}}" class="inline-flex items-center px-5 py-2 border-2 border-green-400 text-sm font-semibold rounded-xl text-green-700 bg-white hover:bg-green-100 transform hover:scale-105 transition-all duration-300">
                                                    <i class="fas fa-edit mr-2"></i> Berikan Penilaian
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
    @endif
@endforeach
                    
                    {{-- Paginasi yang Ditingkatkan --}}
                    @if ($laporans->hasPages())
                        <div class="mt-12 flex flex-col items-center justify-center space-y-4 fade-in">
                            {{-- Tombol Navigasi Halaman --}}
                            <nav class="inline-flex rounded-xl shadow-lg overflow-hidden border border-gray-200 bg-white" aria-label="Pagination">
                                @php
                                    // Dapatkan semua elemen paginasi (angka, '...', dll.)
                                    $elements = $laporans->links()->elements;
                                @endphp

                                {{-- Tombol Previous --}}
                                @if ($laporans->onFirstPage())
                                    <span class="relative inline-flex items-center px-3 py-2 text-gray-400 bg-gray-100 cursor-not-allowed select-none">
                                        <span class="sr-only">Sebelumnya</span>
                                        <i class="fas fa-chevron-left h-5 w-5"></i>
                                    </span>
                                @else
                                    <a href="{{ $laporans->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors duration-200">
                                        <span class="sr-only">Sebelumnya</span>
                                        <i class="fas fa-chevron-left h-5 w-5"></i>
                                    </a>
                                @endif

                                {{-- Elemen Paginasi (Angka dan Elipsis '...') --}}
                                @foreach ($elements as $element)
                                    {{-- "Three Dots" Separator --}}
                                    @if (is_string($element))
                                        <span class="relative inline-flex items-center px-4 py-2 text-gray-500 bg-white select-none">{{ $element }}</span>
                                    @endif

                                    {{-- Array Halaman (Angka) --}}
                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $laporans->currentPage())
                                                <span aria-current="page" class="relative z-10 inline-flex items-center px-4 py-2 bg-primary-navy text-white font-bold shadow-inner">{{ $page }}</span>
                                            @else
                                                <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-primary-navy hover:bg-primary-navy/10 font-semibold transition-colors duration-200">{{ $page }}</a>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                                {{-- Tombol Next --}}
                                @if ($laporans->hasMorePages())
                                    <a href="{{ $laporans->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors duration-200">
                                        <span class="sr-only">Berikutnya</span>
                                        <i class="fas fa-chevron-right h-5 w-5"></i>
                                    </a>
                                @else
                                    <span class="relative inline-flex items-center px-3 py-2 text-gray-400 bg-gray-100 cursor-not-allowed select-none">
                                        <span class="sr-only">Berikutnya</span>
                                        <i class="fas fa-chevron-right h-5 w-5"></i>
                                    </span>
                                @endif
                            </nav>
                            
                            {{-- Teks Informasi Halaman --}}
                            <div class="text-sm text-gray-600">
                                Menampilkan 
                                <span class="font-semibold text-gray-800">{{ $laporans->firstItem() }}</span>
                                sampai
                                <span class="font-semibold text-gray-800">{{ $laporans->lastItem() }}</span>
                                dari
                                <span class="font-semibold text-gray-800">{{ $laporans->total() }}</span>
                                hasil
                            </div>
                        </div>
                    @endif
                @endif
            @else
                
            @endif

            
        </div>
    </div>
@endsection

@section('scripts') 
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    {{-- Fancybox untuk Galeri Foto (Opsional, tapi sangat direkomendasikan) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
      Fancybox.bind("[data-fancybox]", {
        // Opsi kustom jika diperlukan
      });
    </script>
@endsection