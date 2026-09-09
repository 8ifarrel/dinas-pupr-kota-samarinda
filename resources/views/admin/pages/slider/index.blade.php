@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/lightbox.css', 'resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@section('document.body')
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
                  <button data-modal-target="deleteModal-{{ $item->id_slider }}"
                    data-modal-toggle="deleteModal-{{ $item->id_slider }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </div>
              </td>
            </tr>

            {{-- Modal Konfirmasi Hapus --}}
            <x-admin.modal-hapus :id="$item->id_slider" :aksi="route('admin.slider.destroy', $item->id_slider)">
              <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                Apakah Anda yakin ingin menghapus slider <strong>{{ $item->judul_slider }}</strong>?
              </p>
              <div>
                <img src="{{ asset('storage/' . $item->foto_slider) }}" alt="Foto Slider" class="w-72">
              </div>
            </x-admin.modal-hapus>
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

@section('document.end')
  @vite('resources/js/lightbox.js')

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#slider').DataTable();

      // Tombol "Slider Up"
      $('.slider-up').on('click', function(e) {
        e.preventDefault();

        const id = $(this).data('id');
        const button = $(this);
        button.prop('disabled', true);

        $.ajax({
          url: `/e-panel/slider/${id}/move-up`,
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

      // Tombol "Slider Down"
      $('.slider-down').on('click', function(e) {
        e.preventDefault();

        const id = $(this).data('id');
        const button = $(this);
        button.prop('disabled', true);

        $.ajax({
          url: `/e-panel/slider/${id}/move-down`,
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
