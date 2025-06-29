-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Jun 2025 pada 14.27
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pupr_smr_test`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `uuid_berita` char(36) NOT NULL,
  `judul_berita` varchar(255) NOT NULL,
  `slug_berita` varchar(255) NOT NULL,
  `id_berita_kategori` bigint(20) UNSIGNED NOT NULL,
  `foto_berita` varchar(255) NOT NULL,
  `sumber_foto_berita` varchar(255) DEFAULT NULL,
  `isi_berita` text NOT NULL,
  `preview_berita` varchar(255) NOT NULL,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`uuid_berita`, `judul_berita`, `slug_berita`, `id_berita_kategori`, `foto_berita`, `sumber_foto_berita`, `isi_berita`, `preview_berita`, `views_count`, `created_at`, `updated_at`) VALUES
('02f466d0-68ca-4651-8eb3-467230696ad3', 'Evaluasi Kegiatan dan Pembahasan Standar Teknis Permohonan PBG dan SLF Kota Samarinda Tahun 2024', 'evaluasi-kegiatan-dan-pembahasan-standar-teknis-permohonan-pbg-dan-slf-kota-samarinda-tahun-2024', 4, 'Berita/2024-06/19/8hEFKgCtiny1MIqig7CpHfGnggZU1Tvq3a61bt5N.png', NULL, '<div><strong>Samarinda</strong> - Pada Tanggal 19 Juni 2024, Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili Bidang Cipta Karya melakukan Evaluasi Kegiatan dan Pembahasan Standar Teknis Permohonan Persetujuan Bangunan Gedung (PBG) dan Sertifikat Laik Fungsi (SLF) bersama Tim Profesi Ahli Kota Samarinda Tahun 2024.<br><br>Kegiatan tersebut bertempat di Ruang Rapat Utama Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda<br> yang dihadiri juga oleh TPA (Tim Profesi Ahli) Kota Samarinda yang berdiskusi mengenai peningkatan kualitas dan efisiensi proses permohonan. Kegiatan ini merupakan langkah penting dalam memastikan standar yang tinggi dalam penggunaan barang dan layanan fungsi di kota Samarinda, sekaligus meningkatkan transparansi dan akuntabilitas dalam pelayanan publik.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-06-18 17:00:00', '2024-06-18 14:26:42'),
('03b90aa0-d3d1-11eb-81de-0ba8a545c062', 'Sidak Pembangunan Hotel', 'sidak-pembangunan-hotel', 4, 'Berita/2021-06/23/sidak-pembangunan-hotel.jpg', 'Arsip DPUPR', '<p>Selasa 22 juni, Dinas PUPR samarinda menghadiri undangan dari Komisi 1 DPRD Samarinda terkait Kegiatan Sidak pembangunan hotel dan cafe dikawasan jl. Teuku Umar Kec. Sungai kunjang undangan juga dihadiri oleh Dinas Perhubungan dan Satpol PP.</p>', 'sidak', 2047, '2021-06-22 08:00:00', '2023-12-12 10:53:39'),
('056ebd2c-c40c-4100-83eb-1d4e68ad7638', 'Form Pengaduan UPTD Pemeliharaan Saluran Drainase dan Irigasi Kota Samarinda', 'form-pengaduan-uptd-pemeliharaan-saluran-drainase-dan-irigasi-kota-samarinda', 10, 'Berita/2024-08/05/XPdRVoWMvBFjJgCkx1HT9SpLIqHMwfeYLMAbdN7u.png', NULL, '<div><strong>PENGUMUMAN</strong> -&nbsp; Selamat Datang di Form Pengaduan Unit Pelaksana Teknis Dinas (UPTD) Pemeliharaan Saluran Drainase dan Irigasi Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda. Kini layanan pengaduan UPTD Pemeliharaan Saluran Drainase dan Irigasi tersedia secara online.<br><br></div><div>Segera laporkan segala permasalahan Saluran Drainase dan Irigasi di Kota Samarinda dengan mudah melaporkan masalah yang ditemui sehari-hari, mulai dari penyumbatan saluran parit, hingga perbaikan yang sangat dibutuhkan untuk menanggulangi banjir di sekitar tempat tinggal Anda.<br><br></div><div>Setiap pengaduan yang Anda ajukan sangat membantu kami dalam menjaga kondisi infrastruktur baik di Kota Samarinda. Terimakasih atas partisipasi Anda dalam menciptakan Samarinda yang lebih baik!</div><div>\"Mari Menjaga Lingkungan, Bersama Kita Menciptakan Perubahan! 🌿 \"<br><br></div><div>Link Form Pengaduan : <a href=\"https://bit.ly/FormPengaduanUPTDPemeliharaanSaluranDrainseDanIrigasi?fbclid=IwZXh0bgNhZW0CMTAAAR2ZwwbClK7o29Eb1vVTerwsSsLlrf2Wju9GqCQto--olxDmUxbG5AGH2U0_aem_UKg6NXVNtjoiZ26XREiaxg\">https://bit.ly/FormPengaduanUPTDPemeliharaanSaluranDrains...</a></div><div>CP UPTD PSDI : <a href=\"https://l.facebook.com/l.php?u=https%3A%2F%2Fwa.me%2F6283893376619%3Ffbclid%3DIwZXh0bgNhZW0CMTAAAR0L10u6t2jyO0iO9vfZr8a5uoyLyX5JS2KLDVcIWIkOmyUBuOx8dniQ4OU_aem_gpzdmrOMWtES8_yA6h8Lkw&amp;h=AT1TRmO5FfwWzCOiEYxyhI3ZezWEJZxfZxn3QZI2gjCoMWbLU0_QducLg84cQWCYP2AnzIrcIhqJKXKnncs0O52R53f7voXOOkX1JqITtRxux8gphhAWC_edSY736Xkdhtv2&amp;__tn__=-UK-R&amp;c[0]=AT1W543P9Yz2wI9RxJnnbtFX2d1hz8BgACmQWvP5D9krSuXX6aqQ52_UOAHCCaI7BKDtWs0DHheEOdzUToYXabhF8GSS_U7PdQQlhi3VK6rctIH485OdBvf6FabJld6hoz7v3t7FcinUDwBT-bU9MHVrv-_Gdt0wgYUaXj2iSqHG_0nrxCgyHDBTj9FZfhl1pkW5RnFncNN9Mm8fp3IbfhMIOIqN5Opjt5JL\">https://wa.me/6283893376619</a> (Chat Only)</div><div>Instagram: <a href=\"https://l.facebook.com/l.php?u=https%3A%2F%2Fwww.instagram.com%2F_u%2Fuptd_drainase_samarinda%3Ffbclid%3DIwZXh0bgNhZW0CMTAAAR1CWdeFNZNIlnRku-Rz9zfbTRmKUoZMIF45qIjPoaonOsYiyTrASlvWRro_aem_p0VS4cWy50yeewsBzSYvAQ&amp;h=AT2enN06GIuVcB27dGNy-fDTvf56hohuEPUR5An-u8zMj2c7mxA4rjpi05jSIXWP_HG8ZlZsszayH345oqzwJMVFVNa6k1VK-4RxZEzSZlOVeMCvGhFCMgZlxjkpXjMDYg2i&amp;__tn__=-UK-R&amp;c[0]=AT1W543P9Yz2wI9RxJnnbtFX2d1hz8BgACmQWvP5D9krSuXX6aqQ52_UOAHCCaI7BKDtWs0DHheEOdzUToYXabhF8GSS_U7PdQQlhi3VK6rctIH485OdBvf6FabJld6hoz7v3t7FcinUDwBT-bU9MHVrv-_Gdt0wgYUaXj2iSqHG_0nrxCgyHDBTj9FZfhl1pkW5RnFncNN9Mm8fp3IbfhMIOIqN5Opjt5JL\">@uptd_drainase_samarinda</a> <br><br> ———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-08-04 19:00:00', '2024-08-04 13:11:27'),
('0727d7ed-0065-4cfd-b56a-ed9c7e3ebbd6', 'Focus Group Discussion (FGD) Laporan Pendahuluan Rencana Detail Tata Ruang (RDTR) Wilayah Perencanaan Kecamatan Sungai Pinang Kota Samarinda', 'focus-group-discussion-fgd-laporan-pendahuluan-rencana-detail-tata-ruang-rdtr-wilayah-perencanaan-kecamatan-sungai-pinang-kota-samarinda', 6, 'Berita/2024-08/01/2aSwZIUYTQjftxa34F03kwlGmjvMjItReOsMVThz.png', NULL, '<div><strong>Samarinda</strong> - Pada tanggal 30 Juli 2024,&nbsp; Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili Bidang Penataan Ruang (<a href=\"https://www.instagram.com/tataruangsamarinda/\">@tataruangsamarinda</a>) melakukan Focus Group Discussion (FGD) Laporan Pendahuluan Rencana Detail Tata Ruang (RDTR) Wilayah Perencanaan Kecamatan Sungai Pinang Kota Samarinda. <br><br>Acara tersebut bertempat di Ruang Rapat Utama Dinas PUPR Kota Samarinda yang dihadiri juga oleh beberapa Organisasi Perangkat Daerah (OPD) Provinsi Kalimantan Timur, OPD Kota Samarinda, Camat, dan Lurah. Pembukaan dan sambutan acara yang diwakili oleh Plt. Bidang Penataan Ruang, Bu Nurvina Hayuni, S.T., M.T. dilanjutkan dengan Paparan dari Tenaga Ahli Penyusun Rencana Detail Tata Ruang (RDTR) Wilayah Perencanaan (WP) Kecamatan Sungai Pinang Kota Samarinda. Selanjutnya, dilakukan sesi penyampaian masukan dan diskusi dari perwakilan OPD, Camat, dan Lurah yang menghadiri acara.<br><br>RDTR Sungai Pinang disusun mengacu pada RTRW Kota Samarinda dengan memperhatikan RPJPD, RPJMD, perkembangan permasalahan wilayah serta hasil pengkajian implikasi penataan ruang kota, optimasi pemanfaatan ruang darat, ruang udara, dan termasuk ruang dalam bumi sesuai dengan ketentuan teknis yang tertuang dalam Peraturan Menteri ATR/BPN No. 11 Tahun 2021 tentang Tata Cara Penyusunan RTRW dan RDTR.<br><br>Rencana pemanfaatan ruang Wilayah Perencanaan RDTR sendiri secara terperinci disusun untuk penyiapan perwujudan ruang dalam rangka perwujudan Tujuan Penataan Ruang, Rencana Struktur Ruang, Rencana Pola Ruang, Ketentuan Pemanfaatan Ruang dan Peraturan Zonasi. Waktu pelaksanaan penyusunan RDTR ini sangat singkat, yaitu sekitar 6 bulan. Maka di harapkan kepada seluruh OPD, Camat Sungai Pinang serta para Lurah dapat bekerja sama dan memberikan informasi selengkap-lengkapnya pada tim penyusun.<br><br> ———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-07-29 17:00:00', '2024-07-31 14:03:22'),
('0786dc63-d490-4444-9771-1dcb94d55be7', 'Pemeriksaan Kesehatan Masyarakat Sekitar Pembangunan Proyek Terowongan/Tunnel Jl. Sultan Alimuddin - Kakap Kota Samarinda', 'pemeriksaan-kesehatan-masyarakat-sekitar-pembangunan-proyek-terowongantunnel-jl-sultan-alimuddin-kakap-kota-samarinda', 1, 'Berita/2024-05/07/PfBNbhBVLKKPGeZ1j4ZFjqj4A1an8f3OrGJ6N0Qj.png', NULL, '<div>Samarinda - Pada Hari Selasa (05/03/2024)&nbsp; PT PP (Pembangunan Perumahan) Persero Tbk Tunnel Project Samarinda mengadakan pemeriksaan kesehatan kepada warga yang terdampak oleh Pembangunan Terowongan/Tunnel di Kota Samarinda. Kegiatan tersebut bertempat di area outlet terowongan (Jl. Kakap) dan pemeriksaan kesehatan tersebut melayani pemeriksaan gula darah, kolesterol, dan asam urat.<br><br>Pemeriksaan kesehatan ini dilaksanakan oleh Tim Puskesmas Samarinda sebagai bentuk CSR (Corporate Social Responsibility) kepada masyarakat sekitar yang aktivitasnya mungkin terganggu selama aktivitas pembangunan terowongan.&nbsp;</div>', '-', 0, '2024-03-04 08:00:00', '2024-05-06 09:49:17'),
('08a66d48-7e85-44a2-adfc-025f9041c262', 'Kunjungan Bidang Bina Konstruksi Dinas PUPR Kabupaten Penajam Paser Utara', 'kunjungan-bidang-bina-konstruksi-dinas-pupr-kabupaten-penajam-paser-utara', 5, 'Berita/2024-04/30/08a66d48-7e85-44a2-adfc-025f9041c262/OIj535rmfJnV0KO1R8X9a2ctAzuLa4vLl24sfM6L.png', NULL, '<div><strong>Samarinda</strong> - Pada Hari Rabu (24/4/2024)&nbsp; Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili Bidang Bina Konstruksi mendapat Kunjungan Kerja dari Bidang Bina Konstruksi Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Penajam Pasar Utara. Kunjungan tersebut disambut hangat oleh Bapak Herwin Wahyudi, S.T. selaku Kepala Bidang Bina Konstruksi serta Staff Bidang Bina Konstruksi.<br><br>Kunjungan tersebut dihadiri juga oleh Bapak Muhammad Saing, M.T selaku Kepala Bidang Bina Konstruksi Dinas PUPR Kabupaten PPU berserta Tim. Dan kunjungan ini dilakukan untuk koordinasi dan tukar informasi mengenai pelaksanaan pekerjaan sub urusan jasa konstruksi.<br><br>Dalam koordinasi dan pertukaran informasi dalam pelaksanaan pekerjaan sub urusan jasa konstruksi yang bertujuan untuk membantu meningkatkan kualitas pelaksanaan pekerjaan sub urusan jasa konstruksi dan memastikan bahwa proyek dapat diselesaikan tepat waktu dan dalam anggaran yang telah ditentukan.<br>&nbsp;</div><div>———————————————<br><br>Dinas PUPR Kota Samarinda dapat diakses melalui:</div><ul><li>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a></li><li>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda/\">https://www.instagram.com/dpuprkotasamarinda</a></li><li>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a></li><li>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a></li><li>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;</li></ul><div>———————————————&nbsp;</div>', '-', 0, '2024-04-23 17:00:00', '2024-05-05 10:26:14'),
('0ac18680-6db6-43dd-a807-b0ec62608b9f', 'Rapat Koordinasi Lintas Sektor Rencana Detail Tata Ruang (RDTR) Wilayah Perencanaan Kecamatan Samarinda Utara', 'rapat-koordinasi-lintas-sektor-rencana-detail-tata-ruang-rdtr-wilayah-perencanaan-kecamatan-samarinda-utara', 6, 'Berita/2024-11/15/aEygSL7qX9Th5u2BmHdbZI1LL4hvA3gIQ91lfORk.png', NULL, '<div><strong>JAKARTA</strong> - Pada Hari Senin, 11 November 2024. Plt. Wali Kota Samarinda Dr. H. Rusmadi Wongso menghadiri Rapat Koordinasi Lintas Sektor dalam rangka pembahasan Rancangan Peraturan Kepala Daerah (Ranperkada) tentang Rencana Detail Tata Ruang (RDTR) Wilayah Perencanaan Kecamatan Samarinda Utara pada Senin (11/11/24) bertempat di Sheraton Grand Jakarta Gandaria City Hotel.&nbsp;</div><div>Acara ini dihadiri oleh Sekretaris Daerah Kota Samarinda Ir. Hero Mardanus Satyawan, MT, Kepala Bapperida, Kepala DLH, Kabag Hukum, Kepala Dinas PUPR beserta tim teknis.</div><div>Rancangan Peraturan Kepala Daerah (Ranperkada) yang dibahas adalah Ranperkada tentang RDTR Wilayah Perencanaan Kecamatan Samarinda Utara Kota Samarinda. Ranperkada RDTR WP Kecamatan Samarinda Utara memiliki luas delineasi 23.299,11 hektare dengan Tujuan Penataan Ruang “untuk mewujudkan WP Kecamatan Samarinda Utara sebagai Pusat Pelayanan Transportasi Regional yang didukung oleh kegiatan Perdagangan dan Jasa yang berorientasi pada kearifan lokal serta Berwawasan Lingkungan”.&nbsp;</div><div>Harapan pemerintah daerah adalah RDTR Wilayah Perencanaan (WP) Kecamatan Samarinda Utara dapat segera ditetapkan sebagai Perwali dan terintegrasi dengan sistem Online Single Submission (OSS) untuk percepatan iklim investasi di Kecamatan Samarinda Utara melalui Konfirmasi Kesesuaian Kegiatan Pemanfaatan Ruang (KKPR).<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-11-10 16:00:00', '2024-11-14 20:42:10'),
('0ce486c2-3086-4031-ba60-024440e71c05', 'Kegiatan Pemeliharaan Jl. Pirus', 'kegiatan-pemeliharaan-jl-pirus', 9, 'Berita/2024-05/06/w9N116qiCtvfLGozyt5aoUrZTPqUzP1w5Zi1Mzpa.png', NULL, '<div>&nbsp;</div><div><strong>Samarinda</strong> - Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda Bagian Unit Pelaksana Teknis Dinas (UPTD) Pemeliharaan Jalan dan Jembatan melakukan Kegiatan Perbaikan dan Pemeliharaan Jalan Pirus, Kelurahan Bugis, Kecamatan Samarinda Kota, Kota Samarinda. Kegiatan tersebut dilakukan untuk meningkatkan kualitas infrastruktur dan kenyamanan pengguna jalan pada wilayah Kota Samarinda yang serangkaian kegiatan pemeliharaan jalan dilakukan di berbagai lokasi.<br><br>Silahkan laporkan kerusakan jalan di link berikut 👇<br><a href=\"https://forms.gle/CqvjPRs1uiEPL7TN7\">https://forms.gle/CqvjPRs1uiEPL7TN7</a> atau <a href=\"https://www.instagram.com/uptd.jalan_jembatan.smr/\">https://www.instagram.com/uptd.jalan_jembatan.smr/</a></div><div><br>———————————————<br><br>Dinas PUPR Kota Samarinda dapat diakses melalui:</div><ul><li>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a></li><li>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda/\">https://www.instagram.com/dpuprkotasamarinda</a></li><li>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a></li><li>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a></li><li>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;</li></ul><div>———————————————&nbsp;</div>', '-', 0, '2024-05-05 14:00:00', '2024-05-05 15:48:56'),
('0cecf02a-5c4a-4a00-8993-8b006d422fcd', 'Kegiatan Pemeliharaan Jl. Kadrie Oening', 'kegiatan-pemeliharaan-jl-kadrie-oening', 9, 'Berita/2024-05/03/7FDpeghI0OIG9xu96cLz5cWNZgdlcMtbIWsJ1HzJ.png', NULL, '<div><strong>Samarinda</strong> - Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda Bagian Unit Pelaksana Teknis Dinas (UPTD) Pemeliharaan Jalan dan Jembatan melakukan Kegiatan Perbaikan dan Pemeliharaan Jalan Kadrie Oening, Kelurahan Air Hitam, Kecamatan Samarinda Ulu, Kota Samarinda.&nbsp; Kegiatan pemeliharaan jalan ini akan meningkatkan kualitas jalan dan memberikan pengalaman berkendara yang lebih baik bagi pengguna jalan. Selain itu, ini juga merupakan bagian dari komitmen Pemerintah Kota Samarinda untuk terus meningkatkan infrastruktur dan layanan publik. <br><br>Silahkan laporkan kerusakan jalan di link berikut 👇<br><a href=\"https://forms.gle/CqvjPRs1uiEPL7TN7\">https://forms.gle/CqvjPRs1uiEPL7TN7</a> atau&nbsp;<a href=\"https://www.instagram.com/uptd.jalan_jembatan.smr/\">https://www.instagram.com/uptd.jalan_jembatan.smr/</a></div><div><br>———————————————<br><br>Dinas PUPR Kota Samarinda dapat diakses melalui:</div><ul><li>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a></li><li>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda/\">https://www.instagram.com/dpuprkotasamarinda</a></li><li>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a></li><li>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a></li><li>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;</li></ul><div>———————————————&nbsp;</div>', '-', 0, '2024-04-02 08:00:00', '2024-05-05 10:38:42'),
('14127005-2c0f-4bb7-ade8-6a16f488e48e', 'Rapat Koordinasi Terkait Advis Pelaksana Pembangunan Terowongan/Tunnel Jalan Sultan Alimuddin-Kakap Kota Samarinda', 'rapat-koordinasi-terkait-advis-pelaksana-pembangunan-terowongantunnel-jalan-sultan-alimuddin-kakap-kota-samarinda', 1, 'Berita/2024-07/30/hil3AT2HK4udrsoTUoPDALfspvZTSpCfn4axBCnB.png', NULL, '<div><strong>Samarinda</strong> - Pada Tanggal 29 Juli 2024,&nbsp; Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili Kepala Dinas PUPR Samarinda, Sekretaris Dinas PUPR Samarinda, Kepala Bidang Bina Marga, dan PPK Pembangunan Terowongan melakukan Rapat Koordinasi Terkait Advis Pelaksana Pembangunan Terowongan/Tunnel Jalan Sultan Alimuddin - Kakap Kota Samarinda<br><br>Rapat tersebut bertempat di Ruang Rapat Sembuyutan Lt.III Balaikota Samarinda yang dipimpin oleh Sekretaris Daerah Kota Samarinda, Bapak Bapak Ir. Hero Mardanus Satyawan, MT. Dan dihadiri juga oleh Tim Advisor Pembangunan Terowongan dan Tim Teknis Pembangunan Terowongan. Rapat tersebut bertujuan untuk mendiskusikan langkah-langkah selanjutnya untuk memastikan proyek berjalan sesuai rencana dan standar yang ditetapkan dan Tim pelaksana diinstruksikan untuk mempercepat penyelesaian beberapa bagian kritis agar proyek dapat selesai tepat waktu.<br><br> ———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div><div>&nbsp;</div><div><br><br><br></div>', '-', 0, '2024-07-28 21:30:00', '2024-07-29 15:17:55'),
('1484127b-ddfb-460d-a76c-45143778b703', 'Informasi Air Limbah Domestik', 'informasi-air-limbah-domestik', 8, 'Berita/2024-09/11/bvrqVm5wHWEHSniVeU3HxqtWUKJm2Y7PEEB4HxWE.jpg', NULL, '<div><strong>PENGUMUMAN</strong> - Pada Hari Rabu, 11 September 2024, Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda diwakili Bagian Unit Pelaksana Teknis Dinas (UPTD) Pengelolaan Air Limbah Domestik (<a href=\"https://www.instagram.com/perumdamsamarinda/\">@uptd.pald.samarinda</a>) untuk menginformasikan mengenai dengan Air Limbah Domestik? Menurut Peraturan Menteri PUPR No 04/PRT/M/2017 Tentang Penyelenggaraan Sistem Air Limbah Domestik.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-09-10 23:33:00', '2024-09-10 16:11:32'),
('1690a8d4-356c-4e31-a7fd-a346978f8d58', 'Rapat Koordinasi Dinas Pekerjaaan Umum dan Penataan Ruang Kota Samarinda', 'rapat-koordinasi-dinas-pekerjaaan-umum-dan-penataan-ruang-kota-samarinda', 1, 'Berita/2024-07/02/YoFMSmHO2Vk1qVgTSzMejTbqAV07AefDXCnLI6q9.png', NULL, '<div><strong>Samarinda</strong> - Pada Tanggal 2 Juli 2024, Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda melaksanakan Rapat Koordinasi Dinas PUPR Kota Samarinda terkait Progress Kegiatan dan Anggaran Tahun 2024.<br><br>Rapat tersebut berlangsung di Ruang Rapat Dinas PUPR Kota Samarinda yang dipimpin oleh Ibu Desy Damayanti, S.T., M.T. selaku Kepala Dinas PUPR Kota Samarinda dan dihadiri juga oleh Sekretaris Dinas, Seluruh Kepala Bidang, Seluruh Kepala UPTD Beserta Staff Admin Bidang Yang Menangani Anggaran.<br><br>Kegiatan tersebut diharapkan dapat meningkatkan efektivitas dan akuntabilitas penyelenggaraan anggaran Dinas untuk memonitor dan mengevaluasi kegiatan pembangunan yang sedang berjalan serta realisasi fisik di Dinas PUPR Kota Samarinda pada Aplikasi e-TEPIan versi 3. Dengan e-TEPIan versi 3, data perencanaan, penganggaran, dan pengadaan barang dan jasa dapat disinkronisasi secara otomatis dan real time.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————</div>', '-', 0, '2024-07-01 22:00:00', '2024-07-01 15:18:47'),
('1cbab412-fe8f-4513-a940-46ee8fb0276b', 'Focus Group Discussion Penyusunan Dokumen Rencana Tata Bangunan dan Lingkungan Kota Samarinda TA 2024', 'focus-group-discussion-penyusunan-dokumen-rencana-tata-bangunan-dan-lingkungan-kota-samarinda-ta-2024', 4, 'Berita/2024-09/26/1cbab412-fe8f-4513-a940-46ee8fb0276b/vuchcsWBRXMfW19rheNuy8tma7UNMiMQy4SqVX0s.png', NULL, '<div><strong>SAMARINDA</strong> - Pada Hari Kamis, 26 September 2024, Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili Bidang Bidang Cipta Karya (<a href=\"https://www.instagram.com/dpupr_kaltim/\">@sekretariatpbg_samarinda</a>) melakukan Focus Group Discussion (FGD - 1) Penyusunan Dokumen Rencana Tata Bangunan dan Lingkungan (RTBL) Kota Samarinda Tahun Anggaran 2024.<br><br>Rapat tersebut bertempat di Ruang Rapat Utama Dinas PUPR yang dipimpin oleh Sekretaris Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda, Ibu Neneng Chamelia Shanti, S.T., M.Si. Dan dihadiri juga oleh Beberapa Organisasi Perangkat Daerah (OPD) kota Samarida dan Stakeholder terkait bangunan gedung dan lingkungan.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-09-25 17:00:00', '2024-09-25 12:14:04'),
('1e6297a7-9fd8-4d9a-b54a-8b785fb70566', 'Pemeliharaan Jalan Merdeka Tembus Sambutan', 'pemeliharaan-jalan-merdeka-tembus-sambutan', 9, 'Berita/2024-08/19/mlJxO2298QWNZ8LXvHmRbtWeeo3Hd2BH45PzrGlL.jpg', NULL, '<div><strong>PENGUMUMAN</strong> -&nbsp; Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda menghimbau adanya Pemeliharaan Jalan Merdeka Tembus Sambutan, Kecamatan Sungai Pinang pada tanggal 19 Agustus 2024 - 26 Agustus 2024<br><br> Mohon maaf kepada pengendara kendaraan atas ketidaknyamanan yang mungkin terjadi selama proses tersebut. Kami berharap Anda dapat memahami dan bersabar selama pekerjaan ini berlangsung. Terima kasih atas kerjasamanya! 🙏<br>&nbsp;<br>&nbsp;</div><div>&nbsp;———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-08-18 16:00:00', '2024-08-18 10:27:34'),
('1e68617f-e9f3-43cd-b44a-e9bdc1887cea', 'Rapat Implementasi Perwali Nomor 73 Tahun 2023 Tentang Perubahan Atas Perwali Nomor 14 Tahun 2022 Tentang Petunjukan Teknis Pelaksanaan Izin Membuka Tanah Negara (IMTN)', 'rapat-implementasi-perwali-nomor-73-tahun-2023-tentang-perubahan-atas-perwali-nomor-14-tahun-2022-tentang-petunjukan-teknis-pelaksanaan-izin-membuka-tanah-negara-imtn', 7, 'Berita/2024-05/07/ovbRXvze1m5cYgBYvy0B3UElgVPOXEQ2xojgL7yn.png', NULL, '<div><strong>Samarinda</strong> - Pada Hari Rabu (06/03/2024)&nbsp; Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili Bidang Pertanahan melakukan Kegiatan Sosialisasi dan Pembinaan Ketua RT Se - Kecamatan Samarinda Ilir Dalam Rangka Implementasi Perwali Nomor 73 Tahun 2023 Tentang Perubahan Atas Perwali Nomor 14 Tahun 2022 Tentang Petunjukan Teknis Pelaksanaan Izin Membuka Tanah Negara (IMTN)<br><br>Rapat tersebut bertempat di Aula Pertemuan Kecamatan Samarinda Ilir yang dipimpin oleh Sekretaris Camat Samarinda Ilir dan Sub Koordinator Izin Membuka Tanah Negara (IMTN). Dan dihadiri oleh Seluruh Ketua RT Kecamatan Samarinda Ilir&nbsp;</div>', '-', 0, '2024-03-05 08:00:00', '2024-05-06 09:51:15'),
('209ded73-c7d5-43b7-b405-48fe3e8d7928', 'Formulir Pengaduan UPTD Pemeliharaan Jalan dan Jembatan Kota Samarinda', 'formulir-pengaduan-uptd-pemeliharaan-jalan-dan-jembatan-kota-samarinda', 9, 'Berita/2024-08/05/l5eCNirmqbPK1htJwtyfu4qkiRyQ0Hr90gPtrBLL.jpg', NULL, '<div><strong>PENGUMUMAN</strong> -&nbsp; Selamat datang di Form Pengaduan UPTD Pemeliharaan Jalan dan Jembatan Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda. Kami ingin mengajak Anda untuk turut serta dalam menjaga infrastruktur kota kita. Kini tersedia Form Pengaduan online yang memudahkan Anda melaporkan berbagai masalah jalan dan jembatan.</div><div><br>🚧 Temukan lubang di jalan?</div><div>🚧 Melihat kerusakan yang perlu segera diperbaiki?<br><br>Jangan ragu untuk melaporkannya melalui formulir pengaduan ini. Setiap laporan Anda membantu kami meningkatkan kualitas jalan dan jembatan di Kota Samarinda.<br><br></div><div>Link Pengaduan <figure data-trix-attachment=\"{&quot;contentType&quot;:&quot;image&quot;,&quot;height&quot;:16,&quot;url&quot;:&quot;https://static.xx.fbcdn.net/images/emoji.php/v9/t9c/1/16/1f53b.png&quot;,&quot;width&quot;:16}\" data-trix-content-type=\"image\" class=\"attachment attachment--preview\"><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t9c/1/16/1f53b.png\" width=\"16\" height=\"16\"><figcaption class=\"attachment__caption\"></figcaption></figure></div><div><a href=\"https://l.facebook.com/l.php?u=https%3A%2F%2Fbit.ly%2FFormPengaduanJalanRusakUPTDPJJ%3Ffbclid%3DIwZXh0bgNhZW0CMTAAAR07nvxXm6ErkDHZvVKqiKyU8qYAcUSPl4spjG16nhku2IBxdbeRsm4OUCI_aem_CdQqRCUqThbD3fH6cw8JzQ&amp;h=AT0gUVS1j_DPs8VvB-EwdSR4AYe70517FacK-fQuWSY593SCJeOYF2v7xOuDua-A7Kd0yHwXQrTy1Zi6iVZoWcYRmuCAneVTxcnBacv7RqwDCDP4JRL1imxyJhHHFeta2Wui&amp;__tn__=-UK-R&amp;c[0]=AT3Aw542tVBMkw6_escVGFJsttva7tJ7SZyf0H9p_6XsghmYw1AaUfY_uyjgP72SbuvryMKjYnn02msOq-dLmRqCSztUhfJBfk298iC9zjoUrCw1ZoDCfr0jHnVpPCpQy7BR6NqXPEveSZtFiY2tsRxLSvNq7u1qPbgdSnR4MrANVhK0IcEXisQe2pQEuhBBIVzIoRDalzYzkoy0iZ4-bI1GDD2DPz6RRaxl\">https://bit.ly/FormPengaduanJalanRusakUPTDPJJ</a></div><div><br>CP. UPTD PJJ <figure data-trix-attachment=\"{&quot;contentType&quot;:&quot;image&quot;,&quot;height&quot;:16,&quot;url&quot;:&quot;https://static.xx.fbcdn.net/images/emoji.php/v9/t9c/1/16/1f53b.png&quot;,&quot;width&quot;:16}\" data-trix-content-type=\"image\" class=\"attachment attachment--preview\"><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t9c/1/16/1f53b.png\" width=\"16\" height=\"16\"><figcaption class=\"attachment__caption\"></figcaption></figure></div><div><a href=\"https://l.facebook.com/l.php?u=https%3A%2F%2Fwa.me%2F6282252544708%3Ffbclid%3DIwZXh0bgNhZW0CMTAAAR32iLdnyrTdVrQN6MzjWOiGowi39SbSkVl3YFJ8kkW8EsnLn1RBI6qb7dk_aem_SyYuy73K8q3h8e4x8aERhw&amp;h=AT0iMASPQIbwB_8dE_v_yqvGC3wr6e5o1nkxHoKHnQnD22ncjbVEnmyuUh450DGfN91igHyigef1yvHWAQQ5C0w6AV4nyIz6g3ySview22PyvG5EaDRIAagubJSnmX3-qshq&amp;__tn__=-UK-R&amp;c[0]=AT3Aw542tVBMkw6_escVGFJsttva7tJ7SZyf0H9p_6XsghmYw1AaUfY_uyjgP72SbuvryMKjYnn02msOq-dLmRqCSztUhfJBfk298iC9zjoUrCw1ZoDCfr0jHnVpPCpQy7BR6NqXPEveSZtFiY2tsRxLSvNq7u1qPbgdSnR4MrANVhK0IcEXisQe2pQEuhBBIVzIoRDalzYzkoy0iZ4-bI1GDD2DPz6RRaxl\">https://wa.me/6282252544708</a> (Chat Only)</div><div><br>Klik tautan Form Pengaduan yang tersedia di bio <a href=\"https://www.instagram.com/uptd.jalan_jembatan.smr/\">@uptd.jalan_jembatan.smr</a> untuk mulai melaporkan.<br><br>Terima kasih atas partisipasi Anda dalam menciptakan Samarinda yang lebih baik!<br><br> ———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-08-04 19:00:00', '2024-08-04 11:42:39'),
('21e70290-f008-11eb-89d3-35a2c0bcd602', 'SIDANG TABG SLF  BANGUNAN GEDUNG GIANT ALAYA', 'sidang-tabg-slf-bangunan-gedung-giant-alaya', 4, 'Berita/2021-07/29/sidang-tabg-slf-bangunan-gedung-giant-alaya.jpeg', 'Arsip DPUPR', '<p>KAMIS, 15 JULI 2021<br />Bidang Cipta Karya Dinas PUPR Kota Samarinda, Melalui Tim sekretariat TABG melaksanakan Sidang TABG untuk permohonan SLF bangungan gedung GIANT ALAYA (PT. HERO INDONESIA).&nbsp;<br />Adapun peserta sidang terdiri dari PT. MAYALOKA (pengkaji Teknis), &nbsp;Anggota TABG dari unsur Akademis yang ada dikota Samarinda, Tim Sekretariat Pengelola TABG dan Fungsional Ahli Tata Bangunan dan Perumahan.</p>', 'SIDANG TABG SLF  BANGUNAN GEDUNG GIANT ALAYA', 2047, '2021-07-15 08:00:00', '2023-12-08 16:59:57'),
('261274dd-5b0d-4d1d-bc41-4e06908207ee', 'Wali Kota Samarinda Meresmikan Pembangunan Jalan Baru Merdeka - Sambutan', 'wali-kota-samarinda-meresmikan-pembangunan-jalan-baru-merdeka-sambutan', 1, 'Berita/2024-05/07/QdzFu4s96XE1rA5wohVIQYSXqfR4tqLUYoKziEm0.png', NULL, '<div><strong>Samarinda</strong> - Pada Hari Jum\'at (01/03/2024)&nbsp; Walikota Samarinda, Bapak Dr. H. Andi Harun, S.T., S.H., M.Si. didampingi oleh Sekretaris Daerah Kota Samarinda dan Asisten III Kota Samarinda bersama Kepala Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda, Ibu Desy Damayanti S.T., M.T. serta beberapa Organisasi Perangkat Daerah (OPD) Kota Samarinda melakukan Peresmian Pembangunan Jalan Merdeka Menuju Sambutan.<br><br> Kegiatan tersebut dilakukan berdasarkan usulan masyarakat melalui forum Musyawarah Rencana Pembangunan (Musrenbang) dari tingkat Kelurahan hingga Kecamatan di Kota Samarinda.<br><br>Pembangunan jalan tersebut diharapkan dapat mengurangi kemacetan di Kota Samarinda pada Kawasan Jalan Otto Iskandardinata, Gunung Manggah, Samarinda Ilir yang mengarah ke wilayah Kecamatan Sambutan. Diharapkan masyarakat bisa menjaga kondisi jalan dan memanfaatkan dengan sebaik -baiknya.&nbsp;</div>', '-', 0, '2024-02-29 17:00:00', '2024-05-06 09:43:00'),
('2c3e7c03-6a2f-48bf-be46-73efcbd3de81', 'Dinas Pekerjaan Umum dan Penataan Ruang Mengikuti Kerja Bakti Lintas OPD Di Lingkungan Balaikota Samarinda', 'dinas-pekerjaan-umum-dan-penataan-ruang-mengikuti-kerja-bakti-lintas-opd-di-lingkungan-balaikota-samarinda', 1, 'Berita/2024-12/02/E44qgHs6G2UgyeuNxEx0isUt3dllyoUUgbsyuc0v.png', NULL, '<div>SAMARINDA - Pada Hari Minggu, 1 Desember 2024. Wali Kota Samarinda, Bapak Dr. H. Andi Harun, S.T., S.H., M.Si. Pimpin Kerja Bakti Lintas Organisasi Perangkat Daerah (OPD) di Lingkungan Balaikota Samarinda. Kegiatan yang dimulai dari titik kumpul di halaman parkir Balaikota, diikuti oleh Sekretaris Daerah (SEKDA), para asisten, staf ahli, kepala perangkat daerah, hingga lebih dari 30 staf pendukung dari berbagai bagian.<br><br>Dinas Pekerjaan Umum dan Penataan Ruang Samarinda mengikuti rangkaian kegiatan tersebut. Dengan diiringi rintikan hujan sejak pagi dan dalam suasana penuh kebersamaan diharapkan untuk mewujudkan lingkungan kantor yang bersih dan sehat, karena untuk mendorong komitmen Pemerintah Kota (Pemkot) Samarinda untuk terus menjaga kebersihan seluruh kota serta kegiatan seperti ini akan dilaksanakan secara regular.<br><br>Selain kebersihan, Wali Kota Samarinda juga menekankan pentingnya menjaga vegetasi hijau di sekitar Balaikota. “Tidak ada pohon yang perlu ditebang kecuali untuk merapikan pohon yang berpotensi tumbang. Kita justru perlu pohon yang rindang. Selama tidak ada risiko tumbang, kita harus mempertahankan supaya tetap hidup dan hijau untuk menghasilkan oksigen yang baik,” jelasnya.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-11-30 15:30:00', '2024-12-01 09:53:34'),
('30b03d71-8481-4f75-9d1f-2726a56ed0ed', 'Kegiatan Rutin Pengerukan Sedimentasi Drainase di Jalan MT.Haryono', 'kegiatan-rutin-pengerukan-sedimentasi-drainase-di-jalan-mtharyono', 10, 'Berita/2024-07/22/Wzzd5E9tXSV1hVyq4nrHuSGsAxlINBD5GEOZSW5T.png', NULL, '<div>&nbsp;<strong>Samarinda</strong> - Pada Tanggal 21 Juli 2024, Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda Bagian Unit Pelaksana Teknis Dinas (UPTD) Pemeliharaan Saluran Drainase dan Irigasi (<a href=\"https://www.instagram.com/uptd_drainase_samarinda/\">@uptd_drainase_samarinda</a>) melakukan Kegiatan Rutin Pengerukan Sedimentasi Drainase di Jalan MT. Haryono, Kelurahan Air Putih, Kecamatan Samarinda Ulu yang dilakukan oleh Tim Hantu Banyu.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-07-20 19:56:00', '2024-07-21 11:57:09'),
('30f5ce5d-4bdb-4e57-8181-2faabc158ad4', 'Kick Off Program Pembangunan dan Pemberdayaan Masyarakat (Probebaya) Tahun 2024', 'kick-off-program-pembangunan-dan-pemberdayaan-masyarakat-probebaya-tahun-2024', 1, 'Berita/2024-05/17/q0anYF8Acai5q3KKXFbkefDy4ehiuKIAaAUPjmwy.png', NULL, '<div><strong>Samarinda</strong> - Pada tanggal 17 Mei 2024, Wali Kota Samarinda, Bapak Dr. H. Andi Harun, S.T., S.H., M.Si., membuka secara resmi kegiatan <strong>Kick Off Program Pembangunan dan Pemberdayaan Masyarakat (Probebaya) Tahun 2024</strong> dengan tema “Probebaya Menuju Samarinda Kota Peradaban.”<br><br>Acara ini berlangsung di Ruang Crystal II Lantai III Mercure Hotel Samarinda dan dihadiri oleh Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda, para Kepala Organisasi Perangkat Daerah (OPD), Camat dari seluruh Samarinda, Lurah - lurah, dan Ketua Kelompok Masyarakat (Pokmas) Kota Samarinda.<br><br>Dalam sambutannya, Wali Kota Samarinda menegaskan bahwa inisiatif Probebaya yang telah digulirkan sejak awal masa jabatannya merupakan solusi yang sangat ditunggu-tunggu oleh masyarakat, khususnya para ketua RT di Samarinda. Program ini menuai respon positif, terutama setelah melihat suasana musyawarah perencanaan pembangunan (musrenbang) yang lebih kondusif selama periode kepemimpinannya.<br><br>Probebaya merupakan program berbasis pemberdayaan masyarakat di tingkat RT yang kini memasuki tahun ketiga sejak dimulai pada 2022 lalu. Tujuan dari program ini adalah untuk meningkatkan partisipasi masyarakat dalam pembangunan dan pemberdayaan di Kota Samarinda. \"Sekarang, para ketua RT dan LPM lebih fokus pada usulan program yang bermanfaat bagi masyarakat. Tapi setiap program pasti ada kekurangannya. Tapi, Probebaya secara keseluruhan telah memberikan dampak positif bagi pembangunan di Samarinda,\" tuturnya.<br><br>———————————————<br><br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————</div>', '-', 0, '2024-05-16 21:30:00', '2024-05-16 20:48:00'),
('314eda86-b987-4a1f-aa70-875528cecb59', 'Pengerukan Sedimentasi dan Sampah Anorganik di Jalan Banggeris Folder Gang Indra', 'pengerukan-sedimentasi-dan-sampah-anorganik-di-jalan-banggeris-folder-gang-indra', 10, 'Berita/2024-07/22/GHhpJDDnkcDp5PwMkSrc28eoEPbCEgQUviw1ESGt.png', NULL, '<div><strong>Samarinda</strong> - Pada Tanggal 21 Juli 2024, Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda Bagian Unit Pelaksana Teknis Dinas (UPTD) Pemeliharaan Saluran Drainase dan Irigasi (<a href=\"https://www.instagram.com/uptd_drainase_samarinda/\">@uptd_drainase_samarinda</a>) melakukan Kegiatan Rutin Pengerukan Sedimentasi dan Sampah Anorganik di Jalan Banggeris Folder Gang Indra, Kelurahan Air Putih, Kecamatan Samarinda Ulu yang dilakukan oleh Tim Hantu Banyu.<br><br> ———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-07-20 19:54:00', '2024-07-21 11:54:54'),
('326de293-3321-4bf2-a8f3-cea07cc4cec3', 'Sertifikasi Tenaga Kerja Konstruksi Kualifikasi Jabatan Operator untuk Jabatan Kerja Tukang Jenjang 1 dan 2', 'sertifikasi-tenaga-kerja-konstruksi-kualifikasi-susunan_organisasi-operator-untuk-susunan_organisasi-kerja-tukang-jenjang-1-dan-2', 5, 'Berita/2024-06/25/MoWbhqVAhe9Prkea9mreymHjw7W3mYyWD0sUyB1Y.png', NULL, '<div><strong>Samarinda</strong> - Pada Tanggal 21 Juni 2024, Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda melalui Bidang Bina Konstruksi melaksanakan Kegiatan Sertifikasi Tenaga Kerja Konstruksi Kualifikasi Jabatan Operator untuk Jabatan Kerja Tukang Pasang Bata, Tukang Pasang Ubin, Tukang Cat, Tukang Pasang Rangka Baja Ringan Jenjang 1 dan 2.<br><br>Kegiatan ini dilaksanakan dalam rangka menjalankan tugas dan wewenang yang diatur dalam Undang-Undang Nomor 2 Tahun 2017 Tentang Jasa Konstruksi, Dimana memberikan kepastian bahwa setiap pekerja memiliki pengetahuan dan keterampilan yang dibutuhkan untuk melaksanakan tugasnya dengan baik melalui uji kompetensi terhadap tenaga kerja konstruksi di Kota Samarinda terutama kualifikasi operator (Tukang &amp; Operator Exavator).<br><br>Oleh karena itu, selain memberikan pelatihan kepada peserta, juga dilakukan uji kompetensi untuk mendapatkan Sertifikat Kompetensi Kerja (SKK) sebagai pembuktian di depan hukum negara . Dinas PUPR Melalui Bidang Bina Konstruksi bekerja sama dengan P3SM Kaltim melaksanakan kegiatan uji kompetensi yang di ikuti oleh 14 orang Operator Exavator yang bekerja di UPTD Pemeliharaan Saluran Drainase &amp; Irigasi (Hantu Banyu) dan 40 Orang Tukang yang sedang bekerja di salah satu kegiatan Konstruksi Di Kota Samarinda.<br><br>Dengan adanya kegiatan ini diharapkan mampu meningkat kemampuan kompetensi tenaga kerja konstruksi khususnya di Kota Samarinda.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-06-20 16:30:00', '2024-06-24 15:13:32'),
('33019a2c-8e35-4ba7-be78-b7d498c8dc2e', 'Sosialisasi dan Bimbingan Teknis SISWASTEK Provinsi Kalimantan Timur Tahun 2024', 'sosialisasi-dan-bimbingan-teknis-siswastek-provinsi-kalimantan-timur-tahun-2024', 6, 'Berita/2024-05/03/RvqDcvmYwWD1rInE20gcfUYFaQcWbe9P29UyjJMQ.png', NULL, '<div><strong>Balikpapan</strong> -&nbsp; Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili Bidang Penataan Ruang melakukan Sosialisasi dan Bimbingan Teknis (Bimtek) Sistem Informasi Pengawasan Teknis (SISWASTEK) Provinsi Kalimantan Timur Tahun 2024 pada Hari Kamis (02/05/2024).<br><br>Acara tersebut bertempat di Hotel Grand Jatra Balikpapan yang diadakan oleh Dinas Pekerjaan Umum, Penataan Ruang dan Perumahan Rakyat Provinsi Kalimantan Timur. Dalam Sosialisasi dan Bimbingan Teknis ini menjelaskan mengenai pemberian informasi dan sosialisasi terkait tata cara pengawasan terhadap kinerja pengaturan penataan ruang, pembinaan penataan ruang, dan pelaksanaan penataan ruang.<br><br>Kegiatan ini dipimpin oleh Ibu Nurani Citra Adran, S.SI., M.EC.DEV selaku Kepala Bidang Penataan Ruang Provinsi Kalimantan Timur dan dihadiri oleh Organisasi Perangkat Daerah (OPD) Kalimantan Timur. Selanjutnya, pemaparan materi oleh Direktorat Jenderal Pengendalian Pemanfaatan Ruang Kementerian ATR/BPN Tentang Pelaksanaan Pengawasan Kinerja Penyelenggaraan Penataan Ruang Daerah Provinsi Kalimantan Timur Tahun 2024. Dan pemaparan materi Simulasi Pengawasan Kinerja Pengaturan, Pembinaan dan Pelaksanaan Penataan Ruang (TURBINLAK) dan Kinerja Fungsi - Manfaat Penyelengaraan Penataan Ruang melalui SISWASTEK.&nbsp;</div><div><br>———————————————<br><br>Dinas PUPR Kota Samarinda dapat diakses melalui:</div><ul><li>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a></li><li>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda/\">https://www.instagram.com/dpuprkotasamarinda</a></li><li>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a></li><li>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a></li><li>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;</li></ul><div>———————————————&nbsp;</div>', '-', 0, '2024-05-01 17:00:00', '2024-05-02 14:48:55'),
('33653934-393e-4679-8581-3748a7d653eb', 'Pengerukan Gulma dan Sampah Anorganik pada Drainase Sungai Alam Jl. Perjuangan Baru', 'pengerukan-gulma-dan-sampah-anorganik-pada-drainase-sungai-alam-jl-perjuangan-baru', 10, 'Berita/2024-05/07/ZgcEYuSba6eTPGCWIGq14InQ0pa3e8g0Qlu6RKar.png', NULL, '<div><strong>Samarinda</strong> - Pada Hari Jum\'at (01/03/2024)&nbsp; Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda Bagian Unit Pelaksana Teknis Dinas (UPTD) Pemeliharaan Saluran Drainase dan Irigasi melakukan Kegiatan Rutin Pengerukan Gulma dan Sampah Anorganik pada Drainase Sungai Alam Jalan Perjuangan Baru yang dilakukan oleh Tim Hantu Banyu<br><br>Kegiatan tersebut dilakukan untuk menanggulangi meluapnya air/pendangkalan saluran agar segera bisa teratasi dan meminimalisasi banjir akibat terhambatnya aliran air pada saluran drainase&nbsp;</div>', '-', 0, '2024-02-29 08:00:00', '2024-05-06 09:39:12'),
('35015090-94ac-11ee-b147-ebad4aa39c76', 'Kunjungan Pemerintah Kota Samarinda ke PJ Gubernur Kalimantan Timur dalam Perencanaan Anggaran Bantuan Provinsi Kalimantan Timur Tahun 2024', 'kunjungan-pemerintah-kota-samarinda-ke-pj-gubernur-kalimantan-timur-dalam-perencanaan-anggaran-bantuan-provinsi-kalimantan-timur-tahun-2024', 1, 'Berita/2023-12/07/kunjungan-pemerintah-kota-samarinda-ke-pj-gubernur-kalimantan-timur-dalam-perencanaan-anggaran-bantuan-provinsi-kalimantan-timur-tahun-2024.png', 'Seketariat', '<p><strong>Samarinda</strong> - Pada Hari Rabu (29/11/2023) Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda melakukan kunjungan ke PJ Gubernur Kalimantan Timur Bapak Dr. Drs. Akmal Malik, M.Si dalam Perencanaan Anggaran Bantun Provinsi Kalimantan Timur Tahun 2024 bertempat di Kantor Gubernur Kalimantan Timur. Kunjungan tersebut dihadiri oleh Ibu Desy Damayanti, ST., MT. selaku Kepala Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda didampingi dengan Kabid SDA, Kabid Bina Marga, dan Kabid Cipta Karya serta bersama dengan Bapak Dr. H. Ali Fitri Noor, MM selaku Assisten III Sekot Samarinda dan Bapak H. Ananta Fathurrozi, S.Sos., M.Si selaku Kepala Bappedalitbang Kota Samarinda.</p>', '-', 6, '2023-11-28 08:00:00', '2023-12-12 23:42:45');
INSERT INTO `berita` (`uuid_berita`, `judul_berita`, `slug_berita`, `id_berita_kategori`, `foto_berita`, `sumber_foto_berita`, `isi_berita`, `preview_berita`, `views_count`, `created_at`, `updated_at`) VALUES
('37ac80d0-94ae-11ee-9f39-95927f5a87c6', 'Peninjauan Lapangan dan Pendataan Kawasan Keselamatan Operasi Penerbangan (KKOP) pada Bandara APT. Pranoto', 'peninjauan-lapangan-dan-pendataan-kawasan-keselamatan-operasi-penerbangan-kkop-pada-bandara-apt-pranoto', 6, 'Berita/2023-12/07/peninjauan-lapangan-dan-pendataan-kawasan-keselamatan-operasi-penerbangan-kkop-pada-bandara-apt-pranoto.png', 'Penataan Ruang', '<p><strong>Samarinda</strong> - Pada Hari Senin (27/2023) Dinas Pekerjaan Umum dan Penataan Ruang Bidang Penataan Ruang dan Bidang Pertanahan bersama dengan A.P.T. Pranoto, BPKAD Kota Samarinda, Dinas Lingkungan Hidup Kota Samarinda, Kecamatan Samarinda Utara, Kelurahan Sungai Siring, dan PT. PLN Samarinda melakukan peninjauan dan pendataan obstacle yang berpotensi mengganggu Kawasan Keselamatan Operasional Penerbangan (KKOP) Bandar Udara A.P.T. Pranoto. Kegiatan peninjauan dan pendataan tersebut dilakukan terhadap bangunan, tiang listrik, dan pohon yang berdasarkan arahan kawasan kemungkinan bahaya kecelakaan pada operasi penerbangan.</p>', 'Dinas Pekerjaan Umum dan Penataan Ruang Bidang Penataan Ruang melakukan peninjauan dan pendataan Kawasan Keselamatan Operasional Penerbangan (KKOP) Bandar Udara A.P.T. Pranoto terhadap bangunan, tiang listrik, dan pohon.', 32, '2023-11-26 08:00:00', '2023-12-12 00:49:35'),
('3d03de80-05a5-11ee-a35a-151911eb393e', 'test', 'test', 6, 'Berita/2023-06/08/test.jpeg', 'test', '<p>test</p>', 'test', 1658, '2023-06-04 08:00:00', '2023-12-12 02:07:17'),
('3d4e6029-16d3-48d9-addc-da8c828f0e21', 'Diskusi Teknis Pelaksanaan Kesesuaian Kegiatan Pemanfaatan Ruang Pasca Terbitnya Peraturan Presiden Nomor 55 Tahun 2022', 'diskusi-teknis-pelaksanaan-kesesuaian-kegiatan-pemanfaatan-ruang-pasca-terbitnya-peraturan-presiden-nomor-55-tahun-2022', 6, 'Berita/2024-05/03/V392WDTC4fiafdK3KEkGPiUomQRJY1Yc0Ed0SeNV.png', NULL, '<div><strong>Balikpapan</strong> -&nbsp; Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili Bidang Penataan Ruang melakukan Diskusi Teknis Pelaksanaan Kesesuaian Kegiatan Pemanfaatan Ruang (KKPR) Pasca Terbitnya Peraturan Presiden Nomor 55 Tahun 2022 Tentang Pendelegasian Pemberian Perizinan Berusaha Di Bidang Pertambangan Mineral Dan Batubara di Provinsi Kalimantan Timur pada Hari Jum\'at (03/05/2024).<br><br>Acara tersebut bertempat di Hotel Grand Jatra Balikpapan yang diadakan oleh Dinas Pekerjaan Umum, Penataan Ruang dan Perumahan Rakyat Provinsi Kalimantan Timur. Dalam Diskusi Teknis ini menjelaskan mengenai pelaksanaan Kesesuaian Kegiatan Pemanfaatan Ruang (KKPR) untuk kegiatan berusaha dilaksanakan melalui sistem <em>Online single submission </em>(OSS) sehingga perlu diketahui bagaimana mekanisme pemberian Wilayah Izin Usaha Pertambangan dan Izin Usaha Pertambangan berdasarkan kewenan pemerintah daerah.<br><br>Kegiatan ini dipimpin oleh Ibu Nurani Citra Adran, S.SI., M.EC.DEV selaku Kepala Bidang Penataan Ruang Provinsi Kalimantan Timur dan dihadiri oleh Organisasi Perangkat Daerah (OPD) Kalimantan Timur. Selanjutnya, diskusi mengenai Mekanisme dalam penerbitan atau pemberian rekomendasi WIUP dan IUP pasca terbitnya Perpres 55 Tahun 2022 dan Mekanisme penerbitan KKPR untuk WIUP dan IUP yang didelegasikan sebagaimana Perpres 55 Tahun 2022 oleh Dinas ESDM Provinsi Kalimantan Timur dan Kementerian ATR/BPN. Dan Pemaparan SOP Penerbitan Informasi Tata Ruang oleh Kepala Bidang Penataan Ruang Provinsi Kalimantan Timur.<br><br>———————————————<br><br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————</div>', '-', 0, '2024-05-02 17:00:00', '2024-05-05 10:08:59'),
('3e1db278-8062-4bb2-a1e8-48e051a67a42', 'Kunjungan Kerja Sekretariat SIMBG Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Berau', 'kunjungan-kerja-sekretariat-simbg-dinas-pekerjaan-umum-dan-penataan-ruang-kabupaten-berau', 4, 'Berita/2024-05/07/2IGWB18jIhqFVTxmmFzcTLZMBeATxWmeIsNKEivq.png', NULL, '<div><strong>Samarinda</strong> - Pada Hari Rabu (06/03/2024) Sekretariat SIMBG Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Berau melakukan Kunjungan Kerja ke Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda melalui Bidang Cipta Karya<br><br>Kunjungan tersebut membahas terkait layanan data pada Sistem Informasi Manajemen Bagunan Gedung (SIMBG) di Kota Samarinda yang dipimpin oleh Bapak Tajudin Husen, ST., MM. selaku Jafung Penata Kelola Bangunan Gedung dan Kawasan Permukiman&nbsp;</div>', '-', 0, '2024-03-05 08:00:00', '2024-05-06 09:54:35'),
('4643e3cd-2e80-4455-9132-c0c1fb77666d', 'Kegiatan Rutin Pengerukan Parit Jl. Gurami RT 01', 'kegiatan-rutin-pengerukan-parit-jl-gurami-rt-01', 10, 'Berita/2024-07/03/cVWGT2gTNMiylv0tOlOijzWOVwoABYlwizrUNa6D.png', NULL, '<div><strong>Samarinda</strong> - Pada Tanggal 3 Juli 2024, Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda Bagian Unit Pelaksana Teknis Dinas (UPTD) Pemeliharaan Saluran Drainase dan Irigasi (<a href=\"https://www.instagram.com/uptd_drainase_samarinda/\">@uptd_drainase_samarinda</a>) melakukan Kegiatan Rutin Pengerukan Parit Jalan Gurami RT 01, Kelurahan Sungai Dama, Kecamatan Samarinda Ilir yang dilakukan oleh Tim Hantu Banyu.<br><br> ———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-07-02 17:54:00', '2024-07-02 11:03:02'),
('4650022f-a16e-4b93-b99e-223b72fd09d8', 'Pembangunan Kolam Retensi di Kelurahan Sempaja Timur Akan Mulai di Bangun', 'pembangunan-kolam-retensi-di-kelurahan-sempaja-timur-akan-mulai-di-bangun', 1, 'Berita/2024-05/03/4650022f-a16e-4b93-b99e-223b72fd09d8/68Oq1zrVVOKGbupWZKU8MwVyO9aoQ3xes2TkGdaA.png', NULL, '<div><strong>Samarinda</strong> - Pada Hari Selasa (23/4/2024) Walikota Samarinda, Bapak Dr. H. Andi Harun, S.T., S.H., M.Si. bersama Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda melakukan Rapat Rencana Pembangunan Kolam Retensi di Kelurahan Sempaja Timur Kecamatan Smaarinda Utara yang telah menemui titik terang<br><br>Kegiatan tersebut bertempat di Ruang Rapat Wali Kota Balaikota Lantai II. Pembangunan ini merupakan bentuk keseriusan Pemerintah Kota (Pemkota) Samarinda dalam pengendalian banjir yang sering terjadi di simpang 4 Sempaja Jalan KH Wahid Hasyim 2 dan Jalan PM Noor. Dalam pembangunan tersebut, Walikota Samarinda mengatakan bahwa saat ini Pemerintah Kota (Pemkot) Samarinda tengah mempersiakan administrasinya, awal bulan mei ini rencananya sudah bertanda tangan kontrak.<br><br></div><div>———————————————<br><br>Dinas PUPR Kota Samarinda dapat diakses melalui:</div><ul><li>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a></li><li>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda/\">https://www.instagram.com/dpuprkotasamarinda</a></li><li>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a></li><li>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a></li><li>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;</li></ul><div>———————————————&nbsp;</div>', '-', 0, '2024-04-22 21:30:00', '2024-05-02 14:46:51'),
('4a28cf63-e964-43f1-889b-0500ee020473', 'Pengerukan Sedimentasi Saluran Drainase Jalan Tridarma Gunung Kelua', 'pengerukan-sedimentasi-saluran-drainase-jalan-tridarma-gunung-kelua', 10, 'Berita/2024-05/07/pRK1MV3FOqNB2ECGyICh4bMhSTBspKgXBV2wFde6.png', NULL, '<div><strong>Samarinda</strong> - Pada Hari Jum\'at (01/03/2024)&nbsp; Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda Bagian Unit Pelaksana Teknis Dinas (UPTD) Pemeliharaan Saluran Drainase dan Irigasi melakukan Kegiatan Rutin Pengerukan Sedimentasi Saluran Drainase Jalan Tridarma Gunung Keluar yang dilakukan oleh Tim Hantu Banyu. Kegiatan tersebut dilakukan untuk meminimalisasi banjir akibat terhambatnya aliran air pada saluran drainase&nbsp;</div>', '-', 0, '2024-02-29 08:00:00', '2024-05-06 09:41:09'),
('54e0b557-de90-41dc-ba2c-d3a678d41f04', 'Pembongkaran 99 Bangunan di Bantaran Tepi Sungai Karang Mumus Segmen Hotel JB', 'pembongkaran-99-bangunan-di-bantaran-tepi-sungai-karang-mumus-segmen-hotel-jb', 1, 'Berita/2024-07/11/3CbWczuJ14jU9xPANaZGTkaOO8IE2kRmKw337Zky.png', NULL, '<div><strong>Samarinda</strong> - Pada Tanggal 9 Juli 2024, Walikota Samarinda, Bapak Dr. H. Andi Harun, S.T., S.H., <a href=\"https://l.facebook.com/l.php?u=http%3A%2F%2FM.Si%2F%3Ffbclid%3DIwZXh0bgNhZW0CMTAAAR1b4qh2TX35e7bzthZ_MqF0_7vlg3kfttH6Frt36VCZuQpSUyAeY-bhI3A_aem_EfGWMplET-bfDx-KvcUKkw&amp;h=AT1XNv4qHGhfz9uVqk6xGOwL6cU2cbgO4rNhVJ5SpM8l9iyVpxWZ1E63eAfy7QicSfoyVh2pzXabh3Nqu8JND6MKAr6nlF4SJQIn2EqYA9IX2LzcfDbpWzzFJ62JJZxdhZZ8&amp;__tn__=-UK-R&amp;c[0]=AT3YPbChAnOK4mNGSO5vNHpiHq9OpPznM4-ygLMUGsIyERNJKeZdjNapEZSWeDky68Oi_ERoM7qGh6dhIKqYpCq-sP6t9fC0TA5CnkdduocxRyulES5e4Bqn_Ap_sVrHfLGfTh3U87W1K8MvOWCxa5sMzaz08D41Z9Trrj-SWFM4le_kfKI67A-2Oq_7Vp2NlAEZUZVazjthzkxA6yh9fjDbdg-WiKr-1WxShKnpJzlJReIfOk0p\">M.Si.</a> bersama jajaran pejabat terkait seperti Sekretaris Daerah Kota Samarinda, Bapak Ir. Hero Mardanus Satyawan, MT. PLT Asisten II, Bapak Marnabas, S.Sos., <a href=\"https://l.facebook.com/l.php?u=http%3A%2F%2FM.Si%2F%3Ffbclid%3DIwZXh0bgNhZW0CMTAAAR3xuy2CNboAxYBxl-FxA9TvnkvT5YvIK8YLg87DYwseSeprvDRiDJnQLZI_aem_-xegqmqRhutccOdmhgZAgg&amp;h=AT1XNv4qHGhfz9uVqk6xGOwL6cU2cbgO4rNhVJ5SpM8l9iyVpxWZ1E63eAfy7QicSfoyVh2pzXabh3Nqu8JND6MKAr6nlF4SJQIn2EqYA9IX2LzcfDbpWzzFJ62JJZxdhZZ8&amp;__tn__=-UK-R&amp;c[0]=AT3YPbChAnOK4mNGSO5vNHpiHq9OpPznM4-ygLMUGsIyERNJKeZdjNapEZSWeDky68Oi_ERoM7qGh6dhIKqYpCq-sP6t9fC0TA5CnkdduocxRyulES5e4Bqn_Ap_sVrHfLGfTh3U87W1K8MvOWCxa5sMzaz08D41Z9Trrj-SWFM4le_kfKI67A-2Oq_7Vp2NlAEZUZVazjthzkxA6yh9fjDbdg-WiKr-1WxShKnpJzlJReIfOk0p\">M.Si.</a> Ketua TWAP, Bapak Syaparudin, S.Sos. Dan Kepala Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda, Ibu Desy Damayanti, S.T., M.T berserta jajarannya melakukan Pemantauan Kegiatan Pembongkaran 99 Bangunan di Bantaran Tepi Sungai Karang Mumus (SKM) Segmen Hotel JB Jalan KH. Agus Salim.<br><br></div><div>Kegiatan tersebut merupakan salah satu rangkaian dari program pengendalian banjir yang menjadi komitmen bersama dan menjadi amanat segenap warga Kota Samarinda tentang persoalan banjir. Selain itu, juga sebagai normalisasi SKM diantaranya pengerukan sedimentasi kemudian pembebasan dari gangguan bangunan atau utilitas apapun yang ada di sekitar bantaran sungai.<br><br>Sebelumnya pembongkaran rumah atau bangunan milik warga di bantaran SKM sebagai program normalisasi Pemkot Samarinda telah menyasar bantaran SKM di segmen kelurahan Temindung Permai kecamatan Sungai Pinang mulai dari kawasan Jembatan Ruhui Rahayu hingga Jembatan Gelatik.<br><br>&nbsp;———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-07-08 21:30:00', '2024-07-10 12:35:34'),
('555debfb-310d-4ef2-993f-41584d2afc58', 'Pelatihan dan Sertifikasi SKK Jenjang 6 Jabatan Supervisor K3 Konstruksi Utama', 'pelatihan-dan-sertifikasi-skk-jenjang-6-susunan_organisasi-supervisor-k3-konstruksi-utama', 5, 'Berita/2024-05/07/P1IOHJvzvv6A3Vy9cu84NHXrzAP2RhYFFUQi1Cww.png', NULL, '<div><strong>Samarinda</strong> - Pada Hari Selasa (05/03/2024)&nbsp; Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda melalui Bidang Bina Konstruksi melaksanakan kegiatan Pelatihan dan Sertifikasi Tenaga Kerja Konstruksi Kualifikasi Jabatan Operator, Teknisi atau Analis. Untuk Jabatan Kerja Pengawas Pekerjaan Struktur Bangunan Gedung Jenjang 6 &amp; Supervisor K3 Konstruksi Jenjang 6.<br><br>Kegiatan ini dilaksanakan dalam rangka menjalankan tugas dan wewenang yang diatur dalam Undang-Undang Nomor 2 Tahun 2017 tentang Jasa Konstruksi, Dimana pemerintah kabupaten/kota memiliki kewenangan untuk pelaksanaan pelatihan tenaga kerja konstruksi tingkat terampil. Selain itu didalam Undang-Undang tersebut mewajib seluruh pekerja konstruksi untuk memiliki sertifikat kompetensi.<br><br>Oleh karena itu, selain memberikan pelatihan kepada peserta, juga dilakukan uji kompetensi untuk mendapatkan Sertifikat Kompetensi Kerja (SKK) yang menjadi syarat bagi pekerja konstruksi untuk terlibat di kegiatan konstruksi di Kota Samarinda. Kegiatan ini dilaksanakan di Five Hotel Premiere Samarinda tanggal 05 – 07 Maret 2024, dengan jumlah peserta sebanyak 60 orang.<br><br>Dengan adanya kegiatan ini diharapkan mampu meningkat kemampuan kompetensi tenaga kerja konstruksi khususnya di Kota Samarinda.</div>', '-', 0, '2024-03-04 08:00:00', '2024-05-06 09:48:00'),
('5668090c-9bf7-4eaa-bcb3-a43805ca2db7', 'Pelatihan dan Sertifikasi SKK Jenjang 6 Jabatan Kerja Manajer Lapangan Pelaksanaan Pekerjaan Gedung dan Supervisor K3 Konstruksi Utama Jenjang 4', 'pelatihan-dan-sertifikasi-skk-jenjang-6-susunan_organisasi-kerja-manajer-lapangan-pelaksanaan-pekerjaan-gedung-dan-supervisor-k3-konstruksi-utama-jenjang-4', 5, 'Berita/2024-08/07/GMMM8T3khpHk7BPSdvJvWGsNyFtdsnhdsT50bTMz.png', NULL, '<div><strong>SAMARINDA</strong> - Pada Tanggal 6 Agustus 2024,&nbsp; Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda melalui Bidang Bina Konstruksi bersama Lembaga Sertifikasi Profesi Ataki Konstruksi Indonesia (<a href=\"https://www.instagram.com/lsp_ataki/\">@lsp_ataki</a>) dan Lembaga Sertifikasi Profesi Sakti (<a href=\"https://www.instagram.com/lsp_sakti/\">@lsp_sakti</a>) melaksanakan Kegiatan Pelatihan dan Sertifikasi SKK Jabatan Kerja Manajer Lapangan Pelaksanaan Pekerjaan Gedung Jenjang 6 dan Supervisor K3 Konstruksi Utama Jenjang 4.<br><br>Kegiatan ini dilaksanakan dalam rangka menjalankan tugas dan wewenang yang diatur dalam Undang-Undang Nomor 2 Tahun 2017 tentang Jasa Konstruksi, Dimana pemerintah kabupaten/kota memiliki kewenangan untuk pelaksanaan pelatihan tenaga kerja konstruksi tingkat terampil. Selain itu didalam Undang-Undang tersebut mewajib seluruh pekerja konstruksi untuk memiliki sertifikat kompetensi.<br><br>Oleh karena itu, selain memberikan pelatihan kepada peserta, juga dilakukan uji kompetensi untuk mendapatkan Sertifikat Kompetensi Kerja (SKK) yang menjadi syarat bagi pekerja konstruksi untuk terlibat di kegiatan konstruksi di Kota Samarinda. Kegiatan ini dilaksanakan di Five Hotel Premiere Samarinda tanggal 06 – 08 Agustus 2024.<br><br>Dengan adanya kegiatan ini diharapkan mampu meningkat kemampuan kompetensi tenaga kerja konstruksi khususnya di Kota Samarinda.<br> <br> ———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-08-06 02:26:00', '2024-08-06 16:07:02'),
('5a23c2e5-45d5-45ee-b849-f3793a111e42', 'Rapat Forum Konsultasi Publik Penyusunan Standar Pelayanan Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda', 'rapat-forum-konsultasi-publik-penyusunan-standar-pelayanan-dinas-pekerjaan-umum-dan-penataan-ruang-kota-samarinda', 1, 'Berita/2024-05/07/ZTibttjRupY30tQpGvWUJ5pfhendmckN7Sgr4E6a.png', NULL, '<div><strong>Samarinda</strong> - Pada Hari Kamis (14/03/2024) Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda bersama Bagian Organisasi Sekretariat Daerah Kota Samarinda melakukan Rapat Forum Konsultasi Publik (FKP) Penyusunan Standar Pelayanan (SP) Dinas PUPR Kota Samarinda<br><br>Rapat tersebut membahas mengenai penyusunan rancangan standar pelayanan dan pembahasan rancangan standar pelayanan yang dipimpin oleh Ibu Neneng Chamelia Shanti, ST., M.Si. selaku Sekretaris Dinas PUPR Kota Samarinda. Dan narasumber oleh Bapak Irawan, SH selaku Analis Kebijakan Pelayanan Publik Bagian Organisasi Kota Samarinda.<br>&nbsp;</div>', '-', 0, '2024-03-13 18:06:25', '2024-05-06 10:04:49'),
('5ab71e60-24ae-11ec-8b21-97e316a13970', 'Sosialisasi dan Audiensi Program Jaminan Ketenagakerjaan Sektor Jasa Konstruksi', 'sosialisasi-dan-audiensi-program-jaminan-ketenagakerjaan-sektor-jasa-konstruksi', 5, 'Berita/2021-10/04/sosialisasi-dan-audiensi-program-jaminan-ketenagakerjaan-sektor-jasa-konstruksi.jpeg', 'Arsip Dinas PUPR', '<p>Pada Hari Selasa 28, September lalu BPJS ketenagakerjaan melakukan sosialisasi kepada dinas pekerjaan umum dan penataan ruang bertempat di ruang rapat utama kantor dinas pekerjaan umum dan penataan ruang, Sosialisasi tersebut diperuntukan kepada seluruh OPD yang berada di Samarinda untuk bisa berperan aktif dalam mendukung peningkatan kepesertaan BPJS ketenagakerjaan khususnya yang terlibat dalam bidang jasa Konstruksi.</p>\r\n<p>Dalam Rangka Penyelenggaraan jaminan sosial ketenagakerjaan bagi pekerja harian lepas, Borongan dan perjanjian kerja waktu tertentu, BPJS ketenagakerjaan menerangkan manfaat manfaat untuk menjadi peserta dalam penyelenggaraan jaminan sosial tersebut, seperti santunan cacat, atau santunan Meninggal. diharapkan dengan adanya sosialisasi ini Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda dapat ikut mendorong para stake holder stake holder pekerja konstruksi untuk bisa ikut serta didalam melaksanakan program penyelenggaraan jaminan sosial ketenagakerjaan.</p>\r\n<p>&nbsp;</p>', 'Sosialisasi BPJS Ketenagakerjaan Samarinda di Dinas Pekerjaan Umum Dan Penataan Ruang Kota Samarinda', 2154, '2021-09-28 08:00:00', '2023-12-08 16:57:55'),
('5b2b1594-0003-4afe-8299-eddd04e64bb6', 'Tinjauan Lapangan Berkaitan Dengan LKPJ Kepala Daerah T.A. 2023', 'tinjauan-lapangan-berkaitan-dengan-lkpj-kepala-daerah-ta-2023', 1, 'Berita/2024-05/03/5b2b1594-0003-4afe-8299-eddd04e64bb6/atskF4BOWpu4B08FznpG02gLlesaSJ6cRgNGg0Dj.png', NULL, '<div><strong>Samarinda</strong> - Pada Hari Kamis (25/4/2024) Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda bersama Panitia Khusus (Pansus) Dewan Perwakilan Rakyat Daerah (DPRD) Kota Samarinda melakukan Tinjauan Lapangan Berkaitan Dengan Laporan Keterangan Pertanggungjawaban (LKPJ) Wali Kota Samarinda Tahun Anggaran (TA) Tahun 2023<br><br>Kunjungan ini dilakukan untuk memastikan bahwa proyek-proyek tersebut berjalan sesuai dengan rencana yang telah ditetapkan, seperti Pembangunan Teras Samarinda, Pembangunan Terowongan/Tunnel Jl. Sultan Alimuddin - Kakap, dan Rehabilitasi Gor Segiri<br><br>Anggota Komisi II DPRD Samarinda Abdul Rohim mengatakan menyatakan bahwa pembangunan terowongan secara umum sesuai dengan rencana. Namun, ia menyoroti bahwa hasil yang dilihat di lapangan belum memenuhi ekspektasi sepenuhnya. “Pekerjaan ini dilakukan dari dua sisi, namun yang telah selesai hanyalah penembusan awal, bukan operasional penuh,” jelas Rohim. Pansus berencana untuk melakukan verifikasi lebih lanjut dengan Pemerintah Kota dan Dinas PUPR Samarinda untuk memahami rencana besar selanjutnya.<br><br></div><div>———————————————<br><br>Dinas PUPR Kota Samarinda dapat diakses melalui:</div><ul><li>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a></li><li>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda/\">https://www.instagram.com/dpuprkotasamarinda</a></li><li>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a></li><li>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a></li><li>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;</li></ul><div>———————————————&nbsp;</div>', '-', 0, '2024-04-24 18:00:00', '2024-05-02 14:47:26'),
('5c1096aa-3da1-4a5e-8e65-c93dc1c19d6a', 'Informasi Bendungan Benaga', 'informasi-bendungan-benaga', 2, 'Berita/2024-09/24/FYqYxZSDY9wXPgZK7pWD8xeCxSxeSy7wIwo5IVoz.jpg', NULL, '<div><strong>PENGUMUMAN</strong> - Pada Hari Selasa, 24 September 2024, Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda diwakili Bidang Sumber Daya Air (<a href=\"https://www.instagram.com/perumdamsamarinda/\">@</a><a href=\"https://www.instagram.com/sdapuprsmd/?__pwa=1#\">sdapuprsmd</a>) untuk menginformasikan mengenai Bendungan Benaga dalam menyediakan air irigasi untuk pertanian di sekitarnya dan salah satu infrastruktur utama untuk mengendalikan banjir di Kota Samarinda.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-09-23 18:31:00', '2024-09-23 10:56:46'),
('5ebf3bd0-2cf8-47b6-b118-46d097059b78', 'Koordinasi dan Survey Lokasi Permohonan Perbaikan Jalan Rusak di Kecamatan Palaran', 'koordinasi-dan-survey-lokasi-permohonan-perbaikan-jalan-rusak-di-kecamatan-palaran', 3, 'Berita/2024-07/03/bpQol8ikav7NaYefSTWVsI1gHqosS9mdrWq5yzmS.png', NULL, '<div><strong>Samarinda</strong> - Pada Tanggal 2 Juli 2024,&nbsp; Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili Bidang Bina Marga dan Bagian Unit Pelaksana Teknis Dinas (UPTD) Pemeliharaan Jalan dan Jembatan melakukan Koordinasi dan Survei Lokasi ke beberapa titik jalan rusak yang berada di Kecamatan Palaran (<a href=\"https://www.instagram.com/kecamatanpalaran/\">@kecamatanpalaran</a>, <a href=\"https://www.instagram.com/kecamatan_palaran/\">@kecamatan_palaran</a>), Kelurahan Bukuan (<a href=\"https://www.instagram.com/kelurahan_bukuan/\">@kelurahan_bukuan</a>), dan Kelurahan Handil Bakti (<a href=\"https://www.instagram.com/kelurahanhandilbakti/\">@kelurahanhandilbakti</a>). <br><br> Kegiatan tersebut merupakan sebagai bentuk respon atas aduan masyarakat palaran yang diwakilkan oleh <a href=\"https://www.instagram.com/infopalaran/\">@infopalaran</a> dan <a href=\"https://www.instagram.com/forkompemeran/\">@forkompemeran</a> terkait permohonan perbaikan jalan rusak yang terdiri dari:<br><br>1. Jalan Penghijauan RT. 14, Kelurahan Bakuan, Kecamatan Palaran;<br>2. Jalan Pangeran Diponegoro RT. 09, Kelurahan Bakuan, Kecamatan Palaran;<br>3. Jalan Gunung Sari RT. 36, Kelurahan Bukuan, Kecamatan Palaran;<br>4. Gang Impres 3, Kelurahan Bukuan, Kecamatan Palaran; dan<br>5. Jalan Jember Baru RT 07, Kelurahan Handil Bakti, Kecamatan Palaran.<br><br> ———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-07-01 16:30:00', '2024-07-02 10:48:28'),
('61e76d13-6bce-4740-aad3-91b534bcecfe', 'Pembangunan Jalur Pipa PDAM Tirta Kencana - Bhayangkara - Pahlawan', 'pembangunan-jalur-pipa-pdam-tirta-kencana-bhayangkara-pahlawan', 4, 'Berita/2024-09/03/xeJ6RGn9Qmd84RZ4dVG9ciIowCVxFK7ABiBqtSeq.png', NULL, '<div><strong>PENGUMUMAN</strong> - Pada Tanggal 27 Agustus 2024, Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda diwakili Bidang Cipta Karya bersama Perusahaan Daerah Air Minum Tirta Kencana Samarinda (<a href=\"https://www.instagram.com/perumdamsamarinda/\">@perumdamsamarinda</a>) menghimbau bahwa adanya pekerjaan pemasangan pipa dengan kode JDU mulai tanggal 27 Agustus 2024 - Desember 2024.<br><br>Sehubung dengan adanya pekerjaan kegiatan peningkatan infrastruktur air bersih Kota Samarinda dari Perumdam Tirta Kencana - Jalan Milono - Jalan Bhayangkara - Jalan Pahlawan Reservoir Segiri yang akan terjadi penyempitan jalan tersebut.<br><br>Disarankan bagi pengendara mencari jalur alternatif lain untuk keselamatan dan menghindari kemacetan lalu lintas. Mohon maaf kepada pengendara kendaraan atas ketidaknyamanan yang mungkin terjadi selama proses tersebut. Kami berharap Anda dapat memahami dan bersabar selama pekerjaan ini berlangsung. Terima kasih atas kerjasamanya! 🙏<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-08-26 16:45:00', '2024-09-02 10:09:43'),
('6522e2d3-0915-4099-bc74-31b38db98750', 'Telah Hadir Aplikasi SIMBG Versi 3.2', 'telah-hadir-aplikasi-simbg-versi-32', 4, 'Berita/2024-12/05/vuDU5sZubH7fJWB76PT9pmiFx9cP3XiLwpH6VWZI.jpg', NULL, '<div><strong>PENGUMUMAN</strong> - Pada Hari Kamis, 5 Desember 2024. Kementerian Pekerjaan Umum dan Perumahan Rakyat melakukan evaluasi aplikasi sejak SIMBG&nbsp; diluncurkan pada Juli 2021 hingga saat ini, berlandaskan hal tersebut Kementerian PUPR mengembangkan SIMBG versi 3.2. Untuk menciptakan pengalaman penggunaan aplikasi yang lebih baik guna mendorong percepatan dan <br>kemudahan implementasi penyelenggaraan bangunan gedung.<br><br>Layanan yang disediakan pada SIMBG meliputi penerbitan Persetujuan Bangunan Gedung (PBG), penerbitan Sertifikat Laik Fungsi (SLF), penerbitan Surat Bukti Kepemilikan Bangunan Gedung (SBKBG), Rencana Teknis Pembongkaran (RTB), dan pendataan bangunan gedung. Pengembangan SIMBG diharapkan dapat membantu Pemerintah Daerah, Pengusaha dan Penyedia Jasa Konstruksi dalam implementasi penyelenggaraan bangunan gedung sebagaimana termuat di dalam Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah.<br><br>Bagi Masyarakat yang ingin mengakses layanan ini silahkan memasuki website <a href=\"https://simbg.pu.go.id/\">SIMBG.PU.GO.ID</a> dan untuk panduannya silahkan mengkases pada Youtube berikut ini: <a href=\"https://www.youtube.com/watch?v=-RltpZ4jM6k\">Sosialisasi Pemutakhiran Sistem Informasi Manajemen Bangunan Gedung (SIMBG)</a><br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-12-04 18:00:00', '2024-12-04 10:22:43'),
('6ccefd3e-9ae0-4866-b308-fca918409d50', 'Kunjungan Lapangan Konstruksi Bangunan 4 Prodi Arsitektur Universitas Mulawarman', 'kunjungan-lapangan-konstruksi-bangunan-4-prodi-arsitektur-universitas-mulawarman', 4, 'Berita/2024-09/03/w8WSJRskViNk4MbtelBhdaAklu2YkPQFq205vBa8.png', NULL, '<div><strong>Samarinda</strong> - Pada Tanggal 2 September 2024, Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda diwakilkan Bidang Cipta Karya (<a href=\"https://www.instagram.com/sekretariatpbg_samarinda/\">@sekretariatpbg_samarinda</a>) mendampingi Dosen dan Mahasiswa Prodi Arsitektur Universitas Mulawarman (<a href=\"https://www.instagram.com/sekretariatpbg_samarinda/\">@unmul</a>, <a href=\"https://www.instagram.com/sekretariatpbg_samarinda/\">@archiunmul</a>) melakukan Kunjungan Lapangan (Kulap) Konstruksi Bangunan 4 pada Kawasan Citra Niaga, Kota Samarinda.<br><br>Kegiatan ini merupakan bagian dari pembelajaran praktis yang memperkaya pemahaman mereka tentang teknologi bangunan, penerapan sains dalam konstruksi, serta manajemen proyek. Para Mahasiswa dan Dosen Pembimbing berkesempatan melihat secara langsung proses pembangunan, mempelajari kajian struktur dan konstruksi bangunan, serta berinteraksi dan didampingi dengan 3 Konsultan Pengawas di lapangan.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;<br><br></div>', '-', 0, '2024-09-01 17:00:00', '2024-09-02 09:10:48'),
('73503cfd-3845-4b96-9178-06d90d3368c2', 'Informasi Bagi Pengguna Layanan SIMBG', 'informasi-bagi-pengguna-layanan-simbg', 4, 'Berita/2024-12/09/T6r888Jq3p7bnvd3ZebKNoOeql9eRxmlkfmivhdV.jpg', NULL, '<div><strong>PENGUMUMAN</strong> - Pada Hari Sabtu, 7 Desember 2024. Informasi lebih lanjut bagi pengguna layanan SIMBG versi 3.2 dapat menghubungi&nbsp; <a href=\"https://www.instagram.com/sekretariatpbg_samarinda/\">@sekretariatpbg_samarinda</a>&nbsp;di lantai III Mall Pelayanan Publik Kota Samarinda. Bagi Masyarakat yang ingin mengakses layanan ini silahkan memasuki website <a href=\"https://simbg.pu.go.id/\">SIMBG.PU.GO.ID</a> dan untuk panduannya silahkan mengkases pada Youtube berikut ini: <a href=\"https://www.youtube.com/watch?v=-RltpZ4jM6k\">Sosialisasi Pemutakhiran Sistem Informasi Manajemen Bangunan Gedung (SIMBG)</a>.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-12-06 18:54:00', '2024-12-08 08:30:45'),
('7442e733-beb6-4ba4-b9c3-62fff9377ab1', 'Pelatihan dan Sertifikasi SKK Jabatan Pengawas Pekerjaan Struktur Bangunan Gedung Utama Jenjang 6 dan Supervisor K3 Konstruksi Jenjang 5', 'pelatihan-dan-sertifikasi-skk-susunan_organisasi-pengawas-pekerjaan-struktur-bangunan-gedung-utama-jenjang-6-dan-supervisor-k3-konstruksi-jenjang-5', 5, 'Berita/2024-09/25/wBFz9AusQlLPmJLduoUmna9fkznB3lZwWgXWZ4ws.png', NULL, '<div><strong>SAMARINDA</strong> - Pada hari Selasa, 24 September 2024, Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda melalui Bidang Bina Konstruksi bersama Lembaga Sertifikasi Profesi P3SM (<a href=\"https://www.instagram.com/p3smandiri/\">@p3smandiri</a>, <a href=\"https://www.instagram.com/p3smkaltim/\">@p3smkaltim</a>) dan Lembaga Sertifikasi Profesi K3 Konstruksi (<a href=\"https://www.instagram.com/lspk3konstruksi_official/\">@lspk3konstruksi_official</a>) melaksanakan Kegiatan Pelatihan dan Sertifikasi SKK Jabatan Pengawas Pekerjaan Struktur Bangunan Gedung Utama Jenjang 6 dan Supervisor K3 Konstruksi Jenjang 5.<br><br>Kegiatan ini dibuka oleh Sekretaris Dinas PUPR Kota Samarinda, Ibu Neneng Chamelia Shanti, S.T., M.Si. yang dilaksanakan dalam rangka menjalankan tugas dan wewenang yang diatur dalam Undang-Undang Nomor 2 Tahun 2017 tentang Jasa Konstruksi, Dimana pemerintah kabupaten/kota memiliki kewenangan untuk pelaksanaan pelatihan tenaga kerja konstruksi tingkat terampil. Selain itu didalam Undang-Undang tersebut mewajib seluruh pekerja konstruksi untuk memiliki sertifikat kompetensi.<br><br>Oleh karena itu, selain memberikan pelatihan kepada peserta, juga dilakukan uji kompetensi untuk mendapatkan Sertifikat Kompetensi Kerja (SKK) yang menjadi syarat bagi pekerja konstruksi untuk terlibat di kegiatan konstruksi di Kota Samarinda. Kegiatan ini dilaksanakan di Five Hotel Premiere Samarinda (Ex. Selyca Hotel) tanggal 24 – 26 September 2024, dengan jumlah peserta sebanyak 83 orang.<br><br>Dengan adanya kegiatan ini diharapkan mampu meningkat kemampuan kompetensi tenaga kerja konstruksi khususnya di Kota Samarinda.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-09-24 00:38:00', '2024-09-24 09:52:24'),
('90de3f38-00de-4d56-80ed-a8cc8e0dfc34', 'Penutupan Akses Jalan KH. Abul Hasan Satu Arah Kegiatan Peningkatan Drainase', 'penutupan-akses-jalan-kh-abul-hasan-satu-arah-kegiatan-peningkatan-drainase', 2, 'Berita/2024-08/06/gNqGlhbLFbFAwYPWbuxJHaPytR04TpDK0mYCyCNs.png', NULL, '<div><strong>PENGUMUMAN - </strong>&nbsp;Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda menghimbau bahwa adanya Penutupan Akses Jalan KH. Abul Hasan Satu Arah mulai tanggal 9 Agustus 2024 - 31 Desember 2024.<br><br>Sehubung dengan adanya pekerjaan kegiatan peningkatan drainase di Jalan KH. Abul Hasan, akan diberlakukan arus satu arah dari simpang RS. H. Darjad menuju ke simpang Jalan Pangeran Diponegoro.<br><br>&nbsp;———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-08-05 18:36:00', '2024-08-05 11:17:32'),
('92217eb0-e1f5-477f-b82a-f00c21372c3c', 'Informasi Pelaporan dan Pengaduan Perumda Tirta Kencana Samarinda', 'informasi-pelaporan-dan-pengaduan-perumda-tirta-kencana-samarinda', 1, 'Berita/2024-09/02/DqhA9J8aeU8RYW56EEOiqC6I9cQm6cWwqbuck4Ug.jpg', NULL, '<div><strong>PENGUMUMAN</strong> - Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda membantu menyampaikan informasi dari Perusahaan Daerah Air Minum (Perumdam) Tirta Kencana Samarinda (<a href=\"https://www.instagram.com/perumdamsamarinda/\">@perumdamsamarinda</a>). Semoga bermanfaat💧💙<br><br> ———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-08-31 03:30:00', '2024-09-01 08:45:45'),
('94aa29c8-479d-45ed-bc54-ab28428df25a', 'Kegiatan Gotong Royong dan Pengabdian Masyarakat bersama Mahasiswa Fakultas Teknik Universitas 17 Agustus 1945 Samarinda', 'kegiatan-gotong-royong-dan-pengabdian-masyarakat-bersama-mahasiswa-fakultas-teknik-universitas-17-agustus-1945-samarinda', 10, 'Berita/2024-10/06/r70jlQoyoNvNDhsdtQNOzeiYFLkDXkwFnsKkRCsC.png', NULL, '<div>SAMARINDA - Pada Hari Sabtu, 5 Oktober 2024, Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda Bagian Unit Pelaksana Teknis Dinas (UPTD) Pemeliharaan Saluran Drainase dan Irigasi (<a href=\"https://www.instagram.com/uptd_drainase_samarinda/\">@uptd_drainase_samarinda</a>) melakukan Kegiatan Gotong Royong dan Pengabdian Masyarakat bersama Mahasiswa Fakultas Teknik Universitas 17 Agustus 1945 Samarinda (<a href=\"https://www.instagram.com/untag_samarinda/\">@untag_samarinda</a>, <a href=\"https://www.instagram.com/semabpm_ftuntag45smr/\">@semabpm_ftuntag45smr</a>) di Jalan Karang Mulya 2, Kel Lok Bahu Kec Sungai Kunjang.<br><br>Kegiatan ini merupakan bentuk sinergitas antara pemerintah kota samarinda dan mahasiswa fakultas teknik universitas 17 Agustus 1945 Samarinda serta melibatkan masyarakat setempat, dalam meningkatkan kepedulian terhadap lingkungan sekitar dan kegiatan ini merupakan langkah awal dalam membentuk karakter yang lebih peduli terhadap kebersihan lingkungan dan menjaga lingkungan sekitar sehingga meningkatkan kepedulian terhadap jiwa sosial dalam bermasyarakat.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-10-04 16:00:00', '2024-10-06 07:41:19'),
('99a8b3c7-862d-4732-8c0b-81e259f67258', 'Rapat Koordinasi Implementasi BOSP/BOSDA dan Kelayakan Sarana Prasarana Satuan Pendidikan Tahun 2024 - 2025', 'rapat-koordinasi-implementasi-bospbosda-dan-kelayakan-sarana-prasarana-satuan-pendidikan-tahun-2024-2025', 4, 'Berita/2024-11/04/MpoNlan30Ss3QiViYsFWIXTLulRHF1VFEM5jickZ.png', NULL, '<div><strong>BALIKPAPAN</strong> - Pada Hari Rabu, 30 Oktober 2024. Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili Bidang Cipta Karya melakukan Rapat Koordinasi Implementasi BOSP/BOSDA dan Kelayakan Sarana Prasarana Satuan Pendidikan Tahun 2024/2025.<br><br>Rapat tersebut bertempat di Ruang Meeting Hotel Blue Sky yang dihadiri oleh beberapa Organisasi Perangkat Daerah (OPD) Kota Samarinda dan Tim Pembinaan dari PAUD sampai SMP.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;<br><br></div>', '-', 0, '2024-10-29 16:32:00', '2024-11-03 08:32:36'),
('9e7ee5b6-881c-4e11-8a4d-c1ef2e9620b0', 'Pelatihan dan Sertifikasi SKK Jenjang 5 Jabatan Kerja Supervisor K3 Konstruksi Bina Konstruksi', 'pelatihan-dan-sertifikasi-skk-jenjang-5-susunan_organisasi-kerja-supervisor-k3-konstruksi-bina-konstruksi', 5, 'Berita/2024-10/29/pJmtdfc8E0e2esOGorHEwHxH81f6zknzLl01tjsZ.jpg', NULL, '<div><strong>PENGUMUMAN</strong> - Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda diwakilkan Bidang Bina Konstruksi bersama Tempat Uji Kompetensi (TUK) Berlian Mulawarman (<a href=\"https://www.instagram.com/tuk_berlianmulawarman/\">@tuk_berlianmulawarman</a>) mengadakan Pelatihan dan Sertifikasi SKK Jenjang 5 Jabatan Kerja Supervisor K3 Konstruksi<br><br>Link Pendaftaran (Sampai 30 Oktober 2024):<br><a href=\"https://bit.ly/SKK_K3K_J5_XI_2024\">https://bit.ly/SKK_K3K_J5_XI_2024</a><br>Contact Person:<br><a href=\"https://wa.me/6281258414483\">wa.me/6281258414483</a> (Dinar)<br><a href=\"https://wa.me/6285346165565\">wa.me/6285346165565</a><br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-10-28 16:30:00', '2024-10-28 09:34:58'),
('9fc6d4ee-9671-41eb-a4e9-33c37f6a62a0', 'Pelatihan dan Sertifikasi SKK Jenjang 5 Jabatan Kerja Supervisor K3 Konstruksi', 'pelatihan-dan-sertifikasi-skk-jenjang-5-susunan_organisasi-kerja-supervisor-k3-konstruksi', 5, 'Berita/2024-09/03/oZC2WGYpZl24mMsDm5f3mbG8axA7pUz2c5bX1ChI.jpg', NULL, '<div><strong>PENGUMUMAN</strong> -&nbsp; Hari Selasa, 3 September 2024. Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda diwakilkan Bidang Bina Konstruksi mengadakan Pelatihan dan Sertifikasi SKK Jenjang 5 Jabatan Kerja Supervisor K3 Konstruksi pada Tanggal 24 September - 26 September 2024.<br><br>Link Pendaftaran:<br><a href=\"https://bit.ly/SKK_J6_PLKGEDUNG_2024\">https://bit.ly/SKK_J5_K3_2024 </a><br>Contact Person:<br><a href=\"https://wa.me/6281258414483\">wa.me/6281258414483</a> (Dinar)</div><div><a href=\"https://wa.me/6281258414483\">wa.me/6285346165565</a>&nbsp;</div><div><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-09-02 22:12:00', '2024-09-02 15:56:03'),
('a2e36a20-5c70-4fa9-b0c6-63ff004f617a', 'Penutupan Jembatan Achmad Amins Kecamatan Sambutan', 'penutupan-jembatan-achmad-amins-kecamatan-sambutan', 3, 'Berita/2024-11/28/gOiG3aEl7GZX215FySdxyh0CkuxFdl7G4xzn6fRE.jpg', NULL, '<div><strong>PENGUMUMAN</strong> - Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda menghimbau adanya Penutupan Sementara Jembatan Achmad Amins, Kecamatan Sambutan pada hari kamis, 28 November 2024 pukul 09.00 - 15.00 WITA.<br><br>Mohon maaf kepada pengendara kendaraan atas ketidaknyamanan yang mungkin terjadi selama proses tersebut. Kami berharap Anda dapat memahami dan bersabar selama pekerjaan ini berlangsung. Terima kasih atas kerjasamanya! 🙏<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-11-27 16:30:00', '2024-11-27 09:17:43'),
('a39a99e4-fbb8-4547-a996-0f8719a7aff0', 'Rapat Koordinasi Masalah Banjir di Kelurahan Sungai Siring', 'rapat-koordinasi-masalah-banjir-di-kelurahan-sungai-siring', 1, 'Berita/2024-10/10/b6GdM36KaUnAo2zfEBfn61kdvR2rgPhaSFnpMB42.png', NULL, '<div><strong>SAMARINDA</strong> - Pada Hari Rabu, 9 Oktober 2024, Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili Kepala Dinas, Ibu Desy Damayanti, S.T., M.T. melakukan Rapat Koordinasi terkait Masalah Banjir di Kelurahan Sungai Siring. Rapat tersebut bertempat di Ruang Rapat Dinas PUPR Kota Samarinda yang dihadiri juga oleh Ketua Tim Walikota Untuk Akselerasi Pembangunan (TWAP), Badan Penanggulangan Bencana Daerah, Plt Camat Samarinda Utara dan Lurah Sungai Siring.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-10-08 18:00:00', '2024-10-09 09:07:59');
INSERT INTO `berita` (`uuid_berita`, `judul_berita`, `slug_berita`, `id_berita_kategori`, `foto_berita`, `sumber_foto_berita`, `isi_berita`, `preview_berita`, `views_count`, `created_at`, `updated_at`) VALUES
('a47a7ab5-045c-4da1-8204-f9042d20fd2a', 'Forum Jasa Konstruksi Kalimantan Timur Tahun 2024', 'forum-jasa-konstruksi-kalimantan-timur-tahun-2024', 5, 'Berita/2024-09/26/siq4yWyhJxDR5YXiVFtRGDlNJNz4jfRJQ3A1b94d.png', NULL, '<div><strong>BALIKPAPAN</strong> - Pada Hari Rabu, 25 September 2024, Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili Kepala Bidang Bina Konstruksi, Bapak Herwin Wahyudi, S.T. melakukan Forum Jasa Konstruksi Kalimantan Timur Tahun 2024 yang diselenggarakan oleh Dinas Pekerjaan Umum, Penataan Ruang dan Perumahan Rakyat Provinsi Kalimantan Timur (<a href=\"https://www.instagram.com/dpupr_kaltim/\">@dpupr_kaltim</a>)<br><br>Kegiatan tersebut bertempat di Ballroom Grand Senyiur Hotel Balikpapan dan dibuka laporan oleh Kepala Dinas Pekerjaan Umum Penataan Ruang dan Perumahaan Rakyat Provinsi Kaltim, A.M Fitra Firnanda, S.T., M.M. mengenai \"Forum Jasa digunakan sebagai sarana Komunikasi, Konsultasi dan Informasi antara masyarakat Jasa Konstruksi dan Pemerintah Pusat dan/atau Pemerintah Daerah sebagai fungsi menampung dan menyalurkan aspirasi masyarakat, membahas dan membuat rekomendasi kebijakan pengembangan Jasa Konstruksi\".<br><br>Selanjutnya, sambutan dan penyampaian materi oleh Ir. Abdul Muis, M.T. selaku Direktur Jenderal Bina Konstruksi Kementrian Pekerjaan Umum dan Penataan Ruang (<a href=\"https://www.instagram.com/kemenpupr/\">@kemenpupr</a>, <a href=\"https://www.instagram.com/pupr_binakonstruksi/\">@pupr_binakonstruksi</a>) mengenai \"Maju Bersama Badan Usaha Jasa Konstruksi (BUJK) &amp; Tenaga Kerja Konstruksi (TKK) Lokal Menuju Profesional, Kompeten, dan Berdaya Saing\"<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-09-25 03:33:00', '2024-09-25 09:32:53'),
('a91c5099-a453-4795-9f08-283322851aa8', 'Focus Group Discussion (FGD) Laporan Akhir Rencana Tata Bangunan dan Lingkungan Kota Samarinda Tahun Anggaran 2024', 'focus-group-discussion-fgd-laporan-akhir-rencana-tata-bangunan-dan-lingkungan-kota-samarinda-tahun-anggaran-2024', 4, 'Berita/2024-11/25/yN15VhbPWn6JpAdlhiaXwEUX2gO8VxZXmqLBvqKM.png', NULL, '<div><strong>SAMARINDA</strong> - Pada Hari Senin, 25 November 2024. Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili Bidang Cipta Karya ( <a href=\"https://www.instagram.com/sekretariatpbg_samarinda/\">@sekretariatpbg_samarinda</a> ) melakukan Focus Group Discussion (FGD) Laporan Akhir Penyusunan Dokumen Rencana Tata Bangunan dan Lingkungan (RTBL) Kota Samarinda Tahun Anggaran 2024.<br><br>Acara tersebut bertempat di Ruang Rapat Utama Dinas PUPR Kota Samarinda dan dihadiri juga oleh Camat Samarinda Kota, beberapa Lurah Samarinda Kota, beberapa Organisasi Perangkat Daerah (OPD) Kota Samarinda, Tim Teknis Bangunan Gedung, dan Tim Penyusun.<br><br>Acara ini bertujuan untuk mendapatkan masukan dan saran konstruktif terkait dengan dokumen rencana yang telah disusun oleh tim perencana, yang berfokus pada pengelolaan pembangunan yang ramah lingkungan dan berkelanjutan. Dalam laporannya, tim perencana memaparkan berbagai isu penting yang menjadi perhatian, seperti pengelolaan ruang terbuka hijau, perlindungan kawasan sensitif terhadap kerusakan lingkungan, serta strategi untuk menghadapi dampak perubahan iklim.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-11-24 17:00:00', '2024-11-24 13:39:45'),
('b0cc5a00-d899-4612-bd05-3c57ad6b0101', 'Rapat Koordinasi Lintas Sektor Rencana Detail Tata Ruang (RDTR) Daerah Mitra IKN Kota Samarinda', 'rapat-koordinasi-lintas-sektor-rencana-detail-tata-ruang-rdtr-daerah-mitra-ikn-kota-samarinda', 6, 'Berita/2024-12/09/g55a0tkkBWqwgG1fNvK7WqSHLVG4Jc2P9yt9XBEA.png', NULL, '<div><strong>JAKARTA</strong> - Wakil Wali Kota Samarinda Dr. H. Rusmadi menghadiri Rapat Koordinasi Lintas Sektor dalam rangka pembahasan Rancangan Peraturan Kepala Daerah (Ranperkada) tentang Rencana Detail Tata Ruang (RDTR) Wilayah Perencanaan Kecamatan Sungai Kunjang dan Rancangan Peraturan Kepala Daerah (Ranperkada) tentang Rencana Detail Tata Ruang (RDTR) Wilayah Perencanaan Kecamatan Loa Janan Ilir pada Senin (09/12/24) bertempat di Ra Suites Simatupang.<br><br>Acara ini dihadiri oleh Sekretaris Daerah Kota Samarinda Ir. Hero Mardanus Satyawan, MT, Kepala Kantah Kota Samarinda, Kepala DLH, Kabag Hukum, Kepala Dinas PUPR beserta tim teknis.<br><br>Rancangan Peraturan Kepala Daerah (Ranperkada) yang dibahas adalah Ranperkada tentang RDTR Wilayah Perencanaan Kecamatan Sungai Kunjang dan RDTR Wilayah Perencanaan Kecamatan Loa Janan Ilir Kota Samarinda. Ranperkada RDTR WP Kecamatan Sungai Kunjang memiliki luas delineasi 6.757,04 hektare dengan Tujuan Penataan Ruang “Mewujudkan Kawasan Perkotaan Yang Nyaman Sebagai Pusat Perdagangan Jasa Dan Pusat Industri Skala Kota Untuk Mendukung Pengembangan Ibu Kota Nusantara”, sedangkan untuk Ranperkada RDTR WP Kecamatan Loa Janan Ilir memiliki luas delineasi 3.186,89 hektare dengan Tujuan Penataan Ruang “Mewujudkan Kawasan Perkotaan Yang Nyaman Sebagai Pusat Perdagangan Jasa Dan Pusat Pelayanan Publik Skala Regional Untuk Mendukung Pengembangan Ibu Kota Nusantara”.<br><br>Harapan pemerintah daerah adalah RDTR Wilayah Perencanaan (WP) Kecamatan Sungai Kunjang dan RDTR Wilayah Perencanaan (WP) Kecamatan Kecamatan Loa Janan Ilir dapat segera ditetapkan sebagai Perwali dan terintegrasi dengan sistem Online Single Submission (OSS) untuk percepatan iklim investasi di Kecamatan Sungai Kunjang dan Kecamatan Loa Janan Ilir melalui Konfirmasi Kesesuaian Kegiatan Pemanfaatan&nbsp;Ruang&nbsp;(KKPR).<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-12-08 16:30:00', '2024-12-09 06:23:56'),
('bda6e659-9fb3-44c4-aa95-e2254415df75', 'Groundbreaking Pelabuhan Multipurpose Kota Samarinda di Kelurahan Bukuan, Kecamatan Palaran', 'groundbreaking-pelabuhan-multipurpose-kota-samarinda-di-kelurahan-bukuan-kecamatan-palaran', 1, 'Berita/2024-09/10/da58MFznN0yJE0aXHDyBRiZvgxflsNfnf7Vb6QoX.png', NULL, '<div>Samarinda - Pada Hari Selasa, 9 September 2024 - Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili Sekretaris Dinas, Ibu Neneng Chamelia Shanti, S.T., M.Si. dan Kepala Bidang Bina Marga, Bapak Budy Susanto, S.T. menghadiri kegiatan Groundbreaking Pelabuhan Multipurpose Kerjasama Pemerintah Kota (Pemkot) Samarinda (<a href=\"https://www.instagram.com/pemkot.samarinda/\">@pemkot.samarinda</a>, <a href=\"https://www.instagram.com/prokompimkotasamarinda/\">@prokompimkotasamarinda</a>) dengan PT. RAE Energi Investama dan PT. Pelabuhan Samudera Indonesia (<a href=\"https://www.instagram.com/samudera.id/\">@samudera.id</a>, <a href=\"https://www.instagram.com/samudera_psp/\">@samudera_psp</a>) pada Pelabuhan Multipurpose, Kelurahan Bukuan, Kecamatan Palaran.<br><br>Walikota Samarinda, Bapak Dr. H. Andi Harun, S.T., S.H., M.Si. membuka kegiatan tersebut dalam sambutannya menyampaikan rasa optimisme terhadap proyek ini. “Yang pasti menggembirakan, hari ini kita sudah groundbreaking. Artinya, keseriusan investor dan mitranya telah menjadi kesepahaman untuk melanjutkan pembangunan ini,”<br><br>Pelabuhan Multipurpose ini diharapkan menjadi pusat kegiatan ekonomi yang vital, mendukung distribusi logistik, serta meningkatkan konektivitas daerah. Dan konstruksinya diproyeksikan akan dimulai tahun depan, dirancang untuk meningkatkan efisiensi distribusi barang dan jasa, baik untuk pasar dalam negeri maupun luar negeri.<br><br>Pemerintah Kota Samarinda sebelumnya telah menandatangani nota kesepahaman dengan PT RAE Energi Investama, sebagai langkah awal untuk mendorong optimalisasi penyelenggaraan pemerintahan dan pembangunan infrastruktur.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-09-08 17:00:00', '2024-09-09 10:10:42'),
('be632541-4f4c-4648-9289-faa0a8d6ea11', 'Focus Group Discussion Implementasi Bangunan Hijau dan Bangunan Cerdas di Kota Samarinda', 'focus-group-discussion-implementasi-bangunan-hijau-dan-bangunan-cerdas-di-kota-samarinda', 4, 'Berita/2024-11/04/jq6YsUXU5kI6JescAwGLrczVQ4UZqImnbXbeaRB3.png', NULL, '<div><strong>SAMARINDA</strong> - Pada Hari Kamis, 31 Oktober 2024. inas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili Bidang Cipta Karya ( <a href=\"https://www.instagram.com/sekretariatpbg_samarinda/\">@sekretariatpbg_samarinda</a> ) dan Bidang Penataan Ruang ( <a href=\"https://www.instagram.com/tataruangsamarinda/\">@tataruangsamarinda</a> ) melakukan Focus Group Discussion (FGD) Implementasi Bangunan Hijau dan Bangunan Cerdas di Kota Samarinda.<br><br>Acara tersebut bertempat di Ruang Ruang Kartanegara Hotel Bumi Senyiur Samarinda yang dipimpin dan dibuka oleh Sekretaris Daerah Kota Samarinda, Bapak Ir. Hero Mardanus Satyawan, MT. dihadiri juga oleh beberapa Organisasi Perangkat Daerah (OPD) Kota Samarinda.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-10-30 16:30:00', '2024-11-03 08:31:14'),
('bf485b67-42b5-42ca-89a3-bc95a14a4da6', 'Rapat Koordinasi Tentang Teknis Pekerjaan di Lapangan', 'rapat-koordinasi-tentang-teknis-pekerjaan-di-lapangan', 1, 'Berita/2024-10/08/0UYMJ91tB7N3facOgsAUNDOZhiBTygXM16Zwtn7Q.png', NULL, '<div>SAMARINDA - Pada Hari Rabu, 2 Oktober 2024, Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili Sekretaris Dinas dan Kepala Bidang Sumber Daya Air melakukan Rapat Koordinasi Tentang Teknis Pekerjaan di Lapangan bersama bersama Tim Walikota Untuk Akselerasi Pembangunan (TWAP) dan Perusahaan Daerah Air Minum Tirta Kencana Samarinda (<a href=\"https://www.instagram.com/perumdamsamarinda/\">@perumdamsamarinda</a>)<br><br>Rapat tersebut bertempat di Ruang Rapat TWAP, Jl. Dahlia Kota Samarinda. Rapat dilakukan untuk pengerjaan proyek dibawah kendali Bidang Sumber Daya Air Dinas PUPR (<a href=\"https://www.instagram.com/sdapuprsmd/\">@sdapuprsmd</a>) dan Perawatan/Keamanan Pipa PDAM dibawah Kendali Dirtek PDAM Kota Samarinda (<a href=\"https://www.instagram.com/perumdamsamarinda/\">@perumdamsamarinda</a>). Rapat Koordinasi di TWAP, telah membuahkan kesepakatan sebagai berikut:<br><br></div><ol><li>Saling mengintensifkan koordinasi lapangan, agar sama-sama memantau pekerjaan lapangan guna mengurangi resiko kerusakan pipa atau berakibat bocor pada pipa PDAM.</li><li>Sebelum Pengerjaan Proyek Drainase, Para Pihak sepakat untuk turun ke lapangan guna memastikan titik lokasi pipa, guna menghindari penggalian drainase yang dapat berakibat kerusakan pada pipa PDAM.&nbsp;</li><li>Pihak PUPR siap mengakomodir beberapa rekomendasi dari pihak PDAM terkait rekanan pengerjaan pipa oleh pihak PUPR.&nbsp;</li><li>Pihak PDAM siap meningkatkan pelayanan kepada para pelanggan dengan mengoptimalkan dasboard sebagai media informasi cepat dengan meningkatkan pelayanan prima pada para pelanggan.</li></ol><div>Selanjutnya, peninjauan lapangan mengenai pemindahan Tempat Pembuangan Sampah (TPS) dari depan Pasar Kedondong ke Samping Pasar Kedondong. Kegiatan tersebut dihadiri juga oleh Dinas Perdagangan Kota Samarinda (<a href=\"https://www.instagram.com/disdag_samarindakota/\">@disdag_samarindakota</a>) dan UPT Pasar Kedondong.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-10-01 17:00:00', '2024-10-07 08:08:28'),
('cb12554f-3779-4b41-a04a-880e26fcd178', 'Koordinasi Program Pemberantasan Korupsi Terintegrasi Pemerintah Kota Samarinda Tahun 2024', 'koordinasi-program-pemberantasan-korupsi-terintegrasi-pemerintah-kota-samarinda-tahun-2024', 1, 'Berita/2024-10/02/olo5x5ngpah2YPkF5ZcUY4pLnKNAuZkwMdCWudgb.png', NULL, '<div><strong>SAMARINDA</strong> - Pada Hari Selasa, 1 Oktober 2024, Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili oleh Sekretaris Dinas, Kepala Bidang Bina Marga, Kepala Bidang Cipta Karya, Kepala Bidang Sumber Daya Air, dan Tim terkait di setiap bidang melakukan Koordinasi Program Pemberantasan Korupsi Terintegrasi Pemerintah Kota Samarinda Tahun 2024 selama 2 hari (30/09/2024 - 01/10/2024).<br><br>Kegiatan tersebut dilaksanakan oleh Komisi Pemberantasan Korupsi Republik Indonesia ( <a href=\"https://www.instagram.com/official.kpk/\">@official.kpk</a> ) dan dihadiri juga oleh Inspektorat Kota Samarinda ( <a href=\"https://www.instagram.com/inspektoratsamarinda/\">@inspektoratsamarinda</a> ) serta Stakeholder terkait ( <a href=\"https://www.instagram.com/kementerianbumn/\">@kementerianbumn</a>, <a href=\"https://www.instagram.com/ptpp_id/\">@ptpp_id</a>, <a href=\"https://www.instagram.com/ptpp_infrastruktur1/\">@ptpp_infrastruktur1</a>, dan <a href=\"https://www.instagram.com/pp.samarinda/\">@pp.samarinda</a>)<br><br>Koordinasi ini bertujuan untuk melaksanakan rapat koordinasi pendalaman Pengadaan Barang dan Jasa (PBJ) serta evaluasi dan pemantauan/kunjungan 10 Proyek Strategis pada Pemerintah Kota Samarinda tahun 2024, salah satunya adalah Proyek Pembangunan Terowongan/Tunnel Jl. Sultan Alimuddin - Kakap.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-09-30 21:00:00', '2024-10-02 00:44:24'),
('d2a170e4-a60a-48a6-95f1-a92f096506e5', 'Sosialisasi Tata Cara Penyusunan Perkiraan Biaya Kerja Konstruksi Bidang Pekerjaan Umum dan Perumahan Rakyat', 'sosialisasi-tata-cara-penyusunan-perkiraan-biaya-kerja-konstruksi-bidang-pekerjaan-umum-dan-perumahan-rakyat', 5, 'Berita/2024-10/23/CLD0dVVTWv2DeZwFSBnmOBRuTCiNMxAKpuMbvz1S.png', NULL, '<div><strong>SAMARINDA</strong> - Pada Hari Rabu, 23 Oktober 2024. Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda mengadakan Sosialisasi Peraturan Menteri PUPR Nomor 8 Tahun 2023 dan Surat Edaran Dirjen Bina Konstruksi Nomor 68/SE/DK/2024 Tentang Penyusunan Perkiraan Biaya Pekerjaan Konstruksi Bidang Pekerjaan Umum dan Perumahan Rakyat.<br><br>Acara tersebut bertempat di Hotel Aston Samarinda yang dihadiri oleh perwakilan seluruh Bidang dan UPTD Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda, beberapa Organisasi Perangkat Daerah (OPD) Kota Samarinda, dan Stakeholder Jasa Konstruksi di Kota Samarinda. Pembukaan dan sambutan acara oleh Kepala Bidang Sumber Daya Air (<a href=\"https://www.instagram.com/sdapuprsmd/\">@sdapuprsmd</a>) Dinas PUPR Kota Samarinda, Bapak Hendra Kusuma, S.T. Dan laporan ketua panitia, Bapak Herwin Wahyudi, S.T. (<a href=\"https://www.instagram.com/herwinwahyudi/\">@herwinwahyudi</a>) selaku Kepala Bidang Bina Konstruksi Dinas PUPR Kota Samarinda.<br><br>Selanjutnya, penyampaian paparan Badan Penyelenggara Jaminan Sosial (BPJS) Ketenagakerjaan oleh Bapak Novi Adistia dari BPJS Kota Samarinda (<a href=\"https://www.instagram.com/bpjs.ketenagakerjaan/\">@bpjs.ketenagakerjaan</a>) Kemudian, penyampaian materi paparan Peraturan Menteri PUPR Nomor 8 Tahun 2023 dan SE Dirjen Bikon Nomor 68/SE/DK/2024 oleh Ibu Lydia Fitrina, S.T. dan Bapak Pijar Wirastani, S., S.T. dari Direktorat Keberlanjutan Konstruksi (<a href=\"https://www.instagram.com/pupr_binakonstruksi/\">@pupr_binakonstruksi</a>).<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-10-22 16:30:00', '2024-10-22 16:47:32'),
('d41aa506-456d-40c6-91f7-404c2b422ae0', 'Penghargaan Sub Urusan Jasa Konstruksi Kabupaten/Kota Dalam Rangka Hari Bakti Pekerjaan Umum ke 79 Tahun 2024', 'penghargaan-sub-urusan-jasa-konstruksi-kabupatenkota-dalam-rangka-hari-bakti-pekerjaan-umum-ke-79-tahun-2024', 1, 'Berita/2024-12/03/yRV9n1LbyXNWjNXq8rGgnUXIf8daJhqWMpbr05XG.png', NULL, '<div><strong>SAMARINDA</strong> - Pada Hari Selasa, 3 Desember 2024. Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda menghadiri Upacara Memperingati Hari Bakti Pekerjaan Umum ke - 79 yang berlangsung di halaman kantor Dinas PUPR dan PERA Kaltim. Upacara ini dipimpin langsung oleh Pj Gubernur Kalimantan Timur, Bapak Dr. Drs. Akmal Malik, M.Si.<br><br>Acara tersebut turut dihadiri oleh tokoh Forkopimda, Komandan Resor Militer, perwakilan Dinas PUPR dari kabupaten dan kota, Kepala Balai Wilayah Kalimantan, serta para purna tugas Dinas PUPR dan PERA Provinsi Kalimantan Timur. Pada upacara ini, penghargaan juga diberikan kepada para pemenang lomba tingkat Provinsi Kalimantan Timur Sub Urusan Jasa Konstruksi Tahun 2024, yang diselenggarakan oleh Dinas PUPR dan PERA Kaltim.<br><br>Selain itu, turut dilaksanakan serah terima pengadaan alat berat dari Kementerian Pekerjaan Umum Direktorat Jenderal Bina Marga Balai Besar Pelaksanaan Jalan Nasional Kalimantan Timur. <br><br>Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang berhasil meraih peringkat Terbaik II dalam Organisasi Perangkat Daerah Sub Urusan Jasa Konstruksi Tingkat Kota Terbaik Berkinerja Terbaik dan peringkat Terbaik III dalam Tertib Pemanfaatan Tertib Pemanfaat Produk Konstruksi Bangunan Pos Kamling Pada Lomba TKK Tingkat Provinsi Tahun 2024 Di RT. 48, Kel. Sempaja Timur, Kec. Samarinda Utara.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;<br><br></div>', '-', 0, '2024-12-02 15:30:00', '2024-12-02 23:23:10'),
('e1f7adf6-4d67-473d-8d76-2892bc73e871', 'Pemberitahuan Penutupan Sementara Jembatan Achmad Amins Kecamatan Sambutan', 'pemberitahuan-penutupan-sementara-jembatan-achmad-amins-kecamatan-sambutan', 3, 'Berita/2024-12/05/AtASUNpxd3FIJJ3RMixwNtbuUVxV5ERpPHAvhHtr.jpg', NULL, '<div><strong>PENGUMUMAN</strong> - Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda menghimbau adanya Penutupan Sementara Jembatan Achmad Amins, Kecamatan Sambutan pada hari sabtu, 7 Desember 2024 dan hari minggu, 8 Desember 2024 pukul 21.00 - 05.00 WITA.<br><br>Mohon maaf kepada pengendara kendaraan atas ketidaknyamanan yang mungkin terjadi selama proses tersebut. Kami berharap Anda dapat memahami dan bersabar selama pekerjaan ini berlangsung. Terima kasih atas kerjasamanya! 🙏<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-12-04 00:00:00', '2024-12-04 08:32:33'),
('e7727ae5-a0bf-434b-b835-31c4742f18fb', 'Perbaikan Oprit Jembatan Penghubung Jalan Tatako dan Rapak Mahang', 'perbaikan-oprit-jembatan-penghubung-jalan-tatako-dan-rapak-mahang', 9, 'Berita/2024-09/12/wQ90rLT6SL1iF3EQBO8f1AE62l1dpMLHCbJNohAm.jpg', NULL, '<div><strong>PENGUMUMAN</strong> - Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda menghimbau adanya larangan melintas untuk kendaraan mobil muatan dan truk roda 6 atau lebih pada Jalan Tatako dan Rapak Mahang, Kelurahan Sungai Kapih, Kecamatan Sambutan karena ada perbaikan oprit jembatan pada Hari Ini (12/09/24) - Selesai.<br><br>Mohon maaf kepada pengendara kendaraan atas ketidaknyamanan yang mungkin terjadi selama proses tersebut. Kami berharap Anda dapat memahami dan bersabar selama pekerjaan ini berlangsung. Terima kasih atas kerjasamanya! 🙏<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-09-11 06:51:00', '2024-09-12 06:35:04'),
('ee609722-7604-4c76-b664-0bd06784ff69', 'Audensi dan Kunjungan Lapangan dari perwakilan Global Green Growth Institute (GGGI) dan Korea International Cooperation Agency (KOICA)', 'audensi-dan-kunjungan-lapangan-dari-perwakilan-global-green-growth-institute-gggi-dan-korea-international-cooperation-agency-koica', 1, 'Berita/2024-10/24/ee609722-7604-4c76-b664-0bd06784ff69/Vy1wBJyGw1BMnaYsy8xspdzgEbaw0gavUqqZV4XE.png', NULL, '<div><strong>SAMARINDA</strong> - Pada Hari Kamis, 24 Oktober 2024. Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang diwakili Sekretaris Dinas, Ibu Neneng Chamelia Shanti, S.T., M.Si., Kepala Bidang Sumber Daya Air (<a href=\"https://www.instagram.com/perumdamsamarinda/\">@</a><a href=\"https://www.instagram.com/sdapuprsmd/?__pwa=1#\">sdapuprsmd</a>), Bapak Hendra Kusuma, S.T. bersama Tim, dan Bidang Penataan Ruang (<a href=\"https://www.instagram.com/tataruangsamarinda/\">@tataruangsamarinda</a>) melakukan Audensi dan Kunjungan Lapangan dari perwakilan Global Green Growth Institute (GGGI) dan Korea International Cooperation Agency (KOICA).<br><br>Kegiatan tersebut bertempat di Ruang Rapat Sambuyutan Lt. III Balikota Samarinda yang dihadiri juga oleh Assiten II, beberapa Kepala Organisasi Perangkat Daerah (OPD) dan jajarannya. Dalam audiensi yang berlangsung, kedua belah pihak mendiskusikan berbagai isu penting, seperti pengelolaan lingkungan, energi bersih, dan pengembangan kota pintar. Delegasi GGGI dan KOICA menyampaikan kesiapannya untuk berbagi pengetahuan dan pengalaman serta memberikan dukungan teknis dalam mewujudkan program-program pembangunan yang berkelanjutan di Kota Samarinda. <br><br>Selain audiensi, delegasi GGGI <a href=\"https://www.instagram.com/gggi_hq/\">@gggi_hq</a>, <a href=\"https://www.instagram.com/gggiindonesia/\">@gggiindonesia</a> dan KOICA <a href=\"https://www.instagram.com/officialkoica/\">@officialkoica</a>, <a href=\"https://www.instagram.com/koica.indonesia/\">@koica.indonesia</a> juga melakukan kunjungan lapangan untuk melihat langsung kondisi dan potensi pengembangan kota. Hasil dari kunjungan ini diharapkan dapat menjadi dasar dalam merumuskan program kerja sama yang lebih konkret di masa mendatang.<br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-10-23 16:30:00', '2024-10-24 07:00:52'),
('f0439cbc-f27c-4270-ad07-74b33c333242', 'Permohonan dan Pengaduan UPTD Pengelolaan Air Limbah Domestik', 'permohonan-dan-pengaduan-uptd-pengelolaan-air-limbah-domestik', 8, 'Berita/2024-11/28/ackfBCHpAu8QhszzxakBLtpAwPvoTL2a7ANPbWEz.jpg', NULL, '<div><strong>PENGUMUMAN</strong> - Kami dari Unit Pelaksana Teknis Dinas (UPTD) Pengelolaan Air Limbah Domestik Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda yang memerlukan layanan permohonan dan pengaduan sedot tinja dan sedot lumpur limbah bisa menghubungi kontak berikut ini.</div><div><br>Whatsapp: <a href=\"https://wa.me/6285213343536?fbclid=IwZXh0bgNhZW0CMTAAAR1w_ijeQbVLPCrnRGz1vJDQTeVZCOD62tm1x8LyCL80WrFGhRyB2g7-69Q_aem_ohfDYRDsNNquk0BbLW3jOw\"><strong>wa.me/6285213343536</strong></a></div><div>Instagram: <a href=\"https://www.instagram.com/uptd.pald.samarinda/\">@uptd.pald.samarinda</a><br><br>———————————————<br>Dinas PUPR Kota Samarinda dapat diakses melalui:<br>Website&nbsp; &nbsp; : <a href=\"https://pupr.samarindakota.go.id/\">https://pupr.samarindakota.go.id/</a><br>Instagram : <a href=\"https://www.instagram.com/dpuprkotasamarinda\">https://www.instagram.com/dpuprkotasamarinda</a><br>Facebook&nbsp; : <a href=\"https://www.facebook.com/dpuprkotasamarinda\">https://www.facebook.com/dpuprkotasamarinda</a><br>Youtube&nbsp; &nbsp; : <a href=\"https://www.youtube.com/@dinaspuprkotasamarinda\">https://www.youtube.com/@dinaspuprkotasamarinda</a><br>Email&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: dpuprkotasamarinda@gmail.com&nbsp;<br>———————————————&nbsp;</div>', '-', 0, '2024-11-26 17:46:00', '2024-11-27 09:46:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita_kategori`
--

CREATE TABLE `berita_kategori` (
  `id_berita_kategori` bigint(20) UNSIGNED NOT NULL,
  `id_susunan_organisasi` bigint(20) UNSIGNED NOT NULL,
  `ikon_berita_kategori` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `berita_kategori`
--

INSERT INTO `berita_kategori` (`id_berita_kategori`, `id_susunan_organisasi`, `ikon_berita_kategori`, `created_at`, `updated_at`) VALUES
(1, 2, 'Berita/ikon/sekretariat.png', '2024-07-23 19:52:49', '2025-01-07 21:36:06'),
(2, 6, 'Berita/ikon/bidang-sumber-daya-air.png\n', '2024-07-23 19:52:49', '2024-07-23 19:52:49'),
(3, 7, 'Berita/ikon/bidang-bina-marga.png\n', '2024-07-23 19:52:49', '2024-07-23 19:52:49'),
(4, 8, 'Berita/ikon/bidang-cipta-karya.png\n', '2024-07-23 19:52:49', '2024-07-23 19:52:49'),
(5, 9, 'Berita/ikon/bidang-bina-konstruksi.png\n', '2024-07-23 19:52:50', '2024-07-23 19:52:50'),
(6, 10, 'Berita/ikon/bidang-tata-ruang.png\n', '2024-07-25 02:55:50', '2024-07-25 02:55:50'),
(7, 11, 'Berita/ikon/bidang-pertanahan.png\n', '2024-07-25 02:55:50', '2024-07-25 02:55:50'),
(8, 12, 'Berita/ikon/uptd-pengelolaan-air-limbah-domestik.png\n', '2024-07-25 02:56:40', '2024-07-25 02:56:40'),
(9, 13, 'Berita/ikon/uptd-pemeliharaan-jalan-dan-jembatan.png\n', '2024-07-25 02:57:16', '2024-07-25 02:57:16'),
(10, 14, 'Berita/ikon/uptd-pemeliharaan-saluran-drainase-dan-irigasi.png\n', '2024-07-25 02:57:16', '2024-07-25 02:57:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku_tamu`
--

CREATE TABLE `buku_tamu` (
  `id_buku_tamu` varchar(255) NOT NULL,
  `nama_pengunjung` varchar(255) NOT NULL,
  `nomor_telepon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `jabatan_yang_dikunjungi` bigint(20) UNSIGNED NOT NULL,
  `maksud_dan_tujuan` text NOT NULL,
  `status` enum('Pending','Diterima','Ditolak') NOT NULL DEFAULT 'Pending',
  `deskripsi_status` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `buku_tamu`
--

INSERT INTO `buku_tamu` (`id_buku_tamu`, `nama_pengunjung`, `nomor_telepon`, `email`, `alamat`, `jabatan_yang_dikunjungi`, `maksud_dan_tujuan`, `status`, `deskripsi_status`, `created_at`, `updated_at`) VALUES
('11-12-2024-3NMw', 'Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 1, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet officiis dicta eligendi consequatur reprehenderit est alias doloribus asperiores saepe quos!', 'Pending', '', '2024-12-11 03:45:57', '2024-12-11 03:45:57'),
('11-12-2024-4BEE', 'Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 1, 'dsfsdfsdfsdf', 'Pending', 'Pengajuan diterima, menunggu proses lebih lanjut.', '2024-12-11 03:16:28', '2024-12-11 03:16:28'),
('11-12-2024-9kvu', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 11, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi dolores excepturi cupiditate neque similique repellat numquam magni tempora quae harum!', 'Pending', '', '2024-12-11 03:29:04', '2024-12-11 03:29:04'),
('11-12-2024-Ai0e', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 1, 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 'Pending', '', '2024-12-11 03:29:14', '2024-12-11 03:29:14'),
('11-12-2024-BJT8', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 1, 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 'Pending', '', '2024-12-11 03:33:31', '2024-12-11 03:33:31'),
('11-12-2024-csCV', 'Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 13, 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Veniam quaerat delectus libero quod laborum assumenda fugit iusto praesentium, mollitia nobis, commodi labore. Explicabo, eum officiis?', 'Pending', 'Tidak ada kasubag', '2024-12-11 03:46:45', '2024-12-11 03:46:45'),
('11-12-2024-Elp3', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 1, 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 'Pending', '', '2024-12-11 03:31:22', '2024-12-11 03:31:22'),
('11-12-2024-FGQF', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 11, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi dolores excepturi cupiditate neque similique repellat numquam magni tempora quae harum!', 'Pending', 'Pengajuan diterima, menunggu proses lebih lanjut.', '2024-12-11 03:22:46', '2024-12-11 03:22:46'),
('11-12-2024-FNTH', 'Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 1, '3eeeeeeeeeeeeee', 'Pending', 'Pengajuan diterima, menunggu proses lebih lanjut.', '2024-12-11 03:15:38', '2024-12-11 03:15:38'),
('11-12-2024-GmvX', 'Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 1, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste provident adipisci architecto voluptatibus nobis sit consequuntur, at quis explicabo illo impedit inventore temporibus necessitatibus dignissimos? Aut iste id rerum repudiandae!', 'Pending', '', '2024-12-11 03:35:33', '2024-12-11 03:35:33'),
('11-12-2024-HQyg', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 1, 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 'Pending', '', '2024-12-11 03:32:48', '2024-12-11 03:32:48'),
('11-12-2024-J2LN', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 1, 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 'Pending', '', '2024-12-11 03:31:18', '2024-12-11 03:31:18'),
('11-12-2024-KGMB', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 11, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi dolores excepturi cupiditate neque similique repellat numquam magni tempora quae harum!', 'Pending', 'Pengajuan diterima, menunggu proses lebih lanjut.', '2024-12-11 03:24:31', '2024-12-11 03:24:31'),
('11-12-2024-LYRw', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 1, 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 'Pending', '', '2024-12-11 03:33:42', '2024-12-11 03:33:42'),
('11-12-2024-p8zv', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 1, 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 'Pending', '', '2024-12-11 03:33:23', '2024-12-11 03:33:23'),
('11-12-2024-PHAM', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 11, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi dolores excepturi cupiditate neque similique repellat numquam magni tempora quae harum!', 'Pending', 'Pengajuan diterima, menunggu proses lebih lanjut.', '2024-12-11 03:24:38', '2024-12-11 03:24:38'),
('11-12-2024-qzxB', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 1, 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 'Pending', '', '2024-12-11 03:33:33', '2024-12-11 03:33:33'),
('11-12-2024-rkau', 'Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. In, alias corrupti? Odit iure qui asperiores animi hic esse culpa obcaecati laudantium vel. Vitae distinctio quo fugit, error quibusdam maiores voluptatibus.', 'Pending', '', '2024-12-11 03:47:47', '2024-12-11 03:47:47'),
('11-12-2024-SF3F', 'Farrel Sirah', '081369883657', '8ifarrel@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 11, 'mau coba aja', 'Pending', 'Pengajuan diterima, menunggu proses lebih lanjut.', '2024-12-11 03:01:00', '2024-12-11 03:01:00'),
('11-12-2024-SVAZ', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 1, 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 'Pending', '', '2024-12-11 03:31:40', '2024-12-11 03:31:40'),
('11-12-2024-TGVa', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 11, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi dolores excepturi cupiditate neque similique repellat numquam magni tempora quae harum!', 'Pending', '', '2024-12-11 03:28:55', '2024-12-11 03:28:55'),
('11-12-2024-tz94', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 11, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi dolores excepturi cupiditate neque similique repellat numquam magni tempora quae harum!', 'Pending', '', '2024-12-11 03:28:57', '2024-12-11 03:28:57'),
('11-12-2024-Vai2', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 1, 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 'Pending', '', '2024-12-11 03:32:45', '2024-12-11 03:32:45'),
('11-12-2024-VDNJ', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 1, 'aaaaaaaaaaaa', 'Pending', 'Pengajuan diterima, menunggu proses lebih lanjut.', '2024-12-11 03:13:47', '2024-12-11 03:13:47'),
('11-12-2024-YOIO', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 11, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi dolores excepturi cupiditate neque similique repellat numquam magni tempora quae harum!', 'Pending', 'Pengajuan diterima, menunggu proses lebih lanjut.', '2024-12-11 03:24:35', '2024-12-11 03:24:35'),
('11-12-2024-YTSO', 'Muhammad Farrel Sirah', '081369883657', 'farrelsirah@gmail.com', 'Jalan Pangeran Suryanata, Perumahan Graha Indah, Blok AH, No. 22, RT 49, Kel. Air Putih, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur, 75124', 1, 'adsdsdasssssssssssssssssssssssdsaca', 'Pending', 'Pengajuan diterima, menunggu proses lebih lanjut.', '2024-12-11 03:17:31', '2024-12-11 03:17:31'),
('13-12-2024-0bjd', 'Farrel Sirah', '081369883657', '8ifarrel@gmail.com', 'Jalan Suryanata', 9, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis placeat, provident dicta libero in repellendus eum ab, eos qui commodi quisquam distinctio dolorem. Odit, rerum amet a eum reprehenderit quasi incidunt quis tempore dolor harum quae dicta eius obcaecati libero numquam dolores non mollitia dignissimos molestiae reiciendis? Minima, consequuntur maxime!', 'Pending', NULL, '2024-12-13 12:34:39', '2024-12-13 12:34:39'),
('13-12-2024-f0yd', 'Farrel Sirah', '081369883657', '8ifarrel@gmail.com', 'Jalan Suryanata', 7, 'iseng aja wkwkwkw', 'Pending', '', '2024-12-13 12:31:24', '2024-12-13 12:31:24'),
('13-12-2024-nhi0', 'asasas', '42323423423', '8ifarrel@gmail.com', 'sasassa', 2, 'sdasdasdasd', 'Pending', NULL, '2024-12-13 12:45:57', '2024-12-13 12:45:57'),
('13-12-2024-vm0u', 'cdsvsdvsvs', '0209349024', '8ifarrel@gmail.com', 'aaaaaaaaaaaa', 11, '$jabatans = Jabatan::where(\'id_jabatan_parent\', 1)\r\n    ->select(\'id_susunan_organisasi\', \'nama_jabatan\')\r\n    ->get();', 'Pending', NULL, '2024-12-13 12:37:58', '2024-12-13 12:37:58'),
('13-12-2024-wmea', 'asasa', 'asasa', '8ifarrel@gmail.com', 'sasasas', 2, 'sadsads', 'Pending', NULL, '2024-12-13 13:20:47', '2024-12-13 13:20:47'),
('23-12-2024-3apt', 'Farrel Sirah', '081369883657', '8ifarrel@gmail.comds', 'Jalan Suryanata', 2, 'fdsfsdfs', 'Pending', NULL, '2024-12-22 17:50:08', '2024-12-22 17:50:08'),
('23-12-2024-6a9a', 'farrel sirah', '232432424', 'farrelsirah@gmail.com', '342342342423', 2, '23423423', 'Pending', NULL, '2024-12-22 18:01:06', '2024-12-22 18:01:06'),
('23-12-2024-au5h', 'farrel sirah', '232432424', 'farrelsirah@gmail.com', '342342342423', 2, '23423423', 'Pending', NULL, '2024-12-22 17:57:03', '2024-12-22 17:57:03'),
('23-12-2024-nnbj', 'farrel sirah', '3423847382', '8ifarrel@gmail.com', 'asdhsadfkjadsj', 2, 'kjsdnkjsfkhbsd', 'Diterima', 'Sedang dalam antrean', '2024-12-22 18:16:10', '2024-12-22 18:16:10'),
('23-12-2024-tkia', 'farrel sirah', '3423847382', '8ifarrel@gmail.com', 'asdhsadfkjadsj', 2, 'kjsdnkjsfkhbsd', 'Pending', NULL, '2024-12-22 18:15:55', '2024-12-22 18:15:55'),
('23-12-2024-xsl6', 'farrel sirah', '4324234', '8ifarrel@gmail.com', 'ewqeqwe', 2, 'qweqweq', 'Pending', NULL, '2024-12-22 17:52:12', '2024-12-22 17:52:12'),
('23-12-2024-xtxx', 'farrel sirah', '4324234', '8ifarrel@gmail.com', 'ewqeqwe', 2, 'qweqweq', 'Pending', NULL, '2024-12-22 17:53:57', '2024-12-22 17:53:57'),
('23-12-2024-yib4', 'farrel sirah', '232432424', 'farrelsirah@gmail.com', '342342342423', 2, '23423423', 'Pending', NULL, '2024-12-22 18:05:33', '2024-12-22 18:05:33'),
('23-12-2024-zmin', 'farrel sirah', '232432424', 'farrelsirah@gmail.com', '342342342423', 2, '23423423', 'Pending', NULL, '2024-12-22 18:15:12', '2024-12-22 18:15:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1750997958),
('5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1750997958;', 1750997958);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `susunan_organisasi`
--

CREATE TABLE `susunan_organisasi` (
  `id_susunan_organisasi` bigint(20) UNSIGNED NOT NULL,
  `nama_jabatan` varchar(255) NOT NULL,
  `id_jabatan_parent` bigint(20) UNSIGNED DEFAULT NULL,
  `slug_jabatan` varchar(255) NOT NULL,
  `tupoksi_jabatan` text DEFAULT NULL,
  `deskripsi_jabatan` text DEFAULT NULL,
  `kelompok_jabatan` enum('UPTD','Bidang','Kepala Dinas','Sekretariat') NOT NULL,
  `is_subbagian` tinyint(1) NOT NULL DEFAULT 0,
  `is_jabatan_fungsional` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `susunan_organisasi`
--

INSERT INTO `susunan_organisasi` (`id_susunan_organisasi`, `nama_jabatan`, `id_jabatan_parent`, `slug_jabatan`, `tupoksi_jabatan`, `deskripsi_jabatan`, `kelompok_jabatan`, `is_subbagian`, `is_jabatan_fungsional`, `created_at`, `updated_at`) VALUES
(0, 'IT PUPR', NULL, 'it-pupr', NULL, NULL, '', 0, 0, '2024-12-25 03:35:51', '2024-12-25 03:35:51'),
(1, 'Kepala Dinas', 1, 'kepala-dinas', '<div>-</div>', 'Kami menampilkan informasi dalam bentuk Pelayanan E-Goverment sehingga seluruh masyarakat dapat mengakses data terkait perdagangan.', 'Kepala Dinas', 0, 0, '2024-07-23 19:52:49', '2025-01-14 01:54:44'),
(2, 'Sekretariat', 1, 'sekretariat', NULL, 'Menyusun koordinasi penyusunan program, mengelola keuangan, kepegawaian kelengkapan kantor, dan administrasi.', 'Sekretariat', 0, 0, '2024-07-23 19:52:49', '2024-07-23 19:52:49'),
(3, 'Subbagian Program', 2, 'subbagian-program', NULL, NULL, 'Sekretariat', 1, 0, '2024-07-23 19:52:49', '2025-06-03 21:37:53'),
(4, 'Subbagian Umum dan Kepegawaian', 2, 'subbagian-umum-dan-kepegawaian', NULL, NULL, 'Sekretariat', 1, 0, '2024-07-23 19:52:49', '2024-07-23 19:52:49'),
(5, 'Subbagian Keuangan', 2, 'subbagian-keuangan', NULL, NULL, 'Sekretariat', 1, 0, '2024-07-23 19:52:49', '2024-07-23 19:52:49'),
(6, 'Bidang Sumber Daya Air', 1, 'bidang-sumber-daya-air', NULL, 'Mengelola sumber daya air di berbagai wilayah, termasuk sungai, bendungan, danau, irigasi, dll., untuk konservasi dan kebutuhan kota.', 'Bidang', 0, 0, '2024-07-23 19:52:49', '2024-07-23 19:52:49'),
(7, 'Bidang Bina Marga', 1, 'bidang-bina-marga', NULL, 'Memimpin perencanaan, pembangunan, dan preservasi jalan serta jembatan. Termasuk pengamanan, penerangan jalan, dan pengendalian mutu pekerjaan.', 'Bidang', 0, 0, '2024-07-23 19:52:49', '2025-01-12 23:47:25'),
(8, 'Bidang Cipta Karya', 1, 'bidang-cipta-karya', NULL, 'Menangani infrastruktur permukiman, bangunan, dan pengelolaan air minum, drainase, air limbah, serta persampahan di kawasan strategis kota.', 'Bidang', 0, 0, '2024-07-23 19:52:49', '2024-07-23 19:52:49'),
(9, 'Bidang Bina Konstruksi', 1, 'bidang-bina-konstruksi', NULL, 'Melaksanakan kebijakan dalam pembinaan jasa konstruksi sesuai dengan peraturan perundang-undangan yang berlaku', 'Bidang', 0, 0, '2024-07-23 19:52:49', '2024-07-23 19:52:49'),
(10, 'Bidang Tata Ruang', 1, 'bidang-tata-ruang', NULL, 'Menangani perumusan dan pelaksanaan aturan tata ruang sesuai kewenangan Pemerintah Kota berdasarkan perundangan-undangan yang berlaku.', 'Bidang', 0, 0, '2024-07-23 19:52:49', '2024-07-23 19:52:49'),
(11, 'Bidang Pertanahan', 1, 'bidang-pertanahan', NULL, 'Melaksanakan koordinasi izin lokasi, redistribusi tanah, pengadaan tanah kosong, ganti rugi tanah, dan perencanaan pengunaan tanah\n\n', 'Bidang', 0, 0, '2024-07-23 19:52:49', '2024-07-23 19:52:49'),
(12, 'UPTD Pengelolaan Air Limbah Domestik', 1, 'uptd-pengelolaan-air-limbah-domestik', NULL, 'Melaksanakan kegiatan teknis operasional khususnya layanan air limbah domestik.', 'UPTD', 0, 0, '2024-07-25 15:58:58', '2024-07-25 15:58:58'),
(13, 'UPTD Pemeliharaan Jalan dan Jembatan', 1, 'uptd-pemeliharaan-jalan-dan-jembatan', NULL, 'Melaksanakan kegiatan teknis operasional khususnya pemeliharaan jalan dan jembatan', 'UPTD', 0, 0, '2024-07-25 02:10:21', '2024-07-25 02:10:21'),
(14, 'UPTD Pemeliharaan Saluran Drainase dan Irigasi', 1, 'uptd-pemeliharaan-saluran-drainase-dan-irigasi', NULL, 'Melaksanakan kegiatan teknis operasional khususnya pemeliharaan saluran drainase dan irigasi.', 'UPTD', 0, 0, '2024-07-25 02:18:34', '2024-07-25 02:18:34'),
(15, 'Subbagian Tata Usaha UPTD Pengelolaan Air dan Limbah Domestik', 12, 'subbagian-tata-usaha-uptd-pengelolaan-air-dan-limbah-domestik', NULL, NULL, 'UPTD', 1, 0, '2024-07-25 02:22:49', '2024-07-25 02:22:49'),
(16, 'Subbagian Tata Usaha UPTD Pemeliharaan Jalan dan Jembatan', 13, 'subbagian-tata-usaha-uptd-pemeliharaan-jalan-dan-jembatan', NULL, NULL, 'UPTD', 1, 0, '2024-07-25 02:37:03', '2024-07-25 02:37:03'),
(17, 'Subbagian Tata Usaha UPTD Pemeliharaan Saluran Drainase dan Irigasi', 14, 'subbagian-tata-usaha-uptd-pemeliharaan-saluran-drainase-dan-irigasi', NULL, NULL, 'UPTD', 1, 0, '2024-07-25 02:47:05', '2024-07-25 02:47:05'),
(21, 'test', 10, 'test', '<div>test</div>', 'test', 'Bidang', 1, 0, '2025-06-03 22:59:32', '2025-06-03 22:59:32'),
(22, 'test2', 9, 'test2', '<div>test2</div>', 'test2', 'Bidang', 0, 1, '2025-06-03 23:50:58', '2025-06-03 23:50:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kepala_dinas_jenjang_karir`
--

CREATE TABLE `kepala_dinas_jenjang_karir` (
  `id_karir` bigint(20) UNSIGNED NOT NULL,
  `nama_karir` varchar(255) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `id_susunan_organisasi` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kepala_dinas_jenjang_karir`
--

INSERT INTO `kepala_dinas_jenjang_karir` (`id_karir`, `nama_karir`, `tanggal_masuk`, `id_susunan_organisasi`, `created_at`, `updated_at`) VALUES
(249, 'Kepala UPTD Perawatan Laboratorium999', '2009-04-29', 1, '2025-01-14 01:54:44', '2025-01-14 01:54:44'),
(250, 'Kepala Bidang Bina Teknik', '2014-02-07', 1, '2025-01-14 01:54:44', '2025-01-14 01:54:44'),
(251, 'Kepala Bidang Pengendalian Banjir', '2014-10-09', 1, '2025-01-14 01:54:44', '2025-01-14 01:54:44'),
(252, 'Kepala Bidang Pemukimansasa', '2017-01-18', 1, '2025-01-14 01:54:44', '2025-01-14 01:54:44'),
(253, 'Kepala Bidang Pelaksanaan Jaringan Sumber Air', '2017-12-06', 1, '2025-01-14 01:54:44', '2025-01-14 01:54:44'),
(254, 'Sekretaris DPUPR Kota Samarinda', '2021-04-27', 1, '2025-01-14 01:54:44', '2025-01-14 01:54:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kepala_dinas_riwayat_pendidikan`
--

CREATE TABLE `kepala_dinas_riwayat_pendidikan` (
  `id_pendidikan` bigint(20) UNSIGNED NOT NULL,
  `nama_pendidikan` varchar(255) NOT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `id_susunan_organisasi` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kepala_dinas_riwayat_pendidikan`
--

INSERT INTO `kepala_dinas_riwayat_pendidikan` (`id_pendidikan`, `nama_pendidikan`, `tanggal_masuk`, `id_susunan_organisasi`, `created_at`, `updated_at`) VALUES
(210, 'SD Negeri 005', '1992-08-01', 1, '2025-01-14 01:54:44', '2025-01-14 01:54:44'),
(211, 'SMP Negeri 1 Samarinda', '1992-08-02', 1, '2025-01-14 01:54:44', '2025-01-14 01:54:44'),
(212, 'SMA Negeri 1 Malang', '1992-08-03', 1, '2025-01-14 01:54:44', '2025-01-14 01:54:44'),
(213, 'Universitas Institut Teknologi Nasional Malang Program Studi Teknik Sipil Perencanaan', '1992-08-04', 1, '2025-01-14 01:54:44', '2025-01-14 01:54:44'),
(214, 'Institut Teknologi Sepuluh Nopember Program Magister Teknik Sipil-Manajemen Aset', '1992-08-05', 1, '2025-01-14 01:54:44', '2025-01-14 01:54:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `media_album`
--

CREATE TABLE `media_album` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `views_count` bigint(20) UNSIGNED DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `media_album`
--

INSERT INTO `media_album` (`id`, `judul`, `slug`, `views_count`, `created_at`, `updated_at`) VALUES
(1, 'Album 1', 'album-1', 324, '2024-08-04 23:07:05', '2024-08-04 23:07:05'),
(2, 'Album 2', 'album-2', 621, '2024-08-04 23:07:05', '2024-08-04 23:07:05'),
(3, 'Album 3', 'album-3', 171, '2024-08-04 23:07:05', '2024-08-04 23:07:05'),
(4, 'Album 4', 'album-4', 100, '2024-08-04 23:07:05', '2024-08-04 23:07:05'),
(5, 'Album 5', 'album-5', 863, '2024-08-04 23:07:05', '2024-08-04 23:07:05'),
(6, 'Album 6', 'album-6', 453, '2024-08-04 23:07:05', '2024-08-04 23:07:05'),
(7, 'Album 7', 'album-7', 875, '2024-08-04 23:07:05', '2024-08-04 23:07:05'),
(8, 'Album 8', 'album-8', 213, '2024-08-04 23:07:05', '2024-08-04 23:07:05'),
(9, 'Album 9', 'album-9', 547, '2024-08-04 23:07:05', '2024-08-04 23:07:05'),
(10, 'Album 10', 'album-10', 808, '2024-08-04 23:07:05', '2024-08-04 23:07:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `media_galeri`
--

CREATE TABLE `media_galeri` (
  `uuid` char(36) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `id_media_album` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `media_galeri`
--

INSERT INTO `media_galeri` (`uuid`, `foto`, `caption`, `id_media_album`, `created_at`, `updated_at`) VALUES
('022f35f5-dca7-47e7-a45e-d8a59b4567b5', 'https://via.placeholder.com/640x360.png/009955?text=cats+Faker+quam', 'Veritatis ullam dolorem voluptatem eum perferendis eum at voluptate.', 6, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('02d64338-6362-4cee-90c5-bd5ef35db5a0', 'https://via.placeholder.com/1920x1080.png/00aadd?text=cats+Faker+animi', 'Ullam at sed rem.', 3, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('02eb019b-3640-4e97-9f64-77f7831b6d6b', 'https://via.placeholder.com/800x600.png/004488?text=cats+Faker+mollitia', 'Non deleniti nobis ab nobis.', 10, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('067cab18-8f9b-44b3-baf8-449753258745', 'https://via.placeholder.com/1024x768.png/005577?text=cats+Faker+provident', 'Et facere et nesciunt aspernatur incidunt.', 1, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('0689f406-893c-458c-86d4-fe3e8da95973', 'https://via.placeholder.com/800x600.png/0022aa?text=cats+Faker+incidunt', 'Voluptatibus corporis et alias natus ut laboriosam.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('069ef864-218b-4d5d-9250-fc10d9b15b29', 'https://via.placeholder.com/1280x720.png/002266?text=cats+Faker+autem', 'Qui quo quis quis.', 10, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('0775fe06-3560-45ad-8aaf-dcc21f154547', 'https://via.placeholder.com/1920x1200.png/002222?text=cats+Faker+voluptatem', 'Nobis ipsum molestias velit amet illum quos.', 1, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('0ce4a0ec-8703-4f6d-a408-21559748da7d', 'https://via.placeholder.com/1280x1024.png/0066cc?text=cats+Faker+omnis', 'Est ut nostrum labore mollitia ipsam.', 3, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('11f3d7a4-791b-4688-a759-4310bc728bc6', 'https://via.placeholder.com/1280x720.png/0077ff?text=cats+Faker+numquam', 'Eos saepe quam dicta voluptas.', 5, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('12a88197-168a-485b-911d-1808f891edd7', 'https://via.placeholder.com/1280x720.png/0033ff?text=cats+Faker+rerum', 'Unde impedit suscipit iste voluptatem.', 8, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('13466571-7293-4166-a45c-d89748f6d342', 'https://via.placeholder.com/640x360.png/002211?text=cats+Faker+amet', 'Aut ex voluptatem asperiores modi quia est facere.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('152eae34-7353-4e5c-bcff-c18bd7295b15', 'https://via.placeholder.com/1920x1200.png/00ccdd?text=cats+Faker+laboriosam', 'Eum ut sapiente voluptatem ut repellendus et debitis.', 4, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('155cc789-8eea-43ce-be97-fd28f5749f48', 'https://via.placeholder.com/1920x1080.png/001166?text=cats+Faker+quis', 'Et dolorum et iste vitae.', 6, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('155e578f-df63-44d9-aa64-577e8590b226', 'https://via.placeholder.com/1600x900.png/009900?text=cats+Faker+sed', 'Consequatur vero nesciunt neque quae id incidunt non incidunt.', 1, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('16485621-3c9b-4cb2-987d-211eea8a3e17', 'https://via.placeholder.com/640x360.png/004466?text=cats+Faker+quos', 'Est delectus velit rerum eos quia vel ut.', 6, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('187d0850-214b-409b-8e6c-f8bff5519e22', 'https://via.placeholder.com/1920x1200.png/00eedd?text=cats+Faker+debitis', 'Aliquam sint neque sint voluptatum tempora.', 9, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('1a0aaed0-a879-4911-9370-9387f249f734', 'https://via.placeholder.com/1280x1024.png/001188?text=cats+Faker+sunt', 'Vero dolore fuga aspernatur qui assumenda doloribus.', 6, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('1eff74d2-411a-4551-8b40-fc38603203d5', 'https://via.placeholder.com/1280x1024.png/008888?text=cats+Faker+itaque', 'Quidem nam cum voluptas repellendus ipsam.', 4, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('21da85fe-bc13-45f6-991b-047db8a6d1b8', 'https://via.placeholder.com/800x600.png/0000ee?text=cats+Faker+dolore', 'Est enim omnis aspernatur aspernatur quibusdam quo nesciunt.', 5, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('2496d477-ce41-4ea6-8538-104b886cd1f1', 'https://via.placeholder.com/1920x1200.png/009955?text=cats+Faker+consequatur', 'Doloribus perspiciatis enim molestiae.', 4, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('2860522d-6844-402b-a103-18debafed2b8', 'https://via.placeholder.com/1920x1200.png/0033dd?text=cats+Faker+natus', 'Ratione explicabo eum harum error aut.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('2eaecf04-9863-4aa5-a0cb-9fc8ca82f34a', 'https://via.placeholder.com/1280x1024.png/00ffee?text=cats+Faker+non', 'Quasi fugit animi cupiditate veniam.', 1, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('2ebf3389-47ef-4b31-9e9a-a5a5305061e5', 'https://via.placeholder.com/1366x768.png/002299?text=cats+Faker+tenetur', 'Neque tempore velit et placeat repellendus iure.', 9, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('3389395c-9763-4929-b2a5-c62c23b75de6', 'https://via.placeholder.com/1600x900.png/000077?text=cats+Faker+voluptatem', 'Voluptatem et et qui et aliquid et consequatur.', 8, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('38afa6ca-4666-4428-9635-e5a426c9bfd4', 'https://via.placeholder.com/1280x1024.png/003377?text=cats+Faker+natus', 'Nihil quod dolor quasi aut nisi unde.', 10, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('39e7311a-ed03-4144-bb6f-3af03c53901a', 'https://via.placeholder.com/1920x1200.png/00aa33?text=cats+Faker+illo', 'At fugiat blanditiis rerum.', 5, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('3eeded28-2398-4909-a57b-17f7785fb724', 'https://via.placeholder.com/1600x900.png/0000ee?text=cats+Faker+quasi', 'Labore magni ad est illo.', 9, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('41285843-ec33-40f4-9869-de5da27a1235', 'https://via.placeholder.com/1280x720.png/001111?text=cats+Faker+eos', 'Aut tempora consequatur et necessitatibus vero.', 9, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('41592068-f960-43ab-9ba5-d5d58b17c9bd', 'https://via.placeholder.com/1366x768.png/0011ee?text=cats+Faker+quia', 'Temporibus itaque debitis doloribus cum dolor dolorem et fugit.', 4, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('41a401d1-dea8-49f0-a304-9e791187da09', 'https://via.placeholder.com/1366x768.png/004411?text=cats+Faker+placeat', 'Sed eum nobis labore quibusdam deserunt.', 8, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('48e5db78-8ab4-4563-8a38-5d2fca671370', 'https://via.placeholder.com/1366x768.png/0077aa?text=cats+Faker+voluptatem', 'In eligendi voluptates magnam facilis dolor.', 4, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('48fc82ad-8bd8-4886-8170-b1a744784b93', 'https://via.placeholder.com/640x360.png/00ff00?text=cats+Faker+voluptate', 'Repudiandae quae ipsa quos eum praesentium.', 10, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('4be95f83-17ea-4143-a28c-4ec1472f37de', 'https://via.placeholder.com/1280x1024.png/00bb11?text=cats+Faker+quia', 'Earum est reiciendis nobis fugiat.', 3, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('4cc8e4de-fab1-4e4d-b037-cf0cfc21f821', 'https://via.placeholder.com/1600x900.png/00bb77?text=cats+Faker+et', 'Ea magni doloremque consequatur iure in vero modi.', 10, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('4d286108-147b-427a-9d00-29bdb52879db', 'https://via.placeholder.com/1366x768.png/0077dd?text=cats+Faker+molestiae', 'Similique est illo voluptatem facere rerum.', 7, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('4de5843c-7494-4af8-bed2-b75b6591e10e', 'https://via.placeholder.com/1366x768.png/008866?text=cats+Faker+perferendis', 'Eum nostrum enim adipisci voluptas consequatur.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('4e27e3ec-9f09-44ef-98ad-cc7042ed5e4e', 'https://via.placeholder.com/640x360.png/005500?text=cats+Faker+qui', 'Illum non est sit nesciunt placeat et.', 6, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('4e4a85a7-23c8-4fa3-ba13-617d9e5920c2', 'https://via.placeholder.com/1024x768.png/000077?text=cats+Faker+sed', 'Voluptatem fuga officia omnis est natus laboriosam labore.', 8, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('504957d2-fd9b-47ea-a2c6-f134cf63fc95', 'https://via.placeholder.com/1280x720.png/00bbff?text=cats+Faker+debitis', 'Nisi voluptas iste suscipit possimus.', 6, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('5273d582-4653-4414-8ac3-404af11f4ef8', 'https://via.placeholder.com/1024x768.png/0055cc?text=cats+Faker+non', 'Amet consequatur dolore inventore provident explicabo deleniti.', 1, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('5389103d-9f23-4ac3-9e4c-da5f128264c5', 'https://via.placeholder.com/1366x768.png/004433?text=cats+Faker+et', 'Amet modi doloremque quasi perferendis qui fugit facere.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('557ddcf5-70dc-4cef-9ef5-a45fd07a08c8', 'https://via.placeholder.com/1600x900.png/003366?text=cats+Faker+officiis', 'Fuga dolorum dolorem aliquam.', 3, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('567bfaa4-8faa-4df2-ba90-f50c4dac2faf', 'https://via.placeholder.com/1920x1080.png/0066cc?text=cats+Faker+reiciendis', 'Enim alias dignissimos unde et non optio et.', 9, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('56c179a8-9382-4e0a-b6b9-f20fb1bccf1e', 'https://via.placeholder.com/1920x1080.png/0033bb?text=cats+Faker+sunt', 'Quas autem saepe recusandae doloremque voluptas.', 3, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('581a5b0d-46bd-4881-a2ec-13cd00faa960', 'https://via.placeholder.com/1920x1080.png/0044bb?text=cats+Faker+et', 'Ut vel laborum quia itaque.', 1, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('59c8a9b6-4b8d-4011-a2fe-491681d526cd', 'https://via.placeholder.com/1280x720.png/000033?text=cats+Faker+quisquam', 'Autem corporis veritatis dolorem et.', 6, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('5c7c14fb-d25d-4137-a457-6d699fd4d88b', 'https://via.placeholder.com/800x600.png/00eeaa?text=cats+Faker+magni', 'Quia blanditiis et libero tempora nihil deleniti suscipit.', 4, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('5d414076-d767-47c1-9349-31b18ad92269', 'https://via.placeholder.com/640x360.png/001100?text=cats+Faker+rerum', 'Consequatur nihil libero dolor.', 5, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('5ec18f94-e6d5-4750-ac83-9f948f6006a8', 'https://via.placeholder.com/640x360.png/00dd88?text=cats+Faker+neque', 'Modi laboriosam quia eaque ea.', 6, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('6022337d-27df-4aee-bc5c-4902eeac0a35', 'https://via.placeholder.com/1280x720.png/0022ff?text=cats+Faker+eum', 'Atque eos temporibus suscipit blanditiis illum provident provident.', 10, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('63f1a0f2-b099-49d4-abfd-07a08f88bd5a', 'https://via.placeholder.com/1280x1024.png/00cc66?text=cats+Faker+soluta', 'Nesciunt culpa rerum maxime.', 5, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('64b0c540-6089-495b-a570-688e69da76d8', 'https://via.placeholder.com/1920x1080.png/00ffaa?text=cats+Faker+quis', 'Odio sapiente nisi et.', 10, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('64fe9fac-597f-44b1-8139-e32054fdb897', 'https://via.placeholder.com/640x360.png/005544?text=cats+Faker+maiores', 'Eius voluptatem ab repudiandae doloremque vel enim minima.', 1, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('6637b14d-9a53-4f6b-8426-a6890f6b8698', 'https://via.placeholder.com/800x600.png/008811?text=cats+Faker+aut', 'Sunt provident odit dolor optio perspiciatis.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('6677f02f-abbd-472d-b40f-f16c11300d1d', 'https://via.placeholder.com/800x600.png/008888?text=cats+Faker+ad', 'Vel cum quisquam et eum nostrum consectetur.', 1, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('67c5e334-3fad-41ad-a356-ca7265e768c0', 'https://via.placeholder.com/1366x768.png/008811?text=cats+Faker+ea', 'Ut et culpa natus explicabo accusantium quibusdam omnis.', 8, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('6aac1287-9fd0-4e78-a96e-bdc2c9032f8e', 'https://via.placeholder.com/1920x1080.png/0033ff?text=cats+Faker+eveniet', 'Perspiciatis excepturi neque rerum odit.', 8, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('6ec5dbe1-f7c2-4abd-b2f8-dfaa8b8c57fc', 'https://via.placeholder.com/1024x768.png/0055ee?text=cats+Faker+omnis', 'Numquam pariatur ut neque ab deleniti necessitatibus.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('6ffc8210-5bac-4b6b-8d8c-1a53957e3a64', 'https://via.placeholder.com/1024x768.png/00dd22?text=cats+Faker+facere', 'Vitae aspernatur reiciendis laboriosam dolorem nesciunt.', 5, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('70e559c9-622f-4584-b880-356bf28afd7e', 'https://via.placeholder.com/1920x1080.png/002222?text=cats+Faker+distinctio', 'Qui fugit quia impedit.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('74aa00b4-9553-418a-b7f3-8df85b9dfd99', 'https://via.placeholder.com/1600x900.png/00bbee?text=cats+Faker+aut', 'Voluptatibus optio asperiores recusandae.', 6, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('78b4b72d-eea1-4057-a0ba-3b75dd51579c', 'https://via.placeholder.com/1280x1024.png/0033ee?text=cats+Faker+omnis', 'Est aut aut ducimus enim voluptas quis et unde.', 4, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('7f1e81ee-12e5-4cc0-8421-fffb28bc3c97', 'https://via.placeholder.com/800x600.png/008888?text=cats+Faker+perferendis', 'Quod numquam labore consequatur harum.', 3, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('80a811ac-1ea8-410d-ba26-bd5bc9769dcc', 'https://via.placeholder.com/1366x768.png/006699?text=cats+Faker+officia', 'Occaecati necessitatibus deleniti dolores delectus officia.', 8, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('852bc272-c719-4a2a-ad10-f0be6627be44', 'https://via.placeholder.com/640x360.png/005500?text=cats+Faker+dolor', 'Ipsum iure harum sit omnis dignissimos et ut.', 9, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('8aa807ec-72e5-4205-b938-53d43695a1f3', 'https://via.placeholder.com/1280x1024.png/00ffee?text=cats+Faker+non', 'Quisquam dolor molestiae ad nihil harum voluptatem sit dolore.', 5, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('8d9517df-f0bc-42be-8463-87d78250f174', 'https://via.placeholder.com/1280x720.png/0088ff?text=cats+Faker+velit', 'Nulla id ut iste quo dicta.', 7, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('8f588641-6e67-419e-8fca-959c1b90a81e', 'https://via.placeholder.com/1280x720.png/004477?text=cats+Faker+reprehenderit', 'Quia excepturi sunt eos a et architecto ut.', 6, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('903d3d3d-e938-4e8b-860d-c2fc011d0189', 'https://via.placeholder.com/1366x768.png/0055ff?text=cats+Faker+quis', 'In ducimus eius suscipit minus.', 3, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('941dd076-000c-48cf-a713-d4d2a7200281', 'https://via.placeholder.com/640x360.png/00ee00?text=cats+Faker+debitis', 'Natus alias est quis illo minima dolorem.', 10, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('9aeb7fe1-6aca-4950-ae19-8c300e94838e', 'https://via.placeholder.com/1366x768.png/000022?text=cats+Faker+est', 'Est dolor odit quae ad sunt.', 7, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('9c02fd9c-d0aa-4517-87d9-58d0c8e53f17', 'https://via.placeholder.com/1024x768.png/006688?text=cats+Faker+nostrum', 'Est magni repudiandae sequi sit et et perferendis et.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('9e929de0-fcae-432b-8d94-677c2e19485a', 'https://via.placeholder.com/1920x1200.png/00ccdd?text=cats+Faker+perspiciatis', 'Ducimus consectetur earum minus laboriosam.', 4, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('9f07b548-f4e5-40ba-b61e-096d137d96ce', 'https://via.placeholder.com/640x360.png/00ccaa?text=cats+Faker+velit', 'Voluptas quasi architecto dolorem tempora dolore.', 4, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('a31300cb-e06d-4fac-b79f-62f4168c145d', 'https://via.placeholder.com/800x600.png/004477?text=cats+Faker+aliquam', 'Laudantium sed officia commodi natus.', 8, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('a4532cb6-daa8-43c3-b974-92fd59d0f206', 'https://via.placeholder.com/1366x768.png/00ffee?text=cats+Faker+magni', 'Reprehenderit ex aperiam est.', 9, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('a7a2a791-b493-48d5-bbd8-4b16117a98bc', 'https://via.placeholder.com/1366x768.png/001199?text=cats+Faker+voluptatem', 'Odio at temporibus iste culpa voluptates maxime et.', 9, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('a85949a6-7e03-474a-a242-adf09be4bd8e', 'https://via.placeholder.com/1366x768.png/00ff99?text=cats+Faker+nemo', 'Praesentium cupiditate quia dignissimos velit necessitatibus ratione reprehenderit.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('a964effe-66a3-4194-8042-213cf82e6dde', 'https://via.placeholder.com/1600x900.png/004411?text=cats+Faker+repudiandae', 'Consequatur non nam suscipit omnis et molestiae ipsa.', 5, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('ac06931c-aaa9-4d71-ad3e-19ccb7fdf3ee', 'https://via.placeholder.com/1920x1080.png/00aa22?text=cats+Faker+autem', 'Quaerat est odit deserunt.', 5, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('b17155b0-dba1-4a18-867c-4e3301c63b38', 'https://via.placeholder.com/1600x900.png/00eecc?text=cats+Faker+quia', 'Minima sapiente quibusdam ipsam cum asperiores quaerat.', 1, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('b3f4941f-abac-4cd2-8402-ec40a29cbf22', 'https://via.placeholder.com/1600x900.png/00ee55?text=cats+Faker+libero', 'Similique ut id facilis nostrum.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('b5078760-4748-4870-b907-c670d10da038', 'https://via.placeholder.com/800x600.png/0055dd?text=cats+Faker+ad', 'Ex optio sint qui repellat accusantium aut aut.', 7, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('b5e876c0-5078-411f-8db5-93f14d8f37bb', 'https://via.placeholder.com/1024x768.png/003311?text=cats+Faker+tenetur', 'Qui vitae incidunt odio sit in est nisi.', 10, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('ba331481-84bd-457c-9e9c-cdce43708be9', 'https://via.placeholder.com/800x600.png/0011dd?text=cats+Faker+autem', 'Est dolor quis et quidem quam.', 5, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('bbd08f17-3e4a-47d4-bc81-34aa58cf8f7b', 'https://via.placeholder.com/1366x768.png/009988?text=cats+Faker+minima', 'Dolor hic debitis rerum eos.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('bcfe4618-1289-4dbe-9594-7f88a9f6ddd0', 'https://via.placeholder.com/640x360.png/0000aa?text=cats+Faker+rerum', 'Reprehenderit eum vero doloribus consectetur et officiis voluptatum necessitatibus.', 10, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('c106af8b-a872-45f9-b0b3-2d7864a6b0b7', 'https://via.placeholder.com/1280x1024.png/007799?text=cats+Faker+corrupti', 'Quo laboriosam est illum hic laboriosam voluptas.', 8, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('c175f2f9-375f-4527-bc81-5605004b83d3', 'https://via.placeholder.com/800x600.png/0033ee?text=cats+Faker+consequatur', 'Cupiditate est voluptates nesciunt quam amet facilis aliquid.', 1, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('c3a65e9d-7966-49c9-991e-4254e30a95ae', 'https://via.placeholder.com/1366x768.png/003366?text=cats+Faker+sint', 'Molestiae similique distinctio a quibusdam nihil aut.', 6, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('c8dd8844-59cb-4b44-9795-18dc2e74fead', 'https://via.placeholder.com/1366x768.png/009955?text=cats+Faker+sed', 'Quasi ab assumenda a cupiditate suscipit.', 8, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('c99f8d1a-1586-46c5-89ba-fc3f77f00928', 'https://via.placeholder.com/1280x720.png/0044ff?text=cats+Faker+earum', 'Qui ex unde aut molestiae laudantium quia est.', 9, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('c9c2db5c-b4f7-4a71-ba4e-0276b0ecc10e', 'https://via.placeholder.com/1366x768.png/00ddaa?text=cats+Faker+at', 'Veritatis molestiae numquam sit ut libero.', 8, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('ca71924c-93ab-42a0-b302-893b3787a1b1', 'https://via.placeholder.com/1920x1080.png/00ddaa?text=cats+Faker+voluptas', 'Ut quia omnis magnam et provident quos.', 7, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('cb301f3f-5333-4a2b-ae10-f013769c41c8', 'https://via.placeholder.com/1280x720.png/005555?text=cats+Faker+ex', 'Rem aut qui qui a sunt corrupti tenetur.', 1, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('cc14f398-8a60-4a3e-9743-7a357bec15f4', 'https://via.placeholder.com/1920x1080.png/00aa44?text=cats+Faker+minima', 'Eum quibusdam magnam est a aliquid.', 8, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('cc66f3d7-31c6-404b-b3f1-afd35b52678e', 'https://via.placeholder.com/800x600.png/00eedd?text=cats+Faker+nesciunt', 'Accusamus odio consectetur fugiat sed repudiandae.', 3, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('d1c70a92-9472-4767-b27c-3f3b07027a25', 'https://via.placeholder.com/1280x1024.png/0099dd?text=cats+Faker+sit', 'Ut sit vel qui dolores occaecati rerum quos.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('d29f3244-4b30-4d7a-b82b-425767a7d9b3', 'https://via.placeholder.com/1024x768.png/0011bb?text=cats+Faker+a', 'Odit fugit itaque odit consectetur perspiciatis officia.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('dc955c0e-dfcb-47ca-81ac-c21db2cbd265', 'https://via.placeholder.com/1600x900.png/00aa44?text=cats+Faker+dolore', 'Sint eius hic et laudantium autem.', 6, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('dcd881a1-a7d9-4fd7-8ba7-0438467c00e2', 'https://via.placeholder.com/1920x1200.png/0099ee?text=cats+Faker+ea', 'Porro ea ut velit non aliquid natus et corrupti.', 6, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('dd03c123-89f6-49b6-8896-b289729cbff0', 'https://via.placeholder.com/1920x1200.png/00bbaa?text=cats+Faker+fugit', 'Et dignissimos accusantium ut eligendi.', 8, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('ddd7d658-8fa1-4832-9117-9ed4de523e8c', 'https://via.placeholder.com/800x600.png/003366?text=cats+Faker+amet', 'Alias dolor sit aliquam neque ullam aperiam.', 4, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('e14369f5-8986-4093-a5a6-aafcc3b5651b', 'https://via.placeholder.com/1280x720.png/00cc11?text=cats+Faker+non', 'Enim tempora autem blanditiis.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('e2901291-431b-49bf-90c2-fe8e05a9dda8', 'https://via.placeholder.com/1920x1080.png/0066bb?text=cats+Faker+voluptatum', 'Ea asperiores quidem nihil veniam veritatis.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('e836807e-2555-4978-97ce-b35eda18c2f3', 'https://via.placeholder.com/1600x900.png/00dd11?text=cats+Faker+aut', 'Deleniti eveniet id ut vel qui cumque minima.', 10, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('e889e98d-1e13-4fc4-9c5f-f016843dd8fb', 'https://via.placeholder.com/1280x720.png/00dd77?text=cats+Faker+quia', 'Unde dignissimos eveniet nihil qui architecto vel eaque eos.', 6, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('e92800b2-c9c4-4423-b6aa-6d7274eb122f', 'https://via.placeholder.com/1366x768.png/00ee22?text=cats+Faker+odio', 'Consectetur quas distinctio dicta ut quas.', 7, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('ebe1d88d-2f36-41e0-885c-5ea7a22b1f34', 'https://via.placeholder.com/1024x768.png/002200?text=cats+Faker+quibusdam', 'Temporibus inventore quae fugiat quo sit sequi.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('ed16ce9a-2e0d-49f6-95d8-8dc363fc5492', 'https://via.placeholder.com/1920x1080.png/00ff77?text=cats+Faker+quas', 'Alias sit voluptatum veritatis distinctio eius eaque.', 7, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('eda6d426-dd47-498f-97db-879a2519740c', 'https://via.placeholder.com/1280x1024.png/0077dd?text=cats+Faker+magnam', 'Asperiores maxime praesentium fuga dolore in.', 3, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('f405d46b-9328-4b1b-9d9d-5149610faf91', 'https://via.placeholder.com/800x600.png/0077ff?text=cats+Faker+et', 'Cum praesentium quia iusto magni voluptas.', 5, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('f576b1f3-3bf4-47aa-a239-5c77463f197a', 'https://via.placeholder.com/1920x1200.png/00aa77?text=cats+Faker+atque', 'Dolor dolore doloribus maiores veritatis ex dolor voluptatem aliquam.', 4, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('f5b84bae-d738-44f0-b150-86fee0592587', 'https://via.placeholder.com/1366x768.png/0000ee?text=cats+Faker+voluptate', 'Et repudiandae rerum eaque non.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('f7429c83-71f8-4f95-ad7a-1f3857e5c52f', 'https://via.placeholder.com/1920x1080.png/008800?text=cats+Faker+beatae', 'At ea quia facere impedit consectetur.', 2, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('f7c3d6b6-b303-44e4-9940-20c96cb118d9', 'https://via.placeholder.com/1366x768.png/00dd33?text=cats+Faker+voluptate', 'Vitae incidunt magni fugiat quisquam hic qui.', 8, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('faa48507-4400-413f-81d4-ac39ce46bdd5', 'https://via.placeholder.com/800x600.png/0077aa?text=cats+Faker+officia', 'Explicabo est id sit.', 1, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('fb2a1b97-e8bb-411e-89c9-82fe01c1b349', 'https://via.placeholder.com/1366x768.png/008844?text=cats+Faker+atque', 'Aut magni error repudiandae modi inventore.', 9, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('fe5a0257-3e76-45b8-97ac-f287731cc036', 'https://via.placeholder.com/1920x1200.png/00ff22?text=cats+Faker+voluptas', 'Ipsum qui beatae veritatis aut.', 4, '2024-08-04 23:07:06', '2024-08-04 23:07:06'),
('fee34a95-0ca4-43d3-abe0-2485d8d8d861', 'https://via.placeholder.com/1280x1024.png/00dd22?text=cats+Faker+sunt', 'Ut autem voluptatem cupiditate est.', 4, '2024-08-04 23:07:06', '2024-08-04 23:07:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_06_27_010122_create_jabatan_table', 1),
(5, '2024_06_27_011051_create_berita_kategori_table', 1),
(6, '2024_06_27_032820_create_berita_table', 1),
(7, '2024_07_01_020444_create_slider_table', 1),
(8, '2024_07_01_040358_create_struktur_organisasi_table', 1),
(9, '2024_07_01_044528_create_partner_table', 1),
(10, '2024_07_01_065748_create_pegawai_table', 1),
(11, '2024_07_06_064824_create_kepala_dinas_riwayat_pendidikan_table', 1),
(12, '2024_07_06_074628_create_kepala_dinas_jenjang_karir_table', 1),
(13, '2024_07_08_022021_create_sejarah_kota_samarinda_table', 1),
(14, '2024_07_09_031106_create_sejarah_dinas_pupr_kota_samarinda_table', 1),
(15, '2024_07_09_041630_create_struktur_organisasi_diagram_table', 1),
(16, '2024_07_09_065231_create_visi_table', 1),
(17, '2024_07_09_071440_create_misi_table', 1),
(18, '2024_07_24_021909_create_pengumuman_table', 1),
(19, '2024_07_24_080914_create_personal_access_tokens_table', 2),
(20, '2024_08_01_065100_create_struktur_organisasi_slider_table', 3),
(21, '2024_08_01_065102_create_struktur_organisasi_slider_table', 4),
(22, '2024_07_09_041631_create_struktur_organisasi_diagram_table', 5),
(23, '2024_12_11_084734_create_buku_tamu_table', 6),
(24, '2024_12_11_084735_create_buku_tamu_table', 7),
(25, '0001_01_01_000000_create_users_table', 8),
(26, '2025_01_10_041401_create_ppid_pelaksana_kategori_table', 9),
(27, '2025_01_10_041429_create_ppid_pelaksana_table', 10),
(28, '2025_01_10_041426_create_ppid_pelaksana_table', 11),
(29, '2025_06_04_054837_add_is_subbagian_and_is_jabatan_fungsional_to_jabatan_table', 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `misi`
--

CREATE TABLE `misi` (
  `id_misi` bigint(20) UNSIGNED NOT NULL,
  `nomor_urut` int(11) NOT NULL,
  `deskripsi_misi` text NOT NULL,
  `periode_mulai` year(4) NOT NULL,
  `periode_selesai` year(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `misi`
--

INSERT INTO `misi` (`id_misi`, `nomor_urut`, `deskripsi_misi`, `periode_mulai`, `periode_selesai`, `created_at`, `updated_at`) VALUES
(1, 1, 'Mewujudkan masyarakat kota yang religious, unggul dan berbudaya', '2021', '2026', '2025-01-14 01:54:44', '2025-01-14 01:54:44'),
(2, 2, 'Mewujudkan perekonomian kota yang maju, mandiri, berkerakyatan dan berkeadilan', '2021', '2026', '2025-01-14 01:54:44', '2025-01-14 01:54:44'),
(3, 3, 'Mewujudkan pemerintahan yang professional, transparan, akuntabel dan bebas korupsi dengan memberi ruang bagi partisipasi masyarakat', '2021', '2026', '2025-01-14 01:54:44', '2025-01-14 01:54:44'),
(4, 4, 'Mewujudkan infrastruktur yang mantap dan modern', '2021', '2026', '2025-01-14 01:54:44', '2025-01-14 01:54:44'),
(5, 5, 'Mewujudkan lingkungan kota yang aman, nyaman, harmoni dan lestari999', '2021', '2026', '2025-01-14 01:54:44', '2025-01-14 01:54:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `partner`
--

CREATE TABLE `partner` (
  `id_partner` bigint(20) UNSIGNED NOT NULL,
  `foto_partner` varchar(255) NOT NULL,
  `nama_partner` varchar(255) NOT NULL,
  `url_partner` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `partner`
--

INSERT INTO `partner` (`id_partner`, `foto_partner`, `nama_partner`, `url_partner`, `created_at`, `updated_at`) VALUES
(1, 'partner/5.png', 'Sistem Informasi Rencana Umum Pengadaan', 'https://sirup.lkpp.go.id', '2025-01-14 01:09:21', '2025-01-14 01:09:21'),
(2, 'partner/2.png', 'Geographic Information System Tata Ruang Samarinda', 'https://gistaru.samarindakota.go.id/', '2024-12-13 19:42:12', '2024-12-13 19:42:12'),
(3, 'partner/3.png', 'Kementerian Pekerjaan Umum', 'https://pu.go.id/', '2024-12-13 19:47:09', '2024-12-13 19:47:09'),
(4, 'partner/4.png', 'Layanan Pengadaan Secara Elektronik Kota Samarinda', 'https://lpse.samarindakota.go.id/', '2024-12-13 19:50:16', '2024-12-13 19:50:16'),
(5, 'partner/1.png', 'Sistem Informasi Pemerintahan Daerah Republik Indonesia', 'https://sipd.kemendagri.go.id/', '2024-12-13 19:52:15', '2024-12-13 19:52:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul_pengumuman` varchar(255) NOT NULL,
  `slug_pengumuman` varchar(255) NOT NULL,
  `perihal` text NOT NULL,
  `file_lampiran` varchar(255) DEFAULT NULL,
  `views_count` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul_pengumuman`, `slug_pengumuman`, `perihal`, `file_lampiran`, `views_count`, `created_at`, `updated_at`) VALUES
(2, 'PERPANJANGAN KONTRAK KERJA PTTB TAHUN 2019', 'perpanjangan-kontrak-kerja-pttb-tahun-2019', '<p style=\"text-align: justify;\">Sehubungan dengan Surat edaran Sekretariat Daerah Kota Samarinda Nomor : 800/4870/300.04 tentang perpanjangan Kontrak Pegawai PTTB Dilingkungan Pemkot Samarinda Tahun 2019 maka disampaikan sebagai berikut :&nbsp;</p>\r\n<p style=\"text-align: justify;\">1. Agar setiap Kepala Bidang / Seksi / dapat menyeleksi seluruh pegawai PTTB yang berada dibawah pembinaannya selanjutnya membuat rekomendasi perpanjangan Kontrak PTTB.</p>\r\n<p style=\"text-align: justify;\">2. Rekomendasi tersebut diatas dikumpul pada bagian umum Sekretariat Dinas Perdagangan Kota Samarinda paling lambat tanggal 26 Nopember 2018, dengan melampirkan persyaratan yang disyaratkan</p>\r\n<p>&nbsp;</p>', NULL, 385, '2018-11-15 16:17:31', '2023-12-08 16:57:47'),
(3, 'Revisi Rencana Tata Ruang Wilayah Kota (RTRW) Kota Samarinda', 'revisi-rencana-tata-ruang-wilayah-kota-rtrw-kota-samarinda', '<p>Konsultasi Publik 2</p>', 'Pengumuman/revisi-rencana-tata-ruang-wilayah-kota-rtrw-kota-samarinda.jpeg', 732, '2019-11-14 07:27:58', '2023-12-08 16:57:44'),
(4, 'Pengunguman Lelang Terbuka', 'pengunguman-lelang-terbuka', '<p>Dalam rangka lanjutan penertiban reklame atau baliho median jalan kota samarinda pada tahun anggaran 2022 sesuai dengan surat Wali Kota Samariinda nomor 600/1683/100.07 yang mana hasil dari bahan konstruksi dan kontan pembongkaran reklame hasil penetriban akan dilakukan pemusnahan dengan cara dilelang.</p>\r\n<p>untuk informasi lebih lanjut dapat dilihat dari surat pengunguman terlampir</p>\r\n<p>untuk pengiriman bisa diteruskan ke email instansi kami di&nbsp;</p>\r\n<div class=\"qpEBEc\">\r\n<div class=\"q6rarf\">\r\n<div class=\"Wdz6e\">dpuprkotasamarinda@gmail.com</div>\r\n</div>\r\n</div>\r\n<div class=\"oREknc\">&nbsp;</div>', 'Pengumuman/pengunguman-lelang-terbuka.pdf', 72, '2023-06-11 18:35:59', '2023-12-10 08:17:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ppid_pelaksana`
--

CREATE TABLE `ppid_pelaksana` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `download_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ppid_pelaksana`
--

INSERT INTO `ppid_pelaksana` (`id`, `judul`, `slug`, `file`, `id_kategori`, `download_count`, `created_at`, `updated_at`) VALUES
(1, 'Rencana Aksi Perubahan Tahun 2022', 'rencana-aksi-perubahan-tahun-2022', 'Unduhan/2024-05/07/moXXInCE3KfEMtRUdCzJNgaHdPyHRm7zslAmU7ek.pdf', 32, 0, '2024-05-06 14:55:27', '2024-05-06 14:55:27'),
(2, 'Peraturan Menteri Perdagangan Nomor 20/M-DAG/PER/4/2014 Tahun 2014 tentang Pengendalian dan Pengawasan Terhadap Pengadaan, Peredaran, dan Penjualan Minuman Beralkohol', 'peraturan-menteri-perdagangan-nomor-20m-dagper42014-tahun-2014-tentang-pengendalian-dan-pengawasan-terhadap-pengadaan-peredaran-dan-penjualan-minuman-beralkohol', 'Unduhan/2024-05/07/03634cc0-1240-11e9-9b81-ab5d1f7a283c/y4ZTAWG3IpgQCQgqCEbMvlH60LQRz6zivBAjhuqk.pdf', 7, 135, '2019-01-06 21:49:35', '2024-05-06 15:35:42'),
(3, 'Rencana Aksi Pencapaian Kinerja Tahun 2022', 'rencana-aksi-pencapaian-kinerja-tahun-2022', 'Unduhan/2024-05/07/UQxoErmdNayhKJRlfLzWcneNCO1LWypQWQ3mmldX.pdf', 32, 0, '2024-05-06 15:14:29', '2024-05-06 15:14:29'),
(4, 'IKU 2022', 'iku-2022', 'Unduhan/IKU 2022UV9xg2VGjFYicfWzdfY0.pdf', 25, 35, '2023-01-09 19:22:35', '2023-12-09 12:13:58'),
(6, 'Rencana Strategis Tahun 2021 - 2026', 'rencana-strategis-tahun-2021-2026', 'Unduhan/2024-05/07/tgyH1ywdzp6jqrZjhKT84G9JgmPhTD46uu98ORNr.pdf', 38, 0, '2024-05-06 15:19:00', '2024-05-06 15:19:00'),
(7, 'Laporan Kinerja Tahun 2022', 'laporan-kinerja-tahun-2022', 'Unduhan/2024-05/07/hbny2YniaAe1RhtbP5d7ZT5UePayoEdw4MMCarQh.pdf', 32, 0, '2024-05-06 15:07:59', '2024-05-06 15:07:59'),
(9, 'Undang-undang (UU) Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik', 'undang-undang-uu-nomor-14-tahun-2008-tentang-keterbukaan-informasi-publik', 'Unduhan/2024-05/07/16e9e4a0-d334-11e8-a08a-076338748d7d/psqM7cSgMmAjPSI0WedLtrGdI7q6t4tkHzE1RfCJ.pdf', 7, 141, '2018-10-18 16:15:31', '2024-05-06 15:45:51'),
(10, 'Perubahan Rencana Strategis Tahun 2021 - 2026', 'perubahan-rencana-strategis-tahun-2021-2026', 'Unduhan/2024-06/05/JZ1bA7Iom2w4P4nMuHYR7ixIeLrgwZfRsrhCzIM6.pdf', 38, 0, '2024-06-04 14:51:25', '2024-06-04 14:51:25'),
(11, 'Indikator Kinerja Utama (IKU) Tahun 2016 - 2021', 'indikator-kinerja-utama-iku-tahun-2016-2021', 'Unduhan/2024-05/07/qlPdIuVRCiOajrjfOCoRIZBKyyOGxhg36r9virnT.pdf', 32, 0, '2024-05-06 15:04:59', '2024-05-06 15:04:59'),
(12, 'Peraturan Wali Kota Samarinda Nomor 26 Tahun 2024 Tentang Peraturan Pelaksanaan Peraturan Daerah Nomor 6 Tahun 2022 Tentang Penyelenggaraan Keterbukaan Informasi Publik', 'peraturan-wali-kota-samarinda-nomor-26-tahun-2024-tentang-peraturan-pelaksanaan-peraturan-daerah-nomor-6-tahun-2022-tentang-penyelenggaraan-keterbukaan-informasi-publik', 'Unduhan/2024-11/26/rkPXfmgVw5KyZjoIXwRNSPSJ4iVqlYW4bsCsmSFF.pdf', 7, 0, '2024-11-25 14:40:09', '2024-11-25 14:40:09'),
(13, 'Rencana Kerja Tahun 2021', 'rencana-kerja-tahun-2021', 'Unduhan/2024-05/07/ytsL6LwxdWQUL0GatKnC5AimJPcBKUye1WZX0YCt.pdf', 38, 0, '2024-05-06 15:16:51', '2024-05-06 15:16:51'),
(15, 'Renstra 2021-2026', 'renstra-2021-2026', 'Unduhan/6971_2_17571_2022-01-06_075450 (1)zn597c98ohEW7wyj5zlu.pdf', 25, 112, '2022-04-20 22:20:46', '2023-12-08 16:56:07'),
(17, 'RENSTRA DPPKB KATA PENGANTAR', 'renstra-dppkb-kata-pengantar', 'Unduhan/renstra-dppkb-kata-pengantar.pdf', 33, 0, '2018-05-22 19:34:25', '2018-05-22 19:34:25'),
(18, 'Perjanjian Kinerja Perubahan Tahun 2023', 'perjanjian-kinerja-perubahan-tahun-2023', 'Unduhan/2024-06/14/0ESZZ5meuEKaTUJu6fjTqOH1VtejV2qwyHYycsVc.pdf', 32, 0, '2024-06-13 09:30:02', '2024-06-13 09:30:02'),
(19, 'Dokumen Pelaksanaan Anggaran (DPA) TA 2024', 'dokumen-pelaksanaan-anggaran-dpa-ta-2024', 'Unduhan/2024-06/03/nZ5Cmxyaklgzr2eyBEMro1Bsa82ZfnJMNwyfH3Q9.pdf', 32, 0, '2024-06-02 15:25:06', '2024-06-02 15:25:06'),
(20, 'PK', 'pk', 'Unduhan/PKeLND26t5TK30wXgmIWTB.pdf', 25, 87, '2022-04-04 22:25:40', '2023-12-08 16:55:58'),
(21, 'Peraturan Daerah Kota Samarinda Nomor 7 Tahun 2023 Tentang Rencana Tata Ruang Wilayah Kota Samarinda Tahun 2023 - 2042', 'peraturan-daerah-kota-samarinda-nomor-7-tahun-2023-tentang-rencana-tata-ruang-wilayah-kota-samarinda-tahun-2023-2042', 'Unduhan/2024-05/07/37c5de09-d180-46f4-9631-160d7a9a6584/7yApuX8HFSaYSORyExc2GM1LbS5t85XomJVQERuR.pdf', 7, 0, '2024-05-06 11:57:19', '2024-05-06 15:32:10'),
(22, 'LAPORAN PERUBAHAN EKUITAS TAHUN 2023', 'laporan-perubahan-ekuitas-tahun-2023', 'Unduhan/2024-06/14/pTxN7gpYHZhtS8VbOt5vVqqHMJTsUuNeTGr61uyN.pdf', 32, 0, '2024-06-13 09:28:30', '2024-06-13 09:28:30'),
(24, 'Realisasi Penambahan dan Pengurangan Aset Tetap Daerah TA 2023', 'realisasi-penambahan-dan-pengurangan-aset-tetap-daerah-ta-2023', 'Unduhan/2024-06/03/uXWGOrd2V03iHHL2Dop8VyVSlzdn00wTVozucPzW.pdf', 32, 0, '2024-06-02 15:20:21', '2024-06-02 15:20:21'),
(25, 'NERACA TA 2023', 'neraca-ta-2023', 'Unduhan/2024-06/14/eWVCxs5og4eK6SeOiBy5hx9svAcmx1HdbkQB7fqD.pdf', 32, 0, '2024-06-13 09:28:45', '2024-06-13 09:28:45'),
(27, 'Undang-undang (UU) Nomor 25 Tahun 2004 tentang Sistem Perencanaan Pembangunan Nasional', 'undang-undang-uu-nomor-25-tahun-2004-tentang-sistem-perencanaan-pembangunan-nasional', 'Unduhan/2024-05/07/4383a6c0-d122-11e8-97d3-f3b5531964cc/FdBLl2zntysjhSkDRfIWdzYKCogh3pKk0lA4j77j.pdf', 7, 189, '2018-10-16 01:02:52', '2024-05-06 15:48:58'),
(28, 'Laporan Kinerja Tahun 2023', 'laporan-kinerja-tahun-2023', 'Unduhan/2024-06/03/cbIpnLdjJBEZojRzWp7GMtfQyp4D0jcsSCiiOK4Q.pdf', 32, 0, '2024-06-02 15:12:25', '2024-06-02 15:12:25'),
(30, 'Rencana Kerja Tahun 2023', 'rencana-kerja-tahun-2023', 'Unduhan/2024-06/05/4e2ae2cf-7ce0-45d6-bd68-ede75691a965/77f5BZfdKUOtl91Tfd2TDHO9vBJHximiX3cxB8Zf.pdf', 38, 0, '2024-05-06 12:00:10', '2024-06-04 14:52:38'),
(33, 'Rencana Kerja Tahun 2024', 'rencana-kerja-tahun-2024', 'Unduhan/2024-06/05/j3untRm2qPFXo6PA2BOD7osPls1FcbmF5liAMtaw.pdf', 38, 0, '2024-06-04 14:54:02', '2024-06-04 14:54:02'),
(34, 'RENSTRA DPPKB 2016 - 2021', 'renstra-dppkb-2016-2021', 'Unduhan/isi-renstra-dppkb-2016-2021.pdf', 33, 0, '2018-05-22 19:35:28', '2018-05-22 19:49:39'),
(35, 'Evaluasi Rencana Aksi Triwulan IV Tahun 2021', 'evaluasi-rencana-aksi-triwulan-iv-tahun-2021', 'Unduhan/2024-05/07/R4Ucm2pY4AuFAtUkk36cAFvhazmb3Heis7Bi4Isr.pdf', 32, 0, '2024-05-06 14:57:58', '2024-05-06 14:57:58'),
(36, 'Perjanjian Kinerja Tahun 2022', 'perjanjian-kinerja-tahun-2022', 'Unduhan/2024-05/07/HqHKwIPYLUkvt7rFIXIDHMct0RmnGJxSInnoCaPz.pdf', 32, 0, '2024-05-06 15:13:16', '2024-05-06 15:13:16'),
(37, 'Rencana Strategis Perubahan Tahun 2019', 'rencana-strategis-perubahan-tahun-2019', 'Unduhan/2024-05/07/M69StT1A31WkCbXmqMt2uttxtoVJ0nKmqppPlMu6.pdf', 38, 0, '2024-05-06 15:19:30', '2024-05-06 15:19:30'),
(38, 'Rencana Kerja Tahun 2020', 'rencana-kerja-tahun-2020', 'Unduhan/2024-05/07/D85AwAaSXUETl0w2n0fpr8tDOKJ1hzJb1IBJlMPI.pdf', 38, 0, '2024-05-06 15:16:00', '2024-05-06 15:16:00'),
(39, 'Indikator kinerja Individu (IKI) Sekretariat Tahun 2019', 'indikator-kinerja-individu-iki-sekretariat-tahun-2019', 'Unduhan/2024-05/07/Gzl0VZGCNraOS3RUFODIINSjmwyxNmbMYIDtMCHo.pdf', 32, 0, '2024-05-06 15:02:56', '2024-05-06 15:02:56'),
(41, 'Evaluasi Rencana Aksi 2021', 'evaluasi-rencana-aksi-2021', 'Unduhan/Evaluasi Rencana Aksifkl2gryWXl0Zy4G8ZNoC.pdf', 25, 209, '2022-04-04 22:19:53', '2023-12-08 16:56:41'),
(42, 'IKU', 'iku', 'Unduhan/IKUu1wkdA5KZhhHvBh48Qem.pdf', 25, 126, '2023-01-26 16:20:31', '2023-12-08 16:55:43'),
(43, 'LAPORAN REALISASI ANGGARAN PENDAPATAN & BELANJA DAERAH TAHUN 2022', 'laporan-realisasi-anggaran-pendapatan-belanja-daerah-tahun-2022', 'Unduhan/2024-05/07/QgoXOEv3Q0NUlwkSql8NiAmKCDQ8WRWcDKDSUe9p.pdf', 32, 0, '2024-05-06 15:12:19', '2024-05-06 15:12:19'),
(44, 'Perjanjian Kinerja 2021', 'perjanjian-kinerja-2021', 'Unduhan/Perjanjian Kinerja 202135f8Ecq6aLd5A0JYqceB.pdf', 25, 742, '2021-06-01 18:37:05', '2023-12-08 16:56:12'),
(48, 'LAPORAN PERUBAHAN EKUITAS TAHUN 2022', 'laporan-perubahan-ekuitas-tahun-2022', 'Unduhan/2024-05/07/bcpGUZEnTTCcxPvcOucsJ7sbISo70XO5mSCQtjbO.pdf', 32, 0, '2024-05-06 15:11:00', '2024-05-06 15:11:00'),
(49, 'Undang-undang (UU) Nomor 26 Tahun 2007 tentang Penataan Ruang', 'undang-undang-uu-nomor-26-tahun-2007-tentang-penataan-ruang', 'Unduhan/2024-05/07/7abdb130-d333-11e8-90ea-efc01ac715a2/juvaU9ftLUjtwX5TQtpSyBf7JxqUslhOIKuR9Lm7.pdf', 7, 215, '2018-10-18 16:11:09', '2024-05-06 15:47:10'),
(50, 'laporan kinerja LKj 2022_230410_144256', 'laporan-kinerja-lkj-2022-230410-144256', 'Unduhan/laporan kinerja LKj 2022_230410_14425624KnVsJ3XeJQHd7Z3SKg.pdf', 34, 48, '2023-05-30 20:42:06', '2023-12-11 16:15:28'),
(51, 'Peraturan Wali Kota Samarinda Nomor 106 Tahun 2021 Tentang Kedudukan, Susunan Organisasi, Tugas dan Fungsi, Serta Tata Kerja Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda', 'peraturan-wali-kota-samarinda-nomor-106-tahun-2021-tentang-kedudukan-susunan-organisasi-tugas-dan-fungsi-serta-tata-kerja-dinas-pekerjaan-umum-dan-penataan-ruang-kota-samarinda', 'Unduhan/2024-05/07/233fux6kkDKsEq8vpHQ3actzYvNjeLiVgKeDvy70.pdf', 7, 0, '2024-05-06 11:44:49', '2024-05-06 11:44:49'),
(52, 'Laporan Kinerja Tahun 2021', 'laporan-kinerja-tahun-2021', 'Unduhan/2024-05/07/lfdimkyLAK4oBxdQ9axfxW20F6YWrdU1Lzaq6U13.pdf', 32, 0, '2024-05-06 15:06:40', '2024-05-06 15:06:40'),
(53, 'Perjanjian Kinerja 2022', 'perjanjian-kinerja-2022', 'Unduhan/6971_6_17571_2022-02-24_091256 (1)JifPPxYsuWo5ICDCy86e.pdf', 25, 108, '2022-04-20 22:01:45', '2023-12-08 16:56:17'),
(54, 'Realisasi Penambahan dan Pengurangan Aset Lainnya TA 2023', 'realisasi-penambahan-dan-pengurangan-aset-lainnya-ta-2023', 'Unduhan/2024-06/03/2cqiwFisLpCPPw2DcvXNiJPJ6fXWwPhJU0nouCZW.pdf', 32, 0, '2024-06-02 15:21:04', '2024-06-02 15:21:04'),
(55, 'LAPORAN OPERASIONAL TAHUN 2023', 'laporan-operasional-tahun-2023', 'Unduhan/2024-06/14/vONqtCgCcYRxfvSrNagBTbhDsbqMAcmJ9xCu4OYa.pdf', 32, 0, '2024-06-13 09:27:37', '2024-06-13 09:27:37'),
(56, 'IKU 2016-2021', 'iku-2016-2021', 'Unduhan/6971_3_17571_2021-02-15_123832yc0cP37qTO1d4PLd70xA.pdf', 25, 170, '2021-06-02 21:42:55', '2023-12-08 16:55:50'),
(57, 'Perjanjian Kinerja Perubahan Tahun 2022', 'perjanjian-kinerja-perubahan-tahun-2022', 'Unduhan/2024-05/07/4fbkp6JhwBdPuEjmreUWMHeVMyhVk1y1TlcOArjE.pdf', 32, 0, '2024-05-06 14:51:23', '2024-05-06 14:51:23'),
(58, 'Perjanjian kinerja Perubahan 2022', 'perjanjian-kinerja-perubahan-2022', 'Unduhan/Perjanjian kinerja Perubahan 2022qpaFv0df3MdKC51vI6s2.pdf', 25, 68, '2023-01-26 16:21:39', '2023-12-08 16:56:10'),
(59, 'Indikator Kinerja Utama (IKU) Tahun 2021 - 2026', 'indikator-kinerja-utama-iku-tahun-2021-2026', 'Unduhan/2024-06/14/VEPUBiZYlWzoOedQB71Ysc1K1wi27jvprggPUU0k.pdf', 32, 0, '2024-06-13 09:30:26', '2024-06-13 09:30:26'),
(60, 'RENJA 2020', 'renja-2020', 'Unduhan/RENJA 2020OW2KUZ2vaxgXmGUvcbLU.pdf', 25, 174, '2021-06-01 16:57:59', '2023-12-08 16:56:14'),
(61, 'Perjanjian Kinerja Tahun 2023', 'perjanjian-kinerja-tahun-2023', 'Unduhan/2024-06/14/fvLfrK8Tkq0ePvMYpKW9mrot1J4Tochz0QaBtxzr.pdf', 32, 0, '2024-06-13 09:29:50', '2024-06-13 09:29:50'),
(62, 'Undang-undang (UU) Nomor 23 Tahun 2014 tentang Pemerintahan Daerah', 'undang-undang-uu-nomor-23-tahun-2014-tentang-pemerintahan-daerah', 'Unduhan/2024-05/07/94bba110-d332-11e8-a620-bb0c2f529791/w5ETjE1s26ydUNFArzhx5jKqL7YIr3GtLCWPhmVo.pdf', 7, 163, '2018-10-18 16:04:43', '2024-05-06 15:48:22'),
(63, 'Peraturan Wali Kota Samarinda Nomor 34 Tahun 2018 Tentang Pembentukan, Susunan Organisasi dan Tata Kerja Unit Pelaksana Teknis Daerah Pengelolaan Air Limbah Domestik pada Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda', 'peraturan-wali-kota-samarinda-nomor-34-tahun-2018-tentang-pembentukan-susunan-organisasi-dan-tata-kerja-unit-pelaksana-teknis-daerah-pengelolaan-air-limbah-domestik-pada-dinas-pekerjaan-umum-dan-penataan-ruang-kota-samarinda', 'Unduhan/2024-05/07/g5rWciyeoxPeKmDxbTjpriId9oaeoyTMRpmbZkbm.pdf', 7, 0, '2024-05-06 11:47:56', '2024-05-06 11:47:56'),
(64, 'Evaluasi Rencana Aksi Triwulan IV Tahun 2023', 'evaluasi-rencana-aksi-triwulan-iv-tahun-2023', 'Unduhan/2024-06/03/4yJJBcwHByA3kOkkvE87jXaWI9MGFdjVTX962i8e.pdf', 32, 0, '2024-06-02 15:23:11', '2024-06-02 15:23:11'),
(65, 'Peraturan Wali Kota Samarinda Nomor 25 Tahun 2023 Tentang Pembentukan, Susunan Organisasi dan Tata Kerja Unit Pelaksana Teknis Daerah Pemeliharaan Jalan dan Jembatan pada Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda', 'peraturan-wali-kota-samarinda-nomor-25-tahun-2023-tentang-pembentukan-susunan-organisasi-dan-tata-kerja-unit-pelaksana-teknis-daerah-pemeliharaan-jalan-dan-jembatan-pada-dinas-pekerjaan-umum-dan-penataan-ruang-kota-samarinda', 'Unduhan/2024-05/07/9876518a-dbea-48a2-8c2a-09773948ef66/gDcEgjDk9pLm7ZTUalF73SO6BQtwzoDsc63YvtS8.pdf', 7, 0, '2024-05-06 11:53:05', '2024-05-06 11:53:56'),
(67, 'Rencana aksi perubahan', 'rencana-aksi-perubahan', 'Unduhan/Rencana aksi perubahanupUhpWFzwrRsSpoSwqMG.pdf', 25, 152, '2023-01-26 16:22:03', '2023-12-08 16:55:48'),
(68, 'NERACA  TA 2022', 'neraca-ta-2022', 'Unduhan/NERACA  TA 20222jTb801Br9mmUpCeAww3.pdf', 32, 22, '2023-10-06 00:09:11', '2023-12-08 17:00:10'),
(70, 'Laporan Kinerja Tahun 2020', 'laporan-kinerja-tahun-2020', 'Unduhan/2024-05/07/7nClGQGimQUpEIyOQJUgl4CKp7sY32fs8ZDygcPt.pdf', 32, 0, '2024-05-06 15:06:04', '2024-05-06 15:06:04'),
(72, 'perjanjian kinerja perubahan', 'perjanjian-kinerja-perubahan', 'Unduhan/perjanjian kinerja perubahanpM8DDXFATGqRkEWpX5wc.pdf', 25, 138, '2021-06-03 16:41:58', '2023-12-08 16:56:36'),
(74, 'LAPORAN OPERASIONAL TAHUN 2022', 'laporan-operasional-tahun-2022', 'Unduhan/2024-05/07/EWZlhh6u1ogn4sD96OrmjRS5bkK6qQdstJIWTuGd.pdf', 32, 0, '2024-05-06 15:09:54', '2024-05-06 15:09:54'),
(75, 'LO_230410_150214- PEMKOT SMD LAPORAN OPERASIONAL', 'lo-230410-150214-pemkot-smd-laporan-operasional', 'Unduhan/LO_230410_150214- PEMKOT SMD LAPORAN OPERASIONAL9hWkTLUnE4FcpqMH88hv.pdf', 35, 29, '2023-05-30 20:43:23', '2023-12-08 16:54:31'),
(76, 'Peraturan Menteri Perdagangan Nomor 1 Tahun 2018 tentang Ketentuan Ekspor Dan Impor Beras', 'peraturan-menteri-perdagangan-nomor-1-tahun-2018-tentang-ketentuan-ekspor-dan-impor-beras', 'Unduhan/2024-05/07/b21c89d0-123f-11e9-bb08-93604ccfd9c4/75EBFiQ5t9DpqpODGyEJJnR57JfRY8tYisb0NtzM.pdf', 7, 160, '2019-01-06 21:47:19', '2024-05-06 15:37:51'),
(77, 'Undang-undang (UU) Nomor 2 Tahun 1981 tentang Metrologi Legal', 'undang-undang-uu-nomor-2-tahun-1981-tentang-metrologi-legal', 'Unduhan/2024-05/07/b4687710-e03e-11e8-a1b7-379877a5a8e9/Le4nnVfcao7ctYHPky4UBVzzDV5cXrH7rXHWcGN0.pdf', 7, 146, '2018-11-04 06:34:15', '2024-05-06 15:43:45'),
(78, 'Laporan Bulanan Realisasi Anggaran Belanja Langsung/Laporan Fisik TA 2024', 'laporan-bulanan-realisasi-anggaran-belanja-langsunglaporan-fisik-ta-2024', 'Unduhan/2024-06/03/dNSySocvEEYJbk6jJHNmFVLPwjJxvMTB1usbdO82.pdf', 32, 0, '2024-06-02 15:28:41', '2024-06-02 15:28:41'),
(80, 'renja 2021', 'renja-2021', 'Unduhan/renja 2021cTvsk3ZPdYcFah0red6t.pdf', 25, 95, '2022-04-04 22:29:22', '2023-12-08 16:56:39'),
(81, 'evaluasi rencana aksi 2020', 'evaluasi-rencana-aksi-2020', 'Unduhan/evaluasi rencana aksi 2020ty9gLjxDFFisFfc6GdiZ.pdf', 25, 525, '2021-06-01 16:59:18', '2023-12-08 16:56:23'),
(83, 'Indikator kinerja Individu', 'indikator-kinerja-individu', 'Unduhan/Indikator kinerja IndividurmPq1rshtsZ0MGuHPoST.pdf', 25, 189, '2021-06-01 22:57:16', '2023-12-08 16:55:46'),
(84, 'LPE_230410_150100- PEMKOT SMD LAPORAN PERUBAHAN EKUITAS', 'lpe-230410-150100-pemkot-smd-laporan-perubahan-ekuitas', 'Unduhan/LPE_230410_150100- PEMKOT SMD LAPORAN PERUBAHAN EKUITASGvo80tj6tFdaVNv0vf6Q.pdf', 36, 22, '2023-05-30 20:44:04', '2023-12-11 16:45:34'),
(85, 'Perjanjian Kinerja Tahun 2024', 'perjanjian-kinerja-tahun-2024', 'Unduhan/2024-06/05/zQnTBuwQM7Qd7yD8HqVHLcySwxIqv8WgnlUlPHZY.pdf', 32, 0, '2024-06-04 14:49:15', '2024-06-04 14:49:15'),
(86, 'Peraturan Pemerintah (PP) Nomor 45 Tahun 2012 tentang Jenis Dan Tarif Atas Jenis Penerimaan Negara Bukan Pajak Yang Berlaku Pada Kementerian Perdagangan', 'peraturan-pemerintah-pp-nomor-45-tahun-2012-tentang-jenis-dan-tarif-atas-jenis-penerimaan-negara-bukan-pajak-yang-berlaku-pada-kementerian-perdagangan', 'Unduhan/2024-05/07/c7e2d5e0-e03e-11e8-89a7-9376c9422144/H0oYmRs3SLxRJSpLIdWsKA7rGyVUrxYqpaBIRcxb.pdf', 7, 138, '2018-11-04 06:34:48', '2024-05-06 15:42:19'),
(87, 'Perubahan Renstra 2016 - 2021', 'perubahan-renstra-2016-2021', 'Unduhan/Renstra Perubahan 2019rZKEcjkHkCW2bdhjwMt1.pdf', 25, 1428, '2020-02-02 20:29:34', '2023-12-08 16:55:45'),
(89, 'Laporan Kinerja Tahun 2021 - 2026', 'laporan-kinerja-tahun-2021-2026', 'Unduhan/2024-05/07/GKxpwghXLarQrg1iBSBNhC2qTMKJTb5uRlxowcMd.pdf', 32, 0, '2024-05-06 15:08:37', '2024-05-06 15:08:37'),
(90, 'Rencana Aksi Pencapaian Kinerja Tahun 2024', 'rencana-aksi-pencapaian-kinerja-tahun-2024', 'Unduhan/2024-06/14/ZNXz40w40tufvjsD4fvDSSYHIOamOBGgANiBWqZf.pdf', 32, 0, '2024-06-13 09:30:57', '2024-06-13 09:30:57'),
(91, 'Evaluasi Rencana Aksi Tahun 2020', 'evaluasi-rencana-aksi-tahun-2020', 'Unduhan/2024-05/07/WdrT0dIKsPiTTRPEZhdFzT6VQAx2A637zblyO5QB.pdf', 32, 0, '2024-05-06 14:56:57', '2024-05-06 14:56:57'),
(92, 'Peraturan Pemerintah (PP) Nomor 96 Tahun 2012 tentang Pelaksanaan Undang Undang Nomor 25 Tahun 2009 Tentang Pelayanan Publik', 'peraturan-pemerintah-pp-nomor-96-tahun-2012-tentang-pelaksanaan-undang-undang-nomor-25-tahun-2009-tentang-pelayanan-publik', 'Unduhan/2024-05/07/d3984580-e03e-11e8-bf65-d76710249392/fTScLUkfzvCdaaynHkY2WoAnz18U0yBxbThgWsd1.pdf', 7, 151, '2018-11-04 06:35:07', '2024-05-06 15:41:44'),
(93, 'laporan Kinerja 2021', 'laporan-kinerja-2021', 'Unduhan/6971_8_17571_2022-02-07_073248 (2)Bh5WRkMPJbSpMxPDJ1zt.pdf', 25, 162, '2022-04-20 21:49:37', '2023-12-08 16:56:45'),
(94, 'Rencana aksi 2022', 'rencana-aksi-2022', 'Unduhan/Rencana aksi7GzLzZEFnyv5afS928XP.pdf', 25, 90, '2022-04-04 22:22:56', '2023-12-08 16:54:52'),
(95, 'LAPORAN REALISASI ANGGARAN PENDAPATAN & BELANJA DAERAH TAHUN 2023', 'laporan-realisasi-anggaran-pendapatan-belanja-daerah-tahun-2023', 'Unduhan/2024-06/14/AsTYL4BgfXaXUyEocpBpy738Trub9IyhUsJwzDgw.pdf', 32, 0, '2024-06-13 09:28:04', '2024-06-13 09:28:04'),
(97, 'Perjanjian Kinerja Tahun 2020', 'perjanjian-kinerja-tahun-2020', 'Unduhan/2024-05/07/wsMG6H4YCMKzpAmclBao7s9fDRxY1CYFKzxo48cU.pdf', 32, 0, '2024-05-06 15:13:50', '2024-05-06 15:13:50'),
(98, 'Peraturan Daerah (PERDA) Kota Samarinda Nomor 4 Tahun 2016 tentang Pembentukan Dan Susunan Perangkat Daerah', 'peraturan-daerah-perda-kota-samarinda-nomor-4-tahun-2016-tentang-pembentukan-dan-susunan-perangkat-daerah', 'Unduhan/2024-05/07/de0a39b0-e03e-11e8-8657-7b6f36719ab3/GpK7Dk2pTNvBLY1Aec0sLHgvWAlwEC0OUWuhHOKy.pdf', 7, 150, '2018-11-04 06:35:25', '2024-05-06 15:39:49'),
(99, 'Rencana Kerja 2022', 'rencana-kerja-2022', 'Unduhan/6971_10_17571_2022-02-07_073715 (1)SQ4qX1qZiAMTB8VZdqbR.pdf', 25, 90, '2022-04-20 22:04:13', '2023-12-08 16:55:54'),
(100, 'Cover Renstra 2017', 'cover-renstra-2017', 'Unduhan/cover-renstra-2017.pdf', 33, 0, '2018-05-22 19:32:13', '2018-05-22 19:32:13'),
(101, 'Perjanjian Kinerja Tahun 2021', 'perjanjian-kinerja-tahun-2021', 'Unduhan/2024-05/07/KezPtXiyt9nUoFnP5BabsnwDad9ak39dWFaQc2N3.pdf', 32, 0, '2024-05-06 15:12:49', '2024-05-06 15:12:49'),
(102, 'LRA_230410_150142- PEMKOT SMD LAPORAN REALISASI ANGGARAN PENDAPATAN & BELANJA DAERAH 2022', 'lra-230410-150142-pemkot-smd-laporan-realisasi-anggaran-pendapatan-belanja-daerah-2022', 'Unduhan/LRA_230410_150142- PEMKOT SMD LAPORAN REALISASI ANGGARAN PENDAPATAN & BELANJA DAERAH 2022mIQOLBEDbfUWtDrzqOBA.pdf', 37, 50, '2023-05-30 20:45:03', '2023-12-11 16:17:08'),
(103, 'lkj 2020', 'lkj-2020', 'Unduhan/lkj 2020vXX8DN2wPUXJ3tuDY6rz.pdf', 25, 166, '2021-11-15 17:09:56', '2023-12-08 16:56:48'),
(108, 'Peraturan Wali Kota Samarinda Nomor 26 Tahun 2023 Tentang Pembentukan, Susunan Organisasi dan Tata Kerja Unit Pelaksana Teknis Daerah Pemeliharaan Saluran Drainase dan Irigasi pada Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda', 'peraturan-wali-kota-samarinda-nomor-26-tahun-2023-tentang-pembentukan-susunan-organisasi-dan-tata-kerja-unit-pelaksana-teknis-daerah-pemeliharaan-saluran-drainase-dan-irigasi-pada-dinas-pekerjaan-umum-dan-penataan-ruang-kota-samarinda', 'Unduhan/2024-05/07/CWJnZyzzScqruB5CuJ3SIAchPgxp8gDHIrym7yUf.pdf', 7, 0, '2024-05-06 11:55:13', '2024-05-06 11:55:13'),
(110, 'Rencana Kerja Tahun 2022', 'rencana-kerja-tahun-2022', 'Unduhan/2024-05/07/liF6ho5N3DrbEOHDdiah4RDpgm5avpaPDhiCVUXv.pdf', 38, 0, '2024-05-06 15:17:52', '2024-05-06 15:17:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ppid_pelaksana_kategori`
--

CREATE TABLE `ppid_pelaksana_kategori` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ppid_pelaksana_kategori`
--

INSERT INTO `ppid_pelaksana_kategori` (`id`, `nama`, `slug`, `created_at`, `updated_at`) VALUES
(7, 'Peraturan Keputusan dan Kebijakan', 'peraturan-keputusan-dan-kebijakan', '2018-05-21 08:31:48', '2023-03-19 21:23:25'),
(25, 'Dokumen SAKIP', 'dokumen-sakip', '2020-02-02 20:28:18', '2023-03-19 21:23:19'),
(29, 'AUDIT LAPORAN KEUANGAN', 'audit-laporan-keuangan', '2023-03-19 21:23:06', '2023-03-19 21:23:06'),
(30, 'PENGADAAN BARANG DAN JASA', 'pengadaan-barang-dan-jasa', '2023-03-19 21:24:18', '2023-03-19 21:24:18'),
(32, 'INFORMASI YANG WAJIB DISEDIAKAN DAN DIUMUMKAN SECARA BERKALA', 'informasi-yang-wajib-disediakan-dan-diumumkan-secara-berkala', '2023-03-19 21:25:23', '2023-03-19 21:25:23'),
(33, 'INFORMASI YANG WAJIB DIUMUMKAN SECARA SERTA-MERTA', 'informasi-yang-wajib-diumumkan-secara-serta-merta', '2023-03-19 21:25:51', '2023-03-19 21:25:51'),
(34, 'LAPORAN KINERJA 2022', 'laporan-kinerja-2022', '2023-05-30 20:41:15', '2023-05-30 20:59:26'),
(35, 'LAPORAN OPERASIONAL 2022', 'laporan-operasional-2022', '2023-05-30 20:43:08', '2023-05-30 20:59:14'),
(36, 'LAPORAN PERUBAHAN EKUITAS 2022', 'laporan-perubahan-ekuitas-2022', '2023-05-30 20:43:54', '2023-05-30 20:57:50'),
(37, 'LAPORAN REALISASI ANGGARAN PENDAPATAN & BELANJA DAERAH 2022', 'laporan-realisasi-anggaran-pendapatan-belanja-daerah-2022', '2023-05-30 20:44:49', '2023-05-30 20:59:38'),
(38, 'INFORMASI YANG WAJIB TERSEDIA SETIAP SAAT', 'informasi-yang-wajib-tersedia-setiap-saat', '2023-12-12 22:50:24', '2025-01-11 01:38:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sejarah_dinas_pupr_kota_samarinda`
--

CREATE TABLE `sejarah_dinas_pupr_kota_samarinda` (
  `id_sejarah_dinas_pupr_kota_samarinda` bigint(20) UNSIGNED NOT NULL,
  `deskripsi_sejarah_dinas_pupr_kota_samarinda` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sejarah_dinas_pupr_kota_samarinda`
--

INSERT INTO `sejarah_dinas_pupr_kota_samarinda` (`id_sejarah_dinas_pupr_kota_samarinda`, `deskripsi_sejarah_dinas_pupr_kota_samarinda`, `created_at`, `updated_at`) VALUES
(1, '<p>Kantor Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda beralamat di Jalan H. Achmad Amins, Kelurahan Gunung Lingai, Kecamatan Sungai Pinang, Kota Samarinda. Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda semula berada di Komplek Balaikota Samarinda yang terletak di Jl. Kesuma Bangsa No.84, Kel. Bugis, Kec. Samarinda Kota, Kota Samarinda yang sekarang digunakan sebagai Kantor Diskominfo Kota Samarinda. Pada tahun 2018, Kantor Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda dipindah ketempat yang sekarang.</p><p>Selanjutnya, pada tahun 2016 terbitlah Peraturan Daerah (PERDA) Kota Samarinda Nomor 4 Tahun 2016 pada tanggal 16 Agustus 2016 Tentang Pembentukan dan Susunan Perangkat Daerah yang dimana Dinas Pekerjaan Umum dan Penataan Ruang termasuk salah satu OPD dengan tipe A. Kemudian, pada tanggal 20 Oktober 2016 terbitlah Peraturan Walikota (PERWALI) Kota Samarinda Nomor 25 tahun 2016 Tentang Susunan Organisasi dan Tata Kerja Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda Kota Samarinda. Dan terbentuknya Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda adalah gabungan dari 2 (dua) Dinas, yaitu (1) Dinas Bina Marga dan Pengairan dan (2) Dinas Cipta Karya dan Tata Kota.</p><p>Berdasarkan Peraturan Wali Kota Samarinda Nomor 106 Tahun 2021 Tentang Kedudukan, Susunan Organisasi, Tugas dan Fungsi, Serta Tata Kerja Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda pada tanggal 31 Desember 2021 yang susunan organisasi Dinas terdiri atas a. Dinas, b. Sekretariat, c. Bidang Bina Marga, d. Bidang Sumber Daya Air, e. Bidang Cipta Karya, f. Bidang Penataan Ruang, g. Bidang Bina Konstruksi, h. Bidang Pertanahan, i. UPTD Pengelolaan Air Limbah Domestik, j. UPTD Pemeliharaan Jalan dan Jembatan, k. Pemeliharaan Saluran Drainase dan Irigasi.</p>', '2024-07-23 19:52:53', '2024-07-23 19:52:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sejarah_kota_samarinda`
--

CREATE TABLE `sejarah_kota_samarinda` (
  `id_sejarah_kota_samarinda` bigint(20) UNSIGNED NOT NULL,
  `deskripsi_sejarah_kota_samarinda` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sejarah_kota_samarinda`
--

INSERT INTO `sejarah_kota_samarinda` (`id_sejarah_kota_samarinda`, `deskripsi_sejarah_kota_samarinda`, `created_at`, `updated_at`) VALUES
(1, '<p>Pada saat pecah perang Gowa, pasukan Belanda dibawah Laksamana Speelman memimpin Angkatan Laut menyerang Makasar dari laut, sedangkan Arupalaka yang membantu Belanda menyerang dari daratan. Akhirnya Kerajaan Gowa dapat dikalahkan dan Sultan Hasanuddin terpaksa menandatangani Perjanjian yang dikenal dengan “ PERJANJIAN BONGAJA “ pada tanggal 18 Nopember 1667</p><p>Sebagian orang-orang Bugis Wajo dari Kerajaan Gowa yang tidak mau tunduk dan patuh terhadap perjanjian Bongaja tersebut, mereka tetap meneruskan perjuangan dan perlawanan secara gerilya melawan Belanda dan ada pula yang hijrah ke pulau-pulau lainnya diantaranya ada yang hijrah kedaerah Kalimantan Timur untuk mengabdikan diri pada Kerajaan Kutai, yaitu rombongan yang dipimpin oleh La Mohang Daeng Mangkona (bergelar Poa Ado yang pertama), kedatangan orang-orang Bugis Wajo dari Kerajaan Gowa itu diterima dengan baik oleh Sultan Kutai.</p><p>Sesuai dengan perjanjian, bahwa orang-orang Bugis Wajo harus membantu segala kepentingan Raja Kutai, terutama dalam menghadapi musuh. Semua rombongan tersebut memilih daerah sekitar Muara Karang Mumus (daerah Selili Seberang) tetapi daerah ini menimbulkan kesulitan didalam pelayaran karena didaerah yang berarus putar (berulak) dengan banyak gunung-gunung (Gunung Selili), yaitu pada sekitar tahun 1668.</p><p>Dengan rumah rakit yang berada diatas air, harus sama tinggi antara rumah satu dengan yang lainnya, melambangkan tidak ada perbedaan derajat apakah Bangsawan atau tidak, semua sama derajatnya dengan lokasi yang berada disekitar muara sungai yang berulak dan dikiri kanan sungai daratan rendah atau “ renda “ diperkirakan dari istilah inilah lokasi permukaan baru tersebut dinamakan “ SAMARENDA “ atau lama kelamaan ejaannya menjadi “ SAMARINDA “</p><p>Orang-orang Bugis Wajo ini bermukim di Samarinda pada permulaan tahun 1668 atau tepatnya pada bulan Januari 1668 yang dijadikan patokan untuk menetapkan hari jadi Kota Samarinda. Telah ditetapkan pada peraturan Daerah Kotamadya Daerah Tingkat II Samarinda Nomor : 1 tahun 1988 Tanggal 21 Januari 1988, pasal 1 berbunyi “ Hari jadi Kota Samarinda ditetapkan pada tanggal 21 Januari 1668 M bertepatan dengan Tanggal 5 Sya’ban 1078 H “. Penetapan ini dilaksanakan bertepatan dengan peringatan hari jadi Kota Samarinda ke 320 pada Tanggal 21 Januari 1988.</p><p>Pembentukan Pemerintah Kota Samarinda didasarkan pada Undang - Undang Nomor 27 Tahun 1959. Berdasarkan PP 21 tahun 1987, Kota Samarinda terbagi menjadi 4 (empat) Kecamatan, Tahun 1997 dimekarkan menjadi 6 (enam) Kecamatan dan 53 (lima puluh tiga) Kelurahan dan berdasarkan Peraturan Daerah Kota Samarinda Nomor 02 Tahun 2010 dimekarkan kembali menjadi 10 (sepuluh) Kecamatan, dan berdasarkan Perda No. 6 Tahun 2014 Kelurahan Dimekarkan Kembali menjadi 59 Kelurahan.</p>', '2024-07-23 19:52:53', '2024-07-23 19:52:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1xyU1koGK2vnDGDGkBa91haCH514Ab2OzhIP1bAq', 1, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiekcyRjNCMmRlRXNxMnd4MnBWeXpaZmF0YjdVRThmR0NsNjFUdnRmbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lLXBhbmVsL2phYmF0YW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1751001914);

-- --------------------------------------------------------

--
-- Struktur dari tabel `slider`
--

CREATE TABLE `slider` (
  `id_slider` bigint(20) UNSIGNED NOT NULL,
  `judul_slider` varchar(255) NOT NULL,
  `foto_slider` varchar(255) NOT NULL,
  `nomor_urut_slider` int(11) NOT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `slider`
--

INSERT INTO `slider` (`id_slider`, `judul_slider`, `foto_slider`, `nomor_urut_slider`, `is_visible`, `created_at`, `updated_at`) VALUES
(1, 'Jadwal', 'Slider/1.png', 3, 1, '2024-07-23 19:52:52', '2024-12-26 01:02:17'),
(2, 'Jembatan Mahakam', 'Slider/2.jpg', 1, 1, '2024-07-23 19:52:52', '2025-01-11 01:24:42'),
(3, 'Pembuka', 'Slider/3.png', 2, 1, '2024-07-23 19:52:52', '2025-01-11 01:24:42'),
(4, 'Penutup', 'Slider/4.png', 4, 1, '2024-12-26 08:39:45', '2024-12-26 01:02:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `struktur_organisasi`
--

CREATE TABLE `struktur_organisasi` (
  `id_struktur_organisasi` int(10) UNSIGNED NOT NULL,
  `id_susunan_organisasi` bigint(20) UNSIGNED NOT NULL,
  `ikon_jabatan` varchar(255) DEFAULT NULL,
  `nomor_urut_jabatan` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `struktur_organisasi`
--

INSERT INTO `struktur_organisasi` (`id_struktur_organisasi`, `id_susunan_organisasi`, `ikon_jabatan`, `nomor_urut_jabatan`, `created_at`, `updated_at`) VALUES
(1, 2, 'struktur-organisasi/sekretariat/ikon/sekretariat.png', 1, NULL, NULL),
(2, 6, 'struktur-organisasi/bidang-sumber-daya-air/ikon/bidang-sumber-daya-air.png', 2, NULL, NULL),
(3, 7, 'struktur-organisasi/bidang-bina-marga/ikon/bidang-bina-marga.png', 3, NULL, NULL),
(4, 8, 'struktur-organisasi/bidang-cipta-karya/ikon/bidang-cipta-karya.png', 4, '2024-07-25 17:18:15', '2024-07-25 17:18:15'),
(5, 9, 'struktur-organisasi/bidang-bina-konstruksi/ikon/bidang-bina-konstruksi.png', 5, '2024-07-25 17:18:15', '2024-07-25 17:18:15'),
(6, 10, 'struktur-organisasi/bidang-tata-ruang/ikon/bidang-tata-ruang.png', 6, '2024-07-25 17:18:15', '2024-07-25 17:18:15'),
(7, 11, 'struktur-organisasi/bidang-pertanahan/ikon/bidang-pertanahan.png', 7, '2024-07-25 17:18:15', '2024-07-25 17:18:15'),
(8, 12, 'struktur-organisasi/uptd-pengelolaan-air-limbah-domestik/ikon/uptd-pengelolaan-air-limbah-domestik.png', 8, '2024-07-25 17:18:15', '2024-07-25 17:18:15'),
(9, 13, 'struktur-organisasi/uptd-pemeliharaan-jalan-dan-jembatan/ikon/uptd-pemeliharaan-jalan-dan-jembatan.png', 9, '2024-07-25 17:18:15', '2024-07-25 17:18:15'),
(10, 14, 'struktur-organisasi/uptd-pemeliharaan-saluran-drainase-dan-irigasi/ikon/uptd-pemeliharaan-saluran-drainase-dan-irigasi.png', 10, '2024-07-25 17:18:15', '2024-07-25 17:18:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `struktur_organisasi_diagram`
--

CREATE TABLE `struktur_organisasi_diagram` (
  `id_struktur_organisasi_diagram` bigint(20) UNSIGNED NOT NULL,
  `id_struktur_organisasi` int(10) UNSIGNED DEFAULT NULL,
  `diagram_struktur_organisasi` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `struktur_organisasi_diagram`
--

INSERT INTO `struktur_organisasi_diagram` (`id_struktur_organisasi_diagram`, `id_struktur_organisasi`, `diagram_struktur_organisasi`, `created_at`, `updated_at`) VALUES
(1, NULL, 'struktur-organisasi/keseluruhan/diagram/dinas-pupr-kota-samarinda.png', '2024-08-02 07:03:29', '2024-08-02 07:03:29'),
(2, 1, 'struktur-organisasi/sekretariat/diagram/sekretariat.png', '2024-12-10 17:57:52', '2024-12-10 17:57:52'),
(3, 2, 'struktur-organisasi/bidang-sumber-daya-air/diagram/bidang-sumber-daya-air.png', '2024-12-10 17:57:52', '2024-12-10 17:57:52'),
(4, 3, 'struktur-organisasi/bidang-bina-marga/diagram/bidang-bina-marga.png', '2024-12-10 17:57:52', '2024-12-10 17:57:52'),
(5, 4, 'struktur-organisasi/bidang-cipta-karya/diagram/bidang-cipta-karya.png', '2024-12-10 17:57:52', '2024-12-10 17:57:52'),
(6, 5, 'struktur-organisasi/bidang-bina-konstruksi/diagram/bidang-bina-konstruksi.png', '2024-12-10 17:57:52', '2024-12-10 17:57:52'),
(7, 6, 'struktur-organisasi/bidang-tata-ruang/diagram/bidang-tata-ruang.png', '2024-12-10 17:57:52', '2024-12-10 17:57:52'),
(8, 7, 'struktur-organisasi/bidang-pertanahan/diagram/bidang-pertanahan.png', '2024-12-10 17:57:52', '2024-12-10 17:57:52'),
(9, 8, 'struktur-organisasi/uptd-pengelolaan-air-limbah-domestik/diagram/uptd-pengelolaan-air-limbah-domestik.png', '2024-12-10 17:57:52', '2024-12-10 17:57:52'),
(10, 9, 'struktur-organisasi/uptd-pemeliharaan-jalan-dan-jembatan/diagram/uptd-pemeliharaan-jalan-dan-jembatan.png', '2024-12-10 17:57:52', '2024-12-10 17:57:52'),
(11, 10, 'struktur-organisasi/uptd-pemeliharaan-saluran-drainase-dan-irigasi/diagram/uptd-pemeliharaan-saluran-drainase-dan-irigasi.png', '2024-12-10 17:57:52', '2024-12-10 17:57:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `struktur_organisasi_slider`
--

CREATE TABLE `struktur_organisasi_slider` (
  `id_slider` int(10) UNSIGNED NOT NULL,
  `id_struktur_organisasi` int(10) UNSIGNED NOT NULL,
  `foto` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `struktur_organisasi_slider`
--

INSERT INTO `struktur_organisasi_slider` (`id_slider`, `id_struktur_organisasi`, `foto`, `keterangan`, `created_at`, `updated_at`) VALUES
(11, 6, 'https://via.placeholder.com/640x360.png/003322?text=ut', 'Eum et labore sit architecto eveniet.', '2024-07-31 07:22:48', '2024-07-31 07:22:48'),
(12, 4, 'https://via.placeholder.com/640x360.png/0000cc?text=voluptate', 'Illum velit nemo magni maiores non ab.', '2024-07-31 07:22:48', '2024-07-31 07:22:48'),
(13, 4, 'https://via.placeholder.com/640x360.png/003322?text=ratione', 'Accusantium voluptatem aspernatur inventore nulla assumenda dicta blanditiis.', '2024-07-31 07:22:48', '2024-07-31 07:22:48'),
(14, 9, 'https://via.placeholder.com/640x360.png/00cc88?text=fugit', 'Quasi dolores id blanditiis veniam earum.', '2024-07-31 07:22:48', '2024-07-31 07:22:48'),
(15, 6, 'https://via.placeholder.com/640x360.png/000022?text=nihil', 'Adipisci asperiores sunt laudantium iste.', '2024-07-31 07:22:48', '2024-07-31 07:22:48'),
(16, 4, 'https://via.placeholder.com/640x360.png/00ffcc?text=laudantium', 'Impedit eum tenetur dolore culpa.', '2024-07-31 07:22:48', '2024-07-31 07:22:48'),
(17, 9, 'https://via.placeholder.com/640x360.png/00bb33?text=quo', 'Dicta mollitia amet autem rerum.', '2024-07-31 07:22:48', '2024-07-31 07:22:48'),
(18, 10, 'https://via.placeholder.com/640x360.png/0055ee?text=odit', 'Ut quia similique voluptatibus odio nesciunt.', '2024-07-31 07:22:48', '2024-07-31 07:22:48'),
(19, 9, 'https://via.placeholder.com/640x360.png/008800?text=voluptas', 'Rerum excepturi sint eius id magnam ea.', '2024-07-31 07:22:48', '2024-07-31 07:22:48'),
(20, 3, 'https://via.placeholder.com/640x360.png/003300?text=quis', 'Enim qui blanditiis voluptatem culpa sunt similique.', '2024-07-31 07:22:48', '2024-07-31 07:22:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_susunan_organisasi` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `visi`
--

CREATE TABLE `visi` (
  `id_visi` bigint(20) UNSIGNED NOT NULL,
  `deskripsi_visi` text NOT NULL,
  `periode_mulai` year(4) NOT NULL,
  `periode_selesai` year(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `visi`
--

INSERT INTO `visi` (`id_visi`, `deskripsi_visi`, `periode_mulai`, `periode_selesai`, `created_at`, `updated_at`) VALUES
(1, 'Menjadi kota yang berwawasan lingkungan dan berkelanjutan', '2021', '2026', '2024-07-23 19:52:53', '2025-01-14 01:54:44');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`uuid_berita`),
  ADD UNIQUE KEY `berita_judul_berita_unique` (`judul_berita`),
  ADD UNIQUE KEY `berita_slug_berita_unique` (`slug_berita`),
  ADD KEY `berita_id_berita_kategori_foreign` (`id_berita_kategori`);

--
-- Indeks untuk tabel `berita_kategori`
--
ALTER TABLE `berita_kategori`
  ADD PRIMARY KEY (`id_berita_kategori`),
  ADD KEY `berita_kategori_id_jabatan_foreign` (`id_susunan_organisasi`);

--
-- Indeks untuk tabel `buku_tamu`
--
ALTER TABLE `buku_tamu`
  ADD PRIMARY KEY (`id_buku_tamu`),
  ADD KEY `buku_tamu_jabatan_yang_dikunjungi_foreign` (`jabatan_yang_dikunjungi`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `susunan_organisasi`
--
ALTER TABLE `susunan_organisasi`
  ADD PRIMARY KEY (`id_susunan_organisasi`),
  ADD UNIQUE KEY `jabatan_nama_jabatan_unique` (`nama_jabatan`),
  ADD UNIQUE KEY `jabatan_slug_jabatan_unique` (`slug_jabatan`),
  ADD KEY `jabatan_id_jabatan_parent_foreign` (`id_jabatan_parent`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kepala_dinas_jenjang_karir`
--
ALTER TABLE `kepala_dinas_jenjang_karir`
  ADD PRIMARY KEY (`id_karir`),
  ADD KEY `kepala_dinas_jenjang_karir_id_pegawai_foreign` (`id_susunan_organisasi`);

--
-- Indeks untuk tabel `kepala_dinas_riwayat_pendidikan`
--
ALTER TABLE `kepala_dinas_riwayat_pendidikan`
  ADD PRIMARY KEY (`id_pendidikan`),
  ADD KEY `kepala_dinas_riwayat_pendidikan_id_pegawai_foreign` (`id_susunan_organisasi`);

--
-- Indeks untuk tabel `media_album`
--
ALTER TABLE `media_album`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `media_galeri`
--
ALTER TABLE `media_galeri`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `id_media_album` (`id_media_album`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `misi`
--
ALTER TABLE `misi`
  ADD PRIMARY KEY (`id_misi`);

--
-- Indeks untuk tabel `partner`
--
ALTER TABLE `partner`
  ADD PRIMARY KEY (`id_partner`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `ppid_pelaksana`
--
ALTER TABLE `ppid_pelaksana`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ppid_pelaksana_slug_unique` (`slug`),
  ADD KEY `ppid_pelaksana_id_kategori_foreign` (`id_kategori`);

--
-- Indeks untuk tabel `ppid_pelaksana_kategori`
--
ALTER TABLE `ppid_pelaksana_kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ppid_pelaksana_kategori_slug_unique` (`slug`);

--
-- Indeks untuk tabel `sejarah_dinas_pupr_kota_samarinda`
--
ALTER TABLE `sejarah_dinas_pupr_kota_samarinda`
  ADD PRIMARY KEY (`id_sejarah_dinas_pupr_kota_samarinda`);

--
-- Indeks untuk tabel `sejarah_kota_samarinda`
--
ALTER TABLE `sejarah_kota_samarinda`
  ADD PRIMARY KEY (`id_sejarah_kota_samarinda`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id_slider`),
  ADD UNIQUE KEY `slider_nomor_urut_slider_unique` (`nomor_urut_slider`);

--
-- Indeks untuk tabel `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  ADD PRIMARY KEY (`id_struktur_organisasi`),
  ADD UNIQUE KEY `nomor_urut_jabatan` (`nomor_urut_jabatan`),
  ADD KEY `id_susunan_organisasi` (`id_susunan_organisasi`);

--
-- Indeks untuk tabel `struktur_organisasi_diagram`
--
ALTER TABLE `struktur_organisasi_diagram`
  ADD PRIMARY KEY (`id_struktur_organisasi_diagram`),
  ADD KEY `struktur_organisasi_diagram_id_struktur_organisasi_foreign` (`id_struktur_organisasi`);

--
-- Indeks untuk tabel `struktur_organisasi_slider`
--
ALTER TABLE `struktur_organisasi_slider`
  ADD PRIMARY KEY (`id_slider`),
  ADD KEY `id_struktur_organisasi` (`id_struktur_organisasi`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_id_pegawai_foreign` (`id_susunan_organisasi`);

--
-- Indeks untuk tabel `visi`
--
ALTER TABLE `visi`
  ADD PRIMARY KEY (`id_visi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `berita_kategori`
--
ALTER TABLE `berita_kategori`
  MODIFY `id_berita_kategori` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `susunan_organisasi`
--
ALTER TABLE `susunan_organisasi`
  MODIFY `id_susunan_organisasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kepala_dinas_jenjang_karir`
--
ALTER TABLE `kepala_dinas_jenjang_karir`
  MODIFY `id_karir` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT untuk tabel `kepala_dinas_riwayat_pendidikan`
--
ALTER TABLE `kepala_dinas_riwayat_pendidikan`
  MODIFY `id_pendidikan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT untuk tabel `media_album`
--
ALTER TABLE `media_album`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `misi`
--
ALTER TABLE `misi`
  MODIFY `id_misi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `partner`
--
ALTER TABLE `partner`
  MODIFY `id_partner` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
  
--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ppid_pelaksana`
--
ALTER TABLE `ppid_pelaksana`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT untuk tabel `ppid_pelaksana_kategori`
--
ALTER TABLE `ppid_pelaksana_kategori`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `sejarah_dinas_pupr_kota_samarinda`
--
ALTER TABLE `sejarah_dinas_pupr_kota_samarinda`
  MODIFY `id_sejarah_dinas_pupr_kota_samarinda` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `sejarah_kota_samarinda`
--
ALTER TABLE `sejarah_kota_samarinda`
  MODIFY `id_sejarah_kota_samarinda` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `slider`
--
ALTER TABLE `slider`
  MODIFY `id_slider` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  MODIFY `id_struktur_organisasi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `struktur_organisasi_diagram`
--
ALTER TABLE `struktur_organisasi_diagram`
  MODIFY `id_struktur_organisasi_diagram` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `struktur_organisasi_slider`
--
ALTER TABLE `struktur_organisasi_slider`
  MODIFY `id_slider` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `visi`
--
ALTER TABLE `visi`
  MODIFY `id_visi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD CONSTRAINT `berita_id_berita_kategori_foreign` FOREIGN KEY (`id_berita_kategori`) REFERENCES `berita_kategori` (`id_berita_kategori`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `berita_kategori`
--
ALTER TABLE `berita_kategori`
  ADD CONSTRAINT `berita_kategori_id_jabatan_foreign` FOREIGN KEY (`id_susunan_organisasi`) REFERENCES `susunan_organisasi` (`id_susunan_organisasi`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `buku_tamu`
--
ALTER TABLE `buku_tamu`
  ADD CONSTRAINT `buku_tamu_jabatan_yang_dikunjungi_foreign` FOREIGN KEY (`jabatan_yang_dikunjungi`) REFERENCES `susunan_organisasi` (`id_susunan_organisasi`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `susunan_organisasi`
--
ALTER TABLE `susunan_organisasi`
  ADD CONSTRAINT `jabatan_id_jabatan_parent_foreign` FOREIGN KEY (`id_jabatan_parent`) REFERENCES `susunan_organisasi` (`id_susunan_organisasi`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kepala_dinas_jenjang_karir`
--
ALTER TABLE `kepala_dinas_jenjang_karir`
  ADD CONSTRAINT `kepala_dinas_jenjang_karir_id_pegawai_foreign` FOREIGN KEY (`id_susunan_organisasi`) REFERENCES `susunan_organisasi` (`id_susunan_organisasi`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kepala_dinas_riwayat_pendidikan`
--
ALTER TABLE `kepala_dinas_riwayat_pendidikan`
  ADD CONSTRAINT `kepala_dinas_riwayat_pendidikan_id_pegawai_foreign` FOREIGN KEY (`id_susunan_organisasi`) REFERENCES `susunan_organisasi` (`id_susunan_organisasi`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `media_galeri`
--
ALTER TABLE `media_galeri`
  ADD CONSTRAINT `media_galeri_ibfk_1` FOREIGN KEY (`id_media_album`) REFERENCES `media_album` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ppid_pelaksana`
--
ALTER TABLE `ppid_pelaksana`
  ADD CONSTRAINT `ppid_pelaksana_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `ppid_pelaksana_kategori` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  ADD CONSTRAINT `struktur_organisasi_ibfk_1` FOREIGN KEY (`id_susunan_organisasi`) REFERENCES `susunan_organisasi` (`id_susunan_organisasi`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `struktur_organisasi_diagram`
--
ALTER TABLE `struktur_organisasi_diagram`
  ADD CONSTRAINT `struktur_organisasi_diagram_id_struktur_organisasi_foreign` FOREIGN KEY (`id_struktur_organisasi`) REFERENCES `struktur_organisasi` (`id_struktur_organisasi`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `struktur_organisasi_slider`
--
ALTER TABLE `struktur_organisasi_slider`
  ADD CONSTRAINT `struktur_organisasi_slider_ibfk_1` FOREIGN KEY (`id_struktur_organisasi`) REFERENCES `struktur_organisasi` (`id_struktur_organisasi`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_pegawai_foreign` FOREIGN KEY (`id_susunan_organisasi`) REFERENCES `susunan_organisasi` (`id_susunan_organisasi`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
