@extends('admin.layout')

@section('document.body')
  <a href="{{ url()->previous() }}"
    class="inline-flex items-center py-2.5 px-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 focus:outline-none">
    <i class="fa-solid fa-arrow-left me-1.5"></i>Kembali
  </a>

  {{-- ===================== Ringkasan Kejadian ===================== --}}
  <div class="bg-white rounded-lg shadow-lg border p-6 mt-5">
    <div class="flex flex-wrap items-center gap-3 mb-5">
      <span class="inline-block px-3 py-1 rounded text-sm font-semibold {{ $item->warnaAksi() }}">
        {{ $item->labelAksi() }}
      </span>
      <h3 class="font-semibold text-gray-900 text-lg">
        {{ $item->model_label }}
        <span class="text-gray-400 font-normal">#{{ $item->record_id }}</span>
      </h3>
    </div>

    <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4 text-sm">
      <div>
        <dt class="text-gray-500">Nama Data</dt>
        <dd class="text-gray-900 font-medium mt-0.5">{{ $item->record_label ?? '—' }}</dd>
      </div>
      <div>
        <dt class="text-gray-500">Waktu</dt>
        <dd class="text-gray-900 font-medium mt-0.5">
          {{ $item->created_at?->translatedFormat('d F Y, H:i:s') }} WITA
        </dd>
      </div>
      <div>
        <dt class="text-gray-500">Pelaku</dt>
        <dd class="text-gray-900 font-medium mt-0.5">
          {{ $item->namaPelakuTampil() }}
          @if ($item->pelaku_username)
            <span class="text-gray-400 font-normal">({{ $item->pelaku_username }})</span>
          @endif
        </dd>
      </div>
      <div>
        <dt class="text-gray-500">Jenis Pelaku</dt>
        <dd class="text-gray-900 font-medium mt-0.5">{{ $item->labelPelakuTipe() }}</dd>
      </div>
      <div>
        <dt class="text-gray-500">Alamat IP</dt>
        <dd class="text-gray-900 font-medium mt-0.5">{{ $item->ip_address ?? '—' }}</dd>
      </div>
      <div>
        <dt class="text-gray-500">Metode</dt>
        <dd class="text-gray-900 font-medium mt-0.5">{{ $item->metode ?? '—' }}</dd>
      </div>
      <div class="sm:col-span-2 lg:col-span-3">
        <dt class="text-gray-500">Alamat Halaman</dt>
        <dd class="text-gray-900 font-medium mt-0.5 break-all">{{ $item->url ?? '—' }}</dd>
      </div>
      <div class="sm:col-span-2 lg:col-span-3">
        <dt class="text-gray-500">Kelas Model</dt>
        <dd class="text-gray-600 mt-0.5 break-all font-mono text-xs">{{ $item->model }}</dd>
      </div>
      @if ($item->user_agent)
        <div class="sm:col-span-2 lg:col-span-3">
          <dt class="text-gray-500">Perangkat / Peramban</dt>
          <dd class="text-gray-600 mt-0.5 break-all text-xs">{{ $item->user_agent }}</dd>
        </div>
      @endif
    </dl>
  </div>

  {{-- ===================== Rincian Perubahan ===================== --}}
  <div class="bg-white rounded-lg shadow-lg border p-6 mt-6">
    <h3 class="font-semibold text-gray-900 mb-1">
      @if ($item->aksi === 'ubah')
        Kolom yang Berubah
      @elseif ($item->aksi === 'hapus')
        Isi Data Saat Dihapus
      @else
        Isi Data
      @endif
    </h3>
    <p class="text-xs text-gray-400 mb-4">
      Kata sandi dan kunci API sengaja tidak pernah disimpan di log, sehingga tampil sebagai tanda titik.
    </p>

    @if (!$item->perubahan)
      <p class="text-sm text-gray-500">Tidak ada rincian yang tercatat.</p>
    @elseif ($item->aksi === 'ubah')
      <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
              <th scope="col" class="px-4 py-3 whitespace-nowrap">Kolom</th>
              <th scope="col" class="px-4 py-3">Sebelum</th>
              <th scope="col" class="px-4 py-3">Sesudah</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($item->perubahan as $kolom => $nilai)
              <tr class="border-b align-top">
                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">{{ $kolom }}</td>
                <td class="px-4 py-3 text-red-700 bg-red-50 break-words">
                  {{ $nilai['dari'] === null || $nilai['dari'] === '' ? '—' : $nilai['dari'] }}
                </td>
                <td class="px-4 py-3 text-green-700 bg-green-50 break-words">
                  {{ $nilai['menjadi'] === null || $nilai['menjadi'] === '' ? '—' : $nilai['menjadi'] }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
              <th scope="col" class="px-4 py-3 whitespace-nowrap">Kolom</th>
              <th scope="col" class="px-4 py-3">Nilai</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($item->perubahan as $kolom => $nilai)
              <tr class="border-b align-top">
                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">{{ $kolom }}</td>
                <td class="px-4 py-3 text-gray-700 break-words">
                  {{ $nilai === null || $nilai === '' ? '—' : (is_array($nilai) ? json_encode($nilai, JSON_UNESCAPED_UNICODE) : $nilai) }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>

  {{-- ===================== Riwayat Data yang Sama ===================== --}}
  <div class="bg-white rounded-lg shadow-lg border p-6 mt-6">
    <h3 class="font-semibold text-gray-900 mb-1">Riwayat Lain pada Data Ini</h3>
    <p class="text-xs text-gray-400 mb-4">
      Perubahan lain yang pernah terjadi pada {{ $item->model_label }} #{{ $item->record_id }}, terbaru di atas.
    </p>

    @if ($riwayat_record->isEmpty())
      <p class="text-sm text-gray-500">Tidak ada catatan lain pada data ini.</p>
    @else
      <div class="space-y-2">
        @foreach ($riwayat_record as $riwayat)
          <a href="{{ route('admin.super.log.show', $riwayat->id) }}"
            class="flex flex-wrap items-center gap-3 border rounded-lg p-3 hover:bg-gray-50">
            <span class="inline-block px-2 py-1 rounded text-xs font-medium {{ $riwayat->warnaAksi() }}">
              {{ $riwayat->labelAksi() }}
            </span>
            <span class="text-sm text-gray-600">
              {{ $riwayat->created_at?->translatedFormat('d M Y, H:i:s') }} WITA
            </span>
            <span class="text-sm text-gray-900">oleh {{ $riwayat->namaPelakuTampil() }}</span>
            <span class="text-xs text-gray-400 ms-auto">{{ $riwayat->jumlahPerubahan() }} kolom</span>
          </a>
        @endforeach
      </div>
    @endif
  </div>
@endsection
