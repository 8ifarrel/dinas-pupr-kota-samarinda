<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Panel Dinas PUPR')</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7f9;
            color: #333;
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Navigation */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
            height: 100vh;
            position: fixed;
            overflow-y: auto;
        }
        
        .logo-section {
            padding: 0 20px 20px;
            border-bottom: 1px solid #3c546e;
            margin-bottom: 20px;
        }
        
        .logo-section h2 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #ecf0f1;
        }
        
        .logo-section p {
            font-size: 0.8rem;
            color: #bdc3c7;
            margin-top: 5px;
        }
        
        .nav-menu {
            list-style: none;
        }
        
        .nav-menu li {
            margin-bottom: 5px;
        }
        
        .nav-menu a {
            display: block;
            padding: 12px 20px;
            color: #ecf0f1;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }
        
        .nav-menu a:hover, .nav-menu a.active {
            background-color: #34495e;
            border-left-color: #3498db;
        }
        
        .nav-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
        }
        
        .header {
            background-color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .breadcrumb {
            font-size: 0.9rem;
            color: #7f8c8d;
        }
        
        .breadcrumb a {
            color: #3498db;
            text-decoration: none;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        /* Dashboard Info */
        .dashboard-info {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .dashboard-info h2 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 1.5rem;
        }
        
        /* Welcome Panel */
        .welcome-panel {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            color: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .welcome-panel h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        
        /* Filter Section */
        .filter-section {
            background-color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .month-filter {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .month-filter select, .month-filter input {
            padding: 8px 12px;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
        }
        
        .submit-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }
        
        .submit-btn:hover {
            background-color: #2980b9;
        }
        
        /* Table Container */
        .table-container {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: 600;
            color: #2c3e50;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #f1f1f1;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .status-selesai {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-belum {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            margin-right: 10px;
            color: #7f8c8d;
            transition: color 0.2s;
        }
        
        .action-btn:hover {
            color: #3498db;
        }
        
        .print-btn {
            color: #27ae60;
        }
        
        .print-btn:hover {
            color: #2ecc71;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            padding: 15px;
            list-style: none;
        }
        
        .pagination li {
            margin: 0 5px;
        }
        
        .pagination a {
            display: block;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #3498db;
            text-decoration: none;
        }
        
        .pagination a:hover {
            background-color: #f5f5f5;
        }
        
        .pagination .active a {
            background-color: #3498db;
            color: white;
            border-color: #3498db;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo-section">
            <h2>E-Panel</h2>
            <p>Dinas PUPR Kota Samarinda</p>
        </div>
        
        <ul class="nav-menu">
            <li><a href="#"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="has-submenu">
                <a href="#"><i class="fas fa-road"></i> Jalan Peduli</a>
                <ul class="submenu">
                    <li><a href="#">Drainase & Irigasi</a></li>
                    <li><a href="#" class="active">Sedot Tinja</a></li>
                </ul>
            </li>
            <li><a href="#"><i class="fas fa-clipboard-list"></i> Data Pesanan</a></li>
            <li><a href="#"><i class="fas fa-check-circle"></i> Data Terkonfirmasi</a></li>
            <li><a href="#"><i class="fas fa-history"></i> Riwayat Pesanan</a></li>
            <li><a href="#"><i class="fas fa-file-alt"></i> Sijakon</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <div class="breadcrumb">
                <a href="#">Dashboard</a> > <a href="#">Sedot Tinja</a> > <a href="#">@yield('title')</a>
            </div>
            <div class="user-info">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=3498db&color=fff" alt="Admin">
                <span>{{ Auth::user()->name ?? 'Administrator' }}</span>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #c0392b;"><i class="fas fa-sign-out-alt"></i></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
        
        <div class="dashboard-info">
            <h2>Dashboard</h2>
            <p>Beranda E-Panel sekaligus ringkasan aktivitas di website Dinas PUPR Kota Samarinda.</p>
        </div>
        
        {{-- Konten dari halaman lain akan diletakkan di sini --}}
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Script untuk toggle submenu
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
</body>
</html>