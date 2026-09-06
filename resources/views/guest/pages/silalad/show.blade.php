@extends('guest.layouts.main')

@section('document.start')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endsection

@section('document.body')
  <div class="py-5 md:py-12 px-6 lg:px-24 3xl:px-48">
    <nav aria-label="Breadcrumb" class="max-w-4xl mx-auto mb-2.5">
      <ol class="inline-flex items-center text-sm">
        <li class="inline-flex items-center">
          <a href="{{ route('guest.beranda.index') }}" class="text-blue-600 underline">Beranda</a>
        </li>
        <li>
          <div class="flex items-center">
            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
            </svg>
            <a href="{{ route('guest.silalad.index') }}" class="text-blue-600 underline">SILALAD</a>
          </div>
        </li>
        <li>
          <div class="flex items-center">
            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
            </svg>
            <a href="{{ route('guest.silalad.status', ['nomor_telepon_pelanggan' => $data->nomor_telepon_pelanggan]) }}"
              class="text-blue-600 underline">Cek Status</a>
          </div>
        </li>
        <li aria-current="page">
          <div class="flex items-center">
            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
            </svg>
            <span class="text-gray-500 font-medium">Detail Pesanan</span>
          </div>
        </li>
      </ol>
    </nav>

    <div class="max-w-4xl mx-auto space-y-5">
      <div class="flex items-center justify-between">
        <h1 class="text-xl md:text-2xl font-bold text-gray-900">Detail Pemesanan SILALAD</h1>
        <a href="{{ route('guest.silalad.status', ['nomor_telepon_pelanggan' => $data->nomor_telepon_pelanggan]) }}"
          class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg px-4 py-2.5">
          <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
      </div>

      <div class="bg-white rounded-lg shadow-lg border p-6 space-y-5">
        {{-- Informasi Pesanan --}}
        <div>
          <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-2">Informasi Pesanan</h4>
          <dl class="text-sm divide-y border rounded-lg">
            <div class="flex justify-between gap-3 px-3 py-2">
              <dt class="text-gray-500">Kode Booking</dt>
              <dd class="text-right text-brand-blue font-semibold">{{ $data->kode_booking ?? '-' }}</dd>
            </div>
            <div class="flex justify-between gap-3 px-3 py-2">
              <dt class="text-gray-500">Status</dt>
              <dd class="text-right">
                @php
                  $badge = match ($data->status_pengerjaan) {
                      'Belum dikerjakan' => 'bg-yellow-100 text-yellow-800',
                      'Sedang dikerjakan' => 'bg-blue-100 text-blue-800',
                      'Dibatalkan' => 'bg-red-100 text-red-800',
                      default => 'bg-green-100 text-green-800',
                  };
                @endphp
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium whitespace-nowrap {{ $badge }}">
                  {{ $data->status_pengerjaan }}
                </span>
              </dd>
            </div>
            <div class="flex justify-between gap-3 px-3 py-2">
              <dt class="text-gray-500">Tanggal</dt>
              <dd class="text-right">{{ $data->created_at->format('d M Y, H:i') }}</dd>
            </div>
          </dl>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          {{-- Data Pelanggan --}}
          <div>
            <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-2">Data Pelanggan</h4>
            <dl class="text-sm divide-y border rounded-lg">
              <div class="flex justify-between gap-3 px-3 py-2">
                <dt class="text-gray-500">Nama</dt>
                <dd class="text-right">{{ $data->nama_pelanggan }}</dd>
              </div>
              <div class="flex justify-between gap-3 px-3 py-2">
                <dt class="text-gray-500">Nomor Telepon</dt>
                <dd class="text-right">{{ $data->nomor_telepon_pelanggan }}</dd>
              </div>
              <div class="flex justify-between gap-3 px-3 py-2">
                <dt class="text-gray-500">Alamat Pelanggan</dt>
                <dd class="text-right">{{ $data->alamat }}</dd>
              </div>
            </dl>
          </div>

          {{-- Detail Lokasi --}}
          <div>
            <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-2">Detail Lokasi</h4>
            <dl class="text-sm divide-y border rounded-lg">
              <div class="flex justify-between gap-3 px-3 py-2">
                <dt class="text-gray-500">Alamat</dt>
                <dd class="text-right">{{ $data->alamat_detail ?: '-' }}</dd>
              </div>
              <div class="flex justify-between gap-3 px-3 py-2">
                <dt class="text-gray-500">Layanan</dt>
                <dd class="text-right">{{ $data->layanan ?: '-' }}</dd>
              </div>
              <div class="flex justify-between gap-3 px-3 py-2">
                <dt class="text-gray-500">Jenis Bangunan</dt>
                <dd class="text-right">{{ $data->jenis_bangunan ?: '-' }}</dd>
              </div>
              <div class="flex justify-between gap-3 px-3 py-2">
                <dt class="text-gray-500">Detail Laporan</dt>
                <dd class="text-right">{{ $data->detail_laporan ?: '-' }}</dd>
              </div>
              <div class="flex justify-between gap-3 px-3 py-2">
                <dt class="text-gray-500">Kabupaten/Kota</dt>
                <dd class="text-right">{{ $data->kabkota_id ?: '-' }}</dd>
              </div>
              <div class="flex justify-between gap-3 px-3 py-2">
                <dt class="text-gray-500">Kecamatan</dt>
                <dd class="text-right">{{ $namaKecamatan ?: '-' }}</dd>
              </div>
              <div class="flex justify-between gap-3 px-3 py-2">
                <dt class="text-gray-500">Kelurahan</dt>
                <dd class="text-right">{{ $namaKelurahan ?: '-' }}</dd>
              </div>
              <div class="flex justify-between gap-3 px-3 py-2">
                <dt class="text-gray-500">RT</dt>
                <dd class="text-right">{{ $data->rt ?: '-' }}</dd>
              </div>
              <div class="flex justify-between gap-3 px-3 py-2">
                <dt class="text-gray-500">Nomor Bangunan</dt>
                <dd class="text-right">{{ $data->nomor_bangunan ?: '-' }}</dd>
              </div>
            </dl>
          </div>
        </div>

        @if ($data->latitude && $data->longitude)
          <div>
            <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-2">Titik Lokasi</h4>
            <div id="map" class="w-full rounded-lg border" style="height:300px;"></div>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection

@if ($data->latitude && $data->longitude)
  @section('document.end')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
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
