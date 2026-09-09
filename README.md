# Website Dinas PUPR Kota Samarinda — Branch `hantu-banyu`

> Pengembangan lanjutan fitur **Hantu Banyu** (layanan pengaduan Drainase & Irigasi). Fitur ini sebelumnya sudah tergabung penuh ke `main` dengan penamaan final, tapi ada penyesuaian lanjutan yang perlu dikerjakan sehingga branch ini dibuka kembali. Untuk gambaran umum seluruh website beserta cara instalasi, lihat [README di branch `main`](../../tree/main#readme).

## Tentang Branch Ini

Fitur Hantu Banyu sempat ditandai final dan tergabung penuh ke `main`, dengan branch ini disimpan murni sebagai dokumentasi (kode sudah disamakan dengan `main`, penamaan `HantuBanyu*` sudah konsisten). Status itu kini dicabut sementara: branch ini **kembali aktif dikembangkan langsung** untuk mengerjakan penyesuaian lanjutan pada fitur Hantu Banyu. Setelah penyesuaian selesai diuji, gabungkan kembali ke `main` dan pulihkan catatan "final" di README `main` maupun di README ini.

## Cakupan Fitur

Fitur Hantu Banyu melayani pengaduan warga terkait kondisi drainase dan irigasi di Kota Samarinda:

- **Pengaduan Publik** — warga mengajukan laporan lengkap dengan foto, titik koordinat, dan kelurahan terdampak
- **Reverse Geocoding** — koordinat laporan otomatis diterjemahkan menjadi nama jalan
- **Peta Sebaran** — visualisasi lokasi laporan pada peta
- **Bukti Pengaduan (PDF)** — tanda terima pengaduan dapat diunduh warga
- **Tindak Lanjut** — admin memperbarui status dan progres penanganan laporan
- **Login Kelurahan & Admin** — operator kelurahan memiliki akun tersendiri untuk wilayahnya; admin E-Panel dapat login dengan akun yang sama di kedua sisi (lihat di bawah)
- **Rekap Laporan (PDF & Excel)** — unduhan rekap untuk semua data, satu tahun, satu bulan, atau rentang bulan
- **Penyaringan Daftar Laporan** — pencarian, status, jenis, rentang tanggal masuk, dan asal pelapor

### Dua Macam Akun di Sisi Guest

Halaman `/hantu-banyu` menerima dua macam akun yang tersimpan di guard berbeda tapi berbagi satu session:

| | Akun kelurahan (`kelurahan`) | Admin E-Panel (`web`) |
|---|---|---|
| Wilayah yang terlihat | hanya kelurahannya | seluruh kelurahan |
| Membuat laporan | terkunci di kelurahannya | bebas memilih kelurahan |
| Tercatat sebagai | `Operator Kelurahan <nama>` | `Admin UPTD PSDI` |
| Statistik | tanpa sebaran per kecamatan (isinya pasti satu kecamatan saja) | sama dengan statistik E-Panel, termasuk sebaran per kelurahan |
| Kelola akun | lewat halaman guest | lewat E-Panel |

Karena keduanya memakai session yang sama, **admin yang login di salah satu sisi otomatis login di sisi lain** — begitu pula logout. Aturan "siapa yang login dan terkunci di kelurahan mana" hanya ditulis di satu tempat, `App\Support\HantuBanyu\Konteks`, supaya tidak ada controller yang menerapkannya secara berbeda.

### Hak Melihat vs Hak Mengelola

Seluruh admin boleh **melihat** isi Hantu Banyu — daftar laporan, detail, statistik, peta sebaran, dan unduhan rekap. Yang dibatasi hanya hak **mengelola**, yaitu membuat laporan dan mengisi tindak lanjut:

| Akun | Melihat | Mengelola |
|---|---|---|
| Super admin | ya | ya |
| Admin unit pemilik layanan | ya | ya |
| Admin unit lain | ya | tidak |
| Akun kelurahan | ya (wilayahnya) | ya (wilayahnya) |

Unit pemiliknya **tidak ditulis sebagai angka tetap**, melainkan ditelusuri dari data: `layanan.nama = 'hantu_banyu'` → `struktur_organisasi` → `susunan_organisasi` (saat ini UPTD Pemeliharaan Saluran Drainase dan Irigasi). Kalau kepemilikan layanan dipindahkan lewat data, hak aksesnya ikut berpindah sendiri tanpa mengubah kode. Bila rantai data itu putus, hak kelola ditutup untuk semua admin non-super — menutup akses lebih aman daripada membukanya karena data hilang.

Penjagaannya ada di middleware `hantu-banyu.kelola` (`App\Http\Middleware\HantuBanyuPengelola`) yang dipasang pada rute pengubah data, bukan sekadar menyembunyikan tombol — tombol yang hilang tidak menghalangi permintaan yang dikirim langsung ke rutenya. Admin yang hanya boleh melihat tetap dapat membuka halaman kelola laporan, tapi dalam mode lihat saja: formnya tidak dirender sama sekali dan alasannya dijelaskan di halaman.

Asal pembuat laporan disimpan di kolom `dibuat_oleh_tipe` (+ `dibuat_oleh_user_id` untuk telusur) pada tabel `hantu_banyu_laporan`. Laporan yang dibuat sebelum kolom ini ada otomatis terhitung sebagai buatan operator kelurahan — memang begitu keadaannya, karena dulu hanya akun kelurahan yang bisa membuat laporan.

## Struktur Kode

| Bagian | Isi |
|---|---|
| Controller guest | `HantuBanyuGuestController`, `HantuBanyuPengaduanGuestController`, `HantuBanyuPetaSebaranGuestController` |
| Controller admin | `HantuBanyuAdminController` |
| Controller API | `HantuBanyuApiKeyController`, `HantuBanyuLaporanController`, `GeocodingController` |
| Penentu hak akses | `App\Support\HantuBanyu\Konteks` — satu-satunya penjawab "siapa yang login, terkunci di kelurahan mana, dan boleh mengelola atau tidak" |
| Penjaga aksi ubah | middleware `hantu-banyu.kelola` (`HantuBanyuPengelola`) pada rute buat laporan & simpan tindak lanjut |
| Geocoding bersama | `App\Support\Geocoding\OverpassJalanTerdekat` — dipakai `GeocodingController` dan `HantuBanyuSeeder` |
| View guest | `resources/views/guest/pages/hantu-banyu/` |
| View admin | `resources/views/admin/pages/hantu-banyu/` |
| Rute web | prefix `/hantu-banyu`, sebagian besar di belakang middleware `auth.kelurahan` (menerima akun kelurahan maupun admin) |

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

## Data Contoh (Seeder)

`HantuBanyuSeeder` mengisi **462 laporan** (7 tahap penanganan × 66 kelurahan Samarinda) supaya papan status, peta sebaran, dan statistik selalu punya contoh di semua kelurahan sekaligus semua tahap. Beberapa aturan realisme yang dijaga:

- **Koordinat & nama jalan bukan karangan, dan keduanya dijamin sinkron.** Titiknya tidak diacak lalu ditebak nama jalannya; urutannya justru dibalik. Untuk tiap kelurahan, batas wilayahnya diambil dari Nominatim (sekalian poligonnya lewat `polygon_geojson`), lalu **satu** panggilan Overpass API mengambil seluruh ruas jalan bernama **di dalam batas itu** — bukan sekadar dalam radius, yang mau tidak mau ikut menjaring jalan milik kelurahan tetangga. Ketujuh titik laporan diletakkan tepat pada simpul ruas jalan tersebut, dengan syarat: berada di dalam poligon kelurahan, minimal 120 m dari titik lain di kelurahan yang sama, dan minimal 30 m dari titik milik kelurahan lain (ruas jalan batas wilayah bisa terambil dua kali). Hasilnya **462 laporan menempati 462 koordinat berbeda**, dan uji petik acak lewat reverse-geocode menunjukkan seluruh sampel jatuh di kelurahan yang benar. Overpass dipanggil lewat `App\Support\Geocoding\OverpassJalanTerdekat` — kelas yang sama dipakai `GeocodingController` di fitur peta sebaran, jadi data contoh tidak bisa melenceng dari perilaku fitur aslinya.
- **Data geocoding dibekukan, bukan dipanggil ulang tiap seed.** Hasil pengumpulan disimpan di `database/seeders/Support/HantuBanyuTitikGeocode.php`, jadi `db:seed` sehari-hari tidak menyentuh jaringan sama sekali. Mengumpulkan ulang seluruh 66 kelurahan makan waktu ±45 menit karena Nominatim dan Overpass sama-sama dibatasi ~1 request/detik. Kelurahan pemekaran kecil yang tidak punya batas wilayah sendiri di OSM (mayoritas kelompok "Sungai Pinang ...") tidak bisa disaring seakurat itu: titiknya diambil dari sekitar pusat kecamatan yang digeser tetap per id kelurahan — keterbatasan data sumber, bukan bug.
- **Akun kelurahan hanya melapor di kelurahannya sendiri** - `kelurahan_asal_id` pelapor selalu sama dengan `kelurahan_id` laporan, meniru pengunci wilayah di `HantuBanyuPengaduanGuestController::store()`.
- **Asal pelapor dibuat beragam** - sekitar satu dari sembilan laporan dicatat sebagai buatan admin UPTD, sisanya operator kelurahan, supaya kolom dan filter "Pelapor" punya kedua macam data untuk diuji. Pemilihannya tetap (berdasarkan urutan, bukan acak) sehingga hasil `db:seed` selalu sama.
- **Laporan yang berumur lebih dari 5 bulan wajib berstatus "selesai".** Tahap yang belum final selalu berumur di bawah itu; laporan "selesai" sengaja dibuat bervariasi 2-13 bulan (lintas tahun) supaya data tidak terasa seragam. Sekitar 20% kelurahan mendapat satu laporan lama yang ditutup lewat jalur pintas administratif (langsung dari "pending" ke "selesai", tanpa tahap menengah tercatat - hanya dua baris tindak lanjut), sisanya lewat alur normal (semua tahap terisi berurutan).
- **SKM hanya untuk laporan yang sudah selesai**, dan hanya sejumlah yang tersedia dari `SKMSeeder` - mencerminkan kenyataan bahwa tidak semua warga sempat mengisi survei kepuasan.

Untuk mengumpulkan ulang data geocoding (mis. kalau daftar kelurahan berubah), lihat komentar di kepala `HantuBanyuTitikGeocode.php` dan method `HantuBanyuSeeder::titikUntukKelurahanLive()`.

> **Branch ini sedang dikembangkan kembali.** Berbeda dari konvensi biasa (fitur final dikerjakan lanjut lewat branch baru dari `main`), penyesuaian Hantu Banyu kali ini dikerjakan langsung di branch `hantu-banyu` yang sudah ada — karena isinya memang sudah identik dengan `main` sebelum dibuka kembali, jadi tidak ada kode yang tercecer. Setelah selesai diuji, gabungkan ke `main` lalu pulihkan catatan status final di kedua README.

## Instalasi & Menjalankan

Ikuti langkah instalasi umum di [README `main`](../../tree/main#readme). Tidak ada perbedaan proses setup antara branch ini dengan `main`.

## Lisensi & Kepemilikan

Proyek ini adalah properti **Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda** untuk keperluan internal dan layanan publik resmi.
