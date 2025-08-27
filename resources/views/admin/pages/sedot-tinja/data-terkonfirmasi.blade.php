@extends('admin.layout')

@section('title', $page_title)

@section('content')
<div class="container-fluid">

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ $page_title }}</h1>
    </div>

    <!-- Filter Section -->
    <div class="card p-4 mb-4">
        <h5 class="card-title mb-3">Filter Laporan</h5>
        <form method="GET" action="{{ route('admin.sedot-tinja.dataTerkonfirmasi') }}" 
              class="flex flex-wrap items-end gap-4">

            <!-- Pilih Bulan -->
            <div class="flex flex-col">
                <label for="bulan" class="mb-1 font-semibold text-gray-700">Bulan</label>
                <select name="bulan" id="bulan" 
                    class="form-select px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary">
                    <option value="">-- Semua Bulan --</option>
                    @php
                        $daftarBulan = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                    @endphp
                    @foreach ($daftarBulan as $angkaBulan => $namaBulan)
                        <option value="{{ $angkaBulan }}" {{ request('bulan') == $angkaBulan ? 'selected' : '' }}>
                            {{ $namaBulan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Pilih Tahun -->
            <div class="flex flex-col">
                <label for="tahun" class="mb-1 font-semibold text-gray-700">Tahun</label>
                <select name="tahun" id="tahun" 
                    class="form-select px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary">
                    <option value="">-- Semua Tahun --</option>
                    @php $tahunSekarang = date('Y'); @endphp
                    @for ($t = $tahunSekarang; $t >= 2020; $t--)
                        <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endfor
                </select>
            </div>

            <!-- Tombol Filter -->
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary px-4">Filter</button>
                <a href="{{ route('admin.sedot-tinja.dataTerkonfirmasi') }}" class="btn btn-secondary px-4">Reset</a>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Id Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Alamat</th>
                    <th>No. Tlp</th>
                    <th>Jenis Bangunan</th>
                    <th>Status Pengerjaan</th>
                    <th colspan="2" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesananConfirmed as $pesanan)
                <tr>
                    <td>{{ $loop->iteration + ($pesananConfirmed->currentPage() - 1) * $pesananConfirmed->perPage() }}</td>
                    <td>{{ $pesanan->id }}</td>
                    <td>{{ $pesanan->nama_pelanggan }}</td>
                    <td>{{ $pesanan->alamat }}</td>
                    <td>{{ $pesanan->nomor_telepon_pelanggan }}</td>
                    <td>{{ $pesanan->jenis_bangunan }}</td>
                    <td>
                        @if ($pesanan->status_pengerjaan == 'Sudah dikerjakan')
                            <span class="status-badge status-selesai">Sudah dikerjakan</span>
                        @elseif ($pesanan->status_pengerjaan == 'Sedang dikerjakan')
                            <span class="status-badge status-proses">Sedang dikerjakan</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.sedot-tinja.show', $pesanan->id) }}" class="action-btn" title="Detail"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.sedot-tinja.edit', $pesanan->id) }}" class="action-btn edit-btn" title="Edit"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.sedot-tinja.destroy', $pesanan->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('admin.sedot-tinja.print', $pesanan->id) }}" target="_blank" class="action-btn print-btn" title="Print"><i class="fas fa-print"></i></a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada pesanan terkonfirmasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            {{ $pesananConfirmed->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
    .table-container {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .table-container table {
        width: 100%;
        border-collapse: collapse;
    }
    .table-container th, .table-container td {
        padding: 10px;
        border: 1px solid #eee;
        text-align: left;
    }
    .table-container th {
        background: #f8f9fa;
        font-weight: bold;
    }
    .status-badge {
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .status-selesai {
        background: #d4edda;
        color: #155724;
    }
    .status-proses {
        background: #fff3cd;
        color: #856404;
    }
    .action-btn {
        display: inline-block;
        padding: 6px 8px;
        border-radius: 6px;
        background: #f1f1f1;
        color: #333;
        margin-right: 4px;
        text-decoration: none;
        border: none;
    }
    .action-btn:hover {
        background: #ddd;
    }
    .edit-btn {
        background: #ffeeba;
        color: #856404;
    }
    .delete-btn {
        background: #f8d7da;
        color: #721c24;
    }
    .print-btn {
        background: #ffc107;
        color: #212529;
    }
    .print-btn:hover {
        background: #e0a800;
    }
    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
</style>
@endsection
