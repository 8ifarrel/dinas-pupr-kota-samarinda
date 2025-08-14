@extends('guest.layouts.main')

@section('document.start')
  <link rel="dns-prefetch" href="https://lottie.host">
  <link rel="preconnect" href="https://lottie.host" crossorigin>
@endsection

@section('document.body')
  <div
    class="py-6 lg:py-12 px-6 lg:px-12 4xl:h-[calc(100vh-416px-60px-88px)] 4xl:inline-flex 2xl:justify-center 4xl:items-center 4xl:w-full">
    <div class="max-w-3xl mx-auto">
      <!-- Simple Card -->
      <div class="">
        <!-- Success Header -->
        <div class="text-center border-b border-gray-300 pb-4">
          <dotlottie-player src="https://lottie.host/1e9820b7-84fe-45d5-ad40-14004aa784a9/N2PtNg9vHv.lottie"
            background="transparent" speed="1" class="w-[75px] h-[75px] mx-auto" loop autoplay>
          </dotlottie-player>
          <h1 class="text-2xl font-bold text-gray-800 mt-2">Laporan Berhasil Dikirim</h1>
          <p class="text-gray-600 mt-1">
            Terima kasih atas laporan Anda. Laporan akan segera diproses.
          </p>
        </div>

        <!-- Nomor Pengaduan -->
        <div class="py-4 border-b border-gray-300">
          <p class="font-medium text-center text-black mb-1">Nomor Pengaduan</p>
          <div
            class="relative flex-1 bg-gray-50 border rounded p-2 flex items-center justify-between hover:text-gray-700">
            <p id="nomorPengaduan" class="text-lg font-mono font-medium text-center select-all mx-auto">
              {{ $laporan->id }}</p>
            <button id="copyButton" onclick="copyToClipboard()" class="text-gray-500 hover:text-gray-700 rounded-full transition-colors flex items-center gap-1 absolute right-2 cursor-pointer" title="Salin Kode">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
              </svg>
              <p>Salin</p>
            </button>
          </div>
          <p class="text-gray-600 mt-1 text-center text-base">
            Simpan nomor ini untuk memantau perkembangan laporan Anda.
          </p>
        </div>

        <!-- PDF Download Section -->
        <div class="py-4 border-b border-gray-300 text-center">
          <p class="text-gray-600 mb-3">
            Jika bukti pengaduan tidak terunduh secara otomatis, silakan tekan tombol di bawah ini.
          </p>
          <a href="{{ URL::temporarySignedRoute('guest.drainase-irigasi.pengaduan.pdf', now()->addMinutes(15), ['id' => $laporan->id]) }}"
            target="_blank"
            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-brand-blue rounded hover:bg-brand-yellow hover:text-brand-blue">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
            Unduh Bukti Pengaduan
          </a>
          <p class="text-gray-600 mt-3 font-bold">
            Demi keamanan data pelapor, halaman ini hanya dapat diakses selama 15 menit. Harap segera simpan bukti
            pengaduan Anda.
          </p>
        </div>

        <!-- Back Button -->
        <div class="pt-4 text-center text-blue-600">
          &larr;
          <a href="{{ route('guest.drainase-irigasi.index') }}" class="underline">
            Kembali ke halaman utama
          </a>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Auto-download PDF on page load
    window.onload = function() {
      // Create a hidden iframe for download to avoid popup blockers
      const downloadFrame = document.createElement('iframe');
      downloadFrame.style.display = 'none';
      document.body.appendChild(downloadFrame);

      // Set the iframe source to the PDF route with signature preserved
      downloadFrame.src =
        '{{ URL::temporarySignedRoute('guest.drainase-irigasi.pengaduan.pdf', now()->addMinutes(30), ['id' => $laporan->id]) }}';

      // Remove iframe after a delay to ensure download starts
      setTimeout(() => {
        document.body.removeChild(downloadFrame);
      }, 5000);
    }

    // Simple copy to clipboard function with notification
    function copyToClipboard() {
      const text = document.getElementById('nomorPengaduan').innerText;
      navigator.clipboard.writeText(text).then(function() {
        // Visual feedback - change button color briefly
        const copyButton = document.getElementById('copyButton');
        copyButton.classList.remove('text-gray-500');
        copyButton.classList.add('text-green-500');

        // Show tooltip or some indication
        const tooltip = document.createElement('div');
        tooltip.textContent = 'Disalin!';
        tooltip.className = 'absolute -top-8 right-0 bg-green-500 text-white text-xs px-2 py-1 rounded';
        copyButton.parentNode.appendChild(tooltip);

        // Reset after 2 seconds
        setTimeout(function() {
          copyButton.classList.remove('text-green-500');
          copyButton.classList.add('text-gray-500');
          tooltip.remove();
        }, 2000);
      });
    }
  </script>
@endsection

@section('document.end')
  <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module" defer>
  </script>
@endsection
