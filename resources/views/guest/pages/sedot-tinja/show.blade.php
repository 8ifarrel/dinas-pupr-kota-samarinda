@extends('guest.layouts.sedottinja')

@section('content')
<div class="min-h-screen py-10 px-4 bg-gray-50">
  <div class="max-w-5xl mx-auto">

    {{-- Kalau ada order (detail) --}}
    @isset($order)
      <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4 text-center">Detail Pemesanan Sedot Tinja</h2>

        <table class="w-full border rounded-lg text-sm">
          <tbody>
            <tr>
              <td class="px-4 py-3 font-semibold text-gray-700">Kode Booking</td>
              <td class="px-4 py-3 text-blue-700 font-semibold">{{ $order->kode_booking ?? '-' }}</td>
            </tr>
            <tr>
              <td class="px-4 py-3 font-semibold text-gray-700">Nama Pelanggan</td>
              <td class="px-4 py-3">{{ $order->nama_pelanggan }}</td>
            </tr>
            <tr>
              <td class="px-4 py-3 font-semibold text-gray-700">Nomor Telepon</td>
              <td class="px-4 py-3">{{ $order->nomor_telepon_pelanggan }}</td>
            </tr>
            <tr>
              <td class="px-4 py-3 font-semibold text-gray-700">Alamat</td>
              <td class="px-4 py-3">{{ $order->alamat }} {{ $order->alamat_detail }}</td>
            </tr>
            <tr>
              <td class="px-4 py-3 font-semibold text-gray-700">Layanan</td>
              <td class="px-4 py-3">{{ $order->layanan }}</td>
            </tr>
            <tr>
              <td class="px-4 py-3 font-semibold text-gray-700">Status</td>
              <td class="px-4 py-3">
                @if($order->status_pengerjaan === 'Belum dikerjakan')
                  <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">
                    {{ $order->status_pengerjaan }}
                  </span>
                @elseif($order->status_pengerjaan === 'Sedang dikerjakan')
                  <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                    {{ $order->status_pengerjaan }}
                  </span>
                @else
                  <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                    {{ $order->status_pengerjaan }}
                  </span>
                @endif
              </td>
            </tr>
            <tr>
              <td class="px-4 py-3 font-semibold text-gray-700">Tanggal</td>
              <td class="px-4 py-3">{{ $order->created_at->format('d M Y, H:i') }}</td>
            </tr>
          </tbody>
        </table>

        <div class="mt-6 text-center">
          <a href="{{ route('guest.sedot-tinja.show') }}" 
             class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg">
            ← Kembali ke Daftar Laporan
          </a>
        </div>
      </div>
    @endisset

    {{-- Kalau ada data (list semua laporan) --}}
    @isset($data)
      <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-2xl font-bold mb-4 text-center">Daftar Laporan Sedot Tinja</h2>

        @if($data->isEmpty())
          <p class="text-center text-gray-500">Belum ada laporan yang masuk.</p>
        @else
          <div class="overflow-x-auto">
            <table class="w-full border rounded-lg text-sm">
              <thead class="bg-gray-800 text-white">
                <tr>
                  <th class="px-3 py-2 text-left">Kode Booking</th>
                  <th class="px-3 py-2 text-left">Nama</th>
                  <th class="px-3 py-2 text-left">Alamat</th>
                  <th class="px-3 py-2 text-left">Tanggal</th>
                  <th class="px-3 py-2 text-left">Status</th>
                  <th class="px-3 py-2 text-left">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $item)
                  <tr class="odd:bg-white even:bg-gray-50">
                    <td class="px-3 py-2 font-semibold text-blue-700">
                      {{ $item->kode_booking ?? '-' }}
                    </td>
                    <td class="px-3 py-2">{{ $item->nama_pelanggan }}</td>
                    <td class="px-3 py-2">{{ $item->alamat }}</td>
                    <td class="px-3 py-2">{{ $item->created_at->format('d M Y') }}</td>
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
                    <td class="px-3 py-2">
                      <a href="{{ route('guest.sedot-tinja.detail', $item->id) }}" 
                         class="text-blue-600 hover:underline">
                        Lihat Detail
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    @endisset

  </div>
</div>
@endsection
