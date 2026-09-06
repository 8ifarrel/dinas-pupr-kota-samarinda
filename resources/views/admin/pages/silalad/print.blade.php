<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak Pesanan {{ $item->kode_booking ?? $item->id }}</title>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: 'Times New Roman', Times, serif;
      font-size: 14px;
      line-height: 1.6;
      color: #111;
      background: #f5f5f5;
      margin: 0;
      padding: 20px;
    }
    .container {
      width: 21cm;
      min-height: 29.7cm;
      margin: 0 auto;
      background: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      padding: 1.5cm;
    }
    .no-print {
      text-align: right;
      margin-bottom: 20px;
    }
    .no-print button {
      background: #223468;
      color: white;
      padding: 8px 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-family: Arial, sans-serif;
    }
    h1 {
      text-align: center;
      font-size: 18px;
      text-decoration: underline;
      margin-bottom: 4px;
    }
    .subtitle {
      text-align: center;
      margin-bottom: 24px;
    }
    table.data {
      width: 100%;
      border-collapse: collapse;
    }
    table.data td {
      padding: 6px 4px;
      vertical-align: top;
    }
    table.data td.label {
      width: 220px;
      font-weight: bold;
    }
    table.data td.sep {
      width: 16px;
    }
    .status {
      font-weight: bold;
    }
    .signature {
      margin-top: 60px;
      text-align: right;
    }
    .signature .line {
      margin-top: 70px;
      font-weight: bold;
    }
    @media print {
      body { background: white; padding: 0; }
      .container { box-shadow: none; width: auto; min-height: 0; padding: 1.5cm; }
      .no-print { display: none !important; }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="no-print">
      <button onclick="window.print()">🖨 Cetak Pesanan</button>
    </div>

    <h1>BUKTI PESANAN SILALAD</h1>
    <p class="subtitle">
      UPTD Pengelolaan Air Limbah Domestik<br>
      Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda
    </p>

    <table class="data">
      <tr>
        <td class="label">Kode Booking</td>
        <td class="sep">:</td>
        <td>{{ $item->kode_booking ?? '-' }}</td>
      </tr>
      <tr>
        <td class="label">Nama Pelanggan</td>
        <td class="sep">:</td>
        <td>{{ $item->nama_pelanggan }}</td>
      </tr>
      <tr>
        <td class="label">Nomor Telepon</td>
        <td class="sep">:</td>
        <td>{{ $item->nomor_telepon_pelanggan }}</td>
      </tr>
      <tr>
        <td class="label">Alamat</td>
        <td class="sep">:</td>
        <td>{{ $item->alamat }} {{ $item->alamat_detail }}</td>
      </tr>
      <tr>
        <td class="label">Wilayah</td>
        <td class="sep">:</td>
        <td>{{ $item->kabkota_id }} / Kec. {{ $item->kecamatan_id }} / Kel. {{ $item->kelurahan_id }}</td>
      </tr>
      <tr>
        <td class="label">Jenis Bangunan</td>
        <td class="sep">:</td>
        <td>{{ $item->jenis_bangunan }}, No. {{ $item->nomor_bangunan }}, RT {{ $item->rt }}</td>
      </tr>
      <tr>
        <td class="label">Jenis Layanan</td>
        <td class="sep">:</td>
        <td>{{ $item->layanan }}</td>
      </tr>
      <tr>
        <td class="label">Detail Laporan</td>
        <td class="sep">:</td>
        <td>{{ $item->detail_laporan ?: '-' }}</td>
      </tr>
      <tr>
        <td class="label">Status Pengerjaan</td>
        <td class="sep">:</td>
        <td class="status">{{ $item->status_pengerjaan }}</td>
      </tr>
      <tr>
        <td class="label">Tanggal Pendaftaran</td>
        <td class="sep">:</td>
        <td>{{ $item->created_at->translatedFormat('d F Y, H:i') }} WITA</td>
      </tr>
    </table>

    <div class="signature">
      <p>Samarinda, {{ now()->translatedFormat('d F Y') }}</p>
      <p class="line">Kepala UPTD Pengelolaan Air Limbah Domestik</p>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const params = new URLSearchParams(window.location.search);
      if (params.has('print')) {
        window.history.replaceState({}, document.title, window.location.pathname);
        window.print();
      }
    });
  </script>
</body>
</html>
