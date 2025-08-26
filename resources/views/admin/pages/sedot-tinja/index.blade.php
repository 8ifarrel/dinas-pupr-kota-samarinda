@extends('admin.layouts.app')

@section('title', 'Riwayat Laporan Sedot Tinja')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Riwayat Laporan Sedot Tinja</h1>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel daftar laporan --}}
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-left">No</th>
                    <th class="border px-4 py-2 text-left">ID Pesanan</th>
                    <th class="border px-4 py-2 text-left">Nama</th>
                    <th class="border px-4 py-2 text-left">Alamat</th>
                    <th class="border px-4 py-2 text-left">Status</th>
                    <th class="border px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $key => $item)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $item->id_pesanan }}</td>
                        <td class="border px-4 py-2">{{ $item->nama_pelanggan }}</td>
                        <td class="border px-4 py-2">{{ $item->alamat }}</td>
                        <td class="border px-4 py-2">
                            <span class="px-2 py-1 text-sm rounded 
                                {{ $item->status == 'Selesai' ? 'bg-green-200 text-green-700' : 'bg-yellow-200 text-yellow-700' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="border px-4 py-2 text-center space-x-2">
                            <a href="{{ route('admin.sedot-tinja.show', $item->id) }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">Lihat</a>
                            <a href="{{ route('admin.sedot-tinja.edit', $item->id) }}" 
                               class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">Edit</a>
                            <form action="{{ route('admin.sedot-tinja.destroy', $item->id) }}" 
                                  method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">
                            Belum ada laporan yang masuk
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
