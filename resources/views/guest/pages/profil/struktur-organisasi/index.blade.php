@extends('guest.layouts.struktur-organisasi')

@section('slot')
  <div class="px-5 sm:px-10 py-5 md:py-12 lg:px-24 3xl:px-48">
		<div class="text-center mb-2 lg:mb-3">
			<span
				class="bg-blue uppercase font-bold text-yellow text-sm lg:text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">
				{{ $page_title }}
			</span>
		</div>

		<h1 class="text-center font-bold text-2xl lg:text-3xl pb-6 lg:pb-12 uppercase">
			{{ $page_subtitle }}
		</h1>
		
    {{-- Diagram --}}
    <div>
			@if ($struktur_organisasi_diagram)
      	<img src="{{ $struktur_organisasi_diagram->diagram_struktur_organisasi }}" alt="Struktur Organisasi" class="border  sm:border-2 md:border-4 border-black p-3">					
			@endif
    </div>
  </div>

	{{-- Card --}}
	<div class="p-10 md:p-12">
    <div class="text-center mb-2 lg:mb-3">
			<span
				class="bg-blue uppercase font-bold text-yellow text-sm lg:text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">
				{{ $page_title }}
			</span>
		</div>

		<h1 class="text-center font-bold text-2xl lg:text-3xl pb-6 lg:pb-12 uppercase">
			TENTANG KAMI
		</h1>

    <div class="w-fit grid mx-auto md:grid-cols-2 lg:grid-cols-3 gap-7">
      @foreach ($struktur_organisasi as $item)
        <div
          class="max-w-xs p-6 border bg-white rounded-3xl shadow-lg text-center flex flex-col mx-auto {{ $item->nomor_urut_jabatan == 1 ? 'md:col-span-2 lg:col-span-3' : '' }}">
          <figure>
            <div class="static mb-3 w-14 h-14 bg-yellow/40 rounded-full m-auto flex items-center justify-center">
              <img class="absolute h-16" src="{{ url($item->ikon_jabatan) }}" alt="">
            </div>
            <figcaption class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
              {{ $item->jabatan->nama_jabatan }}
            </figcaption>
          </figure>
          <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">{{ $item->jabatan->deskripsi_jabatan }}
          </p>
          <div class="mt-auto">
            <a href="#" class="inline-flex font-medium items-center text-blue hover:underline">
              Pelajari selengkapnya
              <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778" />
              </svg>
            </a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
