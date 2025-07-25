@extends('guest.layouts.main')

@section('document.start')
  @vite(['resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@section('document.body')
  <div class="py-5 md:py-12 px-6 lg:px-24 3xl:px-48">
    @include('guest.components.section-title')

    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="pengumuman" class="border shadow border-separate rounded-3xl stripe hover row-border table-auto"
        style="width:100%;">
        <thead>
          <tr>
            <th class="bg-brand-yellow/35 border-none rounded-tl-3xl">#</th>
            <th class="bg-brand-yellow/35 min-w-44">Judul</th>
            <th class="bg-brand-yellow/35 min-w-36">Telah Dilihat</th>
            <th class="bg-brand-yellow/35 min-w-48">Waktu Terbit</th>
            <th class="bg-brand-yellow/35 min-w-48">Terakhir Diperbarui</th>
            <th class="bg-brand-yellow/35 border-none">Deskripsi</th>
            <th class="bg-brand-yellow/35 border-none rounded-tr-3xl">Lampiran</th>
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

              {{-- Telah Dilihat --}}
              <td>
                {{ $item->views_count ?? 0 }} kali
              </td>

              {{-- Waktu Terbit --}}
              <td>
                {{ $item->created_at ? $item->created_at->format('d M Y H:i') : '-' }}
              </td>

              {{-- Terakhir Diperbarui --}}
              <td>
                {{ $item->updated_at ? $item->updated_at->format('d M Y H:i') : '-' }}
              </td>

              {{-- Deskripsi --}}
              <td>
                <button data-modal-target="static-modal-{{ $loop->index }}"
                  data-modal-toggle="static-modal-{{ $loop->index }}"
                  class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 bg-brand-blue font-semibold rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                  type="button" onclick="incrementPengumumanView('{{ $item->slug_pengumuman }}')">
                  <i class="fa-solid fa-eye me-1.5"></i>Lihat
                </button>
              </td>

              {{-- Lampiran --}}
              <td>
                @if ($item->file_lampiran)
                  <a href="{{ route('guest.pengumuman.download', ['slug' => $item->slug_pengumuman]) }}"
                    class="text-white bg-brand-blue text-nowrap hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    target="_blank" rel="noopener" onclick="incrementPengumumanView('{{ $item->slug_pengumuman }}')">
                    <i class="fa-solid fa-download me-1.5"></i>Unduh
                  </a>
                @else
                  <span
                    class="bg-gray-100 text-gray-800 text-xs font-bold me-2 px-1 py-0.5 rounded border border-gray-500">
                    Tidak ada
                  </span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>#</th>
            <th>Judul</th>
            <th>Telah Dilihat</th>
            <th>Waktu Terbit</th>
            <th>Terakhir Diperbarui</th>
            <th>Deskripsi</th>
            <th>Lampiran</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  @foreach ($pengumuman as $item)
    <!-- Main modal -->
    <div id="static-modal-{{ $loop->index }}" data-modal-target="static-modal-{{ $loop->index }}"
      data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <!-- Modal header -->
          <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
              {{ $item->judul_pengumuman }}
            </h3>
            <button type="button"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
              data-modal-hide="static-modal-{{ $loop->index }}">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
              <span class="sr-only">Close modal</span>
            </button>
          </div>
          <!-- Modal body -->
          <div class="p-4 md:p-5">
            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
              {!! $item->perihal !!}
            </p>
          </div>
        </div>
      </div>
    </div>
  @endforeach
@endsection
<script>
  function incrementPengumumanView(slug) {
    fetch('/pengumuman/store/' + slug, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
      }
    });
  }
</script>

@section('document.end')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#pengumuman').DataTable();

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
