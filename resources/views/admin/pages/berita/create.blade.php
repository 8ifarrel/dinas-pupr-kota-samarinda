@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/cropperjs.css', 'resources/css/viewerjs.css', 'resources/css/trix.css'])

  <style>
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
    /* Tombol crop pada gambar di Trix editor */
    .trix-image-crop-btn {
      position: absolute;
      top: 8px;
      right: 8px;
      background: #fff;
      border: 1px solid #888;
      border-radius: 50%;
      width: 28px;
      height: 28px;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 10;
      cursor: pointer;
      box-shadow: 0 2px 6px rgba(0,0,0,0.12);
      transition: background 0.2s;
    }
    .trix-image-crop-btn:hover {
      background: #e0e7ff;
    }
    .trix-image-wrapper {
      position: relative;
      display: inline-block;
    }

    .attachment--content {
      width: fit-content !important;
    }
  </style>
@endsection

@section('document.body')
  <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
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
      <label for="isi_berita" class="block text-sm font-medium text-gray-700">Isi Berita</label>
      <input id="isi_berita" type="hidden" name="isi_berita">
      <trix-editor input="isi_berita"></trix-editor>
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
  @vite(['resources/js/cropperjs.js', 'resources/js/viewerjs.js', 'resources/js/trix.js']);

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
      let imageHistory = [];
      let historyPointer = -1;

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
              autoCropArea: 1,
              aspectRatio: 16 / 9
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
            autoCropArea: 1,
            aspectRatio: 16 / 9
          });
        }
      });
      if (cropConfirmBtn) cropConfirmBtn.addEventListener('click', function() {
        if (cropper) {
          cropper.getCroppedCanvas().toBlob(function(blob) {
            const croppedFile = new File([blob], lastFile ? lastFile.name : 'cropped_berita.jpg', {
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
      if (preview) preview.addEventListener('click', function(ev) {
        ev.preventDefault();
        ev.stopPropagation();
        if (viewer && !preview.classList.contains('hidden') && preview.src && preview.src !== '#') viewer.show();
        return false;
      });
    });

    // === Trix File Tools: Only allow image, crop before upload ===
    document.addEventListener('trix-file-accept', function(event) {
      const file = event.file;
      if (!file.type.startsWith('image/')) {
        event.preventDefault();
        alert('Hanya gambar yang diperbolehkan untuk diupload.');
        return;
      }
      event.preventDefault(); // Prevent default upload

      // Show cropper modal for Trix image
      showTrixCropper(file);
    });

    function showTrixCropper(file) {
      // Reuse modal cropper
      const cropperModal = document.getElementById('cropperModalFoto');
      const imageToCrop = document.getElementById('image-to-crop-foto');
      let cropper = null;

      // Show image in modal
      const reader = new FileReader();
      reader.onload = function(ev) {
        imageToCrop.src = ev.target.result;
        cropperModal.classList.remove('hidden');
        if (window._trixCropper) window._trixCropper.destroy();
        window._trixCropper = new Cropper(imageToCrop, {
          viewMode: 1,
          autoCropArea: 1,
          aspectRatio: 16 / 9
        });
      };
      reader.readAsDataURL(file);

      // Setup confirm/cancel for Trix
      const confirmBtn = document.getElementById('crop-foto-confirm-btn');
      const cancelBtn = document.getElementById('crop-foto-cancel-btn');

      // Remove previous listeners
      confirmBtn.onclick = null;
      cancelBtn.onclick = null;

      confirmBtn.onclick = function() {
        if (window._trixCropper) {
          window._trixCropper.getCroppedCanvas().toBlob(function(blob) {
            uploadTrixImage(blob, file.name, file.type);
            window._trixCropper.destroy();
            window._trixCropper = null;
            cropperModal.classList.add('hidden');
          }, file.type || 'image/jpeg');
        }
      };
      cancelBtn.onclick = function() {
        cropperModal.classList.add('hidden');
        if (window._trixCropper) {
          window._trixCropper.destroy();
          window._trixCropper = null;
        }
      };
    }

    // === Trix Image Crop Button ===
    document.addEventListener('DOMContentLoaded', function() {
      const trixEditor = document.querySelector('trix-editor');
      if (!trixEditor) return;

      // Helper: inject crop button to images in Trix editor
      function injectCropButtons() {
        // Remove old wrappers/buttons
        trixEditor.querySelectorAll('.trix-image-wrapper').forEach(w => {
          const img = w.querySelector('img');
          if (img) w.replaceWith(img);
        });

        trixEditor.querySelectorAll('img').forEach(img => {
          // Hindari double wrap
          if (img.closest('.trix-image-wrapper')) return;

          // Bungkus img dengan wrapper
          const wrapper = document.createElement('span');
          wrapper.className = 'trix-image-wrapper';
          img.parentNode.insertBefore(wrapper, img);
          wrapper.appendChild(img);

          // Tambahkan tombol crop
          const cropBtn = document.createElement('button');
          cropBtn.type = 'button';
          cropBtn.className = 'trix-image-crop-btn';
          cropBtn.title = 'Crop gambar';
          cropBtn.innerHTML = '<i class="fa-solid fa-crop-simple"></i>';
          wrapper.appendChild(cropBtn);

          cropBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            showTrixImageCropper(img, wrapper);
          });
        });
      }

      // Inject crop button setiap kali konten berubah
      trixEditor.addEventListener('trix-change', injectCropButtons);
      trixEditor.addEventListener('trix-initialize', injectCropButtons);
      // Juga inject saat klik (untuk gambar yang baru di-insert)
      trixEditor.addEventListener('click', injectCropButtons);

      // Fungsi crop gambar yang sudah ada di Trix
      function showTrixImageCropper(img, wrapper) {
        const cropperModal = document.getElementById('cropperModalFoto');
        const imageToCrop = document.getElementById('image-to-crop-foto');
        let origSrc = img.src;
        let origType = 'image/jpeg';
        if (origSrc.startsWith('data:')) {
          origType = origSrc.split(';')[0].split(':')[1] || 'image/jpeg';
        }
        imageToCrop.src = origSrc;
        cropperModal.classList.remove('hidden');
        if (window._trixCropper) window._trixCropper.destroy();
        window._trixCropper = new Cropper(imageToCrop, {
          viewMode: 1,
          autoCropArea: 1,
          aspectRatio: 16 / 9
        });

        // Setup confirm/cancel
        const confirmBtn = document.getElementById('crop-foto-confirm-btn');
        const cancelBtn = document.getElementById('crop-foto-cancel-btn');
        confirmBtn.onclick = null;
        cancelBtn.onclick = null;

        confirmBtn.onclick = function() {
          if (window._trixCropper) {
            window._trixCropper.getCroppedCanvas().toBlob(function(blob) {
              // Upload ulang ke server
              uploadTrixImage(blob, 'cropped_' + Date.now() + '.jpg', blob.type, function(url) {
                // Replace gambar di editor
                replaceTrixImage(img, url);
              });
              window._trixCropper.destroy();
              window._trixCropper = null;
              cropperModal.classList.add('hidden');
            }, origType);
          }
        };
        cancelBtn.onclick = function() {
          cropperModal.classList.add('hidden');
          if (window._trixCropper) {
            window._trixCropper.destroy();
            window._trixCropper = null;
          }
        };
      }

      // Replace gambar di Trix editor dengan url baru
      function replaceTrixImage(img, newUrl) {
        // Simpan posisi caret
        const editor = trixEditor.editor;
        const range = editor.getSelectedRange();
        // Hapus attachment lama
        const attachmentElement = img.closest('figure')?.dataset?.trixAttachment;
        if (attachmentElement) {
          // Remove by Trix API
          const att = editor.getDocument().getAttachments().find(a => a.getURL() === img.src);
          if (att) editor.removeAttachment(att);
        } else {
          // Fallback: replace img src
          img.src = newUrl;
        }
        // Insert attachment baru
        insertTrixImage(newUrl);
        // Restore caret
        editor.setSelectedRange(range);
      }

      // Patch: inject crop button saat load awal
      setTimeout(injectCropButtons, 500);
    });

    // Patch: uploadTrixImage menerima callback untuk replace gambar
    function uploadTrixImage(blob, filename, mimeType, cb) {
      const formData = new FormData();
      formData.append('attachment', new File([blob], filename, { type: mimeType }));

      fetch('{{ route('admin.berita.trix-upload-image') }}', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success && data.url) {
          if (typeof cb === 'function') {
            cb(data.url);
          } else {
            insertTrixImage(data.url);
          }
        } else {
          alert('Gagal upload gambar.');
        }
      })
      .catch(() => alert('Gagal upload gambar.'));
    }

    function insertTrixImage(url) {
      const editor = document.querySelector('trix-editor');
      if (editor) {
        const attachment = new Trix.Attachment({ content: `<img src="${url}" style="max-width:100%;">`, url: url });
        editor.editor.insertAttachment(attachment);
      }
    }

    document.addEventListener('DOMContentLoaded', function() {
      const trixEditor = document.querySelector('trix-editor');
      if (trixEditor) {
        trixEditor.addEventListener('click', function(e) {
          const target = e.target;
          if (target.tagName === 'IMG') {
            e.preventDefault();
            showTrixImageViewer(target);
          }
        });
      }

      function showTrixImageViewer(img) {
        let container = document.getElementById('trix-image-viewer-container');
        if (!container) {
          container = document.createElement('div');
          container.id = 'trix-image-viewer-container';
          container.style.display = 'none';
          document.body.appendChild(container);
        }
        container.innerHTML = '';
        const cloneImg = document.createElement('img');
        cloneImg.src = img.src;
        container.appendChild(cloneImg);

        if (window._trixViewer) {
          window._trixViewer.destroy();
        }
        window._trixViewer = new Viewer(container, {
          navbar: false,
          toolbar: true,
          title: false,
          hidden() {
            window._trixViewer.destroy();
            window._trixViewer = null;
          }
        });
        window._trixViewer.show();
      }
    });
  </script>
@endsection
