// Editor teks kaya (Quill.js) yang terhubung ke sebuah input tersembunyi
// sebagai sumber & tujuan nilainya.
//
// Dipanggil sebagai:
//   window.initRichTextEditor({
//     selector: '#quill-editor',            // elemen kosong tempat Quill dipasang
//     placeholder: 'Tulis ... di sini...',  // opsional
//     hiddenInputSelector: '#perihal',      // elemen yang menyimpan nilai HTML
//     formSelector: '#form-pengumuman',     // form yang membungkus keduanya
//     toolbar: [...],                       // opsional; default di bawah
//   });
//
// Alur kerja:
//  - Saat dipasang, bila hiddenInputSelector sudah berisi HTML (mis. dari
//    database, atau old() input setelah validasi gagal), isi itu dimuat ke
//    editor.
//  - Saat formSelector di-submit, isi editor (quill.root.innerHTML) ditulis
//    balik ke hiddenInputSelector, sehingga ikut terkirim sebagai bagian
//    form.
//
// toolbar default (dipakai bila config.toolbar tidak diisi):
//   [{ header: [1, 2, false] }], ['bold', 'italic', 'underline'],
//   [{ list: 'ordered' }, { list: 'bullet' }], ['clean']
//
// Mengembalikan instance Quill yang dibuat, atau null bila elemen
// selector tidak ditemukan di halaman.

window.initRichTextEditor = function(config) {
  var el = document.querySelector(config.selector);
  if (!el) return null;

  var quill = new Quill(config.selector, {
    theme: 'snow',
    placeholder: config.placeholder || '',
    modules: {
      toolbar: config.toolbar || [
        [{ header: [1, 2, false] }],
        ['bold', 'italic', 'underline'],
        [{ list: 'ordered' }, { list: 'bullet' }],
        ['clean']
      ]
    }
  });

  var hiddenInput = config.hiddenInputSelector ? document.querySelector(config.hiddenInputSelector) : null;

  if (hiddenInput && hiddenInput.value) {
    quill.clipboard.dangerouslyPasteHTML(hiddenInput.value);
  }

  var form = config.formSelector ? document.querySelector(config.formSelector) : null;
  if (form && hiddenInput) {
    form.addEventListener('submit', function() {
      hiddenInput.value = quill.root.innerHTML;
    });
  }

  return quill;
};
