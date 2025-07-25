@extends('layouts.admin')

@section('title', 'Daftar Paket LPSE')

@section('content')
<div class="p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Daftar Paket LPSE</h2>

    <a href="{{ route('lpse.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        + Tambah LPSE
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full border text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-xs uppercase">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Kode Paket</th>
                    <th class="px-4 py-2">Nama Paket</th>
                    <th class="px-4 py-2">Jenis Paket</th>
                    <th class="px-4 py-2">URL</th>
                    <th class="px-4 py-2">Nilai</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lpse as $key => $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $key + 1 }}</td>
                    <td class="px-4 py-2">{{ $item->kode_paket }}</td>
                    <td class="px-4 py-2">{{ $item->nama_paket }}</td>
                    <td class="px-4 py-2">{{ $item->jenis_paket }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ $item->url }}" class="text-blue-600 hover:underline" target="_blank">Lihat</a>
                    </td>
                    <td class="px-4 py-2">Rp {{ number_format($item->nilai, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('lpse.edit', $item->id) }}" class="text-indigo-600 hover:underline">Edit</a>
                        <form action="{{ route('lpse.destroy', $item->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin ingin menghapus?')" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-gray-500">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection