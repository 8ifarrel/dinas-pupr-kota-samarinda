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
  @vite(['resources/js/cropperjs.js', 'resources/js/viewerjs.js'])

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const wrapper = document.querySelector('.slider-viewer-wrapper');
      const input = document.getElementById('foto_slider');
      const preview = document.getElementById('slider-preview');
      const placeholder = wrapper.querySelector('.slider-placeholder');
      const removeBtn = document.getElementById('remove-slider-btn');
      const revertBtn = document.getElementById('revert-slider-btn');
      const editBtn = document.getElementById('edit-slider-button');
      const cropperModalSlider = document.getElementById('cropperModalSlider');
      const imageToCropSlider = document.getElementById('image-to-crop-slider');
      const cropSliderConfirmBtn = document.getElementById('crop-slider-confirm-btn');
      const cropSliderCancelBtn = document.getElementById('crop-slider-cancel-btn');
      let cropperSlider = null;
      let lastSliderFile = null;
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
      let sliderHistory = [];
      let sliderHistoryPointer = -1;

      function pushSliderHistory(src) {
        if (sliderHistoryPointer < sliderHistory.length - 1) sliderHistory = sliderHistory.slice(0,
          sliderHistoryPointer + 1);
        sliderHistory.push(src);
        sliderHistoryPointer = sliderHistory.length - 1;
        updateRevertSliderBtn();
      }

      function updateRevertSliderBtn() {
        if (sliderHistoryPointer > 0) {
          revertBtn.classList.remove('hidden');
          revertBtn.style.display = '';
        } else {
          revertBtn.classList.add('hidden');
          revertBtn.style.display = 'none';
        }
      }

      function setSliderPreviewAndHistory(src, isInitial = false) {
        preview.src = src;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
        removeBtn.classList.remove('hidden');
        removeBtn.disabled = false;
        editBtn.classList.remove('hidden');
        editBtn.style.display = '';
        if (!isInitial) pushSliderHistory(src);
        if (viewer) viewer.update();
      }
      // Inisialisasi preview dan history pada halaman create (tidak ada gambar awal)
      if (input) input.addEventListener('change', function() {
        if (input.files && input.files[0]) {
          lastSliderFile = input.files[0];
          const reader = new FileReader();
          reader.onload = function(ev) {
            imageToCropSlider.src = ev.target.result;
            cropperModalSlider.classList.remove('hidden');
            if (cropperSlider) cropperSlider.destroy();
            cropperSlider = new Cropper(imageToCropSlider, {
              viewMode: 1,
              autoCropArea: 1,
              aspectRatio: 2.368 / 1
            });
          };
          reader.readAsDataURL(input.files[0]);
        }
      });
      if (editBtn) editBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (!preview.classList.contains('hidden') && preview.src && preview.src !== '#') {
          imageToCropSlider.src = preview.src;
          cropperModalSlider.classList.remove('hidden');
          if (cropperSlider) cropperSlider.destroy();
          cropperSlider = new Cropper(imageToCropSlider, {
            viewMode: 1,
            autoCropArea: 1,
            aspectRatio: 2.368 / 1
          });
        }
      });
      if (cropSliderConfirmBtn) cropSliderConfirmBtn.addEventListener('click', function() {
        if (cropperSlider) {
          cropperSlider.getCroppedCanvas().toBlob(function(blob) {
            const croppedFile = new File([blob], lastSliderFile ? lastSliderFile.name :
              'cropped_slider.jpg', {
                type: blob.type
              });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            input.files = dataTransfer.files;
            const reader = new FileReader();
            reader.onload = function(ev) {
              setSliderPreviewAndHistory(ev.target.result);
            };
            reader.readAsDataURL(croppedFile);
            cropperSlider.destroy();
            cropperSlider = null;
            cropperModalSlider.classList.add('hidden');
          }, lastSliderFile ? lastSliderFile.type : 'image/jpeg');
        }
      });
      if (cropSliderCancelBtn) cropSliderCancelBtn.addEventListener('click', function() {
        cropperModalSlider.classList.add('hidden');
        if (cropperSlider) {
          cropperSlider.destroy();
          cropperSlider = null;
        }
        input.value = '';
      });
      if (removeBtn) removeBtn.addEventListener('click', function() {
        setSliderPreviewAndHistory('#');
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
        removeBtn.classList.add('hidden');
        removeBtn.disabled = true;
        editBtn.classList.add('hidden');
        editBtn.style.display = 'none';
      });
      if (revertBtn) revertBtn.addEventListener('click', function() {
        if (sliderHistoryPointer > 0) {
          sliderHistoryPointer--;
          const prevSrc = sliderHistory[sliderHistoryPointer];
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
          updateRevertSliderBtn();
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
