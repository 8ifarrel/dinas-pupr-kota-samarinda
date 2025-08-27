@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@section('document.body')
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
      <div>
        <span class="pe-1 font-semibold">Nomor antrean yang sedang diterima   :</span>
        <span class="bg-green-100 text-green-800 px-3 py-1 rounded font-bold text-lg">
          {{ $tamu_diterima ? $tamu_diterima->nomor_urut : '-' }}
        </span>
      </div>
      <div>
        <label for="filter-hari" class="pe-1">Filter Hari:</label>
        <select id="filter-hari" class="border rounded px-2 py-1 border-gray-400">
          <option value="today" {{ $filter_hari === 'today' ? 'selected' : '' }}>Hari ini saja</option>
          <option value="all" {{ $filter_hari === 'all' ? 'selected' : '' }}>Semua hari</option>
        </select>
      </div>
    </div>
    <div class="relative overflow-x-auto">
      <table id="buku-tamu-table" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Nomor Antrean</th>
            <th>Profil Tamu</th>
            <th>Keperluan</th>
            <th>Diajukan Pada</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($tamus as $index => $item)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $item->nomor_urut }}</td>
              <td>
                <button type="button"
                  class="inline-flex justify-center items-center gap-1 h-8 font-medium text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm p-2.5 focus:outline-none"
                  data-modal-target="profilModal-{{ $item->id_buku_tamu }}"
                  data-modal-toggle="profilModal-{{ $item->id_buku_tamu }}">
                  <i class="fa-solid fa-eye"></i> <span
                    class="font-medium whitespace-nowrap text-xs sm:text-sm">Lihat</span>
                </button>
              </td>
              <td>
                <button type="button"
                  class="inline-flex justify-center items-center gap-1 h-8 font-medium text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm p-2.5 focus:outline-none"
                  data-modal-target="tujuanModal-{{ $item->id_buku_tamu }}"
                  data-modal-toggle="tujuanModal-{{ $item->id_buku_tamu }}">
                  <i class="fa-solid fa-eye"></i> <span
                    class="font-medium whitespace-nowrap text-xs sm:text-sm">Lihat</span>
                </button>
              </td>
              <td>
                {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('d F Y (H:i)') : '-' }}
              </td>
              <td>
                @php
                  $status = $item->status;
                  $statusClass =
                      $status === 'Pending'
                          ? 'bg-yellow-100 text-yellow-800'
                          : ($status === 'Diterima'
                              ? 'bg-green-100 text-green-800'
                              : 'bg-gray-100 text-gray-800');
                @endphp
                <span class="{{ $statusClass }}` font-medium px-2 py-1 rounded border border-gray-400">
                  {{ $status }}
                </span>
              </td>
              <td>
                @if ($item->status === 'Pending')
                  <button type="button"
                    class="inline-flex items-center gap-1 h-8 font-medium text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm px-3 py-2.5 focus:outline-none btn-terima text-nowrap"
                    data-id="{{ $item->id_buku_tamu }}" data-nomor="{{ $item->nomor_urut }}"
                    data-modal-target="modal-terima-{{ $item->id_buku_tamu }}" data-modal-toggle="modal-terima-{{ $item->id_buku_tamu }}">
                    <i class="fa-solid fa-check"></i> Terima Tamu
                  </button>
                @elseif ($item->status === 'Diterima')
                  <button type="button"
                    class="inline-flex items-center gap-1 h-8 font-medium text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-3 py-2.5 focus:outline-none btn-selesai text-nowrap"
                    data-id="{{ $item->id_buku_tamu }}" data-nomor="{{ $item->nomor_urut }}"
                    data-modal-target="modal-selesai-{{ $item->id_buku_tamu }}" data-modal-toggle="modal-selesai-{{ $item->id_buku_tamu }}">
                    <i class="fa-solid fa-flag-checkered"></i> Tandai Sebagai Selesai
                  </button>
                @else
                  <button type="button"
                    class="inline-flex items-center gap-1 h-8 font-medium text-white bg-gray-400 cursor-not-allowed rounded-lg text-sm px-3 py-2.5 text-nowrap"
                    disabled>
                    <i class="fa-solid fa-circle-check"></i> Kunjungan Sudah Selesai
                  </button>
                @endif
              </td>
            </tr>

            <!-- Modal Profil Tamu -->
            <div id="profilModal-{{ $item->id_buku_tamu }}" data-modal-target="profilModal-{{ $item->id_buku_tamu }}"
              data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
              class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
              <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                  <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Profil Tamu
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
            <div id="tujuanModal-{{ $item->id_buku_tamu }}" data-modal-target="tujuanModal-{{ $item->id_buku_tamu }}"
              data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
              class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
              <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                  <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Keperluan
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
      </table>
    </div>
  </div>

  <!-- Modal Terima Tamu -->
  <div id="modal-terima-{{ $item->id_buku_tamu }}" data-modal-target="modal-terima-{{ $item->id_buku_tamu }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
      <div class="relative bg-white rounded-lg shadow">
        <div class="flex items-center justify-between p-4 border-b rounded-t">
          <h3 class="text-xl font-semibold text-gray-900">
            Konfirmasi Terima Tamu
          </h3>
          <button type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
            data-modal-hide="modal-terima-{{ $item->id_buku_tamu }}">
            <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <form id="form-terima" class="p-4">
          <input type="hidden" name="id_buku_tamu" id="terima-id">
          <div class="space-y-4">
            <div class="text-base leading-relaxed text-gray-500 mt-0">
              Apakah Anda ingin menerima antrean <b id="terima-nomor"></b>?
            </div>
            <div>
              <label for="terima-deskripsi" class="block">Deskripsi Status (opsional)</label>
              <textarea id="terima-deskripsi" name="deskripsi_status" rows="2" class="w-full border rounded p-2"></textarea>
              <div class="text-gray-500">Silakan isi deskripsi status untuk memberikan informasi tambahan kepada
                tamu.</div>
            </div>
            <div class="flex justify-end gap-2">
              <button type="button" class="bg-gray-200 px-4 py-2 rounded"
                data-modal-hide="modal-terima-{{ $item->id_buku_tamu }}">Kembali</button>
              <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded">Terima Tamu</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Selesai Tamu -->
  <div id="modal-selesai-{{ $item->id_buku_tamu }}" data-modal-target="modal-selesai-{{ $item->id_buku_tamu }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
      <div class="relative bg-white rounded-lg shadow">
        <div class="flex items-center justify-between p-4 border-b rounded-t">
          <h3 class="text-xl font-semibold text-gray-900">
            Konfirmasi Selesaikan Tamu
          </h3>
          <button type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
            data-modal-hide="modal-selesai-{{ $item->id_buku_tamu }}">
            <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <form id="form-selesai" class="p-4">
          <input type="hidden" name="id_buku_tamu" id="selesai-id">
          <div class="space-y-4">
            <div class="text-base leading-relaxed text-gray-500">
              Apakah Anda ingin menyelesaikan antrean <b id="selesai-nomor"></b>?
            </div>
            <div class="flex justify-end gap-2">
              <button type="button" class="bg-gray-200 px-4 py-2 rounded"
                data-modal-hide="modal-selesai-{{ $item->id_buku_tamu }}">Kembali</button>
              <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded">Tandai Sebagai Selesai</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Error -->
  <div id="modal-error-{{ $item->id_buku_tamu }}" data-modal-target="modal-error-{{ $item->id_buku_tamu }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
      <div class="relative bg-white rounded-lg shadow">
        <div class="flex items-center justify-between p-4 border-b rounded-t">
          <h3 class="text-xl font-semibold text-red-600">
            Tidak Bisa Menerima Tamu
          </h3>
          <button type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
            data-modal-hide="modal-error-{{ $item->id_buku_tamu }}">
            <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <div class="p-4">
          <div class="text-base leading-relaxed text-gray-500" id="error-message">
            Selesaikan tamu dengan nomor antrean {{ $tamu_diterima->nomor_urut ?? '-' }} terlebih dahulu jika ingin menerima tamu baru.
          </div>
          <div class="flex justify-end mt-4">
            <button type="button" class="bg-gray-200 px-4 py-2 rounded" data-modal-hide="modal-error-{{ $item->id_buku_tamu }}">Kembali</button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('document.end')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#buku-tamu-table').DataTable();

      // Filter Hari
      document.getElementById('filter-hari').addEventListener('change', function() {
        const val = this.value;
        const url = new URL(window.location.href);
        url.searchParams.set('filter_hari', val);
        window.location.href = url.toString();
      });

      // Modal logic
      function ensureModalInstance(modalEl) {
        if (window.Modal && modalEl && !modalEl.__flowbiteModal) {
          modalEl.__flowbiteModal = new window.Modal(modalEl);
        }
      }
      ensureModalInstance(modalTerima);
      ensureModalInstance(modalSelesai);
      ensureModalInstance(modalError);

      // Tambahan: Cek status diterima sebelum buka modal terima
      document.querySelectorAll('.btn-terima').forEach(btn => {
        btn.addEventListener('click', function() {
          const sudahDiterima = "{{ $tamu_diterima ? '1' : '' }}";
          const nomorDiterima = "{{ $tamu_diterima ? $tamu_diterima->nomor_urut : '' }}";
          const id = this.dataset.id;
          const modalTerima = document.getElementById('modal-terima-' + id);
          const modalError = document.getElementById('modal-error-' + id);

          if (sudahDiterima && nomorDiterima) {
            if (modalError) {
              ensureModalInstance(modalError);
              modalError.querySelector('#error-message').innerHTML =
                'Selesaikan tamu dengan nomor antrean <b>' + nomorDiterima + '</b> terlebih dahulu jika ingin menerima tamu baru.';
              modalError.__flowbiteModal.show();
            }
            return;
          }
          document.getElementById('terima-id').value = this.dataset.id;
          document.getElementById('terima-nomor').innerText = this.dataset.nomor;
          document.getElementById('terima-deskripsi').value = '';
          if (modalTerima) {
            ensureModalInstance(modalTerima);
            modalTerima.__flowbiteModal.show();
          }
        });
      });

      // Selesai Tamu
      document.querySelectorAll('.btn-selesai').forEach(btn => {
        btn.addEventListener('click', function() {
          const id = this.dataset.id;
          const modalSelesai = document.getElementById('modal-selesai-' + id);
          document.getElementById('selesai-id').value = this.dataset.id;
          document.getElementById('selesai-nomor').innerText = this.dataset.nomor;
          if (modalSelesai) {
            ensureModalInstance(modalSelesai);
            modalSelesai.__flowbiteModal.show();
          }
        });
      });

      // Submit Terima Tamu
      document.getElementById('form-terima').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('terima-id').value;
        const deskripsi = document.getElementById('terima-deskripsi').value;
        fetch("{{ route('admin.buku-tamu.update', [$susunan->slug_susunan_organisasi, '']) }}/" + id, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              aksi: 'terima',
              deskripsi_status: deskripsi
            })
          })
          .then(res => res.json())
          .then(res => {
            if (res.success) {
              window.location.reload();
            } else {
              ensureModalInstance(modalError);
              document.getElementById('error-message').innerText = res.message || 'Gagal menerima tamu.';
              modalError.__flowbiteModal.show();
            }
          });
      });

      // Submit Selesai Tamu
      document.getElementById('form-selesai').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('selesai-id').value;
        fetch("{{ route('admin.buku-tamu.update', [$susunan->slug_susunan_organisasi, '']) }}/" + id, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              aksi: 'selesai'
            })
          })
          .then(res => res.json())
          .then(res => {
            if (res.success) {
              window.location.reload();
            } else {
              alert(res.message || 'Gagal menyelesaikan tamu.');
            }
          });
      });

      // Modal close (Flowbite)
      document.querySelectorAll('[data-modal-hide]').forEach(btn => {
        btn.addEventListener('click', function() {
          const modalId = btn.getAttribute('data-modal-hide');
          const modalEl = document.getElementById(modalId);
          ensureModalInstance(modalEl);
          if (window.Modal && modalEl && modalEl.__flowbiteModal) {
            modalEl.__flowbiteModal.hide();
          }
        });
      });

      // Tambahan: Modal toggle universal untuk semua modal (Flowbite best practice)
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
