<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <meta name="description" content="{{ $meta_description }}" />

  <meta name="robots" content="noindex, nofollow">

  <title>
    {{ $page_title ? $page_title . ' |' : '' }} Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda
  </title>

  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon/favicon-16x16.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon/favicon-32x32.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('image/favicon/apple-touch-icon.png') }}">
  <link rel="manifest" href="{{ asset('image/favicon/site.webmanifest') }}">
  <link rel="shortcut icon" href="{{ asset('image/favicon/favicon.ico') }}">
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('image/favicon/android-chrome-192x192.png') }}">
  <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('image/favicon/android-chrome-512x512.png') }}">
  <link rel="dns-prefetch" href="https://lottie.host">
  <link rel="preconnect" href="https://lottie.host" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  @vite('resources/css/sweetalert2.css')
  @vite('resources/css/app.css')
</head>

<body>
  <div class="hidden py-4 px-16 lg:flex justify-between items-center bg-[#D9D9D9D9]">
    <figure class="flex gap-2">
      <img class="h-[55px]" src="{{ config('app.logo_pemkot') }}" alt="{{ config('app.nama_pemkot') }}" />
      <img class="h-[55px]" src="{{ config('app.logo_dinas') }}" alt="{{ config('app.nama_dinas') }}" />
      <figcaption class="my-auto text-lg text-brand-blue font-bold w-[340px] uppercase">
        {{ config('app.nama_dinas') }}
      </figcaption>
    </figure>

    <div>
      <p class="text-lg font-semibold current-time"></p>
    </div>
  </div>

  @if (session('success'))
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
          html: `
        <div class="flex flex-col items-center">
          <!-- ICON ATAS -->
          <dotlottie-player
            src="https://lottie.host/1e9820b7-84fe-45d5-ad40-14004aa784a9/N2PtNg9vHv.lottie"
            background="transparent"  
            speed="1"
            class="w-[100px] h-[100px] tv-vertical:w-[250px] tv-vertical:h-[250px]"
            loop autoplay>
          </dotlottie-player>

          <!-- TITLE -->
          <h2 class="text-brand-blue font-bold text-xl sm:text-2xl tv-vertical:text-5xl tv-vertical:mt-2 mb-4 text-center">
            Berhasil!
          </h2>

          <!-- TEXT SESSION -->
          <p class="tv-vertical:mt-4 text-gray-700 text-base sm:text-lg tv-vertical:text-3xl font-medium text-center">
            {{ session('success') }}
          </p>
        </div>
      `,
          icon: null,
          showConfirmButton: true,
          confirmButtonText: 'Oke',
          customClass: {
            popup: 'tv-vertical:w-full tv-vertical:max-w-2xl tv-vertical:pb-10 rounded-2xl',
            confirmButton: 'rounded-full bg-brand-blue text-brand-yellow px-4 py-2 text-lg font-bold transition-all duration-200 hover:bg-brand-yellow hover:text-brand-blue active:scale-95 focus:outline-none focus:ring-2 focus:ring-black disabled:opacity-50 disabled:cursor-not-allowed tv-vertical:text-2xl tv-vertical:px-10 tv-vertical:py-4'
          },
          buttonsStyling: false
        });
      });
    </script>
  @endif

  <div class=" flex-col tv-vertical:flex tv-vertical:items-center h-[calc(100vh-450px)]">
    <div class="p-14 w-full border-b-[3px] border-gray-400">
      <div class="text-center">
        <span
          class="bg-brand-blue font-bold text-brand-yellow text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300 tv-vertical:text-2xl tv-vertical:px-8 tv-vertical:py-2">
          Penilaian
        </span>
        <h1 class="mt-3 mb-5 text-3xl font-bold tv-vertical:text-5xl tv-vertical:mt-8 tv-vertical:mb-10">
          {{ $page_title }}
        </h1>
      </div>

      <div class="mb-5 flex justify-center flex-col items-center gap-y-1 tv-vertical:mb-10 tv-vertical:gap-y-4">
        <p
          class="rounded-xl bg-brand-yellow px-3 py-1.5 sm:px-4 sm:py-2 text-sm xs:text-base sm:text-lg font-semibold text-brand-blue shadow w-fit text-center tv-vertical:text-3xl tv-vertical:px-8 tv-vertical:py-4">
          Indeks Kepuasan Masyarakat:
          <span class="font-extrabold">{{ number_format($rata_rata, 3, ',', '.') }}/4</span>
        </p>

        <p class="font-medium tv-vertical:text-2xl">
          dengan total <span class="font-bold">{{ number_format($total_responden) }}</span> responden
        </p>
      </div>

      <form action="{{ route('guest.skm.store') }}" method="POST" class="w-full">
        @csrf

        <div class="w-full max-w-5xl mx-auto grid grid-cols-2 sm:grid-cols-4 gap-5">
          @php
            $options = [
                ['id' => 'tidak-puas', 'value' => 1, 'label' => 'Tidak Puas', 'video' => '11175771'],
                ['id' => 'biasa-saja', 'value' => 2, 'label' => 'Biasa Saja', 'video' => '11175745'],
                ['id' => 'puas', 'value' => 3, 'label' => 'Puas', 'video' => '11175727'],
                ['id' => 'sangat-puas', 'value' => 4, 'label' => 'Sangat Puas', 'video' => '11175766'],
            ];
          @endphp

          @foreach ($options as $option)
            <div>
              <input type="radio" name="nilai" id="{{ $option['id'] }}" value="{{ $option['value'] }}"
                class="peer hidden" required />

              <label for="{{ $option['id'] }}"
                class="bg-white flex cursor-pointer flex-col items-center gap-2 rounded-2xl border p-4 shadow-md transition peer-checked:ring-2 peer-checked:ring-brand-blue hover:scale-105 active:scale-95 group tv-vertical:p-8">
                <video width="100" height="100" autoplay loop muted playsinline preload="auto"
                  poster="https://cdn-icons-png.flaticon.com/512/11175/{{ $option['video'] }}.png"
                  class="mx-auto rounded-xl" style="background: transparent center center / contain no-repeat;">
                  <source src="https://cdn-icons-mp4.flaticon.com/512/11175/{{ $option['video'] }}.mp4"
                    type="video/mp4" />
                </video>
                <span class="font-semibold tv-vertical:text-2xl text-center">
                  {{ $option['label'] }}
                </span>
              </label>
            </div>
          @endforeach
        </div>

        <!-- Tombol Submit -->
        <div class="my-6 flex justify-center tv-vertical:my-12">
          <button type="submit"
            class="rounded-full bg-brand-yellow text-brand-blue px-6 py-2 text-lg font-bold transition-all duration-200 hover:bg-brand-blue hover:text-brand-yellow active:scale-95 focus:outline-none focus:ring-2 focus:ring-black disabled:opacity-50 disabled:cursor-not-allowed tv-vertical:text-2xl tv-vertical:px-16 tv-vertical:py-4">
            Kirim Survei
          </button>
        </div>
      </form>

    </div>
    <div class="bg-white p-14 w-full">
      <div class="text-center">
        <span
          class="bg-brand-blue font-bold text-brand-yellow text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300 tv-vertical:text-2xl tv-vertical:px-8 tv-vertical:py-2">
          Penilaian
        </span>
        <h1 class="mt-3 mb-5 text-3xl font-bold tv-vertical:text-5xl tv-vertical:mt-8 tv-vertical:mb-10">
          Survei Penilaian Integritas
        </h1>
      </div>

      <img src="{{ asset('image/others/spi.png') }}" alt="">
    </div>
  </div>

  <footer class="bg-[#D9D9D9D9] flex flex-col items-center">
    <div
      class="xs:grid xs:grid-cols-2 md:grid-cols-[auto_auto_300px] lg:grid-cols-[auto_auto_350px] lg:w-[930px] xl:w-auto lg:auto-cols-auto xl:flex xl:justify-between p-[1.35rem] md:p-8 lg:py-8 lg:px-0 xl:p-12 xl:h-[360px] tv-vertical:flex-row tv-vertical:flex tv-vertical:gap-10">
      <figure class="xs:col-span-2 md:col-span-3 mb-4 xl:mb-0 xl:w-[35%]">
        <span class="flex gap-2 mb-1 xl:mb-2">
          <img class="h-[50px] xl:h-[75px]" src="{{ asset('image/logo/pemkot-samarinda.png') }}"
            alt="Pemerintah Kota Samarinda" />
          <img class="h-[50px] xl:h-[75px]" src="{{ config('app.logo_dinas') }}"
            alt="{{ config('app.nama_dinas') }}" />
        </span>

        <figcaption class="font-bold text-lg lg:text-xl uppercase mb-1 xl:mb-2">
          {{ config('app.nama_dinas') }}
        </figcaption>

        <figcaption>
          Jalan H. Achmad Amins, Kelurahan Gn. Lingai, Kecamatan Sungai Pinang, Kota Samarinda, Provinsi Kalimantan
          Timur,
          75117
        </figcaption>

        <div class="mt-2 grid gap-2 grid-cols-2">
          <a href="https://www.facebook.com/dpuprkotasamarinda/" target="_blank" class="flex items-center">
            <i class="fa-brands fa-facebook me-1" style="color: #000000;"></i>
            @dpuprkotasamarinda
          </a>

          <a href="https://www.instagram.com/dpuprkotasamarinda/" target="_blank" class="flex items-center">
            <i class="fa-brands fa-instagram me-1" style="color: #000000;"></i>
            @dpuprkotasamarinda
          </a>

          <a href="https://www.youtube.com/@dinaspuprkotasamarinda" target="_blank" class="flex items-center">
            <i class="fa-brands fa-youtube me-1" style="color: #000000;"></i>
            @dinaspuprkotasamarinda
          </a>

          <a href="mailto:dpuprkotasamarinda@gmail.com" class="flex items-center">
            <i class="fa-regular fa-envelope me-1" style="color: #000000;"></i>
            dpuprkotasamarinda@gmail.com
          </a>
        </div>
      </figure>

      <div>
        <h1 class="mb-1 font-bold text-lg xl:text-xl">
          LOKASI
        </h1>
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.690298112536!2d117.17512067507042!3d-0.45899179953650165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df5d6033b793f91%3A0xe380dade32764edd!2sKantor%20PUPR%20Samarinda!5e0!3m2!1sen!2sid!4v1704714282337!5m2!1sen!2sid"
          class="h-[193.517px] w-[250px] xs:w-[300px] lg:w-[350px]" style="border:0;" allowfullscreen=""
          loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>

    <div
      class="bg-brand-blue py-2.5 w-full text-white text-center text-xs flex flex-col justify-between px-[1.35rem] md:px-36 gap-1">
      <p>
        © 2024-2025 {{ config('app.nama_dinas') }}
      </p>

      <a class="underline" href="{{ route('guest.kebijakan-privasi.index') }}">
        Kebijakan Privasi & Penggunaan Kuki
      </a>
    </div>
  </footer>


  @include('guest.components.privacy-policy-notification')

  <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module" defer>
  </script>
  @vite('resources/js/app.js')
  @vite('resources/js/clock.js')
  @vite('resources/js/navbar-guest.js')
  @vite('resources/js/sweetalert2.js')

</body>

</html>


@section('document.start')
@endsection
