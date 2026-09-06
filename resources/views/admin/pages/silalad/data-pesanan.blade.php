@extends('admin.layout')

@section('title', $page_title)

@section('document.head')
  @vite(['resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@section('document.body')
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="flex justify-end mb-4">
      <a href="{{ route('admin.silalad.create') }}"
        class="inline-flex items-center gap-2 h-10 px-4 text-white bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue focus:ring-4 focus:ring-blue-300 rounded-lg text-sm font-medium focus:outline-none transition">
        <i class="fa-solid fa-plus"></i>
        <span class="whitespace-nowrap">Buat Pesanan</span>
      </a>
    </div>

    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="pesananMasuk" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>No.</th>
            <th>Pelanggan</th>
            <th>Alamat</th>
            <th>No. Telepon</th>
            <th>Jenis Bangunan</th>
            <th>Status</th>
            <th>Kelola</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pesananPending as $index => $pesanan)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>
                <div class="font-medium text-gray-900">{{ $pesanan->nama_pelanggan }}</div>
                <div class="text-xs text-gray-500">{{ $pesanan->kode_booking ?? '-' }}</div>
              </td>
              <td>{{ $pesanan->alamat }}</td>
              <td>{{ $pesanan->nomor_telepon_pelanggan }}</td>
              <td>{{ $pesanan->jenis_bangunan }}</td>
              <td>
                <span class="inline-flex items-center whitespace-nowrap px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                  {{ $pesanan->status_pengerjaan }}
                </span>
              </td>
              <td>
                <div class="flex gap-1.5">
                  <a href="{{ route('admin.silalad.show', $pesanan) }}"
                    class="flex justify-center items-center w-9 h-9 text-white bg-blue-700 hover:bg-blue-800 rounded-lg text-sm">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  <a href="{{ route('admin.silalad.print', $pesanan) }}"
                    class="flex justify-center items-center w-9 h-9 text-white bg-gray-600 hover:bg-gray-700 rounded-lg text-sm">
                    <i class="fa-solid fa-print"></i>
                  </a>
                </div>
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
      $('#pesananMasuk').DataTable({
        order: [[0, 'asc']],
        columnDefs: [{
          orderable: false,
          targets: [6]
        }]
      });
    });
  </script>
@endsection
