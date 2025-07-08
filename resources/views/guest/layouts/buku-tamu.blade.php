<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="csrf-token" content="{{ csrf_token() }}" />
  
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

  {{-- Tailwind --}}
  @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body>
  @yield('slot')

  {{-- Jam (Special thanks to Bang Ucup Informatika Unmul 2020) --}}
  {{-- <script>
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
  </script> --}}
</body>

</html>
