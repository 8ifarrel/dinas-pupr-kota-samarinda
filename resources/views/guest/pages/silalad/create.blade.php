@extends('guest.layouts.main')

@section('document.start')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endsection

@section('document.body')
  <div class="py-5 md:py-12 px-6 lg:px-24 3xl:px-48">
    {{-- Breadcrumb --}}
    <nav aria-label="Breadcrumb" class="max-w-[940px] mx-auto mb-2.5">
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
        <li aria-current="page">
          <div class="flex items-center">
            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
            </svg>
            <span class="text-gray-500 font-medium">Form Pendaftaran</span>
          </div>
        </li>
      </ol>
    </nav>

    <div class="max-w-[940px] mx-auto border shadow-lg p-4 sm:p-8 rounded-lg space-y-8">
      <div class="text-center space-y-2.5">
        <h1 class="text-2xl md:text-3xl font-bold">Form Pendaftaran SILALAD</h1>
        <p class="text-gray-700 text-base md:text-lg">
          Silakan isi formulir di bawah ini untuk memesan layanan sedot tinja UPTD Pengelolaan Air Limbah Domestik.
        </p>
      </div>

      {{-- Stepper --}}
      <div class="mb-8">
        <div class="relative flex items-center justify-between" style="height:56px;">
          <div id="stepper-line-left"
            class="absolute left-[calc(50%/3)] right-1/2 top-1/2 transform -translate-y-1/2 h-1 bg-gray-200 z-0 transition-colors">
          </div>
          <div id="stepper-line-right"
            class="absolute left-1/2 right-[calc(50%/3)] top-1/2 transform -translate-y-1/2 h-1 bg-gray-200 z-0 transition-colors">
          </div>
          <ol id="stepper-bar" class="flex w-full z-10 relative">
            <li class="flex-1 flex flex-col items-center stepper-step stepper-step-active relative">
              <span class="flex items-center justify-center w-10 h-10 bg-brand-blue text-white rounded-full z-10">
                <i class="fa-solid fa-address-card"></i>
              </span>
            </li>
            <li class="flex-1 flex flex-col items-center stepper-step relative">
              <span class="flex items-center justify-center w-10 h-10 bg-gray-100 text-gray-500 rounded-full z-10">
                <i class="fa-solid fa-location-dot"></i>
              </span>
            </li>
            <li class="flex-1 flex flex-col items-center stepper-step relative">
              <span class="flex items-center justify-center w-10 h-10 bg-gray-100 text-gray-500 rounded-full z-10">
                <i class="fa-solid fa-paper-plane"></i>
              </span>
            </li>
          </ol>
        </div>
        <div class="flex w-full mt-2">
          <div class="flex-1 flex flex-col items-center">
            <span class="font-semibold text-brand-blue text-xs sm:text-sm text-center">Data Pelanggan</span>
          </div>
          <div class="flex-1 flex flex-col items-center">
            <span class="font-semibold text-gray-500 text-xs sm:text-sm text-center">Detail Lokasi</span>
          </div>
          <div class="flex-1 flex flex-col items-center">
            <span class="font-semibold text-gray-500 text-xs sm:text-sm text-center">Konfirmasi</span>
          </div>
        </div>
      </div>

      <form id="silaladForm" method="POST" action="{{ route('guest.silalad.store') }}" novalidate>
        @csrf

        @if ($errors->any())
          <div id="alert-form-errors" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50" role="alert">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div class="ms-3 text-sm font-medium">
              <ul class="mb-0 list-disc list-inside">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        @endif

        {{-- STEP 1: Data Pelanggan --}}
        <div class="step space-y-4" data-step="1">
          <div class="space-y-1.5">
            <label for="nama_pelanggan" class="block text-sm font-medium text-gray-900">Nama</label>
            <input type="text" id="nama_pelanggan" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}"
              class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              placeholder="Masukkan nama Anda" required>
          </div>
          <div class="space-y-1.5">
            <label for="nomor_telepon_pelanggan" class="block text-sm font-medium text-gray-900">Nomor Telepon</label>
            <input type="text" id="nomor_telepon_pelanggan" name="nomor_telepon_pelanggan" value="{{ old('nomor_telepon_pelanggan') }}"
              class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              placeholder="Contoh: 081234567890" required>
            <p class="text-sm text-gray-500">Dipakai untuk cek status pesanan Anda nanti.</p>
          </div>
          <div class="space-y-1.5">
            <label for="alamat" class="block text-sm font-medium text-gray-900">Alamat Pelanggan</label>
            <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}"
              class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              placeholder="Masukkan alamat pribadi Anda" required>
          </div>
        </div>

        {{-- STEP 2: Detail Lokasi --}}
        <div class="step hidden space-y-4" data-step="2">
          <div class="space-y-1.5">
            <label for="alamat_detail" class="block text-sm font-medium text-gray-900">Alamat</label>
            <textarea id="alamat_detail" name="alamat_detail" rows="2"
              class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              placeholder="Contoh: Jl. Merdeka No. 5, dekat Masjid Al-Ikhlas">{{ old('alamat_detail') }}</textarea>
            <p class="text-sm text-gray-500">Nama jalan dan lokasi bangunan yang ingin dilayani.</p>
          </div>

          <div class="space-y-1.5">
            <label for="layanan" class="block text-sm font-medium text-gray-900">Jenis Layanan</label>
            <select id="layanan" name="layanan"
              class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
              <option value="">-- Pilih Layanan --</option>
              <option value="sedot tinja" {{ old('layanan') == 'sedot tinja' ? 'selected' : '' }}>Sedot Lumpur Tinja</option>
              <option value="sedot lumpur" disabled>Sedot Lemak (belum tersedia)</option>
              <option value="sedot lemak" disabled>Peminjaman WC Portabel (belum tersedia)</option>
            </select>
          </div>

          <div class="space-y-1.5">
            <label for="detail_laporan" class="block text-sm font-medium text-gray-900">Detail Laporan</label>
            <textarea id="detail_laporan" name="detail_laporan" rows="2"
              class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              placeholder="Contoh: Septic tank sudah penuh dan mulai berbau">{{ old('detail_laporan') }}</textarea>
          </div>

          {{-- Tanggal yang diminta pelanggan. Wajib diisi, tapi tetap bukan
               pemesanan slot: aplikasi tidak menyimpan kuota harian maupun
               ketersediaan armada, jadi tanggal ini permintaan - bukan janji.
               Keterangan di bawahnya menegaskan itu supaya pelanggan tidak
               menganggapnya sudah pasti. --}}
          <div class="space-y-1.5">
            <label for="tanggal_diharapkan" class="block text-sm font-medium text-gray-900">Tanggal Pengerjaan</label>
            <input type="date" id="tanggal_diharapkan" name="tanggal_diharapkan" min="{{ now()->toDateString() }}"
              value="{{ old('tanggal_diharapkan') }}" required
              class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <p class="text-xs text-gray-500">Kapan Anda ingin dikerjakan? Tim kami tetap menghubungi Anda untuk
              menyepakati waktu pastinya.</p>
            @error('tanggal_diharapkan')
              <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
          </div>

          <div class="space-y-1.5">
            <label for="kabkota_id" class="block text-sm font-medium text-gray-900">Kabupaten/Kota</label>
            <select id="kabkota_id" name="kabkota_id"
              class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
              <option value="Samarinda" data-source="internal" selected>Kota Samarinda</option>
            </select>
            <p class="text-sm text-gray-500">Selain Kota Samarinda, daftar kecamatan/kelurahan diambil dari layanan wilayah pihak ketiga.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-1.5">
              <label for="kecamatan_id" class="block text-sm font-medium text-gray-900">Kecamatan</label>
              <select id="kecamatan_id" name="kecamatan_id" data-source="internal"
                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option value="" disabled selected>-- Pilih Kecamatan --</option>
                @foreach ($kecamatans as $kecamatan)
                  <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>
                    {{ $kecamatan->nama }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="space-y-1.5">
              <label for="kelurahan_id" class="block text-sm font-medium text-gray-900">Kelurahan</label>
              <select id="kelurahan_id" name="kelurahan_id" data-source="internal"
                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option value="" disabled selected>-- Pilih Kecamatan Dulu --</option>
              </select>
            </div>
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
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>

          <div id="jenis_bangunan_lainnya_div" class="space-y-1.5 hidden">
            <label for="jenis_bangunan_lainnya" class="block text-sm font-medium text-gray-900">Tuliskan Jenis Bangunan</label>
            <input type="text" id="jenis_bangunan_lainnya" name="jenis_bangunan_lainnya"
              class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              placeholder="Contoh: Gudang">
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div class="space-y-1.5">
              <label for="rt" class="block text-sm font-medium text-gray-900">RT</label>
              <input type="number" id="rt" name="rt" value="{{ old('rt') }}"
                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                placeholder="Contoh: 05" required>
            </div>
            <div class="space-y-1.5">
              <label for="nomor_bangunan" class="block text-sm font-medium text-gray-900">Nomor Rumah</label>
              <input type="number" id="nomor_bangunan" name="nomor_bangunan" value="{{ old('nomor_bangunan') }}"
                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                placeholder="Contoh: 12" required>
            </div>
          </div>

          <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-900">Titik Lokasi</label>
            <div id="map" class="w-full rounded-lg border" style="height:400px;"></div>
            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
            <p class="text-sm text-gray-500">Geser penanda atau klik peta untuk memilih titik lokasi: <span id="latText">-</span>, <span id="lngText">-</span></p>
          </div>
        </div>

        {{-- STEP 3: Konfirmasi --}}
        <div class="step hidden space-y-4" data-step="3">
          <div class="space-y-1.5">
            <label class="block text-sm font-bold text-gray-900">Rating</label>
            <p class="text-xs text-gray-600">Berikan pendapat Anda mengenai layanan ini</p>
            <div id="rating-stars" class="flex space-x-2">
              <span data-value="1" class="star">&#9734;</span>
              <span data-value="2" class="star">&#9734;</span>
              <span data-value="3" class="star">&#9734;</span>
              <span data-value="4" class="star">&#9734;</span>
              <span data-value="5" class="star">&#9734;</span>
            </div>
            <input type="hidden" name="rating" id="rating" value="{{ old('rating') }}">
          </div>

          <div class="space-y-1.5">
            <label for="kritik" class="block text-sm font-medium text-gray-900">Kritik</label>
            <textarea id="kritik" name="kritik" rows="2"
              class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              placeholder="Contoh: Admin agak lama merespons WhatsApp">{{ old('kritik') }}</textarea>
          </div>

          <div class="space-y-1.5">
            <label for="saran" class="block text-sm font-medium text-gray-900">Saran</label>
            <textarea id="saran" name="saran" rows="2"
              class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              placeholder="Contoh: Mohon tambahkan jadwal akhir pekan">{{ old('saran') }}</textarea>
          </div>

          <div class="flex items-center gap-2 pt-1">
            <input type="checkbox" id="setuju" name="setuju" value="1" {{ old('setuju') ? 'checked' : '' }}
              class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <label for="setuju" class="text-sm font-medium text-gray-900">Saya setuju jika terdapat biaya tambahan</label>
          </div>
        </div>

        {{-- Navigasi --}}
        <div class="flex justify-between mt-6">
          <button type="button" id="prevBtn"
            class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg px-4 py-2 hidden">
            <i class="fa-solid fa-arrow-left"></i> Kembali
          </button>
          <button type="button" id="nextBtn"
            class="ms-auto inline-flex items-center gap-1.5 text-sm font-semibold text-white bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue rounded-lg px-5 py-2 transition">
            Lanjut <i class="fa-solid fa-arrow-right"></i>
          </button>
          <button type="submit" id="submitBtn"
            class="ms-auto inline-flex items-center gap-1.5 text-sm font-semibold text-white bg-green-600 hover:bg-green-700 rounded-lg px-5 py-2 hidden">
            Kirim <i class="fa-solid fa-paper-plane"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('document.end')
  <style>
    .step-circle-active { background: rgb(34, 52, 104) !important; color: #fff; }
    .star { color: #d1d5db; transition: color 0.2s; font-size: 2rem; cursor: pointer; }
    .star.selected { color: #fbbf24; }
  </style>

  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Jenis bangunan "Lainnya"
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
          inputLainnya.value = "";
        }
      });

      // Kabupaten/Kota -> Kecamatan -> Kelurahan.
      // Kota Samarinda pakai data internal situs ini sendiri (akurat & cepat).
      // Kabupaten/kota lain di luar Samarinda tidak ada di data internal,
      // jadi dipakaikan API wilayah pihak ketiga sebagai sumber data.
      const WILAYAH_API = 'https://alamat.thecloudalert.com/api';
      const PROVINSI_KALTIM_ID = 15;
      const internalKecamatans = @json($kecamatans->map(fn ($k) => ['id' => $k->id, 'nama' => $k->nama]));

      const kabkotaSelect = document.getElementById("kabkota_id");
      const kecamatanSelect = document.getElementById("kecamatan_id");
      const kelurahanSelect = document.getElementById("kelurahan_id");

      function resetKelurahan(placeholder) {
        kelurahanSelect.innerHTML = `<option value="" disabled selected>${placeholder}</option>`;
      }

      function populateKecamatanInternal() {
        kecamatanSelect.dataset.source = 'internal';
        kecamatanSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kecamatan --</option>';
        internalKecamatans.forEach(k => {
          const opt = document.createElement('option');
          opt.value = k.id;
          opt.textContent = k.nama;
          kecamatanSelect.appendChild(opt);
        });
        resetKelurahan('-- Pilih Kecamatan Dulu --');
      }

      function loadKecamatanExternal(kabkotaId) {
        kecamatanSelect.dataset.source = 'external';
        kecamatanSelect.innerHTML = '<option value="" disabled selected>Memuat...</option>';
        fetch(`${WILAYAH_API}/kecamatan/get/?d_kabkota_id=${kabkotaId}`)
          .then(res => res.json())
          .then(data => {
            kecamatanSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kecamatan --</option>';
            (data.result || []).forEach(d => {
              const opt = document.createElement('option');
              opt.value = d.text; // simpan nama, bukan id API pihak ketiga
              opt.dataset.id = d.id;
              opt.textContent = d.text;
              kecamatanSelect.appendChild(opt);
            });
            resetKelurahan('-- Pilih Kecamatan Dulu --');
          })
          .catch(() => {
            kecamatanSelect.innerHTML = '<option value="" disabled selected>Gagal memuat data</option>';
          });
      }

      function loadKelurahanInternal(kecamatanId) {
        resetKelurahan('Memuat...');
        if (!kecamatanId) {
          resetKelurahan('-- Pilih Kecamatan Dulu --');
          return;
        }
        fetch(`/api/kelurahans/by-kecamatan/${kecamatanId}`)
          .then(res => res.json())
          .then(data => {
            resetKelurahan('-- Pilih Kelurahan --');
            if (data.success && data.data.length > 0) {
              data.data.forEach(k => {
                const opt = document.createElement('option');
                opt.value = k.id;
                opt.textContent = k.nama;
                kelurahanSelect.appendChild(opt);
              });
            } else {
              resetKelurahan('Tidak ada data kelurahan');
            }
          })
          .catch(() => resetKelurahan('Gagal memuat data'));
      }

      function loadKelurahanExternal(kecamatanApiId) {
        resetKelurahan('Memuat...');
        if (!kecamatanApiId) {
          resetKelurahan('-- Pilih Kecamatan Dulu --');
          return;
        }
        fetch(`${WILAYAH_API}/kelurahan/get/?d_kecamatan_id=${kecamatanApiId}`)
          .then(res => res.json())
          .then(data => {
            resetKelurahan('-- Pilih Kelurahan --');
            (data.result || []).forEach(d => {
              const opt = document.createElement('option');
              opt.value = d.text; // simpan nama, bukan id API pihak ketiga
              opt.textContent = d.text;
              kelurahanSelect.appendChild(opt);
            });
          })
          .catch(() => resetKelurahan('Gagal memuat data'));
      }

      // Muat daftar kabupaten/kota lain (Kalimantan Timur) sebagai tambahan
      // opsi "Kota Samarinda" yang sudah ada. Tidak memicu event change,
      // supaya kecamatan bawaan (internal, Samarinda) tidak ikut ter-reset.
      fetch(`${WILAYAH_API}/kabkota/get/?d_provinsi_id=${PROVINSI_KALTIM_ID}`)
        .then(res => res.json())
        .then(data => {
          (data.result || []).forEach(d => {
            if (/samarinda/i.test(d.text)) return; // sudah ada sebagai opsi bawaan
            const opt = document.createElement('option');
            opt.value = d.text;
            opt.dataset.source = 'external';
            opt.dataset.id = d.id;
            opt.textContent = d.text;
            kabkotaSelect.appendChild(opt);
          });
        })
        .catch(() => {}); // opsi Kota Samarinda tetap tersedia meski API gagal

      kabkotaSelect.addEventListener("change", function() {
        const opt = this.selectedOptions[0];
        if (opt.dataset.source === 'internal') {
          populateKecamatanInternal();
        } else {
          loadKecamatanExternal(opt.dataset.id);
        }
      });

      kecamatanSelect.addEventListener("change", function() {
        if (this.dataset.source === 'internal') {
          loadKelurahanInternal(this.value);
        } else {
          loadKelurahanExternal(this.selectedOptions[0]?.dataset.id);
        }
      });

      // Rating bintang
      const stars = document.querySelectorAll("#rating-stars .star");
      const ratingInput = document.getElementById("rating");
      stars.forEach(star => {
        star.addEventListener("click", function() {
          const value = this.getAttribute("data-value");
          ratingInput.value = value;
          stars.forEach(s => { s.innerHTML = "&#9734;"; s.classList.remove("selected"); });
          for (let i = 0; i < value; i++) {
            stars[i].innerHTML = "&#9733;";
            stars[i].classList.add("selected");
          }
        });
      });
    });

    // Peta Leaflet
    let map, marker;
    const defaultPos = [-0.502, 117.153];

    function initSilaladMap() {
      map = L.map('map').setView(defaultPos, 12);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
      }).addTo(map);

      marker = L.marker(defaultPos, { draggable: true }).addTo(map);
      updateLatLng(defaultPos[0], defaultPos[1]);

      marker.on('dragend', function() {
        const pos = marker.getLatLng();
        updateLatLng(pos.lat, pos.lng);
      });

      map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateLatLng(e.latlng.lat, e.latlng.lng);
      });
    }

    function updateLatLng(lat, lng) {
      document.getElementById('latitude').value = lat;
      document.getElementById('longitude').value = lng;
      document.getElementById('latText').innerText = lat.toFixed(6);
      document.getElementById('lngText').innerText = lng.toFixed(6);
    }

    // Stepper
    document.addEventListener("DOMContentLoaded", function() {
      let currentStep = 1;
      const steps = document.querySelectorAll('.step');
      const stepCircles = document.querySelectorAll('#stepper-bar .stepper-step span');
      const nextBtn = document.getElementById('nextBtn');
      const prevBtn = document.getElementById('prevBtn');
      const submitBtn = document.getElementById('submitBtn');
      let mapInitialized = false;

      function showStep(step) {
        steps.forEach(s => s.classList.add('hidden'));
        document.querySelector(`.step[data-step="${step}"]`).classList.remove('hidden');

        stepCircles.forEach((circle, i) => {
          circle.classList.remove('step-circle-active', 'bg-gray-100', 'text-gray-500', 'bg-brand-blue', 'text-white');
          if (i + 1 <= step) {
            circle.classList.add('bg-brand-blue', 'text-white');
          } else {
            circle.classList.add('bg-gray-100', 'text-gray-500');
          }
        });

        prevBtn.classList.toggle('hidden', step === 1);
        nextBtn.classList.toggle('hidden', step === steps.length);
        submitBtn.classList.toggle('hidden', step !== steps.length);

        if (step === 2) {
          if (!mapInitialized) {
            initSilaladMap();
            mapInitialized = true;
          }
          setTimeout(() => map.invalidateSize(), 200);
        }
      }

      nextBtn.addEventListener('click', () => { currentStep++; showStep(currentStep); });
      prevBtn.addEventListener('click', () => { currentStep--; showStep(currentStep); });
      showStep(currentStep);
    });
  </script>
@endsection
