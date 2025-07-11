@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/lightbox.css', 'resources/css/datatables.css'])
@endsection

@section('document.body')
  <a href="{{ route('admin.album-kegiatan.foto-kegiatan.create', $album->id) }}"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 mb-4 inline-block">
    <i class="fa-solid fa-plus me-1"></i>Tambah Foto Kegiatan
  </a>
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5 bg-white">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="foto-kegiatan-table" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>Foto</th>
            <th>Deskripsi Singkat</th>
            <th>Dibuat Pada</th>
            <th>Diubah Pada</th>
            <th>Kelola</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($album->fotoKegiatan as $foto)
            <tr>
              <td>
                <a href="{{ Storage::url($foto->foto) }}" data-lightbox="album-foto-{{ $album->id }}"
                  data-title="{{ $foto->caption }}">
                  <img src="{{ Storage::url($foto->foto) }}" alt="Foto Kegiatan" class="w-[200px] h-auto object-cover" />
                </a>
              </td>
              <td>
                @if ($foto->caption)
                  <button type="button"
                    class="inline-flex justify-center items-center gap-1 h-8 font-medium text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm p-2.5 focus:outline-none"
                    data-modal-target="captionModal-{{ $foto->id }}"
                    data-modal-toggle="captionModal-{{ $foto->id }}">
                    <i class="fa-solid fa-eye"></i>
                    <span class="font-medium whitespace-nowrap text-xs sm:text-sm">Lihat</span>
                  </button>
                  <!-- Modal Caption -->
                  <div id="captionModal-{{ $foto->id }}" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
                    data-modal-target="captionModal-{{ $foto->id }}">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Deskripsi Foto
                          </h3>
                          <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="captionModal-{{ $foto->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                              viewBox="0 0 14 14">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                          </button>
                        </div>
                        <div class="p-4 md:p-5 space-y-4">
                          <div>
                            {!! nl2br(e($foto->caption)) !!}
                          </div>
                        </div>
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                          <button type="button"
                            class="bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-400 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                            data-modal-hide="captionModal-{{ $foto->id }}">Tutup</button>
                        </div>
                      </div>
                    </div>
                  </div>
                @else
                  <span
                    class="bg-gray-100 text-gray-800 text-xs font-bold me-2 px-1 py-0.5 rounded border border-gray-500">
                    Tidak ada
                  </span>
                @endif
              </td>
              <td>{{ $foto->created_at ? $foto->created_at->translatedFormat('l, d F Y (H:i)') : '-' }}</td>
              <td>{{ $foto->updated_at ? $foto->updated_at->translatedFormat('l, d F Y (H:i)') : '-' }}</td>
              <td>
                <div class="flex gap-2">
                  <a href="{{ route('admin.album-kegiatan.foto-kegiatan.edit', [$album->id, $foto->id]) }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 rounded-lg text-sm p-2.5"
                    title="Edit">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  <button type="button"
                    class="flex justify-center items-center w-10 h-10 text-white bg-red-700 rounded-lg text-sm p-2.5"
                    title="Hapus"
                    data-modal-target="deleteFotoModal-{{ $foto->id }}"
                    data-modal-toggle="deleteFotoModal-{{ $foto->id }}">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </div>
                <!-- Modal Hapus -->
                <div id="deleteFotoModal-{{ $foto->id }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                  class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                  <div class="relative p-4 max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                      <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                          Konfirmasi Hapus Foto
                        </h3>
                        <button type="button"
                          class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                          data-modal-hide="deleteFotoModal-{{ $foto->id }}">
                          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                          </svg>
                          <span class="sr-only">Close modal</span>
                        </button>
                      </div>
                      <div class="p-4 md:p-5">
                        <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                          Apakah Anda yakin ingin menghapus foto ini?
                        </p>
                      </div>
                      <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <form action="{{ route('admin.album-kegiatan.foto-kegiatan.destroy', [$album->id, $foto->id]) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Hapus
                          </button>
                        </form>
                        <button type="button"
                          class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100"
                          data-modal-hide="deleteFotoModal-{{ $foto->id }}">
                          Batal
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
            <th>Foto</th>
            <th>Deskripsi Singkat</th>
            <th>Dibuat Pada</th>
            <th>Diubah Pada</th>
            <th>Kelola</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
@endsection

@section('document.end')
  @vite(['resources/js/lightbox.js', 'resources/js/datatables.js'])
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#foto-kegiatan-table').DataTable({
        responsive: true,
        "columnDefs": [{
          "orderable": false,
          "targets": [0, 4]
        }]
      });
    });
  </script>
@endsection
