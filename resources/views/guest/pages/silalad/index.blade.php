@extends('guest.layouts.main')

@section('document.body')
  {{-- HERO --}}
  <section class="relative min-h-[calc(100vh-148px)] flex flex-col items-center justify-center overflow-hidden py-8 md:py-12">
    <div class="absolute inset-0 z-0 pointer-events-none">
      <img src="{{ asset('storage/galeri-armada/gambar9.jpg') }}" alt="Armada SILALAD"
        class="w-full h-full object-cover opacity-25 blur-[2px]" />
      <div class="absolute inset-0 bg-gradient-to-b from-brand-blue/70 via-white/10 to-white"></div>
    </div>

    <div class="relative z-10 flex flex-col items-center w-full px-4 sm:px-6 md:px-8">
      <div class="text-center">
        <div class="flex justify-center gap-2 mb-3">
          <span class="inline-block bg-brand-yellow text-brand-blue font-bold text-xs sm:text-sm px-3 py-1 rounded-full shadow">
            UPTD Pengelolaan Air Limbah Domestik
          </span>
        </div>
        <h1 class="mb-3 text-3xl sm:text-4xl lg:text-5xl 2xl:text-6xl font-semibold text-brand-blue px-0 sm:px-8 md:px-12 lg:px-24 max-w-[286px] xs:max-w-full mx-auto">
          SILALAD
        </h1>
        <p class="mb-2 text-sm sm:text-base font-semibold text-gray-700 tracking-wide uppercase">
          Sistem Informasi Layanan Limbah Domestik
        </p>
        <p class="mb-6 text-sm sm:text-base lg:max-w-2xl mx-auto text-gray-700">
          Layanan resmi <b>sedot tinja</b> Dinas PUPR Kota Samarinda — aman, higienis, dan bisa dipesan langsung dari rumah.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-3">
          <a href="{{ route('guest.silalad.create') }}"
            class="inline-flex justify-center items-center px-5 py-2.5 text-sm font-semibold text-white rounded-lg bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue shadow-lg transition">
            Daftar Sekarang
            <i class="fa-solid fa-paper-plane ms-1.5"></i>
          </a>
          <a href="{{ route('guest.silalad.status') }}"
            class="inline-flex justify-center items-center px-5 py-2.5 text-sm font-medium text-brand-blue rounded-lg border border-brand-blue hover:bg-brand-blue hover:text-white shadow-lg transition">
            Cek Status Pesanan
            <i class="fa-solid fa-magnifying-glass ms-1.5"></i>
          </a>
          <a href="https://wa.me/6281528231245?text=Halo%20Admin%2C%20saya%20ingin%20bertanya%20mengenai%20layanan%20SILALAD."
            target="_blank"
            class="inline-flex justify-center items-center px-5 py-2.5 text-sm font-medium text-white rounded-lg bg-green-600 hover:bg-green-700 shadow-lg transition">
            Hubungi via WhatsApp
            <i class="fa-brands fa-whatsapp fa-lg ms-1.5"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

  {{-- Statistik --}}
  <section class="py-10 sm:py-14 px-4 sm:px-6 lg:px-16 bg-gray-50">
    <div class="text-center mb-8">
      <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Statistik Pesanan</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-4xl mx-auto">
      <div class="bg-white rounded-lg shadow-lg border p-6 text-center">
        <i class="fa-solid fa-clock text-yellow-500 text-2xl mb-2"></i>
        <p class="text-sm font-medium text-gray-600">Belum Dikerjakan</p>
        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $statistik['belum_dikerjakan'] }}</p>
      </div>
      <div class="bg-white rounded-lg shadow-lg border p-6 text-center">
        <i class="fa-solid fa-truck-fast text-blue-500 text-2xl mb-2"></i>
        <p class="text-sm font-medium text-gray-600">Sedang Dikerjakan</p>
        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $statistik['sedang_dikerjakan'] }}</p>
      </div>
      <div class="bg-white rounded-lg shadow-lg border p-6 text-center">
        <i class="fa-solid fa-circle-check text-green-500 text-2xl mb-2"></i>
        <p class="text-sm font-medium text-gray-600">Sudah Dikerjakan</p>
        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $statistik['sudah_dikerjakan'] }}</p>
      </div>
    </div>
  </section>

  {{-- Struktur Kepengurusan --}}
  <section class="py-10 px-4 bg-white">
    <div class="max-w-3xl mx-auto text-center">
      <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-900">Struktur Kepengurusan</h2>
      <img src="{{ asset('storage/struktur-organisasi/uptd-pengelolaan-air-limbah-domestik/diagram/uptd-pengelolaan-air-limbah-dan-domestik.png') }}"
        class="max-w-full h-auto mx-auto rounded-xl border shadow-lg" alt="Struktur Kepengurusan UPTD PALD">
    </div>
  </section>

  {{-- Tarif --}}
  <section id="keterangan-tarif" class="py-10 sm:py-14 px-4 sm:px-6 lg:px-16 bg-gray-50">
    <div class="max-w-4xl mx-auto">
      <div class="text-center mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Tarif Layanan</h2>
        <p class="text-gray-600 mt-2">Tarif resmi layanan SILALAD UPTD Pengelolaan Air Limbah Domestik.</p>
      </div>

      <div class="bg-white rounded-lg shadow-lg border overflow-x-auto mb-6">
        <table class="w-full text-sm text-center">
          <thead class="bg-brand-blue text-white">
            <tr>
              <th class="px-4 py-3">No</th>
              <th class="px-4 py-3">Jenis Bangunan</th>
              <th class="px-4 py-3">Biaya</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @foreach ([
                ['Pondok Pesantren', 'Rp300.000'], ['Tempat Ibadah', 'Rp300.000'], ['Panti Asuhan', 'Rp300.000'],
                ['Kampus', 'Rp300.000'], ['Madrasah', 'Rp300.000'], ['Sekolah', 'Rp300.000'], ['Panti Jompo', 'Rp300.000'],
                ['Rumah', 'Rp600.000'], ['Hotel', 'Rp600.000'], ['Pabrik', 'Rp600.000'], ['Rumah Sakit', 'Rp600.000'],
                ['Restoran', 'Rp600.000'], ['Kantor', 'Rp600.000'], ['Puskesmas', 'Rp600.000'], ['Klinik', 'Rp600.000'],
                ['Apartemen', 'Rp600.000'], ['Mall', 'Rp600.000'],
            ] as $i => $row)
              <tr class="odd:bg-white even:bg-gray-50">
                <td class="px-4 py-2.5 font-medium text-gray-700">{{ $i + 1 }}</td>
                <td class="px-4 py-2.5 text-gray-700 text-left">{{ $row[0] }}</td>
                <td class="px-4 py-2.5 font-semibold text-green-600">{{ $row[1] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="bg-white rounded-lg shadow-lg border overflow-x-auto mb-4">
        <table class="w-full text-sm text-center">
          <thead class="bg-brand-blue text-white">
            <tr>
              <th class="px-4 py-3">Wilayah</th>
              <th class="px-4 py-3">Normal</th>
              <th class="px-4 py-3">Pengecualian</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="odd:bg-white even:bg-gray-50">
              <td class="px-4 py-2.5">Kota Samarinda</td>
              <td class="px-4 py-2.5">Rp600.000 / rit</td>
              <td class="px-4 py-2.5 font-semibold text-green-600">Rp300.000 / rit</td>
            </tr>
            <tr class="odd:bg-white even:bg-gray-50">
              <td class="px-4 py-2.5">Loa Janan (+Rp100.000)</td>
              <td class="px-4 py-2.5">Rp700.000 / rit</td>
              <td class="px-4 py-2.5 font-semibold text-green-600">Rp400.000 / rit</td>
            </tr>
            <tr class="odd:bg-white even:bg-gray-50">
              <td class="px-4 py-2.5">Palaran (+Rp150.000)</td>
              <td class="px-4 py-2.5">Rp750.000 / rit</td>
              <td class="px-4 py-2.5 font-semibold text-green-600">Rp450.000 / rit</td>
            </tr>
            <tr class="odd:bg-white even:bg-gray-50">
              <td class="px-4 py-2.5">Luar Kota (+Rp525.000)</td>
              <td class="px-4 py-2.5">Rp1.125.000 / rit</td>
              <td class="px-4 py-2.5 font-semibold text-green-600">Rp825.000 / rit</td>
            </tr>
          </tbody>
        </table>
      </div>

      <p class="text-sm text-gray-600 text-center max-w-2xl mx-auto">
        <strong>Keterangan:</strong> Pengecualian berlaku untuk sekolah, rumah ibadah, madrasah, pondok pesantren, dan panti asuhan.
        Biaya tambahan berlaku sesuai wilayah pelayanan.
      </p>

      <div class="text-center mt-8">
        <a href="{{ route('guest.silalad.create') }}"
          class="inline-flex items-center gap-2 px-6 py-3 bg-brand-blue text-white font-bold rounded-lg shadow-lg hover:bg-brand-yellow hover:text-brand-blue transition">
          Mulai Pesanan
          <i class="fa-solid fa-arrow-right"></i>
        </a>
      </div>
    </div>
  </section>

  {{-- Galeri Armada --}}
  <section class="py-10 sm:py-14 px-4 sm:px-6 lg:px-16 bg-white">
    <div class="max-w-5xl mx-auto">
      <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-center text-gray-900">Galeri</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ([
            ['gambar1.jpg', 'Petugas mengambil sampel limbah tinja untuk pemeriksaan kualitas.'],
            ['gambar2.jpg', 'Proses pengambilan limbah tinja menggunakan alat khusus.'],
            ['gambar3.jpg', 'Armada truk tangki kuning sedang beroperasi di lapangan.'],
            ['gambar4.jpg', 'Armada tangki siap melayani penyedotan limbah di area perumahan.'],
            ['gambar5.jpg', 'Proses penyedotan di kantor Dinas PUPR Samarinda.'],
            ['gambar6.jpg', 'Mobil toilet VIP milik Dinas PUPR Kota Samarinda.'],
        ] as [$file, $desc])
          <div class="overflow-hidden rounded-xl shadow-lg border bg-white">
            <img src="{{ asset('storage/galeri-armada/' . $file) }}" alt="{{ $desc }}"
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
  <section id="faq" class="py-10 sm:py-16 px-4 sm:px-6 bg-gray-50">
    <div class="max-w-4xl mx-auto">
      <h2 class="text-2xl sm:text-3xl font-bold mb-8 text-center text-gray-900">FAQ</h2>
      <div class="space-y-4">
        <details class="group rounded-lg border bg-white shadow-lg p-5 transition">
          <summary class="flex items-center justify-between cursor-pointer font-medium text-gray-800">
            Bagaimana proses pendaftaran?
            <i class="fa-solid fa-chevron-right text-sm transition-transform group-open:rotate-90"></i>
          </summary>
          <p class="mt-3 text-gray-600 text-sm leading-relaxed">
            Isi formulir pendaftaran di website, pilih lokasi & jadwal, lalu tim kami akan melakukan verifikasi dan menghubungi Anda untuk konfirmasi.
          </p>
        </details>
        <details class="group rounded-lg border bg-white shadow-lg p-5 transition">
          <summary class="flex items-center justify-between cursor-pointer font-medium text-gray-800">
            Apakah ada biaya tambahan?
            <i class="fa-solid fa-chevron-right text-sm transition-transform group-open:rotate-90"></i>
          </summary>
          <p class="mt-3 text-gray-600 text-sm leading-relaxed">
            Tarif utama sudah tercantum sesuai wilayah dan layanan yang dipilih. Namun, beberapa kondisi tertentu mungkin dikenakan biaya tambahan.
          </p>
        </details>
        <details class="group rounded-lg border bg-white shadow-lg p-5 transition">
          <summary class="flex items-center justify-between cursor-pointer font-medium text-gray-800">
            Berapa lama proses verifikasi?
            <i class="fa-solid fa-chevron-right text-sm transition-transform group-open:rotate-90"></i>
          </summary>
          <p class="mt-3 text-gray-600 text-sm leading-relaxed">
            Proses verifikasi biasanya memakan waktu 1–2 hari kerja setelah Anda mengisi formulir dengan lengkap.
          </p>
        </details>
        <details class="group rounded-lg border bg-white shadow-lg p-5 transition">
          <summary class="flex items-center justify-between cursor-pointer font-medium text-gray-800">
            Bagaimana cara menghubungi layanan pelanggan?
            <i class="fa-solid fa-chevron-right text-sm transition-transform group-open:rotate-90"></i>
          </summary>
          <p class="mt-3 text-gray-600 text-sm leading-relaxed">
            Anda dapat menghubungi tim kami melalui WhatsApp yang tersedia pada halaman ini.
          </p>
        </details>
      </div>
    </div>
  </section>
@endsection
