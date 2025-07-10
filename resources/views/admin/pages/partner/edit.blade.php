@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/cropperjs.css', 'resources/css/viewerjs.css'])

  <style>
    .partner-viewer-wrapper {
      height: 220px;
    }

    .partner-placeholder {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
    }

    .partner-preview {
      background: #fff;
    }
  </style>
@endsection

@section('document.body')
  <form action="{{ route('admin.partner.update', $partner->id_partner) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-4">
      <label for="nama_partner" class="block text-sm font-medium text-gray-700">Nama Partner</label>
      <input type="text" name="nama_partner" id="nama_partner" value="{{ $partner->nama_partner }}"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
    </div>

    <div class="mb-4">
      <label for="url_partner" class="block text-sm font-medium text-gray-700">URL Partner</label>
      <input type="url" name="url_partner" id="url_partner" value="{{ $partner->url_partner }}"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
    </div>

    <div class="mb-4">
      <label for="foto_partner" class="block text-sm font-medium text-gray-700">Foto Partner</label>
      <span class="text-xs text-gray-700">Kosongi bagian ini jika tetap ingin menggunakan foto sebelumnya</span>
      <div class="relative group partner-viewer-wrapper h-28 sm:h-32">
        <label
          class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0"
          tabindex="0">
          <div
            class="partner-placeholder flex flex-col items-center justify-center pt-5 pb-6 {{ $partner->foto_partner ? 'hidden' : '' }}">
            <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
            </svg>
            <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload foto partner</p>
            <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
          </div>
          <img id="partner-preview"
            class="partner-preview absolute inset-0 w-full h-full object-contain rounded-lg bg-white {{ $partner->foto_partner ? '' : 'hidden' }}"
            src="{{ $partner->foto_partner ? Storage::url($partner->foto_partner) : '' }}" />
          <input name="foto_partner" id="foto_partner" type="file" accept="image/*" class="hidden partner-input" />
        </label>
        <button type="button"
          class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-partner-btn {{ $partner->foto_partner ? '' : 'hidden' }}"
          title="Hapus foto" id="remove-partner-btn">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <button type="button"
          class="w-[30px] h-[30px] bg-white rounded-full text-green-600 hover:text-green-800 shadow-lg border border-black flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-10 revert-partner-btn hidden"
          title="Kembalikan foto sebelumnya" id="revert-partner-btn">
          <i class="fa-solid fa-rotate-right"></i>
        </button>
        <a type="button" id="edit-partner-button"
          class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 {{ $partner->foto_partner ? '' : 'hidden' }}">
          <i class="fa-solid fa-crop-simple"></i>
        </a>
      </div>
    </div>

    <div class="mb-4">
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
    </div>
  </form>

  <!-- Modal CropperJS untuk partner -->
  <div id="cropperModalPartner" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl relative mx-4 md:mx-5">
      <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
        <h3 class="text-xl font-semibold text-gray-900">
          Crop Foto Partner
        </h3>
      </div>
      <div class="m-4 md:m-5 flex justify-center items-center" style="min-height:200px;">
        <img id="image-to-crop-partner" src="" class="max-h-[50vh] max-w-full block rounded border"
          alt="Image to crop" style="background:#f3f4f6;" />
      </div>
      <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b space-x-3">
        <button type="button" id="crop-partner-confirm-btn" class="px-4 py-2 bg-blue-700 text-white rounded">
          Crop & Gunakan
        </button>
        <button type="button" id="crop-partner-cancel-btn" class="px-4 py-2 bg-gray-300 rounded">
          Batal
        </button>
      </div>
    </div>
  </div>
@endsection

@section('document.end')
  @vite(['resources/js/cropperjs.js', 'resources/js/viewerjs.js'])

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const wrapper = document.querySelector('.partner-viewer-wrapper');
      const input = document.getElementById('foto_partner');
      const preview = document.getElementById('partner-preview');
      const placeholder = wrapper.querySelector('.partner-placeholder');
      const removeBtn = document.getElementById('remove-partner-btn');
      const revertBtn = document.getElementById('revert-partner-btn');
      const editBtn = document.getElementById('edit-partner-button');
      const cropperModal = document.getElementById('cropperModalPartner');
      const imageToCrop = document.getElementById('image-to-crop-partner');
      const cropConfirmBtn = document.getElementById('crop-partner-confirm-btn');
      const cropCancelBtn = document.getElementById('crop-partner-cancel-btn');
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
      let partnerHistory = [];
      let partnerHistoryPointer = -1;
      let originalImageSrc = preview && preview.src && !preview.classList.contains('hidden') && preview.src !== '#' ?
        preview.src : null;
      if (originalImageSrc) {
        partnerHistory = [originalImageSrc];
        partnerHistoryPointer = 0;
      }

      function pushPartnerHistory(src) {
        if (partnerHistoryPointer < partnerHistory.length - 1) partnerHistory = partnerHistory.slice(0,
          partnerHistoryPointer + 1);
        partnerHistory.push(src);
        partnerHistoryPointer = partnerHistory.length - 1;
        updateRevertPartnerBtn();
      }

      function updateRevertPartnerBtn() {
        if (partnerHistoryPointer > 0) {
          revertBtn.classList.remove('hidden');
          revertBtn.style.display = '';
        } else {
          revertBtn.classList.add('hidden');
          revertBtn.style.display = 'none';
        }
      }

      function setPartnerPreviewAndHistory(src, isInitial = false) {
        preview.src = src;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
        removeBtn.classList.remove('hidden');
        removeBtn.disabled = false;
        editBtn.classList.remove('hidden');
        editBtn.style.display = '';
        if (!isInitial) pushPartnerHistory(src);
        if (viewer) viewer.update();
      }
      if (originalImageSrc) {
        setPartnerPreviewAndHistory(originalImageSrc, true);
        updateRevertPartnerBtn();
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
            const croppedFile = new File([blob], lastFile ? lastFile.name : 'cropped_partner.jpg', {
              type: blob.type
            });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            input.files = dataTransfer.files;
            const reader = new FileReader();
            reader.onload = function(ev) {
              setPartnerPreviewAndHistory(ev.target.result);
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
        setPartnerPreviewAndHistory('#');
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
        removeBtn.classList.add('hidden');
        removeBtn.disabled = true;
        editBtn.classList.add('hidden');
        editBtn.style.display = 'none';
      });
      if (revertBtn) revertBtn.addEventListener('click', function() {
        if (partnerHistoryPointer > 0) {
          partnerHistoryPointer--;
          const prevSrc = partnerHistory[partnerHistoryPointer];
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
          updateRevertPartnerBtn();
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
        ev.preventDefault();
        ev.stopPropagation();
        if (viewer && !preview.classList.contains('hidden') && preview.src && preview.src !== '#') viewer.show();
        return false;
      });
    });
  </script>
@endsection
