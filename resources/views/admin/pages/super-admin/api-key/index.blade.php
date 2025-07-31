@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@section('document.body')
  <div class="border shadow bg-white rounded-lg p-5 mb-8 space-y-3">
    <div class="flex gap-1.5 items-center">
      <i class="fa-solid fa-circle-question"></i>
      <h2 class="font-bold text-lg">Cara menggunakan API Key</h2>
    </div>
    <hr class="border-gray-300">
    <ol class="space-y-2 list-decimal list-inside">
      <li>Salin salah satu API Key di tabel di atas.</li>
      <li>
        Di Postman (atau klien HTTP lain):
        <ul class="list-disc list-inside ml-5 space-y-1">
          <li>URL: <code class="bg-gray-100 px-2 py-0.5 rounded">POST {{ url('/api/laporan') }}</code></li>
          <li>
            Header:
            <ul class="list-disc list-inside ml-6">
              <li><code>X-API-KEY</code>: tempelkan API Key Anda</li>
              <li><code>Accept</code>: <code>application/json</code></li>
            </ul>
          </li>
          <li>Body: pilih <code>form-data</code>, lalu isi field seperti <code>nama_pelapor</code>,
            <code>nomor_telepon</code>, <code>foto_kerusakan</code>, dll.
          </li>
        </ul>
      </li>
      <li>Kirim request. Respon sukses akan mengembalikan <code>id_laporan</code> dan status <em>Menunggu
          Verifikasi</em>.</li>
    </ol>
  </div>

  <a href="{{ route('admin.super.api-key.create') }}"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
    <i class="fa-solid fa-plus me-1"></i>Buat API Key
  </a>

  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="api-key" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Key</th>
            <th>Jenis</th>
            <th>Status</th>
            <th>Dibuat Pada</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          {{-- @foreach ($api_key as $item) --}} {{-- TODO: Uncomment ini --}}
          <tr>
            <td>1 {{-- $loop->iteration --}}</td> {{-- TODO: Uncomment ini --}}
            <td>name</td> {{-- TODO: Sesuaikan --}}
            <td>key</td> {{-- TODO: Sesuaikan --}}
            <td>jenis</td> {{-- TODO: Sesuaikan --}}
            <td>
              {{-- @if ($item->is_active) --}} {{-- TODO: Uncomment ini --}}
              <span
                class="bg-green-100 text-green-800 text-xs me-2 px-1.5 py-0.5 rounded border border-green-400">Aktif</span>
              {{-- @else --}} {{-- TODO: Uncomment ini --}}
              <span
                class="bg-red-100 text-red-800 text-xs me-2 px-1.5 py-0.5 rounded border border-red-400">Nonaktif</span>
              {{-- @endif --}} {{-- TODO: Uncomment ini --}}
            </td>
            <td>created_at</td> {{-- TODO: Sesuaikan --}}
            <td>
              <div class="flex items-center space-x-2">
                {{-- Tombol ubah status --}}
                <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                  class="text-white rounded-lg text-sm px-3 py-2 text-center inline-flex items-center bg-blue-700 font-medium text-nowrap"
                  type="button">Ubah status <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m1 1 4 4 4-4" />
                  </svg>
                </button>

                {{-- Dropdown menu ubah status --}}
                {{-- TODO: Langsung arahkan ke route admin.super.api-key.update tepat setelah memilih status (metode PUT) --}}
                <div id="dropdown"
                  class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-32 dark:bg-gray-700 border">
                  <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                    <li>
                      <a href="#"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Nonaktif</a>
                    </li>
                    <li>
                      <a href="#"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Aktif</a>
                    </li>
                  </ul>
                </div>

                {{-- Tombol Hapus --}}
                <button data-modal-target="deleteModal-{{-- $item->id --}}" {{-- TODO: Uncomment ini --}}
                  data-modal-toggle="deleteModal-{{-- $item->id --}}" {{-- TODO: Uncomment ini --}}
                  class="flex justify-center items-center w-10 h-10 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm p-2.5 focus:outline-none">
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </div>
            </td>
          </tr>

          {{-- Modal konfirmasi hapus --}}
          <div id="deleteModal-{{-- $item->id --}}" {{-- TODO: Uncomment ini --}}
            data-modal-target="deleteModal-{{-- $item->id --}}" {{-- TODO: Uncomment ini --}} data-modal-backdrop="static"
            tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
              <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Konfirmasi Penghapusan
                  </h3>
                  <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="deleteModal-{{-- $item->id --}}"> {{-- TODO: Uncomment ini --}}
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
                    Apakah Anda yakin ingin menghapus API Key dengan nama <strong>{{-- $item->name --}}Ini nama</strong>?
                    {{-- TODO: Uncomment ini --}}
                  </p>
                </div>
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                  <form action="{{-- route('admin.super.api-key.destroy', $item->id) --}}" method="POST"> {{-- TODO: Uncomment ini --}}
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                      class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Hapus</button>
                  </form>
                  <button type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                    data-modal-hide="deleteModal-{{-- $item->id --}}"> {{-- TODO: Uncomment ini --}}
                    Tidak
                  </button>
                </div>
              </div>
            </div>
          </div>
          {{-- @endforeach --}} {{-- TODO: Uncomment ini --}}
        </tbody>
        <tfoot>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Key</th>
            <th>Jenis</th>
            <th>Status</th>
            <th>Dibuat Pada</th>
            <th>Aksi</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
@endsection

@section('document.end')
  <script>
    // Datatable
    document.addEventListener('DOMContentLoaded', function() {
      $('#api-key').DataTable();

      document.body.addEventListener('click', function(e) {
        var toggleBtn = e.target.closest('[data-modal-toggle]');
        if (toggleBtn) {
          var modalId = toggleBtn.getAttribute('data-modal-toggle');
          var modalEl = document.getElementById(modalId);
          if (window.Modal && modalEl) {
            if (!modalEl.__flowbiteModal) {
              modalEl.__flowbiteModal = new window.Modal(modalEl);
            }
            modalEl.__flowbiteModal.show();
          }
        }
      });

      // Modal konfirmasi hapus
      document.body.addEventListener('click', function(e) {
        var hideBtn = e.target.closest('[data-modal-hide]');
        if (hideBtn) {
          var modalId = hideBtn.getAttribute('data-modal-hide');
          var modalEl = document.getElementById(modalId);
          if (window.Modal && modalEl && modalEl.__flowbiteModal) {
            modalEl.__flowbiteModal.hide();
          }
        }
      });
    });
  </script>
@endsection
