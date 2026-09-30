@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/datatables.css', 'resources/js/datatables.js'])
@endsection

@php
  $alirBadge = [
      'lancar' => 'bg-green-100 text-green-800',
      'kurang_lancar' => 'bg-yellow-100 text-yellow-800',
      'tersumbat_sebagian' => 'bg-orange-100 text-orange-800',
      'macet_total' => 'bg-red-100 text-red-800',
  ];
  $sedimentasiBadge = [
      'normal' => 'bg-green-100 text-green-800',
      'sedang' => 'bg-yellow-100 text-yellow-800',
      'tinggi' => 'bg-red-100 text-red-800',
  ];
@endphp

@section('document.body')
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="flex flex-wrap items-center justify-between gap-2 pb-4 mb-4 border-b border-gray-200">
      <div class="flex flex-wrap gap-2">
        <button type="button" id="btnUnduhExcel"
          class="inline-flex items-center gap-2 h-10 px-4 text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm font-medium focus:outline-none">
          <i class="fa-solid fa-file-excel"></i>
          <span class="whitespace-nowrap">Unduh Excel</span>
        </button>
        <button type="button" id="btnUnduhPdf"
          class="inline-flex items-center gap-2 h-10 px-4 text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 rounded-lg text-sm font-medium focus:outline-none">
          <i class="fa-solid fa-file-pdf"></i>
          <span class="whitespace-nowrap">Unduh PDF</span>
        </button>
      </div>

      @if ($boleh_kelola)
        <a href="{{ route('admin.hantu-banyu.pemeriksaan-berkala.create') }}"
          class="inline-flex items-center gap-2 h-10 px-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm font-medium focus:outline-none">
          <i class="fa-solid fa-plus"></i>
          <span class="whitespace-nowrap">Tambah Pemeriksaan</span>
        </a>
      @endif
    </div>

    @unless ($boleh_kelola)
      <div class="mb-4 flex items-start gap-2 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
        <i class="fa-solid fa-circle-info mt-0.5"></i>
        <span>Anda membuka halaman ini dalam <b>mode lihat saja</b>. Menambah dan mengubah catatan hanya dapat dilakukan oleh unit pengelola Hantu Banyu.</span>
      </div>
    @endunless

    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="pemeriksaan-berkala" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>Ruas Saluran</th>
            <th>Sedimentasi &amp; Sampah</th>
            <th>Status Aliran</th>
            <th>Kelola</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pemeriksaan as $item)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td data-order="{{ $item->tanggal_pemeriksaan->timestamp }}">
                {{ $item->tanggal_pemeriksaan->translatedFormat('d M Y') }}
              </td>
              <td>
                <div class="font-medium text-gray-900">{{ $item->nama_jalan }}</div>
                <div class="text-xs text-gray-500">
                  {{ optional($item->kelurahan)->nama ?? '-' }}, {{ optional($item->kecamatan)->nama ?? '-' }}
                </div>
              </td>
              <td>
                <div class="font-medium text-gray-900">{{ $ruas_saluran_label[$item->nama_ruas_saluran] ?? $item->nama_ruas_saluran }}</div>
                @if ($item->dimensi_lebar_m !== null && $item->dimensi_tinggi_m !== null)
                  <div class="text-xs text-gray-500">
                    {{ number_format((float) $item->dimensi_lebar_m, 2) }} m x {{ number_format((float) $item->dimensi_tinggi_m, 2) }} m
                  </div>
                @endif
              </td>
              <td>
                @if ($item->tingkat_sedimentasi_sampah_cm !== null)
                  <div class="text-gray-900">{{ rtrim(rtrim(number_format((float) $item->tingkat_sedimentasi_sampah_cm, 1), '0'), '.') }} cm</div>
                @endif
                @if ($item->persen_sedimentasi !== null)
                  <span class="inline-flex items-center whitespace-nowrap px-2 py-0.5 rounded-full text-xs font-medium {{ $sedimentasiBadge[$item->kategori_sedimentasi] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $item->persen_sedimentasi }}% ({{ $kategori_sedimentasi_label[$item->kategori_sedimentasi] ?? '-' }})
                  </span>
                @elseif ($item->tingkat_sedimentasi_sampah_cm === null)
                  <span class="text-xs text-gray-400">-</span>
                @endif
              </td>
              <td>
                <span class="inline-flex items-center whitespace-nowrap px-2.5 py-1 rounded-full text-xs font-medium {{ $alirBadge[$item->status_aliran_air] ?? 'bg-gray-100 text-gray-800' }}">
                  {{ $status_aliran_label[$item->status_aliran_air] ?? ucwords(str_replace('_', ' ', $item->status_aliran_air)) }}
                </span>
              </td>
              <td>
                @if ($boleh_kelola)
                  <div class="flex gap-2">
                    <a href="{{ route('admin.hantu-banyu.pemeriksaan-berkala.edit', $item->id) }}"
                      title="Edit catatan"
                      class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
                      <i class="fa-solid fa-pencil"></i>
                    </a>
                    <button data-modal-target="deleteModal-{{ $item->id }}" data-modal-toggle="deleteModal-{{ $item->id }}"
                      title="Hapus catatan"
                      class="flex justify-center items-center w-10 h-10 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm p-2.5 focus:outline-none">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </div>

                  <x-admin.modal-hapus :id="$item->id" :aksi="route('admin.hantu-banyu.pemeriksaan-berkala.destroy', $item->id)">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                      Apakah Anda yakin ingin menghapus catatan pemeriksaan
                      <strong>{{ $item->nama_jalan }} ({{ $ruas_saluran_label[$item->nama_ruas_saluran] ?? $item->nama_ruas_saluran }})</strong> tanggal
                      <strong>{{ $item->tanggal_pemeriksaan->translatedFormat('d F Y') }}</strong>?
                    </p>
                  </x-admin.modal-hapus>
                @else
                  <span class="text-xs text-gray-400">-</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>Ruas Saluran</th>
            <th>Sedimentasi &amp; Sampah</th>
            <th>Status Aliran</th>
            <th>Kelola</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  {{-- Modal unduh, dipakai bersama tombol PDF dan Excel. Pilihan periodenya
       disamakan dengan modal unduh daftar laporan (lihat
       resources/views/admin/pages/hantu-banyu/laporan/index.blade.php). --}}
  @php
    $selCls = 'border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5';
  @endphp
  <div id="modalUnduh" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-full overflow-y-auto">
      <div class="flex items-center justify-between p-4 border-b">
        <h3 class="text-lg font-semibold text-gray-900">
          <i id="modalIkon" class="fa-solid fa-file-pdf text-red-600 mr-1"></i>
          <span id="modalJudul">Unduh PDF</span>
        </h3>
        <button type="button" data-tutup-modal
          class="text-gray-400 hover:bg-gray-100 hover:text-gray-900 rounded-lg p-1.5 inline-flex items-center">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <form method="GET" id="formUnduh" data-aksi-pdf="{{ route('admin.hantu-banyu.pemeriksaan-berkala.unduh-pdf') }}"
        data-aksi-excel="{{ route('admin.hantu-banyu.pemeriksaan-berkala.unduh-excel') }}"
        action="{{ route('admin.hantu-banyu.pemeriksaan-berkala.unduh-pdf') }}" class="p-4 space-y-4">

        <div class="space-y-2">
          <label class="flex items-start gap-2 text-sm">
            <input type="radio" name="mode" value="semua" class="mt-1" checked>
            <span class="font-medium">Semua catatan</span>
          </label>
          <label class="flex items-start gap-2 text-sm">
            <input type="radio" name="mode" value="hari_ini" class="mt-1">
            <span class="font-medium">Hari ini</span>
          </label>
          <label class="flex items-start gap-2 text-sm">
            <input type="radio" name="mode" value="rentang" class="mt-1">
            <span class="font-medium">Rentang tanggal, bulan, &amp; tahun</span>
          </label>
          <label class="flex items-start gap-2 text-sm">
            <input type="radio" name="mode" value="tahun" class="mt-1">
            <span class="font-medium">Satu tahun</span>
          </label>
          <label class="flex items-start gap-2 text-sm">
            <input type="radio" name="mode" value="bulan" class="mt-1">
            <span class="font-medium">Satu Bulan</span>
          </label>
        </div>

        <div id="grpRentang" class="hidden rounded-lg border border-gray-200 p-3 space-y-3">
          <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Dari tanggal</label>
            <input type="date" name="dari_tanggal" lang="id" class="{{ $selCls }}" disabled>
          </div>
          <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Sampai tanggal</label>
            <input type="date" name="sampai_tanggal" lang="id" class="{{ $selCls }}" disabled>
          </div>
        </div>

        <div id="grpTahun" class="hidden rounded-lg border border-gray-200 p-3">
          <label class="block text-xs font-semibold text-gray-500 mb-1">Tahun</label>
          <select name="tahun" class="{{ $selCls }}" disabled>
            @foreach ($tahun_opsi as $y)
              <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
          </select>
        </div>

        <div id="grpBulan" class="hidden rounded-lg border border-gray-200 p-3">
          <label class="block text-xs font-semibold text-gray-500 mb-1">Bulan &amp; tahun</label>
          <input type="month" name="periode_bulan" lang="id" class="{{ $selCls }}" disabled>
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
      $('#pemeriksaan-berkala').DataTable({
        order: [[1, 'desc']],
        columnDefs: [{
          orderable: false,
          targets: [6]
        }]
      });

      const modal = document.getElementById('modalUnduh');
      const form = document.getElementById('formUnduh');
      const modalIkon = document.getElementById('modalIkon');
      const modalJudul = document.getElementById('modalJudul');
      const groups = {
        rentang: document.getElementById('grpRentang'),
        tahun: document.getElementById('grpTahun'),
        bulan: document.getElementById('grpBulan'),
      };

      function bukaModal(tipe) {
        const aksiPdf = form.dataset.aksiPdf;
        const aksiExcel = form.dataset.aksiExcel;
        if (tipe === 'excel') {
          form.action = aksiExcel;
          modalIkon.className = 'fa-solid fa-file-excel text-green-600 mr-1';
          modalJudul.textContent = 'Unduh Excel';
        } else {
          form.action = aksiPdf;
          modalIkon.className = 'fa-solid fa-file-pdf text-red-600 mr-1';
          modalJudul.textContent = 'Unduh PDF';
        }
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      }

      function tutupModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
      }

      document.getElementById('btnUnduhPdf').addEventListener('click', () => bukaModal('pdf'));
      document.getElementById('btnUnduhExcel').addEventListener('click', () => bukaModal('excel'));
      modal.querySelectorAll('[data-tutup-modal]').forEach(btn => btn.addEventListener('click', tutupModal));

      function syncGroups() {
        const mode = form.querySelector('input[name="mode"]:checked')?.value || 'semua';
        Object.entries(groups).forEach(([key, el]) => {
          const aktif = key === mode;
          el.classList.toggle('hidden', !aktif);
          // Nonaktifkan input pada grup tersembunyi agar tidak ikut terkirim.
          el.querySelectorAll('select, input').forEach(s => {
            s.disabled = !aktif;
          });
        });
      }

      form.querySelectorAll('input[name="mode"]').forEach(radio => radio.addEventListener('change', syncGroups));
      syncGroups();
    });
  </script>
@endsection
