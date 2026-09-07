{{--
  Surat Jalan - catatan pelaksanaan yang dibawa petugas ke lapangan dan
  ditandatangani bersama pelanggan. Hanya bisa dicetak setelah pekerjaan
  dinyatakan selesai (lihat SilaladAdminController::printSuratJalan), karena
  jumlah rit baru diketahui setelah penyedotan.
--}}
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Surat Jalan {{ $item->kode_booking ?? $item->id }}</title>
  @include('admin.pages.silalad.partials.gaya-surat')
</head>

<body>
  <div class="container">
    <div class="no-print">
      <button onclick="window.print()">🖨 Cetak Surat Jalan</button>
    </div>

    <h1>SURAT JALAN</h1>
    <p class="subtitle">
      UPTD Pengelolaan Air Limbah Domestik<br>
      Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda
    </p>

    <div class="kelompok">
      <p><strong>KODE BOOKING:</strong> <span class="isian">{{ $item->kode_booking ?: '..................' }}</span></p>
      <p><strong>NAMA OPERATOR:</strong> <span class="isian">{{ $item->nama_operator ?: '..................' }}</span></p>
      <p><strong>NOMOR KENDARAAN:</strong> <span class="isian">{{ $item->nomor_kendaraan ?: '..................' }}</span></p>
      <p><strong>NAMA PELANGGAN:</strong> <span class="isian">{{ $item->nama_pelanggan ?: '..................' }}</span></p>
      <p><strong>ALAMAT:</strong> <span class="isian">{{ $item->alamat_detail ?: $item->alamat }}</span></p>
      <p>
        NO: <span class="isian">{{ $item->nomor_bangunan ?: '......' }}</span>
        &nbsp;&nbsp;&nbsp;
        RT: <span class="isian">{{ $item->rt ?: '......' }}</span>
      </p>
      <p><strong>KELURAHAN:</strong> <span class="isian">{{ $namaKelurahan ?: '..................' }}</span></p>
      <p><strong>KECAMATAN:</strong> <span class="isian">{{ $namaKecamatan ?: '..................' }}</span></p>
      <p><strong>NO. HP:</strong> <span class="isian">{{ $item->nomor_telepon_pelanggan ?: '..................' }}</span></p>
      <p><strong>JUMLAH RIT:</strong> <span class="isian">{{ $item->jumlah_rit ?: '......' }}</span></p>
    </div>

    {{-- tanggal_pelaksanaan, bukan tanggal simpan admin - surat ini
         ditandatangani bersama pelanggan di lokasi, jadi tanggalnya harus
         tanggal penyedotan benar-benar terjadi. --}}
    <p style="margin-top:32px;">Samarinda, {{ ($item->tanggal_pelaksanaan ?? now())->translatedFormat('d F Y') }}</p>

    <div class="ttd-dua">
      <div>
        <p>PETUGAS IPLT</p>
        <div class="garis-ttd">&nbsp;</div>
      </div>
      <div>
        <p>PELANGGAN</p>
        <div class="garis-ttd">{{ $item->nama_pelanggan ?: '&nbsp;' }}</div>
      </div>
    </div>

    <p class="kontak">Pengaduan pelayanan: Zulkifli (0811-5515-808)</p>
  </div>

  @include('admin.pages.silalad.partials.skrip-cetak')
</body>

</html>
