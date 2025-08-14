<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan Pengaduan Drainase dan Irigasi</title>
  <script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>
  <style type="text/css">
    @page {
      size: a4;
      margin: 0;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      font-size: 12pt;
      line-height: 1.5;
      color: #333;
      width: 794px;
      /* 21cm 96dpi (A4 width) */
      height: 1123px;
      /* 29.7cm 96dpi (A4 height) */
      position: relative;
    }

    a {
      color: rgb(37, 99, 235);
      text-decoration: underline;
    }

    .container {
      padding: 37.8px;
      /* 1cm 96dpi padding */
    }

    .header {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
    }

    .logo {
      width: auto;
      height: 72px;
    }

    .title {
      flex: 1;
      line-height: 1;
      font-size: 24pt;
      color: rgba(34, 52, 104, 1);
      font-weight: bold;
    }

    .subtitle {
      font-size: 14pt;
      color: rgba(34, 52, 104, 1);
    }

    .qr-container {
      position: absolute;
      top: 40px;
      right: 40px;
    }

    .info-container {
      text-align: center;
    }

    .report-id {
      margin-top: 5px;
      font-weight: bold;
    }

    .info-section {
      margin-bottom: 20px;
    }

    .section-title {
      background-color: rgba(34, 52, 104, 1);
      color: white;
      padding: 5px 10px;
      font-weight: bold;
    }

    .info-table {
      width: 100%;
      border-collapse: collapse;
    }

    .info-table td {
      padding-top: 5px;
      padding-bottom: 5px;
      vertical-align: top;
      text-align: justify;
    }

    .info-table td:first-child {
      padding-left: 10px;
      width: 25%;
      font-weight: bold;
    }

    .info-table td:last-child {
      padding-right: 10px;
      width: 100%;
      padding-left: 5px;
    }

    .photo-section {
      margin-bottom: 20px;
    }

    .photo-container {
      display: flex;
      justify-content: flex-start;
      gap: 10px;
      flex-wrap: wrap;
      margin-top: 10px;
      margin-left: 5px;
      margin-right: 5px;
    }

    .photo {
      height: 125px;
      width: auto;
    }

    .footer {
      position: absolute;
      bottom: 20px;
      left: 40px;
      right: 40px;
      text-align: center;
      font-size: 10pt;
      color: #666;
      padding-top: 10px;
      border-top: 1px solid #ddd;
    }

    .signature-section {
      margin-top: 30px;
      text-align: right;
      padding-right: 50px;
    }

    .signature-box {
      margin-top: 60px;
      border-bottom: 1px solid #333;
      width: 200px;
      display: inline-block;
    }

    .text-center {
      text-align: center;
    }

    #qrcode img {
      width: 65px !important;
      height: 65px !important;
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Header -->
    <div class="header">
      <div class="qr-container">
        <div id="qrcode"></div>
        <script>
          window.onload = function() {
            var qr = qrcode(0, 'L');
            qr.addData("{{ $show_url }}");
            qr.make();
            var qrImg = qr.createImgTag(1);
            document.getElementById('qrcode').innerHTML = qrImg;
          };
        </script>
      </div>
      <div class="info-container">
        <div class="subtitle">Sistem Informasi Pemeliharaan Saluran Drainase dan Irigasi</div>
        <div class="title">Bukti Pengaduan Hantu Banyu</div>
        <div style="display: flex; flex-direction: row; align-items: flex-end; gap: 5px; justify-content: center;">
          <div class="report-id"><span style="font-weight: normal;">Nomor pengaduan:</span> {{ $laporan->id }}</div>
          <span>•</span>
          <div class="report-id"><span style="font-weight: normal;">Waktu masuk:</span> {{ $tanggal_laporan }}
            ({{ $waktu_laporan }})</div>
        </div>
      </div>
    </div>

    <!-- Reporter Information Section -->
    <div class="info-section">
      <div class="section-title">DATA PELAPOR</div>
      <table class="info-table">
        <tr>
          <td>Nama Lengkap</td>
          <td>:</td>
          <td>{{ $laporan->pelapor->nama_lengkap }}</td>
        </tr>
        <tr>
          <td>Pekerjaan</td>
          <td>:</td>
          <td>{{ $laporan->pelapor->pekerjaan }}</td>
        </tr>
        <tr>
          <td>Alamat</td>
          <td>:</td>
          <td>{{ $laporan->pelapor->alamat }}</td>
        </tr>
        <tr>
          <td>Nomor Telepon</td>
          <td>:</td>
          <td>{{ $laporan->pelapor->nomor_telepon }}</td>
        </tr>
      </table>
    </div>

    <!-- Report Location Section -->
    <div class="info-section">
      <div class="section-title">LOKASI PENGADUAN</div>
      <table class="info-table">
        <tr>
          <td>Kecamatan</td>
          <td>:</td>
          <td>{{ $laporan->kecamatan->nama }}</td>
        </tr>
        <tr>
          <td>Kelurahan</td>
          <td>:</td>
          <td>{{ $laporan->kelurahan->nama }}</td>
        </tr>
        <tr>
          <td>Nama Jalan</td>
          <td>:</td>
          <td>{{ $laporan->nama_jalan }}</td>
        </tr>
        <tr>
          <td>Detail Lokasi</td>
          <td>:</td>
          <td>{{ $laporan->detail_lokasi }}</td>
        </tr>
        <tr>
          <td>Koordinat</td>
          <td>:</td>
          <td>{{ $laporan->latitude }} (latitude), {{ $laporan->longitude }} (longitude)</td>
        </tr>
        <tr>
          <td>Link Google Maps</td>
          <td>:</td>
          <td><a
              href="https://maps.google.com/?q={{ $laporan->latitude }},{{ $laporan->longitude }}">https://maps.google.com/?q={{ $laporan->latitude }},{{ $laporan->longitude }}</a>
          </td>
        </tr>
      </table>
    </div>

    <!-- Report Details Section -->
    <div class="info-section">
      <div class="section-title">DETAIL PENGADUAN</div>
      <table class="info-table">
        <tr>
          <td>Deskripsi Pengaduan</td>
          <td>:</td>
          <td>{{ $laporan->deskripsi_pengaduan }}</td>
        </tr>
      </table>
    </div>

    <!-- Photos Section -->
    <div class="photo-section">
      <div class="section-title">FOTO PENGADUAN</div>
      <div class="photo-container">
        @forelse($laporan->foto as $foto)
          <img src="{{ public_path('storage/' . str_replace('storage/', '', $foto->foto)) }}"
            alt="Foto {{ $loop->iteration }}" class="photo">
        @empty
          <p style="margin-left: 10px;">Tidak ada foto</p>
        @endforelse
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      <div>UPTD Pemeliharaan Saluran Drainase dan Irigasi</div>
      <div>Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda</div>
      <div>Jalan Haji Achmad Amins, Kelurahan Gunung Lingai, Kecamatan Sungai Pinang, Kota Samarinda, 75117</div>
      <div style="font-style: italic;">Bukti pengaduan ini dicetak secara otomatis menggunakan sistem kami.</div>
    </div>
  </div>
</body>

</html>
