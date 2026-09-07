@extends('guest.layouts.main')

@section('document.body')
  <div class="py-5 md:py-12 px-6 lg:px-24 3xl:px-48">
    <nav aria-label="Breadcrumb" class="max-w-4xl mx-auto mb-2.5">
      <ol class="inline-flex items-center text-sm">
        <li class="inline-flex items-center">
          <a href="{{ route('guest.beranda.index') }}" class="text-blue-600 underline">Beranda</a>
        </li>
        <li>
          <div class="flex items-center">
            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
            </svg>
            <a href="{{ route('guest.silalad.index') }}" class="text-blue-600 underline">SILALAD</a>
          </div>
        </li>
        <li aria-current="page">
          <div class="flex items-center">
            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
            </svg>
            <span class="text-gray-500 font-medium">Cek Status</span>
          </div>
        </li>
      </ol>
    </nav>

    <div class="max-w-4xl mx-auto space-y-6">
      {{-- Kotak Pencarian --}}
      <div class="bg-white rounded-lg shadow-lg border p-6">
        <h1 class="text-xl md:text-2xl font-bold mb-1 text-center">Cek Status Pesanan SILALAD</h1>
        <p class="text-sm text-gray-600 text-center mb-4">
          Masukkan nomor telepon yang Anda pakai saat mendaftar.
        </p>

        <form method="GET" action="{{ route('guest.silalad.status') }}" class="flex flex-col sm:flex-row gap-3">
          <div class="flex-1 space-y-1.5">
            <label for="nomor_telepon_pelanggan" class="sr-only">Nomor Telepon</label>
            <input type="text" name="nomor_telepon_pelanggan" id="nomor_telepon_pelanggan"
              value="{{ request('nomor_telepon_pelanggan') }}" placeholder="Masukkan nomor telepon Anda"
              class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
          </div>
          <button type="submit"
            class="inline-flex justify-center items-center gap-1.5 px-6 py-2.5 bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue text-white text-sm font-semibold rounded-lg transition">
            <i class="fa-solid fa-magnifying-glass"></i> Cari
          </button>
        </form>

        @if (request()->filled('nomor_telepon_pelanggan'))
          <div class="mt-6 pt-6 border-t">
            <h2 class="text-lg font-bold mb-4 text-gray-900">Riwayat Pendaftaran</h2>

            <div class="bg-gray-50 rounded-lg border p-4 mb-4">
              <form method="GET" action="{{ route('guest.silalad.status') }}"
                class="flex flex-col sm:flex-row sm:flex-wrap sm:items-end gap-3">
                <input type="hidden" name="nomor_telepon_pelanggan" value="{{ request('nomor_telepon_pelanggan') }}">
                <div class="w-full sm:w-auto">
                  <label for="filter_status" class="block text-sm font-medium text-gray-700 mb-1">Status Pesanan</label>
                  <select name="status" id="filter_status"
                    class="w-full sm:w-auto border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option value="">-- Semua Status --</option>
                    @foreach ($statusList as $s)
                      <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="w-full sm:w-auto">
                  <label for="filter_month" class="block text-sm font-medium text-gray-700 mb-1">Bulan Pendaftaran</label>
                  <select name="month" id="filter_month"
                    class="w-full sm:w-auto border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option value="">-- Semua Bulan --</option>
                    @foreach (range(1, 12) as $m)
                      <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="w-full sm:w-auto">
                  <label for="filter_year" class="block text-sm font-medium text-gray-700 mb-1">Tahun Pendaftaran</label>
                  <select name="year" id="filter_year"
                    class="w-full sm:w-auto border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option value="">-- Semua Tahun --</option>
                    @foreach ($years as $year)
                      <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                  </select>
                </div>
                <button type="submit"
                  class="w-full sm:w-auto justify-center inline-flex items-center gap-1.5 text-sm font-medium text-white bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue rounded-lg px-4 py-2.5 transition">
                  <i class="fa-solid fa-filter"></i> Terapkan Filter
                </button>
                @if (request()->filled('status') || request()->filled('year') || request()->filled('month'))
                  <a href="{{ route('guest.silalad.status', ['nomor_telepon_pelanggan' => request('nomor_telepon_pelanggan')]) }}"
                    class="w-full sm:w-auto justify-center inline-flex items-center gap-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg px-4 py-2.5">
                    <i class="fa-solid fa-xmark"></i> Reset Filter
                  </a>
                @endif
              </form>
            </div>

            <p class="text-sm text-gray-600 mb-3">
              Ditemukan <span class="font-semibold text-gray-900">{{ $history->total() }}</span> pesanan
              @if (request()->filled('status') || request()->filled('year') || request()->filled('month'))
                dengan filter:
                @if (request()->filled('status'))
                  <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ request('status') }}</span>
                @endif
                @if (request()->filled('month'))
                  <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ \Carbon\Carbon::create()->month(request('month'))->translatedFormat('F') }}</span>
                @endif
                @if (request()->filled('year'))
                  <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ request('year') }}</span>
                @endif
              @endif
            </p>

            @if ($history->isEmpty())
              <p class="text-sm text-gray-500">Tidak ada pesanan yang cocok dengan filter di atas.</p>
            @else
              <div class="overflow-x-auto">
                <table class="w-full border rounded-lg text-sm">
                  <thead class="bg-brand-blue text-white">
                    <tr>
                      <th class="px-3 py-2 text-left">Kode Booking</th>
                      <th class="px-3 py-2 text-left">Tanggal</th>
                      <th class="px-3 py-2 text-left">Nama</th>
                      <th class="px-3 py-2 text-left whitespace-nowrap">Status</th>
                      <th class="px-3 py-2 text-left whitespace-nowrap">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y">
                    @foreach ($history as $item)
                      <tr class="odd:bg-white even:bg-gray-50">
                        <td class="px-3 py-2 font-semibold text-brand-blue">{{ $item->kode_booking ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $item->created_at->format('d M Y') }}</td>
                        <td class="px-3 py-2">{{ $item->nama_pelanggan }}</td>
                        <td class="px-3 py-2 whitespace-nowrap">
                          @php
                            $badge = match ($item->status_pengerjaan) {
                                'Menunggu konfirmasi' => 'bg-yellow-100 text-yellow-800',
                                'Dijadwalkan' => 'bg-indigo-100 text-indigo-800',
                                'Sedang dikerjakan' => 'bg-blue-100 text-blue-800',
                                'Dibatalkan' => 'bg-red-100 text-red-800',
                                default => 'bg-green-100 text-green-800',
                            };
                          @endphp
                          <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium whitespace-nowrap {{ $badge }}">
                            {{ $item->status_pengerjaan }}
                          </span>
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap">
                          <a href="{{ route('guest.silalad.show', $item->id) }}?nomor_telepon_pelanggan={{ urlencode(request('nomor_telepon_pelanggan')) }}"
                            class="text-blue-600 hover:underline whitespace-nowrap">
                            Lihat Detail
                          </a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              <div class="mt-4">
                {{ $history->onEachSide(1)->links() }}
              </div>
            @endif
          </div>
        @endif
      </div>

    </div>
  </div>
@endsection
