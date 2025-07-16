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

  <div class="px-5 sm:px-10 py-5 md:py-12 lg:px-24 3xl:px-48">
    @if ($sejarah_dinas_pupr_kota_samarinda)
      <div class="font-dropcap column-container text-multicol">
        {!! $sejarah_dinas_pupr_kota_samarinda->deskripsi_sejarah_dinas_pupr_kota_samarinda !!}
      </div>
    @endif
  </div>
@endsection
