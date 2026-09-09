{{-- Isi dokumentasi API yang spesifik untuk provider "akun-kelurahan" -
     lihat admin.pages.super-admin.api-key.index untuk kerangka halamannya. --}}
<p class="text-gray-600">
  Akun kelurahan adalah identitas milik bersama, bukan milik satu fitur. Kunci di halaman ini memungkinkan sistem
  lain memakai ulang akun kelurahan yang sudah ada &mdash; membaca daftarnya, atau memeriksa apakah sepasang
  username dan kata sandi memang sah &mdash; tanpa perlu membangun sistem akun sendiri.
</p>

<ol class="space-y-2 list-decimal list-inside">
  <li>Salin salah satu API Key di tabel di bawah.</li>
  <li>
    Di Postman (atau klien HTTP lain), sertakan header berikut di setiap permintaan:
    <ul class="list-disc list-inside ml-6">
      <li><code>X-API-KEY</code>: tempelkan API Key Anda</li>
      <li><code>Accept</code>: <code>application/json</code></li>
    </ul>
  </li>
  <li>
    Daftar akun kelurahan: <code class="bg-gray-100 px-2 py-0.5 rounded">GET
      {{ url('/api/akun-kelurahan') }}</code>
    <ul class="list-disc list-inside ml-6 space-y-0.5">
      <li><code>kecamatan_id</code> — opsional, saring berdasarkan kecamatan</li>
    </ul>
  </li>
  <li>
    Detail satu akun: <code class="bg-gray-100 px-2 py-0.5 rounded">GET
      {{ url('/api/akun-kelurahan/{id}') }}</code>
  </li>
  <li>
    Verifikasi kredensial: <code class="bg-gray-100 px-2 py-0.5 rounded">POST
      {{ url('/api/akun-kelurahan/verifikasi') }}</code>
    <ul class="list-disc list-inside ml-6 space-y-0.5">
      <li>Body <code>form-data</code> atau JSON: <code>name</code> (username) dan <code>password</code></li>
      <li>Bila cocok, balasan berisi <code>valid: true</code> beserta identitas kelurahan dan kecamatannya</li>
      <li>Bila tidak cocok, balasan berstatus <code>401</code> dengan <code>valid: false</code></li>
    </ul>
  </li>
</ol>

<div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-lg p-3 text-sm">
  <i class="fa-solid fa-circle-info me-1"></i>
  Kata sandi <strong>tidak pernah</strong> dikembalikan oleh endpoint mana pun di sini, bahkan dalam bentuk
  terenkripsi. Endpoint verifikasi memberi pesan yang sama persis untuk username tidak dikenal maupun kata sandi
  salah, supaya tidak bisa dipakai menebak username mana yang terdaftar, dan dibatasi
  <strong>20 permintaan per menit</strong> per alamat IP. Kunci API Jalan Peduli maupun Hantu Banyu tidak berlaku
  di endpoint ini, begitu pula sebaliknya.
</div>
