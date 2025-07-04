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
  <style>
    .filepond--credits * {
      display: none !important;
    }

    .filepond--credits,
    .filepond--credits span,
    .filepond--credits a {
      font-size: 0 !important;
      text-indent: -9999px !important;
      visibility: hidden !important;
      height: 0 !important;
      width: 0 !important;
      overflow: hidden !important;
      display: none !important;
    }

    .filepond--credits {
      display: flex !important;
      visibility: visible !important;
      height: auto !important;
      width: 100% !important;
      overflow: visible !important;
      font-size: 14px !important;
      align-items: center;
      justify-content: start;
      position: relative;
      min-height: 32px;
      background: transparent;
      padding: 0 !important;
      margin: 0 !important;
    }

    .filepond--credits::after {
      content: "Klik di sini untuk melihat foto sebelumnya";
      display: block;
      width: 100%;
      text-align: start;
      line-height: normal;
      position: static;
      background: transparent;
      font-size: 14px;
      font-weight: 400;
      white-space: pre-line;
      visibility: visible !important;
      height: auto !important;
      width: 100% !important;
      text-indent: 0 !important;
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

  <form action="{{ route('admin.struktur-organisasi.susunan-organisasi.update', $susunan->id_susunan_organisasi) }}"
    method="POST">
    @csrf
    @method('PUT')

    <div class="mb-4">
      @if ($susunan->id_susunan_organisasi == 1)
        <input type="hidden" name="kelompok_susunan_organisasi" value="Kepala Dinas">
      @else
        <label for="kelompok_susunan_organisasi" class="block text-sm font-medium text-gray-700">Kelompok Susunan
          Organisasi</label>
        <select name="kelompok_susunan_organisasi" id="kelompok_susunan_organisasi"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
          <option value="" disabled>-- Pilih Kelompok Susunan Organisasi --</option>
          <option value="Sekretariat" {{ $susunan->kelompok_susunan_organisasi == 'Sekretariat' ? 'selected' : '' }}>
            Sekretariat</option>
          <option value="Bidang" {{ $susunan->kelompok_susunan_organisasi == 'Bidang' ? 'selected' : '' }}>Bidang</option>
          <option value="UPTD" {{ $susunan->kelompok_susunan_organisasi == 'UPTD' ? 'selected' : '' }}>UPTD</option>
        </select>
      @endif
    </div>

    <div class="mb-1">
      <label for="nama_susunan_organisasi" class="block text-sm font-medium text-gray-700">Nama Susunan Organisasi</label>
      <input type="text" name="nama_susunan_organisasi" id="nama_susunan_organisasi"
        value="{{ $susunan->nama_susunan_organisasi }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
        required />
    </div>

    <div class="ms-1 mb-4 flex gap-6">
      <div>
        <input type="checkbox" id="is_subbagian" name="is_subbagian" value="1"
          {{ $susunan->is_subbagian ? 'checked' : '' }}>
        <label for="is_subbagian" class="text-sm font-medium text-gray-700">Subbagian</label>
      </div>
      <div>
        <input type="checkbox" id="is_jabatan_fungsional" name="is_jabatan_fungsional" value="1"
          {{ $susunan->is_jabatan_fungsional ? 'checked' : '' }}>
        <label for="is_jabatan_fungsional" class="text-sm font-medium text-gray-700">Jabatan Fungsional</label>
      </div>
    </div>

    <div class="mb-4" id="subbagian_parent_group" style="display: none;">
      <label for="subbagian_parent" class="block text-sm font-medium text-gray-700">Subbagian dari</label>
      <select name="subbagian_parent" id="subbagian_parent"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        <option value="" disabled {{ !$susunan->is_subbagian ? 'selected' : '' }}>-- Pilih Susunan Organisasi Induk
          --</option>
        @foreach ($parentOptions ?? [] as $item)
          @if (
              (in_array($item->kelompok_susunan_organisasi, ['Bidang', 'UPTD']) &&
                  (empty($item->id_susunan_organisasi_parent) ||
                      $item->id_susunan_organisasi_parent == 0 ||
                      $item->id_susunan_organisasi_parent == 1)) ||
                  ($item->kelompok_susunan_organisasi == 'Sekretariat' &&
                      (empty($item->id_susunan_organisasi_parent) ||
                          $item->id_susunan_organisasi_parent == 0 ||
                          $item->id_susunan_organisasi_parent == 1)))
            @if ($item->id_susunan_organisasi != $susunan->id_susunan_organisasi)
              <option value="{{ $item->id_susunan_organisasi }}" data-kelompok="{{ $item->kelompok_susunan_organisasi }}"
                {{ $susunan->is_subbagian && $susunan->id_susunan_organisasi_parent == $item->id_susunan_organisasi ? 'selected' : '' }}>
                {{ $item->nama_susunan_organisasi }}
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
        <option value="" disabled {{ !$susunan->is_jabatan_fungsional ? 'selected' : '' }}>-- Pilih Susunan
          Organisasi Induk --</option>
        @foreach ($parentOptions ?? [] as $item)
          @if (
              (in_array($item->kelompok_susunan_organisasi, ['Bidang', 'UPTD']) &&
                  (empty($item->id_susunan_organisasi_parent) ||
                      $item->id_susunan_organisasi_parent == 0 ||
                      $item->id_susunan_organisasi_parent == 1)) ||
                  ($item->kelompok_susunan_organisasi == 'Sekretariat' &&
                      (empty($item->id_susunan_organisasi_parent) ||
                          $item->id_susunan_organisasi_parent == 0 ||
                          $item->id_susunan_organisasi_parent == 1)))
            @if ($item->id_susunan_organisasi != $susunan->id_susunan_organisasi)
              <option value="{{ $item->id_susunan_organisasi }}"
                data-kelompok="{{ $item->kelompok_susunan_organisasi }}"
                {{ $susunan->is_jabatan_fungsional && $susunan->id_susunan_organisasi_parent == $item->id_susunan_organisasi ? 'selected' : '' }}>
                {{ $item->nama_susunan_organisasi }}
              </option>
            @endif
          @endif
        @endforeach
      </select>
    </div>

    <div class="mb-4">
      <label for="deskripsi_susunan_organisasi" class="block text-sm font-medium text-gray-700">Deskripsi Susunan
        Organisasi</label>
      <textarea name="deskripsi_susunan_organisasi" id="deskripsi_susunan_organisasi"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md">{{ $susunan->deskripsi_susunan_organisasi }}</textarea>
    </div>

    <div class="mb-4">
      <label for="tupoksi_susunan_organisasi" class="block text-sm font-medium text-gray-700">Tupoksi Susunan
        Organisasi</label>
      <input id="tupoksi_susunan_organisasi" type="hidden" name="tupoksi_susunan_organisasi"
        value="{{ $susunan->tupoksi_susunan_organisasi }}">
      <trix-editor input="tupoksi_susunan_organisasi"></trix-editor>
    </div>

    @if ($susunan->strukturOrganisasi)
      @php
        $diagram = $susunan->strukturOrganisasi->strukturOrganisasiDiagram ?? null;
      @endphp
      <div class="mb-8" id="organigram-upload-group">
        <label for="foto_organigram" id="label-organigram" class="block text-sm font-medium text-gray-700">Organigram
          <span class="text-red-600">*</span></label>
        <div class="relative group foto-viewer-wrapper h-28 sm:h-32">
          <label
            class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0">
            <div
              class="foto-placeholder flex flex-col items-center justify-center pt-5 pb-6 {{ $diagram && $diagram->diagram_struktur_organisasi ? 'hidden' : '' }}">
              <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
              </svg>
              <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload</p>
              <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
            </div>
            <img id="foto-preview"
              class="foto-preview {{ $diagram && $diagram->diagram_struktur_organisasi ? '' : 'hidden' }} absolute inset-0 w-full h-full object-contain rounded-lg bg-white"
              @if ($diagram && $diagram->diagram_struktur_organisasi) src="{{ Storage::url($diagram->diagram_struktur_organisasi) }}"
              @else
                src="#" @endif />
            <input name="foto_organigram" id="foto_organigram" type="file" accept="image/*"
              class="hidden foto-input" />
          </label>
          <button type="button"
            class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-foto-btn {{ $diagram && $diagram->diagram_struktur_organisasi ? '' : 'hidden' }}"
            title="Hapus foto" id="remove-foto-btn">
            <i class="fa-solid fa-xmark"></i>
          </button>
          <button type="button"
            class="w-[30px] h-[30px] bg-white rounded-full text-green-600 hover:text-green-800 shadow-lg border border-black flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-10 revert-foto-btn hidden"
            title="Kembalikan foto sebelumnya" id="revert-foto-btn">
            <i class="fa-solid fa-rotate-right"></i>
          </button>
          <a type="button" id="edit-image-button"
            class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 {{ $diagram && $diagram->diagram_struktur_organisasi ? '' : 'hidden' }}">
            <i class="fa-solid fa-crop-simple"></i>
          </a>
        </div>
      </div>
    @endif

    <!-- Modal CropperJS -->
    <div data-modal-target="cropperModal" id="cropperModal" tabindex="-1" aria-hidden="true"
      class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl relative mx-4 md:mx-5">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
          <h3 class="text-xl font-semibold text-gray-900">
            Crop Gambar
          </h3>
        </div>
        <div class="m-4 md:m-5 flex justify-center items-center" style="min-height:200px;">
          <img id="image-to-crop" src="" class="max-h-[50vh] max-w-full block rounded border"
            alt="Image to crop" style="background:#f3f4f6;" />
        </div>
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b space-x-3">
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
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Perbarui</button>
    </div>
  </form>

  <!-- Modal Cropper: pastikan SELALU ADA di halaman -->
  <div id="cropperModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Crop Image
          </h3>
          <button type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-hide="cropperModal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <div class="p-4 md:p-5 space-y-4">
          <div>
            <img id="image-to-crop" src="" alt="Image to crop" />
          </div>
        </div>
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600 space-x-2">
          <button type="button" id="crop-button"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Crop</button>
          <button type="button"
            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
            data-modal-hide="cropperModal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script src="https://unpkg.com/trix/dist/trix.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.3/viewer.min.js"></script>
  <script src="https://unpkg.com/cropperjs@1.6.1/dist/cropper.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const wrapper = document.querySelector('.foto-viewer-wrapper');
      const input = document.getElementById('foto_organigram');
      const preview = document.getElementById('foto-preview');
      const placeholder = wrapper.querySelector('.foto-placeholder');
      const removeBtn = document.getElementById('remove-foto-btn');
      const revertBtn = document.getElementById('revert-foto-btn');
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

      // Jika ada foto lama, pastikan tombol edit & hapus tampil
      if (!preview.classList.contains('hidden') && preview.src && preview.src !== '#') {
        editBtn.classList.remove('hidden');
        editBtn.style.display = '';
        removeBtn.classList.remove('hidden');
        removeBtn.style.display = '';
      } else {
        editBtn.classList.add('hidden');
        editBtn.style.display = 'none';
        removeBtn.classList.add('hidden');
        removeBtn.style.display = 'none';
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

      // Simpan src asli dari database (foto sebelum diedit/crop)
      const originalImageSrc =
        '{{ $diagram && $diagram->diagram_struktur_organisasi ? Storage::url($diagram->diagram_struktur_organisasi) : '' }}';
      let previousImageSrc = preview.src;
      let previousHadImage = !preview.classList.contains('hidden') && preview.src && preview.src !== '#';

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
              // Simpan state sebelum crop (untuk revert ke DB)
              previousImageSrc = preview.src;
              previousHadImage = !preview.classList.contains('hidden') && preview.src && preview.src !==
              '#';

              preview.src = ev.target.result;
              preview.classList.remove('hidden');
              placeholder.classList.add('hidden');
              removeBtn.classList.remove('hidden');
              removeBtn.style.display = '';
              editBtn.classList.remove('hidden');
              editBtn.style.display = '';
              // Tampilkan tombol revert jika ada original dari DB
              if (originalImageSrc) {
                revertBtn.classList.remove('hidden');
                revertBtn.style.display = '';
              }
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
      });

      // Hapus foto
      removeBtn.addEventListener('click', function() {
        // Simpan state sebelum dihapus
        previousImageSrc = preview.src;
        previousHadImage = !preview.classList.contains('hidden') && preview.src && preview.src !== '#';

        input.value = '';
        preview.src = '#';
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
        removeBtn.classList.add('hidden');
        removeBtn.style.display = 'none';
        editBtn.classList.add('hidden');
        editBtn.style.display = 'none';

        // Tampilkan tombol revert jika sebelumnya ada gambar
        if (originalImageSrc) {
          revertBtn.classList.remove('hidden');
          revertBtn.style.display = '';
        }
      });

      // TOMBOL REVERT: Kembalikan ke foto asli dari database
      revertBtn.addEventListener('click', function() {
        if (originalImageSrc) {
          preview.src = originalImageSrc;
          preview.classList.remove('hidden');
          placeholder.classList.add('hidden');
          removeBtn.classList.remove('hidden');
          removeBtn.style.display = '';
          editBtn.classList.remove('hidden');
          editBtn.style.display = '';
          // Reset input file agar tidak mengirim file baru
          input.value = '';
        }
        // Sembunyikan tombol revert
        revertBtn.classList.add('hidden');
        revertBtn.style.display = 'none';
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
  </script>
@endsection
