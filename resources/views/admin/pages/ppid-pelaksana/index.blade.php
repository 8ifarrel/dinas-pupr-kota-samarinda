@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@section('document.body')
  <a href="{{ route('admin.ppid-pelaksana.create', ['kategori' => request()->query('kategori')]) }}"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
    <i class="fa-solid fa-plus me-1"></i>Tambah PPID Pelaksana
  </a>

  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="ppid-pelaksana" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Judul</th>
            <th>File</th>
            <th>Download Count</th>
            <th>Dibuat Pada</th>
            <th>Kelola</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($ppid_pelaksana as $item)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $item->judul }}</td>
              <td>
                <a href="{{ Storage::url($item->file) }}" target="_blank"
                  class="inline-flex justify-center items-center gap-1 h-8 font-medium text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm p-2.5 focus:outline-none">
                  <i class="fa-solid fa-eye"></i> <span
                    class="font-medium whitespace-nowrap text-xs sm:text-sm">Lihat</span>
                </a>
              </td>
              <td>{{ $item->download_count }}</td>
              <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
              <td>
                <div class="flex gap-2">
                  <a href="{{ route('admin.ppid-pelaksana.edit', $item->id) }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  <button data-modal-target="deleteModal-{{ $item->id }}"
                    data-modal-toggle="deleteModal-{{ $item->id }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </div>
              </td>
            </tr>

            <!-- Modal Konfirmasi Hapus -->
            <x-admin.modal-hapus :id="$item->id" :aksi="route('admin.ppid-pelaksana.destroy', $item->id)">
              <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                Apakah Anda yakin ingin menghapus PPID Pelaksana <strong>{{ $item->judul }}</strong>?
              </p>
            </x-admin.modal-hapus>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>#</th>
            <th>Judul</th>
            <th>File</th>
            <th>Download Count</th>
            <th>Dibuat Pada</th>
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
      $('#ppid-pelaksana').DataTable();
    });
  </script>
@endsection
