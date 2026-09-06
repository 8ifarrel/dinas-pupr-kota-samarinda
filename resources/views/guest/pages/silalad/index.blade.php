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

  {{-- Tarif --}}
  <section id="keterangan-tarif" class="py-10 sm:py-14 px-4 sm:px-6 lg:px-16 bg-white">
    <div class="max-w-5xl mx-auto">
      <div class="text-center mb-8">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Tarif Layanan</h2>
        <p class="text-gray-600 mt-2">Tarif resmi layanan SILALAD UPTD Pengelolaan Air Limbah Domestik.</p>
      </div>

      {{-- Kartu tarif per jenis bangunan --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
        <div class="relative bg-white rounded-2xl shadow-lg border-2 border-brand-yellow overflow-hidden">
          <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full bg-brand-yellow/20"></div>
          <div class="relative p-6">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1">Tarif</p>
            <p class="text-2xl font-bold text-brand-blue">Rp300.000<span class="text-sm font-medium text-gray-500"> / rit</span></p>
            <p class="text-sm text-gray-600 mt-2 mb-3">untuk bangunan:</p>
            <div class="flex flex-wrap gap-2">
              @foreach (['Pondok Pesantren', 'Tempat Ibadah', 'Panti Asuhan', 'Kampus', 'Madrasah', 'Sekolah', 'Panti Jompo'] as $item)
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">{{ $item }}</span>
              @endforeach
            </div>
          </div>
        </div>

        <div class="relative bg-white rounded-2xl shadow-lg border-2 border-brand-blue overflow-hidden">
          <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full bg-brand-blue/10"></div>
          <div class="relative p-6">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1">Tarif</p>
            <p class="text-2xl font-bold text-brand-blue">Rp600.000<span class="text-sm font-medium text-gray-500"> / rit</span></p>
            <p class="text-sm text-gray-600 mt-2 mb-3">untuk bangunan:</p>
            <div class="flex flex-wrap gap-2">
              @foreach (['Rumah', 'Hotel', 'Pabrik', 'Rumah Sakit', 'Restoran', 'Kantor', 'Puskesmas', 'Klinik', 'Apartemen', 'Mall'] as $item)
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">{{ $item }}</span>
              @endforeach
            </div>
          </div>
        </div>
      </div>

      {{-- Kartu tarif per wilayah --}}
      <div class="mb-6">
        <h3 class="text-center text-sm font-semibold uppercase tracking-wide text-gray-500 mb-4">Tambahan Biaya Berdasarkan Wilayah</h3>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
          @foreach ([
              ['Kota Samarinda', '600.000', '300.000'],
              ['Loa Janan', '700.000', '400.000'],
              ['Palaran', '750.000', '450.000'],
              ['Luar Kota', '1.125.000', '825.000'],
          ] as [$wilayah, $normal, $diskon])
            <div class="bg-white rounded-xl shadow-lg border p-4 text-center">
              <i class="fa-solid fa-location-dot text-brand-blue mb-2"></i>
              <p class="text-sm font-semibold text-gray-800 mb-2">{{ $wilayah }}</p>
              <p class="text-lg font-bold text-brand-blue">Rp{{ $normal }} <span class="text-xs font-medium text-gray-500">/ rit</span></p>
              <p class="text-xs text-gray-500 mt-1">Rp{{ $diskon }} untuk pengecualian</p>
            </div>
          @endforeach
        </div>
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

  {{-- Statistik --}}
  @php
    $totalPesanan = $statistik['belum_dikerjakan'] + $statistik['sedang_dikerjakan'] + $statistik['sudah_dikerjakan'];
    $pct = fn ($n) => $totalPesanan > 0 ? round($n / $totalPesanan * 100) : 0;
  @endphp
  <section class="py-10 sm:py-14 px-4 sm:px-6 lg:px-16 bg-gray-200">
    <div class="text-center mb-8">
      <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Statistik Pesanan</h2>
      <p class="text-gray-600 mt-2">Total <span class="font-semibold text-brand-blue">{{ $totalPesanan }}</span> pesanan tercatat sejauh ini.</p>
    </div>

    <div class="max-w-4xl mx-auto">
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
        <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden">
          <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full bg-yellow-100"></div>
          <div class="relative p-6">
            <span class="flex items-center justify-center w-11 h-11 rounded-full bg-yellow-100 text-yellow-600 mb-3">
              <i class="fa-solid fa-clock text-lg"></i>
            </span>
            <p class="text-4xl font-extrabold text-gray-900">{{ $statistik['belum_dikerjakan'] }}</p>
            <p class="text-sm font-medium text-gray-600 mt-1">Belum Dikerjakan</p>
          </div>
        </div>
        <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden">
          <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full bg-blue-100"></div>
          <div class="relative p-6">
            <span class="flex items-center justify-center w-11 h-11 rounded-full bg-blue-100 text-blue-600 mb-3">
              <i class="fa-solid fa-truck-fast text-lg"></i>
            </span>
            <p class="text-4xl font-extrabold text-gray-900">{{ $statistik['sedang_dikerjakan'] }}</p>
            <p class="text-sm font-medium text-gray-600 mt-1">Sedang Dikerjakan</p>
          </div>
        </div>
        <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden">
          <div class="absolute -top-6 -right-6 w-24 h-24 rounded-full bg-green-100"></div>
          <div class="relative p-6">
            <span class="flex items-center justify-center w-11 h-11 rounded-full bg-green-100 text-green-600 mb-3">
              <i class="fa-solid fa-circle-check text-lg"></i>
            </span>
            <p class="text-4xl font-extrabold text-gray-900">{{ $statistik['sudah_dikerjakan'] }}</p>
            <p class="text-sm font-medium text-gray-600 mt-1">Sudah Dikerjakan</p>
          </div>
        </div>
      </div>

      @if ($totalPesanan > 0)
        <div class="flex h-3 w-full rounded-full overflow-hidden shadow-inner">
          <div class="bg-yellow-400" style="width: {{ $pct($statistik['belum_dikerjakan']) }}%"></div>
          <div class="bg-blue-500" style="width: {{ $pct($statistik['sedang_dikerjakan']) }}%"></div>
          <div class="bg-green-500" style="width: {{ $pct($statistik['sudah_dikerjakan']) }}%"></div>
        </div>
        <div class="flex justify-center gap-6 mt-3 text-xs text-gray-600">
          <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-yellow-400"></span>Belum ({{ $pct($statistik['belum_dikerjakan']) }}%)</span>
          <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>Sedang ({{ $pct($statistik['sedang_dikerjakan']) }}%)</span>
          <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>Sudah ({{ $pct($statistik['sudah_dikerjakan']) }}%)</span>
        </div>
      @endif
    </div>
  </section>

  {{-- Tanya Jawab --}}
  <section id="faq" class="py-10 sm:py-16 px-4 sm:px-6 bg-white">
    <div class="max-w-4xl mx-auto">
      <h2 class="text-2xl sm:text-3xl font-bold mb-8 text-center text-gray-900">Pertanyaan yang Sering Diajukan</h2>
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
            Apakah bisa membatalkan pendaftaran?
            <i class="fa-solid fa-chevron-right text-sm transition-transform group-open:rotate-90"></i>
          </summary>
          <p class="mt-3 text-gray-600 text-sm leading-relaxed">
            Bisa, Anda dapat membatalkan pendaftaran sebelum proses verifikasi selesai tanpa dikenakan biaya apapun.
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
