@extends('admin.layout')

@section('document.body')
  {{-- ===================== Ringkasan ===================== --}}
  <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
    <div class="bg-white rounded-lg shadow-lg border p-5">
      <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">Total Tercatat</span>
        <i class="fa-solid fa-database text-gray-500"></i>
      </div>
      <div class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($ringkasan['total']) }}</div>
    </div>

    <div class="bg-white rounded-lg shadow-lg border p-5">
      <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">Hari Ini</span>
        <i class="fa-solid fa-calendar-day text-indigo-500"></i>
      </div>
      <div class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($ringkasan['hari_ini']) }}</div>
    </div>

    <div class="bg-white rounded-lg shadow-lg border p-5">
      <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">Ditambah Hari Ini</span>
        <i class="fa-solid fa-circle-plus text-green-500"></i>
      </div>
      <div class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($ringkasan['tambah_hari_ini']) }}</div>
    </div>

    <div class="bg-white rounded-lg shadow-lg border p-5">
      <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">Diubah Hari Ini</span>
        <i class="fa-solid fa-pen-to-square text-blue-500"></i>
      </div>
      <div class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($ringkasan['ubah_hari_ini']) }}</div>
    </div>

    <div class="bg-white rounded-lg shadow-lg border p-5">
      <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">Dihapus Hari Ini</span>
        <i class="fa-solid fa-trash-can text-red-500"></i>
      </div>
      <div class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($ringkasan['hapus_hari_ini']) }}</div>
    </div>
  </div>

  {{-- ===================== Penyaring ===================== --}}
  <div class="bg-white rounded-lg shadow-lg border p-5 mt-6">
    <form method="GET" action="{{ route('admin.super.log.index') }}">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div>
          <label for="cari" class="block mb-1.5 text-sm font-medium text-gray-900">Cari</label>
          <input type="text" id="cari" name="cari" value="{{ $filter['cari'] ?? '' }}"
            placeholder="Nama data, pelaku, atau IP"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>

        <div>
          <label for="aksi" class="block mb-1.5 text-sm font-medium text-gray-900">Aksi</label>
          <select id="aksi" name="aksi"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value="">Semua aksi</option>
            @foreach (\App\Models\LogAktivitas::AKSI as $nilai => $label)
              <option value="{{ $nilai }}" @selected(($filter['aksi'] ?? '') === $nilai)>{{ $label }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label for="pelaku_tipe" class="block mb-1.5 text-sm font-medium text-gray-900">Pelaku</label>
          <select id="pelaku_tipe" name="pelaku_tipe"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value="">Semua pelaku</option>
            @foreach (\App\Models\LogAktivitas::PELAKU_TIPE as $nilai => $label)
              <option value="{{ $nilai }}" @selected(($filter['pelaku_tipe'] ?? '') === $nilai)>{{ $label }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label for="model" class="block mb-1.5 text-sm font-medium text-gray-900">Jenis Data</label>
          <select id="model" name="model"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value="">Semua jenis data</option>
            @foreach ($daftar_model as $kelas => $label)
              <option value="{{ $kelas }}" @selected(($filter['model'] ?? '') === $kelas)>{{ $label }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label for="tanggal_dari" class="block mb-1.5 text-sm font-medium text-gray-900">Dari Tanggal</label>
          <input type="date" id="tanggal_dari" name="tanggal_dari" value="{{ $filter['tanggal_dari'] ?? '' }}"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>

        <div>
          <label for="tanggal_sampai" class="block mb-1.5 text-sm font-medium text-gray-900">Sampai Tanggal</label>
          <input type="date" id="tanggal_sampai" name="tanggal_sampai" value="{{ $filter['tanggal_sampai'] ?? '' }}"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>
      </div>

      <div class="flex flex-wrap gap-2 mt-4">
        <button type="submit"
          class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 focus:outline-none font-medium rounded-lg text-sm px-3 py-2.5">
          <i class="fa-solid fa-filter me-1"></i>Terapkan Filter
        </button>
        @if ($ada_filter)
          <a href="{{ route('admin.super.log.index') }}"
            class="py-2.5 px-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 focus:outline-none">
            <i class="fa-solid fa-xmark me-1"></i>Bersihkan Filter
          </a>
        @endif
      </div>
    </form>
  </div>

  {{-- ===================== Daftar ===================== --}}
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5 bg-white">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
      <p class="text-sm text-gray-500">
        Menampilkan {{ number_format($log->firstItem() ?? 0) }}&ndash;{{ number_format($log->lastItem() ?? 0) }}
        dari {{ number_format($log->total()) }} catatan
      </p>
    </div>

    @if ($log->isEmpty())
      <div class="text-center py-12">
        <i class="fa-solid fa-clipboard-list text-gray-300 text-5xl mb-3"></i>
        <p class="text-gray-500">
          {{ $ada_filter ? 'Tidak ada catatan yang cocok dengan filter tersebut.' : 'Belum ada aktivitas yang tercatat.' }}
        </p>
      </div>
    @else
      <div class="relative overflow-x-auto text-sm">
        <table class="w-full text-left">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
              <th scope="col" class="px-4 py-3 whitespace-nowrap">Waktu</th>
              <th scope="col" class="px-4 py-3 whitespace-nowrap">Aksi</th>
              <th scope="col" class="px-4 py-3 whitespace-nowrap">Jenis Data</th>
              <th scope="col" class="px-4 py-3">Data</th>
              <th scope="col" class="px-4 py-3 whitespace-nowrap">Pelaku</th>
              <th scope="col" class="px-4 py-3 whitespace-nowrap">IP</th>
              <th scope="col" class="px-4 py-3 whitespace-nowrap">Rincian</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($log as $item)
              <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-3 whitespace-nowrap text-gray-600">
                  {{ $item->created_at?->translatedFormat('d M Y') }}<br>
                  <span class="text-xs text-gray-400">{{ $item->created_at?->format('H:i:s') }} WITA</span>
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                  <span class="inline-block px-2 py-1 rounded text-xs font-medium {{ $item->warnaAksi() }}">
                    {{ $item->labelAksi() }}
                  </span>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-gray-900">{{ $item->model_label }}</td>
                <td class="px-4 py-3">
                  <span class="text-gray-900">{{ $item->record_label ?? '—' }}</span>
                  <span class="text-xs text-gray-400 block">#{{ $item->record_id }}</span>
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                  <span class="text-gray-900">{{ $item->namaPelakuTampil() }}</span>
                  <span class="text-xs text-gray-400 block">{{ $item->labelPelakuTipe() }}</span>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $item->ip_address ?? '—' }}</td>
                <td class="px-4 py-3 whitespace-nowrap">
                  <a href="{{ route('admin.super.log.show', $item->id) }}"
                    class="inline-flex items-center gap-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 focus:outline-none rounded-lg text-xs font-medium px-2.5 py-2">
                    <i class="fa-solid fa-eye"></i>
                    {{ $item->jumlahPerubahan() }} kolom
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="mt-5">
        {{ $log->links() }}
      </div>
    @endif
  </div>
@endsection
