@extends('admin.layouts.slider')

@section('css')
  {{-- DataTables --}}
  <link href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css" rel="stylesheet" />

  {{-- Lightbox2 --}}
  <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet" />
@endsection

@section('slot')
@if (session('success')) 
  <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 border border-green-300" role="alert">
    {{ session('success') }}
  </div>
@endif

@if (session('error'))
  <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 border border-red-300" role="alert">
    {{ session('error') }}
  </div>
@endif
  <a href="{{ route('admin.slider.create') }}"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
    <i class="fa-solid fa-plus me-1"></i>Tambah Slider
  </a>

  {{-- Daftar Slider --}}
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="slider" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>Urutan</th>
            <th>Foto</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Kelola</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($slider as $item)
            <tr>
              <td>
                <div class="flex items-center justify-center gap-x-3">
                  <div>{{ $item->nomor_urut_slider }}</div>
                  <div class="inline-flex flex-col">
                    @if ($item->nomor_urut_slider > 1)
                      <button data-id="{{ $item->id_slider }}" class="slider-up">
                        <i class="fa-solid fa-circle-chevron-up text-xl"></i>
                      </button>
                    @endif
                    @if ($item->nomor_urut_slider < count($slider))
                      <button data-id="{{ $item->id_slider }}" class="slider-down">
                        <i class="fa-solid fa-circle-chevron-down text-xl"></i>
                      </button>
                    @endif
                  </div>
                </div>
              </td>

              <td>
                <a href="{{ Storage::url($item->foto_slider) }}" data-lightbox="slider"
                  data-title="{{ $item->judul_slider }}">
                  <img src="{{ Storage::url($item->foto_slider) }}" width="192px" alt="{{ $item->judul_slider }}">
                </a>
              </td>
              <td>
                {{ $item->judul_slider }}
              </td>
              <td>
                @if ($item->is_visible)
                  <span
                    class="bg-green-100 text-green-800 text-xs me-2 px-1.5 py-0.5 rounded border border-green-400">Ditampilkan</span>
                @else
                  <span
                    class="bg-red-100 text-red-800 text-xs me-2 px-1.5 py-0.5 rounded border border-red-400">Disembunyikan</span>
                @endif
              </td>
              <td>
                <div class="flex gap-2">
                  <a href="{{ route('admin.slider.edit', $item->id_slider) }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  <button data-modal-target="static-modal-{{ $item->id_slider }}"
                    data-modal-toggle="static-modal-{{ $item->id_slider }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </div>
              </td>
            </tr>

            {{-- Modal Konfirmasi haous --}}
            <div id="static-modal-{{ $item->id_slider }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
              class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
              <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                  <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Konfirmasi Penghapusan
                    </h3>
                    <button type="button"
                      class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                      data-modal-hide="static-modal-{{ $item->id_slider }}">
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
                      Apakah Anda yakin ingin menghapus slider <strong>{{ $item->judul_slider }}</strong>?
                    </p>
                    <div>
                      <img src="{{ asset('storage/' . $item->foto_slider) }}" alt="Foto Slider" class="w-72">
                    </div>
                  </div>
                  <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <form action="{{ route('admin.slider.destroy', $item->id_slider) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                        class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Hapus</button>
                    </form>
                    <button type="button"
                      class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                      data-modal-hide="static-modal-{{ $item->id_slider }}">
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
            <th>Urutan</th>
            <th>Foto</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Kelola</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
@endsection

@section('js')
  {{-- Lightbox2 --}}
  <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>

  {{-- DataTables --}}
  <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#slider').DataTable({
        responsive: true
      });
    });
  </script>

  {{-- Ubah nomor urutan slider --}}
  <script>
    $(document).ready(function() {
      $('.slider-up').click(function(e) {
        e.preventDefault();

        const id = $(this).data('id');
        const button = $(this);

        button.prop('disabled', true);

        $.ajax({
          url: '/e-panel/slider/' + id + '/move-up',
          method: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            id: id
          },
          success: function(response) {
            if (response.success) {
              location.reload();
            }
          },
          error: function() {
            alert("An error occurred. Please try again.");
          },
          complete: function() {
            button.prop('disabled', false);
          }
        });
      });

      $('.slider-down').click(function(e) {
        e.preventDefault();

        const id = $(this).data('id');
        const button = $(this);

        button.prop('disabled', true);

        $.ajax({
          url: '/e-panel/slider/' + id + '/move-down',
          method: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            id: id
          },
          success: function(response) {
            if (response.success) {
              location.reload();
            }
          },
          error: function() {
            alert("An error occurred. Please try again.");
          },
          complete: function() {
            button.prop('disabled', false);
          }
        });
      });
    });
  </script>
@endsection
