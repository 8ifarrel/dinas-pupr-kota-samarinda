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
  <section class="py-10 bg-white">
    <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-3 gap-6">
      <div class="p-5 rounded-2xl border">
        <h3 class="font-semibold mb-1">Legal & Aman</h3>
        <p class="text-sm text-gray-600">Ditangani petugas bersertifikat, armada terstandar.</p>
      </div>
      <div class="p-5 rounded-2xl border">
        <h3 class="font-semibold mb-1">Proses Mudah</h3>
        <p class="text-sm text-gray-600">Daftar online, verifikasi, petugas datang sesuai jadwal.</p>
      </div>
      <div class="p-5 rounded-2xl border">
        <h3 class="font-semibold mb-1">Transparan</h3>
        <p class="text-sm text-gray-600">Informasi tarif & jadwal jelas, tanpa biaya tersembunyi.</p>
      </div>
    </div>
  </section>

  {{-- Struktur Kepengurusan --}}
  <section class="py-8 bg-gray-50">
    <div class="max-w-3xl mx-auto">
      <h2 class="text-2xl font-bold mb-8 text-center text-gray-800">Struktur Kepengurusan</h2>
      <img 
        src="{{ asset('storage/struktur-organisasi/uptd-pengelolaan-air-limbah-domestik/diagram/uptd-pengelolaan-air-limbah-dan-domestik.png') }}" 
        style="width: 400px; height: auto; margin: 0 auto;" 
        class="rounded-xl border block"
        alt="Struktur">
    </div>
  </section>

  {{-- Tarif --}}
  <section class="py-8 bg-gray-50">
    <div class="max-w-3xl mx-auto">
      <h2 class="text-2xl font-bold mb-8 text-center text-gray-800">Tarif</h2>
      <div class="overflow-x-auto rounded-xl border">
        <table class="w-full text-sm border border-gray-300">
          <thead class="bg-blue-900 text-white">
            <tr>
              <th class="px-2 py-3 text-center border border-gray-300 w-12">No</th>
              <th class="px-4 py-3 text-left border border-gray-300">Wilayah</th>
              <th class="px-4 py-3 text-left border border-gray-300">Biaya</th>
            </tr>
          </thead>
          <tbody>
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
              <tr class="odd:bg-white even:bg-gray-50">
                <td class="px-4 py-3 border border-gray-300">{{ $i+1 }}</td>
                <td class="px-4 py-3 border border-gray-300">{{ $row[0] }}</td>
                <td class="px-4 py-3 border border-gray-300">{{ $row[1] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>
   
  <!-- Keterangan Tambahan Tarif -->
  <section class="py-8 bg-gray-50">
    <div class="max-w-3xl mx-auto">
      <h2 class="text-2xl font-bold mb-8 text-center text-gray-800">Tambahan Tarif</h2>
      <div class="overflow-x-auto rounded-xl border border-gray-300">
        <table class="w-full text-sm border-collapse">
          <thead class="bg-blue-900 text-white">
            <tr>
              <th class="px-4 py-3 border border-gray-300">Lokasi</th>
              <th class="px-4 py-3 border border-gray-300">Normal</th>
              <th class="px-4 py-3 border border-gray-300">Pengecualian 
                <br>(Sekolah, Rumah Ibadah, dll)</th>
            </tr>
          </thead>
          <tbody>
            <tr class="odd:bg-white even:bg-gray-50">
              <td class="px-4 py-3 border border-gray-300">Kota Samarinda</td>
              <td class="px-4 py-3 border border-gray-300">Rp600.000 / rit</td>
              <td class="px-4 py-3 border border-gray-200 bg-blue-50 text-blue-900 font-semibold">Rp300.000 / rit</td>
            </tr>
            <tr class="odd:bg-white even:bg-gray-50">
              <td class="px-4 py-3 border border-gray-300">Daerah Lojanan (+Rp100.000)</td>
              <td class="px-4 py-3 border border-gray-300">Rp700.000 / rit</td>
              <td class="px-4 py-3 border border-gray-200 bg-blue-50 text-blue-900 font-semibold">Rp400.000 / rit</td>
            </tr>
            <tr class="odd:bg-white even:bg-gray-50">
              <td class="px-4 py-3 border border-gray-300">Daerah Palaran (+Rp150.000)</td>
              <td class="px-4 py-3 border border-gray-300">Rp750.000 / rit</td>
              <td class="px-4 py-3 border border-gray-200 bg-blue-50 text-blue-900 font-semibold">Rp450.000 / rit</td>
            </tr>
            <tr class="odd:bg-white even:bg-gray-50">
              <td class="px-4 py-3 border border-gray-300">Luar Kota (+Rp525.000)</td>
              <td class="px-4 py-3 border border-gray-300">Rp1.125.000 / rit</td>
              <td class="px-4 py-3 border border-gray-200 bg-blue-50 text-blue-900 font-semibold">Rp825.000 / rit</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  {{-- Deskripsi tambahan rapat dengan tabel --}}
  <div class="mt-0 pt-1 text-center">
    <p class="text-gray-600 text-sm leading-relaxed max-w-3xl mx-auto">
      <strong>Keterangan:</strong> Tarif dasar berlaku di wilayah Kota Samarinda dengan biaya 
      <span class="font-semibold">Rp600.000 / rit</span>.  
      Untuk kategori <span class="text-blue-700 font-medium">pengecualian</span> 
      (seperti sekolah, rumah ibadah, madrasah, pondok pesantren, dan panti asuhan) 
      dikenakan biaya khusus sebesar <span class="font-semibold">Rp300.000 / rit</span>.  
      Penambahan tarif berlaku untuk lokasi tertentu (Lojanan, Palaran, dan luar kota) sesuai tabel di atas.
    </p>
  </div>

  <div class="text-center mt-6">
    <a href="{{ route('guest.sedot-tinja.create') }}" 
      class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition duration-300">
      Mulai Pendaftaran 
    <span class="text-xl">→</span>
    </a>
  </div>

  {{-- Galeri Armada --}}
  <section class="py-8 bg-gray-50">
    <div class="max-w-3xl mx-auto">
      
      {{-- Judul --}}
      <h2 class="text-2xl font-bold mb-8 text-center text-gray-800">Galeri</h2>

      {{-- Grid Galeri --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        
        @foreach([
          ['gambar1.jpg', 'Armada 1'],
          ['gambar2.jpg', 'Armada 2'],
          ['gambar3.jpg', 'Armada 3'],
          ['gambar4.jpg', 'Armada 4'],
          ['gambar5.jpg', 'Armada 5'],
          ['gambar6.jpg', 'Armada 6'],
        ] as [$file, $caption])
          <div class="overflow-hidden rounded-xl shadow-md bg-white">
            <img src="{{ asset('storage/galeri-armada/' . $file) }}" 
                alt="{{ $caption }}" 
                class="w-full h-60 object-cover hover:scale-105 transition-transform duration-300">
            <div class="p-3 text-center">
              <p class="text-sm text-gray-700 font-medium">{{ $caption }}</p>
            </div>
          </div>
        @endforeach

      </div>
    </div>
  </section>

  {{-- FAQ --}}
  <section id="faq" class="py-10 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
      <h2 class="text-2xl font-bold mb-8 text-center text-gray-800">Faq</h2>
      <div class="space-y-3">
        <details class="rounded-xl border p-4 bg-white">
          <summary class="font-medium cursor-pointer">Bagaimana proses pendaftaran?</summary>
          <div class="mt-2 text-sm text-gray-600">Isi formulir, pilih lokasi & jadwal, kami verifikasi & tindaklanjuti.</div>
        </details>
        <details class="rounded-xl border p-4 bg-white">
          <summary class="font-medium cursor-pointer">Apakah ada biaya tambahan?</summary>
          <div class="mt-2 text-sm text-gray-600">Tidak, semua tarif sudah tercantum sesuai wilayah.</div>
        </details>
      </div>
    </div>
  </section>

</div>
@endsection
