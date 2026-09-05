@extends('guest.layouts.main')

@section('document.body')
  <section style="background-image: url('{{ asset('image/hero/profil.png') }}');"
    class="bg-center bg-cover bg-no-repeat h-full w-full bg-gray-500 bg-blend-multiply">
    <div
      class="flex flex-col justify-center aspect-[16/9] sm:aspect-[21/9] md:aspect-[32/9] ms-8 xs:ms-10 sm:ms-20 md:ms-28">
      <h2
        class="mb-1 md:mb-3 lg:mb-4 text-lg xs:text-xl sm:text-2xl md:text-3xl lg:text-4xl font-semibold tracking-tight leading-none text-white uppercase">
        {{ $page_subtitle }}</h2>
      <h1 class="font-bold text-gray-300 text-xl xs:text-2xl sm:text-3xl md:text-4xl lg:text-5xl">{{ $page_title }}
      </h1>
    </div>
  </section>
  <div class="px-5 sm:px-10 py-5 md:py-6 md:px-12">
    <div class="block bg-white rounded-xl shadow-xl">
      @if ($kepala_dinas)
        <div class="bg-brand-blue static h-36 rounded-t-xl flex justify-center pt-[72px] mb-[72px]">
          <img class="bg-white absolute rounded-full h-36 border-2 border-black"
            src="{{ Storage::url($kepala_dinas->foto) }}" alt="">
        </div>
        <div class="pb-10 pt-5 px-5 md:px-10 lg:px-14">
          <div class="text-center flex flex-col justify-center mb-5">
            <h1 class="font-bold text-2xl md:text-3xl uppercase mb-1">{{ $kepala_dinas->nama }}</h1>
            <p>{{ $kepala_dinas->susunanOrganisasi->deskripsi_susunan_organisasi }}</p>
          </div>
          <div class="flex flex-col justify-center items-center max-w-3xl mx-auto">
            <div class="hidden sm:grid sm:grid-cols-2 sm:gap-20">
              <h1 class="font-bold text-base md:text-lg lg:text-xl uppercase mb-2 text-end">Riwayat Pendidikan</h1>
              <h1 class="font-bold text-base md:text-lg lg:text-xl uppercase mb-2 text-start">Jenjang Karir</h1>
            </div>
            <div class="sm:grid sm:grid-cols-2 sm:gap-10 lg:gap-20">
              <h1 class="block sm:hidden font-bold text-base md:text-lg lg:text-xl uppercase mb-2 text-start">Riwayat
                Pendidikan</h1>
              <ol class="relative border-s sm:border-e sm:border-s-0 border-gray-200 text-start sm:text-end">
                @foreach ($riwayat_pendidikan as $item)
                  <li class="mb-8 ms-6 sm:me-6">
                    <span
                      class="sm:flex absolute hidden items-center justify-center w-6 h-6 bg-blue-100 rounded-full sm:!-end-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                      <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                          d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                      </svg>
                    </span>
                    <span
                      class="flex sm:hidden absolute items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                      <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                          d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                      </svg>
                    </span>
                    <h3 class="mb-1 text-base lg:text-lg font-medium text-gray-900 dark:text-white">
                      {{ $item->nama_pendidikan }}</h3>
                    {{-- <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d M Y') }}
                  </time> --}}
                  </li>
                @endforeach
              </ol>
              <h1 class="block sm:hidden font-bold text-base md:text-lg lg:text-xl uppercase mb-2 text-start mt-5">Jenjang
                Karir</h1>
              <ol class="relative border-s border-gray-200">
                @foreach ($jenjang_karir as $item)
                  <li class="mb-8 ms-6">
                    <span
                      class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                      <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                          d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                      </svg>
                    </span>
                    <h3 class="mb-1 text-base lg:text-lg font-medium text-gray-900 dark:text-white">
                      {{ $item->nama_karir }}</h3>
                    <time
                      class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d M Y') }}</time>
                  </li>
                @endforeach
              </ol>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection
