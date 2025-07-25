<aside
  class="fixed bg-white top-0 left-0 z-30 h-screen pt-20 transition-transform -translate-x-full border-r border-gray-200 md:translate-x-0"
  id="logo-sidebar" aria-label="Sidebar">
  <div class="h-full px-3 pb-4 overflow-y-auto ">
    <ul class="space-y-2 font-medium">
      {{-- Dashboard --}}
      <li>
        <a class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100"
          href="{{ route('admin.dashboard.index') }}">
          <i class="fa-solid fa-chart-pie">
          </i>

          <span class="ms-3">
            Dashboard
          </span>
        </a>
      </li>

      {{-- Slider --}}
      <li>
        <a class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100"
          href="{{ route('admin.slider.index') }}">
          <i class="fa-solid fa-panorama"></i>

          <span class="ms-3">
            Slider
          </span>
        </a>
      </li>

      {{-- Berita --}}
      <li>
        <a class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100"
          href="{{ route('admin.berita.kategori.index') }}">
          <i class="fa-solid fa-newspaper"></i>

          <span class="ms-3">
            Berita
          </span>
        </a>
      </li>

      {{-- PPID Pelaksana --}}
      <li>
        <a class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100"
          href="{{ route('admin.ppid-pelaksana.kategori.index') }}">
          <i class="fa-solid fa-file-powerpoint"></i>

          <span class="ms-3">
            PPID Pelaksana
          </span>
        </a>
      </li>

      {{-- Pengumuman --}}
      <li>
        <a class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100"
          href="{{ route('admin.pengumuman.index') }}">
          <i class="fa-solid fa-bullhorn"></i>

          <span class="ms-3">
            Pengumuman
          </span>
        </a>
      </li>

      {{-- Buku Tamu --}}
      <li>
        <a class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100"
          href="{{ route('admin.buku-tamu.index') }}">
          <i class="fa-solid fa-receipt"></i>
    
          <span class="ms-3">
            Buku Tamu
          </span>
        </a>
      </li>

      {{-- LPSE --}}
      <li>
        <a class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100"
          href="{{ route('admin.lpse.index') }}">
          <i class="fa-solid fa-box-archive"></i> {{-- kamu bisa ganti ikon sesuai selera --}}
    
          <span class="ms-3">
            LPSE
          </span>
        </a>
      </li>

      {{-- Agenda Kegiatan --}}
      <li>
        <a class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100"
          href="{{ route('admin.agenda-kegiatan.index') }}">
          <i class="fa-solid fa-calendar-days"></i>

          <span class="ms-3">
            Agenda Kegiatan
          </span>
        </a>
      </li>

      {{-- Album & Foto Kegiatan --}}
      <li>
        <a class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100"
          href="{{ route('admin.album-kegiatan.index') }}">
          <i class="fa-solid fa-images"></i>

          <span class="ms-3">
            Album & Foto Kegiatan
          </span>
        </a>
      </li>

      {{-- Struktur Organisasi --}}
      <li>
        <a class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100"
          href="{{ route('admin.struktur-organisasi.index') }}">
          <i class="fa-solid fa-sitemap"></i>

          <span class="ms-3">
            Struktur Organisasi
          </span>
        </a>
      </li>

      {{-- Profil --}}
      <li>
        <button type="button"
          class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
          aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
          <i class="fa-solid fa-building-user"></i>
          <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Profil</span>
          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m1 1 4 4 4-4" />
          </svg>
        </button>
        <ul id="dropdown-example" class="hidden py-2 space-y-2">
          <li>
            <a href="{{ route('admin.profil.visi-dan-misi.index') }}"
              class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Visi
              dan Misi</a>
          </li>
          <li>
            <a href="{{ route('admin.profil.sejarah-dinas-pupr-kota-samarinda.index') }}"
              class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Sejarah</a>
          </li>
        </ul>
      </li>

      {{-- Partner --}}
      <li>
        <a class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100"
          href="{{ route('admin.partner.index') }}">
          <i class="fa-solid fa-handshake"></i>

          <span class="ms-3">
            Partner
          </span>
        </a>
      </li>

      @if (auth()->user()->is_super_admin)
        <div class="flex items-center mx-2 pt-1.5">
          <span class="font-medium text-sm text-gray-600 mr-3">
            Super Admin
          </span>
          <hr class="flex-grow h-px bg-gray-600 border-0">
        </div>

        {{-- Akun Admin --}}
        <li>
          <a class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100"
            href="{{ route('admin.super.akun-admin.index') }}">
            <i class="fa-solid fa-user-lock"></i>
            <span class="ms-3">
              Akun Admin
            </span>
          </a>
        </li>

        {{-- Log --}}
        <li>
          <a class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100" href="">
            <i class="fa-solid fa-file-circle-exclamation"></i>
            <span class="ms-3">
              Log
            </span>
          </a>
        </li>

        {{-- Konfigurasi Sistem --}}
        <li>
          <a class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100" href="">
            <i class="fa-solid fa-gears"></i>
            <span class="ms-3">
              Konfigurasi Sistem
            </span>
          </a>
        </li>
      @endif
    </ul>
  </div>
</aside>
