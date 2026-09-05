@extends('admin.layout')

@section('document.body')
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

  @if ($total > 0)
    @php
      $selectCls = 'text-sm border border-gray-300 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-200';
    @endphp
    {{-- ===================== Sebaran per Kelurahan (bar, kecamatan + bulan + tahun) ===================== --}}
    <div class="bg-white rounded-lg shadow-lg border p-6 mt-6">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
        <div>
          <h3 class="font-semibold text-  gray-900">Sebaran Laporan per Kelurahan</h3>
        </div>
        <div class="flex flex-wrap gap-2">
          <select id="kelKecamatan" class="{{ $selectCls }}">
            @foreach ($kelurahan_map as $namaKec => $daftarKel)
              <option value="{{ $namaKec }}">{{ $namaKec }}</option>
            @endforeach
          </select>
          <select id="kelMonth" class="{{ $selectCls }}"></select>
          <select id="kelYear" class="{{ $selectCls }}">
            @foreach ($years as $y)
              <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="relative" id="kelChartWrap" style="height: 288px">
        <canvas id="chartKelurahan"></canvas>
        <div id="nodataKel"
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

  @if ($total > 0)
    <script>
      window.addEventListener('load', function() {
        if (!window.Chart) return;

        var byYM = @json($by_ym);
        var kelMap = @json($kelurahan_map);
        var nowYear = {{ $now_year }},
          nowMonth = {{ $now_month }};
        var bulanNama = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
          'Oktober', 'November', 'Desember'
        ];

        var monthSel = document.getElementById('kelMonth');
        bulanNama.forEach(function(nama, i) {
          var opt = document.createElement('option');
          opt.value = i + 1;
          opt.textContent = nama;
          monthSel.appendChild(opt);
        });
        monthSel.value = nowMonth;
        document.getElementById('kelYear').value = nowYear;

        function kelCell(y, m) {
          return (byYM[y] && byYM[y][m] && byYM[y][m].kelurahan) || {};
        }

        function sum(arr) {
          return arr.reduce(function(a, b) {
            return a + b;
          }, 0);
        }

        var chartKel = new Chart(document.getElementById('chartKelurahan'), {
          type: 'bar',
          data: {
            labels: [],
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

        function renderKel() {
          var kec = document.getElementById('kelKecamatan').value;
          var m = parseInt(document.getElementById('kelMonth').value, 10);
          var y = parseInt(document.getElementById('kelYear').value, 10);
          var daftar = kelMap[kec] || [];
          var perKec = kelCell(y, m)[kec] || {};
          var data = daftar.map(function(nm) {
            return perKec[nm] || 0;
          });

          document.getElementById('kelChartWrap').style.height = Math.max(288, daftar.length * 34) + 'px';
          chartKel.data.labels = daftar;
          chartKel.data.datasets[0].data = data;
          chartKel.update();

          document.getElementById('nodataKel').style.display = sum(data) === 0 ? 'flex' : 'none';
        }

        ['kelKecamatan', 'kelMonth', 'kelYear'].forEach(function(id) {
          document.getElementById(id).addEventListener('change', renderKel);
        });

        renderKel();
      });
    </script>
  @endif
@endsection
