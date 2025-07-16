@extends('guest.layouts.main')

@section('document.start')
  @vite('resources/css/splidejs.css')
@endsection

@section('document.body')
  <div class="px-5 sm:px-10 py-5 md:py-12 lg:px-24 3xl:px-48">
    <div class="text-center mb-2 lg:mb-3">
      <span
        class="bg-brand-blue uppercase font-bold text-brand-yellow text-sm lg:text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">
        {{ $page_title }}
      </span>
    </div>

    <h1 class="text-center font-bold text-2xl lg:text-3xl 2xl:text-4xl pb-1.5 lg:pb-3 uppercase">
      {{ $page_subtitle }}
    </h1>

    @if ($struktur_organisasi->susunanOrganisasi)
      <p class="text-center text-lg md:text-xl 2xl:text-2xl sm:px-12 md:px-24 ">
        {{ $struktur_organisasi->susunanOrganisasi->deskripsi_susunan_organisasi }}
      </p>
    @endif

    @if ($struktur_organisasi->slider->count())
      <div class="mt-5">
        <hr class="h-0.5 my-4 sm:my-8 w-48 sm:w-72 md:w-96 bg-black mx-auto border-0 dark:bg-gray-700">

        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active flex justify-evenly">
              <section class="splide w-full" aria-labelledby="carousel-heading">
                <div class="splide__track">
                  <ul class="splide__list">
                    @foreach ($struktur_organisasi->slider as $item)
                      {{-- 16:9x315 --}}
                      <li class="splide__slide px-1">
                        {{-- <img class="mx-auto" src="{{ $item->foto }}" alt="{{ $item->keterangan }}"> --}}
                        <img class="mx-auto" src="{{ $item->foto }}" alt="Slider {{ $loop->iteration }}">
                      </li>
                    @endforeach
                  </ul>
                </div>
              </section>
            </div>
          </div>
        </div>

        <hr class="h-0.5 my-4 sm:my-8 w-48 sm:w-72 md:w-96 mx-auto bg-black border-0 dark:bg-gray-700">
      </div>
    @endif
  </div>

  <div class="bg-[#f0f0f0] px-5 sm:px-10 py-5 md:py-12 lg:px-24 3xl:px-48">
    <div class="text-center mb-2 lg:mb-3">
      <span
        class="bg-brand-blue uppercase font-bold text-brand-yellow text-sm lg:text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">
        Struktur Bagian
      </span>
    </div>

    <h2 class="text-center font-bold text-2xl lg:text-3xl 2xl:text-4xl pb-1.5 lg:pb-3 uppercase">
      {{ $page_subtitle }}
    </h2>

    @if ($struktur_organisasi_diagram)
      <div class="flex justify-center">
        <img src="{{ Storage::url($struktur_organisasi_diagram->diagram_struktur_organisasi) }}"
          alt="{{ $struktur_organisasi->susunanOrganisasi->nama_susunan_organisasi ?? '' }}">
      </div>
    @endif
  </div>

  {{-- Berita Terkait --}}
  @if ($berita->isNotEmpty())
    <div class="p-10 md:p-12">
      <div class="text-center pb-6 lg:pb-12 grid gap-3">
        <div>
          <span
            class="bg-brand-blue font-bold text-brand-yellow text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">
            BERITA TERBARU
          </span>
        </div>

        <h2 class="font-bold text-3xl uppercase">
          SEPUTAR {{ $struktur_organisasi->susunanOrganisasi->nama_susunan_organisasi ?? '' }}
        </h2>
      </div>

      <div class="w-fit grid mx-auto md:grid-cols-2 lg:grid-cols-3 gap-7">
        @foreach ($berita as $item)
          <div class="mx-auto max-w-[320px] rounded-xl shadow-lg flex flex-col">
            <div class="text-center text-sm text-white font-semibold bg-brand-blue rounded-t-xl py-2">
              {{ $item->kategori->susunanOrganisasi->nama_susunan_organisasi ?? '' }}
            </div>
            <img class="aspect-[16/9]"
              src="{{ Storage::disk('public')->exists($item->foto_berita) ? Storage::url($item->foto_berita) : asset('image/placeholder/no-image-16x9.webp') }}" />
            <div class="p-5 flex-grow flex flex-col justify-between">
              <div>
                <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                  {{ $item->judul_berita }}
                </h5>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                  {{ $item->created_at->format('d M Y') }}</p>
              </div>
              <div class="flex justify-start">
                <a href="{{ route('guest.berita.show', ['slug_berita' => $item->slug_berita]) }}"
                  class="inline-flex items-center px-3 py-2 text-sm font-semibold text-center text-brand-blue bg-brand-yellow rounded-xl w-auto">
                  Baca berita
                  <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M1 5h12m0 0L9 1m4 4L9 9" />
                  </svg>
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="flex justify-center pt-6 lg:pt-12">
        <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => $struktur_organisasi->susunanOrganisasi->slug_susunan_organisasi ?? '']) }}"
          class="text-brand-blue bg-brand-yellow font-bold rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          Lihat Berita Lainnya
        </a>
      </div>
    </div>
  @endif
@endsection

@section('document.end')
  @vite('resources/js/splidejs.js')

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.splide').forEach(function(element) {
        new Splide(element, {
          type: 'loop',
          focus: 'center',
          breakpoints: {
            640: {
              perPage: 1.25
            },
            768: {
              perPage: 1.5
            },
            1024: {
              perPage: 1.75
            },
            1280: {
              perPage: 2
            },
            1920: {
              perPage: 3
            },
          },
        }).mount();
      });
    });
  </script>
@endsection
