@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@section('document.body')
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto">
      {{-- Filter Status --}} {{-- TODO: Sesuaikan --}}
      <div class="flex items-center justify-center md:justify-normal gap-1.5">
        <label for="filter-status">Filter Status:</label>
        <select id="filter-status" name="filter-status" class="border rounded px-2 py-1 border-gray-400">
          <option value="">Semua</option>
          <option value="disetujui">Disetujui</option>
          <option value="ditolak">Ditolak</option>
          <option value="pending">Pending</option>
          <option value="lainnya">Lainnya</option>
        </select>
      </div>
      <table id="jalan-peduli" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>ID Laporan</th>
            <th>Nama</th>
            <th>No HP</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th>Tanggal Masuk</th>
            <th>Deskripsi</th>
            <th class="w-[200px]">Aksi</th>
          </tr>
        </thead>
        <tbody>
          {{-- @foreach ($data as $item) --}} {{-- TODO: Sesuaikan --}}
          <tr>
            <td>1 {{-- $loop->iteration --}}</td> {{-- TODO: Uncomment ini --}}
            <td>Ini ID</td> {{-- TODO: Sesuaikan --}}
            <td>Ini nama</td> {{-- TODO: Sesuaikan --}}
            <td>0869696969</td> {{-- TODO: Sesuaikan --}}
            <td>Ini lokasi</td> {{-- TODO: Sesuaikan --}}
            <td> {{-- TODO: Sesuaikan --}}
              <span
                class="bg-green-100 text-green-800 text-xs me-2 px-1.5 py-0.5 rounded border border-green-400">Disetujui</span>
              <span class="bg-red-100 text-red-800 text-xs me-2 px-1.5 py-0.5 rounded border border-red-400">Ditolak</span>
              <span
                class="bg-yellow-100 text-yellow-800 text-xs me-2 px-1.5 py-0.5 rounded border border-yellow-500">Pending</span>
              <span
                class="bg-gray-100 text-gray-800 text-xs me-2 px-1.5 py-0.5 rounded border border-gray-500">Others?</span>
            </td>
            <td>Ini tanggal masuk</td> {{-- TODO: Sesuaikan --}}
            <td>Ini deskripsi</td> {{-- TODO: Sesuaikan --}}
            <td class="min-w-[200px]">
              <div class="grid grid-cols-2 gap-2">
                {{-- Tombol Setuju --}}
                <button data-modal-target="acceptModal-{{-- $item->id --}}" {{-- TODO: Uncomment ini --}}
                  data-modal-toggle="acceptModal-{{-- $item->id --}}" {{-- TODO: Uncomment ini --}}
                  class="flex items-center justify-center gap-1.5 text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm py-2 px-3 focus:outline-none whitespace-nowrap">
                  <i class="fa-solid fa-check"></i> <span>Setuju</span>
                </button>

                {{-- Tombol Hapus --}}
                <button data-modal-target="deleteModal-{{-- $item->id --}}" {{-- TODO: Uncomment ini --}}
                  data-modal-toggle="deleteModal-{{-- $item->id --}}" {{-- TODO: Uncomment ini --}}
                  class="flex items-center justify-center gap-1.5 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm py-2 px-3 focus:outline-none whitespace-nowrap">
                  <i class="fa-solid fa-trash-can"></i> <span>Hapus</span>
                </button>

                {{-- Tombol Lihat --}}
                {{-- <a href="{{ route('admin.jalan-peduli.laporan-masuk.show', $item->id) }}" --}} {{-- TODO: Uncomment ini --}}
                <a href="{{ route('admin.jalan-peduli.laporan-masuk.show', 1) }}" {{-- TODO: Hapus ini --}}
                  class="flex items-center justify-center gap-1.5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm py-2 px-3 focus:outline-none whitespace-nowrap">
                  <i class="fa-solid fa-eye"></i> <span>Lihat</span>
                </a>

                {{-- Tombol Unduh --}}
                <a href="{{-- --}}" {{-- TODO: Sesuaikan --}}
                  class="flex items-center justify-center gap-1.5 text-black bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 rounded-lg text-sm py-2 px-3 focus:outline-none whitespace-nowrap">
                  <i class="fa-solid fa-download"></i> <span>Unduh</span>
                </a>
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
                    Apakah Anda yakin ingin menghapus laporan dengan ID
                    <strong>{{-- $item->id --}}324ini_id324</strong>? {{-- TODO: Uncomment ini --}} Laporan yang telah dihapus <strong>tidak dapat dipulihkan</strong>.
                  </p>
                </div>
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                  <form action="{{-- route('admin.jalan-peduli.laporan-masuk.destroy', $item->id) --}}" method="POST"> {{-- TODO: Uncomment ini --}}
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

          {{-- Modal konfirmasi setuju --}}
          <div id="acceptModal-{{-- $item->id --}}" {{-- TODO: Uncomment ini --}}
            data-modal-target="acceptModal-{{-- $item->id --}}" {{-- TODO: Uncomment ini --}} data-modal-backdrop="static"
            tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-3xl max-h-full">
              <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Konfirmasi Persetujuan
                  </h3>
                  <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="acceptModal-{{-- $item->id --}}"> {{-- TODO: Uncomment ini --}}
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
                    Apakah Anda ingin menyetujui laporan dengan ID <strong>{{-- $item->id --}}324ini_id324</strong>? {{-- TODO: Uncomment ini --}} Laporan yang telah setujui dapat diproses lebih lanjut melalui halaman <strong>Tindaklanjuti Laporan</strong>.
                  </p>
                </div>
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                  <form action="{{-- route('admin.jalan-peduli.laporan-masuk.update', $item->id) --}}" method="POST"> {{-- TODO: Uncomment ini --}}
                    @csrf
                    @method('PUT')
                    <button type="submit"
                      class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Setuju</button>
                  </form>
                  <button type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                    data-modal-hide="acceptModal-{{-- $item->id --}}"> {{-- TODO: Uncomment ini --}} Tidak
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
            <th>ID Laporan</th>
            <th>Nama</th>
            <th>No HP</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th>Tanggal Masuk</th>
            <th>Keterangan</th>
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
      $('#jalan-peduli').DataTable();

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

      // Modal konfirmasi
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
