# Website Dinas PUPR Kota Samarinda

Website resmi **Dinas Pekerjaan Umum dan Penataan Ruang (PUPR) Kota Samarinda** — portal informasi publik sekaligus panel administrasi untuk mengelola konten dan layanan dinas.

Dibangun dengan [Laravel 12](https://laravel.com/) di sisi backend dan [Tailwind CSS](https://tailwindcss.com/) + [Alpine.js](https://alpinejs.dev/) di sisi frontend.

## Daftar Isi

- [Fitur](#fitur)
- [Teknologi](#teknologi)
- [Instalasi](#instalasi)
- [Konfigurasi Environment](#konfigurasi-environment)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Struktur Branch](#struktur-branch)
- [Menjalankan Test](#menjalankan-test)
- [Lisensi & Kepemilikan](#lisensi--kepemilikan)

## Fitur

### Portal Publik

- **Profil Dinas** — sejarah, visi & misi, tupoksi, struktur organisasi, profil Kepala Dinas
- **Berita & Pengumuman** — publikasi berita per kategori dan pengumuman resmi
- **PPID Pelaksana** — informasi publik sesuai kategori PPID
- **Agenda & Album Kegiatan** — jadwal kegiatan dan galeri dokumentasi
- **Survei Kepuasan Masyarakat (SKM)** — pengisian dan rekap kepuasan layanan
- **Jalan Peduli** — pelaporan kerusakan jalan oleh warga beserta peta sebaran dan status tindak lanjut
- **Hantu Banyu** *(Drainase & Irigasi)* — pengaduan drainase/irigasi oleh operator kelurahan; lihat [detail fitur ini di branch `hantu-banyu`](../../tree/hantu-banyu#readme)
- **Statistik Pengunjung** — pencatatan kunjungan situs dengan penyaringan lalu lintas bot/cloud

### Panel Admin (E-Panel)

- Manajemen konten (berita, pengumuman, PPID, agenda, album, partner, slider)
- Manajemen struktur organisasi dan akun admin (dengan level super admin)
- Manajemen akun kelurahan (dipakai bersama oleh fitur Hantu Banyu dan fitur mendatang lain yang membutuhkan login kelurahan)
- API key per-fitur untuk integrasi eksternal
- Log aktivitas admin

## Teknologi

| Lapisan | Teknologi |
|---|---|
| Backend | PHP 8.2+, Laravel 12 |
| Frontend | Blade, Tailwind CSS, Alpine.js, Vite |
| Basis Data | MySQL |
| PDF | Browsershot (Puppeteer/Node) |
| Lainnya | Laravel Sanctum-style API key custom, Yajra DataTables, PhpSpreadsheet |

## Instalasi

### Prasyarat

- PHP ^8.2 dengan ekstensi standar Laravel
- Composer
- Node.js & npm
- MySQL
- Node/npm dapat diakses dari PATH (dibutuhkan Browsershot untuk PDF Hantu Banyu; lihat [Konfigurasi Environment](#konfigurasi-environment) bila berjalan di Windows)

### Langkah

```bash
git clone https://github.com/8ifarrel/dinas-pupr-kota-samarinda.git
cd dinas-pupr-kota-samarinda

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Buat basis data MySQL kosong, lalu isi kredensialnya di `.env` (lihat bagian berikutnya), kemudian:

```bash
php artisan migrate
php artisan db:seed   # opsional, mengisi data contoh untuk pengembangan
```

## Konfigurasi Environment

Salin `.env.example` menjadi `.env` lalu sesuaikan sekurang-kurangnya:

| Variabel | Keterangan |
|---|---|
| `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | Kredensial MySQL. Proyek ini **tidak** memakai SQLite bawaan Laravel |
| `IPINFO_TOKEN` | Token [IPInfo](https://ipinfo.io/), dipakai statistik pengunjung untuk menyaring lalu lintas cloud/datacenter. Boleh dikosongkan (penyaring dilewati) |
| `MAPTILER_TOKEN` | Token [MapTiler](https://www.maptiler.com/), dipakai peta sebaran Jalan Peduli |
| `TURNSTILE_SITEKEY`, `TURNSTILE_SECRET` | Kredensial [Cloudflare Turnstile](https://developers.cloudflare.com/turnstile/), captcha pada form laporan Jalan Peduli |
| `BROWSERSHOT_NODE_BINARY`, `BROWSERSHOT_NPM_BINARY` | Path Node/npm untuk PDF Hantu Banyu. Biarkan kosong di Linux (dideteksi otomatis dari PATH); di Windows isi dengan path lengkap berkutip tunggal |

Detail lengkap dan komentar tiap variabel ada di `.env.example`.

## Menjalankan Aplikasi

```bash
php artisan serve
npm run dev       # kompilasi aset saat pengembangan
```

Untuk produksi:

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Struktur Branch

| Branch | Isi |
|---|---|
| `main` | Cabang rilis, berisi seluruh fitur yang sudah selesai |
| `hantu-banyu` | Arsip riwayat pengembangan fitur Drainase & Irigasi. Sudah sepenuhnya tergabung ke `main` dengan penamaan final; branch ini disimpan sebagai riwayat, bukan untuk dikembangkan lebih lanjut |
| `buku-tamu` | Pengembangan aktif fitur Buku Tamu (belum digabung ke `main`) |
| `kkn-unmul/jalan-peduli`, `pkl-umkt/*` | Cabang kerja mitra magang/KKN untuk fitur tertentu |

## Menjalankan Test

```bash
php artisan test
```

## Lisensi & Kepemilikan

Proyek ini adalah properti **Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda** untuk keperluan internal dan layanan publik resmi. Bukan proyek open-source untuk digunakan ulang di luar konteks tersebut tanpa izin.
