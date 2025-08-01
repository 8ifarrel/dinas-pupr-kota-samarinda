@extends('admin.layout')

@section('document.head')
@endsection

@section('document.body')
  <div class="bg-white p-6 md:p-8 rounded-xl shadow-xl">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
      <div class="lg:col-span-2">
        <div class="flex justify-between mb-4 text-gray-500">
          <span>ID Laporan: <strong>1</strong></span>
          <span class="text-gray-600">Diajukan pada <strong>12 Juni 2024 14:30</strong></span>
          {{-- TODO: Ganti dengan $laporan->id_laporan dan $laporan->created_at --}}
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-3">Jl. Dummy Raya No. 123</h2>
        <p class="text-base text-gray-600 mb-5 leading-relaxed">
          RT 02 Kelurahan Dummy, Kecamatan Contoh
          {{-- TODO: Ganti dengan alamat lengkap, RT, kelurahan, kecamatan --}}
        </p>

        <div class="mb-6">
          <a href="https://maps.google.com/?q=-0.502106,117.153709" target="_blank"
            class="inline-flex items-center px-4 py-2 text-blue-600 bg-blue-50 border border-blue-300 rounded-lg shadow-sm hover:bg-blue-100 transition duration-200 ease-in-out transform hover:-translate-y-0.5">
            <i class="fas fa-map-marked-alt mr-3 text-lg"></i>
            <span class="font-semibold">Lihat Lokasi di Google Maps</span>
          </a>
          {{-- TODO: Ganti href dengan $laporan->link_koordinat --}}
        </div>

        <div class="mb-8">
          <h4 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Deskripsi Laporan</h4>
          <p class="text-gray-700 mb-8 bg-gray-50 p-4 rounded-lg leading-relaxed">Jalan berlubang cukup dalam dan
            membahayakan pengendara.</p>
          {{-- TODO: Ganti dengan $laporan->deskripsi_laporan --}}
        </div>

        <div class="mb-8">
          <h4 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Foto Kerusakan</h4>
          <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
            <a href="https://via.placeholder.com/600x400" target="_blank" title="Lihat Gambar Penuh">
              <img src="https://via.placeholder.com/150x100" alt="Foto Kerusakan"
                class="w-full h-[100px] object-cover rounded-md border border-gray-200 transition-transform duration-200 ease-in-out hover:scale-105 hover:shadow-md" />
            </a>
            <a href="https://via.placeholder.com/600x400" target="_blank" title="Lihat Gambar Penuh">
              <img src="https://via.placeholder.com/150x100" alt="Foto Kerusakan"
                class="w-full h-[100px] object-cover rounded-md border border-gray-200 transition-transform duration-200 ease-in-out hover:scale-105 hover:shadow-md" />
            </a>
            {{-- TODO: Loop $fotoArray --}}
          </div>
        </div>

        <div class="mb-8">
          <h4 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Lokasi Peta</h4>
          <div class="mb-8">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1275.123456789!2d117.153709!3d-0.502106!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2z0LrQsNC30LAg0JrQvtC80L7QvNCw!5e0!3m2!1sid!2sid!4v1620000000000!5m2!1sid!2sid"
              allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
              class="w-full h-[300px] border-0 rounded-lg"></iframe>
          </div>
          {{-- TODO: Ganti src dengan $embedUrl --}}
        </div>
      </div>

      <div class="lg:col-span-1">
        <div class="bg-gray-50 border border-gray-200 p-6 rounded-xl sticky top-[80px]">
          <h4 class="text-lg font-semibold text-gray-800 mb-5 text-center border-b border-gray-200 pb-2">Info Laporan
          </h4>

          <div class="text-center mb-6">
            <span
              class="inline-flex items-center font-semibold rounded-full px-5 py-2 bg-yellow-100 text-yellow-800 text-base">
              <i class="fas fa-hourglass-half mr-2 text-base"></i>
              <span class="font-medium">Pending</span>
            </span>
            {{-- TODO: Ganti badge dan status sesuai $laporan->status --}}
          </div>

          <div class="text-sm text-gray-600 space-y-4">
            <div class="mb-3">
              <p><strong class="block mb-1 text-gray-700">Tingkat Kerusakan</strong>Ringan</p>
              {{-- TODO: Ganti dengan $laporan->tingkat_kerusakan --}}
            </div>
            <div class="mb-3">
              <p><strong class="block mb-1 text-gray-700">Jenis Kerusakan</strong>Berlubang</p>
              {{-- TODO: Ganti dengan $laporan->jenis_kerusakan --}}
            </div>

            <div class="pt-4 border-t border-gray-200">
              <p class="font-semibold text-gray-700 mb-1.5">Keterangan Disposisi:</p>
              <p class="bg-purple-50 text-purple-700 italic p-3 rounded-md mt-2">Belum ada keterangan.</p>
              {{-- TODO: Tampilkan jika ada $laporan->keterangan --}}
            </div>

            <div class="pt-4 border-t border-gray-200">
              <p class="font-semibold text-gray-700 mb-1.5">Feedback Pelapor:</p>
              <p class="italic text-gray-700">Terima kasih sudah menindaklanjuti.</p>
              {{-- TODO: Tampilkan jika ada $laporan->feedback --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white p-6 md:p-8 rounded-xl shadow-xl mt-8">
    <h3 class="text-xl font-bold text-gray-800 mb-5 flex items-center">
      <i class="fas fa-network-wired mr-3 text-xl text-gray-600"></i>
      Riwayat IP Laporan Ini
    </h3>

    <div class="overflow-x-auto rounded-lg shadow-md">
      <table class="min-w-full leading-normal rounded-lg overflow-hidden">
        <thead class="bg-gray-50">
          <tr>
            <th class="text-left text-xs font-medium text-gray-500 uppercase px-4 py-3">IP Address</th>
            <th class="text-left text-xs font-medium text-gray-500 uppercase px-4 py-3">Lokasi</th>
            <th class="text-left text-xs font-medium text-gray-500 uppercase px-4 py-3">Waktu</th>
            <th class="text-left text-xs font-medium text-gray-500 uppercase px-4 py-3">Latitude</th>
            <th class="text-left text-xs font-medium text-gray-500 uppercase px-4 py-3">Longitude</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr>
            <td class="font-mono text-sm px-4 py-3 whitespace-nowrap">192.168.1.1</td>
            <td class="text-sm text-gray-600 px-4 py-3">Samarinda, Kalimantan Timur</td>
            <td class="text-sm px-4 py-3 whitespace-nowrap">12/06/2024 14:30</td>
            <td class="text-sm px-4 py-3">-0.502106</td>
            <td class="text-sm px-4 py-3">117.153709</td>
          </tr>
          <tr>
            <td class="font-mono text-sm px-4 py-3 whitespace-nowrap">192.168.1.2</td>
            <td class="text-sm text-gray-600 px-4 py-3">Tidak diketahui</td>
            <td class="text-sm px-4 py-3 whitespace-nowrap">12/06/2024 13:00</td>
            <td class="text-sm px-4 py-3">-</td>
            <td class="text-sm px-4 py-3">-</td>
          </tr>
          {{-- TODO: Loop $ipLogs --}}
        </tbody>
      </table>
    </div>
    {{-- TODO: Tampilkan pesan jika tidak ada data --}}
  </div>
@endsection

@section('document.end')
@endsection
