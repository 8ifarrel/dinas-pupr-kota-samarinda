@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@section('document.body')
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto">
      <table id="buku-tamu-jabatan" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>Susunan Organisasi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($jabatan as $index => $item)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $item->nama_susunan_organisasi }}</td>
              <td>
                <a href="{{ route('admin.buku-tamu.show', $item->slug_susunan_organisasi) }}"
                  class="inline-flex items-center gap-1 h-8 font-medium text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-3 py-2.5 focus:outline-none">
                  <i class="fa-solid fa-users"></i> <span>Lihat Tamu</span>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection

@section('document.end')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#buku-tamu-jabatan').DataTable();
    });
  </script>
@endsection
