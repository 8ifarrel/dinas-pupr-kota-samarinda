@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@section('document.body')
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
    <a href="{{ route('admin.super.akun-kelurahan.create') }}"
      class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 inline-flex items-center w-fit">
      <i class="fa-solid fa-plus me-1"></i>Tambah Akun Kelurahan
    </a>

    <form method="GET" action="{{ route('admin.super.akun-kelurahan.index') }}" class="flex items-center gap-2">
      <label for="kecamatan_id" class="text-sm font-medium text-gray-700 whitespace-nowrap">Filter Kecamatan</label>
      <select name="kecamatan_id" id="kecamatan_id" onchange="this.form.submit()"
        class="text-sm border border-gray-300 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-200">
        <option value="">Semua Kecamatan</option>
        @foreach ($kecamatanList as $kec)
          <option value="{{ $kec->id }}" {{ (string) $kecamatanId === (string) $kec->id ? 'selected' : '' }}>
            {{ $kec->nama }}
          </option>
        @endforeach
      </select>
    </form>
  </div>

  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="akun-kelurahan" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Kelurahan</th>
            <th>Kecamatan</th>
            <th>Nama Lengkap</th>
            <th>Username</th>
            <th>Dibuat Pada</th>
            <th>Kelola</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($akun as $item)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ optional($item->kelurahan)->nama ?? '-' }}</td>
              <td>{{ optional(optional($item->kelurahan)->kecamatan)->nama ?? '-' }}</td>
              <td>{{ $item->fullname }}</td>
              <td>{{ $item->name }}</td>
              <td>{{ $item->created_at->format('d M Y H:i:s') }}</td>
              <td>
                <div class="flex gap-2">
                  <a href="{{ route('admin.super.akun-kelurahan.edit', $item->id) }}"
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
            <x-admin.modal-hapus :id="$item->id" :aksi="route('admin.super.akun-kelurahan.destroy', $item->id)">
              <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                Apakah Anda yakin ingin menghapus akun kelurahan
                <strong>{{ optional($item->kelurahan)->nama ?? '-' }}</strong> dengan username
                <strong>{{ $item->name }}</strong>?
              </p>
            </x-admin.modal-hapus>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>#</th>
            <th>Kelurahan</th>
            <th>Kecamatan</th>
            <th>Nama Lengkap</th>
            <th>Username</th>
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
      $('#akun-kelurahan').DataTable();
    });
  </script>
@endsection
