@extends('admin.layout')

@section('document.head')
  @vite([
    'resources/css/quill.css',
    'resources/css/viewerjs.css',
    'resources/css/cropperjs.css'
  ])
@endsection

@section('document.body')
  <form action="{{ route('admin.struktur-organisasi.susunan-organisasi.update', $susunan->id_susunan_organisasi) }}"
    method="POST" enctype="multipart/form-data" id="form-susunan-organisasi">
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
      <label for="tupoksi_susunan_organisasi" class="block text-sm font-medium text-gray-700 mb-1">Tupoksi Susunan
        Organisasi</label>
      <input id="tupoksi_susunan_organisasi" type="hidden" name="tupoksi_susunan_organisasi"
        value="{{ $susunan->tupoksi_susunan_organisasi }}">
      <div id="quill-editor-tupoksi"></div>
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
   'resources/js/quill.js',
   'resources/js/viewerjs.js',
   'resources/js/cropperjs.js',
   'resources/js/shared/crop-uploader.js',
   'resources/js/shared/rich-text-editor.js'
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
      // === Upload+crop foto - lihat resources/js/shared/crop-uploader.js.
      // Slider (multi input dinamis) di bawah tetap ditulis manual karena
      // strukturnya beda (banyak input sekaligus, bukan satu field tetap).

      // Field organigram/ikon wajib diisi HANYA saat gambar sedang
      // diganti/dihapus dari yang sudah ada (ditandai tombol "kembalikan"
      // ikut muncul) - kalau dibiarkan seperti semula, tidak perlu upload
      // ulang. Dipantau lewat perubahan class tombol revert, supaya tidak
      // bergantung pada tombol mana persisnya yang memicu perubahan itu.
      function syncRequiredWithRevertBtn(inputSelector, revertBtnSelector) {
        const inputEl = document.querySelector(inputSelector);
        const revertBtn = document.querySelector(revertBtnSelector);
        if (!inputEl || !revertBtn) return;

        function sync() {
          if (revertBtn.classList.contains('hidden')) {
            inputEl.removeAttribute('required');
          } else {
            inputEl.setAttribute('required', 'required');
          }
        }

        sync();
        new MutationObserver(sync).observe(revertBtn, { attributes: true, attributeFilter: ['class'] });
      }

      // --- ORGANIGRAM ---
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
      // Ekstra: field organigram wajib diisi HANYA saat gambar sedang
      // diganti/dihapus dari yang sudah ada (revertBtn ikut muncul) - kalau
      // dibiarkan seperti semula (tidak diubah), tidak perlu upload ulang.
      syncRequiredWithRevertBtn('#foto_organigram', '#revert-foto-btn');

      // --- IKON ---
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
      syncRequiredWithRevertBtn('#ikon_jabatan', '#revert-ikon-btn');

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
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      window.initRichTextEditor({
        selector: '#quill-editor-tupoksi',
        placeholder: 'Tulis tupoksi susunan organisasi di sini...',
        hiddenInputSelector: '#tupoksi_susunan_organisasi',
        formSelector: '#form-susunan-organisasi',
      });
    });
  </script>
@endsection