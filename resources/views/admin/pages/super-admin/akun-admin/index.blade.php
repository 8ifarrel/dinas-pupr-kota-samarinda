@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@section('document.body')
  <a href="{{ route('admin.super.akun-admin.create') }}"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
    <i class="fa-solid fa-plus me-1"></i>Tambah Akun Admin
  </a>

  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="akun-admin" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama Lengkap</th>
            <th>Username</th>
            <th>Susunan Organisasi</th>
            <th>Dibuat Pada</th>
            <th>Diubah Pada</th>
            <th>Kelola</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $item)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $item->fullname }}</td>
              <td>{{ $item->name }}</td>
              <td>{{ $item->susunanOrganisasi->nama_susunan_organisasi }}</td>
              <td>{{ $item->created_at->format('d M Y H:i:s') }}</td>
              <td>{{ $item->updated_at->format('d M Y H:is') }}</td>
              <td>
                <div class="flex gap-2">
                  <a href="{{ route('admin.super.akun-admin.edit', $item->id) }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  @if ($item->id_susunan_organisasi != 1)
                    <button data-modal-target="deleteModal-{{ $item->id }}"
                      data-modal-toggle="deleteModal-{{ $item->id }}"
                      class="flex justify-center items-center w-10 h-10 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm p-2.5 focus:outline-none">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  @endif

                </div>
              </td>
            </tr>

            <!-- Modal Konfirmasi Hapus -->
            <x-admin.modal-hapus :id="$item->id" :aksi="route('admin.super.akun-admin.destroy', $item->id)">
              <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                Apakah Anda yakin ingin menghapus Akun Admin <strong>{{ $item->fullname }}</strong> dengan username
                <strong>{{ $item->name }}</strong>?
              </p>
            </x-admin.modal-hapus>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>#</th>
            <th>Nama Lengkap</th>
            <th>Username</th>
            <th>Susunan Organisasi</th>
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
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#akun-admin').DataTable();
    });
  </script>
@endsection
