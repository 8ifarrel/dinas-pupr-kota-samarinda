<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <meta name="description" content="{{ $meta_description }}" />

  <meta name="robots" content="noindex, nofollow">

  <title>
    {{ $page_title ? $page_title . ' |' : '' }} Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda
  </title>

  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon/favicon-16x16.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon/favicon-32x32.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('image/favicon/apple-touch-icon.png') }}">
  <link rel="manifest" href="{{ asset('image/favicon/site.webmanifest') }}">
  <link rel="shortcut icon" href="{{ asset('image/favicon/favicon.ico') }}">
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('image/favicon/android-chrome-192x192.png') }}">
  <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('image/favicon/android-chrome-512x512.png') }}">
  <link rel="dns-prefetch" href="https://lottie.host">
  <link rel="preconnect" href="https://lottie.host" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  @vite('resources/css/sweetalert2.css')
  @vite('resources/css/app.css')
</head>

<body>
  <div class="py-4 px-12 flex justify-between items-center bg-[#D9D9D9D9] border-b-[2px] border-brand-blue">
    <figure class="flex gap-2">
      <img class="h-[55px]" src="{{ config('app.logo_pemkot') }}" alt="{{ config('app.nama_pemkot') }}" />
      <img class="h-[55px]" src="{{ config('app.logo_dinas') }}" alt="{{ config('app.nama_dinas') }}" />
      <figcaption class="my-auto text-lg text-brand-blue font-bold w-[365px] uppercase">
        {{ config('app.nama_dinas') }}
      </figcaption>
    </figure>

    <div>
      <p class="text-lg font-semibold current-time"></p>
    </div>
  </div>

  <div class="h-[calc(100vh-56px-16px-16px-3px-287px)] flex flex-col items-center justify-center">
    <div class="flex flex-col items-center border-b-[2px] border-gray-400 pb-10 px-6">
      <div class="text-center mb-6 flex flex-col items-center">
        <div
          class="bg-brand-blue font-bold text-brand-yellow me-2 px-6 py-2 rounded-full text-xl w-fit">
          Layanan Umum
        </div>
        <h1 class="mb-2 font-bold text-5xl mt-6">
          Antrean Buku Tamu Digital
        </h1>
        <p class=" text-gray-700 text-xl font-medium">
          Kode antrean yang sedang dipanggil pada tanggal {{ now()->translatedFormat('d F Y') }}
        </p>
      </div>
      <div class="w-full max-w-6xl">
        <div id="queue-sections">
          <div class="col-span-full text-center text-gray-400 py-6">Memuat antrean...</div>
        </div>
      </div>
      <div class="text-xl text-gray-700" id="queue-update-info font-medium">
        Data antrean diperbarui otomatis setiap 5 detik.
      </div>
    </div>

    <div class="pt-10 px-6">
      <div class="text-center flex flex-col items-center">
        <div
          class="bg-brand-blue font-bold text-brand-yellow me-2 px-6 py-2 rounded-full text-xl w-fit">
          Penilaian
        </div>
        <h1 class="mt-6 mb-6 text-3xl font-bold tv-vertical:text-5xl">
          Survei Penilaian Integritas
        </h1>
      </div>

      <img src="{{ asset('image/others/spi.png') }}" alt="" class="py-5">
    </div>
  </div>

  <footer class="bg-[#D9D9D9D9] flex flex-col items-center border-t-[2px] border-brand-blue">
    <div class="py-6 px-12 tv-vertical:flex-row tv-vertical:flex tv-vertical:gap-10">
      <figure>
        <div class="flex items-center gap-2 mb-2">
          <div class="flex gap-2">
            <img class="h-[50px]" src="{{ asset('image/logo/pemkot-samarinda.png') }}"
              alt="Pemerintah Kota Samarinda" />
            <img class="h-[50px]" src="{{ config('app.logo_dinas') }}" alt="{{ config('app.nama_dinas') }}" />
          </div>

          <div class="flex-1">
            <figcaption class="font-bold text-lg uppercase text-brand-blue">
              Dinas Pekerjaan Umum dan <br> Penataan Ruang Kota Samarinda
            </figcaption>
          </div>
        </div>

        <figcaption>
          Jalan H. Achmad Amins, Kelurahan Gn. Lingai, Kecamatan Sungai Pinang, Kota Samarinda, Provinsi Kalimantan
          Timur, 75117
        </figcaption>

        <div class="mt-2 grid gap-2 grid-cols-2">
          <a href="https://www.facebook.com/dpuprkotasamarinda/" target="_blank" class="flex items-center">
            <i class="fa-brands fa-facebook me-1" style="color: #000000;"></i>
            @dpuprkotasamarinda
          </a>

          <a href="https://www.instagram.com/dpuprkotasamarinda/" target="_blank" class="flex items-center">
            <i class="fa-brands fa-instagram me-1" style="color: #000000;"></i>
            @dpuprkotasamarinda
          </a>

          <a href="https://www.youtube.com/@dinaspuprkotasamarinda" target="_blank" class="flex items-center">
            <i class="fa-brands fa-youtube me-1" style="color: #000000;"></i>
            @dinaspuprkotasamarinda
          </a>

          <a href="mailto:dpuprkotasamarinda@gmail.com" class="flex items-center">
            <i class="fa-regular fa-envelope me-1" style="color: #000000;"></i>
            dpuprkotasamarinda@gmail.com
          </a>
        </div>
      </figure>

      <div>
        <h1 class="mb-1 font-bold text-lg">
          LOKASI
        </h1>
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.690298112536!2d117.17512067507042!3d-0.45899179953650165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df5d6033b793f91%3A0xe380dade32764edd!2sKantor%20PUPR%20Samarinda!5e0!3m2!1sen!2sid!4v1704714282337!5m2!1sen!2sid"
          class="w-[350px]" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>

    <div
      class="bg-brand-blue py-2.5 w-full text-white text-center text-xs flex flex-col justify-between px-[1.35rem] gap-1">
      <p>
        © 2024-2025 {{ config('app.nama_dinas') }}
      </p>

      <a class="underline" href="{{ route('guest.kebijakan-privasi.index') }}">
        Kebijakan Privasi & Penggunaan Kuki
      </a>
    </div>
  </footer>

  <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module" defer>
  </script>

  @vite('resources/js/app.js')
  @vite('resources/js/clock.js')
  @vite('resources/js/navbar-guest.js')
  @vite('resources/js/sweetalert2.js')

  <script>
    function renderSection(bagian, kode) {
      return `
        <div class="border-4 border-brand-blue rounded-xl p-5 shadow bg-white flex flex-col items-center transition-all duration-300">
          <div class="text-xl font-semibold text-gray-700 mb-2 text-center">${bagian}</div>
          <div class="text-3xl font-extrabold text-brand-blue mb-2 tracking-widest">${kode ? kode : '-'}</div>
        </div>
      `;
    }

    function fetchQueue() {
      fetch("{{ route('guest.buku-tamu.display.queue-data') }}")
        .then(res => res.json())
        .then(res => {
          const sections = document.getElementById('queue-sections');
          sections.innerHTML = '';
          if (res.data && res.data.length > 0) {
            // Sekretariat di baris pertama, lebar sama dengan section lain
            const sekretariat = res.data[0];
            sections.innerHTML += `
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-5">
                <div></div>
                <div>${renderSection(sekretariat.bagian, sekretariat.kode)}</div>
                <div></div>
              </div>
            `;
            // Sisanya 3 kolom per baris
            let rows = '';
            for (let i = 1; i < res.data.length; i += 3) {
              rows += `<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-5">`;
              for (let j = 0; j < 3; j++) {
                const idx = i + j;
                if (res.data[idx]) {
                  rows +=
                    `<div>${renderSection(res.data[idx].bagian, res.data[idx].kode)}</div>`;
                } else {
                  rows += `<div></div>`;
                }
              }
              rows += `</div>`;
            }
            sections.innerHTML += rows;
          } else {
            sections.innerHTML =
              `<div class="col-span-full text-center text-gray-400 py-6">Belum ada data bagian.</div>`;
          }
        })
        .catch(() => {
          const sections = document.getElementById('queue-sections');
          sections.innerHTML =
            `<div class="col-span-full text-center text-gray-400 py-6">Gagal memuat data antrean.</div>`;
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
      fetchQueue();
      setInterval(fetchQueue, 5000);
    });
  </script>
</body>

</html>

</html>
