{{--
  Surat Pesanan - permohonan penyedotan yang ditandatangani pelanggan,
  memuat hasil pemeriksaan kelayakan di lapangan.

  Bagian yang datanya belum diisi sengaja tampil sebagai garis titik-titik,
  bukan tanda strip: surat ini memang dirancang untuk bisa dicetak lebih
  dulu lalu dilengkapi tulisan tangan saat petugas ke lokasi.
--}}
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Surat Pesanan {{ $item->kode_booking ?? $item->id }}</title>
  @include('admin.pages.silalad.partials.gaya-surat')
</head>

<body>
  <div class="container">
    <div class="no-print">
      <button onclick="window.print()">🖨 Cetak Surat Pesanan</button>
    </div>

    <h1>SURAT PESANAN</h1>
    <p class="subtitle">Perihal: Penyedotan Tangki Septik</p>

    <p class="tujuan">
      Kepada Yth.<br>
      Kepala UPTD Pengelolaan Air Limbah Domestik<br>
      Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda
    </p>

    <p><strong>Mohon dilaksanakan Penyedotan Tangki Septik:</strong></p>
    <p>Nomor SPK: <span class="isian">{{ $item->nomor_spk ?: '...................... / UPTD / .......... / ' . now()->year }}</span></p>

    <div class="kelompok">
      <p><strong>Nama:</strong> <span class="isian">{{ $item->nama_pelanggan ?: '..................' }}</span></p>
      <p><strong>Alamat:</strong> <span class="isian">{{ $item->alamat_detail ?: $item->alamat }}</span></p>
      <p>
        <strong>No.:</strong> <span class="isian">{{ $item->nomor_bangunan ?: '......' }}</span>
        &nbsp;&nbsp;&nbsp;
        <strong>RT:</strong> <span class="isian">{{ $item->rt ?: '......' }}</span>
      </p>
      <p><strong>Kelurahan:</strong> <span class="isian">{{ $namaKelurahan ?: '..................' }}</span></p>
      <p><strong>Kecamatan:</strong> <span class="isian">{{ $namaKecamatan ?: '..................' }}</span></p>
      <p><strong>Telp. Rumah / HP:</strong> <span class="isian">{{ $item->nomor_telepon_pelanggan ?: '..................' }}</span></p>
    </div>

    <div class="kelompok">
      <p>1. <strong>Jarak Tangki Septik dengan mobil tinja:</strong>
        <span class="isian">{{ $item->jarak_tangki !== null ? $item->jarak_tangki : '......' }}</span> meter
      </p>
      <p>2. <strong>Tangki Septik bisa disedot:</strong>
        <span class="isian">
          @if ($item->bisa_disedot === null)
            Ya / Tidak
          @else
            {{ $item->bisa_disedot ? 'Ya' : 'Tidak' }}
          @endif
        </span>
      </p>
      <p><strong>Tersedia untuk pemenuhan selang penyedotan</strong></p>
    </div>

    <p class="catatan">
      Apabila kondisi tidak memungkinkan untuk teknis penyedotan, tidak bisa ditambahkan menjadi tanggung jawab kami
      sebagai pemesan.
    </p>

    <div class="ttd-kanan">
      <p>Samarinda, {{ ($item->tanggal_pesanan ?? $item->created_at)->translatedFormat('d F Y') }}</p>
      <p>Pemohon,</p>
      <div class="garis-ttd">{{ $item->nama_pelanggan ?: '..................' }}</div>
    </div>
  </div>

  @include('admin.pages.silalad.partials.skrip-cetak')
</body>

</html>
