@extends('admin.layout')

@section('title', $page_title)

@section('content')
<div class="main-content">

    <!-- Header -->
    <h1 class="h3 mb-4 text-gray-800">{{ $page_title }}</h1>

    <!-- Filter Section -->
    <div class="filter-section mb-4">
        <div class="month-filter">
            <span>Bulan & Tahun</span>
            <form method="GET" action="{{ route('admin.sedot-tinja.riwayat-pesanan') }}" class="d-flex align-items-center">
                <select name="bulan">
                    <option value="">-- Pilih Bulan --</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
                <select name="tahun">
                    <option value="">-- Pilih Tahun --</option>
                    @for ($t = date('Y'); $t >= 2020; $t--)
                        <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endfor
                </select>
                <button type="submit" class="submit-btn">Filter</button>
                <a href="{{ route('admin.sedot-tinja.riwayat-pesanan') }}" class="submit-btn reset-btn">Reset</a>
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Alamat</th>
                    <th>Status Pengerjaan</th>
                    <th>Tanggal Update</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($riwayat as $index => $item)
                    <tr>
                        <td>{{ $riwayat->firstItem() + $index }}</td>
                        <td>{{ $item->nama_pelanggan }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>
                            <span class="status-badge 
                                {{ $item->status_pengerjaan == 'Sudah dikerjakan' ? 'status-selesai' : 
                                   ($item->status_pengerjaan == 'Sedang dikerjakan' ? 'status-proses' : 'status-belum') }}">
                                {{ $item->status_pengerjaan }}
                            </span>
                        </td>
                        <td>{{ $item->updated_at->format('d M Y H:i') }}</td>
                        <td class="action-buttons">
                            <a href="{{ route('admin.sedot-tinja.show', $item->id) }}" class="action-btn" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.sedot-tinja.edit', $item->id) }}" class="action-btn edit-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.sedot-tinja.destroy', $item->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin hapus pesanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
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

        <ul class="pagination">
            {{ $riwayat->links() }}
        </ul>
    </div>
</div>

<!-- Custom CSS -->
<style>
.main-content {
    padding: 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.filter-section {
    margin-bottom: 20px;
}
.month-filter form {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.month-filter select, .submit-btn {
    padding: 6px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    background-color: #fff;
}
.submit-btn {
    background: #007bff;
    color: #fff;
    cursor: pointer;
    border: none;
}
.submit-btn:hover {
    background: #0056b3;
}
.reset-btn {
    background: #6c757d;
}
.reset-btn:hover {
    background: #5a6268;
}
.table-container {
    overflow-x: auto;
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
.status-selesai { background: #d4edda; color: #155724; }
.status-proses { background: #fff3cd; color: #856404; }
.status-belum { background: #f8d7da; color: #721c24; }
.action-buttons .action-btn {
    display: inline-block;
    padding: 6px 8px;
    border-radius: 6px;
    background: #f1f1f1;
    color: #333;
    margin-right: 4px;
    text-decoration: none;
}
.action-buttons .action-btn:hover {
    background: #ddd;
}
.action-buttons .edit-btn { background: #ffeeba; color: #856404; }
.action-buttons .delete-btn { background: #f8d7da; color: #721c24; }
.pagination {
    margin-top: 20px;
    list-style: none;
}
</style>
@endsection
