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
    {{-- Zona unduh rekap, dipisah dari penyaring tabel di bawahnya karena
         periode berkasnya dipilih sendiri di dalam modal. --}}
    <div class="flex flex-wrap gap-2 pb-4 mb-4 border-b border-gray-200">
      <button type="button" id="btnUnduhExcel"
        class="inline-flex items-center gap-2 h-10 px-4 text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm font-medium focus:outline-none">
        <i class="fa-solid fa-file-excel"></i>
        <span class="whitespace-nowrap">Unduh Excel</span>
      </button>
      <button type="button" id="btnUnduhPdf"
        class="inline-flex items-center gap-2 h-10 px-4 text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 rounded-lg text-sm font-medium focus:outline-none">
        <i class="fa-solid fa-file-pdf"></i>
        <span class="whitespace-nowrap">Unduh PDF Laporan</span>
      </button>
    </div>

    {{-- Penyaring sisi-peramban terhadap baris tabel yang sudah dimuat:
         rentang tanggal masuk dan asal pembuat laporan. --}}
    <div class="flex flex-wrap items-end gap-3 mb-4">
      <div>
        <label for="filterTanggalDari" class="block text-xs font-medium text-gray-600 mb-1">Masuk dari</label>
        <input type="date" id="filterTanggalDari"
          class="h-10 border border-gray-300 text-gray-900 text-sm rounded-lg px-3 focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div>
        <label for="filterTanggalSampai" class="block text-xs font-medium text-gray-600 mb-1">sampai</label>
        <input type="date" id="filterTanggalSampai"
          class="h-10 border border-gray-300 text-gray-900 text-sm rounded-lg px-3 focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div>
        <label for="filterDibuatOleh" class="block text-xs font-medium text-gray-600 mb-1">Dibuat oleh</label>
        <select id="filterDibuatOleh"
          class="h-10 border border-gray-300 text-gray-900 text-sm rounded-lg px-3 focus:ring-blue-500 focus:border-blue-500">
          <option value="">Semua pelapor</option>
          <option value="kelurahan">Operator Kelurahan</option>
          <option value="admin">{{ \App\Models\HantuBanyuLaporan::LABEL_ADMIN }}</option>
        </select>
      </div>
      <button type="button" id="btnResetFilter"
        class="h-10 px-4 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-gray-200">
        Reset
      </button>
    </div>

    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="laporan" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>No.</th>
            <th>Pelapor</th>
            <th>Dibuat Oleh</th>
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
              {{-- data-tipe dipakai penyaring "Dibuat oleh" di atas tabel. --}}
              <td data-tipe="{{ $item->dibuat_oleh_tipe }}">
                <span
                  class="inline-flex items-center gap-1 whitespace-nowrap px-2.5 py-1 rounded-full text-xs font-medium {{ $item->dibuat_oleh_tipe === 'admin' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700' }}">
                  <i
                    class="fa-solid {{ $item->dibuat_oleh_tipe === 'admin' ? 'fa-user-shield' : 'fa-building-user' }} fa-xs"></i>
                  {{ $item->label_pelapor }}
                </span>
              </td>
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
                <a href="{{ route('admin.hantu-banyu.laporan.edit', $item->id) }}"
                  title="{{ $boleh_kelola ? 'Kelola laporan' : 'Lihat laporan' }}"
                  class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid {{ $boleh_kelola ? 'fa-clipboard-list' : 'fa-eye' }}"></i>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>No.</th>
            <th>Pelapor</th>
            <th>Dibuat Oleh</th>
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

  {{-- Modal unduh laporan. Dipakai bersama oleh tombol PDF dan Excel:
       pilihan periodenya sama persis, hanya berkas hasilnya yang berbeda,
       jadi tidak perlu dua modal yang isinya kembar. --}}
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
          <i id="modalIkon" class="fa-solid fa-file-pdf text-red-600 mr-1"></i>
          <span id="modalJudul">Unduh PDF Laporan</span>
        </h3>
        <button type="button" data-tutup-modal
          class="text-gray-400 hover:bg-gray-100 hover:text-gray-900 rounded-lg p-1.5 inline-flex items-center">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <form method="GET" id="formUnduh" data-aksi-pdf="{{ route('admin.hantu-banyu.laporan.unduh-pdf') }}"
        data-aksi-excel="{{ route('admin.hantu-banyu.laporan.unduh-excel') }}"
        action="{{ route('admin.hantu-banyu.laporan.unduh-pdf') }}" class="p-4 space-y-4">
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
          <button type="submit" id="modalTombolUnduh"
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
      // Kolom: 0 No, 1 Pelapor, 2 Dibuat Oleh, 3 Lokasi, 4 Waktu Masuk,
      //        5 Status, 6 Jenis, 7 Kelola
      const tabel = $('#laporan').DataTable({
        order: [[4, 'desc']],
        columnDefs: [{
          orderable: false,
          targets: [7]
        }]
      });

      // --- Penyaring tanggal masuk & asal pembuat laporan ---
      const inpDari = document.getElementById('filterTanggalDari');
      const inpSampai = document.getElementById('filterTanggalSampai');
      const selDibuatOleh = document.getElementById('filterDibuatOleh');

      // Waktu masuk disimpan sebagai detik epoch di data-order milik selnya,
      // jadi perbandingannya tidak bergantung pada format tampilan.
      function batasEpoch(nilai, akhirHari) {
        if (!nilai) return null;
        const t = new Date(nilai + (akhirHari ? 'T23:59:59' : 'T00:00:00'));
        return isNaN(t.getTime()) ? null : Math.floor(t.getTime() / 1000);
      }

      $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        if (settings.nTable !== document.getElementById('laporan')) return true;

        const baris = tabel.row(dataIndex).node();
        const dari = batasEpoch(inpDari.value, false);
        const sampai = batasEpoch(inpSampai.value, true);
        const tipe = selDibuatOleh.value;

        if (dari !== null || sampai !== null) {
          const selWaktu = baris.cells[4];
          const epoch = parseInt(selWaktu.getAttribute('data-order'), 10);
          if (!isNaN(epoch)) {
            if (dari !== null && epoch < dari) return false;
            if (sampai !== null && epoch > sampai) return false;
          }
        }

        if (tipe && baris.cells[2].getAttribute('data-tipe') !== tipe) return false;

        return true;
      });

      [inpDari, inpSampai, selDibuatOleh].forEach(function(el) {
        el.addEventListener('change', function() {
          tabel.draw();
        });
      });

      document.getElementById('btnResetFilter').addEventListener('click', function() {
        inpDari.value = '';
        inpSampai.value = '';
        selDibuatOleh.value = '';
        tabel.draw();
      });

      // --- Modal Unduh Laporan (PDF / Excel) ---
      const modal = document.getElementById('modalUnduhPdf');
      const openBtn = document.getElementById('btnUnduhPdf');
      const openBtnExcel = document.getElementById('btnUnduhExcel');
      const formUnduh = document.getElementById('formUnduh');
      const modalJudul = document.getElementById('modalJudul');
      const modalIkon = document.getElementById('modalIkon');
      const modalTombol = document.getElementById('modalTombolUnduh');
      const groups = {
        rentang: document.getElementById('grp-rentang'),
        tahun: document.getElementById('grp-tahun'),
        bulan: document.getElementById('grp-bulan'),
      };

      // Satu modal untuk dua format: yang berubah hanya tujuan form,
      // judul, dan warna tombolnya.
      function openModal(format) {
        const excel = format === 'excel';

        formUnduh.action = excel ? formUnduh.dataset.aksiExcel : formUnduh.dataset.aksiPdf;
        modalJudul.textContent = excel ? 'Unduh Excel Laporan' : 'Unduh PDF Laporan';
        modalIkon.className = excel ?
          'fa-solid fa-file-excel text-green-700 mr-1' :
          'fa-solid fa-file-pdf text-red-600 mr-1';
        modalTombol.className = excel ?
          'inline-flex items-center gap-2 px-4 py-2 text-sm rounded-lg bg-green-700 text-white hover:bg-green-800' :
          'inline-flex items-center gap-2 px-4 py-2 text-sm rounded-lg bg-red-600 text-white hover:bg-red-700';

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

      if (openBtn) openBtn.addEventListener('click', () => openModal('pdf'));
      if (openBtnExcel) openBtnExcel.addEventListener('click', () => openModal('excel'));
      modal.querySelectorAll('[data-tutup-modal]').forEach(b => b.addEventListener('click', closeModal));
      modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
      });
      modal.querySelectorAll('input[name="mode"]').forEach(r => r.addEventListener('change', syncGroups));
      syncGroups();
    });
  </script>
@endsection
