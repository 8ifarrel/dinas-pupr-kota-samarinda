@extends('admin.layouts.partner')

@section('css')
  @vite(['resources/css/lightbox.css', 'resources/css/datatables.css'])
@endsection

@section('slot')
  <a href="{{ route('admin.partner.create') }}"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
    <i class="fa-solid fa-plus me-1"></i>Tambah Partner
  </a>

  {{-- Daftar Partner --}}
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="partner" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>Foto</th>
            <th>Nama</th>
            <th>URL</th>
            <th>Kelola</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($partners as $partner)
            <tr>
              <td>
                <a href="{{ Storage::url($partner->foto_partner) }}" data-lightbox="partner"
                  data-title="{{ $partner->nama_partner }}">
                  <img src="{{ Storage::url($partner->foto_partner) }}" width="192px" alt="{{ $partner->nama_partner }}">
                </a>
              </td>
              <td>{{ $partner->nama_partner }}</td>
              <td>
                <a href="{{ $partner->url_partner }}" class="text-blue-500 underline">
                  {{ $partner->url_partner }}
                </a>
              </td>
              <td>
                <div class="flex gap-2">
                  <a href="{{ route('admin.partner.edit', $partner->id_partner) }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  <button data-modal-target="deleteModal-{{ $partner->id_partner }}"
                    data-modal-toggle="deleteModal-{{ $partner->id_partner }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </div>
              </td>
            </tr>

            <!-- Modal Konfirmasi Hapus -->
            <div id="deleteModal-{{ $partner->id_partner }}" data-modal-backdrop="static" tabindex="-1"
              aria-hidden="true"
              class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
              <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                  <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Konfirmasi Penghapusan
                    </h3>
                    <button type="button"
                      class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                      data-modal-hide="deleteModal-{{ $partner->id_partner }}">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                      </svg>
                      <span class="sr-only">Close modal</span>
                    </button>
                  </div>
                  <div class="p-4 md:p-5 space-y-4">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                      Apakah Anda yakin ingin menghapus partner <strong>{{ $partner->nama_partner }}</strong>?
                    </p>
                    <div>
                      <img src="{{ Storage::url($partner->foto_partner) }}" alt="Foto Partner" class="w-72">
                    </div>
                  </div>
                  <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <form action="{{ route('admin.partner.destroy', $partner->id_partner) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                        class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Hapus</button>
                    </form>
                    <button type="button"
                      class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                      data-modal-hide="deleteModal-{{ $partner->id_partner }}">
                      Tidak
                    </button>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </tbody>

        <tfoot>
          <tr>
            <th>Foto</th>
            <th>Nama</th>
            <th>URL</th>
            <th>Kelola</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
@endsection

@section('js')
  @vite(['resources/js/lightbox.js', 'resources/js/datatables.js'])

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#partner').DataTable({
        responsive: true
      });
    });
  </script>
@endsection
