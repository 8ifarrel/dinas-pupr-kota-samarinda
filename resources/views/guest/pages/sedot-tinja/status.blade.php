@extends('guest.layouts.sedottinja')

@section('content')
<div class="min-h-screen py-10 px-4 bg-gray-50">
  <div class="max-w-4xl mx-auto space-y-6"> {{-- pakai space-y-6 biar antar box ada jarak --}}

    {{-- Kotak Pencarian --}}
    <div class="bg-white rounded-2xl shadow p-6">
      <h2 class="text-xl font-bold mb-4 text-center">Cek Status Layanan</h2>

      <form method="GET" action="{{ route('guest.sedot-tinja.status') }}" class="space-y-4">
        <div>
          <label for="nomor_telepon_pelanggan" class="block text-sm font-medium text-gray-700 mb-1">
            Nomor Telepon
          </label>
          <input type="text" name="nomor_telepon_pelanggan" id="nomor_telepon_pelanggan" 
                 value="{{ request('nomor_telepon_pelanggan') }}"
                 placeholder="Masukkan Nomor Telepon Anda"
                 class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <button type="submit" 
                class="w-full px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
          Cari
        </button>
      </form>

      @if(isset($result))
        <div class="mt-6">
          <h3 class="text-lg font-semibold mb-2">Hasil Pencarian</h3>
          @if($result->isEmpty())
            <p class="text-gray-600">Tidak ada data ditemukan untuk nomor telepon tersebut.</p>
          @else
            <table class="w-full border rounded-lg text-sm">
              <thead class="bg-blue-900 text-white">
                <tr>
                  <th class="px-3 py-2 text-left">ID</th>
                  <th class="px-3 py-2 text-left">Tanggal</th>
                  <th class="px-3 py-2 text-left">Nama</th>
                  <th class="px-3 py-2 text-left">Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($result as $item)
                  <tr class="odd:bg-white even:bg-gray-50">
                    <td class="px-3 py-2 font-semibold text-blue-700">#{{ $item->id }}</td>
                    <td class="px-3 py-2">{{ $item->created_at->format('d M Y') }}</td>
                    <td class="px-3 py-2">{{ $item->nama_pelanggan }}</td>
                    <td class="px-3 py-2">
                      @if($item->status_pengerjaan === 'Belum dikerjakan')
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">
                          {{ $item->status_pengerjaan }}
                        </span>
                      @elseif($item->status_pengerjaan === 'Sedang dikerjakan')
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                          {{ $item->status_pengerjaan }}
                        </span>
                      @else
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                          {{ $item->status_pengerjaan }}
                        </span>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @endif
        </div>
      @endif
    </div>

    {{-- Kotak Histori --}}
    <div class="bg-white rounded-2xl shadow p-6">
      <h2 class="text-xl font-bold mb-4 text-center">Histori Pendaftaran</h2>

      {{-- Filter --}}
      <form method="GET" action="{{ route('guest.sedot-tinja.status') }}" class="flex flex-wrap gap-3 mb-4">
        <select name="year" class="border rounded-lg px-3 py-2">
          <option value="">Pilih Tahun</option>
          @foreach($years as $year)
            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
              {{ $year }}
            </option>
          @endforeach
        </select>

        <select name="month" class="border rounded-lg px-3 py-2">
          <option value="">Pilih Bulan</option>
          @foreach(range(1,12) as $m)
            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
              {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
            </option>
          @endforeach
        </select>

        <button type="submit" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg">
          Filter
        </button>
      </form>

      {{-- Tabel Histori --}}
      <div class="overflow-x-auto">
        <table class="w-full border rounded-lg text-sm">
          <thead class="bg-gray-800 text-white">
            <tr>
              <th class="px-3 py-2 text-left">ID</th>
              <th class="px-3 py-2 text-left">Tanggal</th>
              <th class="px-3 py-2 text-left">Nama</th>
              <th class="px-3 py-2 text-left">Alamat</th>
              <th class="px-3 py-2 text-left">Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($history as $item)
              <tr class="odd:bg-white even:bg-gray-50">
                <td class="px-3 py-2 font-semibold text-blue-700">#{{ $item->id }}</td>
                <td class="px-3 py-2">{{ $item->created_at->format('d M Y') }}</td>
                <td class="px-3 py-2">{{ $item->nama_pelanggan }}</td>
                <td class="px-3 py-2">{{ $item->alamat }}</td>
                <td class="px-3 py-2">
                  @if($item->status_pengerjaan === 'Belum dikerjakan')
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">
                      {{ $item->status_pengerjaan }}
                    </span>
                  @elseif($item->status_pengerjaan === 'Sedang dikerjakan')
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                      {{ $item->status_pengerjaan }}
                    </span>
                  @else
                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                      {{ $item->status_pengerjaan }}
                    </span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-gray-500">Belum ada histori pendaftaran.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
@endsection
