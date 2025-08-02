@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@section('document.body')
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto">
      <div class="flex items-center justify-center flex-col md:flex-row md:justify-between gap-2.5">
        {{-- Tombol Unduh --}}
        <a href="#"
          class="flex items-center justify-center gap-1.5 text-black bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 rounded-lg text-sm py-2 px-3 focus:outline-none whitespace-nowrap font-semibold">
          <i class="fa-solid fa-download"></i> <span>Unduh Semua Laporan</span>
        </a>

        {{-- Filter Status --}}
        <div>
          <label for="filter-status">Filter Status:</label>
          <form method="GET" class="inline">
            <select id="filter-status" name="status_id" class="border rounded px-2 py-1 border-gray-400"
              onchange="this.form.submit()">
              @foreach ($statuses as $status)
                <option value="{{ $status->value }}" {{ request('status_id') === $status->value ? 'selected' : '' }}>
                  {{ $status->label }}
                </option>
              @endforeach
            </select>
          </form>
        </div>
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
          @foreach ($laporans as $index => $item)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $item->id_laporan }}</td>
              <td>{{ $item->pelapor->nama_lengkap ?? '-' }}</td>
              <td>{{ $item->pelapor->nomor_ponsel ?? '-' }}</td>
              <td>{{ $item->alamat_lengkap_kerusakan }}</td>
              <td>
                @php
                  $pendingStatusId = 1;
                  $approvedStatusIds = [2, 3, 4, 5, 6];
                  $statusId = $item->status_id;
                  $statusLabel = '-';
                  $statusClass = 'bg-gray-100 text-gray-800';
                  if ($statusId == $pendingStatusId) {
                      $statusLabel = 'Pending';
                      $statusClass = 'bg-yellow-100 text-yellow-800';
                  } elseif (in_array($statusId, $approvedStatusIds)) {
                      $statusLabel = 'Disetujui';
                      $statusClass = 'bg-green-100 text-green-800';
                  }
                @endphp
                <span class="{{ $statusClass }} text-xs me-2 px-1.5 py-0.5 rounded border border-gray-400">
                  {{ $statusLabel }}
                </span>
              </td>
              <td>
                {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('l, d F Y (H:i)') : '-' }}
              </td>
              <td>{{ \Illuminate\Support\Str::limit($item->deskripsi_laporan, 40) }}</td>
              <td class="min-w-[200px]">
                <div class="grid grid-cols-2 gap-2">
                  {{-- Tombol Setuju --}}
                  @php
                    $isApproved = in_array($item->status_id, [2, 3, 4, 5, 6]);
                  @endphp
                  <button data-modal-target="acceptModal-{{ $item->id_laporan }}"
                    data-modal-toggle="acceptModal-{{ $item->id_laporan }}"
                    class="flex items-center justify-center gap-1.5 text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm py-2 px-3 focus:outline-none whitespace-nowrap {{ $isApproved ? 'opacity-60 cursor-not-allowed pointer-events-none' : '' }}"
                    @if($isApproved) disabled aria-disabled="true" @endif>
                    <i class="fa-solid fa-check"></i> <span>Setuju</span>
                  </button>
                  {{-- Tombol Hapus --}}
                  <button data-modal-target="deleteModal-{{ $item->id_laporan }}"
                    data-modal-toggle="deleteModal-{{ $item->id_laporan }}"
                    class="flex items-center justify-center gap-1.5 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm py-2 px-3 focus:outline-none whitespace-nowrap">
                    <i class="fa-solid fa-trash-can"></i> <span>Hapus</span>
                  </button>
                  {{-- Tombol Lihat --}}
                  <a href="{{ route('admin.jalan-peduli.laporan-masuk.show', $item->id_laporan) }}"
                    class="flex items-center justify-center gap-1.5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm py-2 px-3 focus:outline-none whitespace-nowrap">
                    <i class="fa-solid fa-eye"></i> <span>Lihat</span>
                  </a>
                  {{-- Tombol Unduh --}}
                  <a href="#"
                    class="flex items-center justify-center gap-1.5 text-black bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 rounded-lg text-sm py-2 px-3 focus:outline-none whitespace-nowrap">
                    <i class="fa-solid fa-download"></i> <span>Unduh</span>
                  </a>
                </div>
                {{-- Modal konfirmasi hapus --}}
                <div id="deleteModal-{{ $item->id_laporan }}" data-modal-target="deleteModal-{{ $item->id_laporan }}"
                  data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                  class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                  <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                      <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                          Konfirmasi Penghapusan
                        </h3>
                        <button type="button"
                          class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                          data-modal-hide="deleteModal-{{ $item->id_laporan }}">
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
                          Apakah Anda yakin ingin <strong>menghapus</strong> laporan dengan ID
                          <strong>{{ $item->id_laporan }}</strong>? Laporan yang telah dihapus <strong>tidak dapat
                            dipulihkan</strong>.
                        </p>
                      </div>
                      <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <form action="{{ route('admin.jalan-peduli.laporan-masuk.destroy', $item->id_laporan) }}" method="POST">
                          @csrf
                          @method('POST')
                          <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Hapus</button>
                        </form>
                        <button type="button"
                          class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                          data-modal-hide="deleteModal-{{ $item->id_laporan }}">
                          Tidak
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                {{-- Modal konfirmasi setuju --}}
                <div id="acceptModal-{{ $item->id_laporan }}" data-modal-target="acceptModal-{{ $item->id_laporan }}"
                  data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                  class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                  <div class="relative p-4 w-full max-w-3xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                      <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                          Konfirmasi Persetujuan
                        </h3>
                        <button type="button"
                          class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                          data-modal-hide="acceptModal-{{ $item->id_laporan }}">
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
                          Apakah Anda ingin <strong>menyetujui</strong> laporan dengan ID <strong>{{ $item->id_laporan }}</strong>?
                          Laporan yang telah setujui dapat diproses lebih lanjut melalui halaman <strong>Tindaklanjuti
                            Laporan</strong>.
                        </p>
                      </div>
                      <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <form action="{{ route('admin.jalan-peduli.laporan-masuk.update', $item->id_laporan) }}"
                          method="POST" class="m-0">
                          @csrf
                          @method('POST')
                          <button type="submit"
                            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                            @if($isApproved) disabled aria-disabled="true" @endif
                          >Setuju</button>
                        </form>
                        <button type="button"
                          class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                          data-modal-hide="acceptModal-{{ $item->id_laporan }}"> Tidak
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
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
