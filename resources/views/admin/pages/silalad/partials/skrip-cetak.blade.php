{{--
  Membuka dialog cetak otomatis bila URL-nya membawa ?print - dipakai saat
  admin memilih surat dari halaman edit, supaya tidak perlu menekan tombol
  cetak dua kali.
--}}
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    if (params.has('print')) {
      window.history.replaceState({}, document.title, window.location.pathname);
      window.print();
    }
  });
</script>
