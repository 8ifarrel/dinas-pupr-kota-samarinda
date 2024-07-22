<div class="hidden my-4 mx-16 lg:flex justify-between items-center">
  <figure class="flex gap-2">
    <img class="h-[55px]" src="{{ asset('image/logo/pemkot-samarinda.png') }}" alt="Pemerintah Kota Samarinda" />
    <img class="h-[55px]" src="{{ config('app.logo_dinas') }}" alt="{{ config('app.nama_dinas') }}" />
    <figcaption class="my-auto text-lg text-blue font-bold w-[340px] uppercase">
      {{ config('app.nama_dinas') }}
    </figcaption>
  </figure>

  <div>
    <p class="text-lg font-semibold current-time"></p>
  </div>
</div>

<div class="bg-blue px-4 py-2 lg:hidden">
  <p class="text-center text-white font-semibold text-sm current-time"></p>
</div>

<nav class="bg-white lg:bg-blue border-gray-200" id="navbar">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto px-4 py-3">

    <div class="lg:hidden flex gap-2">
      <img class="h-[40px]" src="{{ asset('image/logo/pemkot-samarinda.png') }}" alt="Pemerintah Kota Samarinda" />
      <img class="h-[40px]" src="{{ config('app.logo_dinas') }}" alt="{{ config('app.nama_dinas') }}" />
    </div>

    <div class="ms-auto lg:ms-0 flex lg:order-2 space-x-3 lg:space-x-0 rtl:space-x-reverse">
      <button type="button"
        class="text-blue bg-yellow focus:ring-4 focus:outline-none focus:ring-yellow-300 font-semibold rounded-xl text-sm px-3 py-1 lg:px-4 lg:py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Pelayanan</button>
      <button data-collapse-toggle="navbar-cta" type="button"
        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
        aria-controls="navbar-cta" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M1 1h15M1 7h15M1 13h15" />
        </svg>
      </button>
    </div>
    <div class="items-center justify-between mx-auto hidden w-full lg:flex lg:w-auto lg:order-1" id="navbar-cta">
      <ul
        class="flex flex-col font-medium p-4 lg:p-0 mt-4 border lg:text-white border-gray-200 rounded-lg bg-gray-100 lg:space-x-8 rtl:space-x-reverse lg:flex-row lg:mt-0 lg:border-0 lg:bg-transparent"
        id="navbarMenu">
        <li>
          <a href="{{ route('guest.beranda.index') }}"
            class="block py-2 px-3 lg:p-0 rounded {{ $page_title == 'Beranda' ? ' bg-yellow lg:bg-transparent' : '' }}"
            aria-current="page">Beranda</a>
        </li>

        <li>
          <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbarProfil"
            class="flex items-center w-full justify-between py-2 px-3 lg:p-0 rounded {{ $page_title == 'Profil' ? ' bg-yellow lg:bg-transparent' : '' }}">
            Profil
            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
            </svg>
          </button>

          <div id="dropdownNavbarProfil"
            class="lg:!absolute lg:!inset-x-0 !top-[148px] lg:!mx-auto lg:!transform-none border-y-4 hidden border-blue z-50 font-normal bg-white divide-y divide-gray-100 shadow w-64 xs:w-72 md:w-fit lg:w-fit">
            <ul class="text-sm text-gray-700 lg:flex" aria-labelledby="dropdownLargeButton">
              {{-- Dinas PUPR Kota Samarinda --}}
              <div class="py-5 px-3">
                <h2 class="font-bold px-4 pb-2 text-base">
                  Dinas PUPR Kota Samarinda
                </h2>

                <div class="border-s-2 ms-4 border-black/15">
                  <li>
                    <a href="{{ route('guest.profil.profil-kepala-dinas.index') }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Kepala
                      Dinas</a>
                  </li>
                  <li>
                    <a href="{{ route('guest.profil.sejarah-dinas-pupr-kota-samarinda.index') }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sejarah</a>
                  </li>
                  <li>
                    <a href="{{ route('guest.profil.visi-dan-misi.index') }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Visi dan
                      Misi</a>
                  </li>
                  <li>
                    <a href="{{ route('guest.profil.struktur-organisasi.index') }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Struktur
                      Organisasi</a>
                  </li>
                </div>
              </div>

              {{-- Kementerian PUPR --}}
              <div class="py-5 px-3">
                <h2 class="font-bold px-4 pb-2 text-base">
                  Kementerian PUPR
                </h2>

                <div class="border-s-2 ms-4 border-black/15">
                  <li>
                    <a href="https://pu.go.id/page/Peristiwa-Heroik-3-Des"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Peristiwa
                      Heroik 3 Desember</a>
                  </li>
                  <li>
                    <a href="https://pu.go.id/page/Dari-Masa-ke-Masa"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Pekerjaan
                      Umum Dari Masa ke Masa</a>
                  </li>
                  <li>
                    <a href="https://pu.go.id/page/Mereka-yang-Gugur"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mereka yang
                      Gugur</a>
                  </li>
                  <li>
                    <a href="https://pu.go.id/page/Mars-PUPR"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mars
                      Kementerian Pekerjaan Umum</a>
                  </li>
                  <li>
                    <a href="https://pu.go.id/page/Visi-dan-Misi"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Visi dan
                      Misi</a>
                  </li>
                  <li>
                    <a href="https://pu.go.id/assets/media/sejarah_perkembangan_pekerjaan_umum_indonesia.pdf"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sejarah
                      Perkembangan Pekerjaan Umum di Indonesia</a>
                  </li>
                </div>
              </div>

              {{-- Kota Samarinda --}}
              <div class="py-5 px-3">
                <h2 class="font-bold px-4 pb-2 text-base">
                  Kota Samarinda
                </h2>
                <div class="border-s-2 ms-4 border-black/15">
                  <li>
                    <a href="{{ route('guest.profil.sejarah-kota-samarinda.index') }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sejarah</a>
                  </li>
                  <li>
                    <a href="https://samarindakota.go.id/laman/visi-dan-misi"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Visi dan
                      Misi</a>
                  </li>
                  <li>
                    <a href="https://samarindakota.go.id/laman/landasan-hukum"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Landasan
                      Hukum</a>
                  </li>
                </div>
              </div>
            </ul>
          </div>
        </li>

        {{-- <li>
          <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbarInformasiPUPR" class="flex items-center w-full justify-between py-2 px-3 lg:p-0 rounded {{ $page_title == 'Informasi PUPR' ? ' bg-yellow lg:bg-transparent' : '' }}">
            Informasi PUPR
            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" >
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
            </svg>
          </button>

          <div id="dropdownNavbarInformasiPUPR" class="z-50 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-64 xs:w-72 md:w-fit lg:w-fit dark:bg-gray-700 dark:divide-gray-600" >
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
              <li>
                <a href="" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Pengumuman</a>
              </li>
              <li>
                <a href="{{ route('guest.berita.kategori.index') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Berita</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">PPID Pelaksana</a>
              </li>
            </ul>
          </div>
        </li> --}}

        <li>
          <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbarInformasiPUPR"
            class="flex items-center w-full justify-between py-2 px-3 lg:p-0 rounded {{ $page_title == 'Profil' ? ' bg-yellow lg:bg-transparent' : '' }}">
            Informasi PUPR
            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
            </svg>
          </button>

          <div id="dropdownNavbarInformasiPUPR"
            class="lg:!absolute lg:!inset-x-0 !top-[148px] lg:!mx-auto lg:!transform-none border-y-4 hidden border-blue z-50 font-normal bg-white divide-y divide-gray-100 shadow w-64 xs:w-72 md:w-fit lg:w-fit">
            <ul class="text-sm text-gray-700 lg:flex" aria-labelledby="dropdownLargeButton">
              {{-- Berita --}}
              <div class="py-5 px-3">
                <h2 class="font-bold px-4 pb-2 text-base">
                  Berita PUPR
                </h2>

                <div class="border-s-2 ms-4 border-black/15">
                  <li>
                    <a href="#"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sekretariat</a>
                  </li>
                  <li>
                    <a href="#"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
                      Sumber Daya Air</a>
                  </li>
                  <li>
                    <a href="#"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
                      Cipta Karya</a>
                  </li>
                  <li>
                    <a href="#"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
                      Bina Marga</a>
                  </li>
                  <li>
                    <a href="#"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
                      Bina Konstruksi</a>
                  </li>
                  <li>
                    <a href="#"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
                      Tata Ruang</a>
                  </li>
                  <li>
                    <a href="#"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
                      Pertanahan</a>
                  </li>
                  <li>
                    <a href="#"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">UPTD
                      Pengelolaan Air Limbah Domestik</a>
                  </li>
                  <li>
                    <a href="#"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">UPTD
                      Pemeliharaan Jalan dan Jembatan</a>
                  </li>
                  <li>
                    <a href="#"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">UPTD
                      Pemeliharaan Saluran Drainase dan irigasi</a>
                  </li>
                </div>
              </div>

              <div>
                {{-- PPID Pelaksana --}}
                <div class="py-5 px-3">
                  <h2 class="font-bold px-4 pb-2 text-base">
                    PPID Pelaksana
                  </h2>

                  <div class="border-s-2 ms-4 border-black/15">
                    <li>
                      <a href="https://pu.go.id/page/Peristiwa-Heroik-3-Des"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Peraturan
                        Keputusan dan Kebijakan</a>
                    </li>
                    <li>
                      <a href="https://pu.go.id/page/Dari-Masa-ke-Masa"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Informasi
                        yang Wajib Disediakan dan Diumumkan Secara Berkala</a>
                    </li>
                    <li>
                      <a href="https://pu.go.id/page/Mereka-yang-Gugur"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Informasi
                        yang Wajib Diumumkan Secara Serta-merta</a>
                    </li>
                    <li>
                      <a href="https://pu.go.id/page/Mars-PUPR"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Informasi
                        yang Wajib Tersedia Setiap Saat</a>
                    </li>
                  </div>
                </div>

                {{-- Informasi Lainnya --}}
                <div class="py-5 px-3">
                  <h2 class="font-bold px-4 pb-2 text-base">
                    Informasi Lainnya
                  </h2>
                  <div class="border-s-2 ms-4 border-black/15">
                    <li>
                      <a href="{{ route('guest.profil.sejarah-kota-samarinda.index') }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Pengumuman
                        PUPR</a>
                    </li>
                    <li>
                      <a href="https://pu.go.id/berita/kanal"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Berita
                        dari Kementerian</a>
                    </li>
                  </div>
                </div>
              </div>
            </ul>
          </div>
        </li>
        <li>
          <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
            class="flex items-center justify-between w-full py-2 px-3 lg:p-0 rounded {{ $page_title == 'E-Library' ? ' bg-yellow lg:bg-transparent' : '' }}">
            E-Library PUPR
            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
            </svg>
          </button>
          <!-- Dropdown menu -->
          <div id="dropdownNavbar"
            class="border-y-4 border-blue z-50 hidden font-normal bg-white divide-y divide-gray-100 shadow w-44">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
              <li>
                <a href="#"
                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Galeri Foto</a>
              </li>
              <li>
                <a href="#"
                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Video</a>
              </li>
          </div>
        </li>
        <li>
          <a href="#"
            class="block py-2 px-3 lg:p-0 rounded {{ $page_title == 'SKM' ? ' bg-yellow lg:bg-transparent' : '' }}">SKM</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
