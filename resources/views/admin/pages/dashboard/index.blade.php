@extends('admin.layouts.dashboard')

@section('slot')
  <main>
    {{-- ALERT SUKSES --}}
    @if (session('success'))
      <div id="alert-success" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-100 dark:bg-green-200 dark:text-green-800" role="alert">
        <svg class="flex-shrink-0 w-4 h-4 me-2" ...></svg>
        <div class="ms-3 text-sm font-medium">
          {{ session('success') }}
        </div>
        <button type="button" class="ms-auto ..." data-dismiss-target="#alert-success" aria-label="Close">
          ...
        </button>
      </div>
    @endif

    {{-- ALERT ERROR --}}
    @if ($errors->any())
      <div id="alert-error" class="p-4 mb-4 text-red-800 rounded-lg bg-red-100" role="alert">
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

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
