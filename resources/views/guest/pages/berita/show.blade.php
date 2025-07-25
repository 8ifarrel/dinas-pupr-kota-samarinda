@extends('guest.layouts.main')

@section('document.start')
  @vite('resources/css/splidejs.css')
@endsection

@section('document.body')
  <div class="lg:flex lg:gap-5 xl:gap-7 py-5 md:py-8 lg:py-12 px-3 sm:px-6 lg:px-12 justify-center">
    {{-- Kategori --}}
    <div class="hidden lg:block flex-shrink-0 lg:w-44 xl:w-48 3xl:w-64">
      <h1 class="lg:text-2xl font-semibold mb-3 3xl:mb-5 3xl:text-3xl">
        Kategori
      </h1>

      <ul>
        <li>
          <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'sekretariat']) }}"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sekretariat</a>
        </li>
        <li>
          <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'bidang-sumber-daya-air']) }}"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
            Sumber Daya Air</a>
        </li>
        <li>
          <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'bidang-cipta-karya']) }}"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
            Cipta Karya</a>
        </li>
        <li>
          <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'bidang-bina-marga']) }}"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
            Bina Marga</a>
        </li>
        <li>
          <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'bidang-bina-konstruksi']) }}"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
            Bina Konstruksi</a>
        </li>
        <li>
          <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'bidang-tata-ruang']) }}"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
            Tata Ruang</a>
        </li>
        <li>
          <a href=" {{ route('guest.berita.kategori.show', ['slug_kategori' => 'bidang-pertanahan']) }} "
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
            Pertanahan</a>
        </li>
        <li>
          <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'uptd-pengelolaan-air-limbah-domestik']) }}"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">UPTD
            Pengelolaan Air Limbah Domestik</a>
        </li>
        <li>
          <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'uptd-pemeliharaan-jalan-dan-jembatan']) }}"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">UPTD
            Pemeliharaan Jalan dan Jembatan</a>
        </li>
        <li>
          <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'uptd-pemeliharaan-saluran-drainase-dan-irigasi']) }}"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">UPTD
            Pemeliharaan Saluran Drainase dan irigasi</a>
        </li>
      </ul>
    </div>

    {{-- Isi berita --}}
    <main>
      <img class="w-full mb-3 3xl:mb-5 aspect-[16/9]"
        src="{{ Storage::disk('public')->exists($berita->foto_berita) ? Storage::url($berita->foto_berita) : asset('image/placeholder/no-image-16x9.webp') }}"
        alt="{{ $berita->judul_berita ?? '' }}" />

      <div class="md:flex justify-between">
        <div class="flex gap-x-3 mb-3 md:mb-0">
          <span class="flex items-center gap-x-1">
            <i class="fa-regular fa-eye" style="color: #000000;"></i>
            <p class="text-sm sm:text-base 3xl:text-xl">{{ $berita->views_count }} views</p>
          </span>

          <span class="flex items-center gap-x-1">
            <i class="fa-regular fa-calendar" style="color: #000000;"></i>
            <time class="text-sm sm:text-base 3xl:text-xl">{{ $berita->created_at->format('D, d M Y') }}</time>
          </span>
        </div>

        <div>
          <span
            class="bg-brand-yellow text-brand-blue text-sm font-bold me-2 px-2.5 py-0.5 3xl:px-4 3xl:py-1 rounded-full 3xl:text-xl">
            {{ $berita->kategori->susunanOrganisasi->nama_susunan_organisasi ?? '-' }}
          </span>
        </div>
      </div>

      <article class="mt-1 md:mt-3 3xl:mt-5">
        <h1 class="text-lg xs:text-xl sm:text-2xl 3xl:text-4xl font-semibold mb-3">
          {{ $berita->judul_berita }}
        </h1>

        <p class="sm:text-lg 3xl:text-2xl">
          {!! $berita->isi_berita !!}
        </p>
      </article>
    </main>

    {{-- Berita lainnya --}}
    <div class="hidden lg:block flex-shrink-0 lg:w-44 xl:w-48 3xl:w-96">
      <h1 class="lg:text-2xl font-semibold mb-3 3xl:text-3xl 3xl:mb-5">
        Berita Lainnya
      </h1>

      <ul>
        @foreach ($berita_lainnya as $item)
          <li class="mb-2">
            <a href="{{ route('guest.berita.show', ['slug_berita' => $item->slug_berita]) }}">
              <img class="3xl:w-full aspect-[16/9]"
                src="{{ Storage::disk('public')->exists($item->foto_berita) ? Storage::url($item->foto_berita) : asset('image/placeholder/no-image-16x9.webp') }}"
                alt="{{ $item->judul_berita ?? '' }}" />
              <h1 class="3xl:text-xl">{{ Str::limit($item->judul_berita, 60) }}</h1>
            </a>
          </li>
        @endforeach
      </ul>
    </div>

    <div class="block lg:hidden mt-5">
      <div class="flex mb-5">
        <h2 class="text-2xl sm:text-3xl font-bold">Berita Lainnya</h2>
        <hr class="ms-4 w-20 sm:w-48 h-1 bg-black border-0 my-auto dark:bg-gray-700">
      </div>

      <div class="splide">
        <div class="splide__track">
          <ul class="splide__list">
            @foreach ($berita_lainnya as $item)
              <li class="splide__slide px-2">
                <img class="aspect-[16/9]"
                  src="{{ Storage::disk('public')->exists($item->foto_berita) ? Storage::url($item->foto_berita) : asset('image/placeholder/no-image-16x9.webp') }}"
                  alt="{{ $item->judul_berita ?? '' }}" />
                <h1>{{ Str::limit($item->judul_berita, 60) }}</h1>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('document.end')
  @vite('resources/js/splidejs.js')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var splide = new Splide('.splide', {
        type: 'loop',
        focus: 'center',
        drag: 'free',
        breakpoints: {
          640: {
            perPage: 2,
          },
          768: {
            perPage: 3,
          },
          1024: {
            perPage: 3,
          },
          1280: {
            perPage: 4,
          },
          1920: {
            perPage: 4,
          }
        },
        pagination: false,
      });
      splide.mount();
    });
  </script>
@endsection
