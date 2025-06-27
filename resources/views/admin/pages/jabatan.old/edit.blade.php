@extends('admin.layouts.jabatan')

@section('css')
  {{-- <link href="https://unpkg.com/trix/dist/trix.css" rel="stylesheet"/> --}}
  {{-- <style>
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
            list-style-type: disc !important; margin-left: 1rem !important; 
        }
        trix-editor ol { 
            list-style-type: decimal !important; margin-left: 1rem !important; 
        }
    </style> --}}
@endsection

@section('slot')
  <form action="{{ route('admin.jabatan.update', $jabatan->id_jabatan) }}" method="POST">
    @csrf
    @method('POST')

    <div class="mb-4">
      <label for="kelompok_jabatan" class="block text-sm font-medium text-gray-700">Kelompok Jabatan</label>
      <select name="kelompok_jabatan" id="kelompok_jabatan" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        <option value="" disabled>-- Pilih Kelompok Jabatan --</option>
        <option value="Sekretariat" {{ $jabatan->kelompok_jabatan == 'Sekretariat' ? 'selected' : '' }}>Sekretariat</option>
        <option value="Bidang" {{ $jabatan->kelompok_jabatan == 'Bidang' ? 'selected' : '' }}>Bidang</option>
        <option value="UPTD" {{ $jabatan->kelompok_jabatan == 'UPTD' ? 'selected' : '' }}>UPTD</option>
      </select>
    </div>

    <div class="mb-1">
      <label for="nama_jabatan" class="block text-sm font-medium text-gray-700">Nama Jabatan</label>
      <input type="text" name="nama_jabatan" id="nama_jabatan" value="{{ $jabatan->nama_jabatan }}"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
    </div>

    @if($jabatan->id_jabatan_parent != 0 && $jabatan->id_jabatan_parent != 1)
    <div class="ms-1 mb-4 flex gap-6">
      <div>
        <input type="checkbox" id="is_subbagian" name="is_subbagian" value="1"
          {{ $jabatan->is_subbagian ? 'checked' : '' }}>
        <label for="is_subbagian" class="text-sm font-medium text-gray-700">Subbagian</label>
      </div>
      <div>
        <input type="checkbox" id="is_jabatan_fungsional" name="is_jabatan_fungsional" value="1"
          {{ $jabatan->is_jabatan_fungsional ? 'checked' : '' }}>
        <label for="is_jabatan_fungsional" class="text-sm font-medium text-gray-700">Jabatan Fungsional</label>
      </div>
    </div>
    @endif

    @if($jabatan->id_jabatan_parent != 0 && $jabatan->id_jabatan_parent != 1)
    <div class="mb-4" id="subbagian_parent_group" style="display: none;">
      <label for="subbagian_parent" class="block text-sm font-medium text-gray-700">Subbagian dari</label>
      <select name="subbagian_parent" id="subbagian_parent"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        <option value="" disabled {{ !$jabatan->is_subbagian ? 'selected' : '' }}>-- Pilih Jabatan Induk --</option>
        @foreach ($jabatanList ?? [] as $item)
          @if (
            (in_array($item->kelompok_jabatan, ['Bidang', 'UPTD']) &&
                (empty($item->id_jabatan_parent) || $item->id_jabatan_parent == 0 || $item->id_jabatan_parent == 1)) ||
            ($item->kelompok_jabatan == 'Sekretariat' &&
                (empty($item->id_jabatan_parent) ||
                    $item->id_jabatan_parent == 0 ||
                    $item->id_jabatan_parent == 1))
          )
            @if($item->id_jabatan != $jabatan->id_jabatan)
              <option value="{{ $item->id_jabatan }}" data-kelompok="{{ $item->kelompok_jabatan }}"
                {{ ($jabatan->is_subbagian && $jabatan->id_jabatan_parent == $item->id_jabatan) ? 'selected' : '' }}>
                {{ $item->nama_jabatan }}
              </option>
            @endif
          @endif
        @endforeach
      </select>
    </div>

    <div class="mb-4" id="fungsional_parent_group" style="display: none;">
      <label for="fungsional_parent" class="block text-sm font-medium text-gray-700">Jabatan Fungsional dari</label>
      <select name="fungsional_parent" id="fungsional_parent"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        <option value="" disabled {{ !$jabatan->is_jabatan_fungsional ? 'selected' : '' }}>-- Pilih Jabatan Induk --</option>
        @foreach ($jabatanList ?? [] as $item)
          @if (
            (in_array($item->kelompok_jabatan, ['Bidang', 'UPTD']) &&
                (empty($item->id_jabatan_parent) || $item->id_jabatan_parent == 0 || $item->id_jabatan_parent == 1)) ||
            ($item->kelompok_jabatan == 'Sekretariat' &&
                (empty($item->id_jabatan_parent) ||
                    $item->id_jabatan_parent == 0 ||
                    $item->id_jabatan_parent == 1))
          )
            @if($item->id_jabatan != $jabatan->id_jabatan)
              <option value="{{ $item->id_jabatan }}" data-kelompok="{{ $item->kelompok_jabatan }}"
                {{ ($jabatan->is_jabatan_fungsional && $jabatan->id_jabatan_parent == $item->id_jabatan) ? 'selected' : '' }}>
                {{ $item->nama_jabatan }}
              </option>
            @endif
          @endif
        @endforeach
      </select>
    </div>
    @endif

    <div class="mb-4">
      <label for="deskripsi_jabatan" class="block text-sm font-medium text-gray-700">Deskripsi Jabatan</label>
      <textarea name="deskripsi_jabatan" id="deskripsi_jabatan"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md">{{ $jabatan->deskripsi_jabatan }}</textarea>
    </div>

    {{-- <div class="mb-4">
      <label for="tupoksi_jabatan" class="block text-sm font-medium text-gray-700">Tupoksi Jabatan</label>
      <input id="tupoksi_jabatan" type="hidden" name="tupoksi_jabatan" value="{{ $jabatan->tupoksi_jabatan }}">
      <trix-editor input="tupoksi_jabatan"></trix-editor>
    </div> --}}

    <div class="mb-4">
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Perbarui</button>
    </div>
  </form>
@endsection

@section('js')
  <script>
    function toggleParentDropdowns() {
      @if($jabatan->id_jabatan_parent != 0 && $jabatan->id_jabatan_parent != 1)
      const isSubbagian = document.getElementById('is_subbagian').checked;
      const isFungsional = document.getElementById('is_jabatan_fungsional').checked;
      document.getElementById('subbagian_parent_group').style.display = isSubbagian ? 'block' : 'none';
      document.getElementById('fungsional_parent_group').style.display = isFungsional ? 'block' : 'none';
      @endif
    }

    function filterParentOptions() {
      const kelompok = document.getElementById('kelompok_jabatan').value;
      @if($jabatan->id_jabatan_parent != 0 && $jabatan->id_jabatan_parent != 1)
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
      @endif
    }

    @if($jabatan->id_jabatan_parent != 0 && $jabatan->id_jabatan_parent != 1)
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
    @endif

    // On page load
    toggleParentDropdowns();
    filterParentOptions();
  </script>
@endsection
