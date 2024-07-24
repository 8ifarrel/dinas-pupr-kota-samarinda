@extends('guest.layouts.pengumuman')

@section('slot')
  <div class="py-5 md:py-12 lg:px-24 3xl:px-48">
    <div class="text-center mb-2 lg:mb-3">
      <span
        class="bg-blue uppercase font-bold text-yellow text-sm lg:text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">
        {{ $page_title }}
      </span>
    </div>

    <h1 class="text-center font-bold text-2xl lg:text-3xl pb-6 lg:pb-12 uppercase">
      {{ $page_subtitle }}
    </h1>

    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="pengumuman" class="border shadow border-separate rounded-3xl stripe hover row-border table-auto" style="width:100%;">
        <thead>
          <tr >
            <th class="bg-yellow/30 border-none rounded-tl-3xl">#</th>
            <th class="bg-yellow/30">Judul</th>
            <th class="bg-yellow/30">Tanggal Terbit</th>
            <th class="bg-yellow/30 border-none rounded-tr-3xl">Lampiran</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pengumuman as $item)
            <tr>
              {{-- # --}}
              <td>
                {{ $loop->iteration }}
              </td>

              {{-- Judul --}}
              <td>
                {{ $item->judul_pengumuman }}
              </td>

              {{-- Tanggal Terbit --}}
              <td>
                {{ $item->created_at->format('d M Y') }}
              </td>

              {{-- Lampiran --}}
              <td>
                apalah
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>#</th>
            <th>Judul</th>
            <th>Tanggal Terbit</th>
            <th>Lampiran</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
@endsection
