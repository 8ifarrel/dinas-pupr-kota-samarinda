@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/cropperjs.css', 'resources/css/viewerjs.css'])
  <style>
    .foto-placeholder { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; }
    .foto-preview { background: #fff; }
  </style>
@endsection

@section('document.body')
  <form action="{{ route('admin.album-kegiatan.foto-kegiatan.store', $album->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Foto Kegiatan (bisa lebih dari satu)</label>
      <div id="foto-kegiatan-list" class="flex flex-row gap-2 overflow-x-auto pb-1">
        <div>
          <div class="relative group foto-kegiatan-input-item flex-shrink-0 w-[220px] sm:min-w-[300px]">
            <label class="flex flex-col items-center justify-center w-full aspect-[4/3] border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0">
              <div class="foto-placeholder flex flex-col items-center justify-center pt-5 pb-6 absolute inset-0 w-full h-full">
                <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
                </svg>
                <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload foto kegiatan</p>
                <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
              </div>
              <img class="foto-preview hidden absolute inset-0 w-full h-full object-contain rounded-lg bg-white" />
              <input name="foto[]" type="file" accept="image/*" class="hidden foto-input" required />
            </label>
            <button type="button" class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-foto-btn hidden" title="Hapus foto">
              <i class="fa-solid fa-xmark"></i>
            </button>
            <a type="button" class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 edit-foto-button hidden">
              <i class="fa-solid fa-crop-simple"></i>
            </a>
            <button type="button" class="w-[30px] h-[30px] bg-white rounded-full text-blue-600 hover:text-blue-800 shadow-lg border border-black flex items-center justify-center absolute top-2 left-2 z-10 add-foto-btn" title="Tambah foto">
              <i class="fa-solid fa-plus"></i>
            </button>
          </div>
          <textarea name="caption[]" rows="3" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-xs resize-none" placeholder="Deskripsi singkat (opsional)"></textarea>
        </div>
      </div>
      <div class="text-gray-500 text-sm">Gunakan tombol "+" untuk menambah foto lagi.</div>
    </div>
    <div class="mb-4">
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
      <a href="{{ route('admin.album-kegiatan.show', $album->id) }}" class="ml-2 px-4 py-2 bg-gray-300 rounded-md">Batal</a>
    </div>

    <!-- Modal CropperJS untuk foto kegiatan -->
    <div id="cropperModalFotoKegiatan" tabindex="-1" aria-hidden="true"
      class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl relative mx-4 md:mx-5">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
          <h3 class="text-xl font-semibold text-gray-900">
            Crop Foto Kegiatan
          </h3>
        </div>
        <div class="m-4 md:m-5 flex justify-center items-center" style="min-height:200px;">
          <img id="image-to-crop-foto-kegiatan" src="" class="max-h-[50vh] max-w-full block rounded border"
            alt="Image to crop" style="background:#f3f4f6;" />
        </div>
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b space-x-3">
          <button type="button" id="crop-foto-kegiatan-confirm-btn" class="px-4 py-2 bg-blue-700 text-white rounded">
            Crop & Gunakan
          </button>
          <button type="button" id="crop-foto-kegiatan-cancel-btn" class="px-4 py-2 bg-gray-300 rounded">
            Batal
          </button>
        </div>
      </div>
    </div>
  </form>
@endsection

@section('document.end')
  @vite(['resources/js/cropperjs.js', 'resources/js/viewerjs.js'])
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const fotoKegiatanList = document.getElementById('foto-kegiatan-list');
      const cropperModal = document.getElementById('cropperModalFotoKegiatan');
      const imageToCrop = document.getElementById('image-to-crop-foto-kegiatan');
      const cropConfirmBtn = document.getElementById('crop-foto-kegiatan-confirm-btn');
      const cropCancelBtn = document.getElementById('crop-foto-kegiatan-cancel-btn');
      let cropper = null;
      let lastFile = null;

      function createFotoInputItem() {
        const isFirst = document.querySelectorAll('.foto-kegiatan-input-item').length === 0;
        const requiredAttr = isFirst ? 'required' : '';
        const html = `
        <div>
          <div class="relative group foto-kegiatan-input-item flex-shrink-0 w-[220px] sm:min-w-[300px]">
            <label class="flex flex-col items-center justify-center w-full aspect-[4/3] border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0">
              <div class="foto-placeholder flex flex-col items-center justify-center pt-5 pb-6 absolute inset-0 w-full h-full">
                <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
                </svg>
                <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload foto kegiatan</p>
                <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
              </div>
              <img class="foto-preview hidden absolute inset-0 w-full h-full object-contain rounded-lg bg-white" />
              <input name="foto[]" type="file" accept="image/*" class="hidden foto-input" ${requiredAttr} />
            </label>
            <button type="button" class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-foto-btn hidden" title="Hapus foto">
              <i class="fa-solid fa-xmark"></i>
            </button>
            <a type="button" class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 edit-foto-button hidden">
              <i class="fa-solid fa-crop-simple"></i>
            </a>
            <button type="button" class="w-[30px] h-[30px] bg-white rounded-full text-blue-600 hover:text-blue-800 shadow-lg border border-black flex items-center justify-center absolute top-2 left-2 z-10 add-foto-btn" title="Tambah foto">
              <i class="fa-solid fa-plus"></i>
            </button>
          </div>
          <textarea name="caption[]" rows="3" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-xs resize-none" placeholder="Deskripsi singkat (opsional)"></textarea>
        </div>
        `;
        const temp = document.createElement('div');
        temp.innerHTML = html.trim();
        return temp.firstChild;
      }
      function updateAddFotoBtnVisibility() {
        const items = Array.from(fotoKegiatanList.querySelectorAll('.foto-kegiatan-input-item'));
        items.forEach(function(item, idx) {
          const addBtn = item.querySelector('.add-foto-btn');
          if (addBtn) {
            if (idx === items.length - 1) {
              addBtn.style.display = '';
            } else {
              addBtn.style.display = 'none';
            }
          }
        });
      }
      function initFotoViewer(item) {
        const wrapper = item;
        if (wrapper && window.Viewer) {
          if (wrapper._fotoViewer) {
            wrapper._fotoViewer.destroy();
            wrapper._fotoViewer = null;
          }
          const img = wrapper.querySelector('.foto-preview');
          if (img) img.removeAttribute('style');
          wrapper._fotoViewer = new Viewer(wrapper, {
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
              return image.classList.contains('foto-preview') && !image.classList.contains('hidden') && image.src && image.src !== '#';
            }
          });
        }
      }
      Array.from(fotoKegiatanList.querySelectorAll('.foto-kegiatan-input-item')).forEach(function(item) {
        initFotoViewer(item);
      });
      updateAddFotoBtnVisibility();

      fotoKegiatanList.addEventListener('click', function(e) {
        if (e.target.closest('.add-foto-btn')) {
          e.preventDefault();
          const newItem = createFotoInputItem();
          fotoKegiatanList.appendChild(newItem);
          initFotoViewer(newItem);
          updateAddFotoBtnVisibility();
        }
        if (e.target.closest('.remove-foto-btn')) {
          e.preventDefault();
          const item = e.target.closest('.foto-kegiatan-input-item');
          if (item) {
            if (fotoKegiatanList.children.length > 1) {
              item.parentElement.remove();
              updateAddFotoBtnVisibility();
            } else {
              // Reset preview
              const preview = item.querySelector('.foto-preview');
              const placeholder = item.querySelector('.foto-placeholder');
              const removeBtn = item.querySelector('.remove-foto-btn');
              const editBtn = item.querySelector('.edit-foto-button');
              preview.src = '#';
              preview.classList.add('hidden');
              if (placeholder) placeholder.classList.remove('hidden');
              if (removeBtn) removeBtn.classList.add('hidden');
              if (editBtn) editBtn.classList.add('hidden');
              const input = item.querySelector('.foto-input');
              if (input) input.value = '';
            }
          }
        }
      });
      fotoKegiatanList.addEventListener('change', function(e) {
        const input = e.target.closest('.foto-input');
        if (input && input.files && input.files[0]) {
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
            cropperModal.currentInput = input;
          };
          reader.readAsDataURL(input.files[0]);
        }
      });
      fotoKegiatanList.addEventListener('click', function(e) {
        const editBtn = e.target.closest('.edit-foto-button');
        if (editBtn) {
          e.preventDefault();
          const item = editBtn.closest('.foto-kegiatan-input-item');
          const preview = item.querySelector('.foto-preview');
          if (!preview.classList.contains('hidden') && preview.src && preview.src !== '#') {
            imageToCrop.src = preview.src;
            cropperModal.classList.remove('hidden');
            if (cropper) cropper.destroy();
            cropper = new Cropper(imageToCrop, {
              viewMode: 1,
              autoCropArea: 1
            });
            cropperModal.currentInput = item.querySelector('.foto-input');
          }
        }
      });
      fotoKegiatanList.addEventListener('click', function(e) {
        const preview = e.target.closest('.foto-preview');
        if (preview && !preview.classList.contains('hidden') && preview.src && preview.src !== '#') {
          e.preventDefault();
          e.stopPropagation();
          const item = preview.closest('.foto-kegiatan-input-item');
          if (item && item._fotoViewer) {
            item._fotoViewer.show();
          }
          return false;
        }
      });
      cropConfirmBtn.addEventListener('click', function() {
        if (cropper && cropperModal.currentInput) {
          cropper.getCroppedCanvas().toBlob(function(blob) {
            const croppedFile = new File([blob], lastFile ? lastFile.name : 'cropped_foto_kegiatan.jpg', {
              type: blob.type
            });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            cropperModal.currentInput.files = dataTransfer.files;
            const item = cropperModal.currentInput.closest('.foto-kegiatan-input-item');
            const preview = item.querySelector('.foto-preview');
            const placeholder = item.querySelector('.foto-placeholder');
            const removeBtn = item.querySelector('.remove-foto-btn');
            const editBtn = item.querySelector('.edit-foto-button');
            const reader = new FileReader();
            reader.onload = function(ev) {
              preview.src = ev.target.result;
              preview.classList.remove('hidden');
              if (placeholder) placeholder.classList.add('hidden');
              if (removeBtn) removeBtn.classList.remove('hidden');
              if (editBtn) editBtn.classList.remove('hidden');
              if (item._fotoViewer) item._fotoViewer.update();
            };
            reader.readAsDataURL(croppedFile);
            cropper.destroy();
            cropper = null;
            cropperModal.classList.add('hidden');
            cropperModal.currentInput = null;
          }, lastFile ? lastFile.type : 'image/jpeg');
        }
      });
      cropCancelBtn.addEventListener('click', function() {
        cropperModal.classList.add('hidden');
        if (cropper) {
          cropper.destroy();
          cropper = null;
        }
        cropperModal.currentInput = null;
      });
    });
  </script>
@endsection
