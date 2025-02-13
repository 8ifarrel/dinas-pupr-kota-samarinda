@extends('admin.layouts.pegawai')

@section('css')
  {{-- Lightbox2 --}}
  <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet" />
  {{-- DataTables --}}
  <link href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css" rel="stylesheet" />
@endsection

@section('slot')   
  <div class="inline-flex gap-2 flex-wrap">
    <a href="{{ route('admin.pegawai.create', ['jabatan' => request()->get('jabatan')]) }}"
      class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
      <i class="fa-solid fa-plus me-1"></i>Tambah Pegawai
    </a>
  </div>

  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="pegawai" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>Foto</th>
            <th>Nama</th>
            <th>Posisi</th>
            <th>NIK</th>
            <th>No. HP</th>
            <th>Golongan</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pegawai as $item)
            <tr>
              <td>
                @if ($item->foto_pegawai)
                  <a href="{{ Storage::url($item->foto_pegawai) }}" data-lightbox="pegawai" data-title="{{ $item->nama_pegawai }}">
                    <img src="{{ Storage::url($item->foto_pegawai) }}" alt="{{ $item->nama_pegawai }}" class="mx-auto w-12 h-12 rounded-full">
                  </a>
                @else
                  <a href="{{ asset('image/profile/default.png') }}" data-lightbox="pegawai" data-title="{{ $item->nama_pegawai }}">
                    <img src="{{ asset('image/profile/default.png') }}" alt="{{ $item->nama_pegawai }}" class="mx-auto w-12 h-12 rounded-full">
                  </a>
                @endif
              </td>
              <td>{{ $item->nama_pegawai }}</td>
              <td>
                @if ($item->posisi == 'Sekretaris')
                  {{ $item->posisi }}
                @else
                  {{ $item->posisi }} {{ $item->jabatan->nama_jabatan }}
                @endif
              </td>
              <td>
                @if ($item->nomor_induk_pegawai)
                  {{ $item->nomor_induk_pegawai }}
                @else
                  <span class="bg-gray-100 text-gray-800 text-xs font-bold me-2 px-1 py-0.5 rounded border border-gray-500">
                    Belum diisi
                  </span>
                @endif
              </td>
              <td>{{ $item->nomor_telepon_pegawai }}</td>
              <td>{{ $item->golongan_pegawai }}</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>Foto</th>
            <th>Nama</th>
            <th>Posisi</th>
            <th>NIK</th>
            <th>No. HP</th>
            <th>Golongan</th>
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
      $('#pegawai').DataTable({
        responsive: true
      });
    });
  </script>
@endsection