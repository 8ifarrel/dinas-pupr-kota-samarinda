@extends('guest.layouts.beranda')

@section('slot')
  {{-- Slider --}}
  <div id="default-carousel" class="relative w-full" data-carousel="slide">
    <!-- Carousel wrapper -->
    <div class="relative w-full pb-[42.8571%] overflow-hidden">
      @foreach ($slider as $key => $item)
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
          <img src="{{ $item->foto_slider }}"
            class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
            alt="Slider Image {{ $key + 1 }}">
        </div>
      @endforeach
    </div>

    <!-- Slider controls -->
    <button type="button"
      class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
      data-carousel-prev>
      <span
        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
        </svg>
        <span class="sr-only">Previous</span>
      </span>
    </button>
    <button type="button"
      class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
      data-carousel-next>
      <span
        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
        </svg>
        <span class="sr-only">Next</span>
      </span>
    </button>
  </div>

  {{-- Sambutan Kepala Dinas --}}
  <div class="bg-gray-200 p-10 md:p-12">
    @if ($kepala_dinas)
      <div class="flex flex-col-reverse lg:flex-row justify-center items-center gap-3 lg:gap-16">
        <div>
          <div class="static flex flex-col-reverse items-center">
            <div
              class="mb-[5rem] sm:mb-[3.8rem] md:mb-[3.7rem] static bg-blue rounded-t-[45%] lg:rounded-tl-[50%] lg:rounded-tr-none">
              {{-- <img class="lg:h-[450px]" src="{{ $kepala_dinas->foto_pegawai }}" alt=""> --}}
              <img class="lg:h-[450px]" src="https://pupr.samarindakota.go.id/temp/desy-damayanti-st-mt.png"
                alt="">
            </div>

            <div
              class="mx-[1.35rem] lg:mx-0 py-1.5 lg:py-1 px-2 lg:px-3 text-center absolute shadow-lg bg-white rounded-lg">
              <p class="font-bold text-lg lg:text-xl">
                {{ $kepala_dinas->nama_pegawai }}
              </p>

              <p class="  text-sm lg:text-base lg:font-medium">
                Kepala Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda
              </p>
            </div>
          </div>
        </div>

        <div class="max-w-md lg:text-start text-center grid gap-3">
          <div>
            <span
              class="bg-blue font-bold text-yellow text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">
              SAMBUTAN
            </span>
          </div>

          <h1 class="font-bold text-3xl">
            SAMBUTAN KEPALA DINAS
          </h1>

          <p>
            {{ $kepala_dinas->jabatan->deskripsi_jabatan }}
          </p>

          <div>
            <button type="button"
              class="text-blue bg-yellow font-bold rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
              Lihat Profil Selengkapnya
            </button>
          </div>
        </div>
      </div>
    @endif
  </div>

  {{-- Berita --}}
  <div class="p-10 md:p-12">
    <div class="text-center pb-6 lg:pb-12 grid gap-3">
      <div>
        <span
          class="bg-blue font-bold text-yellow text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">
          BERITA TERBARU
        </span>
      </div>

      <h1 class="font-bold text-3xl">
        SEPUTAR DPUPR KOTA SAMARINDA
      </h1>
    </div>

    <div class="w-fit grid mx-auto md:grid-cols-2 lg:grid-cols-3 gap-7">
      @foreach ($berita as $item)
        <div class="mx-auto max-w-[320px] rounded-xl shadow-lg flex flex-col">
          <div class="text-center text-white font-bold bg-blue rounded-t-xl py-1.5">
            {{ $item->kategori->jabatan->nama_jabatan }}
          </div>
          <a href="#">
            <img class="aspect-[16/9]" src="{{ Storage::url($item->foto_berita) }}" alt="" />
          </a>
          <div class="p-5 flex-grow flex flex-col justify-between">
            <div>
              <a href="#">
                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                  {{ $item->judul_berita }}</h5>
              </a>
              <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                {{ $item->created_at->format('d M Y') }}</p>
            </div>
            <div class="flex justify-start">
              <a href="#"
                class="inline-flex items-center px-3 py-2 text-sm font-semibold text-center text-blue bg-yellow rounded-xl w-auto">
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
  </div>

  {{-- Struktur Organisasi --}}
  <div class="bg-gray-200 p-10 md:p-12">
    <div class="text-center pb-6 lg:pb-12 grid gap-3">
      <div>
        <span
          class="bg-blue font-bold text-yellow text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">
          STRUKTUR ORGANISASI
        </span>
      </div>

      <h1 class="font-bold text-3xl">
        ORGANISASI KAMI
      </h1>
    </div>

    <div class="w-fit grid mx-auto md:grid-cols-2 lg:grid-cols-3 gap-7">
      @foreach ($struktur_organisasi as $item)
        <div
          class="max-w-xs p-6 bg-white rounded-3xl shadow text-center flex flex-col mx-auto {{ $item->nomor_urut_jabatan == 1 ? 'md:col-span-2 lg:col-span-3' : '' }}">
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

  {{-- Agenda Kegiatan --}}
  <div class="p-10 md:p-12">
    <div class="text-center pb-6 lg:pb-12 grid gap-3">
      <div>
        <span
          class="bg-blue font-bold text-yellow text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">
          JADWAL
        </span>
      </div>

      <h1 class="font-bold text-3xl">
        AGENDA KEGIATAN
      </h1>
    </div>
  </div>

  {{-- Statistik Pengunjung --}}
  <div class="bg-gray-200 p-6 md:p-12">
    <div class="text-center pb-6 lg:pb-12 grid gap-3">
      <div>
        <span
          class="bg-blue font-bold text-yellow text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">
          STATISTIK
        </span>
      </div>

      <h1 class="font-bold text-3xl">
        STATISTIK PENGUNJUNG
      </h1>
    </div>

    <div class="flex justify-center items-center">
      <div class="grid sm:grid-cols-3 gap-2 md:gap-4">
        <div href="#" class="block max-w-xs py-3 px-5 md:px-6 md:py-4 bg-blue text-center rounded-2xl shadow">
          <h5 class="mb-2 text-2xl md:text-3xl font-bold tracking-tight text-white">HARI INI</h5>
          <p class="text-2xl md:text-3xl font-bold text-yellow">0</p>
        </div>

        <div href="#" class="block max-w-xs py-3 px-5 md:px-6 md:py-4 bg-blue text-center rounded-2xl shadow">
          <h5 class="mb-2 text-2xl md:text-3xl font-bold tracking-tight text-white">MINGGU INI</h5>
          <p class="text-2xl md:text-3xl font-bold text-yellow">0</p>
        </div>

        <div href="#" class="block max-w-xs py-3 px-5 md:px-6 md:py-4 bg-blue text-center rounded-2xl shadow">
          <h5 class="mb-2 text-2xl md:text-3xl font-bold tracking-tight text-white">BULAN INI</h5>
          <p class="text-2xl md:text-3xl font-bold text-yellow">0</p>
        </div>
      </div>
    </div>
  </div>

  {{-- Partner --}}
  <div class="p-10 md:p-12">
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active flex justify-evenly">
          <section class="splide w-full" aria-labelledby="carousel-heading">
            <div class="splide__track">
              <ul class="splide__list">
                @foreach ($partner as $item)
                  {{-- 16:9x315 --}}
                  <li class="splide__slide my-auto mx-3">
                    <a href="{{ $item->url_partner }}">
                      <img src="{{ $item->foto_partner }}" alt="{{ $item->nama_partner }}">
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
@endsection
