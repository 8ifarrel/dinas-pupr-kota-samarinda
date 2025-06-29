@extends('admin.layouts.susunan-organisasi')

@section('css')
  <link href="https://unpkg.com/trix/dist/trix.css" rel="stylesheet" />
  <style>
    trix-toolbar .trix-button-group--file-tools {
      display: none;
    }

    trix-toolbar .trix-button--icon-quote {
      display: none;
    }

    trix-toolbar .trix-button--icon-code {
      display: none;
    }

    trix-editor {
      height: 270px !important;
      overflow-y: auto;
    }

    trix-editor h1 {
      font-size: 1.25rem !important;
      line-height: 1.25rem !important;
      margin-bottom: 1rem;
      font-weight: 600;
    }

    trix-editor a:not(.no-underline) {
      text-decoration: underline;
    }

    trix-editor a:visited {
      color: blue;
    }

    trix-editor ul {
      list-style-type: disc !important;
      margin-left: 1rem !important;
    }

    trix-editor ol {
      list-style-type: decimal !important;
      margin-left: 1rem !important;
    }
  </style>
@endsection

@section('slot')
  {{-- Error message --}}
  @if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.susunan-organisasi.store') }}" method="POST">
    @csrf

    <div class="mb-4">
      <label for="kelompok_susunan_organisasi" class="block text-sm font-medium text-gray-700">Kelompok Susunan Organisasi</label>
      <select name="kelompok_susunan_organisasi" id="kelompok_susunan_organisasi" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
        required>
        <option value="" selected disabled>-- Pilih Kelompok Susunan Organisasi --</option>
        <option value="Sekretariat">Sekretariat</option>
        <option value="Bidang">Bidang</option>
        <option value="UPTD">UPTD</option>
      </select>
    </div>

    <div class="mb-1">
      <label for="nama_susunan_organisasi" class="block text-sm font-medium text-gray-700">Nama Susunan Organisasi</label>
      <input type="text" name="nama_susunan_organisasi" id="nama_susunan_organisasi" value="{{ old('nama_susunan_organisasi') }}"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
    </div>

    <div class="ms-1 mb-4 flex gap-6">
      <div>
        <input type="checkbox" id="is_subbagian" name="is_subbagian" value="1"
          {{ old('is_subbagian') ? 'checked' : '' }}>
        <label for="is_subbagian" class="text-sm font-medium text-gray-700">Subbagian</label>
      </div>
      <div>
        <input type="checkbox" id="is_jabatan_fungsional" name="is_jabatan_fungsional" value="1"
          {{ old('is_jabatan_fungsional') ? 'checked' : '' }}>
        <label for="is_jabatan_fungsional" class="text-sm font-medium text-gray-700">Jabatan Fungsional</label>
      </div>
    </div>

    <div class="mb-4" id="subbagian_parent_group" style="display: none;">
      <label for="subbagian_parent" class="block text-sm font-medium text-gray-700">Subbagian dari</label>
      <select name="subbagian_parent" id="subbagian_parent"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        <option value="" disabled selected>-- Pilih Jabatan Induk --</option>
        @foreach ($susunan_organisasi_list ?? [] as $susunan_organisasi)
          @if (
              (in_array($susunan_organisasi->kelompok_susunan_organisasi, ['Bidang', 'UPTD']) &&
                  (empty($susunan_organisasi->id_susunan_organisasi_parent) || $susunan_organisasi->id_susunan_organisasi_parent == 0 || $susunan_organisasi->id_susunan_organisasi_parent == 1)) ||
                  ($susunan_organisasi->kelompok_susunan_organisasi == 'Sekretariat' &&
                      (empty($susunan_organisasi->id_susunan_organisasi_parent) ||
                          $susunan_organisasi->id_susunan_organisasi_parent == 0 ||
                          $susunan_organisasi->id_susunan_organisasi_parent == 1)))
            <option value="{{ $susunan_organisasi->id_susunan_organisasi }}" data-kelompok="{{ $susunan_organisasi->kelompok_susunan_organisasi }}">
              {{ $susunan_organisasi->nama_susunan_organisasi }}
            </option>
          @endif
        @endforeach
      </select>
    </div>

    <div class="mb-4" id="fungsional_parent_group" style="display: none;">
      <label for="fungsional_parent" class="block text-sm font-medium text-gray-700">Jabatan Fungsional dari</label>
      <select name="fungsional_parent" id="fungsional_parent"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        <option value="" disabled selected>-- Pilih Susunan Organisasi Induk --</option>
        @foreach ($susunan_organisasi_list ?? [] as $susunan_organisasi)
          @if (
              (in_array($susunan_organisasi->kelompok_susunan_organisasi, ['Bidang', 'UPTD']) &&
                  (empty($susunan_organisasi->id_susunan_organisasi_parent) || $susunan_organisasi->id_susunan_organisasi_parent == 0 || $susunan_organisasi->id_susunan_organisasi_parent == 1)) ||
                  ($susunan_organisasi->kelompok_susunan_organisasi == 'Sekretariat' &&
                      (empty($susunan_organisasi->id_susunan_organisasi_parent) ||
                          $susunan_organisasi->id_susunan_organisasi_parent == 0 ||
                          $susunan_organisasi->id_susunan_organisasi_parent == 1)))
            <option value="{{ $susunan_organisasi->id_susunan_organisasi }}" data-kelompok="{{ $susunan_organisasi->kelompok_susunan_organisasi }}">
              {{ $susunan_organisasi->nama_susunan_organisasi }}
            </option>
          @endif
        @endforeach
      </select>
    </div>

    <div class="mb-4">
      <label for="deskripsi_susunan_organisasi" class="block text-sm font-medium text-gray-700">Deskripsi Susunan Organisasi</label>
      <textarea name="deskripsi_susunan_organisasi" id="deskripsi_susunan_organisasi"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md">{{ old('deskripsi_susunan_organisasi') }}</textarea>
    </div>

    <div class="mb-4">
      <label for="tupoksi_susunan_organisasi" class="block text-sm font-medium text-gray-700">Tupoksi Susunan Organisasi</label>
      <input id="tupoksi_susunan_organisasi" type="hidden" name="tupoksi_susunan_organisasi" value="{{ old('tupoksi_susunan_organisasi') }}">
      <trix-editor input="tupoksi_susunan_organisasi"></trix-editor>
    </div>

    <div class="mb-4">
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
    </div>
  </form>
@endsection

@section('js')
  <script src="https://unpkg.com/trix/dist/trix.umd.min.js"></script>
  <script>
    function toggleParentDropdowns() {
      const isSubbagian = document.getElementById('is_subbagian').checked;
      const isFungsional = document.getElementById('is_jabatan_fungsional').checked;
      document.getElementById('subbagian_parent_group').style.display = isSubbagian ? 'block' : 'none';
      document.getElementById('fungsional_parent_group').style.display = isFungsional ? 'block' : 'none';
    }

    function filterParentOptions() {
      const kelompok = document.getElementById('kelompok_susunan_organisasi').value;
      ['subbagian_parent', 'fungsional_parent'].forEach(function(selectId) {
        const select = document.getElementById(selectId);
        if (!select) return;
        Array.from(select.options).forEach(function(opt) {
          if (!opt.value) return;
          if (kelompok === 'Sekretariat') {
            opt.style.display = (opt.getAttribute('data-kelompok') === 'Sekretariat') ? '' : 'none';
          } else {
            opt.style.display = (opt.getAttribute('data-kelompok') === kelompok) ? '' : 'none';
          }
        });
        if (select.selectedIndex > 0 && select.options[select.selectedIndex].style.display === 'none') {
          select.selectedIndex = 0;
        }
      });
    }

    document.getElementById('is_subbagian').addEventListener('change', function() {
      if (this.checked) {
        document.getElementById('is_jabatan_fungsional').checked = false;
      }
      toggleParentDropdowns();
    });
    document.getElementById('is_jabatan_fungsional').addEventListener('change', function() {
      if (this.checked) {
        document.getElementById('is_subbagian').checked = false;
      }
      toggleParentDropdowns();
    });

    document.getElementById('kelompok_susunan_organisasi').addEventListener('change', function() {
      filterParentOptions();
    });

    toggleParentDropdowns();
    filterParentOptions();
  </script>
@endsection