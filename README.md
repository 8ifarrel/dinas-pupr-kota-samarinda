# Website Dinas PUPR Kota Samarinda — Branch `hantu-banyu`

> Arsip riwayat pengembangan fitur **Hantu Banyu** (layanan pengaduan Drainase & Irigasi). Fiturnya sudah sepenuhnya tergabung ke `main` dengan penamaan final — branch ini tidak lagi dikembangkan. Untuk gambaran umum seluruh website beserta cara instalasi, lihat [README di branch `main`](../../tree/main#readme).

## Tentang Branch Ini

Fitur Hantu Banyu sudah final dan tergabung penuh ke `main`. Kode di branch ini sudah disamakan dengan `main` (penamaan `HantuBanyu*` yang konsisten) sehingga README ini bisa mendokumentasikan API dan strukturnya secara akurat. Branch ini disimpan sebagai tempat dokumentasi fitur, **bukan sebagai tempat melanjutkan pengembangan** — perbaikan bug atau fitur lanjutan tetap dikerjakan lewat branch baru dari `main`.

## Cakupan Fitur

Fitur Hantu Banyu melayani pengaduan warga terkait kondisi drainase dan irigasi di Kota Samarinda:

- **Pengaduan Publik** — warga mengajukan laporan lengkap dengan foto, titik koordinat, dan kelurahan terdampak
- **Reverse Geocoding** — koordinat laporan otomatis diterjemahkan menjadi nama jalan
- **Peta Sebaran** — visualisasi lokasi laporan pada peta
- **Bukti Pengaduan (PDF)** — tanda terima pengaduan dapat diunduh warga
- **Tindak Lanjut** — admin memperbarui status dan progres penanganan laporan
- **Login Kelurahan** — operator kelurahan memiliki akun tersendiri untuk mengelola laporan wilayahnya

## Struktur Kode

| Bagian | Isi |
|---|---|
| Controller guest | `HantuBanyuGuestController`, `HantuBanyuPengaduanGuestController`, `HantuBanyuPetaSebaranGuestController` |
| Controller admin | `HantuBanyuAdminController` |
| Controller API | `HantuBanyuApiKeyController`, `HantuBanyuLaporanController`, `GeocodingController` |
| View guest | `resources/views/guest/pages/hantu-banyu/` |
| View admin | `resources/views/admin/pages/hantu-banyu/` |
| Rute web | prefix `/hantu-banyu`, sebagian besar di belakang middleware `auth.kelurahan` |

## API

Dijaga kunci API khusus fitur `hantu-banyu` (awalan kunci `uptdsdi-`) — kunci Jalan Peduli maupun Akun Kelurahan tidak berlaku di sini. Kunci disertakan lewat header:

```
X-API-KEY: uptdsdi-xxxxxxxxxxxxxxxx
```

### Laporan

| Method | Endpoint | Keterangan |
|---|---|---|
| `POST` | `/api/hantu-banyu/laporan/upload` | Kirim laporan pengaduan drainase/irigasi baru |
| `GET` | `/api/hantu-banyu/laporan/{id}` | Detail satu laporan |

### Reverse Geocoding

| Method | Endpoint | Keterangan |
|---|---|---|
| `GET` | `/api/hantu-banyu/reverse-geocode?lat=...&lon=...` | Terjemahkan koordinat menjadi nama jalan. Tidak memerlukan kunci API |

### Manajemen Kunci API

Hanya bisa diakses super admin yang sudah login lewat web (bukan lewat `X-API-KEY`):

| Method | Endpoint |
|---|---|
| `GET` | `/api/hantu-banyu-keys` |
| `POST` | `/api/hantu-banyu-keys` |
| `GET` | `/api/hantu-banyu-keys/{id}` |
| `PUT` | `/api/hantu-banyu-keys/{id}` |
| `DELETE` | `/api/hantu-banyu-keys/{id}` |
| `POST` | `/api/hantu-banyu-keys/{id}/regenerate` |
| `GET` | `/api/hantu-banyu-keys/{id}/usage` |

`POST /api/hantu-banyu-keys/validate` bisa diakses siapa saja, untuk menguji apakah suatu kunci masih valid.

> **Jangan melanjutkan pengembangan di branch ini.** Branch ini murni tempat dokumentasi fitur yang sudah final. Bila ke depan ada perbaikan bug atau pengembangan lanjutan untuk fitur Hantu Banyu, buat branch baru dari `main`, kerjakan dan uji di sana, baru gabungkan kembali ke `main` setelah selesai.

## Instalasi & Menjalankan

Ikuti langkah instalasi umum di [README `main`](../../tree/main#readme). Tidak ada perbedaan proses setup antara branch ini dengan `main`.

## Lisensi & Kepemilikan

Proyek ini adalah properti **Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda** untuk keperluan internal dan layanan publik resmi.
