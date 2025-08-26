@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>{{ $page_title }}</h2>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form Filter Bulan & Tahun --}}
    <form method="GET" action="{{ route('admin.sedot-tinja.dataTerkonfirmasi') }}" class="mb-4 row g-3">
        <div class="col-md-4">
            <label for="bulan" class="form-label">Bulan</label>
            <select name="bulan" id="bulan" class="form-select">
                <option value="">-- Semua Bulan --</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="col-md-4">
            <label for="tahun" class="form-label">Tahun</label>
            <select name="tahun" id="tahun" class="form-select">
                <option value="">-- Semua Tahun --</option>
                @php
                    $tahunSekarang = date('Y');
                @endphp
                @for ($t = $tahunSekarang; $t >= 2020; $t--)
                    <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endfor
            </select>
        </div>

        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.sedot-tinja.dataTerkonfirmasi') }}" class="btn btn-secondary ms-2">Reset</a>
        </div>
    </form>

    {{-- Tabel Data Terkonfirmasi --}}
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama Pelanggan</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Diperbarui</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($pesananConfirmed as $pesanan)
            <tr>
                <td>{{ $pesanan->nama_pelanggan }}</td>
                <td>{{ $pesanan->nomor_telepon_pelanggan }}</td>
                <td>{{ $pesanan->alamat }}</td>
                <td>
                    @if ($pesanan->status_pengerjaan == 'Sedang dikerjakan')
                        <span class="badge bg-warning">{{ $pesanan->status_pengerjaan }}</span>
                    @elseif ($pesanan->status_pengerjaan == 'Sudah dikerjakan')
                        <span class="badge bg-success">{{ $pesanan->status_pengerjaan }}</span>
                    @endif
                </td>
                <td>{{ $pesanan->updated_at->format('d-m-Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.sedot-tinja.show', $pesanan->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('admin.sedot-tinja.edit', $pesanan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('admin.sedot-tinja.print', $pesanan->id) }}" target="_blank" class="btn btn-secondary btn-sm">Print</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">Tidak ada pesanan terkonfirmasi</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
