// Buka/tutup modal Flowbite lewat delegasi event di document.body, alih-alih
// mengandalkan auto-init bawaan Flowbite - sehingga tombol [data-modal-toggle]
// dan [data-modal-hide] tetap berfungsi walau elemennya baru muncul belakangan
// (mis. baris tabel yang dirender ulang oleh DataTables).
//
// Cukup dimuat sekali per halaman; tidak perlu pemanggilan fungsi apa pun.
// Tandai elemen pemicu dengan atribut data-modal-toggle="<id modal>" untuk
// membuka, dan data-modal-hide="<id modal>" untuk menutup. Instance Modal
// per elemen di-cache di properti elemen (__flowbiteModal) supaya tidak
// dibuat ulang pada klik berikutnya.

document.addEventListener('DOMContentLoaded', function() {
  document.body.addEventListener('click', function(e) {
    var toggleBtn = e.target.closest('[data-modal-toggle]');
    if (toggleBtn) {
      var modalId = toggleBtn.getAttribute('data-modal-toggle');
      var modalEl = document.getElementById(modalId);
      if (window.Modal && modalEl) {
        if (!modalEl.__flowbiteModal) {
          modalEl.__flowbiteModal = new window.Modal(modalEl);
        }
        modalEl.__flowbiteModal.show();
      }
    }
  });

  document.body.addEventListener('click', function(e) {
    var hideBtn = e.target.closest('[data-modal-hide]');
    if (hideBtn) {
      var modalId = hideBtn.getAttribute('data-modal-hide');
      var modalEl = document.getElementById(modalId);
      if (window.Modal && modalEl && modalEl.__flowbiteModal) {
        modalEl.__flowbiteModal.hide();
      }
    }
  });
});
