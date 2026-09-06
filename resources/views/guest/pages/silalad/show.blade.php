@extends('guest.layouts.silalad')

@section('content')
<div class="min-h-screen py-10 px-4 bg-gray-50">
  <div class="max-w-5xl mx-auto">

    {{-- Kalau ada order (detail) --}}
    @isset($order)
      <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4 text-center">Detail Pemesanan SILALAD</h2>

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
          <a href="{{ route('guest.silalad.status') }}"
             class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg">
            ← Kembali ke Cek Status
          </a>
        </div>
      </div>
    @endisset

  </div>
</div>
@endsection
