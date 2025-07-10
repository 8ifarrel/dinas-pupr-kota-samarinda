@extends('guest.layouts.portal')

@section('slot')
  <img src="{{ asset('image/background/portal.jpg') }}" alt="Portal"
    class="fixed top-0 left-0 w-full h-full object-cover opacity-50 -z-10">

  <main class="flex flex-col gap-3 lg:gap-4 py-4 lg:py-0 px-3 lg:px-16 w-full">
    <figure class="flex flex-col items-center">
      <div class="flex mb-2 lg:mb-3">
        <img class="h-[60px] lg:h-[75px] 3xl:h-[100px] me-2" src="{{ asset('image/logo/pemkot-samarinda.png') }}"
          alt="Pemerintah Kota Samarinda" />
        <img class="h-[60px] lg:h-[75px] 3xl:h-[100px]" src="{{ config('app.logo_dinas') }}"
          alt="{{ config('app.nama_dinas') }}" />
      </div>

      <figcaption class="text-center">
        <h1 class="uppercase font-bold text-xl lg:text-3xl 3xl:text-5xl">
          Portal Resmi <br class="inline lg:hidden"> {{ config('app.nama_singkatan_dinas') }}
        </h1>
        <p class="font-medium text-sm lg:text-2xl 3xl:text-3xl">
          Bergerak Bersama, Samarinda Makin Maju
        </p>
    </figure>

    <a href="{{ route('guest.beranda.index') }}" class="flex justify-center">
      {{-- Tombol di layar gede --}}
      <span class="hidden lg:block">
        <svg width="300" height="90" viewBox="0 0 300 90" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M30 90L0 44.0426L30 0H270L300 46L270 90H30Z" fill="#223468" />

          <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#fcb717" font-size="24"
            font-family="Arial" class="font-semibold">
            Masuk ke Website
          </text>
        </svg>
      </span>

      {{-- Tombol di hape --}}
      <span class="lg:hidden block">
        <svg width="200" height="60" viewBox="0 0 200 60" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M20 60L0 29.3617L20 0H180L200 30.6667L180 60H20Z"
            fill="#223468" />

          <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#fcb717" font-size="18"
            font-family="Arial" class="font-semibold">
            Masuk ke Website
          </text>
        </svg>
      </span>
    </a>

    {{-- Aplikasi --}}
    <div class="px-3 py-4 bg-brand-blue border-[6px] lg:border-[10px] border-gray-300 max-w-6xl 3xl:max-w-[1300px] mx-auto">
      <div class="justify-items-center text-white grid grid-cols-2 gap-3 lg:grid-cols-4 lg:gap-4">
        <button data-modal-target="modal-informasi-publik" data-modal-toggle="modal-informasi-publik" type="button">
          <figure>
            <lottie-player class="h-[100px] lg:h-[200px] 3xl:h-[250px]"
              src="https://lottie.host/dd34a41c-849f-43dc-b0bf-bb9cff0ed814/FrdooYL5sY.json" background="transparent"
              speed="1" loop autoplay></lottie-player>
            <figcaption class="text-center font-semibold text-base lg:text-xl 3xl:text-2xl text-brand-yellow">
              Informasi Publik
            </figcaption>
          </figure>
        </button>

        <button data-modal-target="modal-layanan-aplikasi" data-modal-toggle="modal-layanan-aplikasi" type="button">
          <figure>
            <lottie-player class="h-[100px] lg:h-[200px] 3xl:h-[250px]"
              src="https://lottie.host/79009bb3-5d07-4937-b043-bdfec1f41bf1/l1GIKi6RYJ.json" background="transparent"
              speed="1" loop autoplay></lottie-player>
            <figcaption class="text-center font-semibold text-base lg:text-xl 3xl:text-2xl text-brand-yellow">
              Layanan Aplikasi
            </figcaption>
          </figure>
        </button>

        <button data-modal-target="modal-layanan-aduan" data-modal-toggle="modal-layanan-aduan" type="button">
          <figure>
            <lottie-player class="h-[100px] lg:h-[200px] 3xl:h-[250px]"
              src="https://lottie.host/05a9c4fd-d359-4d7b-acbf-b9d560cf3739/vwyhQ7Wt8H.json" background="transparent"
              speed="1" loop autoplay></lottie-player>
            <figcaption class="text-center font-semibold text-base lg:text-xl 3xl:text-2xl text-brand-yellow">
              Layanan Aduan
            </figcaption>
          </figure>
        </button>

        <button data-modal-target="modal-media-sosial" data-modal-toggle="modal-media-sosial" type="button">
          <figure>
            <lottie-player class="h-[100px] lg:h-[200px] 3xl:h-[250px]"
              src="https://lottie.host/7fc5c4a3-cad9-414a-8bc5-e097ed4ca67c/zGiBmsHxZj.json" background="transparent"
              speed="1" loop autoplay></lottie-player>
            <figcaption class="text-center font-semibold text-base lg:text-xl 3xl:text-2xl text-brand-yellow">
              Media Sosial
            </figcaption>
          </figure>
        </button>
      </div>
    </div>

    {{-- Modal Informasi Publik --}}
    <div id="modal-informasi-publik" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <!-- Modal header -->
          <div class="flex w-full items-center justify-between p-3 md:p-4 border-b rounded-t border-gray-300">
            <figure class="flex">
              <div class="me-2">
                <lottie-player class="h-[50px] lg:h-[100px]"
                  src="https://lottie.host/dd34a41c-849f-43dc-b0bf-bb9cff0ed814/FrdooYL5sY.json" background="transparent"
                  speed="1" loop autoplay></lottie-player>
              </div>
              <figcaption class="my-auto text-center font-semibold text-base lg:text-2xl">
                Informasi Publik
              </figcaption>
            </figure>
            <button type="button"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
              data-modal-hide="modal-informasi-publik">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
              <span class="sr-only">Close modal</span>
            </button>
          </div>
          <!-- Modal body -->
          <div class="p-4 md:p-5 space-y-4">
            <p class="text-base leading-relaxed">
              Temukan informasi yang dapat diakses secara publik seperti berita, PPID Pelaksana, dan pengumuman di sini.
            </p>
          </div>
          <!-- Modal footer -->
          <div class="gap-3 p-4 md:p-5 border-t border-gray-300 rounded-b grid grid-cols-2  lg:flex lg:items-center">
            <a href="{{ route('guest.berita.kategori.index') }}" type="button"
              class="text-white bg-brand-blue focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Berita</a>
            <a href="{{ route('guest.ppid-pelaksana.kategori.index') }}" type="button"
              class="text-white bg-brand-blue focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">PPID
              Pelaksana</a>
            <a href="{{ route('guest.pengumuman.index') }}" type="button"
              class="text-white bg-brand-blue focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 col-span-2">Pengumuman</a>
          </div>
        </div>
      </div>
    </div>

    {{-- Modal Layanan Aplikasi --}}
    <div id="modal-layanan-aplikasi" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <!-- Modal header -->
          <div class="flex w-full items-center justify-between p-3 md:p-4 border-b rounded-t border-gray-300">
            <figure class="flex">
              <div class="me-2">
                <lottie-player class="h-[50px] lg:h-[100px]"
                  src="https://lottie.host/79009bb3-5d07-4937-b043-bdfec1f41bf1/l1GIKi6RYJ.json"
                  background="transparent" speed="1" loop autoplay></lottie-player>
              </div>
              <figcaption class="my-auto text-center font-semibold text-base lg:text-2xl">
                Layanan Aplikasi
              </figcaption>
            </figure>
            <button type="button"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
              data-modal-hide="modal-layanan-aplikasi">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
              <span class="sr-only">Close modal</span>
            </button>
          </div>
          <!-- Modal body -->
          <div class="p-4 md:p-5 space-y-4">
            <p class="text-base leading-relaxed">
              Temukan berbagai layanan aplikasi yang kami sediakan untuk memenuhi kebutuhan Anda.
            </p>
          </div>
          <!-- Modal footer -->
          <div class="gap-3 p-4 md:p-5 border-t border-gray-300 rounded-b grid grid-cols-2 lg:flex lg:items-center">
            <a href="/hantubanyu" type="button"
              class="text-white bg-brand-blue focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Hantubanyu</a>
            <a href="/uptd-limbah" type="button"
              class="text-white bg-brand-blue focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">UPTD
              Limbah</a>
            <a href="/uptd-jalan-dan-jembatan" type="button"
              class="text-white bg-brand-blue focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 col-span-2">UPTD
              Jalan dan Jembatan</a>
          </div>
        </div>
      </div>
    </div>

    {{-- Modal Layanan Aduan --}}
    <div id="modal-layanan-aduan" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <!-- Modal header -->
          <div class="flex w-full items-center justify-between p-3 md:p-4 border-b rounded-t border-gray-300">
            <figure class="flex">
              <div class="me-2">
                <lottie-player class="h-[50px] lg:h-[100px]"
                  src="https://lottie.host/05a9c4fd-d359-4d7b-acbf-b9d560cf3739/vwyhQ7Wt8H.json"
                  background="transparent" speed="1" loop autoplay></lottie-player>
              </div>
              <figcaption class="my-auto text-center font-semibold text-base lg:text-2xl">
                Layanan Aduan
              </figcaption>
            </figure>
            <button type="button"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
              data-modal-hide="modal-layanan-aduan">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
              <span class="sr-only">Close modal</span>
            </button>
          </div>
          <!-- Modal body -->
          <div class="p-4 md:p-5 space-y-4">
            <p class="text-base leading-relaxed">
              Silakan berikan aduan, kritik, atau saran Anda di sini untuk meningkatkan kualitas layanan kami.
            </p>
          </div>
          <!-- Modal footer -->
          <div class="gap-3 p-4 md:p-5 border-t border-gray-300 rounded-b grid grid-cols-2 lg:flex lg:items-center">
            <a href="{{ route('guest.skm.index') }}" type="button"
              class="text-white bg-brand-blue focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">SKM</a>
            <a href="{{ url('https://www.lapor.go.id/') }}" type="button"
              class="text-white bg-brand-blue focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">LAPOR!</a>
            <a href="{{ url('https://e-kianpuas.samarindakota.go.id/survei/form/dinas-pekerjaan-umum-dan-penataan-ruang/39ba9d60-d13d-4bce-ae9e-a54316bed169') }}"
              type="button"
              class="text-white bg-brand-blue focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 col-span-2">E-KianPuas</a>
          </div>
        </div>
      </div>
    </div>

    {{-- Modal Media Sosial --}}
    <div id="modal-media-sosial" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <!-- Modal header -->
          <div class="flex w-full items-center justify-between p-3 md:p-4 border-b rounded-t border-gray-300">
            <figure class="flex">
              <div class="me-2">
                <lottie-player class="h-[50px] lg:h-[100px]"
                  src="https://lottie.host/7fc5c4a3-cad9-414a-8bc5-e097ed4ca67c/zGiBmsHxZj.json"
                  background="transparent" speed="1" loop autoplay></lottie-player>
              </div>
              <figcaption class="my-auto text-center font-semibold text-base lg:text-2xl">
                Media Sosial
              </figcaption>
            </figure>
            <button type="button"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
              data-modal-hide="modal-media-sosial">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
              <span class="sr-only">Close modal</span>
            </button>
          </div>
          <!-- Modal body -->
          <div class="p-4 md:p-5 space-y-4">
            <p class="text-base leading-relaxed">
              Temukan kami di platform media sosial favorit Anda dan ikuti kami untuk mendapatkan informasi terbaru.
            </p>
          </div>
          <!-- Modal footer -->
          <div class="gap-3 p-4 md:p-5 border-t border-gray-300 rounded-b grid grid-cols-2 lg:flex lg:items-center">
            <a href="{{ url('https://www.instagram.com/dpuprkotasamarinda/') }}" type="button"
              class="text-white bg-brand-blue focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Instagram</a>
            <a href="{{ url('https://www.facebook.com/dpuprkotasamarinda/') }}" type="button"
              class="text-white bg-brand-blue focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Facebook</a>
            <a href="{{ url('https://www.youtube.com/@dinaspuprkotasamarinda/') }}" type="button"
              class="text-white bg-brand-blue focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 col-span-2">YouTube</a>
          </div>
        </div>
      </div>
    </div>

    {{-- Footer --}}
    <footer class="">
      <p class="mx-auto text-center font-semibold text-xs w-[85%] lg:w-full lg:text-base">
        &copy; 2024 Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda.
      </p>
    </footer>
  </main>
@endsection


