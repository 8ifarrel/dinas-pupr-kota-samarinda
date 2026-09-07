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

    {{-- Yang bisa diisi admin: status beserta data penugasan & pelaksanaan --}}
    <div class="order-1 lg:order-2 flex flex-col gap-4">
      @php
        $inputCls = 'border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5';
      @endphp

      <div class="order-2 lg:order-1 bg-white rounded-lg shadow-lg border p-6 space-y-5">
        <div>
          <h2 class="text-base font-semibold text-gray-900">Status &amp; Penugasan</h2>
          <p class="text-sm text-gray-500">Data di bawah ini jadi isi Surat Pesanan, Surat Perintah Kerja, dan Surat
            Jalan.</p>
        </div>

        <form action="{{ route('admin.silalad.update-status', $data->id) }}" method="POST" class="space-y-5">
          @csrf
          @method('PUT')

          <div class="space-y-1.5">
            <label for="status_pengerjaan" class="block text-sm font-medium text-gray-900">Status Pengerjaan</label>
            <select id="status_pengerjaan" name="status_pengerjaan" class="{{ $inputCls }}">
              @foreach (\App\Http\Controllers\Admin\SilaladAdminController::STATUS as $status)
                <option value="{{ $status }}" {{ old('status_pengerjaan', $data->status_pengerjaan) == $status ? 'selected' : '' }}>
                  {{ $status }}
                </option>
              @endforeach
            </select>
            @error('status_pengerjaan')
              <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
          </div>

          <div class="space-y-1.5">
            <label for="keterangan" class="block text-sm font-medium text-gray-900">
              Keterangan Perubahan <span class="font-normal text-gray-500">(opsional)</span>
            </label>
            <textarea id="keterangan" name="keterangan" rows="2" class="{{ $inputCls }}"
              placeholder="Contoh: Pelanggan minta dijadwalkan ulang ke minggu depan">{{ old('keterangan') }}</textarea>
            <p class="text-xs text-gray-500">Dicatat di riwayat saat status berpindah. Bila dikosongkan, keterangannya
              diisi otomatis.</p>
            @error('keterangan')
              <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
          </div>

          {{-- ===== Survei kelayakan ===== --}}
          <div class="pt-1 border-t">
            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mt-4 mb-3">Survei Kelayakan</h3>

            <div class="space-y-4">
              <div class="space-y-1.5">
                <label for="nomor_spk" class="block text-sm font-medium text-gray-900">Nomor SPK</label>
                <div class="flex gap-2">
                  <input type="text" id="nomor_spk" name="nomor_spk" value="{{ old('nomor_spk', $data->nomor_spk) }}"
                    class="{{ $inputCls }}" placeholder="{{ $nomorSpkUsulan }}">
                  <button type="button" id="isiNomorSpk" data-usulan="{{ $nomorSpkUsulan }}"
                    class="shrink-0 inline-flex items-center gap-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg px-3">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> Isi
                  </button>
                </div>
                <p class="text-xs text-gray-500">Tombol "Isi" hanya mengusulkan
                  <code>{{ $nomorSpkUsulan }}</code>; formatnya boleh diketik bebas sesuai aturan UPTD.
                </p>
                @error('nomor_spk')
                  <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                  <label for="jarak_tangki" class="block text-sm font-medium text-gray-900">Jarak Tangki (meter)</label>
                  <input type="number" min="0" id="jarak_tangki" name="jarak_tangki"
                    value="{{ old('jarak_tangki', $data->jarak_tangki) }}" class="{{ $inputCls }}" placeholder="Contoh: 15">
                  @error('jarak_tangki')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                  @enderror
                </div>
                <div class="space-y-1.5">
                  <label for="bisa_disedot" class="block text-sm font-medium text-gray-900">Bisa Disedot?</label>
                  @php $bisa = old('bisa_disedot', $data->bisa_disedot === null ? '' : (int) $data->bisa_disedot); @endphp
                  <select id="bisa_disedot" name="bisa_disedot" class="{{ $inputCls }}">
                    <option value="" {{ $bisa === '' ? 'selected' : '' }}>-- Belum disurvei --</option>
                    <option value="1" {{ $bisa === 1 || $bisa === '1' ? 'selected' : '' }}>Ya</option>
                    <option value="0" {{ $bisa === 0 || $bisa === '0' ? 'selected' : '' }}>Tidak</option>
                  </select>
                  @error('bisa_disedot')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="space-y-1.5">
                <label for="tanggal_pesanan" class="block text-sm font-medium text-gray-900">Tanggal Surat Pesanan</label>
                <input type="date" id="tanggal_pesanan" name="tanggal_pesanan"
                  value="{{ old('tanggal_pesanan', optional($data->tanggal_pesanan)->format('Y-m-d')) }}" class="{{ $inputCls }}">
                @error('tanggal_pesanan')
                  <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>

          {{-- ===== Penugasan ===== --}}
          <div class="pt-1 border-t">
            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mt-4 mb-1">Penugasan</h3>
            <p class="text-xs text-gray-500 mb-3">Wajib diisi bila status diubah jadi "Sedang dikerjakan".</p>

            <div class="space-y-4">
              <div class="space-y-1.5">
                <label for="nama_operator" class="block text-sm font-medium text-gray-900">Nama Operator / Sopir</label>
                <input type="text" id="nama_operator" name="nama_operator"
                  value="{{ old('nama_operator', $data->nama_operator) }}" class="{{ $inputCls }}"
                  placeholder="Contoh: Budi Santoso">
                @error('nama_operator')
                  <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                  <label for="nomor_kendaraan" class="block text-sm font-medium text-gray-900">Nomor Kendaraan</label>
                  <input type="text" id="nomor_kendaraan" name="nomor_kendaraan"
                    value="{{ old('nomor_kendaraan', $data->nomor_kendaraan) }}" class="{{ $inputCls }}"
                    placeholder="Contoh: KT 8123 AB">
                  @error('nomor_kendaraan')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                  @enderror
                </div>
                <div class="space-y-1.5">
                  <label for="kapasitas_kendaraan" class="block text-sm font-medium text-gray-900">Kapasitas</label>
                  <input type="text" id="kapasitas_kendaraan" name="kapasitas_kendaraan"
                    value="{{ old('kapasitas_kendaraan', $data->kapasitas_kendaraan) }}" class="{{ $inputCls }}"
                    placeholder="Contoh: 4.000 liter">
                  @error('kapasitas_kendaraan')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="space-y-1.5">
                <label for="tanggal_perintah" class="block text-sm font-medium text-gray-900">Tanggal Perintah Kerja</label>
                <input type="date" id="tanggal_perintah" name="tanggal_perintah"
                  value="{{ old('tanggal_perintah', optional($data->tanggal_perintah)->format('Y-m-d')) }}" class="{{ $inputCls }}">
                @error('tanggal_perintah')
                  <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>

          {{-- ===== Pelaksanaan ===== --}}
          <div class="pt-1 border-t">
            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mt-4 mb-1">Pelaksanaan</h3>
            <p class="text-xs text-gray-500 mb-3">Jumlah rit wajib diisi bila status diubah jadi "Sudah dikerjakan",
              karena jadi dasar penagihan.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="space-y-1.5">
                <label for="jumlah_rit" class="block text-sm font-medium text-gray-900">Jumlah Rit</label>
                <input type="number" min="1" id="jumlah_rit" name="jumlah_rit"
                  value="{{ old('jumlah_rit', $data->jumlah_rit) }}" class="{{ $inputCls }}" placeholder="Contoh: 1">
                @error('jumlah_rit')
                  <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
              </div>
              <div class="space-y-1.5">
                <label for="tanggal_jalan" class="block text-sm font-medium text-gray-900">Tanggal Pengerjaan</label>
                <input type="date" id="tanggal_jalan" name="tanggal_jalan"
                  value="{{ old('tanggal_jalan', optional($data->tanggal_jalan)->format('Y-m-d')) }}" class="{{ $inputCls }}">
                @error('tanggal_jalan')
                  <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>

          {{-- ===== Pembatalan ===== --}}
          <div class="pt-1 border-t">
            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mt-4 mb-3">Pembatalan</h3>
            <div class="space-y-1.5">
              <label for="alasan_batal" class="block text-sm font-medium text-gray-900">Alasan Pembatalan</label>
              <textarea id="alasan_batal" name="alasan_batal" rows="2" class="{{ $inputCls }}"
                placeholder="Contoh: Tangki septik tidak bisa dijangkau selang">{{ old('alasan_batal', $data->alasan_batal) }}</textarea>
              <p class="text-xs text-gray-500">Wajib diisi bila status diubah jadi "Dibatalkan".</p>
              @error('alasan_batal')
                <p class="text-red-600 text-sm">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="flex items-center gap-3 pt-2 border-t">
            <button type="submit"
              class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-white bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue rounded-lg px-5 py-2.5 transition">
              <i class="fa-solid fa-floppy-disk"></i> Simpan
            </button>
            <a href="{{ $routeBatal }}"
              class="mt-4 inline-flex items-center text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg px-5 py-2.5">
              Batal
            </a>
          </div>
        </form>
      </div>

      {{-- Riwayat status: tidak pernah ditimpa, tiap perpindahan jadi baris baru --}}
      <div class="order-3 bg-white rounded-lg shadow-lg border p-6 space-y-4">
        <div>
          <h2 class="text-base font-semibold text-gray-900">Riwayat Status</h2>
          <p class="text-sm text-gray-500">Perjalanan pesanan ini dari awal masuk.</p>
        </div>

        <ol class="relative border-s border-gray-200 ms-2">
          @foreach ($riwayat as $jejak)
            @php
              $titik = match ($jejak->status) {
                  'Belum dikerjakan' => 'bg-yellow-400',
                  'Sedang dikerjakan' => 'bg-blue-500',
                  'Dibatalkan' => 'bg-red-500',
                  default => 'bg-green-500',
              };
            @endphp
            <li class="mb-5 ms-5 last:mb-0">
              <span class="absolute w-3 h-3 rounded-full mt-1.5 -start-1.5 border border-white {{ $titik }}"></span>
              <p class="text-sm font-semibold text-gray-900">{{ $jejak->status }}</p>
              <time class="block text-xs text-gray-500 mb-1">
                {{ $jejak->created_at->translatedFormat('d F Y, H:i') }} WITA
              </time>
              @if ($jejak->keterangan)
                <p class="text-sm text-gray-600">{{ $jejak->keterangan }}</p>
              @endif
            </li>
          @endforeach
        </ol>
      </div>

      {{-- Cetak: surat yang belum memenuhi syarat tampil nonaktif beserta alasannya --}}
      <div class="order-1 lg:order-4 bg-white rounded-lg shadow-lg border p-6 space-y-3">
        <div>
          <h2 class="text-base font-semibold text-gray-900">Cetak Dokumen</h2>
        </div>

        @php
          $btnAktif = 'inline-flex items-center gap-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg px-5 py-2.5 w-full';
          $btnMati = 'inline-flex items-center gap-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg px-5 py-2.5 w-full cursor-not-allowed';
          $spkSiap = $data->status_pengerjaan !== 'Belum dikerjakan' && $data->nama_operator;
          $jalanSiap = $data->status_pengerjaan === 'Sudah dikerjakan';
        @endphp

        <a href="{{ route('admin.silalad.print', $data->id) }}" class="{{ $btnAktif }}">
          <i class="fa-solid fa-receipt w-4"></i> Bukti Pesanan
        </a>

        <a href="{{ route('admin.silalad.surat-pesanan', $data->id) }}" class="{{ $btnAktif }}">
          <i class="fa-solid fa-file-signature w-4"></i> Surat Pesanan
        </a>

        @if ($spkSiap)
          <a href="{{ route('admin.silalad.surat-perintah-kerja', $data->id) }}" class="{{ $btnAktif }}">
            <i class="fa-solid fa-clipboard-check w-4"></i> Surat Perintah Kerja
          </a>
        @else
          <div>
            <span class="{{ $btnMati }}"><i class="fa-solid fa-lock w-4"></i> Surat Perintah Kerja</span>
            <p class="text-xs text-gray-500 mt-1">Tersedia setelah operator ditugaskan dan status bukan lagi "Belum
              dikerjakan".</p>
          </div>
        @endif

        @if ($jalanSiap)
          <a href="{{ route('admin.silalad.surat-jalan', $data->id) }}" class="{{ $btnAktif }}">
            <i class="fa-solid fa-truck-fast w-4"></i> Surat Jalan
          </a>
        @else
          <div>
            <span class="{{ $btnMati }}"><i class="fa-solid fa-lock w-4"></i> Surat Jalan</span>
            <p class="text-xs text-gray-500 mt-1">Tersedia setelah status jadi "Sudah dikerjakan".</p>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection

@section('document.end')
  {{-- Tombol "Isi" pada Nomor SPK: sekadar mengisikan usulan dari server,
       nilainya tetap bisa diketik ulang admin. --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const tombol = document.getElementById('isiNomorSpk');
      const kotak = document.getElementById('nomor_spk');
      if (!tombol || !kotak) return;

      tombol.addEventListener('click', function() {
        kotak.value = tombol.dataset.usulan || '';
        kotak.focus();
      });
    });
  </script>

  @if ($data->latitude && $data->longitude)
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
  @endif
@endsection
