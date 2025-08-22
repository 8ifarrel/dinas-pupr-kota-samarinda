@extends('guest.layouts.sedottinja')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-10 px-4">
  <div class="max-w-lg w-full bg-white rounded-2xl shadow p-8 text-center">
    
    {{-- Icon sukses --}}
    <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-green-100 text-green-600 rounded-full">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
      </svg>
    </div>

    {{-- Judul sukses --}}
    <h1 class="text-xl font-bold mb-2">Pendaftaran Berhasil!</h1>

    {{-- Pesan dari controller (flash session) --}}
    @if(session('status'))
      <p class="text-gray-600 mb-6">
        {{ session('status') }}
      </p>
    @else
      <p class="text-gray-600 mb-6">
        Terima kasih telah mendaftar layanan Sedot Tinja. Tim kami akan segera menghubungi Anda untuk konfirmasi lebih lanjut.
      </p>
    @endif

    {{-- Tombol cek status --}}
    <a href="{{ route('guest.sedot-tinja.status') }}" 
       class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold inline-block mb-4">
      Cek Status Pendaftaran
    </a>

    {{-- Tombol kontak WA Admin jika ada link --}}
    @if(session('wa_link'))
      <a href="{{ session('wa_link') }}" target="_blank" 
         class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold inline-block mb-4">
        Hubungi Admin via WhatsApp
      </a>
    @endif

    {{-- Link kembali ke beranda --}}
    <a href="{{ route('guest.sedot-tinja.index') }}" 
       class="block mt-4 text-sm text-blue-600 hover:underline">
      Kembali ke Beranda
    </a>

    {{-- chapcha --}}
    @if ($errors->has('cf-turnstile-response'))
    <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
        {{ $errors->first('cf-turnstile-response') }}
    </div>
    @endif

  </div>
</div>
@endsection
