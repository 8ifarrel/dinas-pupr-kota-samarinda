{{--
  Surat Perintah Kerja - penugasan operator & kendaraan oleh Kepala UPTD.
  Hanya bisa dicetak setelah pesanan ditugaskan (lihat penjagaannya di
  SilaladAdminController::printSuratPerintahKerja).

  Nama pejabat penanda tangan sengaja tidak ditanam di kode: cukup jabatannya
  yang dicetak, namanya ditulis saat penandatanganan - supaya surat tidak
  perlu diubah tiap kali pejabatnya berganti.
--}}
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Surat Perintah Kerja {{ $item->kode_booking ?? $item->id }}</title>
  @include('admin.pages.silalad.partials.gaya-surat')
</head>

<body>
  <div class="container">
    <div class="no-print">
      <button onclick="window.print()">🖨 Cetak Surat Perintah Kerja</button>
    </div>

    <h1>SURAT PERINTAH KERJA</h1>
    <p class="subtitle">
      Nomor: {{ $item->nomor_spk ?: '...................... / UPTD / .......... / ' . now()->year }}
    </p>

    <p class="tujuan">
      Kepala UPTD Pengelolaan Air Limbah Domestik<br>
      Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda
    </p>

    <p>Dengan ini memberikan perintah kepada:</p>

    <div class="kelompok">
      <p><strong>Nama Sopir:</strong> <span class="isian">{{ $item->nama_operator ?: '..................' }}</span></p>
      <p><strong>Nomor Kendaraan:</strong> <span class="isian">{{ $item->nomor_kendaraan ?: '..................' }}</span></p>
      <p><strong>Kapasitas Kendaraan:</strong> <span class="isian">{{ $item->kapasitas_kendaraan ?: '..................' }}</span></p>
    </div>

    <p>Untuk melaksanakan tugas:</p>
    <p><strong>Penyedotan Limbah Tangki Septik</strong></p>

    <div class="kelompok">
      <p><strong>Kode Booking:</strong> <span class="isian">{{ $item->kode_booking ?: '..................' }}</span></p>
      <p><strong>Nama Pelanggan:</strong> <span class="isian">{{ $item->nama_pelanggan ?: '..................' }}</span></p>
      <p><strong>Lokasi:</strong> <span class="isian">{{ $item->alamat_detail ?: $item->alamat }}</span></p>
      <p><strong>Nomor HP:</strong> <span class="isian">{{ $item->nomor_telepon_pelanggan ?: '..................' }}</span></p>
    </div>

    <p class="catatan">
      Tugas ini harus dilaksanakan dengan baik dan penuh tanggung jawab. Hasil pelaksanaan tugas agar dilaporkan kepada
      pimpinan UPTD.
    </p>

    <div class="ttd-kanan">
      <p>Samarinda, {{ ($item->tanggal_perintah ?? now())->translatedFormat('d F Y') }}</p>
      <p>Kepala UPTD Pengelolaan Air Limbah Domestik</p>
      <div class="garis-ttd">&nbsp;</div>
    </div>
  </div>

  @include('admin.pages.silalad.partials.skrip-cetak')
</body>

</html>
