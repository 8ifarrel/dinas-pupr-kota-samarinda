@extends('admin.layouts.jabatan')

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
  <form action="{{ route('admin.jabatan.store') }}" method="POST">
    @csrf

    <div class="mb-4">
      <label for="kelompok_jabatan" class="block text-sm font-medium text-gray-700">Kelompok Jabatan</label>
      <select name="kelompok_jabatan" id="kelompok_jabatan" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
        required>
        <option value="" selected disabled>-- Pilih Kelompok Jabatan --</option>
        <option value="Sekretariat">Sekretariat</option>
        <option value="Bidang">Bidang</option>
        <option value="UPTD">UPTD</option>
      </select>
    </div>

    <div class="mb-1">
      <label for="nama_jabatan" class="block text-sm font-medium text-gray-700">Nama Jabatan</label>
      <input type="text" name="nama_jabatan" id="nama_jabatan" value="{{ old('nama_jabatan') }}"
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
        @foreach ($jabatanList ?? [] as $jabatan)
          @if (
              (in_array($jabatan->kelompok_jabatan, ['Bidang', 'UPTD']) &&
                  (empty($jabatan->id_jabatan_parent) || $jabatan->id_jabatan_parent == 0 || $jabatan->id_jabatan_parent == 1)) ||
                  ($jabatan->kelompok_jabatan == 'Sekretariat' &&
                      (empty($jabatan->id_jabatan_parent) ||
                          $jabatan->id_jabatan_parent == 0 ||
                          $jabatan->id_jabatan_parent == 1)))
            <option value="{{ $jabatan->id_jabatan }}" data-kelompok="{{ $jabatan->kelompok_jabatan }}">
              {{ $jabatan->nama_jabatan }}
            </option>
          @endif
        @endforeach
      </select>
    </div>

    <div class="mb-4" id="fungsional_parent_group" style="display: none;">
      <label for="fungsional_parent" class="block text-sm font-medium text-gray-700">Jabatan Fungsional dari</label>
      <select name="fungsional_parent" id="fungsional_parent"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        <option value="" disabled selected>-- Pilih Jabatan Induk --</option>
        @foreach ($jabatanList ?? [] as $jabatan)
          @if (
              (in_array($jabatan->kelompok_jabatan, ['Bidang', 'UPTD']) &&
                  (empty($jabatan->id_jabatan_parent) || $jabatan->id_jabatan_parent == 0 || $jabatan->id_jabatan_parent == 1)) ||
                  ($jabatan->kelompok_jabatan == 'Sekretariat' &&
                      (empty($jabatan->id_jabatan_parent) ||
                          $jabatan->id_jabatan_parent == 0 ||
                          $jabatan->id_jabatan_parent == 1)))
            <option value="{{ $jabatan->id_jabatan }}" data-kelompok="{{ $jabatan->kelompok_jabatan }}">
              {{ $jabatan->nama_jabatan }}
            </option>
          @endif
        @endforeach
      </select>
    </div>

    <div class="mb-4">
      <label for="deskripsi_jabatan" class="block text-sm font-medium text-gray-700">Deskripsi Jabatan</label>
      <textarea name="deskripsi_jabatan" id="deskripsi_jabatan"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md">{{ old('deskripsi_jabatan') }}</textarea>
    </div>

    <div class="mb-4">
      <label for="tupoksi_jabatan" class="block text-sm font-medium text-gray-700">Tupoksi Jabatan</label>
      <input id="tupoksi_jabatan" type="hidden" name="tupoksi_jabatan" value="{{ old('tupoksi_jabatan') }}">
      <trix-editor input="tupoksi_jabatan"></trix-editor>
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
      const kelompok = document.getElementById('kelompok_jabatan').value;
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

    document.getElementById('kelompok_jabatan').addEventListener('change', function() {
      filterParentOptions();
    });

    toggleParentDropdowns();
    filterParentOptions();
  </script>
@endsection
