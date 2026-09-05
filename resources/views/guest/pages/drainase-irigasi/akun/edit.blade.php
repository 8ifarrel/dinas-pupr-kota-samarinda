@extends('guest.layouts.main')

@section('document.body')
  <div class="max-w-xl mx-auto px-4 py-10 md:py-14">
    <nav class="mb-4 text-sm">
      <a href="{{ route('guest.drainase-irigasi.index') }}" class="text-blue-600 hover:underline">
        <i class="fa-solid fa-arrow-left fa-sm"></i> Kembali ke Hantu Banyu
      </a>
    </nav>

    <h1 class="text-2xl sm:text-3xl font-bold text-brand-blue mb-1">Kelola Akun Kelurahan</h1>
    <p class="text-sm text-gray-600 mb-6">
      Perbarui username dan kata sandi akun. Nama kelurahan tidak dapat diubah.
    </p>

    @if (session('success'))
      <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <ul class="list-disc list-inside space-y-0.5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg border p-6 sm:p-8">
      <form method="POST" action="{{ route('guest.drainase-irigasi.akun.update') }}" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelurahan</label>
          <input type="text" value="{{ optional($akun->kelurahan)->nama ?? '-' }}" disabled
            class="block w-full rounded-lg border border-gray-200 bg-gray-100 text-gray-500 px-3 py-2 text-sm cursor-not-allowed" />
          <p class="text-xs text-gray-400 mt-1">Terikat pada akun dan tidak bisa diubah.</p>
        </div>

        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
          <input type="text" name="name" id="name" value="{{ old('name', $akun->name) }}" required
            autocomplete="username"
            class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/15" />
        </div>

        <hr class="border-gray-100">

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
            Kata Sandi Baru <span class="text-gray-400 font-normal">(kosongkan jika tidak diganti)</span>
          </label>
          <input type="password" name="password" id="password" autocomplete="new-password" minlength="8"
            placeholder="Minimal 8 karakter"
            class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/15" />
        </div>

        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
            Konfirmasi Kata Sandi Baru
          </label>
          <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
            placeholder="Ulangi kata sandi baru"
            class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/15" />
        </div>

        <div class="pt-1 flex items-center gap-3">
          <button type="submit"
            class="inline-flex items-center gap-2 rounded-lg bg-brand-blue px-4 py-2 text-sm font-semibold text-white hover:bg-blue-900">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
          </button>
          <a href="{{ route('guest.drainase-irigasi.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-800">
            Batal
          </a>
        </div>
      </form>
    </div>
  </div>
@endsection
