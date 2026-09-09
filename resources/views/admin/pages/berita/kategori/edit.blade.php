@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/cropperjs.css', 'resources/css/viewerjs.css'])

  <style>
    .ikon-viewer-wrapper {
      height: 220px;
    }

    .ikon-placeholder {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
    }

    .ikon-preview {
      background: #fff;
    }
  </style>
@endsection

@section('document.body')
  <form action="{{ route('admin.berita.kategori.update', $kategori->id_berita_kategori) }}" method="POST"
    enctype="multipart/form-data">
    @csrf

    <div class="mb-4">
      <label for="nama_kategori" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
      <span class="text-xs text-gray-700">Anda harus menggantinya melalui halaman Struktur Organisasi</span>
      <input type="text" name="nama_kategori" id="nama_kategori"
        value="{{ $kategori->susunanOrganisasi->nama_susunan_organisasi }}"
        class="cursor-not-allowed bg-gray-100 mt-1 block w-full p-2 border border-gray-300 rounded-md" disabled
        readonly />
    </div>

    <div class="mb-4">
      <label for="ikon_berita_kategori" class="block text-sm font-medium text-gray-700">Ikon Kategori</label>
      <div class="relative group ikon-viewer-wrapper h-28 sm:h-32">
        <label
          class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0"
          tabindex="0">
          <div
            class="ikon-placeholder flex flex-col items-center justify-center pt-5 pb-6 {{ $kategori->ikon_berita_kategori ? 'hidden' : '' }}">
            <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
            </svg>
            <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload ikon</p>
            <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
          </div>
          <img id="ikon-preview"
            class="ikon-preview absolute inset-0 w-full h-full object-contain rounded-lg bg-white {{ $kategori->ikon_berita_kategori ? '' : 'hidden' }}"
            src="{{ $kategori->ikon_berita_kategori ? Storage::url($kategori->ikon_berita_kategori) : '' }}" />
          <input name="ikon_berita_kategori" id="ikon_berita_kategori" type="file" accept="image/*"
            class="hidden ikon-input" />
        </label>
        <button type="button"
          class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-ikon-btn {{ $kategori->ikon_berita_kategori ? '' : 'hidden' }}"
          title="Hapus ikon" id="remove-ikon-btn">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <button type="button"
          class="w-[30px] h-[30px] bg-white rounded-full text-green-600 hover:text-green-800 shadow-lg border border-black flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-10 revert-ikon-btn hidden"
          title="Kembalikan ikon sebelumnya" id="revert-ikon-btn">
          <i class="fa-solid fa-rotate-right"></i>
        </button>
        <a type="button" id="edit-ikon-button"
          class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 {{ $kategori->ikon_berita_kategori ? '' : 'hidden' }}">
          <i class="fa-solid fa-crop-simple"></i>
        </a>
      </div>
    </div>

    <div class="mb-4">
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
    </div>
  </form>

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
@endsection

@section('document.end')
  @vite(['resources/js/cropperjs.js', 'resources/js/viewerjs.js', 'resources/js/shared/crop-uploader.js'])

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      window.initCropUploader({
        wrapperSelector: '.ikon-viewer-wrapper',
        inputSelector: '#ikon_berita_kategori',
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
    });
  </script>
@endsection
