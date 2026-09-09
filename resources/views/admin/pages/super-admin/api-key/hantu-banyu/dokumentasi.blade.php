{{-- Isi dokumentasi API yang spesifik untuk provider "hantu-banyu" - lihat
     admin.pages.super-admin.api-key.index untuk kerangka halamannya. --}}
<ol class="space-y-2 list-decimal list-inside">
  <li>Salin salah satu API Key di tabel di bawah.</li>
  <li>
    Di Postman (atau klien HTTP lain):
    <ul class="list-disc list-inside ml-5 space-y-1">
      <li>URL: <code class="bg-gray-100 px-2 py-0.5 rounded">POST
          {{ url('/api/hantu-banyu/laporan/upload') }}</code></li>
      <li>
        Header:
        <ul class="list-disc list-inside ml-6">
          <li><code>X-API-KEY</code>: tempelkan API Key Anda</li>
          <li><code>Accept</code>: <code>application/json</code></li>
        </ul>
      </li>
      <li>
        Body: pilih <code>form-data</code>, lalu isi field berikut:
        <ul class="list-disc list-inside ml-6 space-y-0.5">
          <li><code>nama_lengkap</code> — wajib, maksimal 100 karakter</li>
          <li><code>alamat</code> — wajib, alamat tempat tinggal pelapor</li>
          <li><code>nomor_telepon</code> — wajib, diawali <code>08</code>, 10-15 digit</li>
          <li><code>kelurahan_id</code> — wajib, id kelurahan lokasi kerusakan (kecamatan diturunkan otomatis
            dari kelurahan ini)</li>
          <li><code>nama_jalan</code> — wajib, maksimal 150 karakter</li>
          <li><code>latitude</code>, <code>longitude</code> — wajib, format desimal 7 angka di belakang koma
            (mis. <code>-0.4894570</code>)</li>
          <li><code>detail_lokasi</code> — wajib, patokan lokasi</li>
          <li><code>deskripsi_pengaduan</code> — wajib, uraian kerusakan</li>
          <li><code>foto[]</code> — wajib, minimal 1 berkas, JPG/JPEG/PNG, maksimal 2MB per berkas</li>
          <li><code>skm_nilai</code> — opsional, penilaian layanan 1-4</li>
          <li><code>skm_kritik</code>, <code>skm_saran</code> — opsional</li>
        </ul>
      </li>
    </ul>
  </li>
  <li>Kirim request. Respon sukses mengembalikan <code>id_laporan</code>, status awal
    <em>pending</em>, dan <code>detail_url</code> untuk memantau laporan.</li>
  <li>Pantau laporan lewat <code class="bg-gray-100 px-2 py-0.5 rounded">GET
      {{ url('/api/hantu-banyu/laporan/{id}') }}</code> memakai header yang sama.</li>
</ol>

<div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-lg p-3 text-sm">
  <i class="fa-solid fa-circle-info me-1"></i>
  Koordinat diverifikasi otomatis lewat reverse-geocode: titik yang berada di luar kelurahan yang dikirim akan
  ditolak dengan status <code>422</code>. Bila layanan verifikasi sedang tidak dapat dihubungi, laporan
  <strong>tidak disimpan sama sekali</strong> dan balasan berstatus <code>503</code> &mdash; permintaan yang sama
  aman dikirim ulang beberapa saat kemudian tanpa membuat laporan ganda. Kunci API Jalan Peduli tidak berlaku di
  endpoint ini, begitu pula sebaliknya.
</div>
