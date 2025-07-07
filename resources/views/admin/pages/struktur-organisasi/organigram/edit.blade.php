@extends('admin.layouts.struktur-organisasi')

@section('css')
  <link href="https://unpkg.com/cropperjs@1.6.1/dist/cropper.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.3/viewer.min.css" rel="stylesheet" />
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

@section('slot')
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

  <!-- Modal CropperJS untuk organigram -->
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

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.3/viewer.min.js"></script>
  <script src="https://unpkg.com/cropperjs@1.6.1/dist/cropper.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
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
        } else {
          revertBtn.classList.add('hidden');
          revertBtn.style.display = 'none';
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

      preview.addEventListener('click', function(ev) {
        ev.preventDefault();
        ev.stopPropagation();
        if (viewer && !preview.classList.contains('hidden') && preview.src && preview.src !== '#') {
          viewer.show();
        }
        return false;
      });

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
      preview.addEventListener('click', function(ev) {
        ev.preventDefault();
        ev.stopPropagation();
        if (viewer && !preview.classList.contains('hidden') && preview.src && preview.src !== '#') {
          viewer.show()
        };
        return false;
      });
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
