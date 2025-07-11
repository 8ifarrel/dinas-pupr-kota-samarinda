@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/cropperjs.css', 'resources/css/viewerjs.css'])
  <style>
    .foto-viewer-wrapper { height: 220px; }
    .foto-placeholder { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; }
    .foto-preview { background: #fff; }
  </style>
@endsection

@section('document.body')
  <form action="{{ route('admin.album-kegiatan.foto-kegiatan.update', [$album->id, $foto->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Foto Kegiatan</label>
      <div class="relative group foto-viewer-wrapper w-[220px] sm:min-w-[300px]">
        <label class="flex flex-col items-center justify-center w-full aspect-[4/3] border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0">
          <div class="foto-placeholder flex flex-col items-center justify-center pt-5 pb-6 absolute inset-0 w-full h-full {{ $foto->foto ? 'hidden' : '' }}">
            <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
            </svg>
            <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload foto kegiatan</p>
            <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
          </div>
          <img class="foto-preview absolute inset-0 w-full h-full object-contain rounded-lg bg-white {{ $foto->foto ? '' : 'hidden' }}"
            src="{{ $foto->foto ? Storage::url($foto->foto) : '' }}" />
          <input name="foto" type="file" accept="image/*" class="hidden foto-input" />
        </label>
        <button type="button" class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-foto-btn {{ $foto->foto ? '' : 'hidden' }}" title="Hapus foto">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <a type="button" class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 edit-foto-button {{ $foto->foto ? '' : 'hidden' }}">
          <i class="fa-solid fa-crop-simple"></i>
        </a>
      </div>
    </div>
    <div class="mb-4">
      <label for="caption" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
      <textarea name="caption" id="caption" rows="3" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-xs resize-none" placeholder="Deskripsi singkat (opsional)">{{ $foto->caption }}</textarea>
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
      const wrapper = document.querySelector('.foto-viewer-wrapper');
      const input = wrapper.querySelector('.foto-input');
      const preview = wrapper.querySelector('.foto-preview');
      const placeholder = wrapper.querySelector('.foto-placeholder');
      const removeBtn = wrapper.querySelector('.remove-foto-btn');
      const editBtn = wrapper.querySelector('.edit-foto-button');
      const cropperModal = document.getElementById('cropperModalFotoKegiatan');
      const imageToCrop = document.getElementById('image-to-crop-foto-kegiatan');
      const cropConfirmBtn = document.getElementById('crop-foto-kegiatan-confirm-btn');
      const cropCancelBtn = document.getElementById('crop-foto-kegiatan-cancel-btn');
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

      function setPreview(src) {
        preview.src = src;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
        removeBtn.classList.remove('hidden');
        editBtn.classList.remove('hidden');
        if (viewer) viewer.update();
      }
      function resetPreview() {
        preview.src = '#';
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
        removeBtn.classList.add('hidden');
        editBtn.classList.add('hidden');
      }

      input.addEventListener('change', function() {
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
      editBtn.addEventListener('click', function(e) {
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
      cropConfirmBtn.addEventListener('click', function() {
        if (cropper) {
          cropper.getCroppedCanvas().toBlob(function(blob) {
            const croppedFile = new File([blob], lastFile ? lastFile.name : 'cropped_foto_kegiatan.jpg', {
              type: blob.type
            });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            input.files = dataTransfer.files;
            const reader = new FileReader();
            reader.onload = function(ev) {
              setPreview(ev.target.result);
            };
            reader.readAsDataURL(croppedFile);
            cropper.destroy();
            cropper = null;
            cropperModal.classList.add('hidden');
          }, lastFile ? lastFile.type : 'image/jpeg');
        }
      });
      cropCancelBtn.addEventListener('click', function() {
        cropperModal.classList.add('hidden');
        if (cropper) {
          cropper.destroy();
          cropper = null;
        }
        input.value = '';
      });
      removeBtn.addEventListener('click', function() {
        resetPreview();
        input.value = '';
      });
      preview.addEventListener('click', function(ev) {
        if (!preview.classList.contains('hidden') && preview.src && preview.src !== '#') {
          ev.preventDefault();
          ev.stopPropagation();
          if (viewer) viewer.show();
          return false;
        }
      }, true);
    });
  </script>
@endsection
