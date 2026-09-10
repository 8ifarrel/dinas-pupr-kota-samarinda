@extends('admin.layout')

@section('document.head')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
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
  <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <a href="{{ route('admin.hantu-banyu.laporan.index') }}"
      class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg px-3 py-2">
      <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Laporan
    </a>
    <a href="{{ route('admin.hantu-banyu.laporan.pdf', $laporan->kode) }}"
      class="inline-flex items-center gap-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg px-4 py-2">
      <i class="fa-solid fa-file-pdf"></i> Unduh PDF
    </a>
  </div>

  @unless ($boleh_kelola)
    {{-- Terang-terangan menjelaskan mengapa tidak ada tombol isi tahap,
         supaya tidak terbaca sebagai halaman yang rusak. --}}
    <div class="mb-5 flex items-start gap-2 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
      <i class="fa-solid fa-circle-info mt-0.5"></i>
      <span>
        Anda membuka laporan ini dalam <b>mode lihat saja</b>. Pengisian tindak lanjut hanya dapat
        dilakukan oleh {{ $nama_unit_pengelola }}.
      </span>
    </div>
  @endunless

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Kolom kiri --}}
    <div class="lg:col-span-2 space-y-6">
      {{-- Foto laporan --}}
      <div class="bg-white rounded-lg shadow-lg border p-6">
        <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
          <i class="fa-solid fa-images text-blue-600"></i>Foto Pengaduan
          <span class="text-xs font-normal text-gray-500 ml-auto">Klik untuk memperbesar</span>
        </h3>
        @if (count($laporan->foto) > 0)
          <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
            @foreach ($laporan->foto as $foto)
              <a href="{{ asset('storage/' . $foto->foto) }}" data-lightbox="foto-laporan"
                data-title="Foto Laporan #{{ $loop->iteration }}">
                <img src="{{ asset('storage/' . $foto->foto) }}" alt="Foto Laporan #{{ $loop->iteration }}"
                  class="h-28 w-full object-cover rounded-lg border hover:opacity-90 transition" />
              </a>
            @endforeach
          </div>
        @else
          <div class="bg-gray-50 rounded-lg p-8 flex flex-col items-center justify-center text-center">
            <i class="fa-solid fa-image text-gray-300 text-4xl mb-2"></i>
            <p class="text-gray-500 text-sm">Tidak ada foto yang dilampirkan.</p>
          </div>
        @endif
      </div>

      {{-- Riwayat tahap penanganan --}}
      <div class="bg-white rounded-lg shadow-lg border p-6">
        <h3 class="font-semibold text-gray-900 mb-1 flex items-center gap-2">
          <i class="fa-solid fa-timeline text-blue-600"></i>Riwayat Tindak Lanjut
        </h3>
        <p class="text-sm text-gray-500 mb-4">
          Tahap diisi <b>berurutan</b> &mdash; hanya tahap berikutnya yang bisa dibuka. Tahap yang sudah terisi
          tetap bisa diedit. Pengecualian: dari <b>Menunggu Verifikasi</b> boleh langsung ke <b>Selesai</b>.
        </p>

        <div class="flex items-center flex-wrap gap-2 mb-5 text-sm">
          <span class="text-gray-500">Jenis penanganan:</span>
          <span class="inline-flex items-center whitespace-nowrap px-2.5 py-1 rounded-full text-xs font-medium {{ $jenisBadge[$jenis_laporan] ?? 'bg-gray-100 text-gray-800' }}">
            {{ $jenisLabels[$jenis_laporan] ?? ucwords(str_replace('_', ' ', $jenis_laporan)) }}
          </span>
        </div>

        <ol class="relative border-s border-gray-200 ml-3">
          @foreach ($daftar_status as $s)
            {{-- Admin di luar unit pengelola boleh membaca seluruh linimasa,
                 tapi tidak boleh mengisinya - $bisa dimatikan untuk mereka. --}}
            @php $row = $slot[$s]; $isi = $row !== null; $bisa = $boleh_kelola && ($editable[$s] ?? false); @endphp
            <li class="mb-6 ms-6">
              <span class="absolute flex items-center justify-center w-6 h-6 rounded-full -start-3 ring-4 ring-white {{ $isi ? ($statusBadge[$s] ?? 'bg-gray-100 text-gray-800') : 'bg-gray-100 text-gray-400' }}">
                <i class="fa-solid {{ $isi ? 'fa-circle-check' : 'fa-circle' }} text-[10px]"></i>
              </span>
              <div class="flex items-start justify-between gap-2">
                <div>
                  <span class="text-sm font-semibold {{ $isi ? 'text-gray-900' : 'text-gray-400' }}">
                    {{ $statusLabels[$s] }}
                  </span>
                  @if ($isi)
                    <time class="block text-xs text-gray-500 mt-0.5">
                      {{ $row->created_at->translatedFormat('d F Y H:i') }} WITA
                      @if ($row->updated_at->gt($row->created_at))
                        <span class="text-gray-400">· diubah {{ $row->updated_at->translatedFormat('d F Y H:i') }}</span>
                      @endif
                    </time>
                  @endif
                </div>
                <div class="flex gap-1 shrink-0">
                  @if ($bisa)
                    <button type="button" data-modal-toggle="slotModal-{{ $s }}"
                      class="flex items-center justify-center w-8 h-8 rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                      title="{{ $isi ? 'Edit tahap' : 'Isi tahap' }}">
                      <i class="fa-solid {{ $isi ? 'fa-pencil' : 'fa-plus' }} text-xs"></i>
                    </button>
                  @elseif (!$boleh_kelola)
                    {{-- Terkunci karena wewenang, bukan karena urutan tahap. --}}
                    <span class="flex items-center justify-center w-8 h-8 rounded-md text-gray-300 cursor-not-allowed"
                      title="Hanya {{ $nama_unit_pengelola }} yang dapat mengisi tahap ini">
                      <i class="fa-solid fa-eye text-xs"></i>
                    </span>
                  @else
                    <span
                      class="flex items-center justify-center w-8 h-8 rounded-md text-gray-300 cursor-not-allowed"
                      title="Selesaikan tahap sebelumnya dulu">
                      <i class="fa-solid fa-lock text-xs"></i>
                    </span>
                  @endif
                </div>
              </div>

              @if ($isi)
                <p class="text-sm text-gray-700 mt-2 bg-gray-50 border border-gray-100 rounded-lg p-3">
                  {{ $row->deskripsi }}
                </p>
                @if ($row->foto && count($row->foto) > 0)
                  <div class="grid grid-cols-3 gap-1.5 mt-2">
                    @foreach ($row->foto as $ft)
                      <a href="{{ asset('storage/' . $ft->foto) }}" data-lightbox="tl-{{ $s }}"
                        data-title="Foto Tahap {{ $statusLabels[$s] }}">
                        <img src="{{ asset('storage/' . $ft->foto) }}" alt="Foto Tindak Lanjut"
                          class="h-16 w-full object-cover rounded border hover:opacity-90 transition" />
                      </a>
                    @endforeach
                  </div>
                @endif
              @elseif ($bisa)
                <p class="text-sm text-gray-400 italic mt-2">Belum diisi &mdash; klik <i class="fa-solid fa-plus text-[10px]"></i> untuk mengisi tahap ini.</p>
              @elseif (!$boleh_kelola)
                <p class="text-sm text-gray-300 italic mt-2">Belum diisi.</p>
              @else
                <p class="text-sm text-gray-300 italic mt-2">Terkunci &mdash; selesaikan tahap sebelumnya dulu.</p>
              @endif
            </li>
          @endforeach
        </ol>
      </div>
    </div>

    {{-- Kolom kanan --}}
    <div class="space-y-6">
      <div class="bg-white rounded-lg shadow-lg border p-6">
        <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
          <i class="fa-solid fa-circle-info text-blue-600"></i>Detail Laporan
        </h3>
        <dl class="space-y-2 text-sm">
          <div>
            <dt class="text-gray-500">Nomor Pengaduan</dt>
            <dd class="font-medium text-gray-900">{{ $laporan->kode }}</dd>
          </div>
          <div>
            <dt class="text-gray-500">Status Terkini</dt>
            <dd class="mt-1">
              @if ($status_terkini)
                <span class="inline-flex items-center whitespace-nowrap px-2.5 py-1 rounded-full text-xs font-medium {{ $statusBadge[$status_terkini] ?? 'bg-gray-100 text-gray-800' }}">
                  {{ $statusLabels[$status_terkini] ?? ucwords(str_replace('_', ' ', $status_terkini)) }}
                </span>
              @else
                <span class="text-gray-500">Belum ada tindak lanjut</span>
              @endif
            </dd>
          </div>
          <div>
            <dt class="text-gray-500">Jenis Penanganan</dt>
            <dd class="mt-1">
              <span class="inline-flex items-center whitespace-nowrap px-2.5 py-1 rounded-full text-xs font-medium {{ $jenisBadge[$jenis_laporan] ?? 'bg-gray-100 text-gray-800' }}">
                {{ $jenisLabels[$jenis_laporan] ?? ucwords(str_replace('_', ' ', $jenis_laporan)) }}
              </span>
            </dd>
          </div>
          <div>
            <dt class="text-gray-500">Jalan</dt>
            <dd class="font-medium text-gray-900">{{ $laporan->nama_jalan }}</dd>
          </div>
          <div>
            <dt class="text-gray-500">Kelurahan</dt>
            <dd class="font-medium text-gray-900">{{ $laporan->kelurahan->nama ?? '-' }}</dd>
          </div>
          <div>
            <dt class="text-gray-500">Kecamatan</dt>
            <dd class="font-medium text-gray-900">{{ $laporan->kecamatan->nama ?? '-' }}</dd>
          </div>
          <div>
            <dt class="text-gray-500">Detail Lokasi</dt>
            <dd class="font-medium text-gray-900 whitespace-pre-line">{{ $laporan->detail_lokasi }}</dd>
          </div>
          <div>
            <dt class="text-gray-500">Deskripsi Pengaduan</dt>
            <dd class="font-medium text-gray-900 whitespace-pre-line">{{ $laporan->deskripsi_pengaduan }}</dd>
          </div>
          <div>
            <dt class="text-gray-500">Koordinat</dt>
            <dd class="font-medium text-gray-900">
              {{ $laporan->latitude }}, {{ $laporan->longitude }}
              <a href="https://maps.google.com/?q={{ $laporan->latitude }},{{ $laporan->longitude }}" target="_blank"
                rel="noopener noreferrer" class="text-blue-600 underline ml-1">Buka Peta</a>
            </dd>
          </div>
          <div>
            <dt class="text-gray-500">Dilaporkan</dt>
            <dd class="font-medium text-gray-900">{{ $laporan->created_at->translatedFormat('d F Y H:i') }} WITA</dd>
          </div>
        </dl>
      </div>

      <div class="bg-white rounded-lg shadow-lg border p-6">
        <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
          <i class="fa-solid fa-user text-blue-600"></i>Data Pelapor
        </h3>
        <dl class="space-y-2 text-sm">
          <div>
            <dt class="text-gray-500">Nama Lengkap</dt>
            <dd class="font-medium text-gray-900">{{ $laporan->pelapor->nama_lengkap ?? '-' }}</dd>
          </div>
          <div>
            <dt class="text-gray-500">Asal Kelurahan</dt>
            <dd class="font-medium text-gray-900">{{ optional($laporan->pelapor->kelurahanAsal)->nama ?? '-' }}</dd>
          </div>
          <div>
            <dt class="text-gray-500">Nomor Telepon</dt>
            <dd class="font-medium text-gray-900">{{ $laporan->pelapor->nomor_telepon ?? '-' }}</dd>
          </div>
          <div>
            <dt class="text-gray-500">Alamat</dt>
            <dd class="font-medium text-gray-900 whitespace-pre-line">{{ $laporan->pelapor->alamat ?? '-' }}</dd>
          </div>
        </dl>
      </div>
    </div>
  </div>

  {{-- ================= MODAL: isi / edit tiap tahap =================
       Tidak dirender sama sekali untuk admin yang hanya boleh melihat -
       lebih baik formnya tidak ada daripada ada tapi ditolak saat dikirim. --}}
  @foreach ($boleh_kelola ? $daftar_status : [] as $s)
    @continue(!($editable[$s] ?? false))
    @php $row = $slot[$s]; $slotError = $errors->any() && old('_slot') === $s; @endphp
    <div id="slotModal-{{ $s }}" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow">
          <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
            <h3 class="text-lg font-semibold text-gray-900">
              {{ $row ? 'Edit Tahap' : 'Isi Tahap' }}: {{ $statusLabels[$s] }}
            </h3>
            <button type="button"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
              data-modal-hide="slotModal-{{ $s }}">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
              <span class="sr-only">Tutup</span>
            </button>
          </div>

          <form method="POST" action="{{ route('admin.hantu-banyu.laporan.slot.simpan', [$laporan->kode, $s]) }}"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_slot" value="{{ $s }}">

            <div class="p-4 md:p-5 space-y-4 max-h-96 overflow-y-auto">
              @if ($s === 'selesai' && !$row && $status_terkini === 'pending')
                <p class="text-xs text-amber-700 bg-amber-50 border border-amber-200 rounded-md px-3 py-2">
                  <i class="fa-solid fa-circle-info"></i>
                  Menutup laporan langsung dari <b>Menunggu Verifikasi</b> tanpa melewati tahap lain
                  (mis. laporan tidak valid / bukan kewenangan). Tahap di antaranya akan tetap kosong.
                </p>
              @endif

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Penanganan</label>
                <select name="jenis" class="block w-full p-2 border border-gray-300 rounded-md text-sm">
                  @foreach ($daftar_jenis as $j)
                    <option value="{{ $j }}"
                      @selected(($slotError ? old('jenis') : $jenis_laporan) === $j)>
                      {{ $jenisLabels[$j] ?? ucwords(str_replace('_', ' ', $j)) }}
                    </option>
                  @endforeach
                </select>
                <p class="text-xs text-gray-400 mt-1">
                  Mengubah ini akan mengubah jenis penanganan pada <b>semua tahap</b>.
                </p>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="block w-full p-2 border border-gray-300 rounded-md text-sm"
                  placeholder="Contoh: Laporan telah diverifikasi dan dijadwalkan untuk survei lapangan.">{{ $slotError ? old('deskripsi') : ($row?->deskripsi ?? '') }}</textarea>
              </div>

              @if ($row && $row->foto->count() > 0)
                <div>
                  <span class="block text-sm font-medium text-gray-700 mb-1">Foto Saat Ini</span>
                  <p class="text-xs text-gray-400 mb-2">Centang untuk hapus saat menyimpan.</p>
                  <div class="grid grid-cols-3 gap-2">
                    @foreach ($row->foto as $ft)
                      <div class="border rounded overflow-hidden">
                        <img src="{{ asset('storage/' . $ft->foto) }}" alt="Foto" class="h-16 w-full object-cover" />
                        <label class="flex items-center gap-1 px-1.5 py-1 text-[11px] text-red-700 bg-gray-50 cursor-pointer">
                          <input type="checkbox" name="hapus_foto[]" value="{{ $ft->id }}" class="rounded border-gray-300">
                          Hapus
                        </label>
                      </div>
                    @endforeach
                  </div>
                </div>
              @endif

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Tambah Foto <span class="text-gray-400 font-normal">(opsional, maks. 5, JPG/PNG, ≤ 2MB)</span>
                </label>
                <input type="file" name="foto[]" accept="image/jpeg,image/png" multiple
                  class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md cursor-pointer file:mr-3 file:py-2 file:px-3 file:border-0 file:bg-gray-100 file:text-gray-700" />
              </div>
            </div>

            <div class="flex items-center p-4 md:p-5 border-t rounded-b">
              <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Simpan
              </button>
              <button type="button" data-modal-hide="slotModal-{{ $s }}"
                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">
                Batal
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endforeach
@endsection

@section('document.end')
  @vite(['resources/js/datatables.js', 'resources/js/lightbox.js'])
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      if (window.lightbox) {
        lightbox.option({
          resizeDuration: 200,
          wrapAround: true,
          albumLabel: 'Foto %1 dari %2',
          disableScrolling: true
        });
      }

      // Cache di properti yang sama (__flowbiteModal) dengan
      // resources/js/shared/flowbite-modal.js, supaya modal yang dibuka di
      // sini (lewat validasi gagal) tetap bisa ditutup lewat tombol
      // [data-modal-hide] yang delegasinya ditangani modul itu.
      function modalOf(id) {
        var el = document.getElementById(id);
        if (!window.Modal || !el) return null;
        el.__flowbiteModal = el.__flowbiteModal || new window.Modal(el);
        return el.__flowbiteModal;
      }

      @if ($errors->any() && in_array(old('_slot'), $daftar_status, true))
        var errModal = modalOf('slotModal-{{ old('_slot') }}');
        if (errModal) errModal.show();
      @endif
    });
  </script>
@endsection
