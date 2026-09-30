{{--
  Form tambah/edit satu catatan pemeriksaan berkala. Dipakai bersama oleh
  create.blade.php dan edit.blade.php - hanya action & tombol submit yang
  berbeda, jadi cukup satu berkas. Skrip pendukungnya ada di
  _form-script.blade.php, di-include lewat @section('document.end') masing-
  masing pemanggil.

  Butuh dari pemanggil: $pemeriksaan (model, baru atau lama), $daftar_kecamatan,
  $daftar_kelurahan, $status_aliran_label, $ruas_saluran_label.
--}}
@php
  $inputCls = 'block w-full p-2 border border-gray-300 rounded-md text-sm';
  $labelCls = 'block text-sm font-medium text-gray-700 mb-1';
  $old = fn ($field, $default = null) => old($field, data_get($pemeriksaan, $field, $default));
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
  <div class="md:col-span-2">
    <label for="tanggal_pemeriksaan" class="{{ $labelCls }}">Tanggal Pemeriksaan</label>
    <input type="date" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan"
      value="{{ $old('tanggal_pemeriksaan') instanceof \Carbon\Carbon ? $old('tanggal_pemeriksaan')->format('Y-m-d') : $old('tanggal_pemeriksaan') }}"
      class="{{ $inputCls }} md:w-1/2" required>
    @error('tanggal_pemeriksaan')
      <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label for="pb__kecamatan" class="{{ $labelCls }}">Kecamatan</label>
    <select name="kecamatan_id" id="pb__kecamatan" class="{{ $inputCls }}" required
      data-initial-kelurahan="{{ $old('kelurahan_id') }}" data-initial-nama-jalan="{{ $old('nama_jalan') }}">
      <option value="" {{ $old('kecamatan_id') ? '' : 'selected' }} disabled>-- Pilih kecamatan --</option>
      @foreach ($daftar_kecamatan as $kec)
        <option value="{{ $kec->id }}" {{ (string) $old('kecamatan_id') === (string) $kec->id ? 'selected' : '' }}>
          {{ $kec->nama }}
        </option>
      @endforeach
    </select>
    @error('kecamatan_id')
      <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label for="pb__kelurahan" class="{{ $labelCls }}">Kelurahan</label>
    <select name="kelurahan_id" id="pb__kelurahan" class="{{ $inputCls }} disabled:bg-gray-100" disabled>
      <option value="" selected disabled>Pilih kecamatan terlebih dahulu</option>
      {{-- Seluruh kelurahan ditaruh di sini sekali saja; skrip pendukung
           menyaring ulang sesuai kecamatan yang aktif. --}}
      @foreach ($daftar_kelurahan as $kel)
        <option value="{{ $kel->id }}" data-kecamatan="{{ $kel->kecamatan_id }}">{{ $kel->nama }}</option>
      @endforeach
    </select>
    @error('kelurahan_id')
      <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label for="pb__nama_jalan" class="{{ $labelCls }}">Nama Jalan</label>
    <div class="relative">
      <input type="search" name="nama_jalan" id="pb__nama_jalan" value="{{ $old('nama_jalan') }}"
        class="{{ $inputCls }} disabled:bg-gray-100" placeholder="Pilih kelurahan terlebih dahulu" autocomplete="off"
        disabled required>
      <ul id="pb__nama_jalan_autocomplete"
        class="absolute z-20 bg-white border border-gray-300 rounded-lg mt-1 w-full hidden max-h-48 overflow-y-auto text-sm"></ul>
    </div>
    <p class="text-xs text-gray-400 mt-1">Ketik untuk mencari nama jalan pada kelurahan terpilih.</p>
    @error('nama_jalan')
      <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label for="nama_ruas_saluran" class="{{ $labelCls }}">Nama Ruas Saluran</label>
    <select name="nama_ruas_saluran" id="nama_ruas_saluran" class="{{ $inputCls }}" required>
      <option value="" disabled {{ $old('nama_ruas_saluran') ? '' : 'selected' }}>-- Pilih ruas saluran --</option>
      @foreach ($ruas_saluran_label as $value => $label)
        <option value="{{ $value }}" @selected($old('nama_ruas_saluran') === $value)>{{ $label }}</option>
      @endforeach
    </select>
    @error('nama_ruas_saluran')
      <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label for="dimensi_lebar_m" class="{{ $labelCls }}">Dimensi Eksisting &mdash; Lebar (m)</label>
    <input type="number" step="0.01" min="0.01" name="dimensi_lebar_m" id="dimensi_lebar_m"
      value="{{ $old('dimensi_lebar_m') }}" placeholder="Contoh: 2.0" class="{{ $inputCls }}" required>
    @error('dimensi_lebar_m')
      <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label for="dimensi_tinggi_m" class="{{ $labelCls }}">Dimensi Eksisting &mdash; Tinggi (m)</label>
    <input type="number" step="0.01" min="0.01" name="dimensi_tinggi_m" id="dimensi_tinggi_m"
      value="{{ $old('dimensi_tinggi_m') }}" placeholder="Contoh: 1.5" class="{{ $inputCls }}" required>
    @error('dimensi_tinggi_m')
      <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div class="md:col-span-2">
    <label for="kondisi_fisik_struktur" class="{{ $labelCls }}">Kondisi Fisik Struktur (Dinding/Lantai)</label>
    <textarea name="kondisi_fisik_struktur" id="kondisi_fisik_struktur" rows="2" class="{{ $inputCls }}"
      placeholder="Contoh: Baik, ada retak rambut sepanjang 2 meter" required>{{ $old('kondisi_fisik_struktur') }}</textarea>
    @error('kondisi_fisik_struktur')
      <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label for="tingkat_sedimentasi_sampah_cm" class="{{ $labelCls }}">Tingkat Sedimentasi &amp; Sampah (cm)</label>
    <input type="number" step="0.1" min="0" name="tingkat_sedimentasi_sampah_cm"
      id="tingkat_sedimentasi_sampah_cm" value="{{ $old('tingkat_sedimentasi_sampah_cm') }}"
      placeholder="Contoh: 30" class="{{ $inputCls }}" required>
    <p class="text-xs text-gray-500 mt-1" id="pb__sedimentasi_hasil">
      @if ($pemeriksaan->persen_sedimentasi !== null)
        Persentase terhadap tinggi eksisting: <b>{{ $pemeriksaan->persen_sedimentasi }}%</b>
        ({{ \App\Models\HantuBanyuPemeriksaanBerkala::KATEGORI_SEDIMENTASI_LABEL[$pemeriksaan->kategori_sedimentasi] }})
      @else
        Isi tinggi eksisting &amp; sedimentasi untuk melihat persentase &amp; kategorinya secara otomatis.
      @endif
    </p>
    @error('tingkat_sedimentasi_sampah_cm')
      <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label for="status_aliran_air" class="{{ $labelCls }}">Status Aliran Air</label>
    <select name="status_aliran_air" id="status_aliran_air" class="{{ $inputCls }}" required>
      <option value="" disabled {{ $old('status_aliran_air') ? '' : 'selected' }}>-- Pilih status --</option>
      @foreach ($status_aliran_label as $value => $label)
        <option value="{{ $value }}" @selected($old('status_aliran_air') === $value)>{{ $label }}</option>
      @endforeach
    </select>
    @error('status_aliran_air')
      <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div class="md:col-span-2">
    <label for="tindakan_pemeliharaan" class="{{ $labelCls }}">Tindakan Pemeliharaan yang Dilakukan</label>
    <textarea name="tindakan_pemeliharaan" id="tindakan_pemeliharaan" rows="2" class="{{ $inputCls }}"
      placeholder="Contoh: Pengerukan lumpur manual oleh Satgas" required>{{ $old('tindakan_pemeliharaan') }}</textarea>
    @error('tindakan_pemeliharaan')
      <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div class="md:col-span-2">
    <label for="hambatan_kendala" class="{{ $labelCls }}">Hambatan / Kendala Lapangan</label>
    <textarea name="hambatan_kendala" id="hambatan_kendala" rows="2" class="{{ $inputCls }}"
      placeholder="Contoh: Akses alat berat terhalang utilitas pipa" required>{{ $old('hambatan_kendala') }}</textarea>
    @error('hambatan_kendala')
      <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div class="md:col-span-2">
    <label for="rekomendasi_tindak_lanjut" class="{{ $labelCls }}">Rekomendasi / Tindak Lanjut</label>
    <textarea name="rekomendasi_tindak_lanjut" id="rekomendasi_tindak_lanjut" rows="2" class="{{ $inputCls }}"
      placeholder="Contoh: Jadwalkan pengerukan menggunakan mini ekskavator bulan depan" required>{{ $old('rekomendasi_tindak_lanjut') }}</textarea>
    @error('rekomendasi_tindak_lanjut')
      <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>
</div>
