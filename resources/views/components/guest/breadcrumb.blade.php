{{--
  Breadcrumb navigasi guest: versi ringkas untuk mobile (tombol "Kembali" +
  menu dropdown "lihat jalur lengkap") dan versi penuh untuk desktop
  (daftar path lengkap dengan pemisah panah).

  Props:
  - backHref  URL tombol "Kembali" pada tampilan mobile.
  - items     array path breadcrumb, urutan dari akar ke halaman ini. Tiap
              item: ['label' => string, 'href' => string|null]. href '#'
              atau null membuat item itu tidak bisa diklik (mis. label
              kategori tanpa halamannya sendiri). Item TERAKHIR di array
              selalu dianggap sebagai halaman yang sedang aktif - ditandai
              aria-current="page" dan tidak ditautkan, apa pun isi href-nya.
  - class     (opsional) class tambahan untuk elemen <nav> pembungkus.

  Contoh pemanggilan:
    <x-guest.breadcrumb
      :back-href="route('guest.hantu-banyu.index')"
      class="mb-6"
      :items="[
        ['label' => 'Beranda', 'href' => route('guest.beranda.index')],
        ['label' => 'Layanan Umum', 'href' => '#'],
        ['label' => 'Hantu Banyu', 'href' => route('guest.hantu-banyu.index')],
        ['label' => 'Lihat Pengaduan Hantu Banyu'],
      ]"
    />
--}}
@props(['backHref', 'items', 'class' => ''])

@php
  $current = end($items);
  $trail = array_slice($items, 0, -1);
@endphp

<nav aria-label="Breadcrumb" @if ($class) class="{{ $class }}" @endif>
  <!-- Small/XS Mobile: Back link + Current page only -->
  <div class="md:hidden flex items-center">
    <a href="{{ $backHref }}" class="inline-flex items-center text-blue-600 hover:underline">
      <i class="fa-solid fa-caret-left fa-sm mb-0.5"></i>
      <div class="underline">Kembali</div>
    </a>
    <span class="mx-2 text-gray-400">|</span>
    <button id="breadcrumb-menu-button" type="button" class="text-sm text-gray-500 hover:text-gray-700">
      Lihat jalur lengkap
      <svg class="w-2.5 h-2.5 ml-1 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 10 6">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="m1 1 4 4 4-4" />
      </svg>
    </button>
  </div>

  <!-- Small Mobile: Truncated breadcrumbs -->
  <ol class="hidden md:inline-flex items-center text-sm">
    @foreach ($trail as $item)
      @if ($loop->first)
        <li class="inline-flex items-center">
          <a href="{{ $item['href'] ?? '#' }}" class="text-blue-600 underline">
            {{ $item['label'] }}
          </a>
        </li>
      @else
        <li>
          <div class="flex items-center">
            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 9 4-4-4-4" />
            </svg>
            <a href="{{ $item['href'] ?? '#' }}" class="text-blue-600 underline">
              {{ $item['label'] }}
            </a>
          </div>
        </li>
      @endif
    @endforeach
    <li aria-current="page">
      <div class="flex items-center">
        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
          fill="none" viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="m1 9 4-4-4-4" />
        </svg>
        <span class="text-gray-500 font-medium">
          <span>{{ $current['label'] }}</span>
        </span>
      </div>
    </li>
  </ol>

  <!-- Mobile breadcrumb dots menu -->
  <div class="md:hidden mt-1">
    <div id="breadcrumb-dropdown"
      class="hidden z-50 absolute mt-2 bg-white divide-y divide-gray-100 rounded-lg shadow w-auto min-w-44">
      <ol class="py-2 text-sm text-gray-700">
        @foreach ($trail as $item)
          <li>
            <a href="{{ $item['href'] ?? '#' }}" class="block px-4 py-2 hover:bg-gray-100">{{ $item['label'] }}</a>
          </li>
        @endforeach
        <li>
          <span class="block px-4 py-2 font-semibold text-gray-600">{{ $current['label'] }}</span>
        </li>
      </ol>
    </div>
  </div>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const breadcrumbButton = document.getElementById('breadcrumb-menu-button');
    const breadcrumbDropdown = document.getElementById('breadcrumb-dropdown');

    if (breadcrumbButton && breadcrumbDropdown) {
      breadcrumbButton.addEventListener('click', function() {
        breadcrumbDropdown.classList.toggle('hidden');
      });

      // Tutup dropdown saat mengeklik di luar tombol/dropdown-nya.
      document.addEventListener('click', function(e) {
        if (!breadcrumbButton.contains(e.target) && !breadcrumbDropdown.contains(e.target)) {
          breadcrumbDropdown.classList.add('hidden');
        }
      });
    }
  });
</script>
