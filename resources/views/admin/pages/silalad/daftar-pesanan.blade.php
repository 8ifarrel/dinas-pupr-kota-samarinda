@extends('admin.layout')

@section('title', $page_title)

@section('document.head')
  @vite(['resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@section('document.body')
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    {{-- Filter --}}
    <div class="bg-gray-50 rounded-lg border p-4 mb-4">
      <form method="GET" action="{{ route('admin.silalad.data-pesanan') }}" class="flex flex-wrap items-end gap-3">
        @php
          $selCls = 'border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5';
          $bulanNama = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
          $statusList = ['Belum dikerjakan', 'Sedang dikerjakan', 'Sudah dikerjakan', 'Dibatalkan'];
        @endphp
        <div>
          <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
          <select name="status" id="status" class="{{ $selCls }}">
            <option value="">-- Semua Status --</option>
            @foreach ($statusList as $s)
              <option value="{{ $s }}" {{ $status == $s ? 'selected' : '' }}>{{ $s }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label for="bulan" class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
          <select name="bulan" id="bulan" class="{{ $selCls }}">
            <option value="">-- Semua Bulan --</option>
            @foreach ($bulanNama as $angka => $nama)
              <option value="{{ $angka }}" {{ $bulan == $angka ? 'selected' : '' }}>{{ $nama }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
          <select name="tahun" id="tahun" class="{{ $selCls }}">
            <option value="">-- Semua Tahun --</option>
            @php $tahunSekarang = date('Y'); @endphp
            @for ($t = $tahunSekarang; $t >= 2020; $t--)
              <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
            @endfor
          </select>
        </div>
        <button type="submit"
          class="inline-flex items-center gap-1.5 text-sm font-medium text-white bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue rounded-lg px-4 py-2.5 transition">
          <i class="fa-solid fa-filter"></i> Filter
        </button>
        <a href="{{ route('admin.silalad.data-pesanan') }}"
          class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg px-4 py-2.5">
          Reset
        </a>
      </form>
    </div>

    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="daftarPesanan" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>No.</th>
            <th>Pelanggan</th>
            <th>Alamat</th>
            <th>No. Telepon</th>
            <th>Jenis Bangunan</th>
            <th>Status</th>
            <th>Tanggal Pesan</th>
            <th>Kelola</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($pesanan as $index => $item)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>
                <div class="font-medium text-gray-900">{{ $item->nama_pelanggan }}</div>
                <div class="text-xs text-gray-500">{{ $item->kode_booking ?? '-' }}</div>
              </td>
              <td>{{ $item->alamat }}</td>
              <td>{{ $item->nomor_telepon_pelanggan }}</td>
              <td>{{ $item->jenis_bangunan }}</td>
              <td>
                @php
                  $badge = match ($item->status_pengerjaan) {
                      'Sudah dikerjakan' => 'bg-green-100 text-green-800',
                      'Sedang dikerjakan' => 'bg-blue-100 text-blue-800',
                      'Dibatalkan' => 'bg-red-100 text-red-800',
                      default => 'bg-yellow-100 text-yellow-800',
                  };
                @endphp
                <span class="inline-flex items-center whitespace-nowrap px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }}">
                  {{ $item->status_pengerjaan }}
                </span>
              </td>
              <td data-order="{{ $item->created_at->timestamp }}">{{ $item->created_at->format('d M Y H:i') }}</td>
              <td>
                <div class="flex gap-1.5">
                  <a href="{{ route('admin.silalad.edit', $item) }}"
                    class="flex justify-center items-center w-9 h-9 text-white bg-blue-700 hover:bg-blue-800 rounded-lg text-sm">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  <form action="{{ route('admin.silalad.destroy', $item) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus pesanan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                      class="flex justify-center items-center w-9 h-9 text-white bg-red-600 hover:bg-red-700 rounded-lg text-sm">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center text-gray-500 py-4">Belum ada pesanan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection

@section('document.end')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#daftarPesanan').DataTable({
        order: [[6, 'desc']],
        columnDefs: [{
          orderable: false,
          targets: [7]
        }]
      });
    });
  </script>
@endsection
