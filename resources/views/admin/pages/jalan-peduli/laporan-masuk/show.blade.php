@extends('admin.layout')

@section('document.head')
@endsection

@section('document.body')
  <div class="bg-white p-6 md:p-8 rounded-xl shadow-xl">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
      <div class="lg:col-span-2">
        <div class="flex justify-between mb-4 text-gray-500">
          <span>ID Laporan: <strong>{{ $laporan->id_laporan }}</strong></span>
          <span class="text-gray-600">
            Diajukan pada
            <strong>
              {{ $laporan->created_at ? \Carbon\Carbon::parse($laporan->created_at)->locale('id')->translatedFormat('l, d F Y (H:i)') : '-' }}
            </strong>
          </span>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ $laporan->alamat_lengkap_kerusakan }}</h2>
        <p class="text-base text-gray-600 mb-5 leading-relaxed">
          RT {{ $laporan->rt ?? '-' }}
          {{ $laporan->kelurahan ? 'Kelurahan ' . ($laporan->kelurahan->nama ?? $laporan->kelurahan->nama_kelurahan) . ',' : '' }}
          {{ $laporan->kecamatan ? 'Kecamatan ' . ($laporan->kecamatan->nama ?? $laporan->kecamatan->nama_kecamatan) : '' }}
        </p>

        @if ($laporan->link_koordinat)
        <div class="mb-6">
          <a href="{{ $laporan->link_koordinat }}" target="_blank"
            class="inline-flex items-center px-4 py-2 text-blue-600 bg-blue-50 border border-blue-300 rounded-lg shadow-sm hover:bg-blue-100 transition duration-200 ease-in-out transform hover:-translate-y-0.5">
            <i class="fas fa-map-marked-alt mr-3 text-lg"></i>
            <span class="font-semibold">Lihat Lokasi di Google Maps</span>
          </a>
        </div>
        @endif

        <div class="mb-8">
          <h4 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Deskripsi Laporan</h4>
          <p class="text-gray-700 mb-8 bg-gray-50 p-4 rounded-lg leading-relaxed">{{ $laporan->deskripsi_laporan }}</p>
        </div>

        <div class="mb-8">
          <h4 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Foto Kerusakan</h4>
          <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
            @foreach ($fotoArray as $foto)
              <a href="{{ asset('storage/jalan_peduli/' . $laporan->id_laporan . '/' . $foto) }}" target="_blank" title="Lihat Gambar Penuh">
                <img src="{{ asset('storage/jalan_peduli/' . $laporan->id_laporan . '/' . $foto) }}" alt="Foto Kerusakan"
                  class="w-full h-[100px] object-cover rounded-md border border-gray-200 transition-transform duration-200 ease-in-out hover:scale-105 hover:shadow-md" />
              </a>
            @endforeach
          </div>
        </div>

        @if ($embedUrl)
        <div class="mb-8">
          <h4 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Lokasi Peta</h4>
          <div class="mb-8">
            <iframe
              src="{{ $embedUrl }}"
              allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
              class="w-full h-[300px] border-0 rounded-lg"></iframe>
          </div>
        </div>
        @endif
      </div>

      <div class="lg:col-span-1">
        <div class="bg-gray-50 border border-gray-200 p-6 rounded-xl sticky top-[80px]">
          <h4 class="text-lg font-semibold text-gray-800 mb-5 text-center border-b border-gray-200 pb-2">Info Laporan
          </h4>

          <div class="text-center mb-6">
            @php
              $statusId = $laporan->status_id;
              $statusNama = strtolower($laporan->status->nama_status ?? '-');
              if ($statusId == 1) {
                  $statusClass = 'bg-yellow-100 text-yellow-800';
                  $icon = 'fa-hourglass-half';
                  $label = 'Pending';
              } elseif (in_array($statusId, [2,3,4,5,7])) {
                  $statusClass = 'bg-green-100 text-green-800';
                  $icon = 'fa-check-circle';
                  $label = 'Accept';
              } elseif ($statusId == 6) {
                  $statusClass = 'bg-red-100 text-red-800';
                  $icon = 'fa-times-circle';
                  $label = 'Reject';
              } else {
                  $statusClass = 'bg-gray-100 text-gray-800';
                  $icon = 'fa-info-circle';
                  $label = ucwords(str_replace('_', ' ', $statusNama));
              }
            @endphp
            <span class="inline-flex items-center font-semibold rounded-full px-5 py-2 {{ $statusClass }} text-base">
              <i class="fas {{ $icon }} mr-2 text-base"></i>
              <span class="font-medium">{{ $label }}</span>
            </span>
          </div>

          <div class="text-sm text-gray-600 space-y-4">
            <div class="mb-3">
              <p><strong class="block mb-1 text-gray-700">Tingkat Kerusakan</strong>{{ $laporan->tingkat_kerusakan ?? '-' }}</p>
            </div>
            <div class="mb-3">
              <p><strong class="block mb-1 text-gray-700">Jenis Kerusakan</strong>{{ $laporan->jenis_kerusakan ?? '-' }}</p>
            </div>

            @if (!empty($laporan->keterangan))
            <div class="pt-4 border-t border-gray-200">
              <p class="font-semibold text-gray-700 mb-1.5">Keterangan Disposisi:</p>
              <p class="bg-purple-50 text-purple-700 italic p-3 rounded-md mt-2">{{ $laporan->keterangan }}</p>
            </div>
            @endif

            @if (!empty($laporan->feedback))
            <div class="pt-4 border-t border-gray-200">
              <p class="font-semibold text-gray-700 mb-1.5">Feedback Pelapor:</p>
              <p class="italic text-gray-700">{{ $laporan->feedback }}</p>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white p-6 md:p-8 rounded-xl shadow-xl mt-8">
    <h3 class="text-xl font-bold text-gray-800 mb-5 flex items-center">
      <i class="fas fa-network-wired mr-3 text-xl text-gray-600"></i>
      Riwayat IP Laporan Ini
    </h3>

    <div class="overflow-x-auto rounded-lg shadow-md">
      <table class="min-w-full leading-normal rounded-lg overflow-hidden">
        <thead class="bg-gray-50">
          <tr>
            <th class="text-left text-xs font-medium text-gray-500 uppercase px-4 py-3">IP Address</th>
            <th class="text-left text-xs font-medium text-gray-500 uppercase px-4 py-3">Lokasi</th>
            <th class="text-left text-xs font-medium text-gray-500 uppercase px-4 py-3">Waktu</th>
            <th class="text-left text-xs font-medium text-gray-500 uppercase px-4 py-3">Latitude</th>
            <th class="text-left text-xs font-medium text-gray-500 uppercase px-4 py-3">Longitude</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @forelse ($ipLogs as $log)
          <tr>
            <td class="font-mono text-sm px-4 py-3 whitespace-nowrap">{{ $log->ip_address }}</td>
            <td class="text-sm text-gray-600 px-4 py-3">
              @if($log->kota || $log->provinsi)
                {{ $log->kota }}{{ $log->kota && $log->provinsi ? ', ' : '' }}{{ $log->provinsi }}
              @else
                <span class="text-gray-400">Tidak diketahui</span>
              @endif
            </td>
            <td class="text-sm px-4 py-3 whitespace-nowrap">{{ $log->created_at ? \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') : '-' }}</td>
            <td class="text-sm px-4 py-3">{{ $log->latitude ?? '-' }}</td>
            <td class="text-sm px-4 py-3">{{ $log->longitude ?? '-' }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center py-8 px-6 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 text-gray-500">
              Tidak ada riwayat IP untuk laporan ini.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection

@section('document.end')
@endsection
