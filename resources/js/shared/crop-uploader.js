// Upload gambar dengan crop (Cropper.js) dan riwayat undo/preview (Viewer.js).
//
// Menangani form "create" (belum ada gambar) maupun "edit" (sudah ada
// gambar) sekaligus: state awal dibaca langsung dari elemen preview saat
// skrip berjalan - kalau preview sudah punya src yang valid & tidak hidden,
// itu dianggap gambar awal.
//
// Dipanggil sebagai:
//   window.initCropUploader({
//     wrapperSelector: '.slider-viewer-wrapper',  // pembungkus preview, dipakai Viewer.js
//     inputSelector: '#foto_slider',               // <input type="file">
//     previewSelector: '#slider-preview',          // <img> pratinjau
//     placeholderSelector: '.slider-placeholder',  // dicari di dalam wrapper, ditampilkan saat kosong
//     removeBtnSelector: '#remove-slider-btn',
//     revertBtnSelector: '#revert-slider-btn',     // opsional; disembunyikan otomatis bila riwayat kosong
//     editBtnSelector: '#edit-slider-button',
//     modalSelector: '#cropperModalSlider',
//     imageToCropSelector: '#image-to-crop-slider',
//     confirmBtnSelector: '#crop-slider-confirm-btn',
//     cancelBtnSelector: '#crop-slider-cancel-btn',
//     aspectRatio: 2.368 / 1, // opsional; dikosongkan = bebas
//     fileNamePrefix: 'cropped_slider', // dipakai sebagai nama file kalau belum ada file asli
//   });
//
// Selector yang bernilai null/tidak ditemukan di halaman dilewati dengan
// aman. Bila salah satu elemen inti (input, preview, placeholder, removeBtn,
// editBtn, modal, imageToCrop) tidak ditemukan, inisialisasi dibatalkan
// seluruhnya tanpa error.

window.initCropUploader = function(config) {
  function pilih(selector) {
    return selector ? document.querySelector(selector) : null;
  }

  const wrapper = pilih(config.wrapperSelector);
  const input = pilih(config.inputSelector);
  const preview = pilih(config.previewSelector);
  const placeholder = wrapper && config.placeholderSelector ? wrapper.querySelector(config.placeholderSelector) : null;
  const removeBtn = pilih(config.removeBtnSelector);
  const revertBtn = pilih(config.revertBtnSelector);
  const editBtn = pilih(config.editBtnSelector);
  const cropperModal = pilih(config.modalSelector);
  const imageToCrop = pilih(config.imageToCropSelector);
  const cropConfirmBtn = pilih(config.confirmBtnSelector);
  const cropCancelBtn = pilih(config.cancelBtnSelector);
  const aspectRatio = typeof config.aspectRatio === 'number' ? config.aspectRatio : null;
  const fileNamePrefix = config.fileNamePrefix || 'cropped';

  if (!input || !preview || !placeholder || !removeBtn || !editBtn || !cropperModal || !imageToCrop) {
    // Elemen inti tidak lengkap - form ini kemungkinan belum siap/berbeda
    // struktur, jangan coba jalankan supaya tidak error di tengah.
    return;
  }

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

  // --- Riwayat: mulai dari gambar yang sudah ada (form edit), kalau ada ---
  let history = [];
  let historyPointer = -1;
  const originalImageSrc = preview.src && !preview.classList.contains('hidden') && preview.src !== '#'
    ? preview.src
    : null;
  if (originalImageSrc) {
    history = [originalImageSrc];
    historyPointer = 0;
  }

  function bukaCropper(src) {
    imageToCrop.src = src;
    cropperModal.classList.remove('hidden');
    if (cropper) cropper.destroy();
    const opsi = { viewMode: 1, autoCropArea: 1 };
    if (aspectRatio !== null) opsi.aspectRatio = aspectRatio;
    cropper = new Cropper(imageToCrop, opsi);
  }

  function pushHistory(src) {
    if (historyPointer < history.length - 1) history = history.slice(0, historyPointer + 1);
    history.push(src);
    historyPointer = history.length - 1;
    updateRevertBtn();
  }

  function updateRevertBtn() {
    if (!revertBtn) return;
    if (historyPointer > 0) {
      revertBtn.classList.remove('hidden');
      revertBtn.style.display = '';
    } else {
      revertBtn.classList.add('hidden');
      revertBtn.style.display = 'none';
    }
  }

  function setPreviewAndHistory(src, isInitial) {
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

  function kosongkanPreview() {
    preview.src = '#';
    preview.classList.add('hidden');
    placeholder.classList.remove('hidden');
    removeBtn.classList.add('hidden');
    removeBtn.disabled = true;
    editBtn.classList.add('hidden');
    editBtn.style.display = 'none';
  }

  if (originalImageSrc) {
    setPreviewAndHistory(originalImageSrc, true);
    updateRevertBtn();
  }

  input.addEventListener('change', function() {
    if (input.files && input.files[0]) {
      lastFile = input.files[0];
      const reader = new FileReader();
      reader.onload = function(ev) {
        bukaCropper(ev.target.result);
      };
      reader.readAsDataURL(input.files[0]);
    }
  });

  editBtn.addEventListener('click', function(e) {
    e.preventDefault();
    if (!preview.classList.contains('hidden') && preview.src && preview.src !== '#') {
      bukaCropper(preview.src);
    }
  });

  if (cropConfirmBtn) cropConfirmBtn.addEventListener('click', function() {
    if (!cropper) return;
    cropper.getCroppedCanvas().toBlob(function(blob) {
      const croppedFile = new File([blob], lastFile ? lastFile.name : fileNamePrefix + '.jpg', {
        type: blob.type
      });
      const dataTransfer = new DataTransfer();
      dataTransfer.items.add(croppedFile);
      input.files = dataTransfer.files;
      const reader = new FileReader();
      reader.onload = function(ev) {
        setPreviewAndHistory(ev.target.result, false);
      };
      reader.readAsDataURL(croppedFile);
      cropper.destroy();
      cropper = null;
      cropperModal.classList.add('hidden');
    }, lastFile ? lastFile.type : 'image/jpeg');
  });

  if (cropCancelBtn) cropCancelBtn.addEventListener('click', function() {
    cropperModal.classList.add('hidden');
    if (cropper) {
      cropper.destroy();
      cropper = null;
    }
    input.value = '';
  });

  removeBtn.addEventListener('click', function() {
    pushHistory('#');
    kosongkanPreview();
  });

  if (revertBtn) revertBtn.addEventListener('click', function() {
    if (historyPointer <= 0) return;
    historyPointer--;
    const prevSrc = history[historyPointer];
    if (prevSrc && prevSrc !== '#') {
      preview.src = prevSrc;
      preview.classList.remove('hidden');
      placeholder.classList.add('hidden');
      removeBtn.classList.remove('hidden');
      removeBtn.disabled = false;
      editBtn.classList.remove('hidden');
      editBtn.style.display = '';
    } else {
      kosongkanPreview();
    }
    updateRevertBtn();
  });

  if (preview.classList.contains('hidden') || !preview.src || preview.src === '#') {
    editBtn.classList.add('hidden');
    editBtn.style.display = 'none';
  } else {
    editBtn.classList.remove('hidden');
    editBtn.style.display = '';
  }

  preview.addEventListener('click', function(ev) {
    ev.preventDefault();
    ev.stopPropagation();
    if (viewer && !preview.classList.contains('hidden') && preview.src && preview.src !== '#') viewer.show();
    return false;
  });
};
