@extends('guest.layouts.buku-tamu')

@section('document.body')
  <main class="flex flex-col gap-3 justify-center items-center h-screen">
    <div class="p-5 3xl:px-10 border-black border-[1.5px] max-w-3xl 3xl:max-w-6xl">
      <hgroup class="text-center pb-5">
        <h1 class="text-4xl 3xl:text-5xl font-bold">
          Buku Tamu
        </h1>
        <p class="text-xl 3xl:text-3xl font-medium">
          Dinas PUPR Kota Samarinda
        </p>
      </hgroup>

      <hr class="border-black border-1">

      <div class="flex flex-col items-center gap-5 py-5">
        <p class="text-xl 3xl:text-3xl text-center">
          Terima kasih telah mengajukan permohonan buku tamu. <br> Kami sangat menghargai perhatian dan waktu yang Anda
          luangkan.
        </p>
        <img src="data:image/svg+xml;base64,{{ base64_encode($qrcode) }}" alt="QR Code" class="flex-none w-[150px] 3xl:w-[250px]">
        <p class="text-xl 3xl:text-3xl text-center">
          Silakan <strong>pindai QR code di atas</strong> atau <strong>periksa email Anda</strong> untuk memantau status
          kunjungan Anda secara berkala.
        </p>
      </div>

      <hr class="border-black border-1">

      <div class="flex flex-col items-center gap-5 pt-5">
        <p class="text-center text-sm 3xl:text-lg">
          © 2024 {{ config('app.nama_dinas') }}. <br>
          Powered by Tim IT {{ config('app.nama_singkatan_dinas') }}.
        </p>
      </div>
    </div>

    <a href="{{ route('guest.buku-tamu.index') }}" class="text-[#0000EE] 3xl:text-2xl">Kembali ke halaman utama</a>
  </main>
@endsection


