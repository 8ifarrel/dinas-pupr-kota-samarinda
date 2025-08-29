@extends('admin.layout')

@section('title', $page_title)

@section('content')
<div class="main-content">
    <h2 class="mb-4">{{ $page_title }}</h2>

    <form action="{{ route('admin.sedot-tinja.store') }}" method="POST" class="custom-form">
        @csrf

        <div class="row g-3">
            <!-- Nama Pelanggan -->
            <div class="col-md-6">
                <label for="nama_pelanggan">Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" class="form-control" required>
            </div>

            <!-- Nomor Telepon -->
            <div class="col-md-6">
                <label for="nomor_telepon_pelanggan">Nomor Telepon</label>
                <input type="text" name="nomor_telepon_pelanggan" value="{{ old('nomor_telepon_pelanggan') }}" class="form-control" required>
            </div>

            <!-- Alamat -->
            <div class="col-12">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
            </div>

            <!-- Detail Alamat -->
            <div class="col-12">
                <label for="detail_alamat">Detail Alamat (Jalan / Perumahan)</label>
                <textarea name="detail_alamat" class="form-control" rows="2" required>{{ old('detail_alamat') }}</textarea>
            </div>

            <!-- Nomor Rumah & RT -->
            <div class="col-md-4">
                <label for="nomor_rumah">Nomor Rumah</label>
                <input type="text" name="nomor_rumah" value="{{ old('nomor_rumah') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="rt">RT</label>
                <input type="text" name="rt" value="{{ old('rt') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="rw">RW</label>
                <input type="text" name="rw" value="{{ old('rw') }}" class="form-control">
            </div>

            <!-- Kabupaten, Kecamatan, Kelurahan -->
            <div class="col-md-4">
                <label for="kabupaten">Kabupaten</label>
                <input type="text" name="kabupaten" value="{{ old('kabupaten') }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="kecamatan">Kecamatan</label>
                <input type="text" name="kecamatan" value="{{ old('kecamatan') }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="kelurahan">Kelurahan</label>
                <input type="text" name="kelurahan" value="{{ old('kelurahan') }}" class="form-control" required>
            </div>

            <!-- Jenis Bangunan -->
            <div class="col-md-6">
                <label for="jenis_bangunan">Jenis Bangunan</label>
                <select id="jenis_bangunan" name="jenis_bangunan" class="form-control" required>
                    <option value="">-- Pilih Bangunan --</option>
                    <option value="Rumah">Rumah (Rp600.000)</option>
                    <option value="Tempat ibadah">Tempat Ibadah (Rp300.000)</option>
                    <option value="Panti asuhan">Panti Asuhan (Rp300.000)</option>
                    <option value="Hotel">Hotel (Rp600.000)</option>
                    <option value="Sekolah">Sekolah (Rp300.000)</option>
                    <option value="Panti jompo">Panti Jompo (Rp300.000)</option>
                    <option value="Pabrik">Pabrik (Rp600.000)</option>
                    <option value="Madrasah">Madrasah (Rp300.000)</option>
                    <option value="Rumah sakit">Rumah Sakit (Rp600.000)</option>
                    <option value="Restoran">Restoran (Rp600.000)</option>
                    <option value="Kampus">Kampus (Rp300.000)</option>
                    <option value="Pondok pesantren">Pondok Pesantren (Rp300.000)</option>
                    <option value="Kantor">Kantor (Rp600.000)</option>
                    <option value="Puskesmas">Puskesmas (Rp300.000)</option>
                    <option value="Klinik">Klinik (Rp300.000)</option>
                    <option value="Apartemen">Apartemen (Rp600.000)</option>
                    <option value="Mall">Mall (Rp600.000)</option>
                    <option value="Lainnya">Lainnya (Rp0)</option>
                </select>
            </div>

            <!-- Jenis Layanan -->
            <div class="col-md-6">
                <label for="jenis_Layanan">Jenis Layanan</label>
                <select id="jenis_Layanan" name="jenis_Layanan" class="form-control" required>
                    <option value="">-- Pilih Layanan --</option>
                    <option value="Sedot tinja">Sedot tinja</option>
                    <option value="Sedot lemak">Sedot lemak (soon)</option>
                    <option value="Peminjaman WC Portable">Peminjaman WC Portable (soon)</option>
                </select>
            </div>

            <!-- Detail Laporan -->
            <div class="col-12">
                <label for="detail_laporan">Detail Laporan</label>
                <textarea name="detail_laporan" class="form-control" rows="3">{{ old('detail_laporan') }}</textarea>
            </div>

            <!-- Google Maps -->
            <div class="col-12">
                <label for="lokasi">Titik Lokasi (Google Maps)</label>
                <input type="text" id="lokasi" name="lokasi" class="form-control mb-2" value="{{ old('lokasi') }}" placeholder="Klik peta untuk memilih lokasi" readonly>
                <div id="map"></div>
            </div>

            <!-- Status -->
            <div class="col-md-6">
                <label for="status_pengerjaan">Status Pengerjaan</label>
                <select name="status_pengerjaan" class="form-control" required>
                    <option value="Belum dikerjakan">Belum dikerjakan</option>
                    <option value="Sedang dikerjakan">Sedang dikerjakan</option>
                    <option value="Sudah dikerjakan">Sudah dikerjakan</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
            </div>

            <!-- Tombol -->
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.sedot-tinja.data-pesanan') }}" class="btn btn-secondary">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<style>
    .custom-form {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .custom-form label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }
    .form-control, select, textarea {
        border-radius: 8px !important;
        padding: 10px;
        border: 1px solid #ced4da;
        transition: border-color 0.3s;
    }
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    #map {
        height: 300px;
        border-radius: 10px;
        border: 1px solid #ddd;
    }
    .btn-primary {
        background: #007bff;
        border: none;
        transition: background-color 0.3s;
    }
    .btn-primary:hover {
        background: #0056b3;
    }
    .btn-secondary {
        background: #6c757d;
        border: none;
        transition: background-color 0.3s;
    }
    .btn-secondary:hover {
        background: #565e64;
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const selectBangunan = document.getElementById("jenis_bangunan");
    const divLainnya = document.getElementById("jenis_bangunan_lainnya_div");
    const inputLainnya = document.getElementById("jenis_bangunan_lainnya");

    if (selectBangunan) {
        selectBangunan.addEventListener("change", function() {
            if (this.value === "Lainnya") {
                divLainnya?.classList.remove("d-none");
                inputLainnya?.setAttribute("required", "required");
            } else {
                divLainnya?.classList.add("d-none");
                inputLainnya?.removeAttribute("required");
                if (inputLainnya) inputLainnya.value = "";
            }
        });
    }

    // Google Maps
    var map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -0.502106, lng: 117.153709 },
        zoom: 13
    });

    var marker;
    map.addListener("click", function(event) {
        var lat = event.latLng.lat();
        var lng = event.latLng.lng();
        document.getElementById("lokasi").value = lat + "," + lng;

        if (marker) marker.setPosition(event.latLng);
        else marker = new google.maps.Marker({ position: event.latLng, map: map });
    });
});
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
@endsection