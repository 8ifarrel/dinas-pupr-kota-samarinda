@extends('guest.layouts.buku-tamu')

@section('document.head')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
    integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('document.body')
  <section class="relative h-screen flex flex-col items-center justify-center overflow-hidden">
    {{-- Map BG --}}
    <div class="absolute inset-0 z-0 pointer-events-none">
      <img src="{{ asset('image/hero/drainase-irigasi.jpeg') }}" alt="Peta Samarinda"
        class="w-full h-full object-cover opacity-25 blur-[2px]" />
      <div class="absolute inset-0 bg-gradient-to-b from-brand-blue/70 via-white/10 to-white"></div>
    </div>
    <div class="flex gap-2.5 absolute xl:top-6 2xl:top-8 3xl:top-10">
      <img class="xl:h-12 2xl:h-14 3xl:h-16" src="{{ config('app.logo_pemkot') }}" alt="{{ config('app.nama_pemkot') }}" />
      <img class="xl:h-12 2xl:h-14 3xl:h-16" src="{{ config('app.logo_dinas') }}" alt="{{ config('app.nama_dinas') }}" />
    </div>
    {{-- Main Card --}}
    <div class="relative z-10 flex flex-col items-center w-full xl:gap-6">
      <div class="text-center">
        <div class="flex justify-center gap-2 mb-2 3xl:mb-4">
          <span
            class="inline-block bg-brand-yellow text-brand-blue font-bold xl:text-base 2xl:text-lg 3xl:text-xl xl:px-3 xl:py-0.5 2xl:px-4 2xl:py-1 rounded-full shadow">{{ $page_subtitle }}</span>
        </div>
        <p class="xl:text-2xl 2xl:text-3xl 3xl:text-4xl font-semibold text-gray-700 mx-auto">
          Selamat Datang di
        </p>
        <h1 class="xl:mb-4 xl:text-6xl 2xl:text-7xl 3xl:text-8xl font-semibold text-brand-blue">
          Buku Tamu <br> Digital
        </h1>
        <p class="xl:mb-5 2xl:mb-7 3xl:mb-9 xl:text-xl 2xl:text-2xl 3xl:text-3xl font-semibold text-gray-700 mx-auto">
          {{-- Silakan mengisi buku tamu digital ini sebagai tanda kunjungan Anda. --}}
          Dinas Pekerjaan Umum dan Penataan Ruang <br> Kota Samarinda
        </p>
        <div class="flex justify-center gap-3 xl:justify-center xl:gap-4">
          <a href="{{ route('guest.buku-tamu.create') }}"
            class="inline-flex justify-center items-center xl:py-3 xl:px-5 2xl:py-3.5 2xl:px-6 3xl:py-4 3xl:px-7 xl:text-lg 2xl:text-xl 3xl:text-2xl font-semibold text-white rounded-full bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue shadow-lg transition">
            Klik untuk Mengisi Buku Tamu
            <i class="fa-solid fa-book-bookmark ms-1.5"></i>
          </a>
        </div>
      </div>
    </div>
  </section>
@endsection
