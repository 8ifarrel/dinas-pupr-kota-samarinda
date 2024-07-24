@extends('guest.layouts.pengumuman')

@section('slot')
  <div class="py-5 md:py-12 px-6 lg:px-24 3xl:px-48">
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
      <table id="pengumuman" class="border shadow border-separate rounded-3xl stripe hover row-border table-auto"
        style="width:100%;">
        <thead>
          <tr>
            <th class="bg-yellow/35 border-none rounded-tl-3xl">#</th>
            <th class="bg-yellow/35 min-w-44">Judul</th>
            <th class="bg-yellow/35 min-w-36">Tanggal Terbit</th>
            <th class="bg-yellow/35 border-none rounded-tr-3xl">Lampiran</th>
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
                <button data-modal-target="static-modal" data-modal-toggle="static-modal"
                  class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 bg-blue font-semibold rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                  type="button">
                  Lihat
                </button>
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

  <!-- Main modal -->
  <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Static modal
          </h3>
          <button type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-hide="static-modal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5 space-y-4">
          <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
            With less than a month to go before the European Union enacts new consumer privacy laws for its citizens,
            companies around the world are updating their terms of service agreements to comply.
          </p>
        </div>
        <!-- Modal footer -->
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
          <button data-modal-hide="static-modal" type="button"
            class="text-white bg-blue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Unduh Lampiran</button>
        </div>
      </div>
    </div>
  </div>
@endsection
