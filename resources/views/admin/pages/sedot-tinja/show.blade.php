@extends('admin.layout')

@section('title', 'Detail Laporan Sedot Tinja')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Detail Laporan Sedot Tinja</h1>

    <div class="bg-white p-6 border rounded shadow space-y-3 text-sm leading-relaxed">
    <p><strong>Nama:</strong> {{ $sedotTinja->nama_pelanggan }}</p>
    <p><strong>Telepon:</strong> {{ $sedotTinja->nomor_telepon_pelanggan }}</p>
    <p><strong>Alamat:</strong> {{ $sedotTinja->alamat }}</p>
    <p><strong>Alamat Detail:</strong> {{ $sedotTinja->alamat_detail }}</p>
    <p><strong>Layanan:</strong> {{ $sedotTinja->layanan }}</p>
    <p><strong>Detail Laporan:</strong> {{ $sedotTinja->detail_laporan }}</p>
    <p><strong>Kab/Kota:</strong> {{ $sedotTinja->kabkota_id }}</p>
    <p><strong>Kecamatan:</strong> {{ $sedotTinja->kecamatan_id }}</p>
    <p><strong>Kelurahan:</strong> {{ $sedotTinja->kelurahan_id }}</p>
    <p><strong>Latitude:</strong> {{ $sedotTinja->latitude ?? '-' }}</p>
    <p><strong>Longitude:</strong> {{ $sedotTinja->longitude ?? '-' }}</p>
    <p><strong>Jenis Bangunan:</strong> {{ $sedotTinja->jenis_bangunan }}</p>
    <p><strong>Nomor Bangunan:</strong> {{ $sedotTinja->nomor_bangunan }}</p>
    <p><strong>RT:</strong> {{ $sedotTinja->rt }}</p>
    <p><strong>Rating:</strong> {{ $sedotTinja->rating }}</p>
    <p><strong>Kritik:</strong> {{ $sedotTinja->kritik }}</p>
    <p><strong>Saran:</strong> {{ $sedotTinja->saran }}</p>
    <p><strong>Status Pengerjaan:</strong> {{ $sedotTinja->status_pengerjaan }}</p>
    <p><strong>Persetujuan:</strong> {{ $sedotTinja->setuju ? 'Ya' : 'Tidak' }}</p>
    <p><strong>Dibuat Pada:</strong> {{ $sedotTinja->created_at->format('d-m-Y H:i') }}</p>
    <p><strong>Diupdate Pada:</strong> {{ $sedotTinja->updated_at->format('d-m-Y H:i') }}</p>

            <span class="px-2 py-1 rounded 
                {{ $sedotTinja->status_pengerjaan == 'Sudah dikerjakan' ? 'bg-green-200 text-green-700' : 'bg-yellow-200 text-yellow-700' }}">
                {{ $sedotTinja->status_pengerjaan }}
            </span>
        </p>
        <p><strong>Dibuat pada:</strong> {{ $sedotTinja->created_at->format('d-m-Y H:i') }}</p>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('admin.sedot-tinja.data-pesanan') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            Kembali

        </a>
        <a href="{{ route('admin.sedot-tinja.edit', $sedotTinja->id) }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Edit
        </a>

        <form action="{{ route('admin.sedot-tinja.destroy', $sedotTinja->id) }}" 
              method="POST" 
              onsubmit="return confirm('Yakin ingin menghapus data ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" 
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                Hapus
            </button>
        </form>
        
            <form action="{{ route('admin.sedot-tinja.update-status', $sedotTinja->id) }}" 
        method="POST" class="inline">
        @csrf
        @method('PUT')
        <select name="status_pengerjaan" class="border rounded px-2 py-1">
            <option value="Belum dikerjakan" {{ $sedotTinja->status_pengerjaan == 'Belum dikerjakan' ? 'selected' : '' }}>Belum dikerjakan</option>
            <option value="Sedang dikerjakan" {{ $sedotTinja->status_pengerjaan == 'Sedang dikerjakan' ? 'selected' : '' }}>Sedang dikerjakan</option>
            <option value="Sudah dikerjakan" {{ $sedotTinja->status_pengerjaan == 'Sudah dikerjakan' ? 'selected' : '' }}>Sudah dikerjakan</option>
            <option value="Dibatalkan" {{ $sedotTinja->status_pengerjaan == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
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
