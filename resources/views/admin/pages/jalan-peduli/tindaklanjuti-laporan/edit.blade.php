@extends('admin.layout')

@section('document.head')
  @vite('resources/css/leaflet.css')
  <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
  <link href="https://unpkg.com/filepond-plugin-image-preview@^4/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
  <style>
    .filepond--panel-root {
      background-color: #f9fafb;
      border-radius: 0.5rem;
    }
    .filepond--drop-label {
      color: #4b5563;
    }
    .filepond--label-action {
      text-decoration-color: #3b82f6;
    }
    /* Pastikan peta tidak "menonjol" di atas overlay modal */
    .leaflet-pane {
        z-index: 10 !important;
    }
    .leaflet-top, .leaflet-bottom {
        z-index: 10 !important;
    }
  </style>
@endsection

@section('document.body')
  {{-- Konten utama --}}
  <div class="container mx-auto py-4 sm:py-6 lg:py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2">
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 mb-8">
          <div class="px-6 py-5 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
              </svg>
              Detail Laporan
            </h3>
            <p class="mt-1 text-sm text-gray-500">{{ $laporan->created_at->locale('id')->isoFormat('DD MMMM YYYY') }}</p>
          </div>
          <div class="px-6 py-5">
            <div class="mb-6">
              <h4 class="text-base font-medium text-gray-900 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="size-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                {{ $laporan->alamat_lengkap_kerusakan }}
              </h4>
              <p class="text-sm text-gray-600">{{ $laporan->alamat_lengkap_kerusakan }}, {{ $laporan->kelurahan->nama }}, {{ $laporan->kecamatan->nama }}, Kota Samarinda</p>
              <div class="mt-2">
                <a href="{{ $laporan->link_koordinat }}" target="_blank"
                  class="inline-flex items-center text-sm text-blue-600 hover:text-blue-500">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  </svg>
                  Lihat di Maps
                </a>
              </div>
            </div>

            <div class="mb-6">
              <h5 class="text-sm font-medium text-gray-900 mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                  stroke="currentColor" class="size-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                </svg>
                Deskripsi
              </h5>
              <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $laporan->deskripsi_laporan }}</p>
            </div>

            @php
              $photos = json_decode($laporan->foto_kerusakan, true) ?? [];
            @endphp
            @if(!empty($photos))
            <div class="mb-6">
              <h5 class="text-sm font-medium text-gray-900 mb-3  flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>    
                Foto Kerusakan
              </h5>
              <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($photos as $photo)
                <a href="{{ asset('storage/jalan_peduli/' . $laporan->id_laporan . '/' . $photo) }}" data-fancybox="gallery" data-caption="Foto Kerusakan">
                  <div class="aspect-square">
                    <img src="{{ asset('storage/jalan_peduli/' . $laporan->id_laporan . '/' . $photo) }}" alt="Foto Kerusakan" class="w-full h-full object-cover rounded-lg border border-gray-200 hover:opacity-90 transition-opacity">
                  </div>
                </a>
                @endforeach
              </div>
            </div>
            @endif

            @if($laporan->foto_lanjutan)
            <div class="mb-6">
              <h5 class="text-sm font-medium text-gray-900 mb-3">Foto Dokumentasi</h5>
              <a href="{{ asset('storage/foto_lanjutan/' . $laporan->foto_lanjutan) }}" data-fancybox="gallery" data-caption="Foto Dokumentasi">
                <div class="aspect-square max-w-xs">
                  <img src="{{ asset('storage/foto_lanjutan/' . $laporan->foto_lanjutan) }}" alt="Foto Lanjutan" class="w-full h-full object-cover rounded-lg border border-gray-200 hover:opacity-90 transition-opacity">
                </div>
              </a>
            </div>
            @endif

            @if($laporan->dokumen_pendukung)
            <div class="mb-6">
              <h5 class="text-sm font-medium text-gray-900 mb-3 flex items-center gap-2">
                <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                Dokumen Pendukung
              </h5>
              <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                <div class="flex items-center">
                  <i class="fas fa-file-pdf text-red-500 text-3xl mr-4"></i>
                  <div>
                    <p class="text-sm text-gray-600 mb-1">Dokumen Pendukung Laporan</p>
                    <a href="{{ Storage::url('jalan_peduli/' . $laporan->id_laporan . '/' . $laporan->dokumen_pendukung) }}" 
                    target="_blank" 
                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                      <i class="fas fa-download mr-2"></i> Lihat Dokumen
                    </a>
                  </div>
                </div>
              </div>
            </div>
            @endif

            <div class="mb-4">
              <div class="flex items-center space-x-2 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                  stroke-width="1.5" stroke="currentColor" class="size-5 text-gray-700">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                </svg>
                <h5 class="text-sm font-medium text-gray-900">Lokasi</h5>
              </div>
              <div id="map" class="h-64 rounded-lg border border-gray-200"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="lg:col-span-1">
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 mb-6">
          <div class="px-6 py-5 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
              </svg>
              Status Laporan
            </h3>
          </div>
          <div class="px-6 py-5 space-y-4">
            <div class="flex justify-between items-center">
              <span class="text-sm font-medium text-gray-500">Status</span>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                {{ ucwords(str_replace('_', ' ', $laporan->status->nama_status)) }}
              </span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-sm font-medium text-gray-500">Tingkat</span>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                @if($laporan->tingkat_kerusakan === 'ringan') bg-green-100 text-green-800
                @elseif($laporan->tingkat_kerusakan === 'sedang') bg-yellow-100 text-yellow-800
                @else bg-red-100 text-red-800 @endif">
                {{ ucfirst($laporan->tingkat_kerusakan) }}
              </span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-sm font-medium text-gray-500">Jenis</span>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                {{ $laporan->jenis_kerusakan }}
              </span>
            </div>
          </div>
        </div>

        <div class="bg-white shadow-sm rounded-lg border border-gray-200">
          <div class="px-6 py-5 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 flex items-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
              </svg>
              Edit Laporan
            </h3>
          </div>
          {{-- Dummy form --}}
          <form action="{{ route('admin.jalan-peduli.tindaklanjuti-laporan.update', $laporan->id_laporan) }}" method="POST" enctype="multipart/form-data" id="edit-form" class="px-6 py-5 space-y-6">
            @csrf
            @method('POST')
            <div>
              <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Pengerjaan</label>
              <select name="status_id" id="status" required
                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @foreach(\App\Models\JalanPeduliStatus::where('nama_status', '!=', 'reject')->get() as $status)
                  <option value="{{ $status->status_id }}" {{ $laporan->status_id == $status->status_id ? 'selected' : '' }}>
                    {{ ucwords(str_replace('_', ' ', $status->nama_status)) }}
                  </option>
                @endforeach
              </select>
            </div>
            
            <div id="keterangan-group" style="display: none;">
              <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
              <textarea name="keterangan" id="keterangan" rows="4"
                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                placeholder="Masukkan keterangan...">{{ $laporan->keterangan }}</textarea>
            </div>

            {{-- Di dalam form edit, setelah bagian foto_lanjutan --}}
            <div id="dokumen-petugas-group" style="display: none;">
              <label for="dokumen_petugas" class="block text-sm font-medium text-gray-700 mb-2">Unggah Dokumen Petugas</label>
              <input type="file" name="dokumen_petugas" id="dokumen_petugas" accept=".pdf,.doc,.docx">
              <p class="mt-2 text-xs text-gray-500">
                Anda dapat mengunggah dokumen terkait penanganan laporan di sini (PDF, DOC, DOCX maks 10MB).
              </p>
              
              {{-- Tampilkan dokumen yang sudah ada jika ada --}}
              @if($laporan->dokumen_petugas)
              <div class="mt-3 bg-gray-50 rounded-lg border border-gray-200 p-4">
                <div class="flex items-center">
                  <i class="fas fa-file-pdf text-red-500 text-3xl mr-4"></i>
                  <div>
                    <p class="text-sm text-gray-600 mb-1">Dokumen Petugas Terlampir</p>
                    <a href="{{ Storage::url('dokumen_petugas/' . $laporan->dokumen_petugas) }}" 
                      target="_blank" 
                      class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                      <i class="fas fa-download mr-2"></i> Lihat Dokumen
                    </a>
                  </div>
                </div>
              </div>
              @endif
            </div>

            <div id="foto-group" style="display: none;">
              <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">Unggah Foto Bukti</label>
              <input type="file" name="foto_lanjutan" id="foto" accept="image/png, image/jpeg">
              <p class="mt-2 text-xs text-gray-500">
                Anda dapat mengunggah foto bukti pengerjaan atau survei di sini (JPG, PNG maks 3MB).
              </p>
            </div>

            <div>
              <label for="tingkat_kerusakan" class="block text-sm font-medium text-gray-700 mb-2">Tingkat Kerusakan</label>
              <select name="tingkat_kerusakan" id="tingkat_kerusakan" required
                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="ringan" {{ strtolower($laporan->tingkat_kerusakan) == 'ringan' ? 'selected' : '' }}>Ringan</option>
                <option value="sedang" {{ strtolower($laporan->tingkat_kerusakan) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                <option value="berat" {{ strtolower($laporan->tingkat_kerusakan) == 'berat' ? 'selected' : '' }}>Berat</option>
              </select>
            </div>

            <div>
              <label for="jenis_kerusakan" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kerusakan</label>
              <select name="jenis_kerusakan" id="jenis_kerusakan" required
                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="Lubang-lubang" {{ strtolower($laporan->jenis_kerusakan) == strtolower('Lubang-lubang') ? 'selected' : '' }}>Lubang-lubang</option>
                <option value="Ambles" {{ strtolower($laporan->jenis_kerusakan) == strtolower('Ambles') ? 'selected' : '' }}>Ambles</option>
                <option value="Retak buaya" {{ strtolower($laporan->jenis_kerusakan) == strtolower('Retak buaya') ? 'selected' : '' }}>Retak buaya</option>
                <option value="Permukaan tergerus" {{ strtolower($laporan->jenis_kerusakan) == strtolower('Permukaan tergerus') ? 'selected' : '' }}>Permukaan tergerus</option>
                <option value="Penurunan slab di sambungan" {{ strtolower($laporan->jenis_kerusakan) == strtolower('Penurunan slab di sambungan') ? 'selected' : '' }}>Penurunan slab di sambungan</option>
                <option value="Slab pecah/retak di sambungan" {{ strtolower($laporan->jenis_kerusakan) == strtolower('Slab pecah/retak di sambungan') ? 'selected' : '' }}>Slab pecah/retak di sambungan</option>
                <option value="Permukaan tidak rata" {{ strtolower($laporan->jenis_kerusakan) == strtolower('Permukaan tidak rata') ? 'selected' : '' }}>Permukaan tidak rata</option>
                <option value="Longsor" {{ strtolower($laporan->jenis_kerusakan) == strtolower('Longsor') ? 'selected' : '' }}>Longsor</option>
              </select>
            </div>
            <div class="pt-4">
              <button type="submit" id="submit-button"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Perubahan
              </button>
            </div>
          </form>
        </div>
        <div class="mt-6">
          {{-- Tombol Hapus (modalnya dipindah ke bawah) --}}
          <button data-modal-target="deleteModal-{{ $laporan->id_laporan }}"
            data-modal-toggle="deleteModal-{{ $laporan->id_laporan }}"
            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
              </path>
            </svg>
            Hapus Laporan
          </button>
        </div>
      </div>
    </div>
  </div>

  {{-- ==== PEMINDAHAN MODAL KE SINI ==== --}}
  {{-- Modal konfirmasi hapus --}}
  <div id="deleteModal-{{ $laporan->id_laporan }}" data-modal-target="deleteModal-{{ $laporan->id_laporan }}"
    data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black/40 z-40"></div>
    <div class="relative p-4 w-full max-w-2xl max-h-full z-50">
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
@endsection

@section('document.end')
  @vite('resources/js/leaflet.js')
  <script src="https://unpkg.com/filepond-plugin-file-validate-type@^1/dist/filepond-plugin-file-validate-type.js"></script>
  <script src="https://unpkg.com/filepond-plugin-file-validate-size@^2/dist/filepond-plugin-file-validate-size.js"></script>
  <script src="https://unpkg.com/filepond-plugin-image-preview@^4/dist/filepond-plugin-image-preview.js"></script>
  <script src="https://unpkg.com/filepond-plugin-image-exif-orientation@^1/dist/filepond-plugin-image-exif-orientation.js"></script>
  <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Fancybox dummy
      Fancybox.bind("[data-fancybox]", {});

      // Leaflet map
      if (window.L) {
        var map = L.map('map').setView([{{ $laporan->latitude }}, {{ $laporan->longitude }}], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 18,
          attribution: '© OpenStreetMap'
        }).addTo(map);

        var iconDummy = new L.Icon({
          iconUrl: '/image/map/yellow-dot.png',
          iconSize: [32, 32],
          iconAnchor: [16, 32],
          popupAnchor: [0, -32],
        });

        L.marker([{{ $laporan->latitude }}, {{ $laporan->longitude }}], { icon: iconDummy })
          .addTo(map)
          .bindPopup(
            `<div style="font-size:14px;">
              <b>ID:</b> {{ $laporan->id_laporan }}<br>
              <b>Status:</b> {{ $laporan->status->nama_status }}<br>
              <b>Alamat:</b> {{ $laporan->alamat_lengkap_kerusakan }}<br>
              <b>Keterangan:</b> {{ $laporan->keterangan ?? '-' }}
            </div>`
          );
      }

      // FilePond
      FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginFileValidateType,
        FilePondPluginFileValidateSize,
        FilePondPluginImageExifOrientation
      );
      const fotoInput = document.getElementById('foto');
      if (fotoInput) {
        FilePond.create(fotoInput, {
          labelIdle: `Seret & Lepas file atau <span class="filepond--label-action">Jelajahi</span>`,
          labelFileProcessingComplete: 'Upload Selesai',
          labelTapToUndo: 'ketuk untuk membatalkan',
          labelTapToCancel: 'ketuk untuk membatalkan',
          acceptedFileTypes: ['image/png', 'image/jpeg'],
          labelFileTypeNotAllowed: 'Jenis file tidak valid',
          fileValidateTypeLabelExpectedTypes: 'Hanya menerima file {allButLastType}, atau {lastType}',
          maxFileSize: '3MB',
          labelMaxFileSizeExceeded: 'File terlalu besar',
          labelMaxFileSize: 'Ukuran file maksimum adalah {filesize}',
          name: 'foto_lanjutan',
          server: null,
          storeAsFile: true,
        });
      }

      const dokumenPetugasInput = document.getElementById('dokumen_petugas');
      if (dokumenPetugasInput) {
        FilePond.create(dokumenPetugasInput, {
          labelIdle: `Seret & Lepas file atau <span class="filepond--label-action">Jelajahi</span>`,
          labelFileProcessingComplete: 'Upload Selesai',
          labelTapToUndo: 'ketuk untuk membatalkan',
          labelTapToCancel: 'ketuk untuk membatalkan',
          
          allowFileTypeValidation: false,
          acceptedFileTypes: ['application/pdf', '.pdf', 'application/msword', '.doc', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', '.docx'],
        
          labelFileTypeNotAllowed: 'Jenis file tidak valid. Hanya file PDF, DOC, dan DOCX yang diperbolehkan.',
          fileValidateTypeLabelExpectedTypes: 'Hanya menerima {allButLastType} atau {lastType}',
          maxFileSize: '10MB',
          labelMaxFileSizeExceeded: 'File terlalu besar',
          labelMaxFileSize: 'Ukuran file maksimum adalah {filesize}',
          name: 'dokumen_petugas',
          server: null,
          storeAsFile: true,
        });
      }

      // Conditional fields logic
      const statusSelect = document.getElementById('status');
      const keteranganGroup = document.getElementById('keterangan-group');
      const fotoGroup = document.getElementById('foto-group');

      const dokumenPetugasGroup = document.getElementById('dokumen-petugas-group');
      
      function toggleFields() {
        const dokumenPetugasRequiredStatuses = ['2', '3', '4', '5'];
        const allowedStatuses = ['2', '3', '4', '5', '7'];
        const isAllowed = allowedStatuses.includes(statusSelect.value);
        keteranganGroup.style.display = isAllowed ? 'block' : 'none';
        const photoRequiredStatuses = ['3', '4', '5'];
        const photoFieldIsVisible = photoRequiredStatuses.includes(statusSelect.value);
        fotoGroup.style.display = photoFieldIsVisible ? 'block' : 'none';

        // Tampilkan field dokumen petugas hanya untuk status tertentu
        const dokumenPetugasFieldIsVisible = dokumenPetugasRequiredStatuses.includes(statusSelect.value);
        dokumenPetugasGroup.style.display = dokumenPetugasFieldIsVisible ? 'block' : 'none';

        if (!isAllowed) {
          document.getElementById('keterangan').value = '';
        }
        if (!photoFieldIsVisible && window.FilePond && fotoInput && fotoInput._pond) {
          fotoInput._pond.removeFiles();
        }
        if (!dokumenPetugasFieldIsVisible && window.FilePond && dokumenPetugasInput && dokumenPetugasInput._pond) {
          dokumenPetugasInput._pond.removeFiles();
        }
      }
      statusSelect.addEventListener('change', toggleFields);
      toggleFields();

      // Modal (logic Anda sudah benar, tidak perlu diubah)
      document.querySelectorAll('[data-modal-toggle]').forEach(function (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const modalId = this.getAttribute('data-modal-toggle');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            }
        });
      });

      document.querySelectorAll('[data-modal-hide]').forEach(function (hideBtn) {
          hideBtn.addEventListener('click', function () {
              const modalId = this.getAttribute('data-modal-hide');
              const modal = document.getElementById(modalId);
              if (modal) {
                  modal.classList.add('hidden');
                  modal.classList.remove('flex');
                  document.body.classList.remove('overflow-hidden');
              }
          });
      });
    });
  </script>
@endsection