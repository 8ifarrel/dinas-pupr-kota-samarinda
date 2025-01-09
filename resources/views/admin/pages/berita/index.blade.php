@extends('admin.layouts.partner')

@section('css')
  {{-- DataTables --}}
  <link href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css" rel="stylesheet" />
  {{-- Lightbox2 --}}
  <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet" />
@endsection

{{-- 
TODO:
1. h1, ul, ol pada isi berita tidak terbaca karena tertimpa Tailwind CSS
--}}

@section('slot')
  <a href="{{ route('admin.berita.create', ['id_kategori' => request()->query('id_kategori')]) }}"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
    <i class="fa-solid fa-plus me-1"></i>Tambah Berita
  </a>

  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="berita" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Judul</th>
            <th>Foto</th>
            <th>Isi</th>
            <th>Views</th>
            <th>Dibuat Pada</th>
            <th>Kelola</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($berita as $item)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $item->judul_berita }}</td>
              <td>
                <a href="{{ Storage::url($item->foto_berita) }}" data-lightbox="berita"
                  data-title="{{ $item->judul_berita }} <br> Sumber foto: {{  $item->sumber_foto_berita }}">
                  <img src="{{ Storage::url($item->foto_berita) }}" alt="{{ $item->judul_berita }}" width="100">
                </a>
              </td>
              <td>
                <button type="button" class="flex justify-center items-center gap-1 h-8 font-medium text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm p-2.5 focus:outline-none" data-modal-target="contentModal-{{ $item->uuid_berita }}" data-modal-toggle="contentModal-{{ $item->uuid_berita }}">
                  <i class="fa-solid fa-eye"></i> <span class="font-medium whitespace-nowrap text-xs sm:text-sm">Lihat</span>
                </button>
              </td>
              <td>{{ $item->views_count }}</td>
              <td>{{ $item->formatted_created_at }}</td>
              <td>
                <div class="flex gap-2">
                  <a href="{{ route('admin.berita.edit', $item->uuid_berita) }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  <form action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                      class="flex justify-center items-center w-10 h-10 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm p-2.5 focus:outline-none">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>#</th>
            <th>Judul</th>
            <th>Foto</th>
            <th>Isi</th>
            <th>Views</th>
            <th>Dibuat Pada</th>
            <th>Kelola</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  @foreach ($berita as $item)
    <!-- Modal -->
    <div id="contentModal-{{ $item->uuid_berita }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full" data-modal-target="contentModal-{{ $item->uuid_berita }}">
      <div class="relative p-4 w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <!-- Modal header -->
          <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
              Isi Berita
            </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="contentModal-{{ $item->uuid_berita }}">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
              </svg>
              <span class="sr-only">Close modal</span>
            </button>
          </div>
          <!-- Modal body -->
          <div class="p-4 md:p-5 space-y-4">
            <div>
              {!! $item->isi_berita !!}
            </div>
          </div>
          <!-- Modal footer -->
          <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
            <button type="button" class="bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-400 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" data-modal-hide="contentModal-{{ $item->uuid_berita }}">Tutup</button>
          </div>
        </div>
      </div>
    </div>
  @endforeach
@endsection

@section('js')
  {{-- Lightbox2 --}}
  <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>
  {{-- DataTables --}}
  <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#berita').DataTable({
        responsive: true
      });
    });
  </script>
@endsection
