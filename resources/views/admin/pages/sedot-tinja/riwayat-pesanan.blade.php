@extends('admin.layouts.app')

@section('title', $page_title)

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">{{ $page_title }}</h1>

    <!-- Filter Bulan & Tahun -->
    <form method="GET" action="{{ route('admin.sedot-tinja.riwayat') }}" class="mb-4 row">
        <div class="col-md-3">
            <select name="bulan" class="form-control">
                <option value="">-- Pilih Bulan --</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
        </div>
        <div class="col-md-3">
            <select name="tahun" class="form-control">
                <option value="">-- Pilih Tahun --</option>
                @for ($t = date('Y'); $t >= 2020; $t--)
                    <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <!-- Tabel Riwayat Pesanan -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Tanggal Update</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayat as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama_pelanggan }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>
                                    @if ($item->status_pengerjaan == 'Belum dikerjakan')
                                        <span class="badge badge-warning">Belum Dikerjakan</span>
                                    @elseif ($item->status_pengerjaan == 'Sedang dikerjakan')
                                        <span class="badge badge-info">Sedang Dikerjakan</span>
                                    @else
                                        <span class="badge badge-success">Sudah Dikerjakan</span>
                                    @endif
                                </td>
                                <td>{{ $item->updated_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.sedot-tinja.show', $item->id) }}" class="btn btn-sm btn-info">
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.sedot-tinja.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.sedot-tinja.destroy', $item->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin hapus pesanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada riwayat pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
