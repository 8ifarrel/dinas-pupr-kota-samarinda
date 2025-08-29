@extends('admin.layout')

@section('title', $page_title)

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        
        <!-- Filter Section -->
        <div class="filter-section">
            <div class="month-filter">
                <span>Tanggal</span>
                <select>
                    <option>Januari</option>
                    <option>Februari</option>
                    <option>Maret</option>
                    <option>April</option>
                    <option>Mei</option>
                    <option>Juni</option>
                    <option>Juli</option>
                    <option>Agustus</option>
                    <option>September</option>
                    <option>Oktober</option>
                    <option>November</option>
                    <option>Desember</option>
                </select>
                <select>
                    <option>2025</option>
                    <option>2024</option>
                    <option>2023</option>
                </select>
                <button class="submit-btn">Submit</button>
            </div>
        </div>

        {{-- Buat Pesanan Baru --}}
       <div class="mb-3">
    <a href="{{ route('admin.sedot-tinja.create') }}" 
       class="btn btn-primary" 
       style="width: auto; padding: 8px 16px; display: inline-flex; align-items: center;">
        <i class="fas fa-plus mr-2"></i> Buat Pesanan
    </a>
</div>


        <!-- Table Section -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id Pemesan</th>
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
                    @foreach ($pesananPending as $index => $pesanan)
                        <tr>
                            <td>{{ $pesananPending->firstItem() + $index }}</td>
                            <td>{{ $pesanan->id }}</td>
                            <td>{{ $pesanan->nama_pelanggan }}</td>
                            <td>{{ $pesanan->alamat }}</td>
                            <td>{{ $pesanan->nomor_telepon_pelanggan }}</td>
                            <td>{{ $pesanan->jenis_bangunan }}</td>
                            <td>
                                <span class="status-badge {{ $pesanan->status_pengerjaan == 'Sudah dikerjakan' ? 'status-selesai' : 'status-belum' }}">
                                    {{ $pesanan->status_pengerjaan }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.sedot-tinja.show', $pesanan) }}" class="action-btn" title="show">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.sedot-tinja.print', $pesanan) }}" class="action-btn print-btn" title="Print">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <ul class="pagination">
                {{ $pesananPending->links() }}
            </ul>
        </div>
    </div>

    <style>
        .main-content {
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .filter-section {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }
        .month-filter span {
            margin-right: 10px;
            font-weight: 600;
        }
        .month-filter select, .submit-btn {
            margin-right: 10px;
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        .submit-btn {
            background: #007bff;
            color: #fff;
            cursor: pointer;
            border: none;
        }
        .btn-primary {
            background: #ffc400ff;
            color: #fff;
            cursor: pointer;
            border: none;
        }
        .btn-primary:hover {
            background: #0056b3;
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
        .status-belum {
            background: #f8d7da;
            color: #721c24;
        }
        .action-btn {
            display: inline-block;
            padding: 6px 8px;
            border-radius: 6px;
            background: #f1f1f1;
            color: #333;
            margin-right: 4px;
            text-decoration: none;
        }
        .action-btn:hover {
            background: #ddd;
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
            list-style: none;
        }
    </style>

    <script>
        // Toggle submenu
        document.querySelectorAll('.has-submenu > a').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const submenu = this.nextElementSibling;
                document.querySelectorAll('.submenu').forEach(menu => {
                    if (menu !== submenu) {
                        menu.classList.remove('show');
                        menu.parentElement.classList.remove('active');
                    }
                });
                submenu.classList.toggle('show');
                this.parentElement.classList.toggle('active');
            });
        });

        // Action buttons
        document.querySelectorAll('.action-btn').forEach(button => {
            button.addEventListener('click', function() {
                const action = this.title.toLowerCase();
                const row = this.closest('tr');
                const id = row.querySelector('td:nth-child(2)').textContent;
                const name = row.querySelector('td:nth-child(3)').textContent;
                
                if (action === 'edit') {
                    alert(`Edit data untuk ID: ${id} - ${name}`);
                } else if (action === 'print') {
                    alert(`Mencetak data untuk ID: ${id} - ${name}`);
                }
            });
        });
    </script>
@endsection
