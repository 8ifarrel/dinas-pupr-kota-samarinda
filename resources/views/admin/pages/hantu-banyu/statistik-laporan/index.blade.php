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
  {{--
    Grafik statistik dirender oleh resources/js/hantu-banyu/statistik-chart.js
    (dipakai bersama dengan beranda statistik guest) - lihat berkas itu untuk
    logikanya. Datanya dioper lewat atribut data-* di bawah supaya skrip itu
    tidak perlu tahu apa pun tentang controller/halaman ini.
  --}}
  @if ($total > 0)
    @vite(['resources/js/chartjs.js', 'resources/js/hantu-banyu/statistik-chart.js'])
    <div id="statistik-hantu-banyu-data" class="hidden"
      data-by-ym="{{ json_encode($by_ym) }}"
      data-kecamatan-list="{{ json_encode($kecamatan_list) }}"
      data-kelurahan-map="{{ json_encode($kelurahan_map) }}"
      data-now-year="{{ $now_year }}"
      data-now-month="{{ $now_month }}"
      data-now-quarter="{{ $now_quarter }}"
    ></div>
  @endif
@endsection
