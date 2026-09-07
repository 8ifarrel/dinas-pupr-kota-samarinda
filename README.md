# Website Dinas PUPR Kota Samarinda — Branch `silalad`

> Fitur **SILALAD** (Sistem Informasi Layanan Limbah Domestik) — layanan sedot tinja. Untuk gambaran umum seluruh website beserta cara instalasi, lihat [README di branch `main`](../../tree/main#readme).

## Tentang Branch Ini

Branch `pkl-umkt/form-sedot-tinja` (tempat fitur ini awalnya dikembangkan oleh anak PKL, dengan nama kode `SedotTinja`) sudah sangat usang — bercabang dari `main` sejak Agustus 2025, dari saat itu Laravel di-*upgrade*, seeder ditata ulang, sistem kunci API dibuat, dan banyak hal lain di `main` berubah total. Karena itu, branch ini **bukan** hasil `git merge` langsung antara `main` dan branch sumber — merge mentah seperti itu akan menabrak ratusan baris tak terkait dan berisiko menyeret `main` mundur ke versi lama.

Yang dilakukan adalah **pemindahan manual**: kode milik fitur ini dipindah dan disesuaikan agar berjalan di atas `main` versi terkini, sementara berkas lintas-fitur (routing, seeder, config, dsb.) tetap versi `main`, hanya ditambahkan bagian fiturnya. Jadi branch ini = kode `main` terkini + fitur ini di atasnya, bukan gabungan mentah dua riwayat commit yang berbeda.

Sekaligus dengan pemindahan ini, seluruh penamaan kode (`SedotTinja`) diganti jadi **SILALAD** — nama resmi fitur ini (lihat tabel [Struktur Kode](#struktur-kode)) — dan sejumlah cacat pada kode sumber ikut diperbaiki. Rinciannya ada di bagian [Masalah yang Ditemukan di Branch Sumber](#masalah-yang-ditemukan-di-branch-sumber).

## Cakupan Fitur

- **Pendaftaran SILALAD** — warga mengisi form berisi data pelanggan, lokasi, dan jenis bangunan
- **Kode Booking Otomatis** — format `SIL-<tahun>-<nomor urut>`
- **Cek Status** — warga melihat status pesanan berdasarkan nomor telepon yang dipakai saat mendaftar, lengkap dengan filter status/bulan/tahun, halaman detail per pesanan, dan **riwayat perkembangan** pesanannya
- **Kelola Pesanan (Admin)** — daftar pesanan (dengan filter status/bulan/tahun), ubah status beserta data penugasan & pelaksanaannya, dan cetak empat dokumen (lihat [Alur Pengerjaan & Surat](#alur-pengerjaan--surat))
- **Statistik Laporan (Admin)** — ringkasan pesanan masuk per kuartal, sebaran status, jenis bangunan, dan wilayah
- **Survei Kepuasan (Admin)** — rekap penilaian bintang 1–5 beserta kritik & saran yang diisi pelanggan saat mendaftar
- **API SILALAD** — pendaftaran dan pemantauan pesanan oleh sistem pihak ketiga, dilindungi kunci API tersendiri

## Struktur Kode

| Bagian | Isi |
|---|---|
| Model | `App\Models\Silalad` (tabel `silalad`), `App\Models\SilaladTindakLanjut` (tabel `silalad_tindak_lanjut`), `App\Models\SilaladApiKey` (tabel `silalad_api_keys`) |
| Controller guest | `App\Http\Controllers\Guest\SilaladGuestController` |
| Controller admin | `App\Http\Controllers\Admin\SilaladAdminController`, `SilaladStatistikLaporanAdminController`, `SilaladSKMAdminController` |
| Controller API | `App\Http\Controllers\Api\SilaladPesananController`, `SilaladApiKeyController` |
| View guest | `resources/views/guest/pages/silalad/` |
| View admin | `resources/views/admin/pages/silalad/`, kunci API di `resources/views/admin/pages/super-admin/api-key/silalad/` |
| Rute publik | prefix `/silalad` |
| Rute admin | prefix `/e-panel/silalad`, level akses Admin (bukan Super Admin) |
| Rute kunci API | prefix `/e-panel/super-admin/api-key/silalad`, level akses Super Admin |
| Rute API | prefix `/api/silalad` |

## Alur Pengerjaan & Surat

Branch sumber menyediakan tiga surat (Surat Pesanan, Surat Perintah Kerja, Surat Jalan) yang tidak pernah bisa dipakai: rutenya dikomentari dan mayoritas datanya tidak punya kolom di tabel. Ketiganya dihidupkan kembali di sini, karena setelah ditelusuri **ketiga surat itu mewakili tiga tahap berbeda** dari satu pekerjaan, bukan tiga varian dokumen yang sama.

| Tahap | Data yang dicatat | Surat |
|---|---|---|
| Survei kelayakan | jarak tangki ke mobil tinja, tangki bisa disedot atau tidak, nomor SPK | Surat Pesanan |
| Penugasan | operator, nomor & kapasitas kendaraan, tanggal perintah | Surat Perintah Kerja |
| Pelaksanaan | jumlah rit, tanggal pengerjaan | Surat Jalan |

Statusnya tetap **empat** seperti rancangan branch sumber (`Belum dikerjakan`, `Sedang dikerjakan`, `Sudah dikerjakan`, `Dibatalkan`) — yang ditambahkan bukan statusnya, melainkan data yang menempel di tiap perpindahan status:

- **→ Sedang dikerjakan** wajib mengisi operator, nomor kendaraan, dan tanggal perintah, karena tanpa ketiganya Surat Perintah Kerja tidak ada artinya.
- **→ Sudah dikerjakan** wajib mengisi jumlah rit, karena tarif layanan ini dihitung per rit sehingga angka itu jadi dasar penagihan.
- **→ Dibatalkan** wajib mengisi alasan pembatalan.

Surat yang syaratnya belum terpenuhi tidak bisa dicetak (tombolnya nonaktif berikut alasannya, dan rutenya sendiri menolak dengan `404`). Surat Pesanan sengaja dikecualikan — boleh dicetak kapan saja dengan bagian yang belum terisi tampil bergaris titik-titik, karena surat itu memang untuk dibawa dan dilengkapi tulisan tangan saat petugas ke lokasi.

**Riwayat status tidak pernah ditimpa.** Tiap perpindahan status menambah satu baris di `silalad_tindak_lanjut` (pola yang sama dipakai `hantu_banyu_laporan_tindak_lanjut`), lengkap dengan waktu dan keterangannya — admin boleh menulis keterangan sendiri, atau dibiarkan terisi otomatis dari data yang baru diisi. Riwayat ini ditampilkan di halaman edit admin, di halaman detail pesanan milik pelanggan, dan di balasan API. Kolom `silalad.status_pengerjaan` tetap dipertahankan sebagai status terkini supaya penyaringan dan statistik tidak perlu menelusuri riwayat tiap kali.

> **Catatan:** pembagian tiga tahap di atas adalah rekonstruksi dari isi template surat bawaan branch sumber, bukan hasil wawancara dengan UPTD. Kemungkinan terbesar melesetnya: bisa jadi tidak ada kunjungan survei terpisah, dan jarak tangki diukur petugas saat datang menyedot. Karena itu **tidak ada urutan pengisian yang dipaksakan** — seluruh isian survei boleh dikosongkan atau diisi belakangan; yang diwajibkan hanya data yang benar-benar dibutuhkan surat pada tahap tersebut. Nomor SPK juga tidak dibuat otomatis: kotak isiannya menyediakan tombol usulan berformat `001/UPTD/IX/2026`, tapi admin bebas mengetik format lain karena aturan penomoran resminya milik UPTD.

## API SILALAD

Ditujukan untuk sistem pihak ketiga yang tidak memakai formulir web. Polanya mengikuti API fitur lain (Jalan Peduli, Hantu Banyu): tiap permintaan wajib membawa header `X-API-KEY`, dan kuncinya disimpan di tabelnya sendiri sehingga **kunci fitur lain tidak berlaku di sini, begitu pula sebaliknya**. Kunci dikelola Super Admin lewat menu **API Key → SILALAD**.

| Endpoint | Kegunaan |
|---|---|
| `POST /api/silalad/pesanan` | Mendaftarkan pesanan baru |
| `GET /api/silalad/pesanan/{id}` | Detail satu pesanan |
| `GET /api/silalad/pesanan/status?nomor_telepon_pelanggan=…` | Riwayat pesanan milik satu nomor telepon (opsional `&status=`) |

Dua hal yang perlu diperhatikan pemakai API:

- **Wilayah mengikuti aturan yang sama dengan formulir web.** Untuk Kota Samarinda, `kecamatan_id`/`kelurahan_id` diisi id numerik internal (lihat `GET /api/kecamatans`) dan pasangannya diverifikasi — kelurahan yang bukan bagian dari kecamatan yang dikirim ditolak dengan status `422`. Untuk luar Samarinda, kolom yang sama diisi **nama** wilayahnya, karena datanya berasal dari API wilayah pihak ketiga yang idnya memang tidak ada di basis data ini.
- **Endpoint status wajib menyertakan nomor telepon**, supaya tidak berubah menjadi daftar seluruh pesanan pelanggan.

## Masalah yang Ditemukan di Branch Sumber

Daftar ini adalah cacat yang ditemukan pada branch `pkl-umkt/form-sedot-tinja`, bukan sesuatu yang muncul akibat proses pemindahan kode ke sini. Item yang sudah diperbaiki ditandai di awal kalimat.

- **(Sudah diperbaiki saat pemindahan)** Panel admin fitur ini sama sekali tidak menampilkan isi apa pun (halaman kosong tanpa error) — layout admin di `main` menyediakan slot `@yield('document.body')`, sedangkan seluruh halaman admin fitur ini ditulis memakai nama slot `@section('content')` yang berbeda dan tidak pernah dirender. Semua halaman admin fitur ini disamakan memakai `document.body`, mengikuti konvensi fitur lain.
- **(Sudah diperbaiki saat pemindahan)** Setiap halaman publik fitur ini pasti gagal (error 500) karena layout-nya sendiri memuat komponen `guest.components.flash-message` yang tidak pernah benar-benar dibuat. Layout khusus itu (beserta navbar duplikatnya) sudah dihapus — halaman publik fitur ini sekarang memakai layout utama situs (`guest.layouts.main`) yang sama dengan fitur lain, sehingga navbar, footer, dan gaya tampilannya konsisten dengan seluruh situs.
- **(Sudah diperbaiki saat pemindahan)** Form edit pesanan di admin mengirim datanya ke rute yang salah (`update-status`, yang cuma menerima kolom status) padahal formnya berisi 15+ field. Akibatnya, setiap kali admin mengedit nama/alamat/dsb. lewat form ini, seluruh perubahan selain status pengerjaan hilang diam-diam tanpa pesan error apa pun. Halaman ini kemudian ditata ulang: seluruh data yang diisi pelanggan kini ditampilkan **hanya untuk dibaca** (tidak bisa diubah admin), dan satu-satunya yang benar-benar bisa diubah adalah status pengerjaan — sehingga formnya memang sekarang menuju `update-status`, kali ini sesuai isi formnya.
- **(Sudah diperbaiki saat pemindahan)** Form "Buat Pesanan Baru" di admin memakai nama field yang sama sekali tidak cocok dengan yang divalidasi controller (`kabupaten`/`kecamatan`/`kelurahan`/`nomor_rumah`/`rw` vs yang sebenarnya `kabkota_id`/`kecamatan_id`/`kelurahan_id`/`nomor_bangunan`) — submit apa pun dari form ini pasti gagal validasi total. Form sempat ditulis ulang dengan nama field yang benar, lalu dihapus seluruhnya karena pesanan memang selalu berasal dari pelanggan (lewat formulir publik atau API), bukan dibuat manual oleh admin.
- **(Sudah diperbaiki saat pemindahan)** Status `Dibatalkan` diperlakukan sebagai status sah di seluruh kode (validasi, filter, dropdown, badge), padahal kolom `status_pengerjaan` di tabel hanya berupa `ENUM` dengan tiga nilai — tanpa `Dibatalkan`. Akibatnya, membatalkan pesanan lewat panel admin selalu gagal di tingkat basis data. Ditambahkan migrasi yang melebarkan `ENUM` tersebut menjadi empat nilai.
- **(Sudah diperbaiki saat pemindahan)** Pesanan berstatus `Dibatalkan` tampil dengan badge hijau seperti pesanan selesai, karena tidak punya cabang warnanya sendiri dan jatuh ke nilai bawaan. Sekarang ditandai merah di seluruh tampilan.
- **(Sudah diperbaiki saat pemindahan)** Kebocoran data pribadi: halaman publik (daftar pesanan, detail pesanan, cek status) sebelumnya menampilkan nama, nomor telepon, dan alamat pelanggan ke siapa saja tanpa login maupun filter kepemilikan. Sekarang detail pesanan wajib menyertakan nomor telepon yang cocok lewat tautan yang sama dipakai saat pencarian status (kalau tidak cocok, halamannya ditolak `403`), dan histori/hasil pencarian di halaman cek status hanya menampilkan pesanan milik nomor telepon yang dicari.
- **(Sudah diperbaiki saat pemindahan)** Form edit pesanan di admin punya dua kotak "Kritik" dan "Saran" yang datanya selalu hilang diam-diam saat disimpan (bukan kolom yang ada di tabel). Keduanya kini tidak lagi muncul di halaman admin (bukan wewenang admin untuk mengisinya) — isian kritik & saran dari pelanggan direkap ke tabel `skm` bersama sebagai dua kolom terpisah, dan salinan gabungannya tetap disimpan di kolom asli `saran_masukan`.
- **(Sudah diperbaiki saat pemindahan)** Halaman cek status menghitung paginasi, tapi tombol navigasi halamannya tidak pernah dirender di tampilan mana pun — pesanan ke-11 dan seterusnya praktis tidak bisa dibuka. Paginasinya sekarang benar-benar ditampilkan dan ikut membawa filter yang sedang aktif.
- **(Sudah diperbaiki saat pemindahan)** Pilihan tahun pada filter cek status diambil dari seluruh pesanan milik semua pelanggan, bukan dari pesanan milik nomor telepon yang sedang dicari — memunculkan tahun yang tidak relevan sekaligus membocorkan sedikit informasi tentang data pelanggan lain. Sekarang dibatasi ke riwayat nomor telepon yang bersangkutan.
- **(Sudah diperbaiki saat pemindahan)** Validasi form admin menandai `jenis_bangunan`, `nomor_bangunan`, dan `rt` sebagai boleh kosong, padahal ketiga kolom itu wajib diisi di tabel — menyebabkan pesanan baru gagal disimpan (error database) kalau field itu kosong. Validasinya disamakan jadi wajib diisi.
- **(Sudah diperbaiki saat pemindahan)** Halaman "Cetak Pesanan" berisi tiga surat (Surat Perintah Kerja, Surat Jalan, Surat Pesanan) yang seluruhnya mengambil data dari kolom yang tidak ada di tabel (`nama_operator`, `nomor_kendaraan`, `jarak_tangki`, dst.) — semua cetakan itu selalu kosong. Berkasnya juga menumpuk dokumen HTML lengkap di dalam layout admin (dua `<html>` bersarang), memuat dua salinan surat yang sama (satu dikomentari), dan tiga berkas surat terpisahnya tidak pernah bisa diakses karena rute serta method controllernya dikomentari — bahkan kode yang dikomentari itu memanggil nama view yang tidak cocok dengan nama berkasnya. Ketiga surat kini dihidupkan kembali sebagai berkas dan rute masing-masing, dengan kolom datanya dibuatkan (lihat [Alur Pengerjaan & Surat](#alur-pengerjaan--surat)), ditambah satu bukti pesanan sederhana untuk pelanggan.
- **(Sudah diperbaiki saat pemindahan)** Ketiga surat menanam nama pejabat penanda tangan beserta NIP-nya langsung di kode. Diganti garis tanda tangan berikut jabatannya saja, supaya surat tidak ikut usang setiap kali pejabatnya berganti.
- **(Sudah diperbaiki saat pemindahan)** Status pengerjaan hanya berupa satu kolom yang ditimpa tiap kali diubah, sehingga tidak ada jejak kapan pesanan dikonfirmasi, siapa yang mengerjakan, atau kenapa dibatalkan — padahal `updateStatus` bawaan branch sumber sendiri sudah menyiratkan adanya alur ("Pesanan berhasil dikonfirmasi"). Ditambahkan tabel `silalad_tindak_lanjut` yang mencatat tiap perpindahan status sebagai baris baru, mengikuti pola Hantu Banyu.
- **(Sudah diperbaiki saat pemindahan)** Peta titik lokasi memakai Google Maps dengan kunci API yang ditulis langsung di kode (`AIzaSy...`, dan di form admin bahkan cuma placeholder `YOUR_API_KEY`) — tidak konsisten dengan Leaflet yang dipakai fitur peta lain di situs ini. Diganti Leaflet + OpenStreetMap.
- **(Sudah diperbaiki saat pemindahan)** Dropdown Kabupaten/Kecamatan/Kelurahan sepenuhnya bergantung pada API publik pihak ketiga (`alamat.thecloudalert.com`), termasuk untuk Samarinda yang datanya justru sudah dimiliki situs ini sendiri — artinya wilayah Samarinda pun ikut gagal tampil kalau layanan luar itu sedang mati. Sekarang **Samarinda memakai data kecamatan/kelurahan milik situs ini sendiri** (tabel yang sama dipakai Jalan Peduli), dan API pihak ketiga hanya dipakai sebagai cadangan bila pelanggan memilih kabupaten/kota di luar Samarinda. Karena id dari API luar itu tidak ada di basis data ini, yang disimpan untuk wilayah luar Samarinda adalah **nama** wilayahnya, bukan idnya — supaya datanya tetap terbaca sendiri dan tidak bergantung pada stabilitas id milik pihak ketiga.
- **(Sudah diperbaiki saat pemindahan)** Migrasi yang menambah ulang kolom `kode_booking` (sudah ada di migrasi pembuatan tabel) dan migrasi-migrasi kosong/tidak terpakai dari branch sumber tidak dibawa.
- **(Sudah diperbaiki saat pemindahan)** Rute admin & publik ditulis ulang bersih (branch sumber punya rute bertingkat ganda `admin/admin/sedot-tinja/...` serta nama rute yang didefinisikan berkali-kali).
- **(Sudah diperbaiki saat pemindahan)** Nama field `saran_dan_masukan` (model & validasi) disamakan dengan nama kolom asli di tabel, `saran_masukan`.
- **(Sudah diperbaiki saat pemindahan)** Data contoh (seeder) diperbaiki agar cocok dengan kolom yang benar-benar ada di tabel, dan mengisi `kode_booking` (kolom ini wajib diisi tapi seeder aslinya tidak mengisinya).
- **(Sudah diperbaiki saat pemindahan)** Captcha Cloudflare Turnstile dihapus total dari form pendaftaran SILALAD (widget di form, verifikasi di controller, beserta validasi `cf-turnstile-response`) — sempat gagal terus di produksi (`cf-turnstile-response field is required`) padahal fitur ini tidak butuh captcha.
- **(Sudah diperbaiki saat pemindahan)** Satu bug lama di `LoginAdminController` (login gagal tidak memberi respons apa pun) ikut terbawa perbaikannya dari branch sumber.
- **(Sudah diperbaiki saat pemindahan)** Berkas sampah yang ikut ter-*commit* di riwayat branch sumber (log `git log` yang salah redirect ke file, berkas `.tmp`) tidak dibawa ke branch ini.
- **(Sudah diperbaiki saat pemindahan)** Empat dari empat belas berkas tampilan admin fitur ini (`destroy`, `index`, `layout`, `update-status`) ternyata tidak pernah dirender oleh controller mana pun — sisa peninggalan yang tidak pernah dipakai. Semuanya dihapus, menyusul kemudian berkas tampilan "buat pesanan" dan "detail pesanan" di admin yang ikut dihapus karena fungsinya sudah tidak dipakai (lihat dua poin di atas dan konsolidasi menu di bawah). Tiga berkas surat yang juga tidak pernah dirender tidak ikut dihapus, melainkan dihidupkan kembali.
- **(Sudah diperbaiki saat pemindahan)** Menu admin "Data Pesanan", "Data Terkonfirmasi", dan "Riwayat Pesanan" tumpang tindih (pesanan yang sudah dikerjakan muncul di lebih dari satu menu sekaligus) — digabung jadi satu menu **Daftar Pesanan** dengan filter status/bulan/tahun. Tombol aksinya ikut dirapikan: tombol "lihat detail" dihapus karena isinya sama persis dengan halaman edit, dan tombol cetak dipindah ke dalam halaman edit.
- **Upload foto tidak tersimpan** — form pendaftaran memvalidasi field foto, tapi ternyata form-nya sendiri tidak punya input untuk mengunggah foto sama sekali — validasi itu dihapus karena tidak pernah dipicu. Bila ke depan fitur unggah foto ingin ditambahkan, form dan penyimpanan filenya perlu dibuat dari nol, bukan sekadar diaktifkan kembali.
- **Kolom `rating` & `saran_masukan` di tabel `silalad` kini menyimpan data yang sama dengan tabel `skm`.** Penilaian pelanggan direkap ke tabel `skm` bersama (id layanan `6`, kritik & saran terpisah) supaya halaman Survei Kepuasan bentuknya seragam dengan fitur lain, sementara penulisan ke dua kolom lama itu sengaja dibiarkan apa adanya agar data lama tetap utuh. Bila ke depan ingin dirapikan, kedua kolom itulah yang perlu dipensiunkan — bukan tabel `skm`-nya.
- **Nama operator dan kendaraan masih berupa isian teks bebas**, belum ada tabel master petugas maupun armada. Cukup untuk kebutuhan surat, tapi konsekuensinya penulisan nama yang berbeda-beda (mis. "Budi" vs "Budi S.") akan menyulitkan bila nanti ingin merekap kinerja per operator atau per kendaraan.
- **Rute `PUT /e-panel/silalad/{silalad}` (`admin.silalad.update`) kini tidak dipakai tampilan mana pun**, sisa dari masa ketika admin masih bisa menyunting seluruh data pesanan. Sengaja belum dihapus karena berada di luar cakupan perapian tampilan, tapi perlu diputuskan nasibnya: rute ini menerima pembaruan seluruh kolom pesanan, jadi sebaiknya dihapus bila memang tidak akan dipakai lagi.

## Tampilan

Tampilan halaman publik dan admin fitur ini sudah disesuaikan mengikuti gaya yang konsisten dipakai di seluruh situs (bukan lagi gaya bawaan branch sumber): layout & komponen bersama (navbar, footer, alert), warna `brand-blue`/`brand-yellow`, ikon FontAwesome, pola breadcrumb, kartu Flowbite untuk form, DataTables untuk daftar pesanan, dan Chart.js untuk halaman statistik & survei kepuasan — sama seperti yang dipakai fitur Hantu Banyu.

Sudah diuji lewat migrasi, seeding, dan permintaan HTTP nyata di lingkungan terisolasi sebelum branch ini didorong: login admin, pengisian formulir pendaftaran publik, perpindahan status dari awal sampai selesai berikut penolakan bila data wajibnya belum diisi, pencetakan keempat dokumen berikut penguncian surat yang syaratnya belum terpenuhi, serta seluruh endpoint API — mencakup permintaan tanpa kunci, dengan kunci milik fitur lain, dengan data tidak lengkap, dengan pasangan kecamatan–kelurahan yang tidak cocok, dan jalur sukses untuk wilayah Samarinda maupun luar Samarinda. Seluruh data uji dihapus kembali setelahnya.

## Lisensi & Kepemilikan

Sama seperti `main` — proyek ini properti **Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda**, bukan proyek open-source untuk digunakan ulang di luar konteks tersebut tanpa izin.
