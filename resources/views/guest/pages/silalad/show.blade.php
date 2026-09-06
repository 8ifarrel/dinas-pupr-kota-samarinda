@extends('guest.layouts.main')

@section('document.body')
  <div class="py-5 md:py-12 px-6 lg:px-24 3xl:px-48">
    <div class="max-w-3xl mx-auto">
      <div class="bg-white rounded-lg shadow-lg border p-6 sm:p-8">
        <h1 class="text-xl md:text-2xl font-bold mb-4 text-center text-gray-900">Detail Pemesanan SILALAD</h1>

        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <tbody class="divide-y">
              <tr>
                <td class="px-4 py-3 font-medium text-gray-700 w-1/3">Kode Booking</td>
                <td class="px-4 py-3 text-brand-blue font-semibold">{{ $order->kode_booking ?? '-' }}</td>
              </tr>
              <tr>
                <td class="px-4 py-3 font-medium text-gray-700">Nama Pelanggan</td>
                <td class="px-4 py-3">{{ $order->nama_pelanggan }}</td>
              </tr>
              <tr>
                <td class="px-4 py-3 font-medium text-gray-700">Nomor Telepon</td>
                <td class="px-4 py-3">{{ $order->nomor_telepon_pelanggan }}</td>
              </tr>
              <tr>
                <td class="px-4 py-3 font-medium text-gray-700">Alamat</td>
                <td class="px-4 py-3">{{ $order->alamat }} {{ $order->alamat_detail }}</td>
              </tr>
              <tr>
                <td class="px-4 py-3 font-medium text-gray-700">Layanan</td>
                <td class="px-4 py-3">{{ $order->layanan }}</td>
              </tr>
              <tr>
                <td class="px-4 py-3 font-medium text-gray-700">Status</td>
                <td class="px-4 py-3">
                  @php
                    $badge = match ($order->status_pengerjaan) {
                        'Belum dikerjakan' => 'bg-yellow-100 text-yellow-800',
                        'Sedang dikerjakan' => 'bg-blue-100 text-blue-800',
                        default => 'bg-green-100 text-green-800',
                    };
                  @endphp
                  <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }}">
                    {{ $order->status_pengerjaan }}
                  </span>
                </td>
              </tr>
              <tr>
                <td class="px-4 py-3 font-medium text-gray-700">Tanggal</td>
                <td class="px-4 py-3">{{ $order->created_at->format('d M Y, H:i') }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="mt-6 text-center">
          <a href="{{ route('guest.silalad.status') }}"
            class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg px-4 py-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Cek Status
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
