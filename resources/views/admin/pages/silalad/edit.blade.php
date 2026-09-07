@extends('admin.layout')

@section('title', $page_title)

@section('document.head')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endsection

@section('document.body')

  @php
    $inputCls = 'border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5';
  @endphp

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 items-start">

    {{-- Kolom kerja: yang benar-benar diisi & ditindaklanjuti admin --}}
    <div class="lg:col-span-2 space-y-5">

      {{-- Cetak: surat yang belum memenuhi syarat tampil nonaktif beserta alasannya --}}
      <div class="bg-white rounded-lg shadow-lg border p-6 space-y-4">
        <h2 class="text-base font-semibold text-gray-900">Cetak Dokumen</h2>

        @php
          use App\Models\Silalad;

          // Surat Pesanan dan Surat Perintah Kerja sama-sama terbit saat
          // pesanan dijadwalkan, jadi syarat bukanya pun sama.
          $sudahDijadwalkan = $data->suratPenugasanTerbit();
          $spkSiap = $sudahDijadwalkan && $data->nama_operator;
          $jalanSiap = $data->status_pengerjaan === Silalad::SELESAI;

          // Nama surat panjang-panjang, jadi tiap surat ditaruh satu baris:
          // nama di kiri, tombol di kanan, alasan terkunci di bawah namanya.
          $dokumen = [
              [
                  'nama' => 'Bukti Pesanan',
                  'ikon' => 'fa-receipt',
                  'ket' => 'Tanda terima ringkas untuk pelanggan.',
                  'rute' => route('admin.silalad.print', $data->id),
                  'siap' => true,
              ],
              [
                  'nama' => 'Surat Pesanan',
                  'ikon' => 'fa-file-signature',
                  'ket' => 'Dibawa petugas; bagian yang belum terisi dilengkapi tulisan tangan di lokasi.',
                  'rute' => route('admin.silalad.surat-pesanan', $data->id),
                  'siap' => $sudahDijadwalkan,
                  'alasan' => 'Terbit saat pesanan dijadwalkan.',
              ],
              [
                  'nama' => 'Surat Perintah Kerja',
                  'ikon' => 'fa-clipboard-check',
                  'ket' => 'Dasar penugasan operator dan kendaraan.',
                  'rute' => route('admin.silalad.surat-perintah-kerja', $data->id),
                  'siap' => $spkSiap,
                  'alasan' => 'Terbit saat pesanan dijadwalkan dan operator sudah ditugaskan.',
              ],
              [
                  'nama' => 'Surat Jalan',
                  'ikon' => 'fa-truck-fast',
                  'ket' => 'Bukti pelaksanaan penyedotan beserta jumlah ritnya.',
                  'rute' => route('admin.silalad.surat-jalan', $data->id),
                  'siap' => $jalanSiap,
                  'alasan' => 'Terbit saat pesanan dinyatakan selesai.',
              ],
          ];
        @endphp

        <ul class="divide-y border rounded-lg">
          @foreach ($dokumen as $surat)
            <li class="flex items-center gap-4 px-4 py-3">
              <i class="fa-solid {{ $surat['ikon'] }} w-4 text-center {{ $surat['siap'] ? 'text-red-600' : 'text-gray-300' }}"></i>

              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium {{ $surat['siap'] ? 'text-gray-900' : 'text-gray-400' }}">
                  {{ $surat['nama'] }}
                </p>
                <p class="text-xs text-gray-500 mt-0.5">
                  {{ $surat['siap'] ? $surat['ket'] : $surat['alasan'] }}
                </p>
              </div>

              @if ($surat['siap'])
                <a href="{{ $surat['rute'] }}"
                  class="shrink-0 inline-flex items-center justify-center gap-1.5 w-28 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg px-4 py-2">
                  <i class="fa-solid fa-print"></i> Cetak
                </a>
              @else
                <span
                  class="shrink-0 inline-flex items-center justify-center gap-1.5 w-28 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg px-4 py-2 cursor-not-allowed">
                  <i class="fa-solid fa-lock"></i> Terkunci
                </span>
              @endif
            </li>
          @endforeach
        </ul>
      </div>

      {{-- Riwayat Tindak Lanjut: tiap tahap diisi lewat modal sendiri,
           dibuka berurutan - meniru pola Hantu Banyu, bedanya tiap tahap di
           sini punya field spesifik (bukan jenis+deskripsi generik) karena
           setiap tahap SILALAD memang menerbitkan surat berbeda. --}}
      <div class="bg-white rounded-lg shadow-lg border p-6">
        <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
          <i class="fa-solid fa-timeline text-blue-600"></i> Riwayat Tindak Lanjut
        </h2>
        <p class="text-sm text-gray-500 mt-1 mb-5">
          Tahap diisi <b>berurutan</b> — hanya tahap berikutnya yang bisa dibuka. Tahap yang sudah terisi tetap bisa
          diedit. <b>Dibatalkan</b> boleh diisi kapan saja selama pesanan belum "Selesai".
        </p>

        <ol class="relative border-s border-gray-200 ml-3">
          @foreach (Silalad::STATUS as $s)
            @php
              $row = $slot[$s];
              $isi = $row !== null;
              $bisa = $editable[$s] ?? false;
              $slug = $slotSlug[$s] ?? null;
              $titik = match ($s) {
                  Silalad::MENUNGGU => 'bg-yellow-400',
                  Silalad::DIJADWALKAN => 'bg-indigo-500',
                  Silalad::DIKERJAKAN => 'bg-blue-500',
                  Silalad::DIBATALKAN => 'bg-red-500',
                  default => 'bg-green-500',
              };
            @endphp
            <li class="mb-6 ms-6">
              <span class="absolute flex items-center justify-center w-6 h-6 rounded-full -start-3 ring-4 ring-white {{ $isi ? $titik : 'bg-gray-100' }}">
                <i class="fa-solid {{ $isi ? 'fa-circle-check text-white' : 'fa-circle text-gray-300' }} text-[10px]"></i>
              </span>
              <div class="flex items-start justify-between gap-2">
                <div>
                  <span class="text-sm font-semibold {{ $isi ? 'text-gray-900' : 'text-gray-400' }}">{{ $s }}</span>
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
                  @if ($slug === null)
                    {{-- "Menunggu konfirmasi": tidak ada data admin yang bisa
                         diisi di tahap ini, jadi tidak ada tombol aksi. --}}
                  @elseif ($bisa)
                    <button type="button" data-modal-toggle="slotModal-{{ $slug }}"
                      class="flex items-center justify-center w-8 h-8 rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                      title="{{ $isi ? 'Edit tahap' : 'Isi tahap' }}">
                      <i class="fa-solid {{ $isi ? 'fa-pencil' : 'fa-plus' }} text-xs"></i>
                    </button>
                  @else
                    <span class="flex items-center justify-center w-8 h-8 rounded-md text-gray-300 cursor-not-allowed"
                      title="{{ $s === Silalad::DIBATALKAN ? 'Penyedotan sudah selesai, tidak bisa dibatalkan' : 'Selesaikan tahap sebelumnya dulu' }}">
                      <i class="fa-solid fa-lock text-xs"></i>
                    </span>
                  @endif
                </div>
              </div>

              @if ($isi)
                <p class="text-sm text-gray-700 mt-2 bg-gray-50 border border-gray-100 rounded-lg p-3">
                  {{ $row->keterangan }}
                </p>
              @elseif ($bisa)
                <p class="text-sm text-gray-400 italic mt-2">Belum diisi — klik <i class="fa-solid fa-plus text-[10px]"></i> untuk mengisi tahap ini.</p>
              @elseif ($s === Silalad::DIBATALKAN)
                {{-- Tahap ini terkunci bukan karena menunggu tahap sebelumnya
                     (dibatalkan boleh diisi kapan saja sebelum Selesai), tapi
                     justru karena pesanan sudah Selesai duluan. --}}
                <p class="text-sm text-gray-300 italic mt-2">Penyedotan yang sudah selesai tidak dapat dibatalkan.</p>
              @else
                <p class="text-sm text-gray-300 italic mt-2">Terkunci — selesaikan tahap sebelumnya dulu.</p>
              @endif
            </li>
          @endforeach
        </ol>
      </div>
    </div>

    {{-- Kolom rujukan: isian pelanggan (tidak bisa diubah) & jejak pesanan --}}
    <div class="space-y-5">

      {{-- Data Pelanggan --}}
      <div class="bg-white rounded-lg shadow-lg border p-6 space-y-4">
        <div>
          <h2 class="text-base font-semibold text-gray-900">Data Pelanggan</h2>
          <p class="text-sm text-gray-500">Diisi pelanggan sendiri saat mendaftar.</p>
        </div>

        <dl class="text-sm divide-y border rounded-lg">
          <div class="px-3 py-2">
            <dt class="text-xs text-gray-500">Nama Pelanggan</dt>
            <dd class="text-gray-900">{{ $data->nama_pelanggan }}</dd>
          </div>
          <div class="px-3 py-2">
            <dt class="text-xs text-gray-500">Nomor Telepon</dt>
            <dd class="text-gray-900">{{ $data->nomor_telepon_pelanggan }}</dd>
          </div>
          <div class="px-3 py-2">
            <dt class="text-xs text-gray-500">Alamat</dt>
            <dd class="text-gray-900">{{ $data->alamat }}</dd>
          </div>
          <div class="px-3 py-2">
            <dt class="text-xs text-gray-500">Menyetujui biaya tambahan?</dt>
            <dd class="mt-0.5">
              @if ($data->setuju)
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                  <i class="fa-solid fa-circle-check"></i> Ya
                </span>
              @else
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                  <i class="fa-solid fa-circle-xmark"></i> Tidak
                </span>
              @endif
            </dd>
          </div>
        </dl>
      </div>

      {{-- Detail Lokasi --}}
      <div class="bg-white rounded-lg shadow-lg border p-6 space-y-4">
        <div>
          <h2 class="text-base font-semibold text-gray-900">Detail Lokasi &amp; Waktu</h2>
          <p class="text-sm text-gray-500">Diisi pelanggan sendiri saat mendaftar.</p>
        </div>

        <dl class="text-sm divide-y border rounded-lg">
          @if ($data->alamat_detail)
            <div class="px-3 py-2">
              <dt class="text-xs text-gray-500">Alamat Detail</dt>
              <dd class="text-gray-900">{{ $data->alamat_detail }}</dd>
            </div>
          @endif
          {{-- Permintaan pelanggan, bukan jadwal yang mengikat - keputusan
               tetap di Tanggal Pelaksanaan pada seksi Penugasan. Diberi
               embel-embel "Diminta Pelanggan" di sini supaya kedua label
               "Tanggal Pengerjaan" tidak tertukar. --}}
          <div class="px-3 py-2">
            <dt class="text-xs text-gray-500">Tanggal Pengerjaan (Diminta Pelanggan)</dt>
            <dd class="text-gray-900">
              @if ($data->tanggal_diharapkan)
                {{ $data->tanggal_diharapkan->translatedFormat('l, d F Y') }}
              @else
                {{-- Pesanan lama, dibuat sebelum isian ini ada. --}}
                <span class="text-gray-400">Tidak dicantumkan</span>
              @endif
            </dd>
          </div>
          <div class="px-3 py-2">
            <dt class="text-xs text-gray-500">Layanan</dt>
            <dd class="text-gray-900">{{ $data->layanan ?: '-' }}</dd>
          </div>
          <div class="px-3 py-2">
            <dt class="text-xs text-gray-500">Jenis Bangunan</dt>
            <dd class="text-gray-900">{{ $data->jenis_bangunan ?: '-' }}</dd>
          </div>
          @if ($data->detail_laporan)
            <div class="px-3 py-2">
              <dt class="text-xs text-gray-500">Detail Laporan</dt>
              <dd class="text-gray-900">{{ $data->detail_laporan }}</dd>
            </div>
          @endif
          <div class="px-3 py-2">
            <dt class="text-xs text-gray-500">Kabupaten/Kota</dt>
            <dd class="text-gray-900">{{ $data->kabkota_id ?: '-' }}</dd>
          </div>
          <div class="px-3 py-2">
            <dt class="text-xs text-gray-500">Kecamatan</dt>
            <dd class="text-gray-900">{{ $namaKecamatan ?: '-' }}</dd>
          </div>
          <div class="px-3 py-2">
            <dt class="text-xs text-gray-500">Kelurahan</dt>
            <dd class="text-gray-900">{{ $namaKelurahan ?: '-' }}</dd>
          </div>
          <div class="grid grid-cols-2 divide-x">
            <div class="px-3 py-2">
              <dt class="text-xs text-gray-500">RT</dt>
              <dd class="text-gray-900">{{ $data->rt ?: '-' }}</dd>
            </div>
            <div class="px-3 py-2">
              <dt class="text-xs text-gray-500">Nomor Bangunan</dt>
              <dd class="text-gray-900">{{ $data->nomor_bangunan ?: '-' }}</dd>
            </div>
          </div>
        </dl>

        @if ($data->latitude && $data->longitude)
          <div class="space-y-1.5">
            <p class="text-xs text-gray-500">Titik Lokasi</p>
            <div id="map" class="w-full rounded-lg border" style="height:240px;"></div>
          </div>
        @endif
      </div>
    </div>
  </div>

  {{-- ================= MODAL: Dijadwalkan ================= --}}
  @php
    $slugDijadwalkan = $slotSlug[Silalad::DIJADWALKAN];
    $rowDijadwalkan = $slot[Silalad::DIJADWALKAN];
    $slotErrorDijadwalkan = $errors->any() && old('_slot') === $slugDijadwalkan;

    // Kolom tanggal_pelaksanaan tidak menyimpan apakah nilainya hasil
    // "disamakan otomatis" atau dipilih manual - keduanya sama-sama cuma
    // tanggal. Jadi dikira-kira: bawaan checkbox tercentang bila belum ada
    // tanggal sama sekali, atau nilainya persis sama dengan permintaan
    // pelanggan.
    $tanggalSama = $data->tanggal_diharapkan
        && $data->tanggal_pelaksanaan
        && $data->tanggal_diharapkan->isSameDay($data->tanggal_pelaksanaan);
    $pakaiTanggalDiharapkanBawaan = !$data->tanggal_pelaksanaan || $tanggalSama;

    // Nilai yang ditampilkan di kotak tanggal saat checkbox tercentang
    // bawaan - dituliskan di server (bukan menunggu JS) supaya kotak yang
    // dinonaktifkan sejak render pertama tidak tampil kosong.
    $tampilanTanggalPelaksanaan = $pakaiTanggalDiharapkanBawaan
        ? optional($data->tanggal_diharapkan)->format('Y-m-d')
        : optional($data->tanggal_pelaksanaan)->format('Y-m-d');
  @endphp
  @if ($editable[Silalad::DIJADWALKAN] ?? false)
    <div id="slotModal-{{ $slugDijadwalkan }}" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow">
          <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
            <h3 class="text-lg font-semibold text-gray-900">
              {{ $rowDijadwalkan ? 'Edit Tahap' : 'Isi Tahap' }}: Dijadwalkan
            </h3>
            <button type="button"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
              data-modal-hide="slotModal-{{ $slugDijadwalkan }}">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
              <span class="sr-only">Tutup</span>
            </button>
          </div>

          <form method="POST" action="{{ route('admin.silalad.slot.simpan', [$data->id, $slugDijadwalkan]) }}">
            @csrf
            <input type="hidden" name="_slot" value="{{ $slugDijadwalkan }}">

            <div class="p-4 md:p-5 space-y-4 max-h-96 overflow-y-auto">
              <p class="text-xs text-gray-500">Data ini jadi isi Surat Pesanan dan Surat Perintah Kerja.</p>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor SPK</label>
                <div class="flex gap-2">
                  <input type="text" id="nomor_spk" name="nomor_spk"
                    value="{{ $slotErrorDijadwalkan ? old('nomor_spk') : $data->nomor_spk }}"
                    class="block w-full p-2 border border-gray-300 rounded-md text-sm" placeholder="{{ $nomorSpkUsulan }}">
                  <button type="button" id="isiNomorSpk" data-usulan="{{ $nomorSpkUsulan }}"
                    class="shrink-0 inline-flex items-center gap-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg px-3">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> Isi
                  </button>
                </div>
                <p class="text-xs text-gray-400 mt-1">Tombol "Isi" hanya mengusulkan <code>{{ $nomorSpkUsulan }}</code>;
                  formatnya boleh diketik bebas sesuai aturan UPTD.</p>
                @error('nomor_spk')
                  <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Operator / Sopir</label>
                <input type="text" name="nama_operator"
                  value="{{ $slotErrorDijadwalkan ? old('nama_operator') : $data->nama_operator }}"
                  class="block w-full p-2 border border-gray-300 rounded-md text-sm" placeholder="Contoh: Budi Santoso">
                @error('nama_operator')
                  <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
              </div>

              <div class="grid grid-cols-2 gap-3">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Kendaraan</label>
                  <input type="text" name="nomor_kendaraan"
                    value="{{ $slotErrorDijadwalkan ? old('nomor_kendaraan') : $data->nomor_kendaraan }}"
                    class="block w-full p-2 border border-gray-300 rounded-md text-sm" placeholder="KT 8123 AB">
                  @error('nomor_kendaraan')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                  @enderror
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
                  <input type="text" name="kapasitas_kendaraan"
                    value="{{ $slotErrorDijadwalkan ? old('kapasitas_kendaraan') : $data->kapasitas_kendaraan }}"
                    class="block w-full p-2 border border-gray-300 rounded-md text-sm" placeholder="4.000 liter">
                  @error('kapasitas_kendaraan')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              {{-- Tanggal kapan penyedotan dieksekusi - beda dengan tanggal
                   terbit SPK (yang otomatis, tidak diminta di sini). Bawaannya
                   disamakan dengan permintaan pelanggan lewat centang; admin
                   melepas centang hanya bila pelanggan tidak bisa diladeni
                   sesuai permintaannya. --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pelaksanaan</label>
                <input type="date" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan"
                  value="{{ $slotErrorDijadwalkan ? old('tanggal_pelaksanaan') : $tampilanTanggalPelaksanaan }}"
                  data-tanggal-diharapkan="{{ optional($data->tanggal_diharapkan)->format('Y-m-d') }}"
                  {{ old('pakai_tanggal_diharapkan', $pakaiTanggalDiharapkanBawaan) ? 'disabled' : '' }}
                  class="block w-full p-2 border border-gray-300 rounded-md text-sm">

                <label class="flex items-start gap-2 text-xs text-gray-600 mt-1.5">
                  <input type="checkbox" id="pakai_tanggal_diharapkan" name="pakai_tanggal_diharapkan" value="1"
                    {{ old('pakai_tanggal_diharapkan', $pakaiTanggalDiharapkanBawaan) ? 'checked' : '' }}
                    class="mt-0.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                  <span>
                    Sama seperti tanggal yang diajukan pelanggan
                    @if ($data->tanggal_diharapkan)
                      (<strong class="font-medium text-gray-700">{{ $data->tanggal_diharapkan->translatedFormat('l, d F Y') }}</strong>)
                    @else
                      <span class="text-amber-600">— pelanggan tidak mencantumkan tanggal, pilih manual</span>
                    @endif
                  </span>
                </label>
                @error('tanggal_pelaksanaan')
                  <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
              </div>

              <div class="pt-3 border-t">
                <p class="text-xs text-gray-500 mb-3">Data di bawah ini jadi isi Surat Pesanan. Boleh dikosongkan dan
                  dilengkapi tulisan tangan di suratnya - baru diketahui setelah armada di lokasi.</p>
                <div class="grid grid-cols-2 gap-3">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jarak Tangki (meter)</label>
                    <input type="number" min="0" name="jarak_tangki"
                      value="{{ $slotErrorDijadwalkan ? old('jarak_tangki') : $data->jarak_tangki }}"
                      class="block w-full p-2 border border-gray-300 rounded-md text-sm" placeholder="Contoh: 15">
                    @error('jarak_tangki')
                      <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bisa Disedot?</label>
                    @php
                      $bisa = $slotErrorDijadwalkan
                          ? old('bisa_disedot')
                          : ($data->bisa_disedot === null ? '' : (int) $data->bisa_disedot);
                    @endphp
                    <select name="bisa_disedot" class="block w-full p-2 border border-gray-300 rounded-md text-sm">
                      <option value="" {{ $bisa === '' || $bisa === null ? 'selected' : '' }}>-- Belum didata --</option>
                      <option value="1" {{ $bisa === 1 || $bisa === '1' ? 'selected' : '' }}>Ya</option>
                      <option value="0" {{ $bisa === 0 || $bisa === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('bisa_disedot')
                      <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
              </div>
            </div>

            <div class="flex items-center p-4 md:p-5 border-t rounded-b">
              <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Simpan
              </button>
              <button type="button" data-modal-hide="slotModal-{{ $slugDijadwalkan }}"
                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">
                Batal
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif

  {{-- ================= MODAL: Sedang dikerjakan ================= --}}
  @php
    $slugDikerjakan = $slotSlug[Silalad::DIKERJAKAN];
    $rowDikerjakan = $slot[Silalad::DIKERJAKAN];
  @endphp
  @if ($editable[Silalad::DIKERJAKAN] ?? false)
    <div id="slotModal-{{ $slugDikerjakan }}" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
          <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
            <h3 class="text-lg font-semibold text-gray-900">Tandai Tahap: Sedang Dikerjakan</h3>
            <button type="button"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
              data-modal-hide="slotModal-{{ $slugDikerjakan }}">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
              <span class="sr-only">Tutup</span>
            </button>
          </div>

          <form method="POST" action="{{ route('admin.silalad.slot.simpan', [$data->id, $slugDikerjakan]) }}">
            @csrf
            <input type="hidden" name="_slot" value="{{ $slugDikerjakan }}">
            <div class="p-4 md:p-5">
              <p class="text-sm text-gray-600">
                Tandai pesanan ini sebagai sedang dikerjakan - petugas sudah berangkat ke lokasi. Tidak ada data
                tambahan yang perlu diisi pada tahap ini.
              </p>
            </div>
            <div class="flex items-center p-4 md:p-5 border-t rounded-b">
              <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Simpan
              </button>
              <button type="button" data-modal-hide="slotModal-{{ $slugDikerjakan }}"
                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">
                Batal
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif

  {{-- ================= MODAL: Selesai ================= --}}
  @php
    $slugSelesai = $slotSlug[Silalad::SELESAI];
    $rowSelesai = $slot[Silalad::SELESAI];
    $slotErrorSelesai = $errors->any() && old('_slot') === $slugSelesai;
  @endphp
  @if ($editable[Silalad::SELESAI] ?? false)
    <div id="slotModal-{{ $slugSelesai }}" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
          <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
            <h3 class="text-lg font-semibold text-gray-900">{{ $rowSelesai ? 'Edit Tahap' : 'Isi Tahap' }}: Selesai</h3>
            <button type="button"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
              data-modal-hide="slotModal-{{ $slugSelesai }}">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
              <span class="sr-only">Tutup</span>
            </button>
          </div>

          <form method="POST" action="{{ route('admin.silalad.slot.simpan', [$data->id, $slugSelesai]) }}">
            @csrf
            <input type="hidden" name="_slot" value="{{ $slugSelesai }}">
            <div class="p-4 md:p-5 space-y-4">
              <p class="text-xs text-gray-500">Surat Jalan terbit dari data ini.</p>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Rit</label>
                <input type="number" min="1" name="jumlah_rit"
                  value="{{ $slotErrorSelesai ? old('jumlah_rit') : $data->jumlah_rit }}"
                  class="block w-full p-2 border border-gray-300 rounded-md text-sm" placeholder="Contoh: 1">
                <p class="text-xs text-gray-400 mt-1">Jadi dasar penagihan, karena tarifnya dihitung per rit.</p>
                @error('jumlah_rit')
                  <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
              </div>
            </div>
            <div class="flex items-center p-4 md:p-5 border-t rounded-b">
              <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Simpan
              </button>
              <button type="button" data-modal-hide="slotModal-{{ $slugSelesai }}"
                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">
                Batal
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif

  {{-- ================= MODAL: Dibatalkan ================= --}}
  @php
    $slugDibatalkan = $slotSlug[Silalad::DIBATALKAN];
    $rowDibatalkan = $slot[Silalad::DIBATALKAN];
    $slotErrorDibatalkan = $errors->any() && old('_slot') === $slugDibatalkan;
  @endphp
  @if ($editable[Silalad::DIBATALKAN] ?? false)
    <div id="slotModal-{{ $slugDibatalkan }}" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
          <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
            <h3 class="text-lg font-semibold text-gray-900">{{ $rowDibatalkan ? 'Edit Tahap' : 'Isi Tahap' }}: Dibatalkan</h3>
            <button type="button"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
              data-modal-hide="slotModal-{{ $slugDibatalkan }}">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
              <span class="sr-only">Tutup</span>
            </button>
          </div>

          <form method="POST" action="{{ route('admin.silalad.slot.simpan', [$data->id, $slugDibatalkan]) }}">
            @csrf
            <input type="hidden" name="_slot" value="{{ $slugDibatalkan }}">
            <div class="p-4 md:p-5 space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Pembatalan</label>
                <textarea name="alasan_batal" rows="3" class="block w-full p-2 border border-gray-300 rounded-md text-sm"
                  placeholder="Contoh: Tangki septik tidak bisa dijangkau selang">{{ $slotErrorDibatalkan ? old('alasan_batal') : $data->alasan_batal }}</textarea>
                @error('alasan_batal')
                  <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
              </div>
            </div>
            <div class="flex items-center p-4 md:p-5 border-t rounded-b">
              <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Simpan
              </button>
              <button type="button" data-modal-hide="slotModal-{{ $slugDibatalkan }}"
                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">
                Batal
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif
@endsection

@section('document.end')
  {{-- Tombol "Isi" pada Nomor SPK: sekadar mengisikan usulan dari server,
       nilainya tetap bisa diketik ulang admin. --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const tombol = document.getElementById('isiNomorSpk');
      const kotak = document.getElementById('nomor_spk');
      if (!tombol || !kotak) return;

      tombol.addEventListener('click', function() {
        kotak.value = tombol.dataset.usulan || '';
        kotak.focus();
      });
    });
  </script>

  {{-- Buka/tutup modal tiap tahap (Flowbite, sudah dimuat global lewat
       app.js) - pola yang sama dipakai modal Hantu Banyu. --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      function modalOf(id) {
        var el = document.getElementById(id);
        if (!window.Modal || !el) return null;
        el.__m = el.__m || new window.Modal(el);
        return el.__m;
      }

      document.body.addEventListener('click', function(e) {
        var toggle = e.target.closest('[data-modal-toggle]');
        if (toggle) {
          var m = modalOf(toggle.getAttribute('data-modal-toggle'));
          if (m) m.show();
        }
        var hide = e.target.closest('[data-modal-hide]');
        if (hide) {
          var m2 = modalOf(hide.getAttribute('data-modal-hide'));
          if (m2) m2.hide();
        }
      });

      {{-- Kesalahan validasi membawa balik ke halaman ini (bukan tetap di
           halaman modal, karena modal tidak lebih dari sekadar tampilan) -
           buka kembali modal yang tadi diisi supaya pesan kesalahannya
           terlihat, bukan tersembunyi di modal yang tertutup. --}}
      @if ($errors->any() && in_array(old('_slot'), $slotSlug, true))
        var errModal = modalOf('slotModal-{{ old('_slot') }}');
        if (errModal) errModal.show();
      @endif
    });
  </script>

  {{-- Checkbox "sama seperti tanggal yang diajukan pelanggan": saat
       tercentang, kotak tanggal dinonaktifkan (nilainya diambil server dari
       tanggal_diharapkan, bukan dari kotak ini) dan diisi tampilannya supaya
       admin tetap melihat tanggal apa yang akan dipakai. Saat dilepas,
       kotaknya aktif kembali untuk diisi manual. --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const centang = document.getElementById('pakai_tanggal_diharapkan');
      const kotak = document.getElementById('tanggal_pelaksanaan');
      if (!centang || !kotak) return;

      function segarkan() {
        kotak.disabled = centang.checked;
        if (centang.checked && kotak.dataset.tanggalDiharapkan) {
          kotak.value = kotak.dataset.tanggalDiharapkan;
        }
      }

      centang.addEventListener('change', segarkan);
    });
  </script>

  @if ($data->latitude && $data->longitude)
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const pos = [{{ $data->latitude }}, {{ $data->longitude }}];
        const map = L.map('map', { dragging: false, scrollWheelZoom: false, doubleClickZoom: false }).setView(pos, 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        L.marker(pos).addTo(map);
      });
    </script>
  @endif
@endsection
