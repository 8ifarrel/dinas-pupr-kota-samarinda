@extends('admin.layouts.app')

@section('title', 'Detail Laporan Sedot Tinja')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Detail Laporan Sedot Tinja</h1>

    <div class="bg-white p-6 border rounded shadow space-y-3 text-sm leading-relaxed">
        <p><strong>Nama:</strong> {{ $data->nama_pelanggan }}</p>
        <p><strong>Telepon:</strong> {{ $data->nomor_telepon_pelanggan }}</p>
        <p><strong>Alamat:</strong> {{ $data->alamat }}</p>
        <p><strong>Longitude:</strong> {{ $data->longitude ?? '-' }}</p>
        <p><strong>Latitude:</strong> {{ $data->latitude ?? '-' }}</p>
        <p><strong>Status:</strong> 
            <span class="px-2 py-1 rounded 
                {{ $data->status == 'Selesai' ? 'bg-green-200 text-green-700' : 'bg-yellow-200 text-yellow-700' }}">
                {{ $data->status }}
            </span>
        </p>
        <p><strong>Dibuat pada:</strong> {{ $data->created_at->format('d-m-Y H:i') }}</p>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('admin.sedot-tinja.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            Kembali
        </a>
        <a href="{{ route('admin.sedot-tinja.edit', $data->id) }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Edit
        </a>
    </div>
</div>
@endsection
