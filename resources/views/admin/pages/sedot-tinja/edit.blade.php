@extends('admin.layouts.app')

@section('title', $page_title)

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">{{ $page_title }}</h1>
    <p class="mb-6 text-gray-600">{{ $page_description }}</p>

    <form action="{{ route('admin.sedot-tinja.update', $data->id) }}" 
          method="POST" 
          class="bg-white p-6 border rounded-lg shadow-md space-y-4">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div>
            <label class="block font-medium mb-1">Nama</label>
            <input type="text" name="nama_pelanggan" 
                   value="{{ old('nama_pelanggan', $data->nama_pelanggan) }}" 
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300" required>
            @error('nama_pelanggan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nomor Telepon --}}
        <div>
            <label class="block font-medium mb-1">Nomor Telepon</label>
            <input type="text" name="nomor_telepon_pelanggan" 
                   value="{{ old('nomor_telepon_pelanggan', $data->nomor_telepon_pelanggan) }}" 
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300" required>
            @error('nomor_telepon_pelanggan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Alamat --}}
        <div>
            <label class="block font-medium mb-1">Alamat</label>
            <textarea name="alamat" rows="3"
                      class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300" required>{{ old('alamat', $data->alamat) }}</textarea>
            @error('alamat')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Longitude --}}
        <div>
            <label class="block font-medium mb-1">Longitude</label>
            <input type="text" name="longitude" 
                   value="{{ old('longitude', $data->longitude) }}" 
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
            @error('longitude')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Latitude --}}
        <div>
            <label class="block font-medium mb-1">Latitude</label>
            <input type="text" name="latitude" 
                   value="{{ old('latitude', $data->latitude) }}" 
                   class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
            @error('latitude')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center space-x-3">
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg">
                Simpan
            </button>
            <a href="{{ route('admin.sedot-tinja.index') }}" 
               class="text-blue-600 hover:underline">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
