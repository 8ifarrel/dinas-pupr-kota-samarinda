@extends('admin.layouts.partner')

@section('css')
  {{-- DataTables --}}
  <link href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css" rel="stylesheet" />
@endsection

@section('slot')
  <a href="{{ route('admin.partner.create') }}"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
    <i class="fa-solid fa-plus me-1"></i>Tambah Partner
  </a>

  {{-- Daftar Partner --}}
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="partner" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>Foto</th>
            <th>Nama</th>
            <th>URL</th>
            <th>Kelola</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($partners as $partner)
            <tr>
              <td>
                <img src="{{ Storage::url($partner->foto_partner) }}" width="192px" alt="{{ $partner->nama_partner }}">
              </td>
              <td>{{ $partner->nama_partner }}</td>
              <td>
                <a href="{{ $partner->url_partner }}" class="text-blue-500 underline">
                  {{ $partner->url_partner }}
                </a>
              </td>
              <td>
                <div class="flex gap-2">
                  <a href="{{ route('admin.partner.edit', $partner->id_partner) }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  <form action="{{ route('admin.partner.destroy', $partner->id_partner) }}" method="POST">
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
            <th>Foto</th>
            <th>Nama</th>
            <th>URL</th>
            <th>Kelola</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
@endsection

@section('js')
  {{-- DataTables --}}
  <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#partner').DataTable({
        responsive: true
      });
    });
  </script>
@endsection
