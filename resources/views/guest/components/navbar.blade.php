<div class="hidden px-6 py-2 lg:flex justify-between items-center">
  <figure class="flex flex-col py-2 gap-y-2 gap-x-4 lg:flex-row">
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

<div class="bg-brand-blue px-4 py-2 lg:hidden">
  <p class="text-center text-white font-semibold text-sm current-time"></p>
</div>

<nav class="bg-white lg:bg-brand-blue border-gray-200" id="navbar">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto px-4 py-3">

    <div class="lg:hidden flex gap-2">
      <img class="h-[40px]" src="{{ asset('image/logo/pemkot-samarinda.png') }}" alt="Pemerintah Kota Samarinda" />
      <img class="h-[40px]" src="{{ config('app.logo_dinas') }}" alt="{{ config('app.nama_dinas') }}" />
    </div>

    <div class="ms-auto lg:ms-0 flex lg:order-2 space-x-3 lg:space-x-0 rtl:space-x-reverse">
      <a type="button" href="{{ route('guest.portal.index') }}"
        class="self-center text-brand-blue bg-brand-yellow focus:ring-4 focus:outline-none focus:ring-yellow-300 font-semibold rounded-xl text-sm px-3 py-2 lg:px-4 lg:py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Portal
      </a>
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
            class="block py-2 px-3 lg:p-0 rounded {{ $page_title == 'Beranda' ? ' bg-brand-yellow lg:bg-transparent' : '' }}"
            aria-current="page">Beranda</a>
        </li>

        <li>
          <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbarProfil"
            class="flex items-center w-full justify-between py-2 px-3 lg:p-0 rounded {{ $page_title == 'Profil' ? ' bg-brand-yellow lg:bg-transparent' : '' }}">
            Profil
            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
            </svg>
          </button>

          <div id="dropdownNavbarProfil"
            class="!absolute lg:!inset-x-0 !top-0 lg:!top-[148px] lg:!mx-auto lg:!transform-none z-50 hidden w-full lg:w-fit">
            <ul
              class="text-sm text-gray-700 lg:flex border-y-4 border-brand-blue font-normal bg-white divide-y divide-gray-100 shadow lg:w-fit mx-10"
              aria-labelledby="dropdownLargeButton">
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

              {{-- Kementerian PU --}}
              <div class="py-5 px-3">
                <h2 class="font-bold px-4 pb-2 text-base">
                  Kementerian PU
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
                    <a href="https://samarindakota.go.id/laman/sejarah-samarinda"
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
          <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbarInformasiPUPR" class="flex items-center w-full justify-between py-2 px-3 lg:p-0 rounded {{ $page_title == 'Informasi PUPR' ? ' bg-brand-yellow lg:bg-transparent' : '' }}">
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
          <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbarLayanan"
            class="flex items-center w-full justify-between py-2 px-3 lg:p-0 rounded {{ $page_title == 'Layanan' ? ' bg-brand-yellow lg:bg-transparent' : '' }}">
            Layanan
            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
            </svg>
          </button>

          <div id="dropdownNavbarLayanan"
            class="!absolute lg:!inset-x-0 !top-0 lg:!top-[148px] lg:!mx-auto lg:!transform-none z-50 hidden w-full lg:w-fit">
            <ul
              class="text-sm text-gray-700 lg:flex border-y-4 border-brand-blue font-normal bg-white divide-y divide-gray-100 shadow lg:w-fit mx-10"
              aria-labelledby="dropdownLargeButton">
              <div class="py-5 px-3">
                <h2 class="font-bold px-4 pb-2 text-base">
                  Layanan Dinas PUPR Kota Samarinda
                </h2>

                <div class="border-s-2 ms-4 border-black/15">
                  <li>
                    <a href="{{ route('guest.jalan-peduli.index') }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Jalan Peduli</a>
                  </li>
                  <li>
                    <a href="{{ url('https://sijakon.samarindakota.go.id') }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sijakon</a>
                  </li>
                  <li>
                    <a href="{{-- --}}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Drainase dan Irigasi (soon)</a>
                  </li>
                  <li>
                    <a href="{{ route('guest.sedot-tinja.index') }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">SILALAD</a>
                  </li>
                </div>
              </div>

            </ul>
          </div>
        </li>

        <li>
          <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbarInformasiPUPR"
            class="flex items-center w-full justify-between py-2 px-3 lg:p-0 rounded {{ $page_title == 'Informasi PUPR' ? ' bg-brand-yellow lg:bg-transparent' : '' }}">
            Informasi PUPR
            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
            </svg>
          </button>

          <div id="dropdownNavbarInformasiPUPR"
            class="!absolute lg:!inset-x-0 !top-0 lg:!top-[148px] lg:!mx-auto lg:!transform-none z-50 hidden w-full lg:w-fit">
            <ul
              class="text-sm text-gray-700 lg:flex border-y-4 border-brand-blue font-normal bg-white divide-y divide-gray-100 shadow lg:w-fit mx-10"
              aria-labelledby="dropdownLargeButton">
              {{-- Berita --}}
              <div class="py-5 px-3">
                <h2 class="font-bold px-4 pb-2 text-base">
                  Berita Dinas PUPR Kota Samarinda
                </h2>

                <div class="border-s-2 ms-4 border-black/15">
                  <li>
                    <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'sekretariat']) }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sekretaris</a>
                  </li>
                  <li>
                    <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'bidang-sumber-daya-air']) }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
                      Sumber Daya Air</a>
                  </li>
                  <li>
                    <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'bidang-cipta-karya']) }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
                      Cipta Karya</a>
                  </li>
                  <li>
                    <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'bidang-bina-marga']) }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
                      Bina Marga</a>
                  </li>
                  <li>
                    <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'bidang-bina-konstruksi']) }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
                      Bina Konstruksi</a>
                  </li>
                  <li>
                    <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'bidang-tata-ruang']) }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
                      Tata Ruang</a>
                  </li>
                  <li>
                    <a href=" {{ route('guest.berita.kategori.show', ['slug_kategori' => 'bidang-pertanahan']) }} "
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Bidang
                      Pertanahan</a>
                  </li>
                  <li>
                    <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'uptd-pengelolaan-air-limbah-domestik']) }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">UPTD
                      Pengelolaan Air Limbah Domestik</a>
                  </li>
                  <li>
                    <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'uptd-pemeliharaan-jalan-dan-jembatan']) }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">UPTD
                      Pemeliharaan Jalan dan Jembatan</a>
                  </li>
                  <li>
                    <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => 'uptd-pemeliharaan-saluran-drainase-dan-irigasi']) }}"
                      class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">UPTD
                      Pemeliharaan Saluran Drainase dan irigasi</a>
                  </li>
                </div>
              </div>

              <div>
                {{-- PPID Pelaksana --}}
                <div class="py-5 px-3">
                  <h2 class="font-bold px-4 pb-2 text-base">
                    PPID Pelaksana Dinas PUPR Kota Samarinda
                  </h2>

                  <div class="border-s-2 ms-4 border-black/15">
                    <li>
                      <a href="{{ route('guest.ppid-pelaksana.kategori.index') }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        Lihat PPID Pelaksana
                      </a>
                    </li>
                    {{-- <li>
                      <a href=""
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        Ajukan Permohonan Informasi Publik
                      </a>
                      </a>
                    </li> --}}
                  </div>
                </div>

                {{-- Informasi Lainnya --}}
                <div class="py-5 px-3">
                  <h2 class="font-bold px-4 pb-2 text-base">
                    Informasi Lainnya
                  </h2>
                  <div class="border-s-2 ms-4 border-black/15">
                    <li>
                      <a href="{{ route('guest.pengumuman.index') }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        Pengumuman Dinas PUPR Kota Samarinda</a>
                    </li>
                    <li>
                      <a href="{{ route('guest.pengumuman.index') }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        Agenda Kegiatan Dinas PUPR Kota Samarinda</a>
                    </li>
                    <li>
                      <a href="{{ route('guest.album-kegiatan.index') }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        Album Kegiatan Dinas PUPR Kota Samarinda</a>
                    </li>
                    <li>
                      <a href="https://pu.go.id/berita/kanal"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        Berita dari Kementerian PU</a>
                    </li>
                  </div>
                </div>
              </div>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>