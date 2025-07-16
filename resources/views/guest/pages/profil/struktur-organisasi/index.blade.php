@extends('guest.layouts.main')

@section('document.body')
  <section style="background-image: url('{{ asset('image/hero/profil.png') }}');" class="bg-center bg-cover bg-no-repeat h-full w-full bg-gray-500 bg-blend-multiply">
    <div
      class="flex flex-col justify-center aspect-[16/9] sm:aspect-[21/9] md:aspect-[32/9] ms-8 xs:ms-10 sm:ms-20 md:ms-28">
      <h2
        class="mb-1 md:mb-3 lg:mb-4 text-lg xs:text-xl sm:text-2xl md:text-3xl lg:text-4xl font-semibold tracking-tight leading-none text-white uppercase">
        {{ $page_subtitle }}</h2>
      <h1 class="font-bold text-gray-300 text-xl xs:text-2xl sm:text-3xl md:text-4xl lg:text-5xl">{{ $page_title }}
      </h1>
    </div>
  </section>

  <div class="px-5 sm:px-10 py-5 md:py-12 lg:px-24 3xl:px-48">
    @include('guest.components.section-title', [
      'page_subtitle' => $page_subtitle,
      'page_title' => "Organigram \n" . config('app.nama_singkatan_dinas'),
    ])

    <div>
      @if ($struktur_organisasi_diagram)
        <img src="{{ Storage::url($struktur_organisasi_diagram->diagram_struktur_organisasi) }}" alt="Struktur Organisasi"
          class="border  sm:border-2 md:border-4 border-black p-3">
      @endif
    </div>
  </div>

  <div class="p-5 sm:p-10 md:p-12">
    @include('guest.components.section-title', [
      'page_subtitle' => $page_subtitle,
      'page_title' => "Susunan Organisasi \n" . config('app.nama_singkatan_dinas'),
    ])

    <div class="w-fit grid mx-auto md:grid-cols-2 lg:grid-cols-3 gap-7">
      @foreach ($struktur_organisasi as $item)
        <a href="{{ route('guest.profil.struktur-organisasi.show', ['slug_susunan_organisasi' => $item->susunanOrganisasi->slug_susunan_organisasi]) }}"
          class="max-w-xs p-6 border bg-white rounded-3xl shadow-lg text-center flex flex-col mx-auto {{ $item->nomor_urut_jabatan == 1 ? 'md:col-span-2 lg:col-span-3' : '' }}">
          <figure>
            <div class="static mb-3 w-14 h-14 bg-brand-yellow/40 rounded-full m-auto flex items-center justify-center">
              <img class="absolute h-16" src="{{ Storage::url($item->ikon_jabatan) }}"
                alt="{{ $item->susunanOrganisasi->nama_susunan_organisasi }}">
            </div>
            <figcaption class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
              {{ $item->susunanOrganisasi->nama_susunan_organisasi }}
            </figcaption>
          </figure>
          <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">
            {{ $item->susunanOrganisasi->deskripsi_susunan_organisasi }}
          </p>
          <div class="mt-auto">
            <p href="#" class="inline-flex font-medium items-center text-brand-blue hover:underline">
              Pelajari selengkapnya
              <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778" />
              </svg>
            </p>
          </div>
        </a>
      @endforeach
    </div>
  </div>
@endsection
