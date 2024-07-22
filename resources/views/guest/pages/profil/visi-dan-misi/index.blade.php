@extends('guest.layouts.profil')

@section('slot')
  <div class="px-5 sm:px-10 py-5 md:py-12 lg:px-80 3xl:px-96">
    {{-- Visi --}}
    <div class="mb-10">
      @if ($visi)
        <h1 class="md:text-xl font-bold text-lg">
          Visi Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda Tahun {{ $visi->periode_mulai }} - {{ $visi->periode_selesai }}
        </h1>

        <hr class="w-48 h-[3px] my-4 bg-black border-0 rounded">

				<q class="ms-2 md:ms-5 md:text-2xl italic text-xl block">{{ $visi->deskripsi_visi }}</q>
      @endif
    </div>

    {{-- Misi --}}
    <div>
      @if ($misi)
        <h1 class="md:text-xl font-bold text-lg">
          Misi Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda Tahun {{ $misi->first()->periode_mulai }} -
          {{ $misi->first()->periode_selesai }}
        </h1>

        <hr class="w-48 h-[3px] my-4 bg-black border-0 rounded">

        <p class="mb-4">Untuk mewujudkan Visi Walikota Samarinda, Dinas Pekerjaan Umum Dan Penataan Ruang Kota Samarinda melaksanakan misi sebagai berikut:</p>

				@foreach ($misi as $item)
					<p class="m-2 sm:m-5 flex items-center">
						<span class="border bg-blue rounded-lg w-9 h-9 sm:text-xl font-bold text-white sm:w-11 sm:h-11 flex items-center justify-center me-2 shrink-0">{{ $loop->iteration }}</span> {{ $item->deskripsi_misi }}
					</p>
				@endforeach				
      @endif
    </div>
  </div>
@endsection
