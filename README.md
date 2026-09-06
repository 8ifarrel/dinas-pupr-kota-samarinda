# Website Dinas PUPR Kota Samarinda — Branch `buku-tamu`

> Cabang kode fitur **Buku Tamu**. Untuk gambaran umum seluruh website beserta cara instalasi, lihat [README di branch `main`](../../tree/main#readme).

## ⚠️ Pengembangan Fitur Ini Tidak Dilanjutkan

Fitur Buku Tamu di branch ini **tidak dilanjutkan pengembangannya** dan tidak digabungkan ke `main`. Branch ini disimpan sebagai riwayat kode, bukan sebagai fitur yang aktif dikembangkan maupun dipakai di produksi.

Bila di kemudian hari fitur pendaftaran tamu kunjungan ingin dihidupkan kembali, jangan melanjutkan langsung di branch ini — kode di `main` sudah berjalan jauh sejak branch ini terakhir disentuh, sehingga melanjutkan di sini berarti bekerja di atas basis kode yang tertinggal. Buat branch baru dari `main`, lalu ambil bagian yang relevan dari branch ini sebagai referensi.

## Cakupan Fitur

Buku Tamu adalah fitur pendaftaran kunjungan tamu ke kantor dinas:

- **Pendaftaran Tamu** — pengunjung mengisi formulir kunjungan (nama, kontak, alamat, maksud & tujuan, pejabat yang dituju)
- **Nomor Antrean** — setiap pendaftaran mendapat nomor urut
- **Status Kunjungan** — `Pending`, `Diterima`, `Ditolak`, `Selesai`; pengunjung dapat memeriksa status kunjungannya
- **Layar Display Antrean** — halaman khusus untuk ditampilkan di layar kantor, menampilkan antrean tamu secara langsung
- **Verifikasi Admin** — admin per susunan organisasi mengelola dan memperbarui status kunjungan yang ditujukan kepadanya
- **Pembatasan Akses** — seluruh halaman tamu (kecuali cek status) dan halaman display hanya bisa diakses dari IP tertentu (jaringan kantor), lewat middleware `AllowCertainIpOnly`

## Struktur Kode

| Bagian | Isi |
|---|---|
| Controller guest | `BukuTamuGuestController`, `BukuTamuDisplayGuestController` |
| Controller admin | `BukuTamuAdminController` |
| Model | `BukuTamu` |
| Migrasi | `database/migrations/2025_07_28_300000_create_buku_tamu_table.php` |
| View guest | `resources/views/guest/pages/buku-tamu/` |
| View admin | `resources/views/admin/buku-tamu/` |
| Rute | prefix `/buku-tamu` (guest), `/e-panel/buku-tamu` (admin) |

## Instalasi & Menjalankan

Ikuti langkah instalasi umum di [README `main`](../../tree/main#readme). Tidak ada perbedaan proses setup antara branch ini dengan `main`.

## Lisensi & Kepemilikan

Proyek ini adalah properti **Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda** untuk keperluan internal dan layanan publik resmi.
