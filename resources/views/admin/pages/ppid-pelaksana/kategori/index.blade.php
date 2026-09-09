@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/lightbox.css', 'resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@section('document.body')
  <a href="{{ route('admin.ppid-pelaksana.kategori.create') }}"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
    <i class="fa-solid fa-plus me-1"></i>Tambah Kategori
  </a>

  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="kategori" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Jumlah</th>
            <th>Kelola</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($kategori as $item)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $item->nama }}</td>
              <td>{{ $item->ppid_pelaksana->count() }}</td>
              <td>
                <div class="flex gap-2">
                  <a href="{{ route('admin.ppid-pelaksana.kategori.edit', $item->id) }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  <a href="{{ route('admin.ppid-pelaksana.index', ['kategori' => $item->id]) }}"
                    class="flex justify-center items-center gap-1 h-10 font-medium text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-eye"></i> <span class="font-medium whitespace-nowrap text-sm sm:text-base">Lihat
                      Berkas</span>
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
            <x-admin.modal-hapus :id="$item->id" :aksi="route('admin.ppid-pelaksana.kategori.destroy', $item->id)">
              <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                Apakah Anda yakin ingin menghapus kategori <strong>{{ $item->nama }}</strong>?
              </p>
            </x-admin.modal-hapus>
          @endforeach
        </tbody>

        <tfoot>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Jumlah</th>
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
      $('#kategori').DataTable();
    });
  </script>
@endsection
