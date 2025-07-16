@extends('guest.layouts.main')

@section('document.body')
  <div class="py-5 md:py-12 px-6 3xl:px-48">
    @include('guest.components.section-title')

    <div class="w-fit mx-auto flex flex-wrap gap-7 justify-center">
      @foreach ($berita_kategori as $item)
        <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => $item->susunanOrganisasi->slug_susunan_organisasi]) }}"
          class="w-full sm:w-1/2 lg:w-1/3 border max-w-[275px] md:max-w-[300px] px-6 py-11 h-[300px] md:h-[350px] bg-white rounded-3xl shadow text-center flex flex-col">
          <figure class="flex-1">         
            <div class="static mb-3 w-28 h-28 rounded-full m-auto flex items-center justify-center">
              <img class="absolute h-28" src="{{ Storage::url($item->ikon_berita_kategori) }}" alt="">
            </div>
            <figcaption class="mb-2 text-xl md:text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
              {{ $item->susunanOrganisasi->nama_susunan_organisasi ?? '-' }}
            </figcaption>
          </figure>
          <div class="text-sm md:text-base">
            <div class="mb-1">
              <i class="fa-regular fa-newspaper fa-lg" style="color: #000000;"></i> {{ $item->jumlah_berita_count }}
              berita
            </div>
            <div>
              <i class="fa-regular fa-eye fa-lg" style="color: #000000;"></i> {{ $item->jumlah_views_count }} kali dilihat
            </div>
          </div>
        </a>
      @endforeach
    </div>
  </div>
@endsection
