@extends('admin.layouts.app')

@section('title', 'Edit LPSE')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-xl max-w-2xl mx-auto p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Edit LPSE</h2>

        <form action="{{ route('admin.lpse.update', $lpse->id) }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="kode_paket" class="block text-sm font-medium text-gray-700 mb-1">Kode Paket</label>
                    <input type="text" name="kode_paket" id="kode_paket" value="{{ old('kode_paket', $lpse->kode_paket) }}"
                        class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                        required>
                </div>

                <div>
                    <label for="nama_paket" class="block text-sm font-medium text-gray-700 mb-1">Nama Paket</label>
                    <input type="text" name="nama_paket" id="nama_paket" value="{{ old('nama_paket', $lpse->nama_paket) }}"
                        class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                        required>
                </div>

                <div>
                    <label for="jenis_paket" class="block text-sm font-medium text-gray-700 mb-1">Jenis Paket</label>
                    <select name="jenis_paket" id="jenis_paket"
                        class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                        required>
                        <option value="">-- Pilih Jenis --</option>
                        @foreach (['Jasa Konstruksi', 'Pengadaan Barang', 'Konsultasi', 'Jasa Lainnya', 'Non Tender'] as $jenis)
                            <option value="{{ $jenis }}" {{ old('jenis_paket', $lpse->jenis_paket) == $jenis ? 'selected' : '' }}>
                                {{ $jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="url_informasi_paket" class="block text-sm font-medium text-gray-700 mb-1">URL Informasi Paket</label>
                    <input type="url" name="url_informasi_paket" id="url_informasi_paket"
                        value="{{ old('url_informasi_paket', $lpse->url_informasi_paket) }}"
                        class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                        required>
                </div>

                <div>
                    <label for="nilai" class="block text-sm font-medium text-gray-700 mb-1">Nilai (Rp)</label>
                    <input type="number" name="nilai" id="nilai" value="{{ old('nilai', $lpse->nilai) }}"
                        class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                        required>
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('admin.lpse.index') }}"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-lg">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
