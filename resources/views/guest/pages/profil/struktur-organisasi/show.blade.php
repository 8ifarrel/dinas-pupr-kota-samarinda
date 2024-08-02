@extends('guest.layouts.struktur-organisasi')

@section('slot')
  <div class="px-5 sm:px-10 py-5 md:py-12 lg:px-24 3xl:px-48">
    <div class="text-center mb-2 lg:mb-3">
      <span
        class="bg-blue uppercase font-bold text-yellow text-sm lg:text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">
        {{ $page_title }}
      </span>
    </div>

    <h1 class="text-center font-bold text-2xl lg:text-3xl 2xl:text-4xl pb-1.5 lg:pb-3 uppercase">
      {{ $page_subtitle }}
    </h1>

    @if ($struktur_organisasi->jabatan)
      <p class="text-center text-lg md:text-xl 2xl:text-2xl sm:px-12 md:px-24 md:font-medium">
        {{ $struktur_organisasi->jabatan->deskripsi_jabatan }}
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
                        <img class="mx-auto" src="{{ $item->foto }}" alt="{{ $item->keterangan }}">
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
@endsection


@section('js')
  {{-- Splide --}}
  <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>

  <script>
    const splide = new Splide('.splide', {
      type: 'loop',
      focus: 'center',
      breakpoints: {
        640: {
          perPage: 1.25,
        },
        768: {
          perPage: 1.5,
        },
        1024: {
          perPage: 1.75,
        },
        1280: {
          perPage: 2,
        },
        1920: {
          perPage: 3,
        }
      },
    });

    splide.mount(window.splide);
  </script>
@endsection

@section('css')
  {{-- Splide --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
@endsection
