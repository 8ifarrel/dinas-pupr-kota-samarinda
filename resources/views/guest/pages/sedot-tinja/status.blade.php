@extends('guest.layouts.sedottinja') 

@section('content')
<div class="min-h-screen py-10 px-4 bg-gray-50">
  <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow p-8">

    <h1 class="text-2xl font-bold mb-6 text-center">Cek Status Layanan Sedot Tinja</h1>

    {{-- Form pencarian --}}
    <form method="GET" action="{{ route('guest.sedot-tinja.status') }}" class="mb-8 flex gap-3">
      <input type="text" name="nomor_telepon_pelanggan" value="{{ request('nomor_telepon_pelanggan') }}" 
             placeholder="Masukkan Nomor Telepon Anda"
             class="flex-1 border rounded-lg px-3 py-2" required>
      <button type="submit" 
              class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
        Cari
      </button>
    </form>

    @if(isset($result))
      @if($result->isEmpty())
        <p class="text-center text-gray-600">Tidak ada data ditemukan untuk nomor telepon tersebut.</p>
      @else
        <div class="overflow-x-auto">
          <table class="w-full border rounded-lg">
            <thead class="bg-blue-900 text-white">
              <tr>
                <th class="px-4 py-3 text-left">Tanggal</th>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">Alamat</th>
                <th class="px-4 py-3 text-left">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($result as $item)
                <tr class="odd:bg-white even:bg-gray-50">
                  <td class="px-4 py-3">{{ $item->created_at->format('d M Y') }}</td>
                  <td class="px-4 py-3">{{ $item->nama_pelanggan }}</td>
                  <td class="px-4 py-3">{{ $item->alamat }}</td>
                  <td class="px-4 py-3">
                    @if($item->status_pengerjaan === 'Belum dikerjakan')
                      <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">
                        {{ $item->status_pengerjaan }}
                      </span>
                    @elseif($item->status_pengerjaan === 'Sedang dikerjakan')
                      <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                        {{ $item->status_pengerjaan }}
                      </span>
                    @else
                      <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                        {{ $item->status_pengerjaan }}
                      </span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    @endif

  </div>
</div>
@endsection
