@extends('admin.layout')

@section('document.head')
  @vite('resources/css/leaflet.css')
@endsection

@section('document.body')
  <div class="sticky top-[80px] z-30 w-full">
    <div class="container mx-auto">
      <div class="backdrop-blur-sm rounded-xl">
        <div class="flex justify-between items-center bg-white p-3 rounded-xl shadow-lg border">
          <div class="flex items-center gap-2 flex-wrap">
            <button id="toggleFilterBtn" type="button"
              class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-400 transition-all duration-200 transform hover:scale-105">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
              </svg>
              <span id="toggleFilterBtnLabel">Tampilkan Filter</span>
            </button>
          </div>
        </div>
        <div id="filterPanel" class="mt-4 hidden shadow-lg">
          <div class="bg-white p-4 rounded-xl shadow-md border flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <form method="GET" action="" class="w-full">
              <div class="flex flex-col md:flex-row md:flex-wrap items-end gap-3">
                <div class="w-full md:w-[250px] lg:w-auto">
                  <input type="text" name="search" value="{{ request('search') }}" class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Cari Laporan (ID Laporan / No. HP)...">
                </div>
                <div class="w-full md:flex-1">
                  <select name="tingkat_kerusakan_filter" class="block w-full py-2.5 px-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">Semua Tingkat</option>
                    <option value="ringan" {{ request('tingkat_kerusakan_filter') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                    <option value="sedang" {{ request('tingkat_kerusakan_filter') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="berat" {{ request('tingkat_kerusakan_filter') == 'berat' ? 'selected' : '' }}>Berat</option>
                  </select>
                </div>
                <div class="w-full md:flex-1">
                  <select name="jenis_kerusakan_filter" class="block w-full py-2.5 px-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">Semua Jenis</option>
                    <option value="Lubang-lubang" {{ request('jenis_kerusakan_filter') == 'Lubang-lubang' ? 'selected' : '' }}>Lubang-lubang</option>
                    <option value="Ambles" {{ request('jenis_kerusakan_filter') == 'Ambles' ? 'selected' : '' }}>Ambles</option>
                    <option value="Retak buaya" {{ request('jenis_kerusakan_filter') == 'Retak buaya' ? 'selected' : '' }}>Retak buaya</option>
                    <option value="Permukaan tergerus" {{ request('jenis_kerusakan_filter') == 'Permukaan tergerus' ? 'selected' : '' }}>Permukaan tergerus</option>
                    <option value="Penurunan slab di sambungan" {{ request('jenis_kerusakan_filter') == 'Penurunan slab di sambungan' ? 'selected' : '' }}>Penurunan slab di sambungan</option>
                    <option value="Slab pecah/retak di sambungan" {{ request('jenis_kerusakan_filter') == 'Slab pecah/retak di sambungan' ? 'selected' : '' }}>Slab pecah/retak di sambungan</option>
                    <option value="Permukaan tidak rata" {{ request('jenis_kerusakan_filter') == 'Permukaan tidak rata' ? 'selected' : '' }}>Permukaan tidak rata</option>
                    <option value="Longsor" {{ request('jenis_kerusakan_filter') == 'Longsor' ? 'selected' : '' }}>Longsor</option>
                  </select>
                </div>
                <div class="w-full md:flex-1">
                  <select name="status_kerusakan_filter" class="block w-full py-2.5 px-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">Semua Status</option>
                    <option value="disposisi" {{ request('status_kerusakan_filter') == 'disposisi' ? 'selected' : '' }}>Disposisi</option>
                    <option value="telah_disurvei" {{ request('status_kerusakan_filter') == 'telah_disurvei' ? 'selected' : '' }}>Telah Disurvei</option>
                    <option value="belum_dikerjakan" {{ request('status_kerusakan_filter') == 'belum_dikerjakan' ? 'selected' : '' }}>Belum Dikerjakan</option>
                    <option value="sedang_dikerjakan" {{ request('status_kerusakan_filter') == 'sedang_dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                    <option value="telah_dikerjakan" {{ request('status_kerusakan_filter') == 'telah_dikerjakan' ? 'selected' : '' }}>Telah Dikerjakan</option>
                  </select>
                </div>
                <div>
                  <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-400 transition-all duration-200">
                    Terapkan
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Konten utama --}}
  <div class="container mx-auto py-4 sm:py-6 lg:py-8">
    {{-- TODO: Ganti dengan loop data laporan dari backend --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-8">
      @foreach ($laporans as $laporan)
        @php
          $statusNama = strtolower($laporan->status->nama_status ?? 'tidak diketahui');
          // Mapping label dan warna status dari tabel
          $statusMap = collect($allStatuses)->mapWithKeys(function($s) {
            $label = ucwords(str_replace('_', ' ', $s->nama_status));
            $colorMap = [
              'belum_dikerjakan' => ['gradient' => 'from-amber-400 to-orange-500', 'badge' => 'bg-amber-100 text-amber-800'],
              'telah_dikerjakan' => ['gradient' => 'from-green-400 to-emerald-500', 'badge' => 'bg-green-100 text-green-800'],
              'sedang_dikerjakan' => ['gradient' => 'from-sky-400 to-cyan-500', 'badge' => 'bg-sky-100 text-sky-800'],
              'telah_disurvei' => ['gradient' => 'from-cyan-400 to-teal-500', 'badge' => 'bg-cyan-100 text-cyan-800'],
              'disposisi' => ['gradient' => 'from-purple-400 to-fuchsia-500', 'badge' => 'bg-purple-100 text-purple-800'],
            ];
            $color = $colorMap[$s->nama_status] ?? ['gradient' => 'from-gray-400 to-slate-500', 'badge' => 'bg-gray-100 text-gray-800'];
            return [strtolower($s->nama_status) => array_merge($color, ['text' => $label])];
          });
          $currentStatus = $statusMap[$statusNama] ?? ['gradient' => 'from-gray-400 to-slate-500', 'badge' => 'bg-gray-100 text-gray-800', 'text' => ucwords(str_replace('_', ' ', $statusNama))];
        @endphp

        <div class="bg-white rounded-2xl shadow-lg transition-all duration-300 hover:shadow-2xl transform hover:-translate-y-1 overflow-hidden border border-gray-200/50 flex flex-col">
          <div class="h-2 bg-gradient-to-r {{ $currentStatus['gradient'] }}"></div>
          <div class="p-5 flex-grow">
            <div class="flex justify-between items-center mb-4">
              <span class="text-xs font-bold bg-blue-50 text-blue-800 px-3 py-1 rounded-full">ID: {{ $laporan->id_laporan }}</span>
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $currentStatus['badge'] }}">
                {{ $currentStatus['text'] }}
              </span>
            </div>
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
              <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-gray-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                <div>
                  <h3 class="text-lg font-bold text-gray-800 leading-tight">{{ $laporan->alamat_lengkap_kerusakan }}</h3>
                  <p class="text-sm text-gray-500">{{ $laporan->kecamatan->nama ?? '-' }}, {{ $laporan->kelurahan->nama ?? '-' }}</p>
                </div>
              </div>
              <hr class="my-4 border-slate-200">
              <div class="space-y-3 text-sm">
                <div class="flex items-center">
                  <span class="w-24 text-gray-500">Jenis</span>
                  <span class="font-semibold text-gray-700">: {{ $laporan->jenis_kerusakan ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center">
                  <span class="w-24 text-gray-500">Tingkat</span>
                  <span class="font-semibold text-gray-700">: {{ $laporan->tingkat_kerusakan ? Str::title($laporan->tingkat_kerusakan) : 'N/A' }}</span>
                </div>
                <div class="flex items-center">
                  <span class="w-24 text-gray-500">Tanggal</span>
                  <span class="font-semibold text-gray-700">: {{ $laporan->created_at->locale('id')->isoFormat('DD MMMM YYYY') }}</span>
                </div>
                <div class="flex items-center">
                  <span class="w-24 text-gray-500">Link Peta</span>
                  <span class="font-semibold text-gray-700">: <a href="{{ $laporan->link_koordinat }}" target="_blank" class="text-blue-600 hover:underline">Lihat di Peta</a></span>
                </div>
              </div>
              @if($statusNama === 'disposisi' && !empty($laporan->keterangan))
                <blockquote class="mt-4 p-3 bg-purple-50 border-l-4 border-purple-400 rounded-r-lg">
                  <p class="text-sm text-purple-800 italic">"{{ $laporan->keterangan }}"</p>
                </blockquote>
              @endif
            </div>
          </div>
          <div class="px-5 pb-5 mt-auto">
            <div class="flex justify-center gap-3 flex-wrap">
              <!-- Tombol Edit -->
              <a href="{{ route('admin.jalan-peduli.tindaklanjuti-laporan.edit', $laporan->id_laporan) }}" 
                class="btn-hover bg-yellow-500 text-white font-bold px-4 py-2 rounded-lg hover:bg-yellow-600 flex items-center justify-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125L18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
                Edit
              </a>

              <!-- Tombol Lihat -->
              <a href="{{ route('admin.jalan-peduli.laporan-masuk.show', $laporan->id_laporan) }}"
                class="btn-hover bg-blue-700 text-white font-bold px-4 py-2 rounded-lg hover:bg-blue-800 flex items-center justify-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Lihat
              </a>

              <!-- Tombol Hapus -->
              <button data-modal-target="deleteModal-{{ $laporan->id_laporan }}"
                      data-modal-toggle="deleteModal-{{ $laporan->id_laporan }}"
                      class="btn-hover bg-red-600 text-white font-bold px-4 py-2 rounded-lg hover:bg-red-700 flex items-center justify-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
                Hapus
              </button>
              @if($statusNama === 'telah_dikerjakan')
                <!-- Tombol WhatsApp (hanya muncul jika status 'telah_dikerjakan') -->
                <a href="#" 
                  onclick="sendWhatsAppMessage('{{ $laporan->nomor_ponsel }}', '{{ route('admin.jalan-peduli.laporan-masuk.show', $laporan->id_laporan) }}')"
                  class="btn-hover bg-green-600 text-white font-bold px-4 py-2 rounded-lg hover:bg-green-700 flex items-center justify-center gap-2 text-sm w-full">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                  </svg>
                  Hubungi Pelapor
                </a>
              @endif
            </div>
          </div>
        </div>

        {{-- Modal konfirmasi hapus --}}
        <div id="deleteModal-{{ $laporan->id_laporan }}" data-modal-target="deleteModal-{{ $laporan->id_laporan }}"
          data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
          class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                  Konfirmasi Penghapusan
                </h3>
                <button type="button"
                  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                  data-modal-hide="deleteModal-{{ $laporan->id_laporan }}">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                  <span class="sr-only">Close modal</span>
                </button>
              </div>
              <div class="p-4 md:p-5 space-y-4">
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                  Apakah Anda yakin ingin <strong>menghapus</strong> laporan dengan ID
                  <strong>{{ $laporan->id_laporan }}</strong>? Laporan yang telah dihapus <strong>tidak dapat
                    dipulihkan</strong>.
                </p>
              </div>
              <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <form action="{{ route('admin.jalan-peduli.tindaklanjuti-laporan.destroy', $laporan->id_laporan) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                    class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Hapus</button>
                </form>
                <button type="button"
                  class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                  data-modal-hide="deleteModal-{{ $laporan->id_laporan }}">
                  Tidak
                </button>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    @if ($laporans->hasPages())
      <div class="mt-12 flex justify-center items-center flex-col fade-in gap-3">
        <nav class="inline-flex rounded-xl shadow-lg overflow-hidden border border-gray-200 bg-white w-fit" aria-label="Pagination">
          {{-- Previous Button --}}
          @if ($laporans->onFirstPage())
            <span class="px-4 py-2 text-gray-400 bg-gray-50 cursor-not-allowed select-none flex items-center">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
              </svg>
            </span>
          @else
            <a href="{{ $laporans->previousPageUrl() }}" rel="prev"
              class="px-4 py-2 text-primary-navy hover:bg-primary-navy/10 font-semibold transition-colors flex items-center">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
              </svg>
            </a>
          @endif

          {{-- Page Numbers --}}
          @foreach ($laporans->links()->elements[0] as $page => $url)
            @if ($page == $laporans->currentPage())
              <span class="px-4 py-2 bg-primary-navy text-white font-bold shadow-inner">{{ $page }}</span>
            @else
              <a href="{{ $url }}"
                class="px-4 py-2 text-primary-navy hover:bg-primary-navy/10 font-medium transition-colors">{{ $page }}</a>
            @endif
          @endforeach

          {{-- Next Button --}}
          @if ($laporans->hasMorePages())
            <a href="{{ $laporans->nextPageUrl() }}" rel="next"
              class="px-4 py-2 text-primary-navy hover:bg-primary-navy/10 font-semibold transition-colors flex items-center">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
              </svg>
            </a>
          @else
            <span class="px-4 py-2 text-gray-400 bg-gray-50 cursor-not-allowed select-none flex items-center">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
              </svg>
            </span>
          @endif
        </nav>
        <div class="flex items-center text-gray-500">
          Halaman <span class="font-bold text-primary-navy mx-1">{{ $laporans->currentPage() }}</span>
          dari <span class="font-bold text-primary-navy mx-1">{{ $laporans->lastPage() }}</span>
        </div>
      </div>
    @endif

    {{-- Dummy Map --}}
    <div class="mt-10">
      <h4 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Peta Lokasi Laporan</h4>
      <div id="map" class="relative z-0 h-[50vh] sm:h-96 md:h-[500px] w-full rounded-lg"></div>
    </div>
  </div>
@endsection

@section('document.end')
  @vite('resources/js/leaflet.js')
  <script>
      function sendWhatsAppMessage(phoneNumber, reportUrl) {
          // Format nomor telepon
          const cleanedPhone = phoneNumber.replace(/\D/g, '');
          const formattedPhone = cleanedPhone.startsWith('0') 
              ? '62' + cleanedPhone.substring(1) 
              : cleanedPhone;

          // Ekstrak ID laporan dari URL
          const urlParams = new URL(reportUrl);
          const reportId = urlParams.searchParams.get('search') || reportUrl.split('/').pop();

          // Bangun URL pendek yang konsisten
          const shortUrl = `https://pupr.samarindakota.go.id/jalan-peduli/laporan/data?search=${reportId}`;

          // Format pesan dengan baris terpisah (lebih rapi dibaca di kode)
          const message = `
      Terima kasih telah melaporkan aduan jalan rusak menggunakan website DPUPR Jalan Peduli. 
      Kami ingin menginformasikan bahwa pekerjaan yang Anda laporkan telah selesai dikerjakan.
      ${shortUrl}
          `.trim();

          // Encode untuk URL WhatsApp
          const encodedMessage = encodeURIComponent(message);
          window.open(`https://wa.me/${formattedPhone}?text=${encodedMessage}`, '_blank');
      }

  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var btn = document.getElementById('toggleFilterBtn');
      var panel = document.getElementById('filterPanel');
      var label = document.getElementById('toggleFilterBtnLabel');
      var isOpen = false;
      btn.addEventListener('click', function() {
        isOpen = !isOpen;
        panel.classList.toggle('hidden', !isOpen);
        label.textContent = isOpen ? 'Sembunyikan Filter' : 'Tampilkan Filter';
      });
      // Leaflet map: fetch data dari backend
      if (window.L) {
        var map = L.map('map').setView([-0.502106, 117.153709], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 18,
          attribution: '© OpenStreetMap'
        }).addTo(map);

        const iconBelumDikerjakan = new L.Icon({
          iconUrl: '/image/map/yellow-dot.png',
          iconSize: [32, 32],
          iconAnchor: [16, 32],
          popupAnchor: [0, -32],
        });
        const iconSedangDikerjakan = new L.Icon({
          iconUrl: '/image/map/orange-dot.png',
          iconSize: [32, 32],
          iconAnchor: [16, 32],
          popupAnchor: [0, -32],
        });
        const iconTelahDikerjakan = new L.Icon({
          iconUrl: '/image/map/green-dot.png',
          iconSize: [32, 32],
          iconAnchor: [16, 32],
          popupAnchor: [0, -32],
        });
        const iconTelahDisurvei = new L.Icon({
          iconUrl: '/image/map/blue-dot.png',
          iconSize: [32, 32],
          iconAnchor: [16, 32],
          popupAnchor: [0, -32],
        });
        const iconDisposisi = new L.Icon({
          iconUrl: '/image/map/purple-dot.png',
          iconSize: [32, 32],
          iconAnchor: [16, 32],
          popupAnchor: [0, -32],
        });

        function getStatusIcon(status) {
          switch (status.toLowerCase()) {
            case 'belum_dikerjakan': return iconBelumDikerjakan;
            case 'sedang_dikerjakan': return iconSedangDikerjakan;
            case 'telah_dikerjakan': return iconTelahDikerjakan;
            case 'telah_disurvei': return iconTelahDisurvei;
            case 'disposisi': return iconDisposisi;
            default: return iconBelumDikerjakan;
          }
        }

        // Ambil data laporan dari backend (hanya yang sudah disetujui)
        fetch('{{ route("admin.jalan-peduli.tindaklanjuti-laporan.index") }}?map=1')
          .then(response => response.json())
          .then(data => {
            if (!data || !Array.isArray(data)) return;
            let bounds = [];
            data.forEach(laporan => {
              const statusNama = laporan.status?.nama_status || 'belum_dikerjakan';
              if (!laporan.latitude || !laporan.longitude) return;
              const icon = getStatusIcon(statusNama);
              const marker = L.marker(
                [parseFloat(laporan.latitude), parseFloat(laporan.longitude)],
                { icon: icon }
              ).addTo(map);

              marker.bindPopup(`
                <div style="font-size:14px;">
                  <b>ID:</b> ${laporan.id_laporan}<br>
                  <b>Status:</b> ${statusNama}<br>
                  <b>Alamat:</b> ${laporan.alamat_lengkap_kerusakan}<br>
                  <b>Deskripsi:</b> ${laporan.deskripsi_laporan || 'Tidak ada'}<br>
                  <b>Latitude:</b> ${laporan.latitude}<br>
                  <b>Longitude:</b> ${laporan.longitude}<br>
                  <b>Dibuat:</b> ${laporan.created_at ? new Date(laporan.created_at).toLocaleString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '-'}
                </div>
              `);
              bounds.push([laporan.latitude, laporan.longitude]);
            });
            if (bounds.length > 0) map.fitBounds(bounds);
          })
          .catch(error => {
            console.error('Gagal mengambil data peta:', error);
          });
      }
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.body.addEventListener('click', function(e) {
        var toggleBtn = e.target.closest('[data-modal-toggle]');
        if (toggleBtn) {
          var modalId = toggleBtn.getAttribute('data-modal-toggle');
          var modalEl = document.getElementById(modalId);
          if (window.Modal && modalEl) {
            if (!modalEl.__flowbiteModal) {
              modalEl.__flowbiteModal = new window.Modal(modalEl);
            }
            modalEl.__flowbiteModal.show();
          }
        }
        var hideBtn = e.target.closest('[data-modal-hide]');
        if (hideBtn) {
          var modalId = hideBtn.getAttribute('data-modal-hide');
          var modalEl = document.getElementById(modalId);
          if (window.Modal && modalEl && modalEl.__flowbiteModal) {
            modalEl.__flowbiteModal.hide();
          }
        }
      });
    });
  </script>
@endsection


