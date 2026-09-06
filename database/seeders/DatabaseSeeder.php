<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Urutan pemanggilan seeder mengikuti ketergantungan antar tabel.
 * Memindahkan sebuah seeder ke atas ketergantungannya akan membuat relasinya
 * kosong atau melanggar foreign key.
 */
class DatabaseSeeder extends Seeder
{
  public function run(): void
  {
    $this->call([
      // 1. Susunan organisasi jadi acuan hampir seluruh tabel lain
      //    (struktur, kategori berita, akun admin).
      SusunanOrganisasiSeeder::class,
      StrukturOrganisasiSeeder::class,
      StrukturOrganisasiDiagramSeeder::class,
      StrukturOrganisasiSliderSeeder::class,

      // 2. Profil kepala dinas beserta riwayatnya (mengacu susunan organisasi).
      KepalaDinasSeeder::class,
      KepalaDinasRiwayatPendidikanSeeder::class,
      KepalaDinasJenjangKarirSeeder::class,

      // 3. Halaman profil yang berdiri sendiri.
      VisiSeeder::class,
      MisiSeeder::class,
      TupoksiSeeder::class,
      SejarahDinasPUPRKotaSamarindaSeeder::class,

      // 4. Wilayah: kelurahan mengacu kecamatan, akun kelurahan mengacu kelurahan.
      KecamatanSeeder::class,
      KelurahanSeeder::class,
      UsersKelurahanSeeder::class,

      // 5. Berita: kategori dulu, lalu berita, lalu foto pendukungnya.
      BeritaKategoriSeeder::class,
      BeritaSeeder::class,
      BeritaFotoTambahanSeeder::class,

      // 6. Informasi publik lainnya.
      PengumumanSeeder::class,
      PPIDPelaksanaKategoriSeeder::class,
      PPIDPelaksanaSeeder::class,
      AgendaKegiatanSeeder::class,

      // 7. Galeri: album dulu karena nama berkas foto memakai slug album.
      AlbumKegiatanSeeder::class,
      FotoKegiatanSeeder::class,

      // 8. Elemen beranda.
      SliderSeeder::class,
      PartnerSeeder::class,

      // 9. Layanan publik. Layanan mengacu struktur organisasi, SKM mengacu layanan.
      LayananSeeder::class,
      SKMSeeder::class,

      // 10. Akun panel admin. Kunci API mengacu id super admin, jadi harus setelah UsersSeeder.
      UsersSeeder::class,
      JalanPeduliApiKeySeeder::class,
      HantuBanyuApiKeySeeder::class,
      KelurahanApiKeySeeder::class,

      // 11. Statistik pengunjung; page_visits mengacu visitor_id pada tabel visitors.
      VisitorsSeeder::class,
      PageVisitsSeeder::class,

      // 12. Hantu Banyu mengacu kelurahan/kecamatan dan SKM.
      HantuBanyuSeeder::class,

      // 13. SILALAD, tabel berdiri sendiri tanpa foreign key.
      SilaladSeeder::class,

      // 14. Jalan Peduli (dikelola terpisah) sengaja ditempatkan paling akhir.
      //     JalanPeduliLaporanSeeder mengunduh gambar dari picsum.photos saat
      //     dijalankan, sehingga gagal bila tidak ada koneksi internet. Dengan
      //     menaruhnya di urutan terakhir, kegagalan itu tidak lagi memutus
      //     seeder lain yang sudah selesai lebih dulu.
      JalanPeduliStatusSeeder::class,
      JalanPeduliPelaporSeeder::class,
      JalanPeduliLaporanSeeder::class,
    ]);
  }
}
