@extends('guest.layouts.main')

@section('document.body')
  <div class="min-h-[calc(100vh-148px)] flex items-center justify-center py-10 px-4">
    <div class="max-w-lg w-full bg-white rounded-lg shadow-lg border p-8 text-center">
      <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-green-100 text-green-600 rounded-full">
        <i class="fa-solid fa-check text-2xl"></i>
      </div>

      <h1 class="text-xl md:text-2xl font-bold mb-2 text-gray-900">Pendaftaran Berhasil!</h1>

      <p class="text-gray-600 mb-6">
        {{ session('status') ?? 'Terima kasih telah mendaftar layanan SILALAD. Tim kami akan segera menghubungi Anda untuk konfirmasi lebih lanjut.' }}
      </p>

      <div class="flex flex-col gap-3">
        <a href="{{ route('guest.silalad.status') }}"
          class="inline-flex justify-center items-center gap-1.5 px-5 py-2.5 bg-brand-blue hover:bg-brand-yellow hover:text-brand-blue text-white text-sm font-semibold rounded-lg transition">
          <i class="fa-solid fa-magnifying-glass"></i> Cek Status Pendaftaran
        </a>

        <a href="{{ session('wa_link') ?? 'https://wa.me/6281528231245?text=Halo%20Admin%2C%20saya%20sudah%20mendaftar%20layanan%20SILALAD%2C%20mohon%20informasi%20selanjutnya.' }}"
          target="_blank"
          class="inline-flex justify-center items-center gap-1.5 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
          <i class="fa-brands fa-whatsapp fa-lg"></i> Hubungi via WhatsApp
        </a>
      </div>

      <p class="text-xs text-gray-500 mt-3">
        Klik tombol di atas untuk terhubung langsung dengan admin via WhatsApp.
      </p>

      <a href="{{ route('guest.silalad.index') }}" class="block mt-4 text-sm text-blue-600 hover:underline">
        Kembali ke Beranda
      </a>
    </div>
  </div>
@endsection
