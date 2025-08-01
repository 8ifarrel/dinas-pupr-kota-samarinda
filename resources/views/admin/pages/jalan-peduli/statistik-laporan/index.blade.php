@extends('admin.layout')

@section('document.head')
  {{-- TODO: Tambahkan asset jika perlu --}}
@endsection

@section('document.body')
  {{-- Filter dummy --}}
  <div class="sticky top-[80px] z-30 w-full">
    <div class="container mx-auto py-4">
      <div class="backdrop-blur-sm rounded-xl">
        <div class="flex justify-between items-center bg-white p-3 rounded-xl shadow-lg border ">
          <div class="flex items-center gap-2 flex-wrap">
            <button
              id="toggleFilterBtn"
              type="button"
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
            <div class="flex items-center p-1 bg-slate-200 rounded-full w-full lg:w-auto">
              <label
                class="flex-1 text-center px-4 py-1.5 text-sm font-semibold text-slate-600 rounded-full cursor-pointer transition-colors duration-300">
                <input type="radio" name="filter" value="bulan" class="sr-only" checked><span>Bulan</span>
              </label>
              <label
                class="flex-1 text-center px-4 py-1.5 text-sm font-semibold text-slate-600 rounded-full cursor-pointer transition-colors duration-300">
                <input type="radio" name="filter" value="tahun" class="sr-only"><span>Tahun</span>
              </label>
              <label
                class="flex-1 text-center px-4 py-1.5 text-sm font-semibold text-slate-600 rounded-full cursor-pointer transition-colors duration-300">
                <input type="radio" name="filter" value="keseluruhan" class="sr-only"><span>Total</span>
              </label>
            </div>
            <div class="flex items-center gap-2 w-full lg:w-auto">
              <select
                class="w-full sm:w-auto bg-white border border-slate-300 rounded-md py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                <option>Januari</option>
                <option>Februari</option>
                <option>Maret</option>
                {{-- TODO: Isi bulan dari backend --}}
              </select>
              <select
                class="w-full sm:w-auto bg-white border border-slate-300 rounded-md py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                <option>2024</option>
                <option>2023</option>
                {{-- TODO: Isi tahun dari backend --}}
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Konten utama --}}
  <div class="container mx-auto py-4 sm:py-6 lg:py-8">
    <div class="mb-8 flex items-center">
      <div class="flex items-center gap-2 bg-indigo-600 px-4 py-2 rounded-lg shadow text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-80" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 7V3m8 4V3m-9 8h10m-12 8a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span class="text-base font-medium">Menampilkan data Januari 2024</span>
        {{-- TODO: Ganti dengan info periode terpilih --}}
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm font-medium text-indigo-200 uppercase">Total Laporan</p>
        <h2 class="text-4xl font-bold mt-2">123</h2>
        {{-- TODO: Ganti dengan total laporan --}}
      </div>
      <div class="bg-gradient-to-br from-gray-400 to-slate-500 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm font-medium text-gray-200 uppercase">Pending</p>
        <h3 class="text-4xl font-bold mt-2">12</h3>
        {{-- TODO: Ganti dengan jumlah pending --}}
      </div>
      <div class="bg-gradient-to-br from-emerald-500 to-green-600 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm font-medium text-emerald-100 uppercase">Accept</p>
        <h3 class="text-4xl font-bold mt-2">101</h3>
        {{-- TODO: Ganti dengan jumlah accept --}}
      </div>
      <div class="bg-gradient-to-br from-purple-400 to-pink-500 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm font-medium text-purple-100 uppercase">Disposisi</p>
        <h3 class="text-4xl font-bold mt-2">5</h3>
        {{-- TODO: Ganti dengan jumlah disposisi --}}
      </div>
      <div class="bg-gradient-to-br from-yellow-400 to-orange-500 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm font-medium text-yellow-100 uppercase">Belum Dikerjakan</p>
        <h3 class="text-4xl font-bold mt-2">3</h3>
        {{-- TODO: Ganti dengan jumlah belum dikerjakan --}}
      </div>
      <div class="bg-gradient-to-br from-blue-400 to-cyan-500 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm font-medium text-blue-100 uppercase">Sedang Dikerjakan</p>
        <h3 class="text-4xl font-bold mt-2">7</h3>
        {{-- TODO: Ganti dengan jumlah sedang dikerjakan --}}
      </div>
      <div class="bg-gradient-to-br from-cyan-400 to-teal-500 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm font-medium text-cyan-100 uppercase">Telah di Survei</p>
        <h3 class="text-4xl font-bold mt-2">8</h3>
        {{-- TODO: Ganti dengan jumlah telah di survei --}}
      </div>
      <div class="bg-gradient-to-br from-green-400 to-emerald-500 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm font-medium text-green-100 uppercase">Telah Dikerjakan</p>
        <h3 class="text-4xl font-bold mt-2">78</h3>
        {{-- TODO: Ganti dengan jumlah telah dikerjakan --}}
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
        <div class="flex flex-col md:flex-row items-center justify-center gap-6">
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
        <div class="flex flex-col md:flex-row items-center justify-center gap-6">
          <div class="relative w-full md:w-60 h-60"><canvas id="laporanChart"></canvas></div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3">
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
            <div class="flex items-center gap-3 text-sm col-span-full">
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
        <div class="flex flex-col md:flex-row items-center justify-center gap-6">
          <div class="relative w-full md:w-60 h-60"><canvas id="jenisKerusakanChart"></canvas></div>
          <div id="jenisKerusakanLegend" class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3"></div>
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
        <div class="flex flex-col md:flex-row items-center justify-center gap-6">
          <div class="relative w-full md:w-60 h-60"><canvas id="tingkatKerusakanChart"></canvas></div>
          <div id="tingkatKerusakanLegend" class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3"></div>
        </div>
      </div>
    </div>
  </div>
  {{-- TODO: Ganti semua data dummy di atas dengan data dari backend --}}
@endsection

@section('document.end')
  {{-- Dummy ChartJS --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
  <script>
    // Dummy data
    const laporanMasukData = [12, 101];
    const laporanDetailData = [3, 7, 8, 5, 78];
    const jenisKerusakanLabels = ['Berlubang', 'Retak', 'Amblas'];
    const jenisKerusakanData = [60, 40, 23];
    const jenisKerusakanColors = ['#FF6384', '#36A2EB', '#FFCE56'];
    const tingkatKerusakanLabels = ['Ringan', 'Sedang', 'Berat'];
    const tingkatKerusakanData = [80, 30, 13];
    const tingkatKerusakanColors = ['#f59e0b', '#ef4444', '#84cc16'];

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
        plugins: [ChartDataLabels]
      });
    }

    function renderLegend(containerId, labels, colors) {
      const legendBox = document.getElementById(containerId);
      legendBox.innerHTML = '';
      labels.forEach((label, idx) => {
        const item = document.createElement('div');
        item.className = 'flex items-center gap-3 text-sm';
        const colorDiv = document.createElement('div');
        colorDiv.className = 'w-4 h-4 rounded-full';
        colorDiv.style.backgroundColor = colors[idx % colors.length];
        const span = document.createElement('span');
        span.className = 'font-medium text-slate-600';
        span.textContent = label;
        item.appendChild(colorDiv);
        item.appendChild(span);
        legendBox.appendChild(item);
      });
    }

    document.addEventListener('DOMContentLoaded', function() {
      renderChart('laporanMasukChart', ['Pending', 'Accept'], laporanMasukData, ['#9ca3af', '#10b981']);
      renderChart('laporanChart', ['Belum Dikerjakan', 'Sedang Dikerjakan', 'Telah di Survei', 'Disposisi',
        'Telah Dikerjakan'
      ], laporanDetailData, ['#f97316', '#3b82f6', '#14b8a6', '#a855f7', '#22c55e']);
      renderChart('jenisKerusakanChart', jenisKerusakanLabels, jenisKerusakanData, jenisKerusakanColors);
      renderLegend('jenisKerusakanLegend', jenisKerusakanLabels, jenisKerusakanColors);
      renderChart('tingkatKerusakanChart', tingkatKerusakanLabels, tingkatKerusakanData, tingkatKerusakanColors);
      renderLegend('tingkatKerusakanLegend', tingkatKerusakanLabels, tingkatKerusakanColors);
      // TODO: Ganti data chart dengan data dari backend
    });

    // Toggle filter panel logic
    document.addEventListener('DOMContentLoaded', function() {
      var btn = document.getElementById('toggleFilterBtn');
      var panel = document.getElementById('filterPanel');
      var label = document.getElementById('toggleFilterBtnLabel');
      var isOpen = false;
      btn.addEventListener('click', function() {
        isOpen = !isOpen;
        panel.classList.toggle('hidden', !isOpen);
        label.textContent = isOpen ? 'Sembunyikan Filter' : 'Tampilkan Filter';
      });
    });
  </script>
@endsection
