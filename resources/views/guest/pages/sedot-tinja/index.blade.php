@extends('guest.layouts.sedottinja')

@section('content')
<div class="min-h-screen">

  {{-- Slider/Hero --}}
  <section class="relative">
    <img src="{{ asset('storage/galeri-armada/gambar9.jpg') }}" class="w-full h-[280px] md:h-[420px] object-cover" alt="Sedot Tinja">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="absolute inset-0 flex items-center justify-center">
      <div class="text-center text-white px-4">
        <p class="uppercase tracking-wider text-sm mb-2">UPTD IPAL Domestik</p>
        <h1 class="text-2xl md:text-4xl font-bold mb-3">Layanan Sedot Tinja</h1>
        <p class="max-w-2xl mx-auto opacity-90">Layanan resmi PUPR untuk pengelolaan air limbah domestik yang aman & higienis.</p>
        <a href="{{ route('guest.sedot-tinja.create') }}" class="inline-block mt-5 px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-black font-semibold rounded-xl shadow">
          Daftar Layanan Sekarang
        </a>
      </div>
    </div>
  </section>

  {{-- Informasi Ringkas --}}
  <section class="py-12 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-3 gap-8">
      
      <!-- Card 1 -->
      <div class="p-6 rounded-2xl bg-white shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
        <div class="text-blue-600 text-4xl mb-4">🛡️</div>
        <h3 class="text-lg font-bold mb-2">Legal & Aman</h3>
        <p class="text-sm text-gray-600">Ditangani petugas bersertifikat, armada terstandar.</p>
      </div>

      <!-- Card 2 -->
      <div class="p-6 rounded-2xl bg-white shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
        <div class="text-green-600 text-4xl mb-4">✅</div>
        <h3 class="text-lg font-bold mb-2">Proses Mudah</h3>
        <p class="text-sm text-gray-600">Daftar online, verifikasi, petugas datang sesuai jadwal.</p>
      </div>

      <!-- Card 3 -->
      <div class="p-6 rounded-2xl bg-white shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
        <div class="text-purple-600 text-4xl mb-4">🔍</div>
        <h3 class="text-lg font-bold mb-2">Transparan</h3>
        <p class="text-sm text-gray-600">Informasi tarif & jadwal jelas, tanpa biaya tersembunyi.</p>
      </div>

    </div>
  </section>


  {{-- Struktur Kepengurusan --}}
  <section class="py-8 bg-gray-50">
    <div class="max-w-3xl mx-auto">
      <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">Struktur Kepengurusan</h2>
      <img 
        src="{{ asset('storage/struktur-organisasi/uptd-pengelolaan-air-limbah-domestik/diagram/uptd-pengelolaan-air-limbah-dan-domestik.png') }}" 
        style="width: 400px; height: auto; margin: 0 auto;" 
        class="rounded-xl border block"
        alt="Struktur">
    </div>
  </section>

  {{-- Tarif --}}
  <section class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4">
      <h2 class="text-3xl font-bold mb-2 text-center text-gray-800">Tarif Layanan</h2>
      <p class="text-center text-gray-600 mb-6">
        Tarif resmi layanan sedot tinja UPTD Pengelolaan Air Limbah Domestik.
      </p>

      <div class="overflow-x-auto rounded-2xl shadow-lg border border-gray-200">
        <table class="w-full text-center border-collapse border border-gray-300">
          <thead class="bg-blue-900 text-white sticky top-0">
            <tr>
              <th class="px-3 py-3 text-center border border-gray-300">No</th>
              <th class="px-6 py-3 text-center border border-gray-300">Wilayah</th>
              <th class="px-6 py-3 text-center border border-gray-300">Biaya</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @foreach([
              ['Pondok Pesantren','Rp300.000'],
              ['Tempat Ibadah','Rp300.000'],
              ['Panti Asuhan','Rp300.000'],
              ['Kampus','Rp300.000'],
              ['Madrasah','Rp300.000'],
              ['Sekolah','Rp300.000'],
              ['Panti Jompo','Rp300.000'],
              ['Rumah','Rp600.000'],
              ['Hotel','Rp600.000'],
              ['Pabrik','Rp600.000'],
              ['Rumah Sakit','Rp600.000'],
              ['Restoran','Rp600.000'],
              ['Kantor','Rp600.000'],
              ['Pukesmas','Rp600.000'],
              ['Klinik','Rp600.000'],
              ['Apartemen','Rp600.000'],
              ['Mall','Rp600.000'],
            ] as $i => $row)
              <tr class="odd:bg-white even:bg-gray-50 hover:bg-yellow-100 transition">
                <td class="px-4 py-3 text-center font-medium text-gray-700 border border-gray-300">{{ $i+1 }}</td>
                <td class="px-6 py-3 text-gray-700 border border-gray-300">{{ $row[0] }}</td>
                <td class="px-6 py-3 font-semibold text-green-600 border border-gray-300">{{ $row[1] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>
   
  <!-- Keterangan Tambahan Tarif -->
  <section class="py-10 bg-gradient-to-b from-gray-50 to-gray-100">
    <div class="max-w-4xl mx-auto px-4">
      <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Tambahan Tarif</h2>
      <div class="overflow-hidden rounded-lg shadow-lg">
      <table class="w-full text-sm text-center text-gray-600 border-collapse">
          <thead class="bg-blue-900 text-white sticky top-0">
              <tr>
                  <th scope="col" class="px-6 py-3 border">Lokasi</th>
                  <th scope="col" class="px-6 py-3 border">Normal</th>
                  <th scope="col" class="px-6 py-3 border">Pengecualian (Sekolah, Rumah Ibadah, dll)</th>
              </tr>
          </thead>
          <tbody>
                  <tr class="odd:bg-white even:bg-gray-50 hover:bg-yellow-100 transition">
                  <td class="px-6 py-4 border">Kota Samarinda</td>
                  <td class="px-6 py-4 border">Rp600.000 / rit</td>
                  <td class="px-6 py-4 border text-green-600 font-semibold">Rp300.000 / rit</td>
              </tr>
                  <tr class="odd:bg-white even:bg-gray-50 hover:bg-yellow-100 transition">
                  <td class="px-6 py-4 border">Daerah Loanan (+Rp100.000)</td>
                  <td class="px-6 py-4 border">Rp700.000 / rit</td>
                  <td class="px-6 py-4 border text-green-600 font-semibold">Rp400.000 / rit</td>
              </tr>
                  <tr class="odd:bg-white even:bg-gray-50 hover:bg-yellow-100 transition">
                  <td class="px-6 py-4 border">Daerah Palaran (+Rp150.000)</td>
                  <td class="px-6 py-4 border">Rp750.000 / rit</td>
                  <td class="px-6 py-4 border text-green-600 font-semibold">Rp450.000 / rit</td>
              </tr>
                  <tr class="odd:bg-white even:bg-gray-50 hover:bg-yellow-100 transition">
                  <td class="px-6 py-4 border">Luar Kota (+Rp525.000)</td>
                  <td class="px-6 py-4 border">Rp1.125.000 / rit</td>
                  <td class="px-6 py-4 border text-green-600 font-semibold">Rp825.000 / rit</td>
              </tr>
          </tbody>
      </table>
  </div>

  <p class="mt-2 text-center text-xs text-gray-500 italic">
      *Biaya tambahan sesuai dengan lokasi pelayanan.
  </p>

  {{-- Deskripsi tambahan rapat dengan tabel --}}
  <div class="mt-2 pt-1 text-center">
    <p class="text-sm text-gray-600 leading-relaxed max-w-3xl mx-auto">
      <strong>Keterangan:</strong> Tarif dasar berlaku di wilayah Kota Samarinda dengan biaya 
      <span class="font-semibold">Rp600.000 / rit</span>.  
      Untuk kategori <span class="text-blue-700 font-medium">pengecualian</span> 
      (seperti sekolah, rumah ibadah, madrasah, pondok pesantren, dan panti asuhan) 
      dikenakan biaya khusus sebesar <span class="font-semibold">Rp300.000 / rit</span>.  
      Penambahan tarif berlaku untuk lokasi tertentu (Lojanan, Palaran, dan luar kota) sesuai tabel di atas.
    </p>
  </div>

  {{-- Tombol Mulai Pesanan --}}
<div class="text-center mt-4 mb-6">
  <a href="{{ route('guest.sedot-tinja.create') }}" 
    class="inline-flex items-center gap-3 px-8 py-4 
            bg-blue-600 text-white text-xl font-bold rounded-2xl 
            shadow-lg hover:bg-blue-700 hover:shadow-xl 
            transition duration-300 ease-in-out transform hover:-translate-y-1
            mb-8">
    Mulai Pesanan 
    <span class="text-2xl">→</span>
  </a>
</div>

  {{-- Galeri Armada --}}
  <section class="py-8 bg-gray-50">
    <div class="max-w-5xl mx-auto">
      
      {{-- Judul --}}
      <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Galeri</h2>

      {{-- Grid Galeri --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        
        @foreach([
          ['gambar1.jpg', 'Petugas mengambil sampel limbah tinja untuk pemeriksaan kualitas.'],
          ['gambar2.jpg', 'Proses pengambilan limbah tinja menggunakan alat khusus.'],
          ['gambar3.jpg', 'Armada truk tangki kuning sedang beroperasi di lapangan.'],
          ['gambar4.jpg', 'Armada tangki siap melayani penyedotan limbah di area perumahan.'],
          ['gambar5.jpg', 'Armada tangki digunakan untuk pelayanan di gedung perkantoran.'],
          ['gambar6.jpg', 'Mobil toilet VIP milik Dinas PUPR Kota Samarinda.'],
        ] as [$file, $desc])
          <div class="overflow-hidden rounded-xl shadow-md bg-white">
            <img src="{{ asset('storage/galeri-armada/' . $file) }}" 
                alt="{{ $desc }}" 
                class="w-full h-60 object-cover hover:scale-105 transition-transform duration-300">
            <div class="p-4 text-center border-t">
              <p class="text-sm text-gray-700">{{ $desc }}</p>
            </div>
          </div>
        @endforeach

      </div>
    </div>
  </section>

  {{-- FAQ --}}
  <section id="faq" class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-6">
      <h2 class="text-3xl font-bold mb-8 text-center text-gray-800">FAQ</h2>
      <div class="space-y-4">
        
        <details class="group rounded-2xl border bg-white shadow-sm p-5 transition">
          <summary class="flex items-center justify-between cursor-pointer font-medium text-gray-800">
            Bagaimana proses pendaftaran?
            <span class="transition-transform group-open:rotate-90">▶</span>
          </summary>
          <p class="mt-3 text-gray-600 text-sm leading-relaxed">
            Isi formulir pendaftaran di website, pilih lokasi & jadwal, lalu tim kami akan melakukan verifikasi dan menghubungi Anda untuk konfirmasi.
          </p>
        </details>

        <details class="group rounded-2xl border bg-white shadow-sm p-5 transition">
          <summary class="flex items-center justify-between cursor-pointer font-medium text-gray-800">
            Apakah ada biaya tambahan?
            <span class="transition-transform group-open:rotate-90">▶</span>
          </summary>
          <p class="mt-3 text-gray-600 text-sm leading-relaxed">
            Tarif utama sudah tercantum sesuai wilayah dan layanan yang dipilih. Namun, beberapa kondisi tertentu mungkin dikenakan biaya tambahan.          </p>
        </details>

        <details class="group rounded-2xl border bg-white shadow-sm p-5 transition">
          <summary class="flex items-center justify-between cursor-pointer font-medium text-gray-800">
            Berapa lama proses verifikasi?
            <span class="transition-transform group-open:rotate-90">▶</span>
          </summary>
          <p class="mt-3 text-gray-600 text-sm leading-relaxed">
            Proses verifikasi biasanya memakan waktu 1–2 hari kerja setelah Anda mengisi formulir dengan lengkap.
          </p>
        </details>

        <details class="group rounded-2xl border bg-white shadow-sm p-5 transition">
          <summary class="flex items-center justify-between cursor-pointer font-medium text-gray-800">
            Apakah bisa membatalkan pendaftaran?
            <span class="transition-transform group-open:rotate-90">▶</span>
          </summary>
          <p class="mt-3 text-gray-600 text-sm leading-relaxed">
            Bisa, Anda dapat membatalkan pendaftaran sebelum proses verifikasi selesai tanpa dikenakan biaya apapun.
          </p>
        </details>

        <details class="group rounded-2xl border bg-white shadow-sm p-5 transition">
          <summary class="flex items-center justify-between cursor-pointer font-medium text-gray-800">
            Bagaimana cara menghubungi layanan pelanggan?
            <span class="transition-transform group-open:rotate-90">▶</span>
          </summary>
          <p class="mt-3 text-gray-600 text-sm leading-relaxed">
            Anda dapat menghubungi tim kami melalui email, WhatsApp, atau telepon yang tersedia di halaman <strong>Kontak</strong>.
          </p>
        </details>

    </div>
  </div>
</section>
</div>
@endsection