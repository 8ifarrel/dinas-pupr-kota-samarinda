@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">{{ $page_title }}</h2>

    {{-- Filter Bulan & Tahun --}}
    <form method="GET" action="{{ route('admin.sedot-tinja.index') }}" class="d-flex mb-3">
        <select name="bulan" class="form-select me-2" style="max-width:200px">
            @foreach(range(1,12) as $b)
                <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                </option>
            @endforeach
        </select>
        <select name="tahun" class="form-select me-2" style="max-width:150px">
            @for($t = date('Y'); $t >= 2020; $t--)
                <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>
                    {{ $t }}
                </option>
            @endfor
        </select>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    {{-- Table Pesanan --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>ID Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Alamat</th>
                    <th>No. Telp</th>
                    <th>Jenis Bangunan</th>
                    <th>Status Pengerjaan</th>
                    <th>Kelola</th>
                    <th>Print</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesananPending as $key => $pesanan)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $pesanan->id }}</td>
                        <td>{{ $pesanan->nama_pelanggan }}</td>
                        <td>{{ $pesanan->alamat }}</td>
                        <td>{{ $pesanan->nomor_telepon_pelanggan }}</td>
                        <td>{{ $pesanan->jenis_bangunan }}</td>
                        <td>
                            @if($pesanan->status_pengerjaan == 'Sudah dikerjakan')
                                <span class="badge bg-success">Sudah dikerjakan</span>
                            @elseif($pesanan->status_pengerjaan == 'Sedang dikerjakan')
                                <span class="badge bg-warning text-dark">Sedang dikerjakan</span>
                            @else
                                <span class="badge bg-danger">Belum dikerjakan</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.sedot-tinja.show', $pesanan->id) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.sedot-tinja.edit', $pesanan->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.sedot-tinja.destroy', $pesanan->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-dark">
                                <i class="bi bi-printer"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
