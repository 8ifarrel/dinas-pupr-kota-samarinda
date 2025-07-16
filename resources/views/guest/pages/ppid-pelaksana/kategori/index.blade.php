@extends('guest.layouts.main')

@section('document.start')
  @vite(['resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@section('document.body')
  <div class="py-5 md:py-12 px-6 lg:px-24 3xl:px-48">
    @include('guest.components.section-title')

    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="ppid-pelaksana"
        class="border shadow border-separate rounded-3xl stripe hover row-border table-auto w-full">
        <thead>
          <tr>
            <th class="bg-brand-yellow/35 border-none rounded-tl-3xl">#</th>
            <th class="bg-brand-yellow/35">Nama Kategori</th>
            <th class="bg-brand-yellow/35">Jumlah</th>
            <th class="bg-brand-yellow/35 min-w-56">Terakhir Diperbarui</th>
            <th class="bg-brand-yellow/35 border-none rounded-tr-3xl">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($ppid_pelaksana_kategori as $item)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $item->nama }}</td>
              <td>{{ $item->ppid_pelaksana_count }}</td>
              <td>{{ $item->updated_at ? $item->updated_at->format('d M Y H:i') : '-' }}</td>
              <td>
                <a href="{{ route('guest.ppid-pelaksana.kategori.show', ['slug' => $item->slug]) }}"
                  class="block text-white text-nowrap bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 bg-brand-blue font-semibold rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                  <i class="fa-solid fa-eye me-1.5"></i>Lihat Dokumen
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>#</th>
            <th>Nama Kategori</th>
            <th>Jumlah</th>
            <th>Terakhir Diperbarui</th>
            <th>Aksi</th>
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
