@extends('guest.layouts.jalanpeduli-publik')

@section('title', 'Form Laporan Kerusakan Jalan')

@section('styles')
    {{-- CSRF Token, penting untuk AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Leaflet CSS (wajib untuk peta) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    {{-- Font Awesome for Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    {{-- Custom CSS for Modern UI --}}
    <style>
        :root {
            --primary-yellow: #f9a825;
            --primary-navy: #1a237e;
            --secondary-light-gray: #f3f4f6;
            --secondary-pale-blue: #dbeafe;
            --secondary-pale-yellow: #fef08a;
            --gray-100: #f7fafc;
            --gray-200: #edf2f7;
            --gray-400: #a0aec0;
            --gray-500: #718096;
            --gray-600: #4a5568;
            --gray-800: #1a202c;
            --white: #ffffff;
            --red-500: #ef4444;
            --red-100: #fee2e2;
            --lime-100: #f0fdf4;
            --lime-400: #a3e635;
            --lime-800: #3f6212;
        }

        /* General Body Style */
        body {
            background-color: var(--secondary-light-gray);
        }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.65rem 1.25rem; /* Sedikit lebih kecil untuk mobile */
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem; /* Ukuran font disesuaikan */
            transition: all 0.2s ease-in-out;
            border: 1px solid transparent;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            white-space: nowrap; /* Mencegah teks tombol turun baris */
        }
        .btn-primary {
            background-color: var(--primary-navy);
            color: var(--white);
        }
        .btn-primary:hover {
            background-color: #2c3a9e; /* Slightly lighter navy */
        }
        .btn-secondary {
            background-color: var(--secondary-light-gray);
            color: var(--gray-800);
            border-color: var(--gray-200);
        }
        .btn-secondary:hover {
            background-color: var(--gray-200);
        }
        .btn-danger {
            background-color: var(--red-500);
            color: var(--white);
        }
        .btn-danger:hover {
            background-color: #dc2626; /* Slightly darker red */
        }
        .btn.disabled, .btn:disabled {
            background-color: var(--gray-400);
            cursor: not-allowed;
            opacity: 0.7;
        }

        /* Form Input Styles */
        .form-input, .form-textarea, .form-select {
            width: 100%;
            margin-top: 0.25rem;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            background-color: var(--white);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary-navy);
            box-shadow: 0 0 0 3px rgba(26, 35, 126, 0.2);
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-600);
        }

        /* Stepper Styles */
        .stepper-wrapper {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2.5rem;
            position: relative;
        }
        .stepper-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 33.33%;
            text-align: center;
            position: relative;
        }
        .step-counter {
            width: 36px; /* Dikecilkan untuk mobile */
            height: 36px; /* Dikecilkan untuk mobile */
            border-radius: 50%;
            background: var(--gray-200);
            border: 2px solid var(--gray-200);
            color: var(--gray-500);
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 0.5rem;
            font-weight: bold;
            font-size: 1rem; /* Disesuaikan */
            z-index: 2;
            transition: all 0.4s ease;
        }
        .stepper-item.active .step-counter {
            background-color: var(--white);
            border-color: var(--primary-navy);
            color: var(--primary-navy);
        }
        .stepper-item.completed .step-counter {
            background-color: var(--primary-navy);
            border-color: var(--primary-navy);
            color: var(--white);
        }
        .step-name {
            font-size: 0.75rem; /* Dikecilkan untuk mobile */
            font-weight: 500;
            color: var(--gray-500);
        }
        .stepper-item.active .step-name {
            font-weight: 600;
            color: var(--primary-navy);
        }
        .stepper-item.completed .step-name {
            color: var(--gray-800);
        }
        .stepper-progress {
            position: absolute;
            top: 18px; /* Disesuaikan dengan ukuran counter */
            left: 16.66%;
            right: 16.66%;
            height: 3px;
            background-color: var(--gray-200);
            z-index: 1;
        }
        #stepper-progress-bar {
            width: 0;
            height: 100%;
            background-color: var(--primary-navy);
            transition: width 0.4s ease;
        }
        /* PDF Modal Styles */
        #pdfModal .modal-content {
            width: 100%;
            max-width: 90vw;
            height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        #pdfModal .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid var(--gray-200);
            background-color: var(--white);
        }

        #pdfModal .modal-navigation {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem;
            border-bottom: 1px solid var(--gray-200);
            background-color: var(--gray-100);
        }

        #pdfModal .modal-navigation button {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0.375rem;
            transition: background-color 0.2s;
        }

        #pdfModal .modal-navigation button:disabled {
            background-color: var(--gray-400);
            cursor: not-allowed;
        }

        #pdfModal .modal-navigation .page-info {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-600);
        }

        #pdfModal .modal-body {
            flex-grow: 1;
            overflow: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--gray-50);
        }

        #pdfModal canvas {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        #pdfModal .loading-spinner {
            display: none;
            text-align: center;
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        #pdfModal .loading-spinner.active {
            display: block;
        }

        /* Ad Block Warning Modal Styles */
        #adBlockWarningModal .modal-content {
            width: 100%;
            max-width: 90vw;
            max-height: 90vh;
            background-color: var(--white);
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        #adBlockWarningModal .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        #adBlockWarningModal .modal-body {
            text-align: center;
            color: var(--gray-600);
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }
        #adBlockWarningModal .modal-footer {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        #adBlockWarningModal .btn {
            padding: 0.65rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease-in-out;
        }
        #adBlockWarningModal .btn-primary {
            background-color: var(--primary-navy);
            color: var(--white);
        }
        #adBlockWarningModal .btn-primary:hover {
            background-color: #2c3a9e;
        }
        #adBlockWarningModal .btn-secondary {
            background-color: var(--secondary-light-gray);
            color: var(--gray-800);
            border-color: var(--gray-200);
        }
        #adBlockWarningModal .btn-secondary:hover {
            background-color: var(--gray-200);
        }

    </style>
@endsection

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-4xl mx-auto bg-white p-4 sm:p-8 rounded-2xl shadow-lg">

        <div class="text-center mb-8">
            <h1 class="text-2xl sm:text-4xl font-bold text-gray-800 tracking-tight">Form Laporan Kerusakan Jalan</h1>
            <p class="text-gray-500 text-sm sm:text-base mt-2">Laporkan kerusakan jalan di Kota Samarinda dengan mudah.</p>
        </div>

        {{-- SUCCESS NOTIFICATION --}}
        @if (session('success_data'))
            <div id="success-notification-block" class="bg-lime-100 border-l-4 border-lime-400 p-4 rounded-lg mb-8 text-center">
                <p class="text-lime-800 font-semibold text-base">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success_data.message') }}
                </p>
                <div class="mt-4 pt-4 border-t border-lime-300 flex flex-col items-center justify-center gap-3">
                    <p class="font-semibold text-gray-700 text-xs sm:text-sm">
                        UNDUH BUKTI LAPORAN ANDA:
                    </p>
                    <a href="{{ route('laporan.download', ['id_laporan' => session('success_data.id_laporan')]) }}" target="_blank" class="btn btn-primary shrink-0 w-full sm:w-auto">
                        <i class="fas fa-download mr-2"></i> Download Tanda Terima
                    </a>
                </div>
            </div>
        @endif

        {{-- VALIDATION ERROR NOTIFICATION --}}
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded-md" role="alert">
                <h5 class="font-bold mb-2 text-sm">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    @if ($errors->has('lokasi'))
                        Gagal Mengirim Laporan
                    @else
                        Terjadi Kesalahan Validasi
                    @endif
                </h5>
                @if ($errors->has('lokasi'))
                    <p class="text-xs">{!! $errors->first('lokasi') !!}</p>
                @endif
                @php
                    $otherErrors = $errors->getMessages();
                    unset($otherErrors['lokasi']);
                @endphp
                @if (!empty($otherErrors))
                    <ul class="list-disc list-inside text-xs mt-2">
                        @foreach ($otherErrors as $fieldErrors)
                            @foreach ($fieldErrors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif
        
        {{-- SERVER ERROR NOTIFICATION --}}
        @if (session('error_server'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded-md" role="alert">
                <p class="text-sm"><i class="fas fa-server mr-2"></i>{{ session('error_server') }}</p>
            </div>
        @endif

        {{-- Main Logic: Show Form or "Create New Report" Button --}}
        @if (!session('success_data'))
            {{-- STEPPER --}}
            <div class="stepper-wrapper">
                <div class="stepper-progress"><div id="stepper-progress-bar"></div></div>
                <div id="stepper-item-1" class="stepper-item"><div class="step-counter">1</div><div class="step-name">Data Diri</div></div>
                <div id="stepper-item-2" class="stepper-item"><div class="step-counter">2</div><div class="step-name">Detail</div></div>
                <div id="stepper-item-3" class="stepper-item"><div class="step-counter">3</div><div class="step-name">Kirim</div></div>
            </div>

            {{-- ** PERBAIKAN RESPONSIVE ** Guide & Reset Buttons --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 p-4 bg-secondary-pale-blue rounded-lg border border-blue-200">
                <div class="w-full sm:w-auto">
                    <span class="font-semibold text-base text-primary-navy">Butuh Bantuan?</span>
                    <p class="text-sm text-gray-600 mt-1">Pelajari langkah pelaporan di sini.</p>
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="button" id="openPdfModalBtn" class="btn btn-primary w-1/2 sm:w-auto"><i class="fas fa-book-open mr-2"></i>Panduan</button>
                    <button type="button" id="resetFormBtn" class="btn btn-danger w-1/2 sm:w-auto"><i class="fas fa-sync-alt mr-2"></i> Reset</button>
                </div>
            </div>
            
            <form id="laporanForm" action="{{ route('guest.jalan-peduli.laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- STEP 1: Reporter Data --}}
                <div id="step-1" class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-700 border-b pb-3">Langkah 1: Data Diri Pelapor</h2>
                    <div>
                        <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-input" placeholder="Masukkan nama lengkap Anda" value="{{ old('nama_lengkap') }}" required>
                    </div>
                    <div>
                        <label for="nomor_ponsel" class="form-label">Nomor Ponsel (WA) <span class="text-red-500">*</span></label>
                        <input type="tel" minlength="10" maxlength="13" placeholder="Contoh: 081234567890" id="nomor_ponsel" name="nomor_ponsel" class="form-input" value="{{ old('nomor_ponsel') }}" required>
                    </div>
                     <div>
                        <label for="email" class="form-label">Email <span class="text-gray-400">(Opsional)</span></label>
                        <input type="email" id="email" name="email" class="form-input" placeholder="Contoh: nama@email.com" value="{{ old('email') }}">
                    </div>
                    <div>
                        <label for="alamat_pelapor" class="form-label">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea id="alamat_pelapor" name="alamat_pelapor" rows="3" class="form-textarea" placeholder="Masukkan alamat sesuai KTP" required>{{ old('alamat_pelapor') }}</textarea>
                    </div>
                    {{-- ** PERBAIKAN RESPONSIVE ** Grid diubah jadi 1 kolom di mobile --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="kecamatan_id" class="form-label">Kecamatan <span class="text-red-500">*</span></label>
                            <select id="kecamatan_id" name="kecamatan_id" class="form-select" required>
                                <option value="" disabled {{ old('kecamatan_id') ? '' : 'selected' }}>-- Pilih Kecamatan --</option>
                                @foreach($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="kelurahan_id" class="form-label">Kelurahan <span class="text-red-500">*</span></label>
                            <select id="kelurahan_id" name="kelurahan_id" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Kecamatan Dulu --</option>
                            </select>
                        </div>
                    </div>
                    {{-- ** PERBAIKAN RESPONSIVE ** Flex diubah jadi 1 kolom di mobile --}}
                     <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="rt_pelapor" class="form-label">RT <span class="text-gray-400">(Ops)</span></label>
                            <input type="text" id="rt_pelapor" name="rt_pelapor" maxlength="3" placeholder="002" class="form-input" value="{{ old('rt_pelapor') }}">
                        </div>
                        <div>
                            <label for="rw_pelapor" class="form-label">RW <span class="text-gray-400">(Ops)</span></label>
                            <input type="text" id="rw_pelapor" name="rw_pelapor" maxlength="3" placeholder="003" class="form-input" value="{{ old('rw_pelapor') }}">
                        </div>
                    </div>
                    <div class="flex justify-end pt-4">
                        <button type="button" class="btn btn-primary w-full sm:w-auto" onclick="nextStep()">Selanjutnya <i class="fas fa-arrow-right ml-2"></i></button>
                    </div>
                </div>

                {{-- STEP 2: Report Data --}}
                <div id="step-2" class="space-y-6" style="display:none;">
                    <h2 class="text-xl font-semibold text-gray-700 border-b pb-3">Langkah 2: Detail Lokasi & Bukti</h2>
                     <div>
                        <label for="alamat_lengkap_kerusakan" class="form-label">Alamat Lokasi Kerusakan<span class="text-red-500">*</span></label>
                        <textarea placeholder="Pilih lokasi pada peta untuk mengisi alamat." id="alamat_lengkap_kerusakan" name="alamat_lengkap_kerusakan" rows="3" class="form-textarea" required>{{ old('alamat_lengkap_kerusakan') }}</textarea>
                    </div>
                    {{-- ** PERBAIKAN RESPONSIVE ** Grid diubah jadi 1 kolom di mobile --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="lokasi_kecamatan_id" class="form-label">Kecamatan (Lokasi)<span class="text-red-500">*</span></label>
                            <select id="lokasi_kecamatan_id" name="lokasi_kecamatan_id" class="form-select" required>
                                <option value="" disabled {{ old('lokasi_kecamatan_id') ? '' : 'selected' }}>-- Pilih Kecamatan --</option>
                                @foreach($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->id }}" {{ old('lokasi_kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="lokasi_kelurahan_id" class="form-label">Kelurahan (Lokasi)<span class="text-red-500">*</span></label>
                            <select id="lokasi_kelurahan_id" name="lokasi_kelurahan_id" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Kecamatan Dulu --</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Tentukan Titik Koordinat <span class="text-red-500">*</span></label>
                         <div class="mt-2 p-4 border rounded-lg bg-gray-50 space-y-4">
                            {{-- ** PERBAIKAN RESPONSIVE ** Tombol dibuat full-width di mobile --}}
                            <div class="flex flex-col sm:flex-row gap-3">
                                <button type="button" id="gunakanLokasiBtn" class="btn bg-green-600 hover:bg-green-700 text-white w-full sm:w-auto"><i class="fas fa-map-marker-alt mr-2"></i>Gunakan Lokasi Saya</button>
                                <button type="button" id="pilihLokasiBtn" class="btn btn-primary w-full sm:w-auto"><i class="fas fa-map-marked-alt mr-2"></i>Pilih dari Peta</button>
                            </div>
                            {{-- ** PERBAIKAN RESPONSIVE ** Grid jadi 1 kolom di mobile --}}
                             <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="latitude" class="text-sm font-medium text-gray-600">Latitude</label>
                                    <input type="text" name="latitude" id="latitude" class="form-input bg-gray-100 mt-1" value="{{ old('latitude') }}" placeholder="Otomatis" readonly>
                                </div>
                                <div>
                                    <label for="longitude" class="text-sm font-medium text-gray-600">Longitude</label>
                                    <input type="text" name="longitude" id="longitude" class="form-input bg-gray-100 mt-1" value="{{ old('longitude') }}" placeholder="Otomatis" readonly>
                                </div>
                            </div>
                             <input type="text" name="link_koordinat" id="link_koordinat" class="form-input bg-gray-100" value="{{ old('link_koordinat') }}" placeholder="Link Google Maps otomatis" readonly>
                        </div>
                    </div>
                     <div>
                        <label for="deskripsi_laporan" class="form-label">Deskripsi Laporan<span class="text-red-500">*</span></label>
                        <textarea name="deskripsi_laporan" id="deskripsi_laporan" rows="4" class="form-textarea" placeholder="Jelaskan kondisi kerusakan..." required>{{ old('deskripsi_laporan') }}</textarea>
                    </div>
                    <div>
                        <label class="form-label">Foto Bukti (Maks. 3) <span class="text-red-500">*</span></label>
                        <div class="mt-2 p-4 border-2 border-dashed border-gray-300 rounded-lg">
                            <div id="preview_container" class="flex flex-row flex-wrap gap-4 items-center">
                                <label for="foto_kerusakan" id="upload_box" class="flex flex-col items-center justify-center w-24 h-24 sm:w-28 sm:h-28 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors shrink-0">
                                    <div class="text-center text-gray-500">
                                        <i class="fas fa-camera fa-2x"></i>
                                        <p class="text-xs font-semibold mt-2">Tambah Foto</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <input type="file" name="foto_kerusakan[]" id="foto_kerusakan" accept="image/jpeg,image/png,image/jpg" multiple class="sr-only">
                        <p class="mt-2 text-xs text-gray-500">*Format: JPG/PNG, maks. 10MB/foto.</p>
                        <input type="hidden" name="jenis_kerusakan" id="jenis_kerusakan">
                        <input type="hidden" name="tingkat_kerusakan" id="tingkat_kerusakan">
                    </div>
                    <div>
                        <label for="dokumen_pendukung" class="form-label">Dokumen Pendukung <span class="text-gray-400">(Ops)</span></label>
                        <input type="file" name="dokumen_pendukung" id="dokumen_pendukung" accept="application/pdf" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-secondary-pale-blue file:text-primary-navy hover:file:bg-blue-200" />
                        <p class="mt-2 text-xs text-gray-500">*Opsional, format PDF (misal: surat dari RT/RW).</p>
                    </div>
                    {{-- ** PERBAIKAN RESPONSIVE ** Tombol full-width di mobile --}}
                    <div class="flex flex-col-reverse sm:flex-row justify-between pt-4 gap-3">
                        <button type="button" class="btn btn-secondary w-full sm:w-auto" onclick="prevStep()"><i class="fas fa-arrow-left mr-2"></i>Kembali</button>
                        <button type="button" class="btn btn-primary w-full sm:w-auto" onclick="nextStep()">Selanjutnya <i class="fas fa-arrow-right ml-2"></i></button>
                    </div>
                </div>

                {{-- STEP 3: Confirmation --}}
                <div id="step-3" class="space-y-6" style="display:none;">
                    <h2 class="text-xl font-semibold text-gray-700 border-b pb-3">Langkah 3: Konfirmasi & Kirim</h2>
                    <div>
                        <label class="form-label">Rating Proses Pelaporan<span class="text-red-500">*</span></label>
                        <div id="star-rating" class="flex items-center text-4xl cursor-pointer text-gray-300 mt-2">
                            <span class="star transition-colors duration-200" data-value="1">★</span>
                            <span class="star transition-colors duration-200" data-value="2">★</span>
                            <span class="star transition-colors duration-200" data-value="3">★</span>
                            <span class="star transition-colors duration-200" data-value="4">★</span>
                            <span class="star transition-colors duration-200" data-value="5">★</span>
                        </div>
                        <input type="hidden" name="rating_kepuasan" id="rating_kepuasan" value="{{ old('rating_kepuasan') ?: 1 }}" required>
                    </div>
                     <div>
                        <label for="feedback" class="form-label">Feedback <span class="text-gray-400">(Ops)</span></label>
                        <textarea name="feedback" id="feedback" rows="4" class="form-textarea" placeholder="Berikan masukan untuk perbaikan layanan kami...">{{ old('feedback') }}</textarea>
                    </div>
                    <div class="flex justify-center py-4">
                        <div class="cf-turnstile" 
                            data-sitekey="{{ config('app.turnstile_sitekey') }}" 
                            data-callback="onCaptchaSuccess"
                            data-expired-callback="onCaptchaExpired"
                            data-error-callback="onCaptchaError"
                            data-theme="light">
                        </div>
                    </div>
                    <div id="captcha-error" class="text-center text-red-500 text-sm -mt-2" style="display: none;">Verifikasi Captcha gagal. Coba lagi.</div>

                    {{-- ** PERBAIKAN RESPONSIVE ** Tombol full-width di mobile --}}
                    <div class="flex flex-col-reverse sm:flex-row justify-between items-center pt-4 border-t mt-6 gap-3">
                        <button type="button" class="btn btn-secondary w-full sm:w-auto" onclick="prevStep()"><i class="fas fa-arrow-left mr-2"></i> Kembali</button>
                        <button type="submit" id="kirimLaporanBtn" class="btn bg-green-600 hover:bg-green-700 text-white disabled w-full sm:w-auto" disabled>
                            <i id="kirimIcon" class="fas fa-paper-plane mr-2"></i> 
                            <span id="kirimText">Kirim Laporan</span>
                        </button>
                    </div>
                </div>
            </form>
        @else
            {{-- "Create New Report" button if successful --}}
            <div class="text-center mt-8">
                <a href="{{ route('guest.jalan-peduli.laporan.create') }}" id="buatLaporanBaruBtn" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i> Buat Laporan Baru
                </a>
            </div>
        @endif
    </div>
</div>

{{-- ** PERBAIKAN RESPONSIVE ** Modal dibuat lebih ramah mobile --}}
{{-- Map Modal --}}
<div id="mapModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center p-2 sm:p-4 z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl h-[95vh] sm:h-[90vh] flex flex-col">
        <div class="flex justify-between items-center p-3 sm:p-4 border-b">
            <h3 class="text-base sm:text-lg font-medium text-gray-900">Pilih Lokasi di Peta</h3>
            <button id="closeMapModalBtn" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 p-1.5 rounded-lg"><i class="fas fa-times"></i></button>
        </div>
        <div class="p-3 sm:p-4 border-b">
            <div class="relative">
                <input type="text" id="addressSearch" placeholder="Cari jalan di Samarinda..." class="form-input w-full pl-4 pr-10 text-sm">
                <button id="searchButton" type="button" class="absolute inset-y-0 right-0 px-3 text-gray-500 hover:text-primary-navy"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <div id="map" class="flex-grow"></div>
        <div class="flex flex-col sm:flex-row items-center justify-end p-3 sm:p-4 border-t gap-3">
            <button id="cancelMapModalBtn" type="button" class="btn btn-secondary w-full sm:w-auto">Batal</button>
            <button id="simpanLokasiBtn" type="button" class="btn btn-primary w-full sm:w-auto">Simpan Lokasi</button>
        </div>
    </div>
</div>

{{-- PASTIKAN BLOK INI ADA --}}
<div id="pdfModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center p-2 sm:p-4 z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl h-[95vh] flex flex-col overflow-hidden">
        <div class="flex-shrink-0 flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-medium text-gray-900">Panduan Pelaporan</h3>
            <button id="closePdfModalBtn" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                <i class="fas fa-times fa-lg"></i>
            </button>
        </div>

        <div class="flex-grow w-full h-full">
            <iframe id="pdf-iframe" class="w-full h-full border-none"></iframe>
        </div>
    </div>
</div>

{{-- Ad Block Warning Modal --}}
<div id="adBlockWarningModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="p-6">
            <div class="flex justify-center mb-4">
                <i class="fas fa-exclamation-triangle text-4xl text-yellow-500"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 text-center mb-2">Peringatan</h3>
            <p class="text-sm text-gray-600 text-center mb-6">
                Kami mendeteksi ekstensi seperti Ad Blocker atau IDM yang mungkin mengganggu tampilan panduan. 
                Harap nonaktifkan sementara ekstensi tersebut untuk melihat panduan dengan benar.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button id="retryPdfBtn" class="btn btn-primary">
                    <i class="fas fa-sync-alt mr-2"></i>Coba Lagi
                </button>
                <button id="closeAdBlockModalBtn" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{-- Leaflet & Geocoder JS --}}
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    
    {{-- Anime.js for animations (optional but nice) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

    {{-- Cloudflare Turnstile CAPTCHA --}}
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

    {{-- TensorFlow.js --}}
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@4.22.0/dist/tf.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js"></script>

    {{-- App-specific JS --}}
    @vite(['resources/js/jalan-peduli/buat-laporan.js'])
    @vite(['resources/js/jalan-peduli/pdf-viewer.js'])

    <script>
        // Define global URLs for JS file
        // const STORE_LAPORAN_URL = 
        const VERIFY_CAPTCHA_URL = "/api/verify-captcha";
        const GET_KORDINAT_URL = "/api/kordinat";
        const KELURAHAN_BY_KECAMATAN_URL_PREFIX = "/api/kelurahans/by-kecamatan/";

        // Clear localStorage on successful submission
        @if (session('success_data'))
            document.addEventListener('DOMContentLoaded', function() {
                localStorage.removeItem('laporanFormState');
                localStorage.removeItem('laporanFormCurrentStep');

                // Auto-download functionality
                const downloadUrl = @json(session('success_data.download_url') ?? null);
                if (downloadUrl) {
                    const link = document.createElement('a');
                    link.href = downloadUrl;
                    link.setAttribute('download', 'Tanda-Terima-Laporan.pdf'); 
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            });
        @endif

        // Handle Kecamatan-Kelurahan Dropdown Dependencies
        document.addEventListener('DOMContentLoaded', function() {
            // Handler untuk dropdown kecamatan pelapor
            const kecamatanSelect = document.getElementById('kecamatan_id');
            const kelurahanSelect = document.getElementById('kelurahan_id');
            
            // Handler untuk dropdown kecamatan lokasi
            const lokasiKecamatanSelect = document.getElementById('lokasi_kecamatan_id');
            const lokasiKelurahanSelect = document.getElementById('lokasi_kelurahan_id');
            
            function updateKelurahans(kecamatanId, kelurahanDropdown, placeholderText = '-- Pilih Kelurahan --') {
                kelurahanDropdown.innerHTML = '<option value="" disabled selected>Loading...</option>';
                
                if (!kecamatanId) {
                    kelurahanDropdown.innerHTML = '<option value="" disabled selected>-- Pilih Kecamatan Dulu --</option>';
                    return;
                }
                
                fetch(`/api/kelurahans/by-kecamatan/${kecamatanId}`)
                    .then(response => response.json())
                    .then(data => {
                        kelurahanDropdown.innerHTML = `<option value="" disabled selected>${placeholderText}</option>`;
                        
                        if (data.success && data.data.length > 0) {
                            data.data.forEach(kelurahan => {
                                const option = document.createElement('option');
                                option.value = kelurahan.id;
                                option.textContent = kelurahan.nama;
                                kelurahanDropdown.appendChild(option);
                            });
                        } else {
                            kelurahanDropdown.innerHTML = '<option value="" disabled selected>Tidak ada data kelurahan</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        kelurahanDropdown.innerHTML = '<option value="" disabled selected>Error loading data</option>';
                    });
            }
            
            // Event listener untuk kecamatan pelapor
            if (kecamatanSelect) {
                kecamatanSelect.addEventListener('change', function() {
                    updateKelurahans(this.value, kelurahanSelect);
                });
            }
            
            // Event listener untuk kecamatan lokasi
            if (lokasiKecamatanSelect) {
                lokasiKecamatanSelect.addEventListener('change', function() {
                    updateKelurahans(this.value, lokasiKelurahanSelect);
                });
            }
        });

        // Frontend validation for foto_kerusakan max 2MB per file
        document.addEventListener('DOMContentLoaded', function() {
            const fotoInput = document.getElementById('foto_kerusakan');
            const previewContainer = document.getElementById('preview_container');
            // Tambahkan elemen error jika belum ada
            let fotoError = document.getElementById('foto_kerusakan_error');
            if (!fotoError) {
                fotoError = document.createElement('div');
                fotoError.id = 'foto_kerusakan_error';
                fotoError.className = 'text-red-500 text-xs mt-2';
                fotoInput.parentNode.insertBefore(fotoError, fotoInput.nextSibling);
            }

            fotoInput.addEventListener('change', function(e) {
                fotoError.textContent = '';
                const files = Array.from(e.target.files);
                let valid = true;
                files.forEach((file, idx) => {
                    if (file.size > 2 * 1024 * 1024) { // 2MB
                        valid = false;
                    }
                });
                if (!valid) {
                    fotoError.textContent = 'Ukuran setiap foto tidak boleh lebih dari 2MB.';
                    fotoInput.value = '';
                    // Kosongkan preview jika ada
                    if (typeof window.clearFotoPreview === 'function') window.clearFotoPreview();
                }
            });
        });

        // Frontend validation for dokumen_pendukung max 2MB
        document.addEventListener('DOMContentLoaded', function() {
            const dokumenInput = document.getElementById('dokumen_pendukung');
            if (dokumenInput) {
                let dokumenError = document.getElementById('dokumen_pendukung_error');
                if (!dokumenError) {
                    dokumenError = document.createElement('div');
                    dokumenError.id = 'dokumen_pendukung_error';
                    dokumenError.className = 'text-red-500 text-xs mt-2';
                    dokumenInput.parentNode.insertBefore(dokumenError, dokumenInput.nextSibling);
                }
                dokumenInput.addEventListener('change', function(e) {
                    dokumenError.textContent = '';
                    const file = e.target.files && e.target.files[0];
                    if (file && file.size > 2 * 1024 * 1024) {
                        dokumenError.textContent = 'Ukuran dokumen pendukung tidak boleh lebih dari 2MB.';
                        dokumenInput.value = '';
                    }
                });
            }
        });
    </script>
@endsection