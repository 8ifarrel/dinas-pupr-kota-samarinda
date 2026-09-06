# Website Dinas PUPR Kota Samarinda — Branch `silalad`

> Fitur **SILALAD** (Sistem Informasi Layanan Limbah Domestik) — layanan sedot tinja. Untuk gambaran umum seluruh website beserta cara instalasi, lihat [README di branch `main`](../../tree/main#readme).

## Tentang Branch Ini

Branch `pkl-umkt/form-sedot-tinja` (tempat fitur ini awalnya dikembangkan oleh anak PKL, dengan nama kode `SedotTinja`) sudah sangat usang — bercabang dari `main` sejak Agustus 2025, dari saat itu Laravel di-*upgrade*, seeder ditata ulang, sistem kunci API dibuat, dan banyak hal lain di `main` berubah total. Karena itu, branch ini **bukan** hasil `git merge` langsung antara `main` dan branch sumber — merge mentah seperti itu akan menabrak ratusan baris tak terkait dan berisiko menyeret `main` mundur ke versi lama.

Yang dilakukan adalah **pemindahan manual**: kode milik fitur ini dipindah dan disesuaikan agar berjalan di atas `main` versi terkini, sementara berkas lintas-fitur (routing, seeder, config, dsb.) tetap versi `main`, hanya ditambahkan bagian fiturnya. Jadi branch ini = kode `main` terkini + fitur ini di atasnya, bukan gabungan mentah dua riwayat commit yang berbeda.

Sekaligus dengan pemindahan ini, seluruh penamaan kode (`SedotTinja`) diganti jadi **SILALAD** — nama resmi fitur ini (lihat tabel [Struktur Kode](#struktur-kode)) — dan sejumlah cacat pada kode sumber ikut diperbaiki. Rinciannya ada di bagian [Masalah yang Ditemukan di Branch Sumber](#masalah-yang-ditemukan-di-branch-sumber).

## Cakupan Fitur

- **Pendaftaran SILALAD** — warga mengisi form berisi data pelanggan, lokasi, jenis bangunan, dan captcha Cloudflare Turnstile
- **Kode Booking Otomatis** — format `SIL-<tahun>-<nomor urut>`
- **Cek Status** — warga melihat status pesanan berdasarkan nomor telepon yang dipakai saat mendaftar
- **Kelola Pesanan (Admin)** — data pesanan masuk, data terkonfirmasi, riwayat pesanan, ubah status, cetak pesanan

## Struktur Kode

| Bagian | Isi |
|---|---|
| Model | `App\Models\Silalad`, tabel `silalad` |
| Controller guest | `App\Http\Controllers\Guest\SilaladGuestController` |
| Controller admin | `App\Http\Controllers\Admin\SilaladAdminController` |
| View guest | `resources/views/guest/pages/silalad/` |
| View admin | `resources/views/admin/pages/silalad/` |
| Rute publik | prefix `/silalad` |
| Rute admin | prefix `/e-panel/silalad`, level akses Admin (bukan Super Admin) |

## Masalah yang Ditemukan di Branch Sumber

Daftar ini adalah cacat yang ditemukan pada branch `pkl-umkt/form-sedot-tinja`, bukan sesuatu yang muncul akibat proses pemindahan kode ke sini. Item yang sudah diperbaiki ditandai di awal kalimat.

- **(Sudah diperbaiki saat pemindahan)** Panel admin fitur ini sama sekali tidak menampilkan isi apa pun (halaman kosong tanpa error) — layout admin di `main` menyediakan slot `@yield('document.body')`, sedangkan seluruh halaman admin fitur ini ditulis memakai nama slot `@section('content')` yang berbeda dan tidak pernah dirender. Sudah ditambahkan `@yield('content')` di layout admin agar keduanya bisa dipakai berdampingan tanpa mengubah halaman admin fitur lain manapun.
- **(Sudah diperbaiki saat pemindahan)** Setiap halaman publik fitur ini pasti gagal (error 500) karena layout-nya memuat komponen `guest.components.flash-message` yang tidak pernah benar-benar dibuat. Diarahkan memakai `guest.components.alert`, komponen flash message yang sudah ada dan dipakai fitur lain.
- **(Sudah diperbaiki saat pemindahan)** Kebocoran data pribadi: halaman publik (daftar pesanan, detail pesanan, cek status) sebelumnya menampilkan nama, nomor telepon, dan alamat pelanggan ke siapa saja tanpa login maupun filter kepemilikan. Sekarang detail pesanan wajib menyertakan nomor telepon yang cocok lewat tautan yang sama dipakai saat pencarian status, dan histori/hasil pencarian di halaman cek status hanya menampilkan pesanan milik nomor telepon yang dicari.
- **(Sudah diperbaiki saat pemindahan)** Form edit pesanan di admin punya dua kotak "Kritik" dan "Saran" yang datanya selalu hilang diam-diam saat disimpan (bukan kolom yang ada di tabel). Sekarang keduanya digabung ke kolom asli, `saran_masukan`.
- **(Sudah diperbaiki saat pemindahan)** Validasi form admin menandai `jenis_bangunan`, `nomor_bangunan`, dan `rt` sebagai boleh kosong, padahal ketiga kolom itu wajib diisi di tabel — menyebabkan pesanan baru gagal disimpan (error database) kalau field itu kosong. Validasinya disamakan jadi wajib diisi.
- **(Sudah diperbaiki saat pemindahan)** Migrasi yang menambah ulang kolom `kode_booking` (sudah ada di migrasi pembuatan tabel) dan migrasi-migrasi kosong/tidak terpakai dari branch sumber tidak dibawa.
- **(Sudah diperbaiki saat pemindahan)** Rute admin & publik ditulis ulang bersih (branch sumber punya rute bertingkat ganda `admin/admin/sedot-tinja/...` serta nama rute yang didefinisikan berkali-kali).
- **(Sudah diperbaiki saat pemindahan)** Nama field `saran_dan_masukan` (model & validasi) disamakan dengan nama kolom asli di tabel, `saran_masukan`.
- **(Sudah diperbaiki saat pemindahan)** Data contoh (seeder) diperbaiki agar cocok dengan kolom yang benar-benar ada di tabel, dan mengisi `kode_booking` (kolom ini wajib diisi tapi seeder aslinya tidak mengisinya).
- **(Sudah diperbaiki saat pemindahan)** Verifikasi Cloudflare Turnstile disamakan dengan konvensi yang sudah dipakai Jalan Peduli (`config('app.turnstile_secret')`), bukan lewat paket composer yang sebenarnya tidak pernah dipakai kodenya.
- **(Sudah diperbaiki saat pemindahan)** Satu bug lama di `LoginAdminController` (login gagal tidak memberi respons apa pun) ikut terbawa perbaikannya dari branch sumber.
- **(Sudah diperbaiki saat pemindahan)** Berkas sampah yang ikut ter-*commit* di riwayat branch sumber (log `git log` yang salah redirect ke file, berkas `.tmp`) tidak dibawa ke branch ini.
- **Upload foto tidak tersimpan** — form pendaftaran memvalidasi field foto, tapi ternyata form-nya sendiri tidak punya input untuk mengunggah foto sama sekali — validasi itu dihapus karena tidak pernah dipicu. Bila ke depan fitur unggah foto ingin ditambahkan, form dan penyimpanan filenya perlu dibuat dari nol, bukan sekadar diaktifkan kembali.

Sudah diuji lewat migrasi, seeding, dan penjelajahan HTTP nyata (login admin, isi form publik & admin, ubah status pesanan) di lingkungan terisolasi sebelum branch ini didorong. Tampilan (HTML/CSS) halaman sengaja tidak diubah dari desain aslinya.

## Lisensi & Kepemilikan

Sama seperti `main` — proyek ini properti **Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda**, bukan proyek open-source untuk digunakan ulang di luar konteks tersebut tanpa izin.
