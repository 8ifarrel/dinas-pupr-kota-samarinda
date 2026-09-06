@extends('admin.layout')

@section('title', $page_title)

@section('document.head')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <style>
    .field-disabled {
      background-color: #f3f4f6;
      color: #4b5563;
      cursor: not-allowed;
    }
  </style>
@endsection

@section('document.body')

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 items-start">
    {{-- Data pelanggan & detail lokasi: tampilan saja, tidak bisa diedit --}}
    <div class="order-2 lg:order-1 lg:col-span-2 space-y-5">
      {{-- Data Pelanggan --}}
      <div class="bg-white rounded-lg shadow-lg border p-6 space-y-5">
        <div>
          <h2 class="text-base font-semibold text-gray-900">Data Pelanggan</h2>
          <p class="text-sm text-gray-500">Data ini diisi pelanggan sendiri saat mendaftar dan tidak dapat diubah di sini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-900">Nama Pelanggan</label>
            <input type="text" value="{{ $data->nama_pelanggan }}" disabled
              class="field-disabled border border-gray-300 text-sm rounded-lg block w-full p-2.5">
          </div>
          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-900">Nomor Telepon</label>
            <input type="text" value="{{ $data->nomor_telepon_pelanggan }}" disabled
              class="field-disabled border border-gray-300 text-sm rounded-lg block w-full p-2.5">
          </div>
        </div>

        <div class="space-y-1.5">
          <label class="block text-sm font-medium text-gray-900">Alamat</label>
          <textarea rows="2" disabled
            class="field-disabled border border-gray-300 text-sm rounded-lg block w-full p-2.5">{{ $data->alamat }}</textarea>
        </div>

        <div class="space-y-1.5">
          <label class="block text-sm font-medium text-gray-900">Apakah pelanggan menyetujui biaya tambahan?</label>
          @if ($data->setuju)
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
              <i class="fa-solid fa-circle-check"></i> Ya
            </span>
          @else
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
              <i class="fa-solid fa-circle-xmark"></i> Tidak
            </span>
          @endif
        </div>
      </div>

      {{-- Detail Lokasi --}}
      <div class="bg-white rounded-lg shadow-lg border p-6 space-y-5">
        <div>
          <h2 class="text-base font-semibold text-gray-900">Detail Lokasi</h2>
          <p class="text-sm text-gray-500">Data ini diisi pelanggan sendiri saat mendaftar dan tidak dapat diubah di sini.</p>
        </div>

        @if ($data->alamat_detail)
          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-900">Alamat Detail</label>
            <input type="text" value="{{ $data->alamat_detail }}" disabled
              class="field-disabled border border-gray-300 text-sm rounded-lg block w-full p-2.5">
          </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-900">Layanan</label>
            <input type="text" value="{{ $data->layanan }}" disabled
              class="field-disabled border border-gray-300 text-sm rounded-lg block w-full p-2.5">
          </div>
          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-900">Jenis Bangunan</label>
            <input type="text" value="{{ $data->jenis_bangunan }}" disabled
              class="field-disabled border border-gray-300 text-sm rounded-lg block w-full p-2.5">
          </div>
        </div>

        @if ($data->detail_laporan)
          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-900">Detail Laporan</label>
            <textarea rows="2" disabled
              class="field-disabled border border-gray-300 text-sm rounded-lg block w-full p-2.5">{{ $data->detail_laporan }}</textarea>
          </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-900">Kabupaten/Kota</label>
            <input type="text" value="{{ $data->kabkota_id }}" disabled
              class="field-disabled border border-gray-300 text-sm rounded-lg block w-full p-2.5">
          </div>
          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-900">Kecamatan</label>
            <input type="text" value="{{ $namaKecamatan }}" disabled
              class="field-disabled border border-gray-300 text-sm rounded-lg block w-full p-2.5">
          </div>
          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-900">Kelurahan</label>
            <input type="text" value="{{ $namaKelurahan }}" disabled
              class="field-disabled border border-gray-300 text-sm rounded-lg block w-full p-2.5">
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-900">RT</label>
            <input type="text" value="{{ $data->rt }}" disabled
              class="field-disabled border border-gray-300 text-sm rounded-lg block w-full p-2.5">
          </div>
          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-900">Nomor Bangunan</label>
            <input type="text" value="{{ $data->nomor_bangunan }}" disabled
              class="field-disabled border border-gray-300 text-sm rounded-lg block w-full p-2.5">
          </div>
        </div>

        @if ($data->latitude && $data->longitude)
          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-900">Titik Lokasi</label>
            <div id="map" class="w-full rounded-lg border" style="height:280px;"></div>
          </div>
        @endif
      </div>
    </div>

    {{-- Satu-satunya yang bisa diedit: status pengerjaan --}}
    <div class="order-1 lg:order-2 flex flex-col gap-4 lg:sticky lg:top-24">
      <div class="order-2 lg:order-1 bg-white rounded-lg shadow-lg border p-6 space-y-5">
        <div>
          <h2 class="text-base font-semibold text-gray-900">Status Pengerjaan</h2>
          <p class="text-sm text-gray-500">Ini satu-satunya bagian yang bisa diubah admin.</p>
        </div>

        <form action="{{ route('admin.silalad.update-status', $data->id) }}" method="POST" class="space-y-4">
          @csrf
          @method('PUT')

          <div class="space-y-1.5">
            <label for="status_pengerjaan" class="block text-sm font-medium text-gray-900">Status</label>
            <select id="status_pengerjaan" name="status_pengerjaan"
              class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
              @foreach (['Belum dikerjakan', 'Sedang dikerjakan', 'Sudah dikerjakan', 'Dibatalkan'] as $status)
                <option value="{{ $status }}" {{ $data->status_pengerjaan == $status ? 'selected' : '' }}>
                  {{ $status }}
                </option>
              @endforeach
            </select>
            @error('status_pengerjaan')
              <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
          </div>

          <div class="flex items-center gap-3 pt-1">
            <button type="submit"
              class="inline-flex items-center gap-1.5 text-sm font-semibold text-white bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue rounded-lg px-5 py-2.5 transition">
              <i class="fa-solid fa-floppy-disk"></i> Simpan
            </button>
            <a href="{{ $routeBatal }}"
              class="inline-flex items-center text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg px-5 py-2.5">
              Batal
            </a>
          </div>
        </form>
      </div>

      <a href="{{ route('admin.silalad.print', $data->id) }}"
        class="order-1 lg:order-2 inline-flex items-center gap-1.5 text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-lg px-5 py-2.5 w-full justify-center">
        <i class="fa-solid fa-print"></i> Cetak Pesanan
      </a>
    </div>
  </div>
@endsection

@if ($data->latitude && $data->longitude)
  @section('document.end')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const pos = [{{ $data->latitude }}, {{ $data->longitude }}];
        const map = L.map('map', { dragging: false, scrollWheelZoom: false, doubleClickZoom: false }).setView(pos, 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        L.marker(pos).addTo(map);
      });
    </script>
  @endsection
@endif
