<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bukti Laporan {{ $laporan->id_laporan }}</title>
    <style>
        @page {
            margin: 0; /* Hapus margin default halaman */
            size: A4;
        }
        body {
            font-family: 'Helvetica', DejaVu Sans, sans-serif; /* Fallback ke DejaVu Sans untuk karakter spesial */
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 11pt;
            background-color: #f4f7f6;
        }
        .container {
            padding: 1in;
        }

        /* Header Section */
        .header-section {
            background-color: #1e3a8a; /* Biru Tua dari Referensi */
            color: white;
            padding: 30px 1in;
            position: relative;
        }
        .header-content {
            display: table;
            width: 100%;
        }
        .header-title {
            display: table-cell;
            vertical-align: middle;
        }
        .header-id {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
            width: 180px;
        }
        .header-title h1 {
            font-size: 20pt;
            font-weight: bold;
            margin: 0;
            line-height: 1.2;
        }
        .header-title p {
            font-size: 12pt;
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        .header-id-badge {
            background-color: #f59e0b; /* Kuning dari Referensi */
            color: #1e3a8a;
            border-radius: 6px;
            padding: 10px 15px;
            display: inline-block;
            text-align: center;
        }
        .header-id-badge .label {
            font-size: 9pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }
        .header-id-badge .value {
            font-size: 14pt;
            font-weight: bold;
            margin: 3px 0 0 0;
            letter-spacing: 1px;
        }

        /* Content Section */
        .content-section {
            padding: 1in;
            background-color: #ffffff;
        }
        .content-title {
            font-size: 16pt;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table td {
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: top;
        }
        .details-table tr:last-child td {
            border-bottom: none;
        }
        .details-table .label {
            font-weight: normal;
            color: #6b7280;
            width: 150px; /* Lebar tetap untuk label */
        }
        .details-table .value {
            font-weight: bold;
            color: #1f2937;
        }

        /* Footer Section */
        .footer-section {
            text-align: center;
            padding: 20px 1in;
            font-size: 9pt;
            color: #6b7280;
            position: fixed;
            bottom: 0.5in;
            left: 0;
            right: 0;
        }
        .footer-section p {
            margin: 0;
        }

    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header-section">
        <div class="header-content">
            <div class="header-title">
                <h1>Bukti Laporan</h1>
                <p>Sistem Pelaporan Kerusakan Jalan</p>
            </div>
            <div class="header-id">
                <div class="header-id-badge">
                    <p class="label">ID Laporan</p>
                    <p class="value">{{ $laporan->id_laporan }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <h2 class="content-title">Detail Tanda Terima</h2>

        <table class="details-table">
            <tr>
                <td class="label">ID Laporan</td>
                <td class="value">{{ $laporan->id_laporan }}</td>
            </tr>
            <tr>
                <td class="label">Nama Pelapor</td>
                {{-- Mengakses nama dari relasi 'pelapor' --}}
                <td class="value">{{ $laporan->pelapor->nama_lengkap ?? 'Data tidak ditemukan' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Lapor</td>
                <td class="value"><span>{{ \Carbon\Carbon::parse($laporan->created_at)->locale('id')->isoFormat('DD MMMM YYYY, HH:mm') }} WITA</span></td>
            </tr>
        </table>
    </div>

    <!-- Footer Section -->
    <div class="footer-section">
        <p>Dokumen ini dibuat secara otomatis oleh sistem pada tanggal {{ now()->locale('id')->isoFormat('D MMMM YYYY') }}.</p>
    </div>
</body>
</html>