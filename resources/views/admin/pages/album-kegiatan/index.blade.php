@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/lightbox.css', 'resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@section('document.body')
  <a href="{{ route('admin.album-kegiatan.create') }}"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
    <i class="fa-solid fa-plus me-1"></i>Tambah Album Kegiatan
  </a>

  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5 bg-white">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="album-kegiatan-table" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>Cover</th>
            <th>Judul Album</th>
            <th>Jumlah</th>
            <th>Dilihat</th>
            <th>Dibuat Pada</th>
            <th>Diubah Pada</th>
            <th>Kelola</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($album_kegiatan as $item)
            @php
              $cover = $item->fotoKegiatan->first();
            @endphp
            <tr>
              <td>
                <a href="{{ Storage::url($cover->foto) }}" data-lightbox="album-cover-{{ $item->id }}"
                  data-title="{{ $item->judul }}">
                  <img src="{{ Storage::url($cover->foto) }}" alt="Cover {{ $item->judul }}"
                    class="w-full h-auto object-cover">
                </a>
              </td>

              <td>{{ $item->judul }}</td>

              <td>{{ $item->fotoKegiatan->count() }} foto</td>

              <td>{{ $item->views_count ?? 0 }} kali</td>

              <td>{{ $item->created_at ? $item->created_at->translatedFormat('l, d F Y (H:i)') : '-' }}</td>

              <td>{{ $item->updated_at ? $item->updated_at->translatedFormat('l, d F Y (H:i)') : '-' }}</td>

              <td>
                <div class="flex gap-2">
                  <a href="{{ route('admin.album-kegiatan.show', $item->id) }}"
                    class="flex justify-center items-center gap-1.5 h-10 font-medium text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm p-2.5 focus:outline-none"
                    title="Kelola Foto">
                    <i class="fa-solid fa-eye"></i>
                    <span class="font-medium whitespace-nowrap text-sm">Lihat isi album</span>
                  </a>

                  <a href="{{ route('admin.album-kegiatan.edit', $item->id) }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none"
                    title="Edit Album">
                    <i class="fa-solid fa-pencil"></i>
                  </a>

                  <button data-modal-target="deleteModal-{{ $item->id }}"
                    data-modal-toggle="deleteModal-{{ $item->id }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm p-2.5 focus:outline-none"
                    title="Hapus Album">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </div>
              </td>
            </tr>

            <x-admin.modal-hapus :id="$item->id" :aksi="route('admin.album-kegiatan.destroy', $item->id)">
              <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                Apakah Anda yakin ingin menghapus album kegiatan <strong>{{ $item->judul }}</strong>?
              </p>
            </x-admin.modal-hapus>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th class="w-[120px]">Cover</th>
            <th>Judul Album</th>
            <th class="w-[100px]">Jumlah</th>
            <th class="w-[80px]">Dilihat</th>
            <th class="w-[150px]">Created At</th>
            <th class="w-[150px]">Updated At</th>
            <th class="w-[250px]">Kelola</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
@endsection

@section('document.end')
  @vite(['resources/js/lightbox.js'])
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#album-kegiatan-table').DataTable({
        "columnDefs": [{
          "targets": [0, 6],
          "orderable": false
        }]
      });
    });
  </script>
@endsection
