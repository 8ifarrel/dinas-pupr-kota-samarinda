@extends('admin.layouts.susunan-organisasi')

@section('css')
  <link href="https://unpkg.com/trix/dist/trix.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.3/viewer.min.css" rel="stylesheet" />
  <link href="https://unpkg.com/cropperjs@1.6.1/dist/cropper.min.css" rel="stylesheet" />
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

  <form action="{{ route('admin.struktur-organisasi.susunan-organisasi.store') }}" method="POST"
    enctype="multipart/form-data">
    @csrf

    <div class="mb-4">
      <label for="kelompok_susunan_organisasi" class="block text-sm font-medium text-gray-700">Kelompok Struktur
        Organisasi</label>
      <select name="kelompok_susunan_organisasi" id="kelompok_susunan_organisasi"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        <option value="" selected disabled>-- Pilih Kelompok Susunan Organisasi --</option>
        <option value="Sekretariat">Sekretariat</option>
        <option value="Bidang">Bidang</option>
        <option value="UPTD">UPTD</option>
      </select>
    </div>

    <div class="mb-1">
      <label for="nama_susunan_organisasi" class="block text-sm font-medium text-gray-700">Nama Struktur
        Organisasi</label>
      <input type="text" name="nama_susunan_organisasi" id="nama_susunan_organisasi"
        value="{{ old('nama_susunan_organisasi') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
        required />
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
                  (empty($susunan_organisasi->id_susunan_organisasi_parent) ||
                      $susunan_organisasi->id_susunan_organisasi_parent == 0 ||
                      $susunan_organisasi->id_susunan_organisasi_parent == 1)) ||
                  ($susunan_organisasi->kelompok_susunan_organisasi == 'Sekretariat' &&
                      (empty($susunan_organisasi->id_susunan_organisasi_parent) ||
                          $susunan_organisasi->id_susunan_organisasi_parent == 0 ||
                          $susunan_organisasi->id_susunan_organisasi_parent == 1)))
            <option value="{{ $susunan_organisasi->id_susunan_organisasi }}"
              data-kelompok="{{ $susunan_organisasi->kelompok_susunan_organisasi }}">
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
                  (empty($susunan_organisasi->id_susunan_organisasi_parent) ||
                      $susunan_organisasi->id_susunan_organisasi_parent == 0 ||
                      $susunan_organisasi->id_susunan_organisasi_parent == 1)) ||
                  ($susunan_organisasi->kelompok_susunan_organisasi == 'Sekretariat' &&
                      (empty($susunan_organisasi->id_susunan_organisasi_parent) ||
                          $susunan_organisasi->id_susunan_organisasi_parent == 0 ||
                          $susunan_organisasi->id_susunan_organisasi_parent == 1)))
            <option value="{{ $susunan_organisasi->id_susunan_organisasi }}"
              data-kelompok="{{ $susunan_organisasi->kelompok_susunan_organisasi }}">
              {{ $susunan_organisasi->nama_susunan_organisasi }}
            </option>
          @endif
        @endforeach
      </select>
    </div>

    <div class="mb-4">
      <label for="deskripsi_susunan_organisasi" class="block text-sm font-medium text-gray-700">Deskripsi Susunan
        Organisasi</label>
      <textarea name="deskripsi_susunan_organisasi" id="deskripsi_susunan_organisasi"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md">{{ old('deskripsi_susunan_organisasi') }}</textarea>
    </div>

    <div class="mb-4">
      <label for="tupoksi_susunan_organisasi" class="block text-sm font-medium text-gray-700">Tupoksi Susunan
        Organisasi</label>
      <input id="tupoksi_susunan_organisasi" type="hidden" name="tupoksi_susunan_organisasi"
        value="{{ old('tupoksi_susunan_organisasi') }}">
      <trix-editor input="tupoksi_susunan_organisasi"></trix-editor>
    </div>

    {{-- Organigram input, wajib jika parent punya struktur organisasi --}}
    <label class="block text-sm font-medium text-gray-700 mb-1" for="foto_organigram">Organigram <span
        class="text-red-600">*</span></label>
    <div id="foto-input-single" class="mb-4">
      <div class="relative group foto-viewer-wrapper h-28 sm:h-32">
        <label
          class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0">
          <div class="foto-placeholder flex flex-col items-center justify-center pt-5 pb-6">
            <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
            </svg>
            <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload</p>
            <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
          </div>
          <img id="foto-preview"
            class="foto-preview hidden absolute inset-0 w-full h-full object-contain rounded-lg bg-white" />
          <input name="foto_organigram" id="foto_organigram" type="file" accept="image/*" class="hidden foto-input"
            required />
        </label>
        <button type="button"
          class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-foto-btn hidden"
          title="Hapus foto" id="remove-foto-btn">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <a type="button" id="edit-image-button"
          class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10">
          <i class="fa-solid fa-crop-simple"></i>
        </a>
      </div>
    </div>

    <!-- Modal CropperJS -->
    <div id="cropperModal" tabindex="-1" aria-hidden="true"
      class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl relative mx-4 md:mx-5">
        <div
          class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Crop Gambar
          </h3>
        </div>
        <div class="m-4 md:m-5">
          <img id="image-to-crop" src="" class="max-h-[50vh] mx-auto block m-4" alt="Image to crop" />
        </div>
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600 space-x-3">
          <button type="button" id="crop-confirm-btn" class="px-4 py-2 bg-blue-700 text-white rounded">
            Crop & Gunakan
          </button>
          <button type="button" id="crop-cancel-btn" class="px-4 py-2 bg-gray-300 rounded">
            Batal
          </button>
        </div>
      </div>
    </div>

    <div class="mb-4">
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
    </div>
  </form>
@endsection

@section('js')
  <script src="https://unpkg.com/trix/dist/trix.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.3/viewer.min.js"></script>
  <script src="https://unpkg.com/cropperjs@1.6.1/dist/cropper.js"></script>
  {{-- @vite('resources/js/admin/organigram.js') --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const wrapper = document.querySelector('.foto-viewer-wrapper');
      const input = document.getElementById('foto_organigram');
      const preview = document.getElementById('foto-preview');
      const placeholder = wrapper.querySelector('.foto-placeholder');
      const removeBtn = document.getElementById('remove-foto-btn');
      const editBtn = document.getElementById('edit-image-button');

      // CropperJS modal
      const cropperModal = document.getElementById('cropperModal');
      const imageToCrop = document.getElementById('image-to-crop');
      const cropConfirmBtn = document.getElementById('crop-confirm-btn');
      const cropCancelBtn = document.getElementById('crop-cancel-btn');
      let cropper = null;
      let lastFile = null;

      // Inisialisasi Viewer.js
      let viewer = null;
      if (wrapper && window.Viewer) {
        viewer = new Viewer(wrapper, {
          navbar: false,
          toolbar: true,
          title: false,
          tooltip: false,
          movable: false,
          zoomable: true,
          scalable: false,
          transition: true,
          fullscreen: false,
        });
      }

      // Show modal cropper setelah pilih file
      input.addEventListener('change', function() {
        if (input.files && input.files[0]) {
          lastFile = input.files[0];
          const reader = new FileReader();
          reader.onload = function(ev) {
            imageToCrop.src = ev.target.result;
            cropperModal.classList.remove('hidden');
            if (cropper) cropper.destroy();
            cropper = new Cropper(imageToCrop, {
              viewMode: 1,
              autoCropArea: 1,
            });
          };
          reader.readAsDataURL(input.files[0]);
        }
      });

      // TOMBOL EDIT: crop ulang dari preview
      editBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (!preview.classList.contains('hidden') && preview.src && preview.src !== '#') {
          imageToCrop.src = preview.src;
          cropperModal.classList.remove('hidden');
          if (cropper) cropper.destroy();
          cropper = new Cropper(imageToCrop, {
            viewMode: 1,
            autoCropArea: 1,
          });
        }
      });

      // Crop & gunakan hasil
      cropConfirmBtn.addEventListener('click', function() {
        if (cropper) {
          cropper.getCroppedCanvas().toBlob(function(blob) {
            const croppedFile = new File([blob], lastFile ? lastFile.name : 'cropped.jpg', {
              type: blob.type
            });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            input.files = dataTransfer.files;

            const reader = new FileReader();
            reader.onload = function(ev) {
              preview.src = ev.target.result;
              preview.classList.remove('hidden');
              placeholder.classList.add('hidden');
              removeBtn.classList.remove('hidden');
              removeBtn.disabled = false;
              // Tampilkan tombol edit jika ada foto
              editBtn.classList.remove('hidden');
              editBtn.style.display = '';
              if (viewer) viewer.update();
            };
            reader.readAsDataURL(croppedFile);

            cropper.destroy();
            cropper = null;
            cropperModal.classList.add('hidden');
          }, lastFile ? lastFile.type : 'image/jpeg');
        }
      });

      // Batal crop
      cropCancelBtn.addEventListener('click', function() {
        cropperModal.classList.add('hidden');
        if (cropper) {
          cropper.destroy();
          cropper = null;
        }
        // Reset input file jika batal
        input.value = '';
        // Sembunyikan tombol edit
        editBtn.classList.add('hidden');
        editBtn.style.display = 'none';
      });

      // Hapus foto
      removeBtn.addEventListener('click', function() {
        input.value = '';
        preview.src = '#';
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
        removeBtn.classList.add('hidden');
        removeBtn.disabled = true;
        // Sembunyikan tombol edit
        editBtn.classList.add('hidden');
        editBtn.style.display = 'none';
      });

      // Inisialisasi: pastikan tombol edit hidden jika tidak ada foto
      if (preview.classList.contains('hidden') || !preview.src || preview.src === '#') {
        editBtn.classList.add('hidden');
        editBtn.style.display = 'none';
      } else {
        editBtn.classList.remove('hidden');
        editBtn.style.display = '';
      }

      // Klik preview untuk viewerjs
      preview.addEventListener('click', function(ev) {
        ev.preventDefault();
        ev.stopPropagation();
        if (viewer && !preview.classList.contains('hidden') && preview.src && preview.src !== '#') {
          viewer.show();
        }
        return false;
      });

      // Cegah klik label saat preview
      wrapper.querySelector('label').addEventListener('mousedown', function(e) {
        if (
          e.target.classList.contains('foto-preview') &&
          !e.target.classList.contains('hidden')
        ) {
          e.preventDefault();
          e.stopPropagation();
          return false;
        }
      }, true);
    });

    function toggleParentDropdowns() {
      const isSubbagian = document.getElementById('is_subbagian').checked;
      const isFungsional = document.getElementById('is_jabatan_fungsional').checked;
      const subbagianParentGroup = document.getElementById('subbagian_parent_group');
      const fungsionalParentGroup = document.getElementById('fungsional_parent_group');
      if (subbagianParentGroup) subbagianParentGroup.style.display = isSubbagian ? 'block' : 'none';
      if (fungsionalParentGroup) fungsionalParentGroup.style.display = isFungsional ? 'block' : 'none';

      // Sembunyikan organigram jika salah satu dicentang
      const organigramGroup = document.getElementById('organigram-upload-group');
      const organigramLabel = document.getElementById('label-organigram');
      if (organigramGroup && organigramLabel) {
        if (isSubbagian || isFungsional) {
          organigramGroup.style.display = 'none';
          organigramLabel.style.display = 'none';
        } else {
          organigramGroup.style.display = '';
          organigramLabel.style.display = '';
        }
      }
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

    // Show/hide organigram input
    function checkShowOrganigram() {
      // Cek apakah parent punya struktur organisasi
      // Atau bisa juga berdasarkan pilihan kelompok, dsb.
      // Untuk create, biasanya setelah submit baru relasi ada, jadi bisa tampilkan jika kelompok tertentu saja
      // Atau biarkan selalu tampil, dan handle di backend
      var organigramGroup = document.getElementById('organigram-upload-group');
      var organigramLabel = document.getElementById('label-organigram');
      if (organigramGroup) organigramGroup.style.display = '';
      if (organigramLabel) organigramLabel.style.display = '';
    }
    checkShowOrganigram();

    // Panggil toggleParentDropdowns() di awal dan pada event checkbox
    toggleParentDropdowns();

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
  </script>
@endsection
