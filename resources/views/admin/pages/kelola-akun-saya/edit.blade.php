@extends('admin.layout')

@section('document.body')
  <form action="{{ route('admin.kelola-akun-saya.update', $user->id) }}" method="POST" autocomplete="off">
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
      @if ($user->is_super_admin)
        <select name="id_susunan_organisasi" disabled
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100">
          <option value="">Superadmin tidak perlu mengisi susunan organisasi</option>
        </select>
        <div class="text-gray-500 text-xs mt-1">Superadmin tidak perlu mengisi susunan organisasi</div>
      @else
        <select name="id_susunan_organisasi" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
          <option value="">-- Pilih Susunan Organisasi --</option>
          @foreach ($susunan_organisasi as $so)
            @if ($so->id_susunan_organisasi != 1 || $user->id_susunan_organisasi == 1)
              <option value="{{ $so->id_susunan_organisasi }}"
                {{ old('id_susunan_organisasi', $user->id_susunan_organisasi) == $so->id_susunan_organisasi ? 'selected' : '' }}>
                {{ $so->nama_susunan_organisasi }}
              </option>
            @endif
          @endforeach
        </select>
        <div class="text-gray-500 text-xs mt-1">Pilih Susunan organisasi yang sesuai dengan Anda</div>
      @endif
    </div>
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
      <div class="relative">
        <input type="password" name="old_password" id="old_password"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md pr-10" />
        <button type="button" class="absolute right-2 top-2 text-gray-500" onclick="togglePassword('old_password')">
          <i class="fa-solid fa-eye" id="icon-old_password"></i>
        </button>
      </div>
      <div class="text-gray-500 text-xs mt-1">Masukkan password lama akun Anda untuk memastikan bahwa ini benar-benar Anda.</div>
    </div>
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
      <div class="relative">
        <input type="password" name="password" id="password"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md pr-10" />
        <button type="button" class="absolute right-2 top-2 text-gray-500" onclick="togglePassword('password')">
          <i class="fa-solid fa-eye" id="icon-password"></i>
        </button>
      </div>
      <div class="text-gray-500 text-xs mt-1">Gunakan kombinasi huruf, angka, dan simbol untuk keamanan yang lebih baik.
      </div>
    </div>
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
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
    <div class="mb-4">
      <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-lg px-4 py-2">
        Simpan Perubahan
      </button>
    </div>
    <div class="mb-4">
      <button type="button" class="bg-red-700 hover:bg-red-800 text-white font-medium rounded-lg px-4 py-2"
        data-modal-target="modal-hapus-akun" data-modal-toggle="modal-hapus-akun">
        Hapus Akun Saya
      </button>
    </div>
  </form>

  {{-- Modal Konfirmasi Hapus Akun --}}

  <div id="modal-hapus-akun" data-modal-target="modal-hapus-akun" data-modal-backdrop="static" tabindex="-1"
    aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
      <form action="{{ route('admin.kelola-akun-saya.destroy', $user->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="relative bg-white rounded-lg shadow">
          <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
            <h3 class="text-xl font-semibold text-gray-900">
              Konfirmasi Hapus Akun
            </h3>
            <button type="button"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
              data-modal-hide="modal-hapus-akun">
              <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
              <span class="sr-only">Close modal</span>
            </button>
          </div>
          <div class="p-4 md:p-5 space-y-4">
            <p class="text-base leading-relaxed text-gray-500">
              Apakah Anda yakin ingin menghapus akun Anda? <strong>Tindakan ini tidak dapat dibatalkan.</strong>
            </p>
            <div id="countdown-hapus-akun" class="text-center text-red-600 font-bold text-lg">
              Mohon tunggu <span id='countdown-seconds'>15</span> detik sebelum dapat menghapus akun Anda.
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Password Anda</label>
              <input type="password" name="delete_password" id="delete_password"
                class="block w-full p-2 border border-gray-300 rounded-md text-sm" placeholder="Password Anda" required
                autocomplete="current-password" />
              <div class="text-gray-500 text-xs mt-1">
                Masukkan password akun Anda untuk memastikan bahwa ini benar-benar Anda.
              </div>
            </div>
          </div>
          <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
            <button type="submit" id="btn-hapus-akun"
              class="text-white bg-red-700 cursor-not-allowed opacity-50 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
              disabled>
              Hapus Akun
            </button>
            <button type="button"
              class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100"
              data-modal-hide="modal-hapus-akun">
              Tidak
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('document.end')
  @vite('resources/js/toggle-password-visibility.js')
  <script>
    // Countdown logic untuk modal hapus akun
    document.addEventListener('DOMContentLoaded', function() {
      let modal = document.getElementById('modal-hapus-akun');
      let btnHapus = document.getElementById('btn-hapus-akun');
      let countdownText = document.getElementById('countdown-hapus-akun');
      let countdownSeconds = document.getElementById('countdown-seconds');
      let timer = null;

      function setBtnDisabledStyle(disabled) {
        if (disabled) {
          btnHapus.classList.add('cursor-not-allowed', 'opacity-50');
          btnHapus.classList.remove('hover:bg-red-800', 'focus:ring-red-300');
        } else {
          btnHapus.classList.remove('cursor-not-allowed', 'opacity-50');
          btnHapus.classList.add('hover:bg-red-800', 'focus:ring-red-300');
        }
        btnHapus.disabled = disabled;
      }

      function startCountdown() {
        let seconds = 15;
        setBtnDisabledStyle(true);
        countdownText.style.display = '';
        countdownSeconds.textContent = seconds;
        timer = setInterval(function() {
          seconds--;
          countdownSeconds.textContent = seconds;
          if (seconds <= 0) {
            clearInterval(timer);
            setBtnDisabledStyle(false);
            countdownText.style.display = 'none';
          }
        }, 1000);
      }

      // Flowbite modal event
      document.body.addEventListener('click', function(e) {
        var toggleBtn = e.target.closest('[data-modal-toggle]');
        if (toggleBtn && toggleBtn.getAttribute('data-modal-toggle') === 'modal-hapus-akun') {
          setTimeout(startCountdown, 200); // Modal animasi dulu
        }
        var hideBtn = e.target.closest('[data-modal-hide]');
        if (hideBtn && hideBtn.getAttribute('data-modal-hide') === 'modal-hapus-akun') {
          if (timer) clearInterval(timer);
          setBtnDisabledStyle(true);
          countdownText.style.display = '';
          countdownSeconds.textContent = 15;
        }
      });
    });
  </script>
@endsection
