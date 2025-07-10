@extends('admin.layout')

@section('document.head')
  @vite([
    'resources/css/trix.css',
    'resources/css/viewerjs.css',
    'resources/css/cropperjs.css'
  ])

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
  </style>
@endsection

@section('document.body')
  <form action="{{ route('admin.struktur-organisasi.susunan-organisasi.update', $susunan->id_susunan_organisasi) }}"
    method="POST" enctype="multipart/form-data">
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
          {{ $susunan->is_susunan_organisasi_fungsional ? 'checked' : '' }}>
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
        <option value="" disabled {{ !$susunan->is_susunan_organisasi_fungsional ? 'selected' : '' }}>-- Pilih
          Susunan Organisasi Induk --</option>
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
                {{ $susunan->is_susunan_organisasi_fungsional && $susunan->id_susunan_organisasi_parent == $item->id_susunan_organisasi ? 'selected' : '' }}>
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

    {{-- Ikon, Organigram, Slider --}}
    <div id="ikon-organigram-slider-group" class="sm:flex sm:gap-4">
      <div class="sm:flex-1">
        <label class="block text-sm font-medium text-gray-700 mb-1" for="ikon_jabatan">
          Ikon <span id="ikon-required" class="text-red-600">*</span>
        </label>
        <div id="ikon-input-single" class="mb-4">
          <div class="relative group ikon-viewer-wrapper h-28 sm:h-32">
            <label
              class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0"
              tabindex="0">
              <div class="ikon-placeholder flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
                </svg>
                <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload ikon</p>
                <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
              </div>
              <img id="ikon-preview"
                class="absolute inset-0 w-full h-full object-contain rounded-lg bg-white {{ $susunan->strukturOrganisasi && $susunan->strukturOrganisasi->ikon_jabatan ? '' : 'hidden' }}"
                src="{{ $susunan->strukturOrganisasi && $susunan->strukturOrganisasi->ikon_jabatan ? Storage::url($susunan->strukturOrganisasi->ikon_jabatan) : '' }}" />
              <input name="ikon_jabatan" id="ikon_jabatan" type="file" accept="image/*"
                class="hidden ikon-preview" />
            </label>
            <button type="button"
              class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-ikon-btn {{ $susunan->strukturOrganisasi && $susunan->strukturOrganisasi->ikon_jabatan ? '' : 'hidden' }}"
              title="Hapus ikon" id="remove-ikon-btn">
              <i class="fa-solid fa-xmark"></i>
            </button>
            <button type="button"
              class="w-[30px] h-[30px] bg-white rounded-full text-green-600 hover:text-green-800 shadow-lg border border-black flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-10 revert-ikon-btn hidden"
              title="Kembalikan ikon sebelumnya" id="revert-ikon-btn">
              <i class="fa-solid fa-rotate-right"></i>
            </button>
            <a type="button" id="edit-ikon-button"
              class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 {{ $susunan->strukturOrganisasi && $susunan->strukturOrganisasi->ikon_jabatan ? '' : 'hidden' }}">
              <i class="fa-solid fa-crop-simple"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="sm:flex-1">
        <label class="block text-sm font-medium text-gray-700 mb-1" for="foto_organigram">
          Organigram <span id="organigram-required" class="text-red-600">*</span>
        </label>
        <div id="foto-input-single" class="mb-4">
          <div class="relative group foto-viewer-wrapper h-28 sm:h-32">
            <label
              class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0"
              tabindex="0">
              <div class="foto-placeholder flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
                </svg>
                <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload organigram</p>
                <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
              </div>
              <img id="foto-preview"
                class="absolute inset-0 w-full h-full object-contain rounded-lg bg-white {{ $susunan->strukturOrganisasi && $susunan->strukturOrganisasi->strukturOrganisasiDiagram ? '' : 'hidden' }}"
                src="{{ $susunan->strukturOrganisasi && $susunan->strukturOrganisasi->strukturOrganisasiDiagram ? Storage::url($susunan->strukturOrganisasi->strukturOrganisasiDiagram->diagram_struktur_organisasi) : '' }}" />
              <input name="foto_organigram" id="foto_organigram" type="file" accept="image/*"
                class="hidden foto-preview " style="z-index:2;" />
            </label>
            <button type="button"
              class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-foto-btn {{ $susunan->strukturOrganisasi && $susunan->strukturOrganisasi->strukturOrganisasiDiagram ? '' : 'hidden' }}"
              title="Hapus foto" id="remove-foto-btn">
              <i class="fa-solid fa-xmark"></i>
            </button>
            <button type="button"
              class="w-[30px] h-[30px] bg-white rounded-full text-green-600 hover:text-green-800 shadow-lg border border-black flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-10 revert-foto-btn hidden"
              title="Kembalikan foto sebelumnya" id="revert-foto-btn">
              <i class="fa-solid fa-rotate-right"></i>
            </button>
            <a type="button" id="edit-image-button"
              class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 {{ $susunan->strukturOrganisasi && $susunan->strukturOrganisasi->strukturOrganisasiDiagram ? '' : 'hidden' }}">
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
        @if ($susunan->strukturOrganisasi && $susunan->strukturOrganisasi->slider->count())
          @foreach ($susunan->strukturOrganisasi->slider as $slider)
            <div
              class="relative group slider-viewer-wrapper h-28 sm:h-32 mb-2 slider-input-item min-w-[calc(7rem*16/9)] max-w-[calc(8rem*16/9)] flex-shrink-0 aspect-[16/9]"
              data-slider-id="{{ $slider->id_slider }}">
              <label
                class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0 aspect-[16/9]">
                <div class="slider-placeholder flex flex-col items-center justify-center pt-5 pb-6 hidden"></div>
                <img
                  class="slider-preview absolute inset-0 w-full h-full object-contain rounded-lg bg-white aspect-[16/9]"
                  src="{{ Storage::url($slider->foto) }}" />
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
                class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 edit-slider-button">
                <i class="fa-solid fa-crop-simple"></i>
              </a>
              <button type="button"
                class="w-[30px] h-[30px] bg-white rounded-full text-blue-600 hover:text-blue-800 shadow-lg border border-black flex items-center justify-center absolute top-2 left-2 z-10 add-slider-btn"
                title="Tambah slider">
                <i class="fa-solid fa-plus"></i>
              </button>
            </div>
          @endforeach
        @else
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
              <input name="slider_jabatan[]" type="file" accept="image/*"
                class="hidden foto-preview slider-input" />
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
        @endif
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
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Perbarui</button>
    </div>
  </form>
@endsection

@section('document.end')
  @vite([
   'resources/js/trix.js',
   'resources/js/viewerjs.js',
   'resources/js/cropperjs.js'
  ])

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      function toggleParentDropdowns() {
        const isSubbagian = document.getElementById('is_subbagian').checked;
        const isFungsional = document.getElementById('is_jabatan_fungsional').checked;
        document.getElementById('subbagian_parent_group').style.display = isSubbagian ? 'block' : 'none';
        document.getElementById('fungsional_parent_group').style.display = isFungsional ? 'block' : 'none';

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
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // === COPY DARI create.blade.js UNTUK SEMUA FITUR CROP, REMOVE, ADD, REVERT, ETC ===

      // --- ORGANIGRAM ---
      const wrapper = document.querySelector('.foto-viewer-wrapper');
      const input = document.getElementById('foto_organigram');
      const preview = document.getElementById('foto-preview');
      const placeholder = wrapper.querySelector('.foto-placeholder');
      const removeBtn = document.getElementById('remove-foto-btn');
      const revertBtn = document.getElementById('revert-foto-btn');
      const editBtn = document.getElementById('edit-image-button');
      const cropperModal = document.getElementById('cropperModal');
      const imageToCrop = document.getElementById('image-to-crop');
      const cropConfirmBtn = document.getElementById('crop-confirm-btn');
      const cropCancelBtn = document.getElementById('crop-cancel-btn');
      let cropper = null;
      let lastFile = null;
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
          fullscreen: false
        });
      }
      // --- HISTORY: always start with original image if exists ---
      let imageHistory = [];
      let historyPointer = -1;
      // Ambil original image dari preview src (jika ada)
      let originalImageSrc = preview && preview.src && !preview.classList.contains('hidden') && preview.src !== '#' ?
        preview.src : null;
      if (originalImageSrc) {
        imageHistory = [originalImageSrc];
        historyPointer = 0;
      }

      function pushHistory(src) {
        if (historyPointer < imageHistory.length - 1) imageHistory = imageHistory.slice(0, historyPointer + 1);
        imageHistory.push(src);
        historyPointer = imageHistory.length - 1;
        updateRevertBtn();
      }

      function updateRevertBtn() {
        if (historyPointer > 0) {
          revertBtn.classList.remove('hidden');
          revertBtn.style.display = '';
          // Tampilkan kembali required pada organigram jika ada history
          if (input) input.setAttribute('required', 'required');
        } else {
          revertBtn.classList.add('hidden');
          revertBtn.style.display = 'none';
          // Hilangkan required pada organigram jika sudah di-revert ke awal
          if (input) input.removeAttribute('required');
        }
      }

      function setPreviewAndHistory(src, isInitial = false) {
        preview.src = src;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
        removeBtn.classList.remove('hidden');
        removeBtn.disabled = false;
        editBtn.classList.remove('hidden');
        editBtn.style.display = '';
        if (!isInitial) pushHistory(src);
        if (viewer) viewer.update();
      }
      // Inisialisasi preview dan history pada halaman edit
      if (originalImageSrc) {
        setPreviewAndHistory(originalImageSrc, true);
        updateRevertBtn();
      }
      if (input) input.addEventListener('change', function() {
        if (input.files && input.files[0]) {
          lastFile = input.files[0];
          const reader = new FileReader();
          reader.onload = function(ev) {
            imageToCrop.src = ev.target.result;
            cropperModal.classList.remove('hidden');
            if (cropper) cropper.destroy();
            cropper = new Cropper(imageToCrop, {
              viewMode: 1,
              autoCropArea: 1
            });
          };
          reader.readAsDataURL(input.files[0]);
        }
      });
      if (editBtn) editBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (!preview.classList.contains('hidden') && preview.src && preview.src !== '#') {
          imageToCrop.src = preview.src;
          cropperModal.classList.remove('hidden');
          if (cropper) cropper.destroy();
          cropper = new Cropper(imageToCrop, {
            viewMode: 1,
            autoCropArea: 1
          });
        }
      });
      if (cropConfirmBtn) cropConfirmBtn.addEventListener('click', function() {
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
              setPreviewAndHistory(ev.target.result);
            };
            reader.readAsDataURL(croppedFile);
            cropper.destroy();
            cropper = null;
            cropperModal.classList.add('hidden');
          }, lastFile ? lastFile.type : 'image/jpeg');
        }
      });
      if (cropCancelBtn) cropCancelBtn.addEventListener('click', function() {
        cropperModal.classList.add('hidden');
        if (cropper) {
          cropper.destroy();
          cropper = null;
        }
        input.value = '';
      });
      if (removeBtn) removeBtn.addEventListener('click', function() {
        setPreviewAndHistory('#');
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
        removeBtn.classList.add('hidden');
        removeBtn.disabled = true;
        editBtn.classList.add('hidden');
        editBtn.style.display = 'none';
        // Jangan reset imageHistory, agar revert tetap bisa ke original
      });
      if (revertBtn) revertBtn.addEventListener('click', function() {
        if (historyPointer > 0) {
          historyPointer--;
          const prevSrc = imageHistory[historyPointer];
          if (prevSrc && prevSrc !== '#') {
            preview.src = prevSrc;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
            removeBtn.classList.remove('hidden');
            removeBtn.disabled = false;
            editBtn.classList.remove('hidden');
            editBtn.style.display = '';
          } else {
            preview.src = '#';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
            removeBtn.classList.add('hidden');
            removeBtn.disabled = true;
            editBtn.classList.add('hidden');
            editBtn.style.display = 'none';
          }
          updateRevertBtn();
        }
      });
      if (preview && (preview.classList.contains('hidden') || !preview.src || preview.src === '#')) {
        editBtn.classList.add('hidden');
        editBtn.style.display = 'none';
      } else {
        editBtn.classList.remove('hidden');
        editBtn.style.display = '';
      }
      if (preview) preview.addEventListener('click', function(ev) {
        // Fix: prevent file input click, only show viewer if image is visible
        if (!preview.classList.contains('hidden') && preview.src && preview.src !== '#') {
          ev.preventDefault();
          ev.stopPropagation();
          if (viewer) viewer.show();
          return false;
        }
      }, true);

      // --- IKON ---
      const ikonWrapper = document.querySelector('.ikon-viewer-wrapper');
      const ikonInput = document.getElementById('ikon_jabatan');
      const ikonPreview = document.getElementById('ikon-preview');
      const ikonPlaceholder = ikonWrapper ? ikonWrapper.querySelector('.ikon-placeholder') : null;
      const removeIkonBtn = document.getElementById('remove-ikon-btn');
      const revertIkonBtn = document.getElementById('revert-ikon-btn');
      const editIkonBtn = document.getElementById('edit-ikon-button');
      const cropperModalIkon = document.getElementById('cropperModalIkon');
      const imageToCropIkon = document.getElementById('image-to-crop-ikon');
      const cropIkonConfirmBtn = document.getElementById('crop-ikon-confirm-btn');
      const cropIkonCancelBtn = document.getElementById('crop-ikon-cancel-btn');
      let cropperIkon = null;
      let lastIkonFile = null;
      // --- HISTORY: always start with original image if exists ---
      let ikonHistory = [];
      let ikonHistoryPointer = -1;
      let ikonOriginalImageSrc = ikonPreview && ikonPreview.src && !ikonPreview.classList.contains('hidden') &&
        ikonPreview.src !== '#' ? ikonPreview.src : null;
      if (ikonOriginalImageSrc) {
        ikonHistory = [ikonOriginalImageSrc];
        ikonHistoryPointer = 0;
      }
      let ikonViewer = null;
      if (ikonWrapper && window.Viewer) {
        ikonViewer = new Viewer(ikonWrapper, {
          navbar: false,
          toolbar: true,
          title: false,
          tooltip: false,
          movable: false,
          zoomable: true,
          scalable: false,
          transition: true,
          fullscreen: false
        });
      }

      function pushIkonHistory(src) {
        if (ikonHistoryPointer < ikonHistory.length - 1) ikonHistory = ikonHistory.slice(0, ikonHistoryPointer + 1);
        ikonHistory.push(src);
        ikonHistoryPointer = ikonHistory.length - 1;
        updateRevertIkonBtn();
      }

      function updateRevertIkonBtn() {
        if (ikonHistoryPointer > 0) {
          revertIkonBtn.classList.remove('hidden');
          revertIkonBtn.style.display = '';
          // Tampilkan kembali required pada ikon jika ada history
          if (ikonInput) ikonInput.setAttribute('required', 'required');
        } else {
          revertIkonBtn.classList.add('hidden');
          revertIkonBtn.style.display = 'none';
          // Hilangkan required pada ikon jika sudah di-revert ke awal
          if (ikonInput) ikonInput.removeAttribute('required');
        }
      }

      function setIkonPreviewAndHistory(src, isInitial = false) {
        ikonPreview.src = src;
        ikonPreview.classList.remove('hidden');
        if (ikonPlaceholder) ikonPlaceholder.classList.add('hidden');
        removeIkonBtn.classList.remove('hidden');
        removeIkonBtn.style.display = '';
        editIkonBtn.classList.remove('hidden');
        editIkonBtn.style.display = '';
        if (!isInitial) pushIkonHistory(src);
        if (window.Viewer && ikonWrapper) {
          if (!ikonWrapper.viewer) ikonWrapper.viewer = new Viewer(ikonWrapper, {
            navbar: false,
            toolbar: true
          });
          else ikonWrapper.viewer.update();
        }
      }
      // Inisialisasi preview dan history pada halaman edit
      if (ikonOriginalImageSrc) {
        setIkonPreviewAndHistory(ikonOriginalImageSrc, true);
        updateRevertIkonBtn();
      }
      if (ikonInput) ikonInput.addEventListener('change', function() {
        if (ikonInput.files && ikonInput.files[0]) {
          lastIkonFile = ikonInput.files[0];
          const reader = new FileReader();
          reader.onload = function(ev) {
            imageToCropIkon.src = ev.target.result;
            cropperModalIkon.classList.remove('hidden');
            if (cropperIkon) cropperIkon.destroy();
            cropperIkon = new Cropper(imageToCropIkon, {
              viewMode: 1,
              autoCropArea: 1,
              aspectRatio: 1, // 1:1 ratio
            });
          };
          reader.readAsDataURL(ikonInput.files[0]);
        }
      });
      if (editIkonBtn) editIkonBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (!ikonPreview.classList.contains('hidden') && ikonPreview.src && ikonPreview.src !== '#') {
          imageToCropIkon.src = ikonPreview.src;
          cropperModalIkon.classList.remove('hidden');
          if (cropperIkon) cropperIkon.destroy();
          cropperIkon = new Cropper(imageToCropIkon, {
            viewMode: 1,
            autoCropArea: 1,
            aspectRatio: 1, // 1:1 ratio
          });
        }
      });
      if (cropIkonConfirmBtn) cropIkonConfirmBtn.addEventListener('click', function() {
        if (cropperIkon) {
          cropperIkon.getCroppedCanvas().toBlob(function(blob) {
            const croppedFile = new File([blob], lastIkonFile ? lastIkonFile.name : 'cropped_ikon.jpg', {
              type: blob.type
            });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            ikonInput.files = dataTransfer.files;
            const reader = new FileReader();
            reader.onload = function(ev) {
              setIkonPreviewAndHistory(ev.target.result);
            };
            reader.readAsDataURL(croppedFile);
            cropperIkon.destroy();
            cropperIkon = null;
            cropperModalIkon.classList.add('hidden');
          }, lastIkonFile ? lastIkonFile.type : 'image/jpeg');
        }
      });
      if (cropIkonCancelBtn) cropIkonCancelBtn.addEventListener('click', function() {
        cropperModalIkon.classList.add('hidden');
        if (cropperIkon) {
          cropperIkon.destroy();
          cropperIkon = null;
        }
      });
      if (removeIkonBtn) removeIkonBtn.addEventListener('click', function() {
        setIkonPreviewAndHistory('#');
        ikonPreview.classList.add('hidden');
        if (ikonPlaceholder) ikonPlaceholder.classList.remove('hidden');
        removeIkonBtn.classList.add('hidden');
        removeIkonBtn.style.display = 'none';
        editIkonBtn.classList.add('hidden');
        editIkonBtn.style.display = 'none';
        // Jangan reset ikonHistory, agar revert tetap bisa ke original
      });
      if (revertIkonBtn) revertIkonBtn.addEventListener('click', function() {
        if (ikonHistoryPointer > 0) {
          ikonHistoryPointer--;
          const prevSrc = ikonHistory[ikonHistoryPointer];
          if (prevSrc && prevSrc !== '#') {
            ikonPreview.src = prevSrc;
            ikonPreview.classList.remove('hidden');
            if (ikonPlaceholder) ikonPlaceholder.classList.add('hidden');
            removeIkonBtn.classList.remove('hidden');
            removeIkonBtn.style.display = '';
            editIkonBtn.classList.remove('hidden');
            editIkonBtn.style.display = '';
          } else {
            ikonPreview.src = '#';
            ikonPreview.classList.add('hidden');
            if (ikonPlaceholder) ikonPlaceholder.classList.remove('hidden');
            removeIkonBtn.classList.add('hidden');
            removeIkonBtn.style.display = 'none';
            editIkonBtn.classList.add('hidden');
            editIkonBtn.style.display = 'none';
          }
          updateRevertIkonBtn();
        }
      });
      if (ikonPreview) ikonPreview.addEventListener('click', function(ev) {
        // Fix: prevent file input click, only show viewer if image is visible
        if (!ikonPreview.classList.contains('hidden') && ikonPreview.src && ikonPreview.src !== '#') {
          ev.preventDefault();
          ev.stopPropagation();
          if (ikonViewer) ikonViewer.show();
          return false;
        }
      }, true);

      // --- SLIDER MULTI INPUT ---
      const sliderInputList = document.getElementById('slider-input-list');
      const cropperModalSlider = document.getElementById('cropperModalSlider');
      const imageToCropSlider = document.getElementById('image-to-crop-slider');
      const cropSliderConfirmBtn = document.getElementById('crop-slider-confirm-btn');
      const cropSliderCancelBtn = document.getElementById('crop-slider-cancel-btn');
      let cropperSlider = null;
      let lastSliderFile = null;

      function getSliderHistoryStore(item) {
        if (!item._sliderHistory) item._sliderHistory = {
          history: [],
          pointer: -1
        };
        return item._sliderHistory;
      }

      function pushSliderHistory(item, src) {
        const store = getSliderHistoryStore(item);
        if (store.pointer < store.history.length - 1) store.history = store.history.slice(0, store.pointer + 1);
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
        if (item._sliderViewer) item._sliderViewer.update();
        // Sembunyikan tombol x jika tidak ada foto dan hanya satu input
        updateRemoveSliderBtnVisibility();
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
        // Sembunyikan tombol x jika tidak ada foto dan hanya satu input
        updateRemoveSliderBtnVisibility();
      }

      function updateAddSliderBtnVisibility() {
        const items = Array.from(sliderInputList.querySelectorAll('.slider-input-item'));
        items.forEach(function(item, idx) {
          const addBtn = item.querySelector('.add-slider-btn');
          if (addBtn) {
            if (idx === items.length - 1) addBtn.style.display = '';
            else addBtn.style.display = 'none';
          }
        });
        updateRemoveSliderBtnVisibility();
      }

      function updateRemoveSliderBtnVisibility() {
        const items = Array.from(sliderInputList.querySelectorAll('.slider-input-item'));
        items.forEach(function(item) {
          const removeBtn = item.querySelector('.remove-slider-btn');
          const preview = item.querySelector('.slider-preview');
          // Jika hanya satu input dan tidak ada foto, sembunyikan tombol x
          if (items.length === 1 && (preview.classList.contains('hidden') || !preview.src || preview.src ===
              '#')) {
            if (removeBtn) removeBtn.classList.add('hidden');
          } else {
            if (removeBtn) removeBtn.classList.remove('hidden');
          }
        });
      }

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
          // Cek apakah slider lama (punya data-slider-id)
          const sliderId = item.getAttribute('data-slider-id');
          if (sliderId) {
            // Tambahkan input hidden hapus_slider[]
            let form = item.closest('form');
            if (!form) form = document.querySelector('form');
            if (form && !form.querySelector('input[name="hapus_slider[]"][value="' + sliderId + '"]')) {
              const input = document.createElement('input');
              input.type = 'hidden';
              input.name = 'hapus_slider[]';
              input.value = sliderId;
              form.appendChild(input);
            }
            item.remove();
            // Tambahkan minimal satu form slider jika sudah tidak ada lagi
            if (sliderInputList.querySelectorAll('.slider-input-item').length === 0) {
              const newItem = createSliderInputItem();
              sliderInputList.appendChild(newItem);
              initSliderViewer(newItem);
            }
            updateAddSliderBtnVisibility();
          } else {
            // Slider baru (belum ada id), reset preview saja
            if (sliderInputList.children.length > 1) {
              item.remove();
              updateAddSliderBtnVisibility();
            } else {
              resetSliderPreview(item);
              const input = item.querySelector('.slider-input');
              if (input) input.value = '';
              item._sliderHistory = {
                history: [],
                pointer: -1
              };
              updateRevertSliderBtn(item);
            }
          }
        }
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

      function updateAddSliderBtnVisibility() {
        const items = Array.from(sliderInputList.querySelectorAll('.slider-input-item'));
        items.forEach(function(item, idx) {
          const addBtn = item.querySelector('.add-slider-btn');
          if (addBtn) {
            if (idx === items.length - 1) addBtn.style.display = '';
            else addBtn.style.display = 'none';
          }
        });
        updateRemoveSliderBtnVisibility();
      }

      function updateRemoveSliderBtnVisibility() {
        const items = Array.from(sliderInputList.querySelectorAll('.slider-input-item'));
        items.forEach(function(item) {
          const removeBtn = item.querySelector('.remove-slider-btn');
          const preview = item.querySelector('.slider-preview');
          // Jika hanya satu input dan tidak ada foto, sembunyikan tombol x
          if (items.length === 1 && (preview.classList.contains('hidden') || !preview.src || preview.src ===
              '#')) {
            if (removeBtn) removeBtn.classList.add('hidden');
          } else {
            if (removeBtn) removeBtn.classList.remove('hidden');
          }
        });
      }
      Array.from(sliderInputList.querySelectorAll('.slider-input-item')).forEach(function(item) {
        initSliderViewer(item);
      });
      updateAddSliderBtnVisibility();

      function initSliderViewer(item) {
        const wrapper = item;
        if (wrapper && window.Viewer) {
          if (wrapper._sliderViewer) {
            wrapper._sliderViewer.destroy();
            wrapper._sliderViewer = null;
          }
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
              return image.classList.contains('slider-preview') && !image.classList.contains('hidden') && image
                .src && image.src !== '#';
            }
          });
        }
      }
      Array.from(sliderInputList.querySelectorAll('.slider-input-item')).forEach(function(item) {
        initSliderViewer(item);
      });
      sliderInputList.addEventListener('click', function(e) {
        const preview = e.target.closest('.slider-preview');
        if (preview && !preview.classList.contains('hidden') && preview.src && preview.src !== '#') {
          e.preventDefault();
          e.stopPropagation();
          const item = preview.closest('.slider-input-item');
          if (item && item._sliderViewer) item._sliderViewer.show();
          return false;
        }
      }, true);
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

      function replaceEventListener(el, event, handler) {
        const clone = el.cloneNode(true);
        el.parentNode.replaceChild(clone, el);
        clone.addEventListener(event, handler);
        return clone;
      }
      window.initCropperSliderModalButtons = function() {
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
      window.initCropperSliderModalButtons();

      // --- Required dinamis ikon/organigram ---
      function toggleRequiredIkonOrganigram() {
        const isSubbagian = document.getElementById('is_subbagian').checked;
        const isFungsional = document.getElementById('is_jabatan_fungsional').checked;
        const ikonInput = document.getElementById('ikon_jabatan');
        const ikonRequired = document.getElementById('ikon-required');
        const organigramInput = document.getElementById('foto_organigram');
        const organigramRequired = document.getElementById('organigram-required');
        const required = !(isSubbagian || isFungsional);
      }
      document.getElementById('is_subbagian').addEventListener('change', function() {
        toggleRequiredIkonOrganigram();
      });
      document.getElementById('is_jabatan_fungsional').addEventListener('change', function() {
        toggleRequiredIkonOrganigram();
      });
      toggleRequiredIkonOrganigram();
    });
  </script>
@endsection
