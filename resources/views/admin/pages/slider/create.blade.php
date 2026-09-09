@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/cropperjs.css', 'resources/css/viewerjs.css'])

  <style>
    .slider-viewer-wrapper {
      height: 220px;
    }

    .slider-placeholder {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
    }

    .slider-preview {
      background: #fff;
    }
  </style>
@endsection

@section('document.body')
  <form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-4 flex gap-2">
      <div class="w-4/5">
        <label for="judul_slider" class="block text-sm font-medium text-gray-700">Judul Slider</label>
        <input type="text" name="judul_slider" id="judul_slider"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
      </div>

      <div class="w-1/5">
        <label for="is_visible" class="block text-sm font-medium text-gray-700">Status</label>
        <select name="is_visible" id="is_visible" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
          required>
          <option value="1">Ditampilkan</option>
          <option value="0">Disembunyikan</option>
        </select>
      </div>
    </div>

    <div class="mb-4">
      <label for="foto_slider" class="block text-sm font-medium text-gray-700">Foto Slider <span
          class="text-red-600">*</span></label>
      <div class="relative group slider-viewer-wrapper h-28 sm:h-32">
        <label
          class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0"
          tabindex="0">
          <div class="slider-placeholder flex flex-col items-center justify-center pt-5 pb-6">
            <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
            </svg>
            <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload slider</p>
            <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
          </div>
          <img id="slider-preview"
            class="slider-preview hidden absolute inset-0 w-full h-full object-contain rounded-lg bg-white aspect-[16/9]" />
          <input name="foto_slider" id="foto_slider" type="file" accept="image/*" class="hidden slider-input"
            required />
        </label>
        <button type="button"
          class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-slider-btn hidden"
          title="Hapus slider" id="remove-slider-btn">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <button type="button"
          class="w-[30px] h-[30px] bg-white rounded-full text-green-600 hover:text-green-800 shadow-lg border border-black flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-10 revert-slider-btn hidden"
          title="Kembalikan slider sebelumnya" id="revert-slider-btn">
          <i class="fa-solid fa-rotate-right"></i>
        </button>
        <a type="button" id="edit-slider-button"
          class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 hidden">
          <i class="fa-solid fa-crop-simple"></i>
        </a>
      </div>
    </div>

    <!-- Modal CropperJS untuk slider -->
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
  @vite(['resources/js/cropperjs.js', 'resources/js/viewerjs.js', 'resources/js/shared/crop-uploader.js'])

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      window.initCropUploader({
        wrapperSelector: '.slider-viewer-wrapper',
        inputSelector: '#foto_slider',
        previewSelector: '#slider-preview',
        placeholderSelector: '.slider-placeholder',
        removeBtnSelector: '#remove-slider-btn',
        revertBtnSelector: '#revert-slider-btn',
        editBtnSelector: '#edit-slider-button',
        modalSelector: '#cropperModalSlider',
        imageToCropSelector: '#image-to-crop-slider',
        confirmBtnSelector: '#crop-slider-confirm-btn',
        cancelBtnSelector: '#crop-slider-cancel-btn',
        aspectRatio: 2.368 / 1,
        fileNamePrefix: 'cropped_slider',
      });
    });
  </script>
@endsection
