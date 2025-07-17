<div id="privacy-notif" style="display:none;"
  class="fixed bottom-0 left-0 right-0 z-50 border-t-4 border-brand-blue bg-white text-sm px-4 py-3 flex flex-col md:flex-row items-center justify-center gap-2 md:gap-8 lg:md-gap-16 shadow-lg">
  <span>
    Website ini dikelola oleh Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda. Kami berkomitmen melindungi
    privasi dan data pribadi Anda. Informasi lebih lanjut dapat mengunjungi halaman
    <a href="{{ route('guest.kebijakan-privasi.index') }}"
      class="underline text-brand-blue font-semibold hover:text-yellow-300 transition">Kebijakan Privasi &amp;
      Penggunaan Kuki</a>.
  </span>
  <button id="privacy-notif-close"
    class="md:mt-0 bg-brand-yellow text-brand-blue font-bold px-4 py-2 rounded-lg shadow text-nowrap w-full md:w-auto">
    Saya Mengerti
  </button>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var notif = document.getElementById('privacy-notif');
    var btn = document.getElementById('privacy-notif-close');
    // Tampilkan hanya jika belum pernah disetujui
    if (!localStorage.getItem('privacy_notice_accepted')) {
      notif.style.display = 'flex';
    }
    btn.onclick = function() {
      notif.style.display = 'none';
      localStorage.setItem('privacy_notice_accepted', '1');
    };
  });
</script>
