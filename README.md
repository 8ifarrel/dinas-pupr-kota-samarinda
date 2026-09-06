# Website Dinas PUPR Kota Samarinda — Branch `hantu-banyu`

> Cabang pengembangan fitur **Hantu Banyu** (layanan pengaduan Drainase & Irigasi). Untuk gambaran umum seluruh website beserta cara instalasi, lihat [README di branch `main`](../../tree/main#readme).

## Tentang Branch Ini

Branch ini adalah riwayat pengembangan fitur Hantu Banyu sejak tahap awal, ketika kodenya masih memakai penamaan **Drainase Irigasi** (`DrainaseIrigasiGuestController`, `DrainaseIrigasiLaporan`, dsb.) sebelum dirapikan dan diganti nama menjadi **Hantu Banyu** pada `main`. Sebagian tampilan admin di sini sudah memakai nama baru, sementara kode guest-facing masih dengan penamaan lama — mencerminkan proses migrasi penamaan yang sedang berjalan.

**Versi fitur yang sudah selesai dan stabil ada di branch `main`.** Gunakan branch ini bila Anda melanjutkan riwayat pengembangan fitur ini, bukan sebagai sumber kode produksi.

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

## Instalasi & Menjalankan

Ikuti langkah instalasi umum di [README `main`](../../tree/main#readme). Tidak ada perbedaan proses setup antara branch ini dengan `main`.

## Lisensi & Kepemilikan

Proyek ini adalah properti **Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda** untuk keperluan internal dan layanan publik resmi.
