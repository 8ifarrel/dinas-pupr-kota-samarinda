@extends('admin.layout')

@section('title', 'Detail Laporan SILALAD')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Detail Laporan SILALAD</h1>

    <div class="bg-white p-6 border rounded shadow space-y-3 text-sm leading-relaxed">
    <p><strong>Nama:</strong> {{ $silalad->nama_pelanggan }}</p>
    <p><strong>Telepon:</strong> {{ $silalad->nomor_telepon_pelanggan }}</p>
    <p><strong>Alamat:</strong> {{ $silalad->alamat }}</p>
    <p><strong>Alamat Detail:</strong> {{ $silalad->alamat_detail }}</p>
    <p><strong>Layanan:</strong> {{ $silalad->layanan }}</p>
    <p><strong>Detail Laporan:</strong> {{ $silalad->detail_laporan }}</p>
    <p><strong>Kab/Kota:</strong> {{ $silalad->kabkota_id }}</p>
    <p><strong>Kecamatan:</strong> {{ $silalad->kecamatan_id }}</p>
    <p><strong>Kelurahan:</strong> {{ $silalad->kelurahan_id }}</p>
    <p><strong>Latitude:</strong> {{ $silalad->latitude ?? '-' }}</p>
    <p><strong>Longitude:</strong> {{ $silalad->longitude ?? '-' }}</p>
    <p><strong>Jenis Bangunan:</strong> {{ $silalad->jenis_bangunan }}</p>
    <p><strong>Nomor Bangunan:</strong> {{ $silalad->nomor_bangunan }}</p>
    <p><strong>RT:</strong> {{ $silalad->rt }}</p>
    <p><strong>Rating:</strong> {{ $silalad->rating }}</p>
    <p><strong>Kritik:</strong> {{ $silalad->kritik }}</p>
    <p><strong>Saran:</strong> {{ $silalad->saran }}</p>
    <p><strong>Status Pengerjaan:</strong> {{ $silalad->status_pengerjaan }}</p>
    <p><strong>Persetujuan:</strong> {{ $silalad->setuju ? 'Ya' : 'Tidak' }}</p>
    <p><strong>Dibuat Pada:</strong> {{ $silalad->created_at->format('d-m-Y H:i') }}</p>
    <p><strong>Diupdate Pada:</strong> {{ $silalad->updated_at->format('d-m-Y H:i') }}</p>

            <span class="px-2 py-1 rounded 
                {{ $silalad->status_pengerjaan == 'Sudah dikerjakan' ? 'bg-green-200 text-green-700' : 'bg-yellow-200 text-yellow-700' }}">
                {{ $silalad->status_pengerjaan }}
            </span>
        </p>
        <p><strong>Dibuat pada:</strong> {{ $silalad->created_at->format('d-m-Y H:i') }}</p>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('admin.silalad.data-pesanan') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            Kembali

        </a>
        <a href="{{ route('admin.silalad.edit', $silalad->id) }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Edit
        </a>

        <form action="{{ route('admin.silalad.destroy', $silalad->id) }}" 
              method="POST" 
              onsubmit="return confirm('Yakin ingin menghapus data ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" 
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                Hapus
            </button>
        </form>
        
            <form action="{{ route('admin.silalad.update-status', $silalad->id) }}" 
        method="POST" class="inline">
        @csrf
        @method('PUT')
        <select name="status_pengerjaan" class="border rounded px-2 py-1">
            <option value="Belum dikerjakan" {{ $silalad->status_pengerjaan == 'Belum dikerjakan' ? 'selected' : '' }}>Belum dikerjakan</option>
            <option value="Sedang dikerjakan" {{ $silalad->status_pengerjaan == 'Sedang dikerjakan' ? 'selected' : '' }}>Sedang dikerjakan</option>
            <option value="Sudah dikerjakan" {{ $silalad->status_pengerjaan == 'Sudah dikerjakan' ? 'selected' : '' }}>Sudah dikerjakan</option>
            <option value="Dibatalkan" {{ $silalad->status_pengerjaan == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded ml-2">
            Update Status
        </button>
    </form>

        </button>
    </form>


    </div>
</div>
@endsection
