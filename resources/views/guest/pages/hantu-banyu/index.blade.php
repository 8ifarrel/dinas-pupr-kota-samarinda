@extends('guest.layouts.main')

@section('document.start')
  <link rel="dns-prefetch" href="https://lottie.host">
  <link rel="preconnect" href="https://lottie.host" crossorigin>
@endsection

@section('document.body')
  {{-- HERO SECTION: Interactive Map + Step Timeline --}}
  <section
    class="relative min-h-[calc(100vh-148px)] flex flex-col items-center justify-center overflow-hidden py-8 md:py-12">
    {{-- Map BG --}}
    <div class="absolute inset-0 z-0 pointer-events-none">
      <img src="{{ asset('image/hero/hantu-banyu.jpeg') }}" alt="Peta Samarinda"
        class="w-full h-full object-cover opacity-25 blur-[2px]" />
      <div class="absolute inset-0 bg-gradient-to-b from-brand-blue/70 via-white/10 to-white"></div>
    </div>

    {{-- Akun kelurahan (pojok kanan atas hero) --}}
    @auth('kelurahan')
      @php $akunKel = Auth::guard('kelurahan')->user(); @endphp
      <div class="absolute top-4 right-4 sm:top-6 sm:right-6 z-20">
        <button data-dropdown-toggle="dropdownAkunKelurahan" data-dropdown-placement="bottom-end" type="button"
          class="inline-flex items-center gap-2 text-brand-blue bg-white font-semibold rounded-xl text-sm px-3 py-2 shadow-lg hover:shadow-xl active:shadow-md transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-blue/40 focus-visible:ring-offset-2">
          <i class="fa-solid fa-circle-user"></i>
          <span class="hidden sm:inline">Akun Saya</span>
          <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
          </svg>
        </button>
        <div id="dropdownAkunKelurahan"
          class="z-50 hidden bg-white text-gray-700 divide-y divide-gray-100 rounded-lg shadow-lg border w-60">
          <div class="px-4 py-3">
            <p class="text-sm font-semibold text-gray-900 truncate">{{ $akunKel->fullname }}</p>
            <p class="text-xs text-gray-500 truncate">
              Kelurahan {{ optional($akunKel->kelurahan)->nama ?? '-' }}
            </p>
          </div>
          <ul class="py-1 text-sm">
            <li>
              <a href="{{ route('guest.hantu-banyu.akun.edit') }}"
                class="block px-4 py-2 hover:bg-gray-100">Kelola Akun</a>
            </li>
            <li>
              <form method="POST" action="{{ route('guest.hantu-banyu.logout') }}">
                @csrf
                <button type="submit" class="w-full text-left block px-4 py-2 text-red-600 hover:bg-gray-100">
                  Logout
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    @endauth

    {{-- Main Card --}}
    <div class="relative z-10 flex flex-col items-center w-full px-4 sm:px-6 md:px-8 lg:gap-6 3xl:gap-10">
      <div class="text-center">
        <div class="flex justify-center gap-2 mb-2 lg:mb-2 3xl:mb-4">
          <span
            class="inline-block bg-brand-yellow text-brand-blue font-bold text-xs sm:text-sm 2xl:text-base 3xl:text-lg px-2 sm:px-3 py-0.5 sm:py-1 rounded-full shadow">{{ $page_subtitle }}</span>
        </div>
        {{-- <h1
          class="mb-2 sm:mb-3 lg:mb-3 3xl:mb-5 text-2xl sm:text-3xl md:text-4xl lg:text-4xl 2xl:text-5xl 3xl:text-7xl font-semibold text-brand-blue px-0 sm:px-8 md:px-12 lg:px-24 max-w-[286px] xs:max-w-full mx-auto">
          Laporkan Masalah Drainase <br class="hidden sm:inline lg:hidden 2xl:inline"> dan Irigasi <br
            class="hidden lg:inline 2xl:hidden"> di Aplikasi Hantu Banyu
        </h1> --}}
        <h1
          class="mb-2 sm:mb-3 lg:mb-3 3xl:mb-5 text-3xl sm:text-4xl lg:text-5xl 2xl:text-6xl 3xl:text-7xl font-semibold text-brand-blue px-0 sm:px-8 md:px-12 lg:px-24 max-w-[286px] xs:max-w-full mx-auto">
          Hantu Banyu
        </h1>
        <p
          class="mb-4 sm:mb-5 lg:mb-6 3xl:mb-10 text-sm sm:text-base lg:text-base 3xl:text-2xl font-medium text-gray-700 sm:px-4 md:px-8 lg:px-0 lg:max-w-4xl 3xl:max-w-6xl mx-auto">
          Laporkan masalah <b>banjir dan kerusakan saluran drainase dan irigasi</b> melalui layanan <b>Hantu Banyu</b> dari <b>UPTD
            Pemeliharaan Saluran Drainase dan Irigasi</b> Dinas PUPR Kota Samarinda!
        </p>
        <div 
          class="
            flex flex-col 
            sm:grid sm:grid-cols-2 sm:gap-4 sm:w-full 
            md:grid md:grid-cols-2 md:gap-4 md:w-full
            lg:flex lg:flex-row lg:justify-center lg:gap-4
            justify-center gap-3
          "
        >
          <a href="{{ route('guest.hantu-banyu.pengaduan.create') }}"
            class="inline-flex justify-center items-center px-4 py-2 3xl:py-3 3xl:px-6 text-sm 2xl:text-base font-semibold text-white rounded-lg bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue shadow-lg transition">
            Buat Pengaduan
            <i class="fa-solid fa-paper-plane ms-1.5"></i>
          </a>
          <a href="{{ route('guest.hantu-banyu.pengaduan.index') }}"
            class="inline-flex justify-center items-center px-4 py-2 3xl:py-3 3xl:px-6 text-sm 2xl:text-base font-medium text-brand-blue rounded-lg border border-brand-blue hover:bg-brand-blue hover:text-white shadow-lg transition">
            Lihat Semua Pengaduan
            <i class="fa-solid fa-list-ol ms-1.5"></i>
          </a>
          <a href="{{ route('guest.hantu-banyu.peta-sebaran.index') }}"
            class="inline-flex justify-center items-center px-4 py-2 3xl:py-3 3xl:px-6 text-sm 2xl:text-base font-medium text-brand-blue rounded-lg border border-brand-blue hover:bg-brand-blue hover:text-white shadow-lg transition">
            Lihat Peta Sebaran
            <i class="fa-solid fa-map-location-dot ms-1.5"></i>
          </a>
          <a href="https://wa.me/6281234567890" target="_blank"
            class="inline-flex justify-center items-center px-4 py-2 3xl:py-3 3xl:px-6 text-sm 2xl:text-base font-medium text-white rounded-lg bg-green-600 hover:bg-green-700 shadow-lg transition">
            Hubungi Kami di WhatsApp
            <i class="fa-brands fa-whatsapp fa-lg ms-1.5"></i>
          </a>
        </div>
      </div>

      {{-- Step Timeline --}}
      <div class="w-full flex flex-col items-center mt-8 sm:mt-10 md:mt-12 lg:mt-0">
        <div
          class="flex flex-col sm:grid lg:flex sm:grid-cols-2 items-center justify-center sm:gap-x-4 sm:gap-y-6 lg:flex-row lg:gap-2 xl:gap-6 3xl:gap-8 w-full max-w-[240px] sm:max-w-xl md:max-w-2xl lg:max-w-4xl xl:max-w-5xl 3xl:max-w-6xl text-center">
          {{-- Siapa yang bisa Melapor? --}}
          <div class="flex flex-col items-center group flex-1 mb-5 sm:mb-0">
            <div
              class="bg-brand-blue text-brand-yellow rounded-full w-10 h-10 sm:w-10 sm:h-10 lg:w-12 lg:h-12 2xl:w-16 2xl:h-16 flex items-center justify-center text-lg sm:text-lg lg:text-xl 2xl:text-3xl shadow-lg group-hover:scale-110 transition">
              <i class="fa-solid fa-users"></i>
            </div>
            <span
              class="mt-1 sm:mt-2 2xl:mt-3 font-bold text-brand-blue text-sm sm:text-sm lg:text-base 2xl:text-lg">Siapa
              yang bisa Melapor?</span>
            <span
              class="text-gray-700 text-xs sm:text-xs lg:text-sm 2xl:text-base text-center mt-0.5 2xl:mt-1 px-2">Seluruh
              warga Kota Samarinda</span>
          </div>
          <div class="hidden lg:block h-1 w-8 lg:w-10 xl:w-12 bg-brand-yellow rounded-full"></div>
          {{-- Jadwal Petugas Lapangan --}}
          <div class="flex flex-col items-center group flex-1 mb-5 sm:mb-0">
            <div
              class="bg-brand-yellow text-brand-blue rounded-full w-10 h-10 sm:w-10 sm:h-10 lg:w-12 lg:h-12 2xl:w-16 2xl:h-16 flex items-center justify-center text-lg sm:text-lg lg:text-xl 2xl:text-3xl shadow-lg group-hover:scale-110 transition">
              <i class="fa-solid fa-helmet-safety"></i>
            </div>
            <span
              class="mt-1 sm:mt-2 2xl:mt-3 font-bold text-brand-blue text-sm sm:text-sm lg:text-base 2xl:text-lg">Jadwal
              Petugas Lapangan</span>
            <span class="text-gray-700 text-xs sm:text-xs lg:text-sm 2xl:text-base text-center mt-0.5 2xl:mt-1 px-2">Libur
              setiap hari Jumat
              hari Sabtu & Minggu</span>
          </div>
          <div class="hidden lg:block h-1 w-8 lg:w-10 xl:w-12 bg-brand-yellow rounded-full"></div>
          {{-- Jadwal Petugas Kantor --}}
          <div class="flex flex-col items-center group flex-1 mb-5 sm:mb-0">
            <div
              class="bg-brand-yellow text-brand-blue rounded-full w-10 h-10 sm:w-10 sm:h-10 lg:w-12 lg:h-12 2xl:w-16 2xl:h-16 flex items-center justify-center text-lg sm:text-lg lg:text-xl 2xl:text-3xl shadow-lg group-hover:scale-110 transition">
              <i class="fa-solid fa-briefcase"></i>
            </div>
            <span
              class="mt-1 sm:mt-2 2xl:mt-3 font-bold text-brand-blue text-sm sm:text-sm lg:text-base 2xl:text-lg">Jadwal
              Petugas Kantor</span>
            <span class="text-gray-700 text-xs sm:text-xs lg:text-sm 2xl:text-base text-center mt-0.5 2xl:mt-1 px-2">Libur
              setiap hari Sabtu dan
              Minggu</span>
          </div>
          <div class="hidden lg:block h-1 w-8 lg:w-10 xl:w-12 bg-brand-yellow rounded-full"></div>
          {{-- Proses Laporan --}}
          <div class="flex flex-col items-center group flex-1">
            <div
              class="bg-brand-blue text-brand-yellow rounded-full w-10 h-10 sm:w-10 sm:h-10 lg:w-12 lg:h-12 2xl:w-16 2xl:h-16 flex items-center justify-center text-lg sm:text-lg lg:text-xl 2xl:text-3xl shadow-lg group-hover:scale-110 transition">
              <i class="fa-solid fa-list-check"></i>
            </div>
            <span
              class="mt-1 sm:mt-2 2xl:mt-3 font-bold text-brand-blue text-sm sm:text-sm lg:text-base 2xl:text-lg">Proses
              Laporan</span>
            <span
              class="text-gray-700 text-xs sm:text-xs lg:text-sm 2xl:text-base text-center mt-0.5 2xl:mt-1 px-2">Diurutkan
              berdasarkan waktu laporan
              masuk dan tingkat
              prioritas</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-6 sm:py-8 lg:py-16 px-4 sm:px-6 lg:px-16">
    <div class="text-center space-y-1.5 pb-5 lg:pb-10">
      <h2 class="text-3xl lg:text-4xl font-bold">Statistik Pengaduan</h2>
    </div>

{{--
  Statistik pengaduan Hantu Banyu. Butuh variabel yang disiapkan controller
  (lihat method compute() di controller ini).
--}}
@if ($total === 0)
  <div class="bg-white rounded-lg shadow-lg border p-10 text-center">
    <i class="fa-solid fa-chart-pie text-gray-300 text-5xl mb-3"></i>
    <p class="text-gray-500">Belum ada laporan yang masuk. Statistik akan tampil setelah ada data.</p>
  </div>
@else
  {{-- ===================== KPI ===================== --}}
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-lg shadow-lg border p-5">
      <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">Total Laporan</span>
        <i class="fa-solid fa-file-lines text-blue-500"></i>
      </div>
      <div class="text-2xl font-bold text-gray-900 mt-2">{{ $total }}</div>
    </div>
    <div class="bg-white rounded-lg shadow-lg border p-5">
      <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">Sedang Diproses</span>
        <i class="fa-solid fa-spinner text-indigo-500"></i>
      </div>
      <div class="text-2xl font-bold text-gray-900 mt-2">{{ $total_berjalan }}</div>
    </div>
    <div class="bg-white rounded-lg shadow-lg border p-5">
      <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">Selesai</span>
        <i class="fa-solid fa-circle-check text-green-500"></i>
      </div>
      <div class="text-2xl font-bold text-gray-900 mt-2">{{ $total_selesai }}</div>
      <div class="text-xs text-gray-400 mt-1">{{ round($total_selesai / $total * 100) }}% dari total</div>
    </div>
    <div class="bg-white rounded-lg shadow-lg border p-5">
      <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">Belum Diproses</span>
        <i class="fa-solid fa-clock text-yellow-500"></i>
      </div>
      <div class="text-2xl font-bold text-gray-900 mt-2">{{ $belum_diproses }}</div>
    </div>
  </div>

  @php
    $selectCls = 'text-sm border border-gray-300 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-200';
  @endphp

  {{-- ===================== Laporan Masuk (bar, kuartal + tahun) ===================== --}}
  <div class="bg-white rounded-lg shadow-lg border p-6 mt-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
      <div>
        <h3 class="font-semibold text-gray-900">Laporan Masuk</h3>
      </div>
      <div class="flex gap-2">
        <select id="masukQuarter" class="{{ $selectCls }}">
          <option value="1">Kuartal I (Jan–Mar)</option>
          <option value="2">Kuartal II (Apr–Jun)</option>
          <option value="3">Kuartal III (Jul–Sep)</option>
          <option value="4">Kuartal IV (Okt–Des)</option>
        </select>
        <select id="masukYear" class="{{ $selectCls }}">
          @foreach ($years as $y)
            <option value="{{ $y }}">{{ $y }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="relative h-72">
      <canvas id="chartMasuk"></canvas>
      <div id="nodataMasuk"
        class="absolute inset-0 hidden items-center justify-center text-gray-400 text-sm bg-white">
        Tidak ada data pada periode ini
      </div>
    </div>
  </div>

  {{-- ===================== Diproses & Jenis (doughnut, bulan + tahun) ===================== --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <div class="bg-white rounded-lg shadow-lg border p-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
        <div>
          <h3 class="font-semibold text-gray-900">Laporan sedang Diproses</h3>
        </div>
        <div class="flex gap-2">
          <select id="diprosesMonth" class="{{ $selectCls }}"></select>
          <select id="diprosesYear" class="{{ $selectCls }}">
            @foreach ($years as $y)
              <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="relative h-72">
        <canvas id="chartDiproses"></canvas>
        <div id="nodataDiproses"
          class="absolute inset-0 hidden items-center justify-center text-gray-400 text-sm bg-white">
          Tidak ada data pada periode ini
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg border p-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
        <div>
          <h3 class="font-semibold text-gray-900">Jenis Laporan</h3>
        </div>
        <div class="flex gap-2">
          <select id="jenisMonth" class="{{ $selectCls }}"></select>
          <select id="jenisYear" class="{{ $selectCls }}">
            @foreach ($years as $y)
              <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="relative h-72">
        <canvas id="chartJenis"></canvas>
        <div id="nodataJenis"
          class="absolute inset-0 hidden items-center justify-center text-gray-400 text-sm bg-white">
          Tidak ada data pada periode ini
        </div>
      </div>
    </div>
  </div>

  {{-- ===================== Kecamatan (bar, bulan + tahun) ===================== --}}
  <div class="bg-white rounded-lg shadow-lg border p-6 mt-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
      <div>
        <h3 class="font-semibold text-gray-900">Sebaran Laporan per Kecamatan</h3>
      </div>
      <div class="flex gap-2">
        <select id="kecMonth" class="{{ $selectCls }}"></select>
        <select id="kecYear" class="{{ $selectCls }}">
          @foreach ($years as $y)
            <option value="{{ $y }}">{{ $y }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="relative" style="height: {{ max(288, $kecamatan_list->count() * 34) }}px">
      <canvas id="chartKecamatan"></canvas>
      <div id="nodataKec"
        class="absolute inset-0 hidden items-center justify-center text-gray-400 text-sm bg-white">
        Tidak ada data pada periode ini
      </div>
    </div>
  </div>
@endif
  </section>
@endsection

@section('document.end')
  <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module" defer>
  </script>

  @if ($total > 0)
    @vite('resources/js/chartjs.js')
  @endif
{{--
  Script grafik statistik Hantu Banyu.
  Pastikan Chart.js sudah dimuat (@vite('resources/js/chartjs.js')) sebelum ini.
--}}
@if ($total > 0)
  <script>
    window.addEventListener('load', function() {
      if (!window.Chart) return;

      Chart.defaults.font.family = getComputedStyle(document.body).fontFamily;
      Chart.defaults.color = '#6b7280';

      var byYM = @json($by_ym);
      var kecList = @json($kecamatan_list);
      var nowYear = {{ $now_year }},
        nowMonth = {{ $now_month }},
        nowQuarter = {{ $now_quarter }};

      var bulanNama = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
        'Oktober', 'November', 'Desember'
      ];
      var kuartalNama = ['Kuartal I', 'Kuartal II', 'Kuartal III', 'Kuartal IV'];

      var diprosesKeys = ['diterima', 'menunggu_survei', 'sudah_disurvei', 'menunggu_jadwal_pengerjaan',
        'sedang_dikerjakan'
      ];
      var diprosesLabel = ['Diterima', 'Menunggu Survei', 'Sudah Disurvei', 'Menunggu Jadwal Pengerjaan',
        'Sedang Dikerjakan'
      ];
      var diprosesColor = ['#3b82f6', '#ec4899', '#a855f7', '#f97316', '#6366f1'];

      var jenisKeys = ['belum_diklasifikasikan', 'darurat', 'biasa', 'rutin'];
      var jenisLabel = ['Belum Diklasifikasikan', 'Penanganan Darurat', 'Penanganan Biasa', 'Pemeliharaan Rutin'];
      var jenisColor = ['#9ca3af', '#ef4444', '#14b8a6', '#3b82f6'];

      function cell(y, m) {
        return (byYM[y] && byYM[y][m]) || {
          masuk: 0,
          status: {},
          jenis: {},
          kecamatan: {}
        };
      }

      function num(o, k) {
        return (o && o[k]) ? o[k] : 0;
      }

      function sum(arr) {
        return arr.reduce(function(a, b) {
          return a + b;
        }, 0);
      }

      function toggleNoData(id, empty) {
        var el = document.getElementById(id);
        el.style.display = empty ? 'flex' : 'none';
      }

      // Isi dropdown bulan
      ['diprosesMonth', 'jenisMonth', 'kecMonth'].forEach(function(id) {
        var sel = document.getElementById(id);
        bulanNama.forEach(function(nama, i) {
          var opt = document.createElement('option');
          opt.value = i + 1;
          opt.textContent = nama;
          sel.appendChild(opt);
        });
      });

      // Set nilai default
      document.getElementById('masukQuarter').value = nowQuarter;
      document.getElementById('masukYear').value = nowYear;
      ['diprosesMonth', 'jenisMonth', 'kecMonth'].forEach(function(id) {
        document.getElementById(id).value = nowMonth;
      });
      ['diprosesYear', 'jenisYear', 'kecYear'].forEach(function(id) {
        document.getElementById(id).value = nowYear;
      });

      var doughnutOpts = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'right'
          }
        }
      };

      // ---------- Laporan Masuk ----------
      var chartMasuk = new Chart(document.getElementById('chartMasuk'), {
        type: 'bar',
        data: {
          labels: [],
          datasets: [{
              label: 'Belum diproses',
              data: [],
              backgroundColor: '#E63846',
              borderRadius: 4
            },
            {
              label: 'Sedang diproses',
              data: [],
              backgroundColor: '#F9A11A',
              borderRadius: 4
            },
            {
              label: 'Selesai',
              data: [],
              backgroundColor: '#9EDE73',
              borderRadius: 4
            },
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              stacked: true
            },
            y: {
              stacked: true,
              beginAtZero: true,
              ticks: {
                precision: 0
              }
            }
          },
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      });

      function renderMasuk() {
        var q = parseInt(document.getElementById('masukQuarter').value, 10);
        var y = parseInt(document.getElementById('masukYear').value, 10);
        var start = (q - 1) * 3 + 1;
        var months = [start, start + 1, start + 2];
        var pending = [],
          proses = [],
          selesai = [];
        months.forEach(function(m) {
          var st = cell(y, m).status;
          pending.push(num(st, 'pending'));
          proses.push(diprosesKeys.reduce(function(a, k) {
            return a + num(st, k);
          }, 0));
          selesai.push(num(st, 'selesai'));
        });
        chartMasuk.data.labels = months.map(function(m) {
          return bulanNama[m - 1];
        });
        chartMasuk.data.datasets[0].data = pending;
        chartMasuk.data.datasets[1].data = proses;
        chartMasuk.data.datasets[2].data = selesai;
        chartMasuk.update();

        var totalP = sum(pending) + sum(proses) + sum(selesai);
        toggleNoData('nodataMasuk', totalP === 0);
      }

      // ---------- Laporan sedang Diproses ----------
      var chartDiproses = new Chart(document.getElementById('chartDiproses'), {
        type: 'doughnut',
        data: {
          labels: diprosesLabel,
          datasets: [{
            data: [],
            backgroundColor: diprosesColor
          }]
        },
        options: doughnutOpts
      });

      function renderDiproses() {
        var m = parseInt(document.getElementById('diprosesMonth').value, 10);
        var y = parseInt(document.getElementById('diprosesYear').value, 10);
        var st = cell(y, m).status;
        var data = diprosesKeys.map(function(k) {
          return num(st, k);
        });
        chartDiproses.data.datasets[0].data = data;
        chartDiproses.update();
        toggleNoData('nodataDiproses', sum(data) === 0);
      }

      // ---------- Jenis Laporan ----------
      var chartJenis = new Chart(document.getElementById('chartJenis'), {
        type: 'doughnut',
        data: {
          labels: jenisLabel,
          datasets: [{
            data: [],
            backgroundColor: jenisColor
          }]
        },
        options: doughnutOpts
      });

      function renderJenis() {
        var m = parseInt(document.getElementById('jenisMonth').value, 10);
        var y = parseInt(document.getElementById('jenisYear').value, 10);
        var jn = cell(y, m).jenis;
        var data = jenisKeys.map(function(k) {
          return num(jn, k);
        });
        chartJenis.data.datasets[0].data = data;
        chartJenis.update();
        toggleNoData('nodataJenis', sum(data) === 0);
      }

      // ---------- Kecamatan ----------
      var chartKec = new Chart(document.getElementById('chartKecamatan'), {
        type: 'bar',
        data: {
          labels: kecList,
          datasets: [{
            label: 'Jumlah laporan',
            data: [],
            backgroundColor: '#223468',
            borderRadius: 4
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              beginAtZero: true,
              ticks: {
                precision: 0
              }
            }
          },
          plugins: {
            legend: {
              display: false
            }
          }
        }
      });

      function renderKec() {
        var m = parseInt(document.getElementById('kecMonth').value, 10);
        var y = parseInt(document.getElementById('kecYear').value, 10);
        var kc = cell(y, m).kecamatan;
        var data = kecList.map(function(nama) {
          return num(kc, nama);
        });
        chartKec.data.datasets[0].data = data;
        chartKec.update();
        toggleNoData('nodataKec', sum(data) === 0);
      }

      // Listeners
      document.getElementById('masukQuarter').addEventListener('change', renderMasuk);
      document.getElementById('masukYear').addEventListener('change', renderMasuk);
      document.getElementById('diprosesMonth').addEventListener('change', renderDiproses);
      document.getElementById('diprosesYear').addEventListener('change', renderDiproses);
      document.getElementById('jenisMonth').addEventListener('change', renderJenis);
      document.getElementById('jenisYear').addEventListener('change', renderJenis);
      document.getElementById('kecMonth').addEventListener('change', renderKec);
      document.getElementById('kecYear').addEventListener('change', renderKec);

      renderMasuk();
      renderDiproses();
      renderJenis();
      renderKec();
    });
  </script>
@endif
@endsection
