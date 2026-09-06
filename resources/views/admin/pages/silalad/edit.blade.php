@extends('admin.layout')

@section('title', $page_title)

@section('document.head')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endsection

@section('document.body')
  <div class="flex items-center gap-3 mb-5">
    <a href="{{ $routeBatal }}"
      class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg px-3 py-2">
      <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
    <div>
      <h1 class="text-xl font-bold text-gray-900">{{ $page_title }}</h1>
      <p class="text-sm text-gray-600">{{ $page_description }}</p>
    </div>
  </div>

  {{-- PENTING: form ini mengirim ke rute update (seluruh field), bukan
       update-status (yang hanya menerima status_pengerjaan). Sebelumnya
       form ini salah arah ke update-status, sehingga semua perubahan
       selain status pengerjaan hilang diam-diam saat disimpan. --}}
  <form action="{{ route('admin.silalad.update', $data->id) }}" method="POST"
    class="bg-white rounded-lg shadow-lg border p-6 space-y-5">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="space-y-1.5">
        <label for="nama_pelanggan" class="block text-sm font-medium text-gray-900">Nama Pelanggan</label>
        <input type="text" id="nama_pelanggan" name="nama_pelanggan"
          value="{{ old('nama_pelanggan', $data->nama_pelanggan) }}"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
        @error('nama_pelanggan')
          <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>
      <div class="space-y-1.5">
        <label for="nomor_telepon_pelanggan" class="block text-sm font-medium text-gray-900">Nomor Telepon</label>
        <input type="text" id="nomor_telepon_pelanggan" name="nomor_telepon_pelanggan"
          value="{{ old('nomor_telepon_pelanggan', $data->nomor_telepon_pelanggan) }}"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
        @error('nomor_telepon_pelanggan')
          <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <div class="space-y-1.5">
      <label for="alamat" class="block text-sm font-medium text-gray-900">Alamat</label>
      <textarea id="alamat" name="alamat" rows="2"
        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>{{ old('alamat', $data->alamat) }}</textarea>
      @error('alamat')
        <p class="text-red-600 text-sm">{{ $message }}</p>
      @enderror
    </div>

    <div class="space-y-1.5">
      <label for="alamat_detail" class="block text-sm font-medium text-gray-900">Alamat Detail</label>
      <input type="text" id="alamat_detail" name="alamat_detail" value="{{ old('alamat_detail', $data->alamat_detail) }}"
        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="space-y-1.5">
        <label for="layanan" class="block text-sm font-medium text-gray-900">Layanan</label>
        <input type="text" id="layanan" name="layanan" value="{{ old('layanan', $data->layanan) }}"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
      </div>
      <div class="space-y-1.5">
        <label for="jenis_bangunan" class="block text-sm font-medium text-gray-900">Jenis Bangunan</label>
        <input type="text" id="jenis_bangunan" name="jenis_bangunan" value="{{ old('jenis_bangunan', $data->jenis_bangunan) }}"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
        @error('jenis_bangunan')
          <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <div class="space-y-1.5">
      <label for="detail_laporan" class="block text-sm font-medium text-gray-900">Detail Laporan</label>
      <textarea id="detail_laporan" name="detail_laporan" rows="2"
        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ old('detail_laporan', $data->detail_laporan) }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="space-y-1.5">
        <label for="kabkota_id" class="block text-sm font-medium text-gray-900">Kabupaten/Kota</label>
        <input type="text" id="kabkota_id" name="kabkota_id" value="{{ old('kabkota_id', $data->kabkota_id) }}"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
      </div>
      <div class="space-y-1.5">
        <label for="kecamatan_id" class="block text-sm font-medium text-gray-900">Kecamatan</label>
        <select id="kecamatan_id" name="kecamatan_id"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
          <option value="" disabled>-- Pilih Kecamatan --</option>
          @foreach ($kecamatans as $kecamatan)
            <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $data->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>
              {{ $kecamatan->nama }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="space-y-1.5">
        <label for="kelurahan_id" class="block text-sm font-medium text-gray-900">Kelurahan</label>
        <select id="kelurahan_id" name="kelurahan_id"
          data-current="{{ old('kelurahan_id', $data->kelurahan_id) }}"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
          <option value="" disabled selected>Memuat...</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div class="space-y-1.5">
        <label for="rt" class="block text-sm font-medium text-gray-900">RT</label>
        <input type="number" id="rt" name="rt" value="{{ old('rt', $data->rt) }}"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
        @error('rt')
          <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>
      <div class="space-y-1.5">
        <label for="nomor_bangunan" class="block text-sm font-medium text-gray-900">Nomor Bangunan</label>
        <input type="number" id="nomor_bangunan" name="nomor_bangunan" value="{{ old('nomor_bangunan', $data->nomor_bangunan) }}"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
        @error('nomor_bangunan')
          <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <div class="space-y-1.5">
      <label class="block text-sm font-medium text-gray-900">Titik Lokasi</label>
      <div id="map" class="w-full rounded-lg border" style="height:320px;"></div>
      <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $data->latitude) }}">
      <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $data->longitude) }}">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="space-y-1.5">
        <label for="rating" class="block text-sm font-medium text-gray-900">Rating</label>
        <input type="number" id="rating" name="rating" min="1" max="5" value="{{ old('rating', $data->rating) }}"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
      </div>
      <div class="space-y-1.5">
        <label for="status_pengerjaan" class="block text-sm font-medium text-gray-900">Status Pengerjaan</label>
        <select id="status_pengerjaan" name="status_pengerjaan"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
          @foreach (['Belum dikerjakan', 'Sedang dikerjakan', 'Sudah dikerjakan', 'Dibatalkan'] as $status)
            <option value="{{ $status }}" {{ old('status_pengerjaan', $data->status_pengerjaan) == $status ? 'selected' : '' }}>
              {{ $status }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="space-y-1.5">
        <label for="kritik" class="block text-sm font-medium text-gray-900">Kritik</label>
        <textarea id="kritik" name="kritik" rows="2"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ old('kritik', $data->kritik) }}</textarea>
      </div>
      <div class="space-y-1.5">
        <label for="saran" class="block text-sm font-medium text-gray-900">Saran</label>
        <textarea id="saran" name="saran" rows="2"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ old('saran', $data->saran) }}</textarea>
      </div>
    </div>

    <div class="flex items-center gap-2">
      <input type="checkbox" id="setuju" name="setuju" value="1" {{ old('setuju', $data->setuju) ? 'checked' : '' }}
        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
      <label for="setuju" class="text-sm font-medium text-gray-900">Setuju biaya tambahan</label>
    </div>

    <div class="flex items-center gap-3 pt-2">
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
@endsection

@section('document.end')
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const kecamatanSelect = document.getElementById('kecamatan_id');
      const kelurahanSelect = document.getElementById('kelurahan_id');

      function loadKelurahan(kecamatanId, selectedId) {
        kelurahanSelect.innerHTML = '<option value="" disabled selected>Memuat...</option>';
        if (!kecamatanId) {
          kelurahanSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kecamatan Dulu --</option>';
          return;
        }
        fetch(`/api/kelurahans/by-kecamatan/${kecamatanId}`)
          .then(res => res.json())
          .then(data => {
            kelurahanSelect.innerHTML = '<option value="" disabled>-- Pilih Kelurahan --</option>';
            if (data.success && data.data.length > 0) {
              data.data.forEach(k => {
                const opt = document.createElement('option');
                opt.value = k.id;
                opt.textContent = k.nama;
                if (selectedId && String(k.id) === String(selectedId)) opt.selected = true;
                kelurahanSelect.appendChild(opt);
              });
            } else {
              kelurahanSelect.innerHTML = '<option value="" disabled selected>Tidak ada data kelurahan</option>';
            }
          })
          .catch(() => {
            kelurahanSelect.innerHTML = '<option value="" disabled selected>Gagal memuat data</option>';
          });
      }

      // Muat kelurahan awal sesuai kecamatan yang sudah tersimpan.
      loadKelurahan(kecamatanSelect.value, kelurahanSelect.dataset.current);

      kecamatanSelect.addEventListener('change', function() {
        loadKelurahan(this.value, null);
      });

      const savedLat = parseFloat(document.getElementById('latitude').value);
      const savedLng = parseFloat(document.getElementById('longitude').value);
      const defaultPos = (!isNaN(savedLat) && !isNaN(savedLng)) ? [savedLat, savedLng] : [-0.502, 117.153];

      const map = L.map('map').setView(defaultPos, 13);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
      }).addTo(map);
      const marker = L.marker(defaultPos, { draggable: true }).addTo(map);

      function updateLatLng(lat, lng) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
      }

      marker.on('dragend', function() {
        const pos = marker.getLatLng();
        updateLatLng(pos.lat, pos.lng);
      });
      map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateLatLng(e.latlng.lat, e.latlng.lng);
      });
    });
  </script>
@endsection
