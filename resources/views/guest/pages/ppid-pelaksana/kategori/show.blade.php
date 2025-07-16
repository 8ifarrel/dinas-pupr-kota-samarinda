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
            <th class="bg-brand-yellow/35">Nama</th>
            <th class="bg-brand-yellow/35">Waktu Terbit</th>
            <th class="bg-brand-yellow/35">Telah Diunduh</th>
            <th class="bg-brand-yellow/35 border-none rounded-tr-3xl">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($ppid_pelaksana_kategori->ppid_pelaksana as $item)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $item->judul }}</td>
              <td>{{ $item->created_at ? $item->created_at->format('d M Y H:i') : '-' }}</td>
              <td>{{ $item->download_count ?? 0 }} kali</td>
              <td>
                @if ($item->file)
                  <button
                    onclick="window.open('{{ route('guest.ppid-pelaksana.download', ['id' => $item->id]) }}', '_blank'); setTimeout(function(){ location.reload(); }, 1000);"
                    class="block text-white text-nowrap bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 bg-brand-blue font-semibold rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fa-solid fa-download me-1.5"></i>Unduh
                  </button>
                @else
                  <span class="text-gray-400">Tidak ada file</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-4">Belum ada dokumen pada kategori ini.</td>
            </tr>
          @endforelse
        </tbody>
        <tfoot>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Waktu Terbit</th>
            <th>Telah Diunduh</th>
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
