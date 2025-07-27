@extends('admin.layouts.app')

@section('title', 'Data LPSE')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">📦 Daftar Paket LPSE</h1>
        <a href="{{ route('admin.lpse.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Tambah LPSE
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        @if($lpses->count())
        <table class="min-w-full text-sm text-center border">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Kode Paket</th>
                    <th class="px-4 py-2 border text-left">Nama Paket</th>
                    <th class="px-4 py-2 border">Jenis Paket</th>
                    <th class="px-4 py-2 border">URL</th>
                    <th class="px-4 py-2 border">Nilai</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($lpses as $lpse)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border">{{ $lpse->kode_paket }}</td>
                    <td class="px-4 py-2 border text-left">{{ $lpse->nama_paket }}</td>
                    <td class="px-4 py-2 border">{{ $lpse->jenis_paket }}</td>
                    <td class="px-4 py-2 border">
                        <a href="{{ $lpse->url_informasi_paket }}" target="_blank"
                           class="text-blue-600 underline hover:text-blue-800">
                            Lihat
                        </a>
                    </td>
                    <td class="px-4 py-2 border">
                        Rp {{ number_format($lpse->nilai, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-2 border space-x-1">
                        <a href="{{ route('admin.lpse.edit', $lpse->id) }}"
                           class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 text-sm">
                            Edit
                        </a>
                        <form action="{{ route('admin.lpse.destroy', $lpse->id) }}"
                              method="POST" class="inline-block"
                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center text-gray-500 py-10">
            <h2 class="text-lg font-semibold">Belum ada data LPSE</h2>
            <p>Klik tombol “Tambah LPSE” untuk menambahkan data baru.</p>
        </div>
        @endif
    </div>
</div>
@endsection
