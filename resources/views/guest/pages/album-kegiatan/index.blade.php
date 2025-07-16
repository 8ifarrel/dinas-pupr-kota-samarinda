@extends('guest.layouts.main')

@section('document.body')
  <div class="py-5 md:py-12 px-6 lg:px-24 3xl:px-48">
    @include('guest.components.section-title')

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 2xl:grid-cols-5 gap-6">
      @foreach ($album_kegiatan as $album)
        @php
          $cover = $album->fotoKegiatan->first();
        @endphp
        <div class="flex flex-col h-full">
          <div class="relative group  overflow-hidden shadow hover:shadow-lg transition border-0 bg-white">
            <a href="{{ route('guest.album-kegiatan.show', $album->slug) }}" class="block text-black no-underline">
              <div class="absolute bottom-0 left-0 w-full z-10 px-3 pt-5 pb-2"
                style="background: linear-gradient(360deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0) 100%);">
                <p class="font-semibold text-base text-center text-white">
                  {{ $album->judul }}
                </p>
              </div>
              <div class="w-full aspect-[4/3] bg-gray-200">
                @if ($cover)
                  <img src="{{ Storage::url($cover->foto) }}" alt="{{ $album->judul }}"
                    class="object-cover w-full h-full transition group-hover:scale-105 duration-300" />
                @else
                  <div class="w-full h-full flex items-center justify-center text-gray-500">No Image</div>
                @endif
              </div>
            </a>
          </div>
          <div class="flex justify-between items-center px-3 py-2 bg-white shadow mt-0">
            <p class="flex items-center gap-1.5 text-sm text-gray-700">
              <i class="fa-solid fa-image"></i>
              {{ $album->fotoKegiatan->count() }} foto
            </p>
            <p class="flex items-center gap-1.5 text-sm text-gray-700">
              <i class="fa-solid fa-eye"></i>
              {{ $album->views_count ?? 0 }} kali
            </p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
