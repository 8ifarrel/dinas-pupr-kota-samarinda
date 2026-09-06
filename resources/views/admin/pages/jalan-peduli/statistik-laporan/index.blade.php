@extends('admin.layout')

@section('document.body')
  <div class="sticky top-[80px] z-30 w-full">
    <div class="container mx-auto">
      <div class="backdrop-blur-sm rounded-xl">
        <div class="flex justify-between items-center bg-white p-3 rounded-xl shadow-lg border ">
          <div class="flex items-center gap-2 flex-wrap">
            <button id="toggleFilterBtn" type="button"
              class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-400 transition-all duration-200 transform hover:scale-105">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
              </svg>
              <span id="toggleFilterBtnLabel">Tampilkan Filter</span>
            </button>
          </div>
        </div>
        <div id="filterPanel" class="mt-4 hidden shadow-lg">
          <div
            class="bg-white p-4 rounded-xl shadow-md border flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div id="filterRadioGroup" class="flex items-center p-1 bg-slate-200 rounded-full w-full lg:w-auto">
              <label data-value="bulan"
                class="flex-1 text-center px-4 py-1.5 text-sm font-semibold text-slate-600 rounded-full cursor-pointer transition-colors duration-300 active">
                <input type="radio" name="filter" value="bulan" class="sr-only" checked><span>Bulan</span>
              </label>
              <label data-value="tahun"
                class="flex-1 text-center px-4 py-1.5 text-sm font-semibold text-slate-600 rounded-full cursor-pointer transition-colors duration-300">
                <input type="radio" name="filter" value="tahun" class="sr-only"><span>Tahun</span>
              </label>
              <label data-value="keseluruhan"
                class="flex-1 text-center px-4 py-1.5 text-sm font-semibold text-slate-600 rounded-full cursor-pointer transition-colors duration-300">
                <input type="radio" name="filter" value="keseluruhan" class="sr-only"><span>Total</span>
              </label>
            </div>
            <div id="filterDropdownGroup" class="flex items-center gap-2 w-full lg:w-auto">
              <select id="monthSelect"
                class="w-full sm:w-auto bg-white border border-slate-300 rounded-md py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                {{-- Bulan akan diisi JS --}}
              </select>
              <select id="yearSelect"
                class="w-full sm:w-auto bg-white border border-slate-300 rounded-md py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                {{-- Tahun akan diisi JS --}}
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Konten utama --}}
  <div class="container mx-auto pt-4 sm:pt-6 lg:pt-8">
    <div id="periodInfo" class="mb-4 sm:mb-6 lg:mb-8 flex items-center justify-center sm:justify-normal">
      <div class="flex items-center gap-2 bg-indigo-600 px-4 py-2 rounded-lg shadow text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-80" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 7V3m8 4V3m-9 8h10m-12 8a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span id="periodInfoText" class="text-sm sm:text-base font-medium">Menampilkan data Januari 2024</span>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm font-medium text-indigo-200 uppercase">Total Laporan</p>
        <h2 id="totalLaporan" class="text-4xl font-bold mt-2">{{ $total }}</h2>
      </div>
      <div class="bg-gradient-to-br from-gray-400 to-slate-500 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm font-medium text-gray-200 uppercase">Pending</p>
        <h3 id="pending" class="text-4xl font-bold mt-2">{{ $pending }}</h3>
      </div>
      <div class="bg-gradient-to-br from-emerald-500 to-green-600 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm font-medium text-emerald-100 uppercase">Accept</p>
        <h3 id="accept" class="text-4xl font-bold mt-2">{{ $accept }}</h3>
      </div>
      <div class="bg-gradient-to-br from-purple-400 to-pink-500 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm font-medium text-purple-100 uppercase">Disposisi</p>
        <h3 id="disposisi" class="text-4xl font-bold mt-2">{{ $disposisi }}</h3>
      </div>
      <div class="bg-gradient-to-br from-yellow-400 to-orange-500 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm font-medium text-yellow-100 uppercase">Belum Dikerjakan</p>
        <h3 id="belumDikerjakan" class="text-4xl font-bold mt-2">{{ $belum_dikerjakan }}</h3>
      </div>
      <div class="bg-gradient-to-br from-blue-400 to-cyan-500 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm font-medium text-blue-100 uppercase">Sedang Dikerjakan</p>
        <h3 id="sedangDikerjakan" class="text-4xl font-bold mt-2">{{ $sedang_dikerjakan }}</h3>
      </div>
      <div class="bg-gradient-to-br from-cyan-400 to-teal-500 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm font-medium text-cyan-100 uppercase">Telah di Survei</p>
        <h3 id="telahDiSurvei" class="text-4xl font-bold mt-2">{{ $telah_disurvei }}</h3>
      </div>
      <div class="bg-gradient-to-br from-green-400 to-emerald-500 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm font-medium text-green-100 uppercase">Telah Dikerjakan</p>
        <h3 id="telahDikerjakan" class="text-4xl font-bold mt-2">{{ $telah_dikerjakan }}</h3>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <div class="flex items-center gap-3 mb-6">
          <div class="bg-indigo-100 p-2 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 13h4v8H3zm6-8h4v16H9zm6 4h4v12h-4z" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-slate-800">Laporan Masuk</h3>
        </div>
        <div class="flex flex-col md:flex-row items-center md:items-start justify-start gap-6">
          <div class="relative w-full md:w-60 h-60"><canvas id="laporanMasukChart"></canvas></div>
          <div class="flex flex-col gap-3">
            <div class="flex items-center gap-3 text-sm">
              <div class="w-4 h-4 rounded-full" style="background-color:#9ca3af"></div><span
                class="font-medium text-slate-600">Pending</span>
            </div>
            <div class="flex items-center gap-3 text-sm">
              <div class="w-4 h-4 rounded-full" style="background-color:#10b981"></div><span
                class="font-medium text-slate-600">Accept</span>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <div class="flex items-center gap-3 mb-6">
          <div class="bg-indigo-100 p-2 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-3-3v6m-7 3h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-slate-800">Detail Status Laporan Diproses</h3>
        </div>
        <div class="flex flex-col md:flex-row items-center md:items-start justify-start gap-6">
          <div class="relative w-full md:w-60 h-60"><canvas id="laporanChart"></canvas></div>
          <div class="flex flex-col gap-3">
            <div class="flex items-center gap-3 text-sm">
              <div class="w-4 h-4 rounded-full" style="background-color:#f97316"></div><span
                class="font-medium text-slate-600">Belum Dikerjakan</span>
            </div>
            <div class="flex items-center gap-3 text-sm">
              <div class="w-4 h-4 rounded-full" style="background-color:#3b82f6"></div><span
                class="font-medium text-slate-600">Sedang Dikerjakan</span>
            </div>
            <div class="flex items-center gap-3 text-sm">
              <div class="w-4 h-4 rounded-full" style="background-color:#14b8a6"></div><span
                class="font-medium text-slate-600">Telah di Survei</span>
            </div>
            <div class="flex items-center gap-3 text-sm">
              <div class="w-4 h-4 rounded-full" style="background-color:#a855f7"></div><span
                class="font-medium text-slate-600">Disposisi</span>
            </div>
            <div class="flex items-center gap-3 text-sm">
              <div class="w-4 h-4 rounded-full" style="background-color:#22c55e"></div><span
                class="font-medium text-slate-600">Telah Dikerjakan</span>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <div class="flex items-center gap-3 mb-6">
          <div class="bg-indigo-100 p-2 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 14l2-2m0 0l2-2m-2 2l-2 2m2-2l2 2m-7 1h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-slate-800">Jenis Kerusakan Dilaporkan</h3>
        </div>
        <div class="flex flex-col md:flex-row items-center md:items-start justify-start gap-6">
          <div class="relative w-full md:w-60 h-60"><canvas id="jenisKerusakanChart"></canvas></div>
          <div id="jenisKerusakanLegend" class="flex flex-col gap-3"></div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <div class="flex items-center gap-3 mb-6">
          <div class="bg-indigo-100 p-2 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 6l3 3m0 0l3-3m-3 3v12m6-15l3 3m0 0l3-3m-3 3v12" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-slate-800">Tingkat Kerusakan Dilaporkan</h3>
        </div>
        <div class="flex flex-col md:flex-row items-center md:items-start justify-start gap-6">
          <div class="relative w-full md:w-60 h-60"><canvas id="tingkatKerusakanChart"></canvas></div>
          <div id="tingkatKerusakanLegend" class="flex flex-col gap-3"></div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('document.end')
  @vite(['resources/js/chartjs.js', 'resources/js/chartjs-plugin-datalabels.js'])
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Bulan dan tahun dinamis
      const months = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
      ];
      const now = new Date();
      const currentMonth = now.getMonth();
      const currentYear = now.getFullYear();
      const yearSelect = document.getElementById('yearSelect');
      const monthSelect = document.getElementById('monthSelect');
      for (let y = currentYear; y >= currentYear - 5; y--) {
        let opt = document.createElement('option');
        opt.value = y;
        opt.textContent = y;
        yearSelect.appendChild(opt);
      }
      months.forEach((m, i) => {
        let opt = document.createElement('option');
        opt.value = i + 1;
        opt.textContent = m;
        monthSelect.appendChild(opt);
      });
      yearSelect.value = currentYear;
      monthSelect.value = currentMonth + 1;

      // Tailwind active class logic for filter radio
      const filterRadioGroup = document.getElementById('filterRadioGroup');

      function setActiveRadioLabel() {
        filterRadioGroup.querySelectorAll('label').forEach(label => {
          label.classList.remove(
            'bg-indigo-600', 'text-white', 'shadow-md'
          );
          label.classList.add(
            'bg-slate-200', 'text-slate-600'
          );
        });
        const activeLabel = filterRadioGroup.querySelector('input[type=radio]:checked').parentElement;
        activeLabel.classList.remove('bg-slate-200', 'text-slate-600');
        activeLabel.classList.add('bg-indigo-600', 'text-white', 'shadow-md');
      }
      // Initial state
      setActiveRadioLabel();

      // Dropdown show/hide logic
      function updateDropdownVisibility() {
        const filterType = filterRadioGroup.querySelector('input[type=radio]:checked').value;
        const monthSelect = document.getElementById('monthSelect');
        const yearSelect = document.getElementById('yearSelect');
        if (filterType === 'bulan') {
          monthSelect.style.display = '';
          yearSelect.style.display = '';
        } else if (filterType === 'tahun') {
          monthSelect.style.display = 'none';
          yearSelect.style.display = '';
        } else {
          monthSelect.style.display = 'none';
          yearSelect.style.display = 'none';
        }
      }
      updateDropdownVisibility();

      // Listen radio change
      filterRadioGroup.querySelectorAll('label').forEach(label => {
        label.addEventListener('click', function() {
          setTimeout(() => {
            setActiveRadioLabel();
            updateDropdownVisibility();
            triggerFilter();
          }, 10);
        });
      });

      // Listen dropdown change
      document.getElementById('monthSelect').addEventListener('change', triggerFilter);
      document.getElementById('yearSelect').addEventListener('change', triggerFilter);

      // Toggle filter panel
      var btn = document.getElementById('toggleFilterBtn');
      var panel = document.getElementById('filterPanel');
      var labelBtn = document.getElementById('toggleFilterBtnLabel');
      var isOpen = false;
      btn.addEventListener('click', function() {
        isOpen = !isOpen;
        panel.classList.toggle('hidden', !isOpen);
        labelBtn.textContent = isOpen ? 'Sembunyikan Filter' : 'Tampilkan Filter';
      });

      // Initial load
      triggerFilter();

      function triggerFilter() {
        const filterType = filterRadioGroup.querySelector('input[type=radio]:checked').value;
        const month = document.getElementById('monthSelect').value;
        const year = document.getElementById('yearSelect').value;

        // Info periode
        let infoText = '';
        if (filterType === 'bulan') {
          infoText = `Menampilkan data ${months[month - 1]} ${year}`;
        } else if (filterType === 'tahun') {
          infoText = `Menampilkan data tahun ${year}`;
        } else {
          infoText = 'Menampilkan data keseluruhan';
        }
        document.getElementById('periodInfoText').textContent = infoText;

        // AJAX ke backend
        let url = `{{ route('admin.jalan-peduli.statistik-laporan.index') }}?ajax=1&type=${filterType}`;
        if (filterType === 'bulan') {
          url += `&month=${month}&year=${year}`;
        } else if (filterType === 'tahun') {
          url += `&year=${year}`;
        }
        fetch(url)
          .then(res => res.json())
          .then(data => {
            document.getElementById('totalLaporan').textContent = data.total;
            document.getElementById('pending').textContent = data.pending;
            document.getElementById('accept').textContent = data.accept;
            document.getElementById('disposisi').textContent = data.disposisi;
            document.getElementById('belumDikerjakan').textContent = data.belum_dikerjakan;
            document.getElementById('sedangDikerjakan').textContent = data.sedang_dikerjakan;
            document.getElementById('telahDiSurvei').textContent = data.telah_disurvei;
            document.getElementById('telahDikerjakan').textContent = data.telah_dikerjakan;
            updateCharts(data);
          });
      }

      // Chart update logic
      let laporanMasukChart, laporanDetailChart, jenisKerusakanChart, tingkatKerusakanChart;

      function updateCharts(data) {
        // Laporan Masuk
        const laporanMasukData = [data.pending, data.accept];
        if (laporanMasukChart) laporanMasukChart.destroy();
        laporanMasukChart = renderChart('laporanMasukChart', ['Pending', 'Accept'], laporanMasukData, ['#9ca3af',
          '#10b981'
        ]);

        // Detail Status
        const laporanDetailData = [
          data.belum_dikerjakan,
          data.sedang_dikerjakan,
          data.telah_disurvei,
          data.disposisi,
          data.telah_dikerjakan
        ];
        if (laporanDetailChart) laporanDetailChart.destroy();
        laporanDetailChart = renderChart('laporanChart', ['Belum Dikerjakan', 'Sedang Dikerjakan', 'Telah di Survei',
          'Disposisi', 'Telah Dikerjakan'
        ], laporanDetailData, ['#f97316', '#3b82f6', '#14b8a6', '#a855f7', '#22c55e']);

        // Jenis Kerusakan
        const jenisKerusakanLabels = Object.keys(data.jenisKerusakanData);
        const jenisKerusakanDataArr = Object.values(data.jenisKerusakanData);
        const jenisKerusakanColors = ['#FF6384', '#36A2EB', '#FFCE56', '#8B5CF6', '#F59E42', '#10B981', '#F43F5E',
          '#6366F1'
        ];
        if (jenisKerusakanChart) jenisKerusakanChart.destroy();
        jenisKerusakanChart = renderChart('jenisKerusakanChart', jenisKerusakanLabels, jenisKerusakanDataArr,
          jenisKerusakanColors);
        renderLegend('jenisKerusakanLegend', jenisKerusakanLabels, jenisKerusakanColors);

        // Tingkat Kerusakan
        const tingkatKerusakanLabels = Object.keys(data.tingkatKerusakanData);
        const tingkatKerusakanDataArr = Object.values(data.tingkatKerusakanData);
        const tingkatKerusakanColors = ['#f59e0b', '#ef4444', '#84cc16'];
        if (tingkatKerusakanChart) tingkatKerusakanChart.destroy();
        tingkatKerusakanChart = renderChart('tingkatKerusakanChart', tingkatKerusakanLabels, tingkatKerusakanDataArr,
          tingkatKerusakanColors);
        renderLegend('tingkatKerusakanLegend', tingkatKerusakanLabels, tingkatKerusakanColors);
      }

      // Chart rendering functions (same as before)
      function renderChart(canvasId, labels, data, colors) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        return new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: labels,
            datasets: [{
              data: data,
              backgroundColor: colors,
              borderWidth: 2,
              borderColor: '#fff'
            }]
          },
          options: {
            cutout: '65%',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              datalabels: {
                color: '#fff',
                font: {
                  size: 11,
                  weight: 'bold'
                },
                formatter: (value) => value > 0 ? value : ''
              },
              legend: {
                display: false
              }
            }
          },
          plugins: [window.ChartDataLabels]
        });
      }

      function renderLegend(containerId, labels, colors) {
        const legendBox = document.getElementById(containerId);
        legendBox.innerHTML = '';
        labels.forEach((label, idx) => {
          const item = document.createElement('div');
          item.className = 'legend-item flex items-center gap-3 text-sm';
          const colorDiv = document.createElement('div');
          colorDiv.className = 'legend-color w-4 h-4 rounded-full';
          colorDiv.style.backgroundColor = colors[idx % colors.length];
          const span = document.createElement('span');
          span.className = 'font-medium text-slate-600';
          span.textContent = label;
          item.appendChild(colorDiv);
          item.appendChild(span);
          legendBox.appendChild(item);
        });
      }
    });
  </script>
@endsection
