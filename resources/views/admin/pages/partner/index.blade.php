@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/lightbox.css', 'resources/css/datatables.css'])
@endsection

@section('document.body')
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
                <a href="{{ Storage::url($partner->foto_partner) }}" data-lightbox="partner"
                  data-title="{{ $partner->nama_partner }}">
                  <img src="{{ Storage::url($partner->foto_partner) }}" width="192px" alt="{{ $partner->nama_partner }}">
                </a>
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
                  <button data-modal-target="deleteModal-{{ $partner->id_partner }}"
                    data-modal-toggle="deleteModal-{{ $partner->id_partner }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </div>
              </td>
            </tr>

            <!-- Modal Konfirmasi Hapus -->
            <x-admin.modal-hapus :id="$partner->id_partner" :aksi="route('admin.partner.destroy', $partner->id_partner)">
              <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                Apakah Anda yakin ingin menghapus partner <strong>{{ $partner->nama_partner }}</strong>?
              </p>
              <div>
                <img src="{{ Storage::url($partner->foto_partner) }}" alt="Foto Partner" class="w-72">
              </div>
            </x-admin.modal-hapus>
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

@section('document.end')
  @vite(['resources/js/lightbox.js', 'resources/js/datatables.js'])

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#partner').DataTable();
    });
  </script>
@endsection
