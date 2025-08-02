@extends('guest.layouts.main')

@section('document.start')
{{-- Additional styles and scripts for Jalan Peduli page --}}
<meta property="og:title" content="Website Jalan Peduli">
<meta property="og:description" content="Layanan pelaporan kerusakan jalan dan informasi tindak lanjut laporan di Kota Samarinda.">
<meta property="og:image" content="{{ asset('image/logo/dinas-pupr-kota-samarinda.png') }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Website Jalan Peduli">
<meta name="twitter:description" content="Layanan pelaporan kerusakan jalan dan informasi tindak lanjut laporan di Kota Samarinda.">
<meta name="twitter:image" content="{{ asset('image/logo/dinas-pupr-kota-samarinda.png') }}">

<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/@sjmc11/tourguidejs/dist/css/tour.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />

<style>
.connector-desktop, .connector-mobile {
    background-color: rgba(34, 52, 104, 1); /* Menggunakan warna bg.colors.blue */
    position: relative;
    overflow: hidden;
}
.connector-desktop::after, .connector-mobile::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(34, 52, 104, 1); /* Menggunakan warna bg.colors.blue */
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.8s ease;
}
.connector-desktop.active::after, .connector-mobile.active::after {
    transform: scaleX(1);
}
.step-item.step-active .step-circle {
    box-shadow: 0 0 20px rgba(249, 168, 37, 0.5);
}
.step-item.step-completed .step-circle {
    box-shadow: 0 0 20px rgba(34, 197, 94, 0.5);
}

/* Custom styling untuk tour guide agar tidak bertabrakan dengan privacy notification */
.tg-dialog {
    z-index: 49 !important;
}
.tg-dialog.tg-dialog--bottom {
    margin-bottom: 100px !important; /* Berikan ruang untuk privacy notification */
}
/* Ketika privacy notification tidak ada, gunakan z-index tinggi */
body:not(.privacy-notification-visible) .tg-dialog {
    z-index: 9999 !important;
}
body:not(.privacy-notification-visible) .tg-dialog.tg-dialog--bottom {
    margin-bottom: 20px !important;
}
body.privacy-notice-visible .tg-dialog.tg-dialog--bottom {
    /* 
      Dorong dialog tur ke atas setinggi notifikasi (sekitar 75px) 
      ditambah jarak aman (15px). Total 90px.
    */
    margin-bottom: 90px !important;
}

</style>
@endsection

@section('document.body')
<body class="bg-gray-100">
    <main class="container mx-auto p-4 sm:p-8">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

            <div class="bg-brand-blue text-white p-8 rounded-t-2xl">
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">Selamat datang di Jalan Peduli</h1>
                <p class="text-blue-200">Website ini menyediakan layanan pelaporan serta informasi terkini mengenai status dan tindak lanjut laporan yang telah diajukan.</p>
            </div>

            <div class="p-8 border-b border-gray-200">

                <div class="mb-10 border-2 border-dashed border-gray-300 rounded-lg p-4 sm:p-6 text-center bg-gray-50">
                    <a href="{{ asset('image/panduan_penggunaan.jpg') }}" data-fancybox="gallery" data-caption="Panduan Penggunaan">
                        <img 
                            src="{{ asset('image/panduan_penggunaan.jpg') }}" 
                            alt="Panduan Penggunaan" 
                            class="mx-auto w-full max-w-[140px] sm:max-w-[160px] md:max-w-[180px] h-auto rounded-lg shadow-md object-contain cursor-pointer"
                            style="max-width:60vw;"
                        >
                    </a>
                </div>

                <h2 class="text-xl font-bold text-gray-800 text-center">Alur Proses Pelaporan</h2>

                {{-- Desktop Stepper --}}
                <div class="max-w-5xl mx-auto mt-8 mb-4 px-2 sm:px-4 hidden sm:block">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col items-center text-center step-item" data-step="1">
                            <div class="w-20 h-20 rounded-full bg-white border-4 border-gray-300 text-gray-400 flex items-center justify-center text-3xl shadow-lg stepper-icon step-circle">
                                <i class="fa-solid fa-pencil-alt step-icon-element"></i>
                            </div>
                            <p class="mt-3 font-semibold text-sm step-text step-label">Tulis Laporan</p>
                        </div>
                        <div class="flex-1 mx-4 connector-desktop" data-connector="1" style="height: 4px; background-color: #d1d5db;"></div>
                        <div class="flex flex-col items-center text-center step-item" data-step="2">
                            <div class="w-20 h-20 rounded-full bg-white border-4 border-gray-300 text-gray-400 flex items-center justify-center text-3xl shadow-lg stepper-icon step-circle">
                                <i class="fa-solid fa-arrow-right step-icon-element"></i>
                            </div>
                            <p class="mt-3 font-semibold text-sm step-text step-label">Proses Verifikasi</p>
                        </div>
                        <div class="flex-1 mx-4 connector-desktop" data-connector="2" style="height: 4px; background-color: #d1d5db;"></div>
                        <div class="flex flex-col items-center text-center step-item" data-step="3">
                            <div class="w-20 h-20 rounded-full bg-white border-4 border-gray-300 text-gray-400 flex items-center justify-center text-3xl shadow-lg stepper-icon step-circle">
                                <i class="fa-solid fa-comments step-icon-element"></i>
                            </div>
                            <p class="mt-3 font-semibold text-sm step-text step-label">Tindak Lanjut</p>
                        </div>
                        <div class="flex-1 mx-4 connector-desktop" data-connector="3" style="height: 4px; background-color: #d1d5db;"></div>
                        <div class="flex flex-col items-center text-center step-item" data-step="4">
                            <div class="w-20 h-20 rounded-full bg-white border-4 border-gray-300 text-gray-400 flex items-center justify-center text-3xl shadow-lg stepper-icon step-circle">
                                <i class="fa-solid fa-check step-icon-element"></i>
                            </div>
                            <p class="mt-3 font-semibold text-sm step-text step-label">Selesai</p>
                        </div>
                    </div>
                </div>

                {{-- Mobile Stepper --}}
                <div class="max-w-md mx-auto mt-8 mb-4 px-4 block sm:hidden">
                    <div class="flex flex-col items-center space-y-6">
                         <div class="flex flex-col items-center text-center step-item" data-step="1">
                            <div class="w-16 h-16 rounded-full bg-white border-4 border-gray-300 text-gray-400 flex items-center justify-center text-2xl shadow-lg stepper-icon step-circle">
                                <i class="fa-solid fa-pencil-alt step-icon-element"></i>
                            </div>
                            <p class="mt-3 font-semibold text-sm step-text step-label">Tulis Laporan</p>
                        </div>
                        <div class="h-12 connector-mobile" data-connector="1" style="width: 4px; background-color: #d1d5db;"></div>
                        <div class="flex flex-col items-center text-center step-item" data-step="2">
                            <div class="w-16 h-16 rounded-full bg-white border-4 border-gray-300 text-gray-400 flex items-center justify-center text-2xl shadow-lg stepper-icon step-circle">
                                <i class="fa-solid fa-arrow-right step-icon-element"></i>
                            </div>
                            <p class="mt-3 font-semibold text-sm step-text step-label">Proses Verifikasi</p>
                        </div>
                        <div class="h-12 connector-mobile" data-connector="2" style="width: 4px; background-color: #d1d5db;"></div>
                        <div class="flex flex-col items-center text-center step-item" data-step="3">
                            <div class="w-16 h-16 rounded-full bg-white border-4 border-gray-300 text-gray-400 flex items-center justify-center text-2xl shadow-lg stepper-icon step-circle">
                                <i class="fa-solid fa-comments step-icon-element"></i>
                            </div>
                            <p class="mt-3 font-semibold text-sm step-text step-label">Tindak Lanjut</p>
                        </div>
                        <div class="h-12 connector-mobile" data-connector="3" style="width: 4px; background-color: #d1d5db;"></div>
                        <div class="flex flex-col items-center text-center step-item" data-step="4">
                            <div class="w-16 h-16 rounded-full bg-white border-4 border-gray-300 text-gray-400 flex items-center justify-center text-2xl shadow-lg stepper-icon step-circle">
                                <i class="fa-solid fa-check step-icon-element"></i>
                            </div>
                            <p class="mt-3 font-semibold text-sm step-text step-label">Selesai</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8 bg-gray-50">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 text-center mb-8 leading-tight" style="letter-spacing: 0.5px;">
                    Pilih Opsi Anda:
                </h1>
                
                <div class="w-full max-w-4xl mx-auto mb-10">
                    <a href="#" class="block bg-brand-blue text-white p-8 sm:p-10 rounded-3xl shadow-2xl hover:bg-[#223468] btn-hover transform hover:scale-105 transition-all duration-300 create-report-button ring-4 ring-blue-200 focus:outline-none focus:ring-8 focus:ring-blue-100 relative overflow-hidden" style="min-height: 120px;">
                        <div class="flex items-center justify-center space-x-5 sm:space-x-7 relative z-10">
                            <div class="bg-[#3b5fc9] ring-4 ring-blue-100 p-5 sm:p-6 rounded-full flex items-center justify-center shadow-lg" style="min-width:70px; min-height:70px;">
                                <i class="fa-solid fa-plus text-white text-4xl sm:text-5xl"></i>
                            </div>
                            <div class="text-left">
                                <h2 class="text-2xl sm:text-4xl font-extrabold drop-shadow-lg pb-2 leading-tight text-white">
                                    Buat Laporan
                                </h2>
                                <p class="text-blue-100 text-base sm:text-xl font-semibold drop-shadow leading-snug">
                                    Laporkan kerusakan jalan atau temuan Anda
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-4xl mx-auto">
                    <a href="#" class="bg-white border-2 border-blue-200 hover:border-blue-400 p-5 sm:p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:scale-105 check-report-button group">
                        <div class="text-center">
                            <div class="bg-blue-100 group-hover:bg-blue-200 p-3 sm:p-4 rounded-full w-14 sm:w-16 h-14 sm:h-16 mx-auto mb-4 flex items-center justify-center transition-colors duration-300">
                                <i class="fa-solid fa-search text-blue-600 text-xl sm:text-2xl group-hover:text-blue-700"></i>
                            </div>
                            <h3 class="text-base sm:text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors duration-300 leading-tight">
                                Cek Laporan
                            </h3>
                            <p class="text-sm sm:text-base text-gray-600 mt-2 leading-snug">
                                Cek status dan progress laporan Anda
                            </p>
                        </div>
                    </a>

                    <a href="#" class="bg-white border-2 border-green-200 hover:border-green-400 p-5 sm:p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:scale-105 map-report-button group">
                        <div class="text-center">
                            <div class="bg-green-100 group-hover:bg-green-200 p-3 sm:p-4 rounded-full w-14 sm:w-16 h-14 sm:h-16 mx-auto mb-4 flex items-center justify-center transition-colors duration-300">
                                <i class="fa-solid fa-map-location-dot text-green-600 text-xl sm:text-2xl group-hover:text-green-700"></i>
                            </div>
                            <h3 class="text-base sm:text-lg font-bold text-gray-800 group-hover:text-green-600 transition-colors duration-300 leading-tight">
                                Lihat Peta
                            </h3>
                            <p class="text-sm sm:text-base text-gray-600 mt-2 leading-snug">
                                Lihat sebaran laporan di peta interaktif
                            </p>
                        </div>
                    </a>

                    <a href="#" class="bg-white border-2 border-purple-200 hover:border-purple-400 p-5 sm:p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:scale-105 faq-button group">
                        <div class="text-center">
                            <div class="bg-purple-100 group-hover:bg-purple-200 p-3 sm:p-4 rounded-full w-14 sm:w-16 h-14 sm:h-16 mx-auto mb-4 flex items-center justify-center transition-colors duration-300">
                                <i class="fa-solid fa-question-circle text-purple-600 text-xl sm:text-2xl group-hover:text-purple-700"></i>
                            </div>
                            <h3 class="text-base sm:text-lg font-bold text-gray-800 group-hover:text-purple-600 transition-colors duration-300 leading-tight">
                                FAQ
                            </h3>
                            <p class="text-sm sm:text-base text-gray-600 mt-2 leading-snug">
                                Temukan jawaban pertanyaan umum
                            </p>
                        </div>
                    </a>
                </div>

                <div class="mt-10 max-w-2xl mx-auto">
                    <div class="flex flex-col sm:flex-row items-center gap-4 bg-gradient-to-r from-blue-100 via-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-6 shadow-lg">
                        <div class="flex-shrink-0 bg-blue-600 p-3 rounded-full flex items-center justify-center shadow-md">
                            <i class="fa-solid fa-info text-white text-xl"></i>
                        </div>
                        <div class="flex-1 text-center sm:text-left">
                            <h4 class="font-bold text-blue-900 mb-1 text-lg">Informasi Penting</h4>
                            <p class="text-blue-800 text-base leading-relaxed">
                                Lengkapi laporan Anda dengan <span class="font-semibold text-blue-700">foto</span> dan <span class="font-semibold text-blue-700">lokasi akurat</span> agar proses verifikasi & tindak lanjut lebih efisien.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    
</body>
@endsection

@section('document.end')
<script src="https://unpkg.com/@sjmc11/tourguidejs/dist/tour.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@vite(['resources/js/jalan-peduli/animasi.js'])
@vite(['resources/js/jalan-peduli/shepherd-tour.js'])
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
@endsection```