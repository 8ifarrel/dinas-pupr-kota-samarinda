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

    {{-- Tombol kontak WA Admin --}}
<a href="https://wa.me/6281528231245?text=Halo%20Admin,%20saya%20sudah%20mendaftar."
   target="_blank"
   class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-medium px-5 py-3 rounded-lg shadow-md transition">
    <!-- Ikon WhatsApp -->
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
        <path d="M20.52 3.48A11.91 11.91 0 0012 0C5.37 0 0 5.37 0 12a11.9 11.9 0 001.64 6L0 24l6.23-1.63A11.9 11.9 0 0012 24c6.63 0 12-5.37 12-12 0-3.19-1.24-6.19-3.48-8.52zM12 22a9.93 9.93 0 01-5.09-1.39l-.36-.22-3.7.97.99-3.61-.23-.37A9.93 9.93 0 012 12c0-5.52 4.48-10 10-10s10 4.48 10 10-4.48 10-10 10zm5.2-7.55c-.29-.15-1.71-.84-1.97-.94-.26-.1-.45-.15-.64.15-.19.29-.74.94-.91 1.13-.17.19-.34.22-.63.07-.29-.15-1.24-.46-2.36-1.47-.87-.78-1.45-1.74-1.62-2.03-.17-.29-.02-.45.13-.6.13-.13.29-.34.43-.5.14-.17.19-.29.29-.48.1-.19.05-.36-.02-.51-.07-.15-.64-1.55-.88-2.13-.23-.55-.47-.48-.64-.49h-.55c-.19 0-.5.07-.76.36-.26.29-1 1-1 2.45s1.02 2.84 1.16 3.03c.15.19 2.01 3.06 4.87 4.29.68.29 1.21.46 1.62.59.68.22 1.3.19 1.79.12.55-.08 1.71-.7 1.95-1.37.24-.67.24-1.25.17-1.37-.07-.12-.26-.19-.55-.34z"/>
    </svg>
    Hubungi via WhatsApp
</a>


    {{-- Deskripsi di bawah tombol --}}
    <p class="text-gray-600 text-sm mt-1">
      *Klik tombol di atas untuk terhubung langsung dengan admin via WhatsApp.
    </p>
    
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
</div>
@endsection