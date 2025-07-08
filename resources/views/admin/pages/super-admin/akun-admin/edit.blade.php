@extends('admin.layouts.super')

@section('slot')
  @php
    $kepalaDinasSudahAda = \App\Models\User::where('id_susunan_organisasi', 1)->exists();
  @endphp

  <form action="{{ route('admin.super.akun-admin.update', $user->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PUT')

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
      <input type="text" name="fullname" value="{{ old('fullname', $user->fullname) }}" required
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" />
      <div class="text-gray-500 text-xs mt-1">Masukkan nama lengkap</div>
    </div>

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
      <input type="text" name="name" value="{{ old('name', $user->name) }}" required
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" />
      <div class="text-gray-500 text-xs mt-1">Username digunakan untuk login ke E-Panel.</div>
    </div>

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Susunan Organisasi</label>
      <select name="id_susunan_organisasi" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        <option value="">-- Pilih Susunan Organisasi --</option>
        @foreach ($susunan_organisasi as $so)
          @if (
            (!$kepalaDinasSudahAda && ($so->id_susunan_organisasi_parent == 1 || $so->id_susunan_organisasi == 1)) ||
            ($user->id_susunan_organisasi == 1 && $so->id_susunan_organisasi_parent == 1) ||
            ($user->id_susunan_organisasi == 1 && $so->id_susunan_organisasi == 1) ||
            ($kepalaDinasSudahAda && $user->id_susunan_organisasi != 1 && $so->id_susunan_organisasi_parent == 1 && $so->id_susunan_organisasi != 1)
          )
            <option value="{{ $so->id_susunan_organisasi }}"
              {{ old('id_susunan_organisasi', $user->id_susunan_organisasi) == $so->id_susunan_organisasi ? 'selected' : '' }}>
              {{ $so->nama_susunan_organisasi }}
            </option>
          @endif
        @endforeach
      </select>
      <div class="text-gray-500 text-xs mt-1">Pilih Susunan organisasi yang sesuai dengan pemilik akun</div>
    </div>

    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Reset Password</label>
      <div class="flex flex-col sm:flex-row gap-1 sm:gap-4">
        <label>
          <input type="radio" name="reset_mode" value="ingat" id="reset_mode_ingat"
            {{ old('reset_mode') == 'ingat' ? 'checked' : '' }}> Ingat password lama
        </label>
        <label>
          <input type="radio" name="reset_mode" value="lupa" id="reset_mode_lupa"
            {{ old('reset_mode') == 'lupa' ? 'checked' : '' }}> Lupa password lama
        </label>
      </div>
      <div class="text-gray-500 text-xs mt-1">Pilih metode reset password sesuai kondisi akun.</div>
    </div>

    <div id="ingat_password_fields" class="mb-4" style="display: none;">
      <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
      <div class="relative">
        <input type="password" name="old_password" id="old_password"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md pr-10" />
        <button type="button" class="absolute right-2 top-2 text-gray-500" onclick="togglePassword('old_password')">
          <i class="fa-solid fa-eye" id="icon-old_password"></i>
        </button>
      </div>
      <div class="text-gray-500 text-xs mt-1">Masukkan password lama akun ini.</div>
      <label class="block text-sm font-medium text-gray-700 mb-1 mt-3">Password Baru</label>
      <div class="relative">
        <input type="password" name="password" id="password"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md pr-10" />
        <button type="button" class="absolute right-2 top-2 text-gray-500" onclick="togglePassword('password')">
          <i class="fa-solid fa-eye" id="icon-password"></i>
        </button>
      </div>
      <div class="text-gray-500 text-xs mt-1">Gunakan kombinasi huruf, angka, dan simbol untuk keamanan yang lebih baik.
      </div>
      <label class="block text-sm font-medium text-gray-700 mb-1 mt-3">Konfirmasi Password Baru</label>
      <div class="relative">
        <input type="password" name="password_confirmation" id="password_confirmation"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md pr-10" />
        <button type="button" class="absolute right-2 top-2 text-gray-500"
          onclick="togglePassword('password_confirmation')">
          <i class="fa-solid fa-eye" id="icon-password_confirmation"></i>
        </button>
      </div>
      <div class="text-gray-500 text-xs mt-1">Pastikan password yang dimasukkan sama persis.</div>
    </div>

    <div id="lupa_password_fields" class="mb-4" style="display: none;">
      <label class="block text-sm font-medium text-gray-700 mb-1">Username Superadmin</label>
      <input type="text" name="superadmin_name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
        value="{{ auth()->user()->name }}" />
      <div class="text-gray-500 text-xs mt-1">Masukkan username superadmin yang sedang login.</div>
      <label class="block text-sm font-medium text-gray-700 mb-1 mt-3">Password Superadmin</label>
      <div class="relative">
        <input type="password" name="superadmin_password" id="superadmin_password"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md pr-10" />
        <button type="button" class="absolute right-2 top-2 text-gray-500"
          onclick="togglePassword('superadmin_password')">
          <i class="fa-solid fa-eye" id="icon-superadmin_password"></i>
        </button>
      </div>
      <div class="text-gray-500 text-xs mt-1">Masukkan password superadmin yang sedang login.</div>
      <label class="block text-sm font-medium text-gray-700 mb-1 mt-3">Password Baru</label>
      <div class="relative">
        <input type="password" name="password" id="password_lupa"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md pr-10" />
        <button type="button" class="absolute right-2 top-2 text-gray-500" onclick="togglePassword('password_lupa')">
          <i class="fa-solid fa-eye" id="icon-password_lupa"></i>
        </button>
      </div>
      <div class="text-gray-500 text-xs mt-1">Gunakan kombinasi huruf, angka, dan simbol untuk keamanan yang lebih baik.
      </div>
      <label class="block text-sm font-medium text-gray-700 mb-1 mt-3">Konfirmasi Password Baru</label>
      <div class="relative">
        <input type="password" name="password_confirmation" id="password_confirmation_lupa"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md pr-10" />
        <button type="button" class="absolute right-2 top-2 text-gray-500"
          onclick="togglePassword('password_confirmation_lupa')">
          <i class="fa-solid fa-eye" id="icon-password_confirmation_lupa"></i>
        </button>
      </div>
      <div class="text-gray-500 text-xs mt-1">Pastikan password yang dimasukkan sama persis.</div>
    </div>

    <div class="mb-4">
      <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-lg px-4 py-2">
        Simpan Perubahan
      </button>
    </div>
  </form>
@endsection

@section('js')
  <script>
    function toggleResetFields() {
      const mode = document.querySelector('input[name="reset_mode"]:checked');
      document.getElementById('ingat_password_fields').style.display = (mode && mode.value === 'ingat') ? '' : 'none';
      document.getElementById('lupa_password_fields').style.display = (mode && mode.value === 'lupa') ? '' : 'none';
    }
    document.querySelectorAll('input[name="reset_mode"]').forEach(el => {
      el.addEventListener('change', toggleResetFields);
    });
    window.addEventListener('DOMContentLoaded', toggleResetFields);

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
