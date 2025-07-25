@extends('guest.layouts.buku-tamu')

@section('document.head')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('document.body')
  <main>
    <hgroup class="flex flex-col items-center text-center py-5">
      <h1 class="text-3xl font-bold">Buku Tamu</h1>
      <p class="text-lg font-medium">Dinas PUPR Kota Samarinda</p>
    </hgroup>

    <hr class="w-full border-gray-700">

    {{-- Progress bar --}}
    <section class="flex flex-col items-center p-4">
      <h2 class="text-2xl font-semibold">Status Kunjungan</h2>

      <ol class="relative my-4">
        {{-- Progress 1 --}}
        <li>
          <span
            class="absolute flex items-center justify-center w-8 h-8 {{ $buku_tamu->status === 'Pending' || $buku_tamu->status === 'Diterima' || $buku_tamu->status === 'Ditolak' ? 'bg-green-400' : 'bg-gray-400' }} rounded-full">
            <i class="fa-solid fa-check text-white"></i>
          </span>
          <p class="ms-10 font-medium leading-8">Terajukan</p>
          <hr
            class="h-10 w-1 translate-x-[14px] {{ $buku_tamu->status === 'Pending' ? 'bg-yellow-300' : 'bg-green-400' }}">
        </li>

        {{-- Progress 2 --}}
        <li>
          <span
            class="absolute flex items-center justify-center w-8 h-8 {{ $buku_tamu->status === 'Pending' ? 'bg-yellow-300' : ($buku_tamu->status === 'Diterima' ? 'bg-green-400' : 'bg-green-400') }} rounded-full">
            <i
              class="{{ $buku_tamu->status === 'Pending' ? 'fa-solid fa-hourglass-half' : 'fa-solid fa-check' }} text-white"></i>
          </span>
          <p class="ms-10 font-medium leading-8">{{ $buku_tamu->status === 'Pending' ? 'Pending' : 'Selesai' }}</p>
          <hr
            class="h-10 w-1 translate-x-[14px] {{ $buku_tamu->status === 'Pending' ? 'bg-gray-400' : ($buku_tamu->status === 'Diterima' ? 'bg-green-400' : 'bg-red-500') }}">
        </li>

        {{-- Progress 3 --}}
        <li>
          <span
            class="absolute flex items-center justify-center w-8 h-8 {{ $buku_tamu->status === 'Diterima' ? 'bg-green-400' : ($buku_tamu->status === 'Ditolak' ? 'bg-red-500' : 'bg-gray-400') }} rounded-full">
            <i
              class="{{ $buku_tamu->status === 'Diterima' ? 'fa-solid fa-check' : ($buku_tamu->status === 'Ditolak' ? 'fa-solid fa-xmark' : 'fa-solid fa-hourglass-half') }} text-white"></i>
          </span>
          <p class="ms-10 font-medium leading-8">
            {{ $buku_tamu->status === 'Diterima' ? 'Diterima' : ($buku_tamu->status === 'Ditolak' ? 'Ditolak' : 'Pending') }}
          </p>
        </li>
      </ol>

      {{-- Tombol Refresh --}}
      @if ($buku_tamu->status === 'Pending')
        <a href="#" onclick="window.location.reload();"
          class="text-white bg-brand-blue hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-4 py-2 text-center me-2 mb-2">
          Refresh Halaman
        </a>
      @endif

      {{-- Pesan Berdasarkan Status --}}
      <p class="text-center">
        @if ($buku_tamu->status === 'Pending')
          Harap untuk <strong>memantau status kunjungan</strong> Anda secara berkala dengan <strong>menekan tombol Refresh
            Halaman</strong>.
        @elseif ($buku_tamu->status === 'Diterima')
          Kunjungan Anda <strong>diterima</strong>. Silakan datang ke kantor untuk melanjutkan proses kunjungan.
        @else
          Kunjungan Anda <strong>ditolak</strong>. Kami mohon maaf atas ketidaknyamanan ini. Silakan ajukan kunjungan di lain waktu.
        @endif
      </p>
    </section>

    <hr class="w-full border-gray-700">

    {{-- Deskripsi Status --}}
    <section class="flex flex-col items-center p-4">
      <h2 class="text-2xl font-semibold mb-4 text-center">
        Deskripsi Status
      </h2>

      <p class="text-start">
        {{ $buku_tamu->deskripsi_status ?? "Permintaan kunjungan sedang diproses" }}
      </p>
    </section>

    <hr class="w-full border-gray-700">

    <section class="p-4">
      <h2 class="text-2xl font-semibold mb-4 text-center">Detail Tamu</h2>
      <table class="border-separate border-spacing-1.5">
        {{-- ID --}}
        <tr>
          <td class=" text-end max-w-[200px] pe-2 font-bold">Kode</td>
          <td>{{ $buku_tamu->id_buku_tamu }}</td>
        </tr>
        {{-- Nama --}}
        <tr>
          <td class=" text-end max-w-[200px] pe-2 font-bold">Nama Tamu</td>
          <td>{{ $buku_tamu->nama_pengunjung }}</td>
        </tr>
        {{-- Email --}}
        <tr>
          <td class=" text-end max-w-[200px] pe-2 font-bold">Email Tamu</td>
          <td>{{ $buku_tamu->email }}</td>
        </tr>
        {{-- Alamat --}}
        <tr>
          <td class=" text-end max-w-[200px] pe-2 font-bold">Alamat Asal Tamu</td>
          <td>{{ $buku_tamu->alamat }}</td>
        </tr>
        {{-- Jabatan --}}
        <tr>
          <td class=" text-end max-w-[200px] pe-2 font-bold">Bagian yang Dikunjungi</td>
          <td>{{ $buku_tamu->susunanOrganisasi->nama_susunan_organisasi }}</td>
        </tr>
        {{-- Maksud --}}
        <tr>
          <td class=" text-end max-w-[200px] pe-2 font-bold">Keperluan Kunjungan</td>
          <td>{{ $buku_tamu->maksud_dan_tujuan }}</td>
        </tr>
      </table>
    </section>
  </main>

  <hr class="w-full border-gray-700">

  <footer class="flex flex-col items-center pt-5 px-5">
    <p class="text-center text-sm">
      © 2024 {{ config('app.nama_dinas') }}. <br>
      Powered by Tim IT {{ config('app.nama_singkatan_dinas') }}.
    </p>
  </footer>
@endsection


