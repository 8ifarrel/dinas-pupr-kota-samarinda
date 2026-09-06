# Website Dinas PUPR Kota Samarinda — Branch `silalad`

> Fitur **SILALAD** (Sistem Informasi Layanan Limbah Domestik) — layanan sedot tinja. Untuk gambaran umum seluruh website beserta cara instalasi, lihat [README di branch `main`](../../tree/main#readme).

## Tentang Branch Ini

Branch `pkl-umkt/form-sedot-tinja` (tempat fitur ini awalnya dikembangkan oleh anak PKL) sudah sangat usang — bercabang dari `main` sejak Agustus 2025, dari saat itu Laravel di-*upgrade*, seeder ditata ulang, sistem kunci API dibuat, dan banyak hal lain di `main` berubah total. Karena itu, branch ini **bukan** hasil `git merge` langsung antara `main` dan branch sumber — merge mentah seperti itu akan menabrak ratusan baris tak terkait dan berisiko menyeret `main` mundur ke versi lama.

Yang dilakukan adalah **pemindahan manual**: kode milik fitur SILALAD dipindah dan disesuaikan agar berjalan di atas `main` versi terkini, sementara berkas lintas-fitur (routing, seeder, config, dsb.) tetap versi `main`, hanya ditambahkan bagian SILALAD-nya. Jadi branch ini = kode `main` terkini + fitur SILALAD di atasnya, bukan gabungan mentah dua riwayat commit yang berbeda.

Selama proses ini, beberapa cacat *mekanis* bawaan branch sumber (yang membuat instalasi baru gagal total) ikut diperbaiki agar branch ini minimal bisa di-*migrate* dan di-*seed*. Cacat pada **logika/keamanan fitur itu sendiri** tidak diperbaiki di sini — lihat bagian [Masalah yang Ditemukan di Branch Sumber](#masalah-yang-ditemukan-di-branch-sumber) — sehingga fitur ini belum digabungkan ke `main`.

## Cakupan Fitur

- **Pendaftaran Sedot Tinja** — warga mengisi form berisi data pelanggan, lokasi, jenis bangunan, dan captcha Cloudflare Turnstile
- **Kode Booking Otomatis** — format `STJ-<tahun>-<nomor urut>`
- **Cek Status** — warga melihat status pesanan berdasarkan riwayat/nomor telepon
- **Kelola Pesanan (Admin)** — data pesanan masuk, data terkonfirmasi, riwayat pesanan, ubah status, cetak pesanan

## Struktur Kode

| Bagian | Isi |
|---|---|
| Model | `App\Models\SedotTinja` |
| Controller guest | `App\Http\Controllers\Guest\SedotTinjaGuestController` |
| Controller admin | `App\Http\Controllers\Admin\SedotTinjaAdminController` |
| View guest | `resources/views/guest/pages/sedot-tinja/` |
| View admin | `resources/views/admin/pages/sedot-tinja/` |
| Rute publik | prefix `/sedot-tinja` |
| Rute admin | prefix `/e-panel/sedot-tinja`, level akses Admin (bukan Super Admin) |

## Masalah yang Ditemukan di Branch Sumber

Daftar ini adalah cacat yang ditemukan pada branch `pkl-umkt/form-sedot-tinja`, bukan sesuatu yang muncul akibat proses pemindahan kode ke sini.

### Sudah Diperbaiki Saat Dipindahkan

Cacat *mekanis* berikut membuat instalasi baru gagal total, jadi ikut diperbaiki agar branch ini minimal bisa dipasang dari kosong (`migrate` + `seed`) — bukan perubahan perilaku fitur:

- Migrasi yang menambah ulang kolom `kode_booking` (sudah ada di migrasi pembuatan tabel) dan migrasi-migrasi kosong/tidak terpakai dari branch sumber **tidak dibawa**.
- Rute admin & publik ditulis ulang bersih (branch sumber punya rute bertingkat ganda `admin/admin/sedot-tinja/...` serta nama rute yang didefinisikan berkali-kali).
- Nama field `saran_dan_masukan` (model & validasi) disamakan dengan nama kolom asli di tabel, `saran_masukan`.
- Data contoh (seeder) diperbaiki agar cocok dengan kolom yang benar-benar ada di tabel, dan mengisi `kode_booking` (kolom ini wajib diisi tapi seeder aslinya tidak mengisinya).
- Verifikasi Cloudflare Turnstile disamakan dengan konvensi yang sudah dipakai Jalan Peduli (`config('app.turnstile_secret')`), bukan lewat paket composer yang sebenarnya tidak pernah dipakai kodenya.
- Satu bug lama di `LoginAdminController` (login gagal tidak memberi respons apa pun) ikut terbawa perbaikannya dari branch sumber.

Sudah diuji: `php artisan migrate` dan `php artisan db:seed` dari basis data kosong berjalan tanpa error di lingkungan terisolasi sebelum branch ini didorong.

### Belum Diperbaiki

Dipertahankan apa adanya dari branch sumber, belum diperbaiki di branch ini:

- **Kebocoran data pribadi** — halaman publik (daftar pesanan, detail pesanan, cek status) menampilkan nama, nomor telepon, dan alamat pelanggan ke siapa saja tanpa login maupun filter kepemilikan.
- **Upload foto tidak tersimpan** — form pendaftaran memvalidasi field foto, tapi file-nya tidak pernah benar-benar disimpan.
- **Nomor & email admin di-hardcode** di kode (bukan di `.env`), dipakai untuk notifikasi WhatsApp/email.
- **Berkas sampah** ikut ter-*commit* di riwayat branch sumber (log `git log` yang salah redirect ke file, berkas `.tmp`) — sudah tidak dibawa ke branch ini, disebut di sini sebagai catatan riwayat saja.

## Lisensi & Kepemilikan

Sama seperti `main` — proyek ini properti **Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda**, bukan proyek open-source untuk digunakan ulang di luar konteks tersebut tanpa izin.
