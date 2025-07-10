@extends('admin.layout')

@section('document.body')
  <main>
    {{-- Selamat datang --}}
    <div class="w-full p-4 rounded-lg shadow-xl sm:p-8">
      <h5 class="mb-2 text-3xl font-bold text-center md:text-start text-gray-900">
        Selamat Datang di E-Panel
      </h5>

      <p class="mb-5 text-base text-center md:text-start text-gray-500 sm:text-lg">
        Kelola website {{ config('app.nama_dinas') }} di sini
      </p>
    </div>
  </main>
@endsection


