@extends('guest.layouts.main')

@section('document.start')
  @vite('resources/css/splidejs.css')
@endsection

@section('document.body')
  {{-- Slider --}}
  <div id="default-carousel" class="relative w-full" data-carousel="slide">
    <div class="relative w-full pb-[42.8571%] overflow-hidden">
      @foreach ($slider as $key => $item)
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
          @if ($key === 0)
            <img src="{{ Storage::url($item->foto_slider) }}"
              class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 brightness-50"
              alt="Slider Image {{ $key + 1 }}">
            <div class="absolute inset-0 flex flex-col text-center items-center justify-center">
              <h1
                class="font-bold text-base xs:text-lg sm:text-2xl md:text-3xl lg:text-4xl md:pb-2 text-center text-white max-w-64 xs:max-w-72 sm:max-w-lg md:max-w-2xl lg:max-w-4xl">
                Website Resmi Dinas Pekerjaan Umum dan Penantaan Ruang Kota Samarinda</h1>
              <p
                class="hidden sm:block sm:text-sm md:text-base lg:text-lg text-white sm:max-w-lg md:max-w-2xl lg:max-w-4xl">
                Selamat datang di website Dinas Pekerjaan Umum dan Penantaan Ruang Kota Samarinda, tempat
                informasi mengenai pembangunan, pemeliharaan, dan pengelolaan infrastruktur, serta tata ruang dan
                pengawasan
                bangunan di wilayah Kota Samarinda.
              </p>
            </div>
          @else
            <img src="{{ Storage::url($item->foto_slider) }}"
              class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
              alt="Slider Image {{ $key + 1 }}">
          @endif
        </div>
      @endforeach
    </div>

    <button type="button"
      class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
      data-carousel-prev>
      <span
        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
        </svg>
        <span class="sr-only">Previous</span>
      </span>
    </button>
    <button type="button"
      class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
      data-carousel-next>
      <span
        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
        </svg>
        <span class="sr-only">Next</span>
      </span>
    </button>
  </div>

  {{-- Sambutan Kepala Dinas --}}
  <div class="bg-gray-200 p-10 md:p-12">
    @if (!empty($kepala_dinas) && $kepala_dinas->nama)
      <div class="flex flex-col-reverse lg:flex-row justify-center items-center gap-3 lg:gap-16">
        <div>
          <div class="static flex flex-col-reverse items-center">
            <div
              class="mb-[5rem] sm:mb-[3.8rem] md:mb-[3.7rem] static bg-brand-blue rounded-t-[45%] lg:rounded-tl-[50%] lg:rounded-tr-none">
              <img class="lg:h-[450px]"
                src="{{ $kepala_dinas->foto ? Storage::url($kepala_dinas->foto) : asset('img/default.png') }}"
                alt="{{ $kepala_dinas->nama }}">
            </div>

            <div
              class="mx-[1.35rem] lg:mx-0 py-1.5 lg:py-1 px-2 lg:px-3 text-center absolute shadow-lg bg-white rounded-lg">
              <p class="font-bold text-lg lg:text-xl">
                {{ $kepala_dinas->nama }}
              </p>
              <p class="text-sm lg:text-base lg:font-medium">
                {{ $kepala_dinas->susunanOrganisasi->nama_susunan_organisasi ?? '' }} {{ config('app.nama_dinas') }}
              </p>
            </div>
          </div>
        </div>

        <div class="max-w-md lg:text-start text-center grid gap-3">
          <div>
            <span
              class="bg-brand-blue font-bold text-brand-yellow text-base me-2 px-4 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">
              SAMBUTAN
            </span>
          </div>

          <h1 class="font-bold text-3xl uppercase">
            SAMBUTAN KEPALA DINAS
          </h1>

          <p>
            {{ $kepala_dinas->susunanOrganisasi->deskripsi_susunan_organisasi ?? '' }}
          </p>

          <div>
            <a href="{{ route('guest.profil.profil-kepala-dinas.index') }}"
              class="text-brand-blue bg-brand-yellow font-bold rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
              Lihat Profil Selengkapnya
            </a>
          </div>
        </div>
      </div>
    @endif
  </div>

  {{-- Berita --}}
  <div class="p-10 md:p-12">
    @include('guest.components.section-title', [
        'page_subtitle' => 'BERITA TERKINI',
        'page_title' => 'Seputar DPUPR Kota Samarinda',
    ])

    <div class="w-fit grid mx-auto md:grid-cols-2 lg:grid-cols-3 gap-7">
      @foreach ($berita as $item)
        <div class="mx-auto max-w-[320px] rounded-xl shadow-lg flex flex-col">
          <a href="{{ route('guest.berita.kategori.show', ['slug_kategori' => $item->kategori->susunanOrganisasi->slug_susunan_organisasi]) }}"
            class="text-center text-sm text-white font-semibold bg-brand-blue rounded-t-xl py-2">
            {{ $item->kategori->susunanOrganisasi->nama_susunan_organisasi }}
          </a>
          <img class="aspect-[16/9]"
            src="{{ Storage::disk('public')->exists($item->foto_berita) ? Storage::url($item->foto_berita) : asset('image/placeholder/no-image-16x9.webp') }}"
            alt="{{ $item->judul_berita }}" />
          <div class="p-5 flex-grow flex flex-col justify-between">
            <div>
              <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                {{ $item->judul_berita }}
              </h5>
              <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                {{ $item->created_at->format('d M Y') }}</p>
            </div>
            <div class="flex justify-start">
              <a href="{{ route('guest.berita.show', ['slug_berita' => $item->slug_berita]) }}"
                class="inline-flex items-center px-3 py-2 text-sm font-semibold text-center text-brand-blue bg-brand-yellow rounded-xl w-auto">
                Baca berita
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                  fill="none" viewBox="0 0 14 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="flex justify-center pt-6 lg:pt-12">
      <a href="{{ route('guest.berita.kategori.index') }}"
        class="text-brand-blue bg-brand-yellow font-bold rounded-full text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Lihat Berita Lainnya
      </a>
    </div>
  </div>

  {{-- Struktur Organisasi --}}
  <div class="bg-gray-200 p-10 md:p-12">
    @include('guest.components.section-title', [
        'page_subtitle' => 'STRUKTUR ORGANISASI',
        'page_title' => 'Susunan Organisasi Kami',
    ])


    <div class="w-fit grid mx-auto md:grid-cols-2 lg:grid-cols-3 gap-7">
      @foreach ($struktur_organisasi as $i => $item)
        <a href="{{ route('guest.profil.struktur-organisasi.show', ['slug_susunan_organisasi' => $item->susunanOrganisasi->slug_susunan_organisasi]) }}"
          class="max-w-xs p-6 bg-white rounded-3xl shadow text-center flex flex-col mx-auto
            @if ($i === 0) md:col-span-2 lg:col-span-3 @endif">
          <figure>
            <div class="static mb-3 w-14 h-14 bg-brand-yellow/40 rounded-full m-auto flex items-center justify-center">
              <img class="absolute h-16" src="{{ Storage::url($item->ikon_jabatan) }}"
                alt="{{ $item->susunanOrganisasi->nama_susunan_organisasi }}">
            </div>
            <figcaption class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
              {{ $item->susunanOrganisasi->nama_susunan_organisasi }}
            </figcaption>
          </figure>
          <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">
            {{ $item->susunanOrganisasi->deskripsi_susunan_organisasi }}
          </p>
          <div class="mt-auto">
            <p class="inline-flex font-medium items-center text-brand-blue hover:underline">
              Pelajari selengkapnya
              <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778" />
              </svg>
            </p>
          </div>
        </a>
      @endforeach
    </div>

    <div class="flex justify-center pt-6 lg:pt-12">
      <a href="{{ route('guest.profil.struktur-organisasi.index') }}"
        class="text-brand-blue bg-brand-yellow font-bold rounded-full text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Lihat Struktur Organisasi
      </a>
    </div>
  </div>

  {{-- ================================================================= --}}
  {{-- =================== BAGIAN YANG DIUBAH MULAI DARI SINI ================== --}}
  {{-- ================================================================= --}}

  {{-- Agenda Kegiatan --}}
  <div class="p-10 md:p-12">
    @include('guest.components.section-title', [
        'page_subtitle' => 'Jadwal',
        'page_title' => 'Agenda Kegiatan',
    ])

    <div class="max-w-3xl mx-auto">
      <div class="space-y-6 mx-auto">
        {{-- Tanggal --}}
        <div class="space-y-2.5">
          <div class="flex justifu-center flex-col sm:flex-row sm:justify-between sm:items-center">
            <div class="flex justify-start items-center gap-1.5">
              <button id="agenda-prev-week"
                class="bg-brand-blue text-white rounded-xl h-5 w-5 p-4 flex items-center justify-center shadow">
                <i class="fa-solid fa-chevron-left"></i>
              </button>
              <span id="agenda-week-label"
                class="font-bold text-gray-700 bg-brand-yellow rounded-xl px-3.5 py-1 shadow w-full sm:w-auto text-center sm:text-left">
                {{-- Label minggu, diisi JS --}}
              </span>
              <button id="agenda-next-week"
                class="bg-brand-blue text-white rounded-xl h-5 w-5 p-4 flex items-center justify-center shadow">
                <i class="fa-solid fa-chevron-right"></i>
              </button>
            </div>
            <button id="agenda-today-btn"
              class="bg-brand-yellow text-brand-blue font-semibold rounded-xl px-3.5 py-1 shadow mt-4 mb-1.5 sm:mb-0 sm:mt-0 self-center sm:self-auto">
              Pergi ke hari ini
            </button>
          </div>

          <div id="agenda-days"
            class="rounded-2xl bg-brand-blue/20 p-4 border border-brand-blue shadow grid grid-cols-2 sm:grid-cols-12 md:grid-cols-7 gap-2.5">
            {{-- Diisi JS: daftar hari minggu berjalan dengan layout grid --}}
          </div>
        </div>

        <div id="agenda-list" class="flex flex-col justify-center items-center gap-3 w-full lg:w-5/6 mx-auto">
          {{-- Diisi JS: daftar agenda kegiatan pada hari terpilih --}}
        </div>
      </div>

      <div class="flex justify-center pt-3 lg:pt-6">
        <a href="{{ route('guest.agenda-kegiatan.index') }}"
          class="text-brand-blue bg-brand-yellow font-bold rounded-full text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          Lihat Semua Agenda Kegiatan
        </a>
      </div>
    </div>
  </div>
  {{-- ================================================================= --}}
  {{-- =================== BAGIAN YANG DIUBAH SELESAI DI SINI ================== --}}
  {{-- ================================================================= --}}

  {{-- Statistik Pengunjung --}}
  <div class="bg-gray-200 p-6 md:p-12">
    @include('guest.components.section-title', [
        'page_subtitle' => 'Statistik',
        'page_title' => 'Statistik Pengunjung',
    ])

    <div class="flex justify-center items-center">
      <div class="grid sm:grid-cols-3 gap-2 md:gap-4">
        <div class="block max-w-xs py-3 px-5 md:px-6 md:py-4 bg-brand-blue text-center rounded-2xl shadow">
          <h5 class="mb-2 text-2xl md:text-3xl font-bold tracking-tight text-white">HARI INI</h5>
          <p class="text-2xl md:text-3xl font-bold text-brand-yellow">
            {{ $statistik_pengunjung['today'] }}
          </p>
        </div>

        <div class="block max-w-xs py-3 px-5 md:px-6 md:py-4 bg-brand-blue text-center rounded-2xl shadow">
          <h5 class="mb-2 text-2xl md:text-3xl font-bold tracking-tight text-white">MINGGU INI</h5>
          <p class="text-2xl md:text-3xl font-bold text-brand-yellow">
            {{ $statistik_pengunjung['this_week'] }}
          </p>
        </div>

        <div class="block max-w-xs py-3 px-5 md:px-6 md:py-4 bg-brand-blue text-center rounded-2xl shadow">
          <h5 class="mb-2 text-2xl md:text-3xl font-bold tracking-tight text-white">BULAN INI</h5>
          <p class="text-2xl md:text-3xl font-bold text-brand-yellow">
            {{ $statistik_pengunjung['this_month'] }}
          </p>
        </div>
      </div>
    </div>
  </div>

  {{-- Partner --}}
  <div class="p-8 sm:p-10 md:p-12">
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active flex justify-evenly">
          <section class="splide w-full" aria-labelledby="carousel-heading">
            <div class="splide__track">
              <ul class="splide__list">
                @foreach ($partner as $item)
                  <li class="splide__slide my-auto !w-fit px-6 sm:px-10">
                    <a href="{{ $item->url_partner }}" class="!w-fit">
                      <img class="h-24 object-contain" src="{{ Storage::url($item->foto_partner) }}"
                        alt="{{ $item->nama_partner }}" height="36">
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('document.end')
  @vite(['resources/js/splidejs.js', 'resources/js/splide-autoscroll.js'])

  {{-- ================================================================= --}}
  {{-- ================ SCRIPT YANG DIUBAH MULAI DARI SINI ================ --}}
  {{-- ================================================================= --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var el = document.querySelector('.splide');
      if (el && window.SplideAutoScroll) {
        var splide = new Splide(el, {
          type: 'loop',
          drag: 'free',
          focus: 'center',
          breakpoints: {
            640: {
              perPage: 2
            },
            768: {
              perPage: 4
            },
            1024: {
              perPage: 4
            },
            1280: {
              perPage: 5
            },
            1920: {
              perPage: 5
            }
          },
          autoScroll: {
            speed: 0.4
          },
          arrows: false,
          pagination: false,
          extensions: {
            AutoScroll: window.SplideAutoScroll
          }
        });
        splide.mount({
          AutoScroll: window.SplideAutoScroll
        });
      }
    });

    document.addEventListener('DOMContentLoaded', function() {
      // Kode agenda lainnya tetap sama
      function formatDate(date) {
        return date.toLocaleDateString('id-ID', {
          day: 'numeric',
          month: 'long',
          year: 'numeric'
        });
      }

      function formatTime(timeStr) {
        return timeStr ? timeStr.substring(0, 5) : '';
      }

      let currentDate = new Date();
      let currentWeekStart = new Date(currentDate);
      currentWeekStart.setDate(currentDate.getDate() - currentDate.getDay() + (currentDate.getDay() === 0 ? -6 : 1));
      let currentWeekEnd = new Date(currentWeekStart);
      currentWeekEnd.setDate(currentWeekStart.getDate() + 6);
      let selectedDate = new Date(currentDate);

      function updateWeekLabel() {
        document.getElementById('agenda-week-label').textContent = formatDate(currentWeekStart) + ' - ' + formatDate(
          currentWeekEnd);
      }

      function renderDays(weekCounts = {}) {
        const daysContainer = document.getElementById('agenda-days');
        daysContainer.innerHTML = '';
        for (let i = 0; i < 7; i++) {
          let dayDate = new Date(currentWeekStart);
          dayDate.setDate(currentWeekStart.getDate() + i);
          let isToday = dayDate.toDateString() === currentDate.toDateString();
          let isSelected = dayDate.toDateString() === selectedDate.toDateString();
          let dayStr = dayDate.toISOString().slice(0, 10);

          let cardClass =
            'rounded-xl font-bold py-2.5 flex flex-col items-center justify-center shadow cursor-pointer ';
          if (isSelected && isToday) {
            cardClass += 'bg-brand-blue text-white border-2 border-brand-yellow';
          } else if (isSelected) {
            cardClass += 'bg-brand-blue text-white';
          } else if (isToday) {
            cardClass += 'bg-brand-yellow text-black border-2 border-brand-yellow';
          } else {
            cardClass += 'bg-brand-yellow/30 text-black';
          }

          let kegiatanCount = weekCounts[dayStr] ?? 0;
          let kegiatanColor = isSelected ? 'text-brand-yellow' : 'text-brand-blue';

          let dayDiv = document.createElement('div');
          dayDiv.className = cardClass;
          dayDiv.dataset.date = dayStr;

          // DIUBAH (REVISI FINAL): Logika class responsif yang baru
          const responsiveClasses = [];

          // 1. Layout default (<sm): 2-2-2-1
          if (i === 6) {
            responsiveClasses.push('col-span-2');
          }

          // 2. Layout 'sm': 4-3 (penuh) menggunakan grid 12 kolom
          if (i < 4) {
            responsiveClasses.push('sm:col-span-3'); // 4 item x 3 span = 12
          } else {
            responsiveClasses.push('sm:col-span-4'); // 3 item x 4 span = 12
          }

          // 3. Layout 'md' ke atas: Reset agar setiap item memakan 1 kolom dari 7
          responsiveClasses.push('md:col-span-1');

          dayDiv.classList.add(...responsiveClasses);

          dayDiv.innerHTML = `
            <div>${dayDate.getDate()}</div>
            <div>${dayDate.toLocaleDateString('id-ID', { weekday: 'long' })}</div>
            <div><span class="text-xs font-medium ${kegiatanColor}" id="agenda-count-${dayStr}">${kegiatanCount} Kegiatan</span></div>
          `;
          dayDiv.onclick = function() {
            selectedDate = dayDate;
            renderDays(weekCounts);
            fetchAgendaList();
          };
          daysContainer.appendChild(dayDiv);
        }
      }

      // Kode fetchWeekCounts, fetchAgendaList, updateAgendaWeek, dan event listener button lainnya tetap sama
      function fetchWeekCounts(callback) {
        const startStr = currentWeekStart.toISOString().slice(0, 10);
        const endStr = currentWeekEnd.toISOString().slice(0, 10);
        fetch(`{{ route('guest.agenda-kegiatan.ajax-week-count') }}?start=${startStr}&end=${endStr}`)
          .then(res => res.json()).then(data => {
            callback(data);
          });
      }

      function fetchAgendaList() {
        const dateStr = selectedDate.toISOString().slice(0, 10);
        fetch(`{{ route('guest.agenda-kegiatan.ajax') }}?start=${dateStr}&end=${dateStr}`)
          .then(res => res.json())
          .then(data => {
            const listContainer = document.getElementById('agenda-list');
            listContainer.innerHTML = '';
            let infoDiv = document.createElement('div');
            infoDiv.className =
            'text-sm bg-brand-yellow text-brand-blue px-2.5 py-1 rounded-full shadow sm:self-start';
            infoDiv.innerHTML =
              `${data.length} Kegiatan pada <span class="font-semibold">${formatDate(selectedDate)}</span>`;
            listContainer.appendChild(infoDiv);
            if (data.length === 0) {
              let emptyDiv = document.createElement('div');
              emptyDiv.className =
                'rounded-2xl bg-brand-blue/20 p-4 border border-brand-blue w-full shadow text-center';
              emptyDiv.textContent = 'Tidak ada agenda kegiatan pada tanggal ini.';
              listContainer.appendChild(emptyDiv);
            } else {
              data.forEach(item => {
                let agendaDiv = document.createElement('div');
                agendaDiv.className = 'rounded-2xl bg-brand-blue/20 p-4 border border-brand-blue w-full shadow';
                agendaDiv.innerHTML =
                  `<p class="font-bold text-black">${item.nama}</p><p class="text-sm text-gray-700"><b>Waktu</b>: ${formatTime(item.waktu_mulai)} WITA</p><p class="text-sm text-gray-700"><b>Pelaksana</b>: ${item.pelaksana}</p><p class="text-sm text-gray-700"><b>Lokasi</b>: ${item.tempat}</p><p class="text-sm text-black"><b>Dihadiri oleh: ${item.dihadiri_oleh}</b></p>`;
                listContainer.appendChild(agendaDiv);
              });
            }
          });
      }

      function updateAgendaWeek() {
        updateWeekLabel();
        fetchWeekCounts(function(weekCounts) {
          renderDays(weekCounts);
          fetchAgendaList();
        });
      }

      document.getElementById('agenda-prev-week').onclick = function() {
        currentWeekStart.setDate(currentWeekStart.getDate() - 7);
        currentWeekEnd.setDate(currentWeekEnd.getDate() - 7);
        selectedDate = new Date(currentWeekStart);
        updateAgendaWeek();
      };
      document.getElementById('agenda-next-week').onclick = function() {
        currentWeekStart.setDate(currentWeekStart.getDate() + 7);
        currentWeekEnd.setDate(currentWeekEnd.getDate() + 7);
        selectedDate = new Date(currentWeekStart);
        updateAgendaWeek();
      };
      document.getElementById('agenda-today-btn').onclick = function() {
        currentDate = new Date();
        currentWeekStart = new Date(currentDate);
        currentWeekStart.setDate(currentDate.getDate() - currentDate.getDay() + (currentDate.getDay() === 0 ? -6 :
          1));
        currentWeekEnd = new Date(currentWeekStart);
        currentWeekEnd.setDate(currentWeekStart.getDate() + 6);
        selectedDate = new Date(currentDate);
        updateAgendaWeek();
      };

      updateAgendaWeek();
    });
  </script>
@endsection
