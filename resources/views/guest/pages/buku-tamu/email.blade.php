<!DOCTYPE html>
<html>

<head>
  <title>Konfirmasi Pengajuan Buku Tamu</title>
</head>

<body>
  <h1>Konfirmasi Pengajuan Buku Tamu</h1>
  <p>Terima kasih telah mengajukan permohonan buku tamu. Kami sangat menghargai perhatian dan waktu Anda.</p>

  <p>Untuk memantau <strong>status kunjungan</strong> Anda, silakan klik tautan di bawah ini:</p>
  <a href="https://pupr.samarindakota.go.id/buku-tamu/status?id={{ $idBukuTamu }}"><strong>Lihat Status Kunjungan</strong></a>

  <p>Harap terus memantau status kunjungan Anda secara berkala. Terima kasih atas perhatiannya.</p>

  <p><strong>Detail Pengajuan:</strong></p>
  <ul style="padding-left: 25px">
    <li style="padding-bottom: 2.5px"><strong>Kode: </strong> {{ $idBukuTamu }}</li>
    <li style="padding-bottom: 2.5px"><strong>Nama Pengunjung: </strong> {{ $data['nama_pengunjung'] }}</li>
    <li style="padding-bottom: 2.5px"><strong>Nomor Telepon Pengunjung: </strong> {{ $data['nomor_telepon'] }}</li>
    <li style="padding-bottom: 2.5px"><strong>Email Pengunjung: </strong> {{ $data['email'] }}</li>
    <li style="padding-bottom: 2.5px"><strong>Alamat Asal Pengunjung:</strong> <br> {{ $data['alamat'] }}</li>
    <li style="padding-bottom: 2.5px"><strong>Bagian yang Akan Dikunjungi:</strong> <br> {{ App\Models\SusunanOrganisasi::find($data['jabatan_yang_dikunjungi'])->nama_susunan_organisasi }}</li>
    <li><strong>Keperluan:</strong> <br> {{ $data['maksud_dan_tujuan'] }}</li>
  </ul>

  <p><em>Pesan ini dibuat secara otomatis menggunakan sistem kami.</em></p>

  <hr>

  <p class="text-white text-center text-sm">
    <em>© 2024 {{ config('app.nama_dinas') }}. Powered by Tim IT {{ config('app.nama_singkatan_dinas') }}.</em>
  </p>
</body>

</html>

