@extends('admin.layouts.super')

@section('slot')

  @php
    $kepalaDinasSudahAda = \App\Models\User::where('id_susunan_organisasi', 1)->exists();
  @endphp

  <form action="{{ route('admin.super.akun-admin.store') }}" method="POST" autocomplete="off">
    @csrf

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
      <input type="text" name="fullname" value="{{ old('fullname') }}" required
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" />
      <div class="text-gray-500 text-xs mt-1">Masukkan nama lengkap</div>
    </div>

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
      <input type="text" name="name" value="{{ old('name') }}" required
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" />
      <div class="text-gray-500 text-xs mt-1">Username digunakan untuk login ke E-Panel.</div>
    </div>

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Susunan Organisasi</label>
      <select name="id_susunan_organisasi" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        <option value="">-- Pilih Susunan Organisasi --</option>
        @foreach ($susunan_organisasi as $so)
          @if (
            (!$kepalaDinasSudahAda && $so->id_susunan_organisasi_parent == 1) ||
            (!$kepalaDinasSudahAda && $so->id_susunan_organisasi == 1) ||
            ($kepalaDinasSudahAda && $so->id_susunan_organisasi_parent == 1 && $so->id_susunan_organisasi != 1)
          )
            <option value="{{ $so->id_susunan_organisasi }}"
              {{ old('id_susunan_organisasi') == $so->id_susunan_organisasi ? 'selected' : '' }}>
              {{ $so->nama_susunan_organisasi }}
            </option>
          @endif
        @endforeach
      </select>
      <div class="text-gray-500 text-xs mt-1">Pilih Susunan organisasi yang sesuai dengan pemilik akun</div>
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
      <div class="text-gray-500 text-xs mt-1">Gunakan kombinasi huruf, angka, dan simbol untuk keamanan yang lebih baik.
      </div>
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

@section('js')
  <script>
    function togglePassword(id) {
      const input = document.getElementById(id);
      const icon = document.getElementById('icon-' + id);
      if (input.type === "password") {
        input.type = "text";
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = "password";
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
  </script>
@endsection
