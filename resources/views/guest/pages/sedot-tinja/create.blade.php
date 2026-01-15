@extends('guest.layouts.sedottinja')

@section('styles')
<style>
  /* Stepper */
  #stepper {
    position: relative;
  }
  #stepper::before {
    content: "";
    position: absolute;
    top: 20px;
    left: 12%;
    right: 12%;
    height: 3px;
    background: #e5e7eb;
    z-index: 0;
  }
  .step-item {
    position: relative;
    z-index: 1;
  }
  .step-circle {
    transition: all 0.3s ease;
  }
  .step-circle.active {
    background: #2563eb;
    color: #fff;
    transform: scale(1.1);
    box-shadow: 0 0 12px rgba(37, 99, 235, 0.5);
  }
  .step-circle.completed {
    background: #16a34a;
    color: #fff;
  }

  /* Input & Select */
  input[type="text"],
  input[type="number"],
  input[type="file"],
  select,
  textarea {
    transition: all 0.2s ease;
  }
  input:focus,
  select:focus,
  textarea:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.3);
    outline: none;
  }

  /* Tombol Navigasi */
  button {
    transition: all 0.2s ease;
  }
  button:hover {
    opacity: 0.9;
    transform: translateY(-1px);
  }
  button:active {
    transform: translateY(1px);
  }

  /* Map */
  #map {
    border: 2px solid #e5e7eb;
    border-radius: 0.75rem;
    overflow: hidden;
  }

  /* Rating Stars */
  .star {
    color: #d1d5db; /* abu-abu */
    transition: color 0.2s;
    font-size: 2rem;
    cursor: pointer;
  }
  .star.selected { color: #fbbf24; } /* kuning */
</style>
@endsection

@section('content')
<div class="min-h-screen py-10 px-4 bg-gray-50">
  <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow p-8">

    <h1 class="text-2xl font-bold mb-6 text-center">Form Pendaftaran Layanan Sedot Tinja</h1>

    <!-- Stepper -->
    <div id="stepper" class="flex justify-between mb-8">
      <div class="step-item text-center flex-1">
        <div class="step-circle w-10 h-10 mx-auto flex items-center justify-center rounded-full bg-blue-600 text-white font-semibold">1</div>
        <p class="mt-2 text-sm">Data Pelanggan</p>
      </div>
      <div class="step-item text-center flex-1">
        <div class="step-circle w-10 h-10 mx-auto flex items-center justify-center rounded-full bg-gray-300 text-gray-600 font-semibold">2</div>
        <p class="mt-2 text-sm">Detail Alamat</p>
      </div>
      <div class="step-item text-center flex-1">
        <div class="step-circle w-10 h-10 mx-auto flex items-center justify-center rounded-full bg-gray-300 text-gray-600 font-semibold">3</div>
        <p class="mt-2 text-sm">Konfirmasi</p>
      </div>
    </div>

    <!-- Form -->
    <form id="sedotTinjaForm" method="POST" action="{{ route('guest.sedot-tinja.store') }}">
      @csrf

      <!-- STEP 1 -->
      <div class="step" data-step="1">
        <div class="mb-4">
          <label class="block mb-1 font-medium">Nama</label>
          <input type="text" 
                name="nama_pelanggan" 
                value="{{ old('nama_pelanggan') }}" 
                class="w-full border rounded-lg px-3 py-2" 
                placeholder="Masukkan nama anda"
                required>
        </div>
        <div class="mb-4">
          <label class="block mb-1 font-medium">Nomor Telepon</label>
          <input type="text" 
                name="nomor_telepon_pelanggan" 
                value="{{ old('nomor_telepon_pelanggan') }}" 
                class="w-full border rounded-lg px-3 py-2" 
                placeholder="Contoh: 081234567890"
                required>
        </div>
        <div class="mb-4">
          <label class="block mb-1 font-medium">Alamat</label>
          <input type="text" 
                name="alamat" 
                value="{{ old('alamat') }}" 
                class="w-full border rounded-lg px-3 py-2" 
                placeholder="Masukkan alamat lengkap anda"
                required>
        </div>
      </div>


      <!-- STEP 2 -->
      <div class="step hidden" data-step="2">
        <div class="mb-4">
          <label class="block mb-1 font-medium">Detail Alamat</label>
          <textarea name="alamat_detail" class="w-full border rounded-lg px-3 py-2" rows="2" required>{{ old('alamat_detail') }}</textarea>
        </div>

        <div class="mb-4">
          <label class="block mb-1 font-medium">Jenis Layanan</label>
          <select name="layanan" class="w-full border rounded-lg px-3 py-2" required>
            <option value="">-- Pilih Layanan --</option>
            <option value="sedot tinja" {{ old('layanan')=='sedot tinja' ? 'selected' : '' }}>Sedot Lumpur Tinja</option>
            <option value="sedot lumpur" {{ old('layanan')=='sedot lumpur' ? 'selected' : '' }}>Sedot Lemak (soon)</option>
            <option value="sedot lemak" {{ old('layanan')=='sedot lemak' ? 'selected' : '' }}>Peminjaman WC  Portabel 9(soon)</option>
          </select>
        </div>

        <div class="mb-4">
          <label class="block mb-1 font-medium">Detail Laporan</label>
          <textarea name="detail_laporan" class="w-full border rounded-lg px-3 py-2" rows="2">{{ old('detail_laporan') }}</textarea>
        </div>

        <!-- Dropdown API Alamat -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
          <div>
            <label class="block mb-1 font-medium">Kabupaten/Kota</label>
            <select id="kabkota_id" name="kabkota_id" class="w-full border rounded-lg px-3 py-2" required></select>
          </div>
          <div>
            <label class="block mb-1 font-medium">Kecamatan</label>
            <select id="kecamatan_id" name="kecamatan_id" class="w-full border rounded-lg px-3 py-2" required></select>
          </div>
          <div>
            <label class="block mb-1 font-medium">Kelurahan</label>
            <select id="kelurahan_id" name="kelurahan_id" class="w-full border rounded-lg px-3 py-2" required></select>
          </div>
        </div>

        <div class="mb-4">
          <label class="block mb-1 font-medium">Jenis Bangunan</label>
          <select id="jenis_bangunan" name="jenis_bangunan" class="w-full border rounded-lg px-3 py-2" required>
            <option value="">-- Pilih Bangunan --</option>
            <option value="Rumah">Rumah </option>
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
            <option value="Lainnya">Lainnya </option>
          </select>
        </div>

        <!-- Input tambahan untuk 'Lainnya' -->
        <div id="jenis_bangunan_lainnya_div" class="mb-4 hidden">
          <label class="block mb-1 font-medium">Tuliskan Jenis Bangunan</label>
          <input type="text" id="jenis_bangunan_lainnya" name="jenis_bangunan_lainnya"
                class="w-full border rounded-lg px-3 py-2"
                placeholder="Isi jenis bangunan lain...">
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block mb-1 font-medium">RT</label>
          <input type="number" 
                name="rt" 
                value="{{ old('rt') }}" 
                class="w-full border rounded-lg px-3 py-2" 
                placeholder="Masukkan nomor RT"
                required>
        </div>
        <div>
          <label class="block mb-1 font-medium">Nomor Rumah</label>
          <input type="number" 
                name="nomor_bangunan" 
                value="{{ old('nomor_bangunan') }}" 
                class="w-full border rounded-lg px-3 py-2" 
                placeholder="Masukkan nomor rumah"
                required>
        </div>
      </div>

        <div class="mb-4">
          <label class="block mb-1 font-medium">Titik Lokasi</label>
          <div id="map" class="w-full rounded-lg border" style="height:400px;"></div>
          <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
          <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
          <p class="mt-2 text-sm text-gray-600">
          Titik lokasi: <span id="latText">-</span>, <span id="lngText">-</span></p>
        </div>
      </div>


      <!-- STEP 3 -->
      <div class="step hidden" data-step="3">
         <!-- Rating -->
        <div class="mb-4">
          <label class="block mb-1 font-bold text-sm">Rating</label>
          <p class="text-xs text-gray-600">Berikan pendapatmu mengenai website ini</p>
          <div id="rating-stars" class="flex space-x-2">
            <span data-value="1" class="star">&#9734;</span>
            <span data-value="2" class="star">&#9734;</span>
            <span data-value="3" class="star">&#9734;</span>
            <span data-value="4" class="star">&#9734;</span>
            <span data-value="5" class="star">&#9734;</span>
          </div>
          <input type="hidden" name="rating" id="rating" value="{{ old('rating') }}">
        </div>

        <!-- <div class="mb-4">
          <label class="block mb-1 font-medium">Masukan</label>
          <textarea name="Masukan" class="w-full border rounded-lg px-3 py-2" rows="2">{{ old('Masukan') }}</textarea>
        </div> -->
        <div class="mb-4">
          <label class="block mb-1 font-medium">Saran & Masukan</label>
          <textarea name="saran & masukan" class="w-full border rounded-lg px-3 py-2" rows="2">{{ old('saran & masukan') }}</textarea>
        </div>
        {{--  Captcha Turnstile --}}
        <div class="mb-4">
          <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.key') }}"></div>
          @error('cf-turnstile-response')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>
        <!-- <div class="mb-4">
          <label class="inline-flex items-center">
            <input type="checkbox" name="setuju" value="1" required class="mr-2" {{ old('setuju') ? 'checked' : '' }}>
            <span>Saya menyetujui bila ada tambahan biaya pada saat di lokasi</span>
          </label>
        </div> -->
      </div>

      <!-- Navigation -->
      <div class="flex justify-between mt-6">
        <button type="button" id="prevBtn" class="px-6 py-2 bg-gray-300 rounded-lg hidden">Kembali</button>
        <button type="button" id="nextBtn" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Lanjut</button>
        <button type="submit" id="submitBtn" class="px-6 py-2 bg-green-600 text-white rounded-lg hidden">Kirim</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const selectBangunan = document.getElementById("jenis_bangunan");
    const divLainnya = document.getElementById("jenis_bangunan_lainnya_div");
    const inputLainnya = document.getElementById("jenis_bangunan_lainnya");

    selectBangunan.addEventListener("change", function() {
      if (this.value === "Lainnya") {
        divLainnya.classList.remove("hidden");
        inputLainnya.setAttribute("required", "required");
      } else {
        divLainnya.classList.add("hidden");
        inputLainnya.removeAttribute("required");
        inputLainnya.value = ""; // reset kalau user ganti pilihan lain
      }
    });
  });

  // Google Maps
  let map, marker;
  window.initMap = function() {
    const defaultPos = { lat: -0.502, lng: 117.153 };
    map = new google.maps.Map(document.getElementById("map"), {
      center: defaultPos,
      zoom: 12,
    });
    marker = new google.maps.Marker({
      position: defaultPos,
      map,
      draggable: true,
    });

    document.getElementById('latitude').value = marker.getPosition().lat();
    document.getElementById('longitude').value = marker.getPosition().lng();
    document.getElementById('latText').innerText = defaultPos.lat.toFixed(6);
    document.getElementById('lngText').innerText = defaultPos.lng.toFixed(6);
    
    // Kalau marker digeser
    google.maps.event.addListener(marker, 'dragend', function() {
      updateLatLng(marker.getPosition().lat(), marker.getPosition().lng());
    });

    // Kalau user klik map
    google.maps.event.addListener(map, 'click', function(event) {
      marker.setPosition(event.latLng);
      updateLatLng(event.latLng.lat(), event.latLng.lng());
    });

  }

  function updateLatLng(lat, lng) {
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;
    document.getElementById('latText').innerText = lat.toFixed(6);
    document.getElementById('lngText').innerText = lng.toFixed(6);
  }

  document.addEventListener("DOMContentLoaded", function() {
    let currentStep = 1;
    const steps = document.querySelectorAll('.step');
    const stepCircles = document.querySelectorAll('.step-circle');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');

    function showStep(step) {
      steps.forEach(s => s.classList.add('hidden'));
      document.querySelector(`.step[data-step="${step}"]`).classList.remove('hidden');

      stepCircles.forEach((circle, i) => {
        circle.classList.remove('active', 'completed');
        if (i + 1 < step) {
          circle.classList.add('completed');
        } else if (i + 1 === step) {
          circle.classList.add('active');
        }
      });

      prevBtn.classList.toggle('hidden', step === 1);
      nextBtn.classList.toggle('hidden', step === steps.length);
        submitBtn.classList.toggle('hidden', step !== steps.length);

      // masuk ke step 2, trigger resize agar map muncul normal
      if(step === 2 && map){
        setTimeout(() => {
          google.maps.event.trigger(map, "resize");
          map.setCenter(marker.getPosition());
        }, 300);
      }
    }

    nextBtn.addEventListener('click', () => { currentStep++; showStep(currentStep); });
    prevBtn.addEventListener('click', () => { currentStep--; showStep(currentStep); });
    showStep(currentStep);
  });

  // API Alamat
  async function fetchWilayah(url, targetId) {
    try {
        let res = await fetch(url);
        let data = await res.json();
        let select = document.getElementById(targetId);
        select.innerHTML = '<option value="">-- Pilih --</option>';
        data.result.forEach(d => {
        select.innerHTML += `<option value="${d.id}">${d.text}</option>`;
        });
    } catch (err) {
        console.error("API Alamat error:", err);
        document.getElementById(targetId).innerHTML = '<option value="">Gagal load data</option>';
    }
    }

    fetchWilayah("https://alamat.thecloudalert.com/api/kabkota/get/?d_provinsi_id=15", "kabkota_id");

    document.getElementById("kabkota_id").addEventListener("change", function() {
    fetchWilayah(
      `https://alamat.thecloudalert.com/api/kecamatan/get/?d_kabkota_id=${this.value}`, 
      "kecamatan_id"
      );
    });
    document.getElementById("kecamatan_id").addEventListener("change", function() {
    fetchWilayah(
      `https://alamat.thecloudalert.com/api/kelurahan/get/?d_kecamatan_id=${this.value}`, 
      "kelurahan_id"
    );
  });

  // ⭐ Rating
  document.addEventListener("DOMContentLoaded", function() {
    const stars = document.querySelectorAll("#rating-stars .star");
    const ratingInput = document.getElementById("rating");

    stars.forEach(star => {
      star.addEventListener("click", function() {
        const value = this.getAttribute("data-value");
        ratingInput.value = value;

        stars.forEach(s => {
          s.innerHTML = "&#9734;"; // kosong ☆
          s.classList.remove("selected");
        });

        for (let i = 0; i < value; i++) {
          stars[i].innerHTML = "&#9733;"; // penuh ★
          stars[i].classList.add("selected");
        }
      });
    });
  });

</script>

{{-- Google Maps --}}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARqG3-uSv0J4VgNmU9YtaNdWExMqxPgRg&callback=initMap" async defer></script>

{{-- Cloudflare Turnstile --}}
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

@endsection
