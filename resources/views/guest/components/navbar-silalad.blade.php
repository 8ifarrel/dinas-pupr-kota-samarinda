<nav class="bg-blue-900 text-white shadow-md">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">

      {{-- Logo --}}
      <div class="flex-shrink-0">
        <a href="{{ route('guest.silalad.index') }}" class="flex items-center gap-2">
          <img src="{{ asset('storage/asset/logo-SILALAD.jpg') }}" alt="Logo PUPR" class="h-20">
          <span class="font-bold text-lg">SILALAD</span>
        </a>
      </div>

      {{-- Menu --}}
      <div class="hidden md:flex space-x-6">
        <a href="{{ route('guest.silalad.index') }}" 
           class="hover:text-yellow-400 {{ request()->routeIs('guest.silalad.index') ? 'text-yellow-400 font-semibold' : '' }}">
          Beranda
        </a>
        <a href="{{ route('guest.silalad.create') }}" 
           class="hover:text-yellow-400 {{ request()->routeIs('guest.silalad.create') ? 'text-yellow-400 font-semibold' : '' }}">
          Buat Laporan
        </a>
        <a href="{{ route('guest.silalad.status') }}" 
           class="hover:text-yellow-400 {{ request()->routeIs('guest.silalad.status') ? 'text-yellow-400 font-semibold' : '' }}">
          Cek Status
        </a>
        <a href="{{ route('guest.silalad.success') }}" 
           class="hover:text-yellow-400 {{ request()->routeIs('guest.silalad.success') ? 'text-yellow-400 font-semibold' : '' }}">
          Halaman Sukses
        </a>
      </div>

    </div>
  </div>
</nav>
