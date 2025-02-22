<aside
  class="fixed bg-white top-0 left-0 z-30 w-64 h-screen pt-20 transition-transform -translate-x-full border-r border-gray-200 md:translate-x-0"
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

      {{-- Jabatan & Pegawai --}}
      <li>
        <a class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100"
          href="{{ route('admin.jabatan.index') }}">
          <i class="fa-solid fa-people-group"></i>

          <span class="ms-3">
            Jabatan & Pegawai
          </span>
        </a>
      </li>
    </ul>
  </div>
</aside>
