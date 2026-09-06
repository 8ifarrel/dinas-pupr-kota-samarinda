# Website Dinas PUPR Kota Samarinda — Branch `akun-kelurahan`

> Dokumentasi fitur **Akun Kelurahan** dan API-nya. Kode fitur ini sudah ada di `main` (bukan fitur terpisah yang menunggu digabung); branch ini murni tempat dokumentasinya. Untuk gambaran umum seluruh website beserta cara instalasi, lihat [README di branch `main`](../../tree/main#readme).

## Tentang Akun Kelurahan

Akun kelurahan adalah identitas login **milik bersama**, sengaja ditempatkan di level super admin (bukan di dalam salah satu fitur) supaya fitur mana pun yang butuh login kelurahan bisa memakai akun yang sudah ada, tanpa membangun sistem akun sendiri. Saat ini dipakai oleh **Hantu Banyu**; fitur mendatang yang butuh login kelurahan tinggal memakai akun yang sama.

Super admin mengelola akun kelurahan (buat, ubah, hapus) lewat panel admin.

## API

API ini dijaga kunci API khusus fitur `akun-kelurahan` — kunci Jalan Peduli maupun Hantu Banyu tidak berlaku di sini, begitu pula sebaliknya. Kunci diberi awalan `kelurahan-` dan disertakan lewat header:

```
X-API-KEY: kelurahan-xxxxxxxxxxxxxxxx
```

### Endpoint Data Akun

| Method | Endpoint | Keterangan |
|---|---|---|
| `GET` | `/api/akun-kelurahan` | Daftar seluruh akun kelurahan. Bisa difilter `?kecamatan_id=`. Tidak memuat kolom sandi |
| `GET` | `/api/akun-kelurahan/{id}` | Detail satu akun kelurahan |
| `POST` | `/api/akun-kelurahan/verifikasi` | Verifikasi `name` + `password`. Pemeriksaan lewat provider guard `kelurahan` yang sama persis dengan login web, sehingga hasilnya selalu konsisten dengan login web. Dibatasi `throttle:20,1` karena endpoint ini memeriksa kata sandi |

Contoh verifikasi:

```bash
curl -X POST https://domain-anda/api/akun-kelurahan/verifikasi \
  -H "X-API-KEY: kelurahan-xxxxxxxxxxxxxxxx" \
  -H "Content-Type: application/json" \
  -d '{"name": "kelurahan_taniaman", "password": "kata-sandi"}'
```

Respons memuat `success`, `message`, `valid`, dan (bila valid) `data` berisi `id`, `fullname`, `username`, `kelurahan`, `kecamatan`. Pesan gagal untuk username tidak dikenal maupun sandi salah **sengaja disamakan**, supaya endpoint ini tidak bisa dipakai menebak username mana yang terdaftar.

### Manajemen Kunci API

Hanya bisa diakses super admin yang sudah login lewat web (bukan lewat `X-API-KEY`):

| Method | Endpoint |
|---|---|
| `GET` | `/api/akun-kelurahan-keys` |
| `POST` | `/api/akun-kelurahan-keys` |
| `GET` | `/api/akun-kelurahan-keys/{id}` |
| `PUT` | `/api/akun-kelurahan-keys/{id}` |
| `DELETE` | `/api/akun-kelurahan-keys/{id}` |
| `POST` | `/api/akun-kelurahan-keys/{id}/regenerate` |
| `GET` | `/api/akun-kelurahan-keys/{id}/usage` |

`POST /api/akun-kelurahan-keys/validate` bisa diakses siapa saja, untuk menguji apakah suatu kunci masih valid.

## Fitur yang Memerlukan Akses Akun Kelurahan

Halaman-halaman berikut (di web ini, bukan API) hanya bisa diakses setelah login sebagai akun kelurahan:

- **Halaman utama Hantu Banyu** — beranda fitur setelah login
- **Kelola Akun Saya** — ubah username dan kata sandi akun kelurahan sendiri
- **Pengaduan Hantu Banyu** — buat pengaduan baru, kirim, lihat daftar dan detail pengaduan wilayahnya, lihat hasil, unduh bukti pengaduan (PDF)
- **Peta Sebaran** — visualisasi lokasi laporan Hantu Banyu

## Lisensi & Kepemilikan

Proyek ini adalah properti **Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda** untuk keperluan internal dan layanan publik resmi.
