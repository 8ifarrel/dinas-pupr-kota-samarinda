# Website Dinas PUPR Kota Samarinda — Branch `hantu-banyu`

> Arsip riwayat pengembangan fitur **Hantu Banyu** (layanan pengaduan Drainase & Irigasi). Fiturnya sudah sepenuhnya tergabung ke `main` dengan penamaan final — branch ini tidak lagi dikembangkan. Untuk gambaran umum seluruh website beserta cara instalasi, lihat [README di branch `main`](../../tree/main#readme).

## Tentang Branch Ini

Branch ini adalah snapshot pengembangan fitur Hantu Banyu pada tahap awal, ketika kodenya masih memakai penamaan **Drainase Irigasi** (`DrainaseIrigasiGuestController`, `DrainaseIrigasiLaporan`, dsb.), sebelum kemudian dirapikan dan diganti nama menjadi **Hantu Banyu** secara konsisten pada `main`. Sebagian tampilan admin di sini sudah memakai nama baru, sementara kode guest-facing masih dengan penamaan lama — jejak proses ganti nama yang saat itu sedang berjalan.

Riwayat commit branch ini berhenti di titik yang sudah menyatu penuh ke `main` (tidak ada perubahan yang tertinggal). **Versi fitur yang sudah selesai dan stabil ada di branch `main`.** Branch ini disimpan sebagai riwayat, bukan sebagai sumber kode produksi maupun tempat melanjutkan pengembangan.

## Cakupan Fitur

Fitur Hantu Banyu melayani pengaduan warga terkait kondisi drainase dan irigasi di Kota Samarinda:

- **Pengaduan Publik** — warga mengajukan laporan lengkap dengan foto, titik koordinat, dan kelurahan terdampak
- **Reverse Geocoding** — koordinat laporan otomatis diterjemahkan menjadi nama jalan
- **Peta Sebaran** — visualisasi lokasi laporan pada peta
- **Bukti Pengaduan (PDF)** — tanda terima pengaduan dapat diunduh warga
- **Tindak Lanjut** — admin memperbarui status dan progres penanganan laporan
- **Login Kelurahan** — operator kelurahan memiliki akun tersendiri untuk mengelola laporan wilayahnya

## Struktur Kode di Branch Ini

| Bagian | Penamaan di branch ini |
|---|---|
| Controller guest | `DrainaseIrigasiGuestController`, `DrainaseIrigasiPengaduanGuestController`, `DrainaseIrigasiPetaSebaranGuestController` |
| Controller admin | `HantuBanyuAdminController` |
| Model | `DrainaseIrigasiLaporan`, `DrainaseIrigasiLaporanFoto`, `DrainaseIrigasiLaporanTindakLanjut`, `DrainaseIrigasiPelapor` |
| Migrasi | `database/migrations/2025_08_03_*_drainase_irigasi_*` |
| View guest | `resources/views/guest/pages/drainase-irigasi/` |
| View admin | `resources/views/admin/pages/hantu-banyu/` |
| Rute | prefix `/drainase-irigasi`, nama rute `guest.drainase-irigasi.*` |

Di `main`, seluruh bagian di atas sudah konsisten memakai penamaan `HantuBanyu*`.

> **Jangan melanjutkan pengembangan di branch ini.** Bila ke depan ada perbaikan bug atau pengembangan lanjutan untuk fitur Hantu Banyu, buat branch baru dari `main` (bukan dari branch ini), kerjakan dan uji di sana, baru gabungkan kembali ke `main` setelah selesai. Melanjutkan di sini berarti bekerja di atas kode yang sudah usang.

## Instalasi & Menjalankan

Ikuti langkah instalasi umum di [README `main`](../../tree/main#readme). Tidak ada perbedaan proses setup antara branch ini dengan `main`.

## Lisensi & Kepemilikan

Proyek ini adalah properti **Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda** untuk keperluan internal dan layanan publik resmi.
