<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  {{-- 
		Curhat part #3 (duplikat)
		plis tolong bantu gua buatkan meta desc yang cocok untuk SEO
		tujuannya biar orang samarinda tau kalau pemerintahan 
		menyediakan layanan dan informasi terkait infrastruktur
	--}}
  <meta name="description" content="{{ $meta_description }}" />

  <title>
    Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda
  </title>

  <link rel="icon" type="image/x-icon" href="" />

  {{-- Flowbite --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

  {{-- Flowbite --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

  {{-- Fontawesome --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  {{-- Splide --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">

  {{-- AOS --}}
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

  {{-- Tailwind --}}
  @vite('resources/css/app.css')

  @yield('css')
</head>

<body>
  @include('guest.components.navbar')

  @yield('slot')

  @include('guest.components.footer')

  {{-- AOS --}}
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js">
    AOS.init({
      duration: 800,
    });
  </script>

  {{-- Lottiefiles --}}
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

  {{-- Jam (Special thanks to Bang Ucup Informatika Unmul 2020) --}}
  <script>
    function updateClock() {
      var elementsJam = document.getElementsByClassName("current-time");
      var now = new Date();
      var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
      var day = days[now.getDay()];
      var date = now.getDate();
      var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
        'November', 'Desember'
      ];
      var month = months[now.getMonth()];
      var year = now.getFullYear();
      var hours = now.getHours();
      var minutes = now.getMinutes();
      var seconds = now.getSeconds();
      var timeString = day + ', ' + date + ' ' + month + ' ' + year + ' | ' + (hours < 10 ? "0" : "") + hours + ':' + (
        minutes < 10 ? "0" : "") + minutes + ':' + (seconds < 10 ? "0" : "") + seconds + ' WITA ';

      for (var i = 0; i < elementsJam.length; i++) {
        elementsJam[i].textContent = timeString;
      }
    }

    updateClock();
    setInterval(updateClock, 1000);
  </script>

  {{-- Fixed navbar --}}
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var navbar = document.getElementById("navbar");
      var navbarMenu = document.getElementById("navbarMenu");

      var lastScrollY = window.scrollY;
      var ticking = false;

      function updateNavbar() {
        if (lastScrollY > 88 && window.innerWidth >= 1024) {
          navbar.classList.add("bg-white", "shadow-lg");
          navbar.classList.add("fixed", "w-full", "z-50", "top-0", "start-0");
          navbar.classList.remove("transition", "duration-200", "ease-out", "lg:bg-blue");
          navbar.classList.add("transition", "duration-350", "ease-in");

          navbarMenu.classList.remove("lg:text-white", "lg:bg-blue");
          navbarMenu.classList.add("lg:text-blue");
          navbarMenu.classList.add("transition", "duration-350", "ease-in");

          dropdownNavbarProfil.classList.remove("!top-[148px]");
          dropdownNavbarProfil.classList.add("!top-[60px]");

          dropdownNavbarInformasiPUPR.classList.remove("!top-[148px]");
          dropdownNavbarInformasiPUPR.classList.add("!top-[60px]");
        } else {
          navbar.classList.remove("bg-white", "shadow-lg");
          navbar.classList.remove("fixed", "w-full", "z-50", "top-0", "start-0");
          navbar.classList.add("transition", "duration-200", "ease-out", "lg:bg-blue");
          navbar.classList.remove("transition", "duration-350", "ease-in");

          navbarMenu.classList.add("lg:text-white", "lg:bg-blue");
          navbarMenu.classList.remove("lg:text-blue");
          navbarMenu.classList.remove("transition", "duration-350", "ease-in");

          dropdownNavbarProfil.classList.remove("!top-[60px]");
          dropdownNavbarProfil.classList.add("!top-[148px]");

          dropdownNavbarInformasiPUPR.classList.remove("!top-[60px]");
          dropdownNavbarInformasiPUPR.classList.add("!top-[148px]");
        }
        ticking = false;
      }

      function onScroll() {
        lastScrollY = window.scrollY;
        if (!ticking) {
          window.requestAnimationFrame(updateNavbar);
          ticking = true;
        }
      }

      window.addEventListener("scroll", onScroll);
    });
  </script>

  @yield('js')
</body>

</html>
