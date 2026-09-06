@extends('admin.layout')

@section('document.body')
  <form action="{{ route('admin.super.akun-kelurahan.store') }}" method="POST" autocomplete="off">
    @csrf

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
      <select name="kelurahan_id" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        <option value="">-- Pilih Kelurahan --</option>
        @foreach ($kelurahanTersedia as $kel)
          <option value="{{ $kel->id }}" {{ old('kelurahan_id') == $kel->id ? 'selected' : '' }}>
            {{ $kel->nama }} ({{ optional($kel->kecamatan)->nama ?? '-' }})
          </option>
        @endforeach
      </select>
      <div class="text-gray-500 text-xs mt-1">Hanya kelurahan yang belum memiliki akun yang ditampilkan. Satu kelurahan
        hanya boleh memiliki satu akun.</div>
    </div>

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
      <input type="text" name="fullname" value="{{ old('fullname') }}" required
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" />
      <div class="text-gray-500 text-xs mt-1">Masukkan nama lengkap operator/pemilik akun.</div>
    </div>

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
      <input type="text" name="name" value="{{ old('name') }}" required
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" />
      <div class="text-gray-500 text-xs mt-1">Username digunakan untuk login akun kelurahan.</div>
    </div>

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
      <div class="relative">
        <input type="password" name="password" id="password" required
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md pr-10" />
        <button type="button" class="absolute right-2 top-2 text-gray-500" onclick="togglePassword('password')">
          <i class="fa-solid fa-eye" id="icon-password"></i>
        </button>
      </div>
      <div class="text-gray-500 text-xs mt-1">Minimal 8 karakter.</div>
    </div>

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
      <div class="relative">
        <input type="password" name="password_confirmation" id="password_confirmation" required
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md pr-10" />
        <button type="button" class="absolute right-2 top-2 text-gray-500"
          onclick="togglePassword('password_confirmation')">
          <i class="fa-solid fa-eye" id="icon-password_confirmation"></i>
        </button>
      </div>
      <div class="text-gray-500 text-xs mt-1">Pastikan password yang dimasukkan sama persis.</div>
    </div>

    <div class="mb-4">
      <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-lg px-4 py-2">
        Tambah
      </button>
    </div>
  </form>
@endsection

@section('document.end')
  @vite('resources/js/toggle-password-visibility.js')
@endsection
