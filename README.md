# Website Dinas PUPR Kota Samarinda — Branch `akun-kelurahan`

> Dokumentasi fitur **Akun Kelurahan** dan API-nya. Kode fitur ini sudah ada di `main` (bukan fitur terpisah yang menunggu digabung); branch ini murni tempat dokumentasinya. Untuk gambaran umum seluruh website beserta cara instalasi, lihat [README di branch `main`](../../tree/main#readme).

## Tentang Akun Kelurahan

Akun kelurahan adalah satu identitas login yang dipakai bersama oleh fitur mana pun yang membutuhkan login kelurahan — bukan akun yang dimiliki atau dibuat khusus untuk satu fitur tertentu. Saat ini dipakai oleh **Hantu Banyu**; fitur mendatang yang butuh login kelurahan tinggal memakai akun yang sudah ada, tanpa perlu membangun sistem akunnya sendiri.

Hanya admin dengan akses **super admin** yang bisa mengelola seluruh akun kelurahan (membuat, mengubah, dan menghapus) lewat panel admin.

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

1. **Hantu Banyu**

## Lisensi & Kepemilikan

Proyek ini adalah properti **Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda** untuk keperluan internal dan layanan publik resmi.
