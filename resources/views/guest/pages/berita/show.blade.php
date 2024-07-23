@extends('guest.layouts.berita')

@section('slot')
  <div class="lg:flex lg:gap-5 xl:gap-7 py-5 md:py-8 lg:py-12 px-3 sm:px-6 lg:px-12 justify-center">
    {{-- Kategori --}}
    <div class="hidden lg:block flex-shrink-0 lg:w-44 xl:w-48 3xl:w-64">
      <h1 class="lg:text-2xl font-semibold mb-3 3xl:mb-5 3xl:text-3xl">
        Kategori
      </h1>

      <ul>
        <li>
          <a href="#"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sekretariat</a>
        </li>
        <li>
          <a href="#"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
            Sumber Daya Air</a>
        </li>
        <li>
          <a href="#"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
            Cipta Karya</a>
        </li>
        <li>
          <a href="#"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
            Bina Marga</a>
        </li>
        <li>
          <a href="#"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
            Bina Konstruksi</a>
        </li>
        <li>
          <a href="#"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
            Tata Ruang</a>
        </li>
        <li>
          <a href="#"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
            Pertanahan</a>
        </li>
        <li>
          <a href="#"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">UPTD
            Pengelolaan Air Limbah Domestik</a>
        </li>
        <li>
          <a href="#"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">UPTD
            Pemeliharaan Jalan dan Jembatan</a>
        </li>
        <li>
          <a href="#"
            class="block pb-3 3xl:pb-4 text-base 3xl:text-xl hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">UPTD
            Pemeliharaan Saluran Drainase dan irigasi</a>
        </li>
      </ul>
    </div>

    {{-- Isi berita --}}
    <main>
      <img class="w-full mb-3 3xl:mb-5" src="{{ $berita->foto_berita }}" alt="">

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
          <span class="bg-yellow text-blue text-sm font-bold me-2 px-2.5 py-0.5 3xl:px-4 3xl:py-1 rounded-full 3xl:text-xl">
            {{ $berita->kategori->jabatan->nama_jabatan }}
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
              <img class="3xl:w-full" src="{{ $item->foto_berita }}" alt="">
              <h1 class="3xl:text-xl">{{ Str::limit($item->judul_berita, 60) }}</h1>
            </a>
          </li>
        @endforeach
      </ul>
    </div>

    <div class="block lg:hidden mt-5">
      <div class="flex mb-5">
        <h2 class="text-xl xs:text-2xl sm:text-3xl font-bold">Berita Lainnya</h2>
        <hr class="ms-2 sm:ms-4 w-24 sm:w-48 h-[3px] xs:h-1 bg-black border-0 my-auto dark:bg-gray-700">
      </div>

      <div class="splide">
        <div class="splide__track">
          <ul class="splide__list">
            @foreach ($berita_lainnya as $item)
              <li class="splide__slide mx-2">
                <img src="{{ $item->foto_berita }}" alt="">
                <h1>{{ Str::limit($item->judul_berita, 60) }}</h1>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
@endsection
