@extends('admin.layout')

@section('title', 'Detail Pesanan SILALAD')

@section('document.body')
  <div class="flex items-center gap-3 mb-5">
    <a href="{{ route('admin.silalad.data-pesanan') }}"
      class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg px-3 py-2">
      <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
    <h1 class="text-xl font-bold text-gray-900">Detail Pesanan SILALAD</h1>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-lg shadow-lg border p-6">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <tbody class="divide-y">
            <tr>
              <td class="px-2 py-2.5 font-medium text-gray-700 w-1/3">Kode Booking</td>
              <td class="px-2 py-2.5 text-brand-blue font-semibold">{{ $silalad->kode_booking ?? '-' }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2.5 font-medium text-gray-700">Nama</td>
              <td class="px-2 py-2.5">{{ $silalad->nama_pelanggan }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2.5 font-medium text-gray-700">Telepon</td>
              <td class="px-2 py-2.5">{{ $silalad->nomor_telepon_pelanggan }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2.5 font-medium text-gray-700">Alamat</td>
              <td class="px-2 py-2.5">{{ $silalad->alamat }} {{ $silalad->alamat_detail }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2.5 font-medium text-gray-700">Layanan</td>
              <td class="px-2 py-2.5">{{ $silalad->layanan }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2.5 font-medium text-gray-700">Detail Laporan</td>
              <td class="px-2 py-2.5">{{ $silalad->detail_laporan ?: '-' }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2.5 font-medium text-gray-700">Wilayah</td>
              <td class="px-2 py-2.5">{{ $silalad->kabkota_id }} / Kec. {{ $silalad->kecamatan_id }} / Kel. {{ $silalad->kelurahan_id }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2.5 font-medium text-gray-700">Jenis Bangunan</td>
              <td class="px-2 py-2.5">{{ $silalad->jenis_bangunan }}, No. {{ $silalad->nomor_bangunan }}, RT {{ $silalad->rt }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2.5 font-medium text-gray-700">Titik Lokasi</td>
              <td class="px-2 py-2.5">{{ $silalad->latitude ?? '-' }}, {{ $silalad->longitude ?? '-' }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2.5 font-medium text-gray-700">Rating</td>
              <td class="px-2 py-2.5">{{ $silalad->rating ?? '-' }} / 5</td>
            </tr>
            <tr>
              <td class="px-2 py-2.5 font-medium text-gray-700">Kritik & Saran</td>
              <td class="px-2 py-2.5">{{ $silalad->saran_masukan ?: '-' }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2.5 font-medium text-gray-700">Persetujuan Biaya</td>
              <td class="px-2 py-2.5">{{ $silalad->setuju ? 'Ya' : 'Tidak' }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2.5 font-medium text-gray-700">Dibuat</td>
              <td class="px-2 py-2.5">{{ $silalad->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2.5 font-medium text-gray-700">Diupdate</td>
              <td class="px-2 py-2.5">{{ $silalad->updated_at->format('d-m-Y H:i') }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="space-y-6">
      <div class="bg-white rounded-lg shadow-lg border p-6">
        <h3 class="font-semibold text-gray-900 mb-3">Status Saat Ini</h3>
        @php
          $badge = match ($silalad->status_pengerjaan) {
              'Sudah dikerjakan' => 'bg-green-100 text-green-800',
              'Sedang dikerjakan' => 'bg-blue-100 text-blue-800',
              'Dibatalkan' => 'bg-gray-200 text-gray-700',
              default => 'bg-yellow-100 text-yellow-800',
          };
        @endphp
        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium {{ $badge }}">
          {{ $silalad->status_pengerjaan }}
        </span>

        <form action="{{ route('admin.silalad.update-status', $silalad->id) }}" method="POST" class="mt-4 space-y-2">
          @csrf
          @method('PUT')
          <select name="status_pengerjaan"
            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            @foreach (['Belum dikerjakan', 'Sedang dikerjakan', 'Sudah dikerjakan', 'Dibatalkan'] as $status)
              <option value="{{ $status }}" {{ $silalad->status_pengerjaan == $status ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
          </select>
          <button type="submit"
            class="w-full inline-flex justify-center items-center gap-1.5 text-sm font-semibold text-white bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue rounded-lg px-4 py-2 transition">
            <i class="fa-solid fa-rotate"></i> Update Status
          </button>
        </form>
      </div>

      <div class="bg-white rounded-lg shadow-lg border p-6 space-y-2">
        <a href="{{ route('admin.silalad.edit', $silalad->id) }}"
          class="w-full inline-flex justify-center items-center gap-1.5 text-sm font-semibold text-white bg-yellow-500 hover:bg-yellow-600 rounded-lg px-4 py-2 transition">
          <i class="fa-solid fa-pencil"></i> Edit Pesanan
        </a>
        <a href="{{ route('admin.silalad.print', $silalad->id) }}"
          class="w-full inline-flex justify-center items-center gap-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg px-4 py-2">
          <i class="fa-solid fa-print"></i> Cetak
        </a>
        <form action="{{ route('admin.silalad.destroy', $silalad->id) }}" method="POST"
          onsubmit="return confirm('Yakin ingin menghapus pesanan ini?');">
          @csrf
          @method('DELETE')
          <button type="submit"
            class="w-full inline-flex justify-center items-center gap-1.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg px-4 py-2 transition">
            <i class="fa-solid fa-trash"></i> Hapus Pesanan
          </button>
        </form>
      </div>
    </div>
  </div>
@endsection
