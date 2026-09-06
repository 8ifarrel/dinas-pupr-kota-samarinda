@extends('admin.layout')

@section('document.body')
  @if ($total_responden === 0)
    <div class="bg-white rounded-lg shadow-lg border p-10 text-center">
      <i class="fa-solid fa-face-smile text-gray-300 text-5xl mb-3"></i>
      <p class="text-gray-500">Belum ada responden. Statistik akan tampil setelah ada yang mengisi survei.</p>
    </div>
  @else
    {{-- ===================== KPI ===================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div class="bg-white rounded-lg shadow-lg border p-5">
        <div class="flex items-center justify-between">
          <span class="text-xs text-gray-500">Nilai Rata-rata</span>
          <i class="fa-solid fa-star text-amber-500"></i>
        </div>
        <div class="text-2xl font-bold text-gray-900 mt-2">
          {{ number_format($rata_rata, 2) }}<span class="text-base text-gray-400">/{{ $skala_maksimum }}</span>
        </div>
        <div class="text-xs text-gray-400 mt-1">dari {{ $total_dinilai }} penilaian</div>
      </div>

      <div class="bg-white rounded-lg shadow-lg border p-5">
        <div class="flex items-center justify-between">
          <span class="text-xs text-gray-500">Total Responden</span>
          <i class="fa-solid fa-users text-indigo-500"></i>
        </div>
        <div class="text-2xl font-bold text-gray-900 mt-2">{{ $total_responden }}</div>
        <div class="text-xs text-gray-400 mt-1">{{ $total_masukan }} memberi kritik/saran</div>
      </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-4 mt-6">
      {{-- ===================== Sebaran Penilaian ===================== --}}
      <div class="bg-white rounded-lg shadow-lg border p-6">
        <h3 class="font-semibold text-gray-900 mb-4">Sebaran Penilaian</h3>
        <div class="relative" style="height: 260px">
          <canvas id="chartDistribusiSkm"></canvas>
        </div>
        <div class="mt-4 space-y-1.5">
          @foreach ($distribusi as $d)
            <div class="flex items-center justify-between text-sm">
              <span class="text-gray-600">{{ $d['nilai'] }} - {{ $d['label'] }}</span>
              <span class="text-gray-900 font-medium">{{ $d['jumlah'] }}
                <span class="text-gray-400 font-normal">({{ $d['persen'] }}%)</span>
              </span>
            </div>
          @endforeach
        </div>
      </div>

      {{-- ===================== Tren Penilaian ===================== --}}
      <div class="bg-white rounded-lg shadow-lg border p-6">
        <h3 class="font-semibold text-gray-900 mb-1">Tren Nilai Rata-rata 12 Bulan Terakhir</h3>
        <p class="text-xs text-gray-400 mb-4">Bulan tanpa responden tidak digambar sebagai titik.</p>
        <div class="relative" style="height: 300px">
          <canvas id="chartTrenSkm"></canvas>
        </div>
      </div>
    </div>

    {{-- ===================== Penilaian Terbaru ===================== --}}
    <div class="bg-white rounded-lg shadow-lg border p-6 mt-6">
      <h3 class="font-semibold text-gray-900 mb-4">Penilaian Terbaru</h3>
      @if (empty($masukan))
        <p class="text-sm text-gray-500">Belum ada responden yang mengisi survei.</p>
      @else
        <div class="space-y-3 max-h-[28rem] overflow-y-auto pr-1">
          @foreach ($masukan as $m)
            <div class="border rounded-lg p-4">
              <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-gray-500">
                  {{ $m['waktu'] ? $m['waktu']->translatedFormat('d F Y, H:i') : '-' }} WITA
                </span>
                @if ($m['nilai'])
                  <span class="text-xs text-gray-600">
                    <i class="fa-solid fa-star text-amber-400"></i>
                    {{ $m['nilai'] }} - {{ $m['label_nilai'] }}
                  </span>
                @endif
              </div>
              @if ($m['kritik'])
                <p class="text-sm text-gray-800"><span class="font-bold">Kritik:</span> {{ $m['kritik'] }}</p>
              @endif
              @if ($m['saran'])
                <p class="text-sm text-gray-800 mt-1"><span class="font-bold">Saran:</span> {{ $m['saran'] }}</p>
              @endif
              @if (!$m['kritik'] && !$m['saran'])
                <p class="text-sm text-gray-400 italic">Tidak menuliskan kritik atau saran.</p>
              @endif
            </div>
          @endforeach
        </div>
      @endif
    </div>
  @endif
@endsection

@section('document.end')
  @if ($total_responden > 0)
    @vite('resources/js/chartjs.js')

    <script>
      window.addEventListener('load', function() {
        if (!window.Chart) return;

        var distribusi = @json($distribusi);
        var tren = @json($tren);

        // Merah ke hijau mengikuti urutan nilai 1 sampai 5.
        var warnaNilai = ['#dc2626', '#f59e0b', '#eab308', '#3b82f6', '#059669'];

        new Chart(document.getElementById('chartDistribusiSkm'), {
          type: 'doughnut',
          data: {
            labels: distribusi.map(function(d) {
              return d.nilai + ' - ' + d.label;
            }),
            datasets: [{
              data: distribusi.map(function(d) {
                return d.jumlah;
              }),
              backgroundColor: warnaNilai,
              borderWidth: 0
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '58%',
            plugins: {
              legend: {
                position: 'bottom',
                labels: {
                  boxWidth: 12,
                  font: {
                    size: 11
                  }
                }
              }
            }
          }
        });

        new Chart(document.getElementById('chartTrenSkm'), {
          type: 'line',
          data: {
            labels: tren.map(function(t) {
              return t.label;
            }),
            datasets: [{
              label: 'Nilai rata-rata',
              data: tren.map(function(t) {
                return t.rata_rata;
              }),
              borderColor: '#223468',
              backgroundColor: 'rgba(34, 52, 104, 0.08)',
              borderWidth: 2,
              fill: true,
              tension: 0.3,
              spanGaps: true,
              pointRadius: 4,
              pointBackgroundColor: '#223468'
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              y: {
                suggestedMin: 1,
                suggestedMax: 5,
                title: {
                  display: true,
                  text: 'Nilai rata-rata (1 - 5)'
                }
              }
            },
            plugins: {
              legend: {
                display: false
              },
              tooltip: {
                callbacks: {
                  label: function(ctx) {
                    var titik = tren[ctx.dataIndex];
                    if (titik.rata_rata === null) return 'Belum ada responden';
                    return 'Rata-rata ' + titik.rata_rata + ' (' + titik.jumlah + ' responden)';
                  }
                }
              }
            }
          }
        });
      });
    </script>
  @endif
@endsection
