@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/cropperjs.css', 'resources/css/viewerjs.css', 'resources/css/quill.css', 'resources/css/quill-resize-module.css'])
@endsection

@section('document.body')
  <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" id="form-berita">
    @csrf

    <input type="hidden" name="id_berita_kategori" value="{{ $kategori->id_berita_kategori }}">

    <div class="mb-4">
      <label for="judul_berita" class="block text-sm font-medium text-gray-700">Judul Berita</label>
      <input type="text" name="judul_berita" id="judul_berita"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
    </div>

    <div class="mb-4">
      <label for="foto_berita" class="block text-sm font-medium text-gray-700">Foto Berita</label>
      <div class="relative group foto-viewer-wrapper h-28 sm:h-32">
        <label
          class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0"
          tabindex="0">
          <div class="foto-placeholder flex flex-col items-center justify-center pt-5 pb-6">
            <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
            </svg>
            <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload foto berita</p>
            <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
          </div>
          <img id="foto-preview"
            class="foto-preview hidden absolute inset-0 w-full h-full object-contain rounded-lg bg-white aspect-[16/9]" />
          <input name="foto_berita" id="foto_berita" type="file" accept="image/*" class="hidden foto-input" required />
        </label>
        <button type="button"
          class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-foto-btn hidden"
          title="Hapus foto" id="remove-foto-btn">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <button type="button"
          class="w-[30px] h-[30px] bg-white rounded-full text-green-600 hover:text-green-800 shadow-lg border border-black flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-10 revert-foto-btn hidden"
          title="Kembalikan foto sebelumnya" id="revert-foto-btn">
          <i class="fa-solid fa-rotate-right"></i>
        </button>
        <a type="button" id="edit-foto-button"
          class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 hidden">
          <i class="fa-solid fa-crop-simple"></i>
        </a>
      </div>
    </div>

    <div class="mb-4">
      <label for="sumber_foto_berita" class="block text-sm font-medium text-gray-700">Sumber Foto Berita</label>
      <input type="text" name="sumber_foto_berita" id="sumber_foto_berita"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" />
    </div>

    <div class="mb-4">
      <label for="isi_berita" class="block text-sm font-medium text-gray-700 mb-1">Isi Berita</label>
      <input id="isi_berita" type="hidden" name="isi_berita">
      <div id="quill-editor" style="height:480px;"></div>
    </div>

    <div class="mb-4">
      <label for="preview_berita" class="block text-sm font-medium text-gray-700">Preview Berita</label>
      <input type="text" name="preview_berita" id="preview_berita"
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

@section('document.end')
  @vite(['resources/js/cropperjs.js', 'resources/js/viewerjs.js', 'resources/js/quill.js', 'resources/js/quill-resize-module.js', 'resources/js/shared/crop-uploader.js'])

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Tulis isi berita di sini...',
        modules: {
          toolbar: [
            [{
              header: [1, 2, 3, false]
            }],
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{
              list: 'ordered'
            }, {
              list: 'bullet'
            }],
            [{
              align: []
            }],
            ['link', 'image'],
            ['clean']
          ],
          resize: {
            tools: [
              'left', 'right', 'full',
              {
                text: '<i class="fa-solid fa-crop-simple"></i>',
                verify(activeEle) {
                  return (activeEle && activeEle.tagName === 'IMG');
                },
                handler(evt, button, activeEle) {
                  // Simpan history src di elemen gambar
                  if (!activeEle._srcHistory) activeEle._srcHistory = [activeEle.src];
                  if (activeEle._srcHistoryPointer === undefined) activeEle._srcHistoryPointer = 0;
                  const imgSrc = activeEle.src;
                  const cropperModal = document.getElementById('cropperModalFoto');
                  const imageToCrop = document.getElementById('image-to-crop-foto');
                  let cropper = null;
                  cropperModal.classList.remove('hidden');
                  imageToCrop.src = imgSrc;
                  if (window.Cropper) {
                    if (imageToCrop.cropper) imageToCrop.cropper.destroy();
                    cropper = new Cropper(imageToCrop, {
                      viewMode: 1,
                      autoCropArea: 1,
                      aspectRatio: 16 / 9
                    });
                  }
                  document.getElementById('crop-foto-confirm-btn').onclick = function() {
                    if (cropper) {
                      cropper.getCroppedCanvas().toBlob(function(blob) {
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                          // Simpan src hasil crop ke history
                          activeEle._srcHistory.push(ev.target.result);
                          activeEle._srcHistoryPointer = activeEle._srcHistory.length - 1;
                          activeEle.src = ev.target.result;
                          cropper.destroy();
                          cropperModal.classList.add('hidden');
                        };
                        reader.readAsDataURL(blob);
                      }, 'image/jpeg');
                    }
                  };
                  document.getElementById('crop-foto-cancel-btn').onclick = function() {
                    cropperModal.classList.add('hidden');
                    if (cropper) cropper.destroy();
                  };
                }
              },
              {
                text: '<i class="fa-solid fa-rotate-left"></i>',
                verify(activeEle) {
                  // Tombol hanya muncul jika sudah pernah crop (history > 1 dan pointer > 0)
                  return (
                    activeEle &&
                    activeEle.tagName === 'IMG' &&
                    Array.isArray(activeEle._srcHistory) &&
                    activeEle._srcHistory.length > 1 &&
                    typeof activeEle._srcHistoryPointer === 'number' &&
                    activeEle._srcHistoryPointer > 0
                  );
                },
                handler(evt, button, activeEle) {
                  if (activeEle._srcHistoryPointer === undefined) activeEle._srcHistoryPointer = activeEle._srcHistory.length - 1;
                  if (activeEle._srcHistoryPointer > 0) {
                    activeEle._srcHistoryPointer--;
                    activeEle.src = activeEle._srcHistory[activeEle._srcHistoryPointer];
                  }
                }
              }
            ]
          }
        }
      });

      // Custom image handler for Quill
      function quillImageHandler() {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.click();

        input.onchange = function() {
          const file = input.files[0];
          if (file) {
            const formData = new FormData();
            formData.append('image', file);
            // Kirim UUID berita jika sudah ada
            formData.append('uuid_berita', '{{ old('uuid_berita') ?? '' }}');
            fetch('{{ route('admin.berita.uploadQuillImage') }}', {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              body: formData
            })
            .then(response => response.json())
            .then(result => {
              if (result.success && result.url) {
                const range = quill.getSelection();
                quill.insertEmbed(range.index, 'image', result.url);
              } else {
                alert('Gagal upload gambar');
              }
            })
            .catch(() => alert('Gagal upload gambar'));
          }
        };
      }

      // Replace default image handler
      quill.getModule('toolbar').addHandler('image', quillImageHandler);

      // Pastikan value Quill diisi ke input hidden sebelum submit
      document.getElementById('form-berita').addEventListener('submit', function(e) {
        document.getElementById('isi_berita').value = quill.root.innerHTML;
      });
    });

    document.getElementById('form-berita').addEventListener('submit', function(e) {
      document.getElementById('isi_berita').value = quill.root.innerHTML;
    });

    // Upload+crop foto utama - TERPISAH dari cropper di dalam editor Quill
    // di atas (yang sengaja memakai ulang modal #cropperModalFoto & tombol
    // #crop-foto-confirm-btn/#crop-foto-cancel-btn milik foto utama, lihat
    // komentar di modul resize Quill). initCropUploader() di sini hanya
    // menambahkan listener addEventListener untuk alur foto utama;
    // penanganan klik saat cropper dibuka dari toolbar Quill tetap
    // ditangani terpisah lewat penugasan .onclick di atas.
    document.addEventListener('DOMContentLoaded', function() {
      window.initCropUploader({
        wrapperSelector: '.foto-viewer-wrapper',
        inputSelector: '#foto_berita',
        previewSelector: '#foto-preview',
        placeholderSelector: '.foto-placeholder',
        removeBtnSelector: '#remove-foto-btn',
        revertBtnSelector: '#revert-foto-btn',
        editBtnSelector: '#edit-foto-button',
        modalSelector: '#cropperModalFoto',
        imageToCropSelector: '#image-to-crop-foto',
        confirmBtnSelector: '#crop-foto-confirm-btn',
        cancelBtnSelector: '#crop-foto-cancel-btn',
        aspectRatio: 16 / 9,
        fileNamePrefix: 'cropped_berita',
      });
    });
  </script>
@endsection
