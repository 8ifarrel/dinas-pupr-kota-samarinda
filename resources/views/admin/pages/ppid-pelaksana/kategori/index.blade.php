@extends('admin.layouts.ppid-pelaksana')

@section('css')
  {{-- DataTables --}}
  <link href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css" rel="stylesheet" />

  {{-- Lightbox2 --}}
  <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet" />
@endsection

@section('slot')
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="kategori" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Jumlah</th>
            <th>Kelola</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($kategori as $item)
            <tr>
              <td>{{ $item->nama }}</td>
              <td>{{ $item->ppid_pelaksana->count() }}</td>
              <td>
                <div class="flex gap-2">
                  <a href="{{ route('admin.ppid-pelaksana-kategori.edit', $item->id) }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>

        <tfoot>
          <tr>
            <th>Nama</th>
            <th>Jumlah</th>
            <th>Kelola</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
@endsection

@section('js')
  {{-- Lightbox2 --}}
  <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>

  {{-- DataTables --}}
  <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#kategori').DataTable({
        responsive: true
      });
    });
  </script>
@endsection