@extends('admin.layout')

@section('title', 'Hapus Pesanan')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Hapus Pesanan</h1>

    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <p>Apakah kamu yakin ingin menghapus pesanan ini?</p>
        <p><strong>{{ $data->nama }}</strong> (Tanggal Pesan: {{ $data->created_at->format('d-m-Y') }})</p>
    </div>

    <form action="{{ route('admin.sedot-tinja.destroy', $data->id) }}" method="POST" class="flex items-center gap-4">
        @csrf
        @method('DELETE')

        <button type="submit" 
                class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded shadow">
            Ya, Hapus
        </button>

        <a href="{{ route('admin.sedot-tinja.data-pesanan') }}" 
           class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow">
            Batal
        </a>
    </form>
</div>
@endsection
