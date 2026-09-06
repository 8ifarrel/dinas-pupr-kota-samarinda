@extends('admin.layout')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">Update Status Pesanan</h2>

    <form action="{{ route('admin.sedot-tinja.update-status', $sedotTinja->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="status_pengerjaan" class="block text-sm font-medium text-gray-700">Status Pengerjaan</label>
            <select name="status_pengerjaan" id="status_pengerjaan" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="Belum dikerjakan" {{ $sedotTinja->status_pengerjaan == 'Belum dikerjakan' ? 'selected' : '' }}>Belum dikerjakan</option>
                <option value="Sedang dikerjakan" {{ $sedotTinja->status_pengerjaan == 'Sedang dikerjakan' ? 'selected' : '' }}>Sedang dikerjakan</option>
                <option value="Sudah dikerjakan" {{ $sedotTinja->status_pengerjaan == 'Sudah dikerjakan' ? 'selected' : '' }}>Sudah dikerjakan</option>
                <option value="Dibatalkan" {{ $sedotTinja->status_pengerjaan == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            @error('status_pengerjaan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update Status
            </button>
            <a href="{{ url()->previous() }}" class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-100">Batal</a>
        </div>
    </form>
</div>
@endsection
