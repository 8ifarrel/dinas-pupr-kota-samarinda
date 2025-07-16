@extends('admin.layouts.profil')

@section('slot')
@if (session('success'))
  <div id="alert-success" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-100" role="alert">
    <svg class="flex-shrink-0 w-4 h-4 me-2" fill="currentColor" viewBox="0 0 20 20">
      <path d="M16.707 5.293a1 1 0 0 0-1.414 0L8 12.586l-3.293-3.293A1 1 0 0 0 3.293 10.707l4 4a1 1 0 0 0 1.414 0l8-8a1 1 0 0 0 0-1.414z" />
    </svg>
    <div class="ms-3 text-sm font-medium">
      {{ session('success') }}
    </div>
    <button type="button" class="ms-auto bg-green-100 text-green-500 rounded-lg p-1.5 hover:bg-green-200" data-dismiss-target="#alert-success" aria-label="Close">
      <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
        <path stroke="currentColor" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
      </svg>
    </button>
  </div>
@endif

  <a href="{{ route('admin.profil.visi-dan-misi.edit') }}"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
    <i class="fa-solid fa-pencil me-1.5"></i>Edit Visi dan Misi
  </a>

  {{-- Visi --}}
  <div class="mb-10 mt-10">
    @if ($visi)
      <h1 class="md:text-xl font-bold text-lg">
        Visi Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda Tahun {{ $visi->periode_mulai }} -
        {{ $visi->periode_selesai }}
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

      <p class="mb-4">Untuk mewujudkan Visi Walikota Samarinda, Dinas Pekerjaan Umum Dan Penataan Ruang Kota Samarinda
        melaksanakan misi sebagai berikut:</p>

      @foreach ($misi as $item)
        <p class="m-2 sm:m-5 flex items-center">
          <span
            class="border bg-blue rounded-lg w-9 h-9 sm:text-xl font-bold text-white sm:w-11 sm:h-11 flex items-center justify-center me-2 shrink-0">{{ $loop->iteration }}</span>
          {{ $item->deskripsi_misi }}
        </p>
      @endforeach
    @endif
  </div>
@endsection
