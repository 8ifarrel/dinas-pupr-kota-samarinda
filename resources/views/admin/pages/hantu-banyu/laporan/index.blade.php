@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@php
  $statusLabels = [
      'pending' => 'Menunggu Verifikasi',
      'diterima' => 'Diterima',
      'menunggu_survei' => 'Menunggu Survei',
      'sudah_disurvei' => 'Sudah Disurvei',
      'menunggu_jadwal_pengerjaan' => 'Menunggu Jadwal Pengerjaan',
      'sedang_dikerjakan' => 'Sedang Dikerjakan',
      'selesai' => 'Selesai',
  ];
  $statusBadge = [
      'pending' => 'bg-yellow-100 text-yellow-800',
      'diterima' => 'bg-blue-100 text-blue-800',
      'menunggu_survei' => 'bg-pink-100 text-pink-800',
      'sudah_disurvei' => 'bg-purple-100 text-purple-800',
      'menunggu_jadwal_pengerjaan' => 'bg-orange-100 text-orange-800',
      'sedang_dikerjakan' => 'bg-indigo-100 text-indigo-800',
      'selesai' => 'bg-green-100 text-green-800',
  ];
  $jenisLabels = [
      'belum_diklasifikasikan' => 'Belum Diklasifikasikan',
      'darurat' => 'Penanganan Darurat',
      'biasa' => 'Penanganan Biasa',
      'rutin' => 'Pemeliharaan Rutin',
  ];
  $jenisBadge = [
      'belum_diklasifikasikan' => 'bg-gray-100 text-gray-800',
      'darurat' => 'bg-red-100 text-red-800',
      'biasa' => 'bg-teal-100 text-teal-800',
      'rutin' => 'bg-blue-100 text-blue-800',
  ];
@endphp

@section('document.body')
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="flex justify-end mb-4">
      <button type="button" id="btnUnduhPdf"
        class="inline-flex items-center gap-2 h-10 px-4 text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 rounded-lg text-sm font-medium focus:outline-none">
        <i class="fa-solid fa-file-pdf"></i>
        <span class="whitespace-nowrap">Unduh PDF Laporan</span>
      </button>
    </div>

    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="laporan" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>No.</th>
            <th>Pelapor</th>
            <th>Lokasi</th>
            <th>Waktu Masuk</th>
            <th>Status Terkini</th>
            <th>Jenis</th>
            <th>Kelola</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($laporan as $item)
            @php
              $status = $item->status_terkini;
              $jenis = $item->jenis_laporan;
            @endphp
            <tr>
              <td>{{ $item->id }}</td>
              <td>{{ $item->pelapor->nama_lengkap ?? '-' }}</td>
              <td>
                <div class="font-medium text-gray-900">{{ $item->nama_jalan }}</div>
                <div class="text-xs text-gray-500">
                  {{ $item->kelurahan->nama ?? '-' }}, {{ $item->kecamatan->nama ?? '-' }}
                </div>
              </td>
              <td data-order="{{ $item->created_at->timestamp }}">
                {{ $item->created_at->translatedFormat('d M Y') }}<br>
                <span class="text-xs text-gray-500">{{ $item->created_at->translatedFormat('H.i') }} WITA</span>
              </td>
              <td>
                @if ($status)
                  <span class="inline-flex items-center whitespace-nowrap px-2.5 py-1 rounded-full text-xs font-medium {{ $statusBadge[$status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $statusLabels[$status] ?? ucwords(str_replace('_', ' ', $status)) }}
                  </span>
                @else
                  <span class="text-xs text-gray-400">Belum ada</span>
                @endif
              </td>
              <td>
                <span class="inline-flex items-center whitespace-nowrap px-2.5 py-1 rounded-full text-xs font-medium {{ $jenisBadge[$jenis] ?? 'bg-gray-100 text-gray-800' }}">
                  {{ $jenisLabels[$jenis] ?? ucwords(str_replace('_', ' ', $jenis)) }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.hantu-banyu.laporan.detail', $item->id) }}" class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-pencil"></i>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>No.</th>
            <th>Pelapor</th>
            <th>Lokasi</th>
            <th>Waktu Masuk</th>
            <th>Status Terkini</th>
            <th>Jenis</th>
            <th>Kelola</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  {{-- Modal: Unduh PDF Laporan --}}
  @php
    $bulanNama = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];
    $selCls = 'border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5';
  @endphp
  <div id="modalUnduhPdf" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg max-h-full overflow-y-auto">
      <div class="flex items-center justify-between p-4 border-b">
        <h3 class="text-lg font-semibold text-gray-900">
          <i class="fa-solid fa-file-pdf text-red-600 mr-1"></i> Unduh PDF Laporan
        </h3>
        <button type="button" data-tutup-modal
          class="text-gray-400 hover:bg-gray-100 hover:text-gray-900 rounded-lg p-1.5 inline-flex items-center">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <form method="GET" action="{{ route('admin.hantu-banyu.laporan.unduh-pdf') }}" class="p-4 space-y-4">
        <p class="text-sm text-gray-600">
          Setiap laporan dicetak pada satu halaman A4 dan digabung menjadi satu berkas PDF. PDF ini menyertakan
          riwayat tindak lanjut.
        </p>

        <div class="space-y-2">
          <label class="flex items-start gap-2 text-sm">
            <input type="radio" name="mode" value="semua" class="mt-1" checked>
            <span><span class="font-medium">Semua laporan</span></span>
          </label>
          <label class="flex items-start gap-2 text-sm">
            <input type="radio" name="mode" value="rentang" class="mt-1">
            <span><span class="font-medium">Rentang bulan &amp; tahun</span></span>
          </label>
          <label class="flex items-start gap-2 text-sm">
            <input type="radio" name="mode" value="tahun" class="mt-1">
            <span><span class="font-medium">Satu tahun</span></span>
          </label>
          <label class="flex items-start gap-2 text-sm">
            <input type="radio" name="mode" value="bulan" class="mt-1">
            <span><span class="font-medium">Satu bulan tertentu</span></span>
          </label>
        </div>

        <div id="grp-rentang" class="hidden rounded-lg border border-gray-200 p-3 space-y-3">
          <div>
            <p class="text-xs font-semibold text-gray-500 mb-1">Dari</p>
            <div class="flex gap-2">
              <select name="dari_bulan" class="{{ $selCls }}" disabled>
                @foreach ($bulanNama as $n => $nm)
                  <option value="{{ $n }}">{{ $nm }}</option>
                @endforeach
              </select>
              <select name="dari_tahun" class="{{ $selCls }}" disabled>
                @foreach ($tahun_opsi as $y)
                  <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div>
            <p class="text-xs font-semibold text-gray-500 mb-1">Sampai</p>
            <div class="flex gap-2">
              <select name="sampai_bulan" class="{{ $selCls }}" disabled>
                @foreach ($bulanNama as $n => $nm)
                  <option value="{{ $n }}">{{ $nm }}</option>
                @endforeach
              </select>
              <select name="sampai_tahun" class="{{ $selCls }}" disabled>
                @foreach ($tahun_opsi as $y)
                  <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div id="grp-tahun" class="hidden rounded-lg border border-gray-200 p-3">
          <p class="text-xs font-semibold text-gray-500 mb-1">Tahun</p>
          <select name="tahun" class="{{ $selCls }}" disabled>
            @foreach ($tahun_opsi as $y)
              <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
          </select>
        </div>

        <div id="grp-bulan" class="hidden rounded-lg border border-gray-200 p-3">
          <p class="text-xs font-semibold text-gray-500 mb-1">Bulan &amp; tahun</p>
          <div class="flex gap-2">
            <select name="bulan" class="{{ $selCls }}" disabled>
              @foreach ($bulanNama as $n => $nm)
                <option value="{{ $n }}">{{ $nm }}</option>
              @endforeach
            </select>
            <select name="bulan_tahun" class="{{ $selCls }}" disabled>
              @foreach ($tahun_opsi as $y)
                <option value="{{ $y }}">{{ $y }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="flex justify-end gap-2 pt-2 border-t">
          <button type="button" data-tutup-modal
            class="px-4 py-2 text-sm rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">Batal</button>
          <button type="submit"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm rounded-lg bg-red-600 text-white hover:bg-red-700">
            <i class="fa-solid fa-download"></i> Unduh
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('document.end')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('#laporan').DataTable({
        order: [[3, 'desc']],
        columnDefs: [{
          orderable: false,
          targets: [6]
        }]
      });

      // --- Modal Unduh PDF Laporan ---
      const modal = document.getElementById('modalUnduhPdf');
      const openBtn = document.getElementById('btnUnduhPdf');
      const groups = {
        rentang: document.getElementById('grp-rentang'),
        tahun: document.getElementById('grp-tahun'),
        bulan: document.getElementById('grp-bulan'),
      };

      function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      }

      function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
      }

      function syncGroups() {
        const mode = modal.querySelector('input[name="mode"]:checked')?.value || 'semua';
        Object.entries(groups).forEach(([key, el]) => {
          const aktif = key === mode;
          el.classList.toggle('hidden', !aktif);
          // Nonaktifkan input pada grup tersembunyi agar tidak ikut terkirim.
          el.querySelectorAll('select').forEach(s => {
            s.disabled = !aktif;
          });
        });
      }

      if (openBtn) openBtn.addEventListener('click', openModal);
      modal.querySelectorAll('[data-tutup-modal]').forEach(b => b.addEventListener('click', closeModal));
      modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
      });
      modal.querySelectorAll('input[name="mode"]').forEach(r => r.addEventListener('change', syncGroups));
      syncGroups();
    });
  </script>
@endsection
