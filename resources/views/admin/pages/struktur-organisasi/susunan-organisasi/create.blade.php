@extends('admin.layout')

@section('document.head')
  @vite([
    'resources/css/quill.css',
    'resources/css/viewerjs.css',
    'resources/css/cropperjs.css'
  ])
@endsection

@section('document.body')
  <form action="{{ route('admin.struktur-organisasi.susunan-organisasi.store') }}" method="POST"
    enctype="multipart/form-data" id="form-susunan-organisasi">
    @csrf

    <div class="mb-4">
      <label for="kelompok_susunan_organisasi" class="block text-sm font-medium text-gray-700">Kelompok Susunan
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
      <label for="nama_susunan_organisasi" class="block text-sm font-medium text-gray-700">Nama Susunan
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
      <label for="tupoksi_susunan_organisasi" class="block text-sm font-medium text-gray-700 mb-1">Tupoksi Susunan
        Organisasi</label>
      <input id="tupoksi_susunan_organisasi" type="hidden" name="tupoksi_susunan_organisasi"
        value="{{ old('tupoksi_susunan_organisasi') }}">
      <div id="quill-editor-tupoksi"></div>
    </div>

    {{-- Ikon --}}
    <div id="ikon-organigram-slider-group" class="sm:flex sm:gap-4">
      <div class="sm:flex-1">
        <label class="block text-sm font-medium text-gray-700 mb-1" for="ikon_jabatan">
          Ikon <span id="ikon-required" class="text-red-600">*</span>
        </label>
        <div id="ikon-input-single" class="mb-4">
          <div class="relative group ikon-viewer-wrapper h-28 sm:h-32">
            <label
              class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0">
              <div class="ikon-placeholder flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
                </svg>
                <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload ikon</p>
                <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
              </div>
              <img id="ikon-preview" class="hidden absolute inset-0 w-full h-full object-contain rounded-lg bg-white" />
              <input name="ikon_jabatan" id="ikon_jabatan" type="file" accept="image/*" class="hidden ikon-preview" />
            </label>
            <button type="button"
              class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-ikon-btn hidden"
              title="Hapus ikon" id="remove-ikon-btn">
              <i class="fa-solid fa-xmark"></i>
            </button>
            <button type="button"
              class="w-[30px] h-[30px] bg-white rounded-full text-green-600 hover:text-green-800 shadow-lg border border-black flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-10 revert-ikon-btn hidden"
              title="Kembalikan ikon sebelumnya" id="revert-ikon-btn">
              <i class="fa-solid fa-rotate-right"></i>
            </button>
            <a type="button" id="edit-ikon-button"
              class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 hidden">
              <i class="fa-solid fa-crop-simple"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="sm:flex-1">
        {{-- Organigram input, wajib jika parent punya susunan organisasi --}}
        <label class="block text-sm font-medium text-gray-700 mb-1" for="foto_organigram">
          Organigram <span id="organigram-required" class="text-red-600">*</span>
        </label>
        <div id="foto-input-single" class="mb-4">
          <div class="relative group foto-viewer-wrapper h-28 sm:h-32">
            <label
              class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0">
              <div class="foto-placeholder flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
                </svg>
                <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload organigram</p>
                <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
              </div>
              <img id="foto-preview" class="hidden absolute inset-0 w-full h-full object-contain rounded-lg bg-white" />
              <input name="foto_organigram" id="foto_organigram" type="file" accept="image/*"
                class="hidden foto-preview foto-input" />
            </label>
            <button type="button"
              class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-foto-btn hidden"
              title="Hapus foto" id="remove-foto-btn">
              <i class="fa-solid fa-xmark"></i>
            </button>
            <button type="button"
              class="w-[30px] h-[30px] bg-white rounded-full text-green-600 hover:text-green-800 shadow-lg border border-black flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-10 revert-foto-btn hidden"
              title="Kembalikan foto sebelumnya" id="revert-foto-btn">
              <i class="fa-solid fa-rotate-right"></i>
            </button>
            <a type="button" id="edit-image-button"
              class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10">
              <i class="fa-solid fa-crop-simple"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- Slider --}}
    <div id="slider-group">
      <label class="block text-sm font-medium text-gray-700 mb-1" for="slider_jabatan[]">Slider (bisa lebih dari
        satu)</label>
      <div id="slider-input-list" class="mb-4 flex flex-row gap-2 overflow-x-auto">
        <div
          class="relative group slider-viewer-wrapper h-28 sm:h-32 mb-2 slider-input-item min-w-[calc(7rem*16/9)] max-w-[calc(8rem*16/9)] flex-shrink-0 aspect-[16/9]">
          <label
            class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0 aspect-[16/9]">
            <div class="slider-placeholder flex flex-col items-center justify-center pt-5 pb-6">
              <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
              </svg>
              <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload slider</p>
              <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
            </div>
            <img
              class="slider-preview hidden absolute inset-0 w-full h-full object-contain rounded-lg bg-white aspect-[16/9]" />
            <input name="slider_jabatan[]" type="file" accept="image/*" class="hidden foto-preview slider-input" />
          </label>
          <button type="button"
            class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-slider-btn hidden"
            title="Hapus slider">
            <i class="fa-solid fa-xmark"></i>
          </button>
          <button type="button"
            class="w-[30px] h-[30px] bg-white rounded-full text-green-600 hover:text-green-800 shadow-lg border border-black flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-10 revert-slider-btn hidden"
            title="Kembalikan slider sebelumnya">
            <i class="fa-solid fa-rotate-right"></i>
          </button>
          <a type="button"
            class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 edit-slider-button hidden">
            <i class="fa-solid fa-crop-simple"></i>
          </a>
          <button type="button"
            class="w-[30px] h-[30px] bg-white rounded-full text-blue-600 hover:text-blue-800 shadow-lg border border-black flex items-center justify-center absolute top-2 left-2 z-10 add-slider-btn"
            title="Tambah slider">
            <i class="fa-solid fa-plus"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Modal CropperJS untuk ikon -->
    <div id="cropperModalIkon" tabindex="-1" aria-hidden="true"
      class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl relative mx-4 md:mx-5">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
          <h3 class="text-xl font-semibold text-gray-900">
            Crop Ikon
          </h3>
        </div>
        <div class="m-4 md:m-5 flex justify-center items-center" style="min-height:200px;">
          <img id="image-to-crop-ikon" src="" class="max-h-[50vh] max-w-full block rounded border"
            alt="Image to crop" style="background:#f3f4f6;" />
        </div>
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b space-x-3">
          <button type="button" id="crop-ikon-confirm-btn" class="px-4 py-2 bg-blue-700 text-white rounded">
            Crop & Gunakan
          </button>
          <button type="button" id="crop-ikon-cancel-btn" class="px-4 py-2 bg-gray-300 rounded">
            Batal
          </button>
        </div>
      </div>
    </div>

    <!-- Modal CropperJS untuk organigram -->
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

    <!-- Modal CropperJS untuk slider (PASTIKAN ADA DI LUAR LOOP DAN HANYA SATU KALI DI BAWAH) -->
    <div id="cropperModalSlider" tabindex="-1" aria-hidden="true"
      class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl relative mx-4 md:mx-5">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
          <h3 class="text-xl font-semibold text-gray-900">
            Crop Slider
          </h3>
        </div>
        <div class="m-4 md:m-5 flex justify-center items-center" style="min-height:200px;">
          <img id="image-to-crop-slider" src="" class="max-h-[50vh] max-w-full block rounded border"
            alt="Image to crop" style="background:#f3f4f6;" />
        </div>
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b space-x-3">
          <button type="button" id="crop-slider-confirm-btn" class="px-4 py-2 bg-blue-700 text-white rounded">
            Crop & Gunakan
          </button>
          <button type="button" id="crop-slider-cancel-btn" class="px-4 py-2 bg-gray-300 rounded">
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

@section('document.end')
  @vite([
    'resources/js/quill.js',
    'resources/js/viewerjs.js',
    'resources/js/cropperjs.js',
    'resources/js/shared/crop-uploader.js',
    'resources/js/shared/rich-text-editor.js'
  ])
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      window.initRichTextEditor({
        selector: '#quill-editor-tupoksi',
        placeholder: 'Tulis tupoksi susunan organisasi di sini...',
        hiddenInputSelector: '#tupoksi_susunan_organisasi',
        formSelector: '#form-susunan-organisasi',
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      window.initCropUploader({
        wrapperSelector: '.foto-viewer-wrapper',
        inputSelector: '#foto_organigram',
        previewSelector: '#foto-preview',
        placeholderSelector: '.foto-placeholder',
        removeBtnSelector: '#remove-foto-btn',
        revertBtnSelector: '#revert-foto-btn',
        editBtnSelector: '#edit-image-button',
        modalSelector: '#cropperModal',
        imageToCropSelector: '#image-to-crop',
        confirmBtnSelector: '#crop-confirm-btn',
        cancelBtnSelector: '#crop-cancel-btn',
        fileNamePrefix: 'cropped',
      });

      // Ekstra: cegah klik pada gambar pratinjau (untuk membesarkan lewat
      // Viewer.js) ikut memicu label membuka dialog pilih berkas.
      const fotoWrapper = document.querySelector('.foto-viewer-wrapper');
      const fotoLabel = fotoWrapper ? fotoWrapper.querySelector('label') : null;
      if (fotoLabel) {
        fotoLabel.addEventListener('mousedown', function(e) {
          if (
            e.target.classList.contains('foto-preview') &&
            !e.target.classList.contains('hidden')
          ) {
            e.preventDefault();
            e.stopPropagation();
            return false;
          }
        }, true);
      }

      // === IKON ===
      window.initCropUploader({
        wrapperSelector: '.ikon-viewer-wrapper',
        inputSelector: '#ikon_jabatan',
        previewSelector: '#ikon-preview',
        placeholderSelector: '.ikon-placeholder',
        removeBtnSelector: '#remove-ikon-btn',
        revertBtnSelector: '#revert-ikon-btn',
        editBtnSelector: '#edit-ikon-button',
        modalSelector: '#cropperModalIkon',
        imageToCropSelector: '#image-to-crop-ikon',
        confirmBtnSelector: '#crop-ikon-confirm-btn',
        cancelBtnSelector: '#crop-ikon-cancel-btn',
        aspectRatio: 1,
        fileNamePrefix: 'cropped_ikon',
      });

      // == SLIDER MULTI INPUT ==
      const sliderInputList = document.getElementById('slider-input-list');
      const cropperModalSlider = document.getElementById('cropperModalSlider');
      const imageToCropSlider = document.getElementById('image-to-crop-slider');
      const cropSliderConfirmBtn = document.getElementById('crop-slider-confirm-btn');
      const cropSliderCancelBtn = document.getElementById('crop-slider-cancel-btn');
      let cropperSlider = null;
      let lastSliderFile = null;

      // Helper untuk menyimpan history per slider input
      function getSliderHistoryStore(item) {
        if (!item._sliderHistory) {
          item._sliderHistory = {
            history: [],
            pointer: -1
          };
        }
        return item._sliderHistory;
      }

      function pushSliderHistory(item, src) {
        const store = getSliderHistoryStore(item);
        if (store.pointer < store.history.length - 1) {
          store.history = store.history.slice(0, store.pointer + 1);
        }
        store.history.push(src);
        store.pointer = store.history.length - 1;
        updateRevertSliderBtn(item);
      }

      function updateRevertSliderBtn(item) {
        const store = getSliderHistoryStore(item);
        const revertBtn = item.querySelector('.revert-slider-btn');
        if (store.pointer > 0) {
          revertBtn.classList.remove('hidden');
          revertBtn.style.display = '';
        } else {
          revertBtn.classList.add('hidden');
          revertBtn.style.display = 'none';
        }
      }

      // Pada setiap kali setSliderPreviewAndHistory, update viewer
      function setSliderPreviewAndHistory(item, src) {
        const preview = item.querySelector('.slider-preview');
        const placeholder = item.querySelector('.slider-placeholder');
        const removeBtn = item.querySelector('.remove-slider-btn');
        const editBtn = item.querySelector('.edit-slider-button');
        preview.src = src;
        preview.classList.remove('hidden');
        if (placeholder) placeholder.classList.add('hidden');
        if (removeBtn) removeBtn.classList.remove('hidden');
        if (editBtn) editBtn.classList.remove('hidden');
        pushSliderHistory(item, src);
        // Update viewer agar gambar baru bisa tampil
        if (item._sliderViewer) item._sliderViewer.update();
      }

      function resetSliderPreview(item) {
        const preview = item.querySelector('.slider-preview');
        const placeholder = item.querySelector('.slider-placeholder');
        const removeBtn = item.querySelector('.remove-slider-btn');
        const editBtn = item.querySelector('.edit-slider-button');
        preview.src = '#';
        preview.classList.add('hidden');
        if (placeholder) placeholder.classList.remove('hidden');
        if (removeBtn) removeBtn.classList.add('hidden');
        if (editBtn) editBtn.classList.add('hidden');
      }

      // Ubah createSliderInputItem agar h-28 sm:h-32 dan aspect ratio 16:9
      function createSliderInputItem() {
        const html = `
        <div class="relative group slider-viewer-wrapper h-28 sm:h-32 mb-2 slider-input-item min-w-[calc(7rem*16/9)] max-w-[calc(8rem*16/9)] flex-shrink-0 aspect-[16/9]">
          <label
            class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0 aspect-[16/9]">
            <div class="slider-placeholder flex flex-col items-center justify-center pt-5 pb-6">
              <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
              </svg>
              <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload slider</p>
              <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
            </div>
            <img class="slider-preview hidden absolute inset-0 w-full h-full object-contain rounded-lg bg-white aspect-[16/9]" />
            <input name="slider_jabatan[]" type="file" accept="image/*"
              class="hidden foto-preview slider-input" />
          </label>
          <button type="button"
            class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-slider-btn"
            title="Hapus slider">
            <i class="fa-solid fa-xmark"></i>
          </button>
          <button type="button"
            class="w-[30px] h-[30px] bg-white rounded-full text-green-600 hover:text-green-800 shadow-lg border border-black flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-10 revert-slider-btn hidden"
            title="Kembalikan slider sebelumnya">
            <i class="fa-solid fa-rotate-right"></i>
          </button>
          <a type="button"
            class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 edit-slider-button hidden">
            <i class="fa-solid fa-crop-simple"></i>
          </a>
          <button type="button"
            class="w-[30px] h-[30px] bg-white rounded-full text-blue-600 hover:text-blue-800 shadow-lg border border-black flex items-center justify-center absolute top-2 left-2 z-10 add-slider-btn"
            title="Tambah slider">
            <i class="fa-solid fa-plus"></i>
          </button>
        </div>
        `;
        const temp = document.createElement('div');
        temp.innerHTML = html.trim();
        return temp.firstChild;
      }

      // Delegasi event untuk tombol + dan x pada slider
      sliderInputList.addEventListener('click', function(e) {
        if (e.target.closest('.add-slider-btn')) {
          e.preventDefault();
          const newItem = createSliderInputItem();
          sliderInputList.appendChild(newItem);
          initSliderViewer(newItem);
          updateAddSliderBtnVisibility();
        }
        if (e.target.closest('.remove-slider-btn')) {
          e.preventDefault();
          const item = e.target.closest('.slider-input-item');
          // Ubah: Jika hanya satu form, reset preview saja, jangan hapus form
          if (item) {
            if (sliderInputList.children.length > 1) {
              item.remove();
              updateAddSliderBtnVisibility();
            } else {
              // Reset preview, placeholder, tombol, dan input file
              resetSliderPreview(item);
              const input = item.querySelector('.slider-input');
              if (input) input.value = '';
              // Reset history
              item._sliderHistory = {
                history: [],
                pointer: -1
              };
              updateRevertSliderBtn(item);
            }
          }
        }
        // Tombol revert slider
        if (e.target.closest('.revert-slider-btn')) {
          e.preventDefault();
          const item = e.target.closest('.slider-input-item');
          const store = getSliderHistoryStore(item);
          if (store.pointer > 0) {
            store.pointer--;
            const prevSrc = store.history[store.pointer];
            const preview = item.querySelector('.slider-preview');
            const placeholder = item.querySelector('.slider-placeholder');
            const removeBtn = item.querySelector('.remove-slider-btn');
            const editBtn = item.querySelector('.edit-slider-button');
            if (prevSrc && prevSrc !== '#') {
              preview.src = prevSrc;
              preview.classList.remove('hidden');
              if (placeholder) placeholder.classList.add('hidden');
              if (removeBtn) removeBtn.classList.remove('hidden');
              if (editBtn) editBtn.classList.remove('hidden');
            } else {
              resetSliderPreview(item);
            }
            updateRevertSliderBtn(item);
          }
        }
      });

      // Hanya tampilkan tombol + pada input slider terakhir
      function updateAddSliderBtnVisibility() {
        const items = Array.from(sliderInputList.querySelectorAll('.slider-input-item'));
        items.forEach(function(item, idx) {
          const addBtn = item.querySelector('.add-slider-btn');
          if (addBtn) {
            if (idx === items.length - 1) {
              addBtn.style.display = '';
            } else {
              addBtn.style.display = 'none';
            }
          }
        });
      }

      // Inisialisasi viewerjs untuk slider input yang sudah ada saat load
      Array.from(sliderInputList.querySelectorAll('.slider-input-item')).forEach(function(item, idx, arr) {
        initSliderViewer(item);
      });
      updateAddSliderBtnVisibility();

      // Tambahkan: ViewerJS untuk setiap slider input
      function initSliderViewer(item) {
        const wrapper = item;
        if (wrapper && window.Viewer) {
          // Hapus instance lama jika ada (untuk mencegah duplikasi)
          if (wrapper._sliderViewer) {
            wrapper._sliderViewer.destroy();
            wrapper._sliderViewer = null;
          }
          // Pastikan .slider-preview tidak memiliki attribute style="display:none" (gunakan class hidden saja)
          const img = wrapper.querySelector('.slider-preview');
          if (img) img.removeAttribute('style');
          wrapper._sliderViewer = new Viewer(wrapper, {
            navbar: false,
            toolbar: true,
            title: false,
            tooltip: false,
            movable: false,
            zoomable: true,
            scalable: false,
            transition: true,
            fullscreen: false,
            filter(image) {
              // Hanya img.slider-preview yang visible
              return image.classList.contains('slider-preview') && !image.classList.contains('hidden') && image
                .src && image.src !== '#';
            }
          });
        }
      }

      // Inisialisasi viewerjs untuk slider input yang sudah ada saat load
      Array.from(sliderInputList.querySelectorAll('.slider-input-item')).forEach(function(item) {
        initSliderViewer(item);
      });

      // Tambahkan event click pada slider-preview untuk show viewerjs
      sliderInputList.addEventListener('click', function(e) {
        const preview = e.target.closest('.slider-preview');
        if (preview && !preview.classList.contains('hidden') && preview.src && preview.src !== '#') {
          e.preventDefault();
          e.stopPropagation();
          const item = preview.closest('.slider-input-item');
          if (item && item._sliderViewer) {
            item._sliderViewer.show();
          }
          return false;
        }
      });

      // Delegasi event untuk cropper slider (harus pakai event delegation agar modal cropperSlider muncul)
      sliderInputList.addEventListener('change', function(e) {
        const input = e.target.closest('.slider-input');
        if (input && input.files && input.files[0]) {
          lastSliderFile = input.files[0];
          const reader = new FileReader();
          reader.onload = function(ev) {
            imageToCropSlider.src = ev.target.result;
            cropperModalSlider.classList.remove('hidden');
            if (cropperSlider) cropperSlider.destroy();
            cropperSlider = new Cropper(imageToCropSlider, {
              viewMode: 1,
              autoCropArea: 1,
              aspectRatio: 16 / 9
            });
            cropperModalSlider.currentInput = input;
          };
          reader.readAsDataURL(input.files[0]);
        }
      });

      // Delegasi event untuk tombol edit crop pada slider
      sliderInputList.addEventListener('click', function(e) {
        const editBtn = e.target.closest('.edit-slider-button');
        if (editBtn) {
          e.preventDefault();
          const item = editBtn.closest('.slider-input-item');
          const preview = item.querySelector('.slider-preview');
          if (!preview.classList.contains('hidden') && preview.src && preview.src !== '#') {
            imageToCropSlider.src = preview.src;
            cropperModalSlider.classList.remove('hidden');
            if (cropperSlider) cropperSlider.destroy();
            cropperSlider = new Cropper(imageToCropSlider, {
              viewMode: 1,
              autoCropArea: 1,
              aspectRatio: 16 / 9
            });
            cropperModalSlider.currentInput = item.querySelector('.slider-input');
          }
        }
      });

      // --- FIX: Cropper Modal Slider Button Events ---
      // Pastikan event listener cropSliderConfirmBtn dan cropSliderCancelBtn hanya didaftarkan sekali
      // dan tidak terduplikasi setiap kali modal dibuka.

      // Hapus event listener lama jika ada (prevent duplicate)
      function replaceEventListener(el, event, handler) {
        const clone = el.cloneNode(true);
        el.parentNode.replaceChild(clone, el);
        clone.addEventListener(event, handler);
        return clone;
      }

      // Inisialisasi ulang tombol modal cropper slider agar selalu bisa diklik
      window.initCropperSliderModalButtons = function() {
        // Crop & Gunakan
        const oldConfirm = document.getElementById('crop-slider-confirm-btn');
        const newConfirm = replaceEventListener(oldConfirm, 'click', function() {
          if (cropperSlider && cropperModalSlider.currentInput) {
            cropperSlider.getCroppedCanvas().toBlob(function(blob) {
              const croppedFile = new File([blob], lastSliderFile ? lastSliderFile.name :
                'cropped_slider.jpg', {
                  type: blob.type
                });
              const dataTransfer = new DataTransfer();
              dataTransfer.items.add(croppedFile);
              cropperModalSlider.currentInput.files = dataTransfer.files;

              // Update preview pada input yang sedang diedit
              const item = cropperModalSlider.currentInput.closest('.slider-input-item');
              const reader = new FileReader();
              reader.onload = function(ev) {
                setSliderPreviewAndHistory(item, ev.target.result);
              };
              reader.readAsDataURL(croppedFile);

              cropperSlider.destroy();
              cropperSlider = null;
              cropperModalSlider.classList.add('hidden');
              cropperModalSlider.currentInput = null;
            }, lastSliderFile ? lastSliderFile.type : 'image/jpeg');
          }
        });

        // Batal
        const oldCancel = document.getElementById('crop-slider-cancel-btn');
        const newCancel = replaceEventListener(oldCancel, 'click', function() {
          cropperModalSlider.classList.add('hidden');
          if (cropperSlider) {
            cropperSlider.destroy();
            cropperSlider = null;
          }
          cropperModalSlider.currentInput = null;
        });
      };

      // Panggil sekali saat halaman load
      window.initCropperSliderModalButtons();

      // Jika ada kemungkinan modal cropper slider di-render ulang, panggil juga window.initCropperSliderModalButtons() setelah render.

      // == Subbagian/Jabatan Fungsional ==
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

      function checkShowOrganigram() {
        var organigramGroup = document.getElementById('organigram-upload-group');
        var organigramLabel = document.getElementById('label-organigram');
        if (organigramGroup) organigramGroup.style.display = '';
        if (organigramLabel) organigramLabel.style.display = '';
      }
      checkShowOrganigram();

      toggleParentDropdowns();

      document.getElementById('is_subbagian').addEventListener('change', function() {
        if (this.checked) {
          document.getElementById('is_jabatan_fungsional').checked = false;
        }
        toggleParentDropdowns();
        toggleIconOrganigramSlider();
        toggleRequiredIkonOrganigram();
      });
      document.getElementById('is_jabatan_fungsional').addEventListener('change', function() {
        if (this.checked) {
          document.getElementById('is_subbagian').checked = false;
        }
        toggleParentDropdowns();
        toggleIconOrganigramSlider();
        toggleRequiredIkonOrganigram();
      });

      document.getElementById('kelompok_susunan_organisasi').addEventListener('change', function() {
        filterParentOptions();
      });

      // Sembunyikan ikon, organigram, slider jika subbagian/jabatan fungsional dicentang
      function toggleIconOrganigramSlider() {
        const isSubbagian = document.getElementById('is_subbagian').checked;
        const isFungsional = document.getElementById('is_jabatan_fungsional').checked;
        const group = document.getElementById('ikon-organigram-slider-group');
        const sliderGroup = document.getElementById('slider-group');
        if (group) group.style.display = (!isSubbagian && !isFungsional) ? '' : 'none';
        if (sliderGroup) sliderGroup.style.display = (!isSubbagian && !isFungsional) ? '' : 'none';
      }

      // Toggle required attribute and * on ikon/organigram if subbagian/fungsional checked
      function toggleRequiredIkonOrganigram() {
        const isSubbagian = document.getElementById('is_subbagian').checked;
        const isFungsional = document.getElementById('is_jabatan_fungsional').checked;
        const ikonInput = document.getElementById('ikon_jabatan');
        const ikonRequired = document.getElementById('ikon-required');
        const organigramInput = document.getElementById('foto_organigram');
        const organigramRequired = document.getElementById('organigram-required');
        const required = !(isSubbagian || isFungsional);

        if (ikonInput) {
          if (required) {
            ikonInput.setAttribute('required', 'required');
            ikonRequired.style.display = '';
          } else {
            ikonInput.removeAttribute('required');
            ikonRequired.style.display = 'none';
          }
        }
        if (organigramInput) {
          if (required) {
            organigramInput.setAttribute('required', 'required');
            organigramRequired.style.display = '';
          } else {
            organigramInput.removeAttribute('required');
            organigramRequired.style.display = 'none';
          }
        }
      }

      // Panggil saat load
      toggleIconOrganigramSlider();
      toggleRequiredIkonOrganigram();
    });
  </script>
@endsection
