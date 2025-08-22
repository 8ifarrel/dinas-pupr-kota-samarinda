@extends('guest.layouts.sedottinja')

@section('content')
<div class="min-h-screen">

  {{-- Slider/Hero --}}
  <section class="relative">
    <img src="{{ asset('images/sedot-tinja/hero.jpg') }}" class="w-full h-[280px] md:h-[420px] object-cover" alt="Sedot Tinja">
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

  {{-- Struktur Kepengurusan (placeholder) --}}
  <section class="py-10 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
      <h2 class="text-xl font-bold mb-4">Struktur Kepengurusan</h2>
      <img src="{{ asset('images/sedot-tinja/struktur.png') }}" class="rounded-xl border w-full" alt="Struktur">
    </div>
  </section>

  {{-- Tarif --}}
  <section class="py-10 bg-white">
    <div class="max-w-6xl mx-auto px-4">
      <h2 class="text-xl font-bold mb-4">Tarif</h2>
      <div class="overflow-x-auto rounded-xl border">
        <table class="w-full text-sm">
          <thead class="bg-blue-900 text-white">
            <tr>
              <th class="px-4 py-3 text-left">No</th>
              <th class="px-4 py-3 text-left">Wilayah</th>
              <th class="px-4 py-3 text-left">Biaya</th>
            </tr>
          </thead>
          <tbody>
            @foreach([
              ['Rumah','Rp120.000'],
              ['Tempat Ibadah','Rp120.000'],
              ['Panti Asuhan','Rp120.000'],
              ['Hotel','Rp120.000'],
              ['Sekolah','Rp120.000'],
              ['Panti Jompo','Rp120.000'],
              ['Pabrik','Rp120.000'],
              ['Madrasah','Rp120.000'],
              ['Rumah Sakit','Rp120.000'],
              ['Restoran','Rp120.000'],
              ['Kampus','Rp120.000'],
              ['Pondok Pesantren','Rp120.000'],
              ['Kantor','Rp120.000'],
              ['Pukesmas','Rp120.000'],
              ['klinik','Rp120.000'],
              ['Apartemen','Rp120.000'],
              ['Mall','Rp120.000'],
              
            ] as $i => $row)
              <tr class="odd:bg-white even:bg-gray-50">
                <td class="px-4 py-3">{{ $i+1 }}</td>
                <td class="px-4 py-3">{{ $row[0] }}</td>
                <td class="px-4 py-3">{{ $row[1] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="text-center mt-6">
        <a href="{{ route('guest.sedot-tinja.create') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold">
          Mulai Pendaftaran
        </a>
      </div>
    </div>
  </section>

  {{-- Galeri --}}
  <section class="py-10 bg-white">
    <div class="max-w-6xl mx-auto px-4">
      <h2 class="text-xl font-bold mb-4">Galeri Armada</h2>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        @for($i=1;$i<=8;$i++)
          <img src="{{ asset('images/sedot-tinja/galeri-'.$i.'.jpg') }}" class="w-full h-36 object-cover rounded-xl border" alt="galeri">
        @endfor
      </div>
    </div>
  </section>

  {{-- FAQ --}}
  <section id="faq" class="py-10 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
      <h2 class="text-xl font-bold mb-4">FAQ</h2>
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
