@extends('admin.layout')

@section('document.body')
  @include('partials.hantu-banyu-statistik')

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
  @include('partials.hantu-banyu-statistik-js')

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
