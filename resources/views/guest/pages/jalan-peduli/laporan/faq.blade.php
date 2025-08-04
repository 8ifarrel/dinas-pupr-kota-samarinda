@extends('guest.layouts.jalanpeduli-publik')

@section('title', 'Pusat Bantuan & Informasi')

@section('content')

{{-- Background gradient yang lebih modern --}}
<div class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl py-12 sm:py-20">

        <div class="text-center mb-12 sm:mb-16 relative">
            {{-- Background tambahan di belakang judul --}}
            <div class="absolute inset-0 top-0 left-1/2 -translate-x-1/2 w-full max-w-4xl h-56 sm:h-72 mx-auto z-[-1] pointer-events-none" aria-hidden="true">
            <div class="w-full h-full bg-gradient-to-tr from-blue-100 via-primary-yellow/30 to-blue-50 opacity-60 rounded-3xl blur-2xl"></div>
            </div>
            <div class="relative inline-flex items-center justify-center w-20 h-20 mb-6 z-10">
            <span class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-blue-600 via-primary-navy to-primary-yellow opacity-80 blur-md"></span>
            <span class="relative inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-primary-yellow shadow-lg">
                <i class="fas fa-question-circle text-4xl text-white"></i>
            </span>
            </div>
            <h1 class="relative z-10 text-4xl sm:text-5xl font-extrabold text-primary-navy mb-4 tracking-tight">
            Pusat Bantuan & Informasi
            </h1>
            <p class="relative z-10 text-lg text-slate-600 max-w-3xl mx-auto leading-relaxed">
            Temukan jawaban cepat untuk pertanyaan yang paling sering diajukan mengenai layanan kami.
            </p>
        </div>

        {{-- Form Pencarian sekarang sepenuhnya bergantung pada backend Laravel --}}
        <form method="GET" action="{{ route('faq') }}" class="mb-12 sm:mb-16">
            <div class="flex justify-center">
                <div class="w-full md:w-3/4 lg:w-2/3">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                            <i class="fas fa-search text-slate-400 group-focus-within:text-blue-500 transition-colors duration-200"></i>
                        </div>
                        <input type="text"
                                class="block w-full pl-14 pr-5 py-4 border border-slate-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 bg-white text-slate-700 placeholder-slate-400 transition-all duration-300 ease-in-out hover:border-blue-300 hover:shadow-md"
                                id="search" name="search" placeholder="Cari berdasarkan kata kunci..."
                                value="{{ request('search') }}">
                    </div>
                </div>
            </div>
        </form>

        <div id="faqAccordion" class="space-y-4">
            {{-- Loop untuk menampilkan FAQ (akan menampilkan 10 per halaman) --}}
            @forelse($faqs as $index => $faq)
                <div class="faq-item group bg-white border border-slate-200 rounded-xl shadow-sm transition-all duration-300 ease-in-out hover:shadow-md hover:border-blue-200">
                    <h2 id="faqHeading{{ $index }}">
                        <button
                            class="faq-button w-full flex justify-between items-center text-left px-6 py-5 focus:outline-none focus:ring-2 focus:ring-blue-100 rounded-xl"
                            type="button"
                            aria-expanded="false"
                            aria-controls="faqCollapse{{ $index }}">
                            <span class="font-semibold text-lg text-slate-800 group-hover:text-blue-600 transition-colors duration-300 pr-4">
                                {{ $faq['question'] }}
                            </span>
                            <div class="flex-shrink-0 w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center group-hover:bg-blue-50 transition-all duration-300">
                                <i class="fas fa-chevron-down text-slate-500 group-hover:text-blue-500 transition-transform duration-300 ease-in-out transform"></i>
                            </div>
                        </button>
                    </h2>
                    <div id="faqCollapse{{ $index }}"
                            class="faq-content hidden"
                            aria-labelledby="faqHeading{{ $index }}">
                        <div class="px-6 pb-6 pt-0">
                            <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                                {!! $faq['answer'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Pesan jika tidak ada hasil sama sekali (dari pencarian atau data kosong) --}}
                <div id="noResultsMessage" class="bg-amber-50 border-l-4 border-amber-400 p-8 text-center rounded-r-xl shadow-sm mt-4" role="alert">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:text-left">
                        <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mb-4 sm:mb-0 sm:mr-6 flex-shrink-0">
                            <i class="fas fa-magnifying-glass-minus text-2xl text-amber-600"></i>
                        </div>
                        <div class="text-amber-800">
                            <p class="font-bold text-xl mb-1">Hasil Tidak Ditemukan</p>
                            <p class="text-amber-700">Kami tidak dapat menemukan pertanyaan yang cocok dengan pencarian Anda.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- BAGIAN PAGINASI BARU --}}
        @if ($faqs->hasPages())
            <div class="mt-12 flex flex-col items-center justify-center space-y-4 fade-in">
                <nav class="inline-flex rounded-xl shadow-lg overflow-hidden border border-gray-200 bg-white" aria-label="Pagination">
                    @php
                        $elements = $faqs->links()->elements;
                    @endphp

                    @if ($faqs->onFirstPage())
                        <span class="relative inline-flex items-center px-3 py-2 text-gray-400 bg-gray-100 cursor-not-allowed select-none">
                            <span class="sr-only">Sebelumnya</span>
                            <i class="fas fa-chevron-left h-5 w-5"></i>
                        </span>
                    @else
                        <a href="{{ $faqs->previousPageUrl() . (request()->has('search') ? '&search=' . request('search') : '') }}" rel="prev" class="relative inline-flex items-center px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors duration-200">
                            <span class="sr-only">Sebelumnya</span>
                            <i class="fas fa-chevron-left h-5 w-5"></i>
                        </a>
                    @endif

                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="relative inline-flex items-center px-4 py-2 text-gray-500 bg-white select-none">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $faqs->currentPage())
                                    <span aria-current="page" class="relative z-10 inline-flex items-center px-4 py-2 bg-primary-navy text-white font-bold shadow-inner">{{ $page }}</span>
                                @else
                                    <a href="{{ $url . (request()->has('search') ? '&search=' . request('search') : '') }}" class="relative inline-flex items-center px-4 py-2 text-primary-navy hover:bg-primary-navy/10 font-semibold transition-colors duration-200">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($faqs->hasMorePages())
                        <a href="{{ $faqs->nextPageUrl() . (request()->has('search') ? '&search=' . request('search') : '') }}" rel="next" class="relative inline-flex items-center px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors duration-200">
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
                
                <div class="text-sm text-gray-600">
                    Menampilkan 
                    <span class="font-semibold text-gray-800">{{ $faqs->firstItem() ?? 0 }}</span>
                    sampai
                    <span class="font-semibold text-gray-800">{{ $faqs->lastItem() ?? 0 }}</span>
                    dari
                    <span class="font-semibold text-gray-800">{{ $faqs->total() }}</span>
                    hasil
                </div>
            </div>
        @endif

        {{-- AKHIR BAGIAN PAGINASI --}}

        <div class="text-center mt-16 sm:mt-24 pt-12 border-t border-slate-200">
            <div class="bg-primary-navy rounded-2xl p-8 sm:p-12 text-white shadow-xl relative overflow-hidden">
                <div class="absolute inset-0 bg-white bg-opacity-5"></div>
            
                <div class="relative z-10">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white bg-opacity-20 rounded-full mb-6">
                    <i class="fas fa-headset text-3xl text-white"></i>
                    </div>
                    <h3 class="text-3xl font-bold mb-3 text-white">Tidak ada pertanyaan Anda?</h3>
                    <p class="text-blue-100 mb-8 max-w-lg mx-auto text-lg">
                    Tim kami selalu siap sedia untuk memberikan dukungan dan menjawab setiap pertanyaan Anda.
                    </p>
                    
                    <button id="openContactModalBtn"
                        class="inline-flex items-center px-8 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-lg hover:bg-green-700 transform hover:-translate-y-1 transition-all duration-300 ease-in-out group">
                        <i class="fab fa-whatsapp mr-3 text-xl"></i>
                        Hubungi Kami di Whatsapp
                    </button>
                </div>
            </div>
        </div>

        <div id="contactModal"
            class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center p-4 transition-opacity duration-300 backdrop-blur-sm">
            <div id="modalContent"
                class="bg-white rounded-2xl shadow-2xl w-full max-w-lg text-left transform transition-all duration-300 scale-95 opacity-0 mx-auto">
                {{-- Header Modal --}}
                <div class="flex justify-between items-center p-5 border-b border-slate-100">
                    <h4 class="text-xl sm:text-2xl font-bold text-slate-800">Kirim Pesan ke Tim Support</h4>
                    <button id="closeContactModalBtn"
                        class="text-slate-400 hover:text-slate-600 transition-colors duration-200 p-2 hover:bg-slate-100 rounded-full">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                {{-- Body Modal --}}
                <div class="p-6 max-h-[70vh] overflow-y-auto">
                    <form id="contactForm">
                        <div id="formStatusMessage" class="hidden p-4 mb-6 text-sm rounded-lg" role="alert"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label for="contactName" class="block text-sm font-medium text-slate-700 mb-2">Nama
                                    Lengkap</label>
                                <input type="text" id="contactName" name="name"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200"
                                    placeholder="Masukkan nama Anda">
                            </div>
                            <div>
                                <label for="contactEmail" class="block text-sm font-medium text-slate-700 mb-2">Alamat
                                    Email</label>
                                <input type="email" id="contactEmail" name="email"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200"
                                    placeholder="your.email@example.com">
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="contactCategory" class="block text-sm font-medium text-slate-700 mb-2">Kategori
                                Bantuan</label>
                            <select id="contactCategory" name="category"
                                class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 bg-white transition-all duration-200">
                                <option value="">Pilih Kategori</option>
                                <option value="Pertanyaan Umum">Pertanyaan Umum</option>
                                <option value="Kendala Teknis">Kendala Teknis</option>
                                <option value="Saran & Masukan">Saran & Masukan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-5">
                            <label for="contactMessage" class="block text-sm font-medium text-slate-700 mb-2">Pesan Anda</label>
                            <textarea id="contactMessage" name="message" rows="5"
                                class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200"
                                placeholder="Jelaskan pertanyaan atau masalah Anda di sini..."></textarea>
                        </div>
                    </form>
                </div>

                {{-- Footer Modal --}}
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 text-right rounded-b-2xl">
                    <button id="sendToWhatsAppBtn"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-lg hover:bg-green-700 transition-all duration-300 hover:shadow-xl">
                        <i class="fab fa-whatsapp mr-3 text-xl"></i>
                        <span>Kirim Melalui WhatsApp</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@vite(['resources/js/jalan-peduli/faq.js'])
@endsection