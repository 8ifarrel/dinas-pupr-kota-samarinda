@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@section('document.body')
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="buku-tamu" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>Kode</th>
            <th>Profil Pengunjung</th>
            <th>Bagian yang Akan Dikunjungi</th>
            <th>Keperluan</th>
            <th>Diajukan Pada</th>
            <th>Status</th>
            <th>Kelola</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($bukuTamu as $item)
            <tr>
              <td>{{ $item->id_buku_tamu }}</td>
              <td>
                <button type="button"
                  class="inline-flex justify-center items-center gap-1 h-8 font-medium text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm p-2.5 focus:outline-none"
                  data-modal-target="profilModal-{{ $item->id_buku_tamu }}"
                  data-modal-toggle="profilModal-{{ $item->id_buku_tamu }}">
                  <i class="fa-solid fa-eye"></i> <span
                    class="font-medium whitespace-nowrap text-xs sm:text-sm">Lihat</span>
                </button>
              </td>
              <td>{{ $item->susunanOrganisasi->nama_susunan_organisasi ?? '-' }}</td>
              <td>
                <button type="button"
                  class="inline-flex justify-center items-center gap-1 h-8 font-medium text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm p-2.5 focus:outline-none"
                  data-modal-target="tujuanModal-{{ $item->id_buku_tamu }}"
                  data-modal-toggle="tujuanModal-{{ $item->id_buku_tamu }}">
                  <i class="fa-solid fa-eye"></i> <span
                    class="font-medium whitespace-nowrap text-xs sm:text-sm">Lihat</span>
                </button>
              </td>
              <td>{{ $item->created_at->translatedFormat('l, d F Y (H:i)') }}</td>
              <td>
                @if ($item->status == 'Diterima')
                  <span
                    class="bg-green-100 text-green-800 text-xs me-2 px-1.5 py-0.5 rounded border border-green-400">Diterima</span>
                @elseif ($item->status == 'Ditolak')
                  <span
                    class="bg-red-100 text-red-800 text-xs me-2 px-1.5 py-0.5 rounded border border-red-400">Ditolak</span>
                @else
                  <span
                    class="bg-yellow-100 text-yellow-800 text-xs me-2 px-1.5 py-0.5 rounded border border-yellow-400">Pending</span>
                @endif
              </td>
              <td>
                <a href="{{ route('admin.buku-tamu.edit', $item->id_buku_tamu) }}"
                  class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
                  <i class="fa-solid fa-pencil"></i>
                </a>
              </td>
            </tr>

            <!-- Modal Profil Tamu -->
            <div id="profilModal-{{ $item->id_buku_tamu }}" data-modal-target="profilModal-{{ $item->id_buku_tamu }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
              class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
              <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                  <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Profil Pengunjung
                    </h3>
                    <button type="button"
                      class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                      data-modal-hide="profilModal-{{ $item->id_buku_tamu }}">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                      </svg>
                      <span class="sr-only">Close modal</span>
                    </button>
                  </div>
                  <div class="p-4 md:p-5 space-y-2.5">
                    <p><strong>Nama:</strong> {{ $item->nama_pengunjung }}</p>
                    <p><strong>Nomor Telepon:</strong> {{ $item->nomor_telepon }}</p>
                    <p><strong>Email:</strong> {{ $item->email }}</p>
                    <p><strong>Alamat:</strong> {{ $item->alamat }}</p>
                  </div>
                  <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button"
                      class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                      data-modal-hide="profilModal-{{ $item->id_buku_tamu }}">
                      Tutup
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal Maksud dan Tujuan -->
            <div id="tujuanModal-{{ $item->id_buku_tamu }}" data-modal-target="tujuanModal-{{ $item->id_buku_tamu }}" data-modal-backdrop="static" tabindex="-1"
              aria-hidden="true"
              class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
              <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                  <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Maksud dan Tujuan
                    </h3>
                    <button type="button"
                      class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                      data-modal-hide="tujuanModal-{{ $item->id_buku_tamu }}">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                      </svg>
                      <span class="sr-only">Close modal</span>
                    </button>
                  </div>
                  <div class="p-4 md:p-5 space-y-4">
                    <p>{{ $item->maksud_dan_tujuan }}</p>
                  </div>
                  <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button"
                      class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                      data-modal-hide="tujuanModal-{{ $item->id_buku_tamu }}">
                      Tutup
                    </button>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>Kode</th>
            <th>Profil Pengunjung</th>
            <th>Bagian yang Akan Dikunjungi</th>
            <th>Keperluan</th>
            <th>Diajukan Pada</th>
            <th>Status</th>
            <th>Kelola</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
@endsection

@section('document.end')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#buku-tamu').DataTable();

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
