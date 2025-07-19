@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/cropperjs.css', 'resources/css/viewerjs.css', 'resources/css/quill.css'])
@endsection

@section('document.body')
  <form action="{{ route('admin.kepala-dinas.update') }}" method="POST" enctype="multipart/form-data" id="form-kepala-dinas">
    @csrf

    <div class="mb-4">
      <label for="nama_pegawai" class="block font-medium text-gray-700">Nama Pegawai</label>
      <input type="text" name="nama_pegawai" id="nama_pegawai" value="{{ $kepalaDinas->nama }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
        required>
    </div>
    <div class="mb-4">
      <label for="nomor_induk_pegawai" class="block font-medium text-gray-700">Nomor Induk Pegawai</label>
      <input type="text" name="nomor_induk_pegawai" id="nomor_induk_pegawai" value="{{ $kepalaDinas->nip }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50">
    </div>
    <div class="mb-4">
      <label for="nomor_telepon_pegawai" class="block font-medium text-gray-700">Nomor Telepon</label>
      <input type="text" name="nomor_telepon_pegawai" id="nomor_telepon_pegawai"
        value="{{ $kepalaDinas->nomor_telepon }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50">
    </div>
    <div class="mb-4">
      <label for="golongan_pegawai" class="block mb-2 text-sm font-medium text-gray-700">Golongan</label>
      <select id="golongan_pegawai" name="golongan_pegawai"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        @php
          $golonganList = [
              'I/a',
              'I/b',
              'I/c',
              'I/d',
              'II/a',
              'II/b',
              'II/c',
              'II/d',
              'III/a',
              'III/b',
              'III/c',
              'III/d',
              'IV/a',
              'IV/b',
              'IV/c',
              'IV/d',
              'IV/e',
          ];
        @endphp
        <option value="">Pilih Golongan</option>
        @foreach ($golonganList as $gol)
          <option value="{{ $gol }}" @if ($kepalaDinas->golongan == $gol) selected @endif>{{ $gol }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="mb-4">
      <label for="foto" class="block text-sm font-medium text-gray-700">Foto Pegawai</label>
      <div class="relative group foto-viewer-wrapper h-28 sm:h-32">
        <label
          class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden m-0"
          tabindex="0">
          <div
            class="foto-placeholder flex flex-col items-center justify-center pt-5 pb-6 {{ $kepalaDinas->foto ? 'hidden' : '' }}">
            <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4 4h-4a1 1 0 01-1-1v-1h10v1a1 1 0 01-1 1h-4z" />
            </svg>
            <p class="mb-1 text-xs text-gray-500 font-semibold text-center">Klik untuk upload foto pegawai</p>
            <p class="text-xs text-gray-400 text-center">PNG, JPG, JPEG <br> (max 2MB)</p>
          </div>
          <img id="foto-preview"
            class="foto-preview absolute inset-0 w-full h-full object-contain rounded-lg bg-white {{ $kepalaDinas->foto ? '' : 'hidden' }}"
            src="{{ $kepalaDinas->foto ? Storage::url($kepalaDinas->foto) : '' }}" />
          <input name="foto" id="foto" type="file" accept="image/*" class="hidden foto-input" />
        </label>
        <button type="button"
          class="w-[30px] h-[30px] bg-white rounded-full text-red-500 hover:text-red-700 shadow-lg border border-black flex items-center justify-center absolute top-2 right-2 z-10 remove-foto-btn {{ $kepalaDinas->foto ? '' : 'hidden' }}"
          title="Hapus foto" id="remove-foto-btn">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <button type="button"
          class="w-[30px] h-[30px] bg-white rounded-full text-green-600 hover:text-green-800 shadow-lg border border-black flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-10 revert-foto-btn hidden"
          title="Kembalikan foto sebelumnya" id="revert-foto-btn">
          <i class="fa-solid fa-rotate-right"></i>
        </button>
        <a type="button" id="edit-foto-button"
          class="p-3.5 w-3 h-3 bg-white rounded-full text-black shadow-lg border border-black flex items-center justify-center absolute bottom-2 right-2 z-10 {{ $kepalaDinas->foto ? '' : 'hidden' }}">
          <i class="fa-solid fa-crop-simple"></i>
        </a>
      </div>
    </div>

    <div id="cropperModalFoto" tabindex="-1" aria-hidden="true"
      class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl relative mx-4 md:mx-5">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
          <h3 class="text-xl font-semibold text-gray-900">
            Crop Foto Pegawai
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

    <div class="mb-4">
      <label for="deskripsi_susunan_organisasi" class="block font-medium text-gray-700">Deskripsi Jabatan</label>
      <textarea name="deskripsi_jabatan" id="deskripsi_susunan_organisasi" rows="4"
        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ $susunan->deskripsi_susunan_organisasi }}</textarea>
    </div>
    <div class="mb-4">
      <label for="tupoksi_susunan_organisasi" class="block font-medium text-gray-700 mb-1">Tupoksi Jabatan</label>
      <input id="tupoksi_susunan_organisasi" type="hidden" name="tupoksi_jabatan"
        value="{{ $susunan->tupoksi_susunan_organisasi }}">
      <div id="quill-editor-tupoksi"></div>
    </div>
    <div class="mb-4">
      <label for="periode_jabatan" class="block font-medium text-gray-700">Periode Jabatan</label>
      <div class="flex gap-2 items-center">
        <input type="number" name="tahun_mulai" id="tahun_mulai" value="{{ $kepalaDinas->tahun_mulai }}"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
          min="1900" max="2100" required>
        <span>-</span>
        <input type="number" name="tahun_selesai" id="tahun_selesai" value="{{ $kepalaDinas->tahun_selesai }}"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
          min="1900" max="2100" required>
      </div>
    </div>
    <div class="mb-4">
      <label for="riwayat_pendidikan" class="block font-medium text-gray-700">Riwayat Pendidikan</label>
      <ul id="riwayat-pendidikan-list" class="list-disc pl-5">
        @foreach ($riwayatPendidikan->sortBy('tanggal_masuk') as $pendidikan)
          <li class="mb-2">
            <input type="text" name="riwayat_pendidikan[]" value="{{ $pendidikan->nama_pendidikan }}"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
              required>
            <input type="date" name="tanggal_masuk_pendidikan[]" value="{{ $pendidikan->tanggal_masuk }}"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
              required>
            <button type="button" class="mt-1 text-red-500 text-sm" onclick="removeField(this)">Hapus</button>
          </li>
        @endforeach
      </ul>
      <button type="button"
        class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xs px-2.5 py-2 mt-2"
        onclick="addField('riwayat-pendidikan-list', 'riwayat_pendidikan[]', 'tanggal_masuk_pendidikan[]')">
        <i class="fa-solid fa-plus me-1"></i>Tambah Riwayat Pendidikan
      </button>
    </div>
    <div class="mb-4">
      <label for="jenjang_karir" class="block font-medium text-gray-700">Jenjang Karir</label>
      <ul id="jenjang-karir-list" class="list-disc pl-5">
        @foreach ($jenjangKarir->sortBy('tanggal_masuk') as $karir)
          <li class="mb-2">
            <input type="text" name="jenjang_karir[]" value="{{ $karir->nama_karir }}"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
              required>
            <input type="date" name="tanggal_masuk_karir[]" value="{{ $karir->tanggal_masuk }}"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
              required>
            <button type="button" class="mt-1 text-red-500 text-sm" onclick="removeField(this)">Hapus</button>
          </li>
        @endforeach
      </ul>
      <button type="button"
        class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xs px-2.5 py-2 mt-2"
        onclick="addField('jenjang-karir-list', 'jenjang_karir[]', 'tanggal_masuk_karir[]')">
        <i class="fa-solid fa-plus me-1"></i>Tambah Jenjang Karir
      </button>
    </div>

    <div class="mb-4">
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
    </div>
  </form>
@endsection

@section('document.end')
  @vite(['resources/js/cropperjs.js', 'resources/js/viewerjs.js', 'resources/js/quill.js'])

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const wrapper = document.querySelector('.foto-viewer-wrapper');
      const input = document.getElementById('foto');
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
              autoCropArea: 1,
              aspectRatio: 1
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
            aspectRatio: 1
          });
        }
      });
      if (cropConfirmBtn) cropConfirmBtn.addEventListener('click', function() {
        if (cropper) {
          cropper.getCroppedCanvas().toBlob(function(blob) {
            const croppedFile = new File([blob], lastFile ? lastFile.name : 'cropped_foto.jpg', {
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

    document.addEventListener('DOMContentLoaded', function() {
      var quillTupoksi = new Quill('#quill-editor-tupoksi', {
        theme: 'snow',
        placeholder: 'Tulis tupoksi jabatan di sini...',
        modules: {
          toolbar: [
            [{ header: [1, 2, false] }],
            ['bold', 'italic', 'underline'],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['clean']
          ]
        }
      });
      var isiTupoksi = document.getElementById('tupoksi_susunan_organisasi').value;
      if (isiTupoksi) {
        quillTupoksi.clipboard.dangerouslyPasteHTML(isiTupoksi);
      }
      document.getElementById('form-kepala-dinas').addEventListener('submit', function(e) {
        document.getElementById('tupoksi_susunan_organisasi').value = quillTupoksi.root.innerHTML;
      });
    });
  </script>
@endsection
