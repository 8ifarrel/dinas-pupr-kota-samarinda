@extends('guest.layouts.buku-tamu')

@section('document.head')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('document.body')
  <main class="flex flex-col gap-3 justify-center items-center h-screen">
    <div class="p-5 3xl:px-10 border-black border-[1.5px] max-w-3xl 3xl:max-w-6xl">
      <hgroup class="text-center pb-5">
        <h1 class="text-4xl 3xl:text-5xl font-bold mb-2">
          Buku Tamu Digital
        </h1>
        <p class="text-xl 3xl:text-3xl font-medium">
          Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda
        </p>
      </hgroup>

      <hr class="border-black border-1">

      <div class="flex flex-col items-center gap-5 py-5">
        <p class="text-xl 3xl:text-3xl text-center">
          Terima kasih telah mengajukan permohonan buku tamu. <br> Kami sangat menghargai perhatian dan waktu yang Anda
          luangkan.
        </p>
        <div class="border-black border-2 p-4">
          <p class="text-xl 3xl:text-3xl text-center">
            Nomor antrean Anda adalah <strong>{{ $buku_tamu->nomor_urut }}</strong>
          </p>
        </div>
        <img src="data:image/svg+xml;base64,{{ base64_encode($qrcode) }}" alt="QR Code"
          class="flex-none w-[150px] 3xl:w-[250px]">
        <p class="text-xl 3xl:text-3xl text-center">
          Silakan <strong>pindai kode QR di atas</strong> untuk memantau status kunjungan Anda melalui ponsel secara
          berkala.
        </p>
        <p class="text-xl 3xl:text-3xl text-center">
          Anda juga dapat memantau status kunjungan pada <b>TV berdiri yang berada di samping meja informasi</b>.
        </p>
      </div>

      <hr class="border-black border-1">

      <div class="flex flex-col items-center gap-5 pt-5">
        <p class="text-center text-sm 3xl:text-lg">
          © 2024-2025 {{ config('app.nama_dinas') }}. <br>
        </p>
      </div>
    </div>

    <a href="{{ route('guest.buku-tamu.index') }}">
      <span class="text-blue-600 underline text-xl">Kembali ke halaman utama</span>
      <i class="fa-solid fa-up-right-from-square ms-1 text-blue-600"></i>
    </a>
  </main>
@endsection
