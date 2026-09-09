@extends('admin.layout')

@section('document.head')
  @vite([
    'resources/css/viewerjs.css',
    'resources/css/cropperjs.css'
  ])

  <style>
    .foto-placeholder {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
    }
  </style>
@endsection

@section('document.body')
  <form action="{{ route('admin.struktur-organisasi.organigram.update', 1) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1" for="foto_organigram">
        Organigram <span class="text-red-600">*</span>
      </label>
      <div id="foto-input-single" class="mb-4">
        <div class="relative group foto-viewer-wrapper h-28 sm:h-32">
          <label
            class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0"
            tabindex="0">
            <div
              class="foto-placeholder flex flex-col items-center justify-center pt-5 pb-6
              {{ $organigram->diagram_struktur_organisasi ? 'hidden' : '' }}">
              <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
              </svg>
              <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload organigram</p>
              <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
            </div>
            <img id="foto-preview"
              class="absolute inset-0 w-full h-full object-contain rounded-lg bg-white {{ $organigram->diagram_struktur_organisasi ? '' : 'hidden' }}"
              src="{{ $organigram->diagram_struktur_organisasi ? Storage::url($organigram->diagram_struktur_organisasi) : '' }}" />
            <input name="foto_organigram" id="foto_organigram" type="file" accept="image/*"
              class="hidden foto-preview" />
          </label>
          <button type="button"
            class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-foto-btn {{ $organigram->diagram_struktur_organisasi ? '' : 'hidden' }}"
            title="Hapus foto" id="remove-foto-btn">
            <i class="fa-solid fa-xmark"></i>
          </button>
          <button type="button"
            class="w-[30px] h-[30px] bg-white rounded-full text-green-600 hover:text-green-800 shadow-lg border border-black flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-10 revert-foto-btn hidden"
            title="Kembalikan foto sebelumnya" id="revert-foto-btn">
            <i class="fa-solid fa-rotate-right"></i>
          </button>
          <a type="button" id="edit-image-button"
            class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 {{ $organigram->diagram_struktur_organisasi ? '' : 'hidden' }}">
            <i class="fa-solid fa-crop-simple"></i>
          </a>
        </div>
      </div>
    </div>
    <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
  </form>

  <div id="cropperModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl relative mx-4 md:mx-5">
      <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
        <h3 class="text-xl font-semibold text-gray-900">
          Crop Gambar
        </h3>
      </div>
      <div class="m-4 md:m-5">
        <img id="image-to-crop" src="" class="max-h-[50vh] mx-auto block m-4" alt="Image to crop" />
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
@endsection

@section('document.end')
  @vite([
    'resources/js/viewerjs.js',
    'resources/js/cropperjs.js',
    'resources/js/shared/crop-uploader.js'
  ])

  <script>
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
      const wrapper = document.querySelector('.foto-viewer-wrapper');
      const label = wrapper.querySelector('label');
      if (label) {
        label.addEventListener('mousedown', function(e) {
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
    });
  </script>
@endsection
