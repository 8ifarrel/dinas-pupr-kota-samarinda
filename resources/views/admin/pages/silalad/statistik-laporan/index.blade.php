@extends('admin.layout')

@section('document.body')
{{--
  Statistik pesanan SILALAD. Butuh variabel yang disiapkan controller
  (lihat method compute() di controller ini).
--}}
@if ($total === 0)
  <div class="bg-white rounded-lg shadow-lg border p-10 text-center">
    <i class="fa-solid fa-chart-pie text-gray-300 text-5xl mb-3"></i>
    <p class="text-gray-500">Belum ada pesanan yang masuk. Statistik akan tampil setelah ada data.</p>
  </div>
@else
  {{-- ===================== KPI ===================== --}}
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-lg shadow-lg border p-5">
      <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">Total Pesanan</span>
        <i class="fa-solid fa-file-lines text-blue-500"></i>
      </div>
      <div class="text-2xl font-bold text-gray-900 mt-2">{{ $total }}</div>
      <div class="text-xs text-gray-400 mt-1">{{ $dibatalkan }} dibatalkan</div>
    </div>
    <div class="bg-white rounded-lg shadow-lg border p-5">
      <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">Sedang Dikerjakan</span>
        <i class="fa-solid fa-spinner text-indigo-500"></i>
      </div>
      <div class="text-2xl font-bold text-gray-900 mt-2">{{ $total_berjalan }}</div>
    </div>
    <div class="bg-white rounded-lg shadow-lg border p-5">
      <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">Sudah Dikerjakan</span>
        <i class="fa-solid fa-circle-check text-green-500"></i>
      </div>
      <div class="text-2xl font-bold text-gray-900 mt-2">{{ $total_selesai }}</div>
      <div class="text-xs text-gray-400 mt-1">{{ round($total_selesai / $total * 100) }}% dari total</div>
    </div>
    <div class="bg-white rounded-lg shadow-lg border p-5">
      <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">Belum Dikerjakan</span>
        <i class="fa-solid fa-clock text-yellow-500"></i>
      </div>
      <div class="text-2xl font-bold text-gray-900 mt-2">{{ $belum_diproses }}</div>
    </div>
  </div>

  @php
    $selectCls = 'text-sm border border-gray-300 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-200';
  @endphp

  {{-- ===================== Pesanan Masuk (bar, kuartal + tahun) ===================== --}}
  <div class="bg-white rounded-lg shadow-lg border p-6 mt-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
      <div>
        <h3 class="font-semibold text-gray-900">Pesanan Masuk</h3>
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

  {{-- ===================== Status & Jenis Bangunan (doughnut, bulan + tahun) ===================== --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <div class="bg-white rounded-lg shadow-lg border p-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
        <div>
          <h3 class="font-semibold text-gray-900">Status Pesanan</h3>
        </div>
        <div class="flex gap-2">
          <select id="statusMonth" class="{{ $selectCls }}"></select>
          <select id="statusYear" class="{{ $selectCls }}">
            @foreach ($years as $y)
              <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="relative h-72">
        <canvas id="chartStatus"></canvas>
        <div id="nodataStatus"
          class="absolute inset-0 hidden items-center justify-center text-gray-400 text-sm bg-white">
          Tidak ada data pada periode ini
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg border p-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
        <div>
          <h3 class="font-semibold text-gray-900">Jenis Bangunan</h3>
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

  {{-- ===================== Kabupaten/Kota (bar, bulan + tahun) ===================== --}}
  <div class="bg-white rounded-lg shadow-lg border p-6 mt-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
      <div>
        <h3 class="font-semibold text-gray-900">Sebaran Pesanan per Kabupaten/Kota</h3>
      </div>
      <div class="flex gap-2">
        <select id="kabkotaMonth" class="{{ $selectCls }}"></select>
        <select id="kabkotaYear" class="{{ $selectCls }}">
          @foreach ($years as $y)
            <option value="{{ $y }}">{{ $y }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="relative" style="height: {{ max(288, $kabkota_list->count() * 34) }}px">
      <canvas id="chartKabkota"></canvas>
      <div id="nodataKabkota"
        class="absolute inset-0 hidden items-center justify-center text-gray-400 text-sm bg-white">
        Tidak ada data pada periode ini
      </div>
    </div>
  </div>

  {{-- ===================== Sebaran per Kecamatan (bar, kabkota + bulan + tahun) ===================== --}}
  <div class="bg-white rounded-lg shadow-lg border p-6 mt-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
      <div>
        <h3 class="font-semibold text-gray-900">Sebaran Pesanan per Kecamatan</h3>
      </div>
      <div class="flex flex-wrap gap-2">
        <select id="kecKabkota" class="{{ $selectCls }}">
          @foreach ($kecamatan_map as $namaKabkota => $daftarKec)
            <option value="{{ $namaKabkota }}">{{ $namaKabkota }}</option>
          @endforeach
        </select>
        <select id="kecMonth" class="{{ $selectCls }}"></select>
        <select id="kecYear" class="{{ $selectCls }}">
          @foreach ($years as $y)
            <option value="{{ $y }}">{{ $y }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="relative" id="kecChartWrap" style="height: 288px">
      <canvas id="chartKecamatan"></canvas>
      <div id="nodataKec"
        class="absolute inset-0 hidden items-center justify-center text-gray-400 text-sm bg-white">
        Tidak ada data pada periode ini
      </div>
    </div>
  </div>
@endif
@endsection

@section('document.end')
  @if ($total > 0)
    @vite('resources/js/chartjs.js')

    <script>
      window.addEventListener('load', function() {
        if (!window.Chart) return;

        Chart.defaults.font.family = getComputedStyle(document.body).fontFamily;
        Chart.defaults.color = '#6b7280';

        var byYM = @json($by_ym);
        var kabkotaList = @json($kabkota_list);
        var jenisBangunanList = @json($jenis_bangunan_list);
        var kecamatanMap = @json($kecamatan_map);
        var nowYear = {{ $now_year }},
          nowMonth = {{ $now_month }},
          nowQuarter = {{ $now_quarter }};

        var bulanNama = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
          'Oktober', 'November', 'Desember'
        ];

        var statusKeys = ['Belum dikerjakan', 'Sedang dikerjakan', 'Sudah dikerjakan', 'Dibatalkan'];
        var statusLabel = ['Belum Dikerjakan', 'Sedang Dikerjakan', 'Sudah Dikerjakan', 'Dibatalkan'];
        var statusColor = ['#eab308', '#3b82f6', '#22c55e', '#ef4444'];

        // Warna jenis bangunan: sebanyak entri dinamis + satu warna abu-abu untuk "Lainnya" di posisi terakhir.
        var jenisPalette = ['#3b82f6', '#14b8a6', '#f97316', '#a855f7', '#ec4899', '#9ca3af'];

        function cell(y, m) {
          return (byYM[y] && byYM[y][m]) || {
            masuk: 0,
            status: {},
            jenis_bangunan: {},
            kabkota: {},
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
        ['statusMonth', 'jenisMonth', 'kabkotaMonth', 'kecMonth'].forEach(function(id) {
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
        ['statusMonth', 'jenisMonth', 'kabkotaMonth', 'kecMonth'].forEach(function(id) {
          document.getElementById(id).value = nowMonth;
        });
        ['statusYear', 'jenisYear', 'kabkotaYear', 'kecYear'].forEach(function(id) {
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

        // ---------- Pesanan Masuk ----------
        var chartMasuk = new Chart(document.getElementById('chartMasuk'), {
          type: 'bar',
          data: {
            labels: [],
            datasets: statusKeys.map(function(key, i) {
              return {
                label: statusLabel[i],
                data: [],
                backgroundColor: statusColor[i],
                borderRadius: 4
              };
            })
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

          var perStatus = statusKeys.map(function() {
            return [];
          });
          months.forEach(function(m) {
            var st = cell(y, m).status;
            statusKeys.forEach(function(key, i) {
              perStatus[i].push(num(st, key));
            });
          });

          chartMasuk.data.labels = months.map(function(m) {
            return bulanNama[m - 1];
          });
          statusKeys.forEach(function(key, i) {
            chartMasuk.data.datasets[i].data = perStatus[i];
          });
          chartMasuk.update();

          var totalP = perStatus.reduce(function(a, arr) {
            return a + sum(arr);
          }, 0);
          toggleNoData('nodataMasuk', totalP === 0);
        }

        // ---------- Status Pesanan ----------
        var chartStatus = new Chart(document.getElementById('chartStatus'), {
          type: 'doughnut',
          data: {
            labels: statusLabel,
            datasets: [{
              data: [],
              backgroundColor: statusColor
            }]
          },
          options: doughnutOpts
        });

        function renderStatus() {
          var m = parseInt(document.getElementById('statusMonth').value, 10);
          var y = parseInt(document.getElementById('statusYear').value, 10);
          var st = cell(y, m).status;
          var data = statusKeys.map(function(k) {
            return num(st, k);
          });
          chartStatus.data.datasets[0].data = data;
          chartStatus.update();
          toggleNoData('nodataStatus', sum(data) === 0);
        }

        // ---------- Jenis Bangunan ----------
        var chartJenis = new Chart(document.getElementById('chartJenis'), {
          type: 'doughnut',
          data: {
            labels: jenisBangunanList,
            datasets: [{
              data: [],
              backgroundColor: jenisBangunanList.map(function(_, i) {
                return jenisPalette[i % jenisPalette.length];
              })
            }]
          },
          options: doughnutOpts
        });

        function renderJenis() {
          var m = parseInt(document.getElementById('jenisMonth').value, 10);
          var y = parseInt(document.getElementById('jenisYear').value, 10);
          var jn = cell(y, m).jenis_bangunan;
          var data = jenisBangunanList.map(function(k) {
            return num(jn, k);
          });
          chartJenis.data.datasets[0].data = data;
          chartJenis.update();
          toggleNoData('nodataJenis', sum(data) === 0);
        }

        // ---------- Kabupaten/Kota ----------
        var chartKabkota = new Chart(document.getElementById('chartKabkota'), {
          type: 'bar',
          data: {
            labels: kabkotaList,
            datasets: [{
              label: 'Jumlah pesanan',
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

        function renderKabkota() {
          var m = parseInt(document.getElementById('kabkotaMonth').value, 10);
          var y = parseInt(document.getElementById('kabkotaYear').value, 10);
          var kb = cell(y, m).kabkota;
          var data = kabkotaList.map(function(nama) {
            return num(kb, nama);
          });
          chartKabkota.data.datasets[0].data = data;
          chartKabkota.update();
          toggleNoData('nodataKabkota', sum(data) === 0);
        }

        // ---------- Kecamatan ----------
        var chartKec = new Chart(document.getElementById('chartKecamatan'), {
          type: 'bar',
          data: {
            labels: [],
            datasets: [{
              label: 'Jumlah pesanan',
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
          var kabkota = document.getElementById('kecKabkota').value;
          var m = parseInt(document.getElementById('kecMonth').value, 10);
          var y = parseInt(document.getElementById('kecYear').value, 10);
          var daftar = kecamatanMap[kabkota] || [];
          var perKabkota = (cell(y, m).kecamatan || {})[kabkota] || {};
          var data = daftar.map(function(nm) {
            return perKabkota[nm] || 0;
          });

          document.getElementById('kecChartWrap').style.height = Math.max(288, daftar.length * 34) + 'px';
          chartKec.data.labels = daftar;
          chartKec.data.datasets[0].data = data;
          chartKec.update();
          toggleNoData('nodataKec', sum(data) === 0);
        }

        // Listeners
        document.getElementById('masukQuarter').addEventListener('change', renderMasuk);
        document.getElementById('masukYear').addEventListener('change', renderMasuk);
        document.getElementById('statusMonth').addEventListener('change', renderStatus);
        document.getElementById('statusYear').addEventListener('change', renderStatus);
        document.getElementById('jenisMonth').addEventListener('change', renderJenis);
        document.getElementById('jenisYear').addEventListener('change', renderJenis);
        document.getElementById('kabkotaMonth').addEventListener('change', renderKabkota);
        document.getElementById('kabkotaYear').addEventListener('change', renderKabkota);
        ['kecKabkota', 'kecMonth', 'kecYear'].forEach(function(id) {
          document.getElementById(id).addEventListener('change', renderKec);
        });

        renderMasuk();
        renderStatus();
        renderJenis();
        renderKabkota();
        renderKec();
      });
    </script>
  @endif
@endsection
