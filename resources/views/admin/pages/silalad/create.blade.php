@extends('admin.layout')

@section('title', $page_title)

@section('document.head')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endsection

@section('document.body')
  <div class="flex items-center gap-3 mb-5">
    <a href="{{ route('admin.silalad.data-pesanan') }}"
      class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg px-3 py-2">
      <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
    <h1 class="text-xl font-bold text-gray-900">{{ $page_title }}</h1>
  </div>

  <form action="{{ route('admin.silalad.store') }}" method="POST"
    class="bg-white rounded-lg shadow-lg border p-6 space-y-5">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="space-y-1.5">
        <label for="nama_pelanggan" class="block text-sm font-medium text-gray-900">Nama Pelanggan</label>
        <input type="text" id="nama_pelanggan" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
      </div>
      <div class="space-y-1.5">
        <label for="nomor_telepon_pelanggan" class="block text-sm font-medium text-gray-900">Nomor Telepon</label>
        <input type="text" id="nomor_telepon_pelanggan" name="nomor_telepon_pelanggan" value="{{ old('nomor_telepon_pelanggan') }}"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
      </div>
    </div>

    <div class="space-y-1.5">
      <label for="alamat" class="block text-sm font-medium text-gray-900">Alamat</label>
      <textarea id="alamat" name="alamat" rows="2"
        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>{{ old('alamat') }}</textarea>
    </div>

    <div class="space-y-1.5">
      <label for="alamat_detail" class="block text-sm font-medium text-gray-900">Alamat Detail</label>
      <input type="text" id="alamat_detail" name="alamat_detail" value="{{ old('alamat_detail') }}"
        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="space-y-1.5">
        <label for="layanan" class="block text-sm font-medium text-gray-900">Jenis Layanan</label>
        <select id="layanan" name="layanan"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
          <option value="">-- Pilih Layanan --</option>
          <option value="sedot tinja" {{ old('layanan') == 'sedot tinja' ? 'selected' : '' }}>Sedot Lumpur Tinja</option>
          <option value="sedot lumpur" {{ old('layanan') == 'sedot lumpur' ? 'selected' : '' }}>Sedot Lemak (soon)</option>
          <option value="sedot lemak" {{ old('layanan') == 'sedot lemak' ? 'selected' : '' }}>Peminjaman WC Portabel (soon)</option>
        </select>
      </div>
      <div class="space-y-1.5">
        <label for="jenis_bangunan" class="block text-sm font-medium text-gray-900">Jenis Bangunan</label>
        <select id="jenis_bangunan" name="jenis_bangunan"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
          <option value="">-- Pilih Bangunan --</option>
          <option value="Rumah">Rumah</option>
          <option value="Tempat ibadah">Tempat Ibadah</option>
          <option value="Panti asuhan">Panti Asuhan</option>
          <option value="Hotel">Hotel</option>
          <option value="Sekolah">Sekolah</option>
          <option value="Panti jompo">Panti Jompo</option>
          <option value="Pabrik">Pabrik</option>
          <option value="Madrasah">Madrasah</option>
          <option value="Rumah sakit">Rumah Sakit</option>
          <option value="Restoran">Restoran</option>
          <option value="Kampus">Kampus</option>
          <option value="Pondok pesantren">Pondok Pesantren</option>
          <option value="Kantor">Kantor</option>
          <option value="Puskesmas">Puskesmas</option>
          <option value="Klinik">Klinik</option>
          <option value="Apartemen">Apartemen</option>
          <option value="Mall">Mall</option>
        </select>
      </div>
    </div>

    <div class="space-y-1.5">
      <label for="detail_laporan" class="block text-sm font-medium text-gray-900">Detail Laporan</label>
      <textarea id="detail_laporan" name="detail_laporan" rows="2"
        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ old('detail_laporan') }}</textarea>
    </div>

    <input type="hidden" name="kabkota_id" value="Samarinda">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="space-y-1.5">
        <label for="kecamatan_id" class="block text-sm font-medium text-gray-900">Kecamatan</label>
        <select id="kecamatan_id" name="kecamatan_id"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
          <option value="" disabled selected>-- Pilih Kecamatan --</option>
          @foreach ($kecamatans as $kecamatan)
            <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama }}</option>
          @endforeach
        </select>
      </div>
      <div class="space-y-1.5">
        <label for="kelurahan_id" class="block text-sm font-medium text-gray-900">Kelurahan</label>
        <select id="kelurahan_id" name="kelurahan_id"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
          <option value="" disabled selected>-- Pilih Kecamatan Dulu --</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div class="space-y-1.5">
        <label for="rt" class="block text-sm font-medium text-gray-900">RT</label>
        <input type="number" id="rt" name="rt" value="{{ old('rt') }}"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
      </div>
      <div class="space-y-1.5">
        <label for="nomor_bangunan" class="block text-sm font-medium text-gray-900">Nomor Rumah</label>
        <input type="number" id="nomor_bangunan" name="nomor_bangunan" value="{{ old('nomor_bangunan') }}"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
      </div>
    </div>

    <div class="space-y-1.5">
      <label class="block text-sm font-medium text-gray-900">Titik Lokasi</label>
      <div id="map" class="w-full rounded-lg border" style="height:320px;"></div>
      <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
      <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="space-y-1.5">
        <label for="rating" class="block text-sm font-medium text-gray-900">Rating</label>
        <input type="number" id="rating" name="rating" min="1" max="5" value="{{ old('rating') }}"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
      </div>
      <div class="space-y-1.5">
        <label for="status_pengerjaan" class="block text-sm font-medium text-gray-900">Status Pengerjaan</label>
        <select id="status_pengerjaan" name="status_pengerjaan"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
          <option value="Belum dikerjakan">Belum dikerjakan</option>
          <option value="Sedang dikerjakan">Sedang dikerjakan</option>
          <option value="Sudah dikerjakan">Sudah dikerjakan</option>
          <option value="Dibatalkan">Dibatalkan</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="space-y-1.5">
        <label for="kritik" class="block text-sm font-medium text-gray-900">Kritik</label>
        <textarea id="kritik" name="kritik" rows="2"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ old('kritik') }}</textarea>
      </div>
      <div class="space-y-1.5">
        <label for="saran" class="block text-sm font-medium text-gray-900">Saran</label>
        <textarea id="saran" name="saran" rows="2"
          class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ old('saran') }}</textarea>
      </div>
    </div>

    <div class="flex items-center gap-3 pt-2">
      <button type="submit"
        class="inline-flex items-center gap-1.5 text-sm font-semibold text-white bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue rounded-lg px-5 py-2.5 transition">
        <i class="fa-solid fa-floppy-disk"></i> Simpan
      </button>
      <a href="{{ route('admin.silalad.data-pesanan') }}"
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
      const selectBangunan = document.getElementById('jenis_bangunan');

      const kecamatanSelect = document.getElementById('kecamatan_id');
      const kelurahanSelect = document.getElementById('kelurahan_id');
      kecamatanSelect.addEventListener('change', function() {
        kelurahanSelect.innerHTML = '<option value="" disabled selected>Memuat...</option>';
        if (!this.value) {
          kelurahanSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kecamatan Dulu --</option>';
          return;
        }
        fetch(`/api/kelurahans/by-kecamatan/${this.value}`)
          .then(res => res.json())
          .then(data => {
            kelurahanSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kelurahan --</option>';
            if (data.success && data.data.length > 0) {
              data.data.forEach(k => {
                const opt = document.createElement('option');
                opt.value = k.id;
                opt.textContent = k.nama;
                kelurahanSelect.appendChild(opt);
              });
            } else {
              kelurahanSelect.innerHTML = '<option value="" disabled selected>Tidak ada data kelurahan</option>';
            }
          })
          .catch(() => {
            kelurahanSelect.innerHTML = '<option value="" disabled selected>Gagal memuat data</option>';
          });
      });

      const defaultPos = [-0.502, 117.153];
      const map = L.map('map').setView(defaultPos, 12);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
      }).addTo(map);
      const marker = L.marker(defaultPos, { draggable: true }).addTo(map);

      function updateLatLng(lat, lng) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
      }
      updateLatLng(defaultPos[0], defaultPos[1]);

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
