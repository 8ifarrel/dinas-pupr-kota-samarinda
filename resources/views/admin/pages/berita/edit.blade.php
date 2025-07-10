@extends('admin.layouts.partner')

@section('css')
  <link href="https://unpkg.com/trix/dist/trix.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.3/viewer.min.css" rel="stylesheet"/>
  <link href="https://unpkg.com/cropperjs@1.6.1/dist/cropper.min.css" rel="stylesheet"/>
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

    /*
		 * Fixing Trix Editor style when using Tailwind CSS
		 * Based on solution by Muhammad Jamil
		 * https://dev.to/fanreza/resolving-problem-when-using-trix-rich-editor-with-tailwind-13ca
		 */

    trix-editor {
      @apply block w-full border border-gray-300 rounded-md p-3 prose prose-sm prose-slate dark:prose-invert;
      min-height: 200px;
      overflow-y: auto;
      background-color: white;
    }

    trix-editor h1 {
      font-size: 1.25rem !important;
      line-height: 1.75rem !important;
      margin-bottom: 1rem !important;
      font-weight: 600 !important;
    }

    trix-editor h2 {
      font-size: 1.125rem !important;
      line-height: 1.5rem !important;
      margin-bottom: 0.75rem !important;
      font-weight: 600 !important;
    }

    trix-editor h3 {
      font-size: 1rem !important;
      line-height: 1.5rem !important;
      margin-bottom: 0.5rem !important;
      font-weight: 500 !important;
    }

    trix-editor p {
      margin-bottom: 1rem !important;
      line-height: 1.625 !important;
    }

    trix-editor pre {
      background-color: #f3f4f6 !important;
      padding: 1rem !important;
      border-radius: 0.375rem !important;
      overflow-x: auto;
      font-family: monospace;
      font-size: 0.875rem;
    }

    trix-editor ul {
      list-style-type: disc !important;
      padding-left: 1.25rem !important;
      margin-bottom: 1rem !important;
    }

    trix-editor ol {
      list-style-type: decimal !important;
      padding-left: 1.25rem !important;
      margin-bottom: 1rem !important;
    }

    trix-editor li {
      margin-bottom: 0.5rem !important;
    }

    trix-editor blockquote {
      border-left: 4px solid #d1d5db !important;
      padding-left: 1rem !important;
      color: #6b7280 !important;
      font-style: italic !important;
      margin-bottom: 1rem !important;
    }

    trix-editor a:not(.no-underline) {
      text-decoration: underline !important;
      color: #3b82f6 !important;
    }

    trix-editor a:visited {
      color: #6366f1 !important;
    }

    trix-editor img {
      max-width: 100% !important;
      height: auto !important;
      display: block;
      margin: 1rem 0 !important;
      border-radius: 0.375rem;
    }

    trix-editor hr {
      border: none;
      border-top: 1px solid #e5e7eb;
      margin: 2rem 0;
    }

    trix-editor strong {
      font-weight: 600 !important;
    }

    trix-editor em {
      font-style: italic !important;
    }

    .foto-viewer-wrapper { height: 220px; }
    .foto-placeholder { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; }
    .foto-preview { background: #fff; }
  </style>
@endsection

@section('slot')
  <form action="{{ route('admin.berita.update', $berita->uuid_berita) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="id_berita_kategori" value="{{ $kategori->id_berita_kategori }}">

    <div class="mb-4">
      <label for="judul_berita" class="block text-sm font-medium text-gray-700">Judul Berita</label>
      <input type="text" name="judul_berita" id="judul_berita" value="{{ $berita->judul_berita }}"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
    </div>

    <div class="mb-4">
      <label for="foto_berita" class="block text-sm font-medium text-gray-700">Foto Berita</label>
      <span class="text-xs text-gray-700">Kosongi bagian ini jika tetap ingin menggunakan foto sebelumnya</span>
      <div class="relative group foto-viewer-wrapper h-28 sm:h-32">
        <label
          class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0"
          tabindex="0">
          <div class="foto-placeholder flex flex-col items-center justify-center pt-5 pb-6 {{ $berita->foto_berita ? 'hidden' : '' }}">
            <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
            </svg>
            <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload foto berita</p>
            <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
          </div>
          <img id="foto-preview"
            class="foto-preview absolute inset-0 w-full h-full object-contain rounded-lg bg-white aspect-[16/9] {{ $berita->foto_berita ? '' : 'hidden' }}"
            src="{{ $berita->foto_berita ? Storage::url($berita->foto_berita) : '' }}" />
          <input name="foto_berita" id="foto_berita" type="file" accept="image/*"
            class="hidden foto-input" />
        </label>
        <button type="button"
          class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-foto-btn {{ $berita->foto_berita ? '' : 'hidden' }}"
          title="Hapus foto" id="remove-foto-btn">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <button type="button"
          class="w-[30px] h-[30px] bg-white rounded-full text-green-600 hover:text-green-800 shadow-lg border border-black flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-10 revert-foto-btn hidden"
          title="Kembalikan foto sebelumnya" id="revert-foto-btn">
          <i class="fa-solid fa-rotate-right"></i>
        </button>
        <a type="button" id="edit-foto-button"
          class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 {{ $berita->foto_berita ? '' : 'hidden' }}">
          <i class="fa-solid fa-crop-simple"></i>
        </a>
      </div>
    </div>

    <div class="mb-4">
      <label for="sumber_foto_berita" class="block text-sm font-medium text-gray-700">Sumber Foto Berita</label>
      <input type="text" name="sumber_foto_berita" id="sumber_foto_berita" value="{{ $berita->sumber_foto_berita }}"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" />
    </div>

    <div class="mb-4">
      <label for="isi_berita" class="block text-sm font-medium text-gray-700">Isi Berita</label>
      <input id="isi_berita" type="hidden" name="isi_berita" value="{{ $berita->isi_berita }}">
      <trix-editor input="isi_berita"></trix-editor>
    </div>

    <div class="mb-4">
      <label for="preview_berita" class="block text-sm font-medium text-gray-700">Preview Berita</label>
      <input type="text" name="preview_berita" id="preview_berita" value="{{ $berita->preview_berita }}"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
    </div>

    <div class="mb-4">
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
    </div>
  </form>

  <!-- Modal CropperJS untuk foto berita -->
  <div id="cropperModalFoto" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl relative mx-4 md:mx-5">
      <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
        <h3 class="text-xl font-semibold text-gray-900">
          Crop Foto Berita
        </h3>
      </div>
      <div class="m-4 md:m-5 flex justify-center items-center" style="min-height:200px;">
        <img id="image-to-crop-foto" src="" class="max-h-[50vh] max-w-full block rounded border"
          alt="Image to crop" style="background:#f3f4f6;" />
      </div>
      <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b space-x-3">
        <button type="button" id="crop-foto-confirm-btn" class="px-4 py-2 bg-blue-700 text-white rounded">
          Crop & Gunakan
        </button>
        <button type="button" id="crop-foto-cancel-btn" class="px-4 py-2 bg-gray-300 rounded">
          Batal
        </button>
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
      const input = document.getElementById('foto_berita');
      const preview = document.getElementById('foto-preview');
      const placeholder = wrapper.querySelector('.foto-placeholder');
      const removeBtn = document.getElementById('remove-foto-btn');
      const revertBtn = document.getElementById('revert-foto-btn');
      const editBtn = document.getElementById('edit-foto-button');
      const cropperModal = document.getElementById('cropperModalFoto');
      const imageToCrop = document.getElementById('image-to-crop-foto');
      const cropConfirmBtn = document.getElementById('crop-foto-confirm-btn');
      const cropCancelBtn = document.getElementById('crop-foto-cancel-btn');
      let cropper = null;
      let lastFile = null;
      let viewer = null;
      if (wrapper && window.Viewer) {
        viewer = new Viewer(wrapper, {
          navbar: false, toolbar: true, title: false, tooltip: false, movable: false, zoomable: true, scalable: false, transition: true, fullscreen: false
        });
      }
      let imageHistory = [];
      let historyPointer = -1;
      let originalImageSrc = preview && preview.src && !preview.classList.contains('hidden') && preview.src !== '#' ? preview.src : null;
      if (originalImageSrc) {
        imageHistory = [originalImageSrc];
        historyPointer = 0;
      }
      function pushHistory(src) {
        if (historyPointer < imageHistory.length - 1) imageHistory = imageHistory.slice(0, historyPointer + 1);
        imageHistory.push(src); historyPointer = imageHistory.length - 1; updateRevertBtn();
      }
      function updateRevertBtn() {
        if (historyPointer > 0) {
          revertBtn.classList.remove('hidden'); revertBtn.style.display = '';
        } else {
          revertBtn.classList.add('hidden'); revertBtn.style.display = 'none';
        }
      }
      function setPreviewAndHistory(src, isInitial = false) {
        preview.src = src; preview.classList.remove('hidden'); placeholder.classList.add('hidden');
        removeBtn.classList.remove('hidden'); removeBtn.disabled = false; editBtn.classList.remove('hidden'); editBtn.style.display = '';
        if (!isInitial) pushHistory(src);
        if (viewer) viewer.update();
      }
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
            cropper = new Cropper(imageToCrop, {viewMode: 1, autoCropArea: 1, aspectRatio: 16 / 9});
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
          cropper = new Cropper(imageToCrop, {viewMode: 1, autoCropArea: 1, aspectRatio: 16 / 9});
        }
      });
      if (cropConfirmBtn) cropConfirmBtn.addEventListener('click', function() {
        if (cropper) {
          cropper.getCroppedCanvas().toBlob(function(blob) {
            const croppedFile = new File([blob], lastFile ? lastFile.name : 'cropped_berita.jpg', {type: blob.type});
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            input.files = dataTransfer.files;
            const reader = new FileReader();
            reader.onload = function(ev) { setPreviewAndHistory(ev.target.result); };
            reader.readAsDataURL(croppedFile);
            cropper.destroy(); cropper = null; cropperModal.classList.add('hidden');
          }, lastFile ? lastFile.type : 'image/jpeg');
        }
      });
      if (cropCancelBtn) cropCancelBtn.addEventListener('click', function() {
        cropperModal.classList.add('hidden');
        if (cropper) { cropper.destroy(); cropper = null; }
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
            preview.src = prevSrc; preview.classList.remove('hidden'); placeholder.classList.add('hidden');
            removeBtn.classList.remove('hidden'); removeBtn.disabled = false; editBtn.classList.remove('hidden'); editBtn.style.display = '';
          } else {
            preview.src = '#'; preview.classList.add('hidden'); placeholder.classList.remove('hidden');
            removeBtn.classList.add('hidden'); removeBtn.disabled = true; editBtn.classList.add('hidden'); editBtn.style.display = 'none';
          }
          updateRevertBtn();
        }
      });
      if (preview && (preview.classList.contains('hidden') || !preview.src || preview.src === '#')) {
        editBtn.classList.add('hidden'); editBtn.style.display = 'none';
      } else {
        editBtn.classList.remove('hidden'); editBtn.style.display = '';
      }
      if (preview) preview.addEventListener('click', function(ev) {
        ev.preventDefault(); ev.stopPropagation();
        if (viewer && !preview.classList.contains('hidden') && preview.src && preview.src !== '#') viewer.show();
        return false;
      });
    });
  </script>
@endsection

