@extends('admin.layouts.pegawai')

@section('css')
  <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
  <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
  <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
@endsection

@section('slot')
  @if ($errors->any())
    <div id="alert-border-2"
      class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800"
      role="alert">
      <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
        viewBox="0 0 20 20">
        <path
          d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
      </svg>
      <div class="ms-3 text-sm font-medium">
        @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
      <button type="button"
        class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
        data-dismiss-target="#alert-border-2" aria-label="Close">
        <span class="sr-only">Dismiss</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
      </button>
    </div>
  @endif

  <form action="{{ route('admin.pegawai.update', ['id' => $pegawai->id_pegawai]) }}" method="POST"
    enctype="multipart/form-data" autocomplete="off">
    @csrf
    @method('PUT')

    <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
      <h2 class="font-semibold text-2xl mb-5 md:text-3xl">
        Edit Profil Pegawai
      </h2>

      <div class="mb-4">
        <label for="id_jabatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
        <select name="id_jabatan" id="id_jabatan"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
          required>
          @foreach ($jabatan as $jabatanItem)
            <option value="{{ $jabatanItem->id_jabatan }}"
              {{ $pegawai->id_jabatan == $jabatanItem->id_jabatan ? 'selected' : '' }}>
              {{ $jabatanItem->nama_jabatan }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="mb-4">
        <label for="nama_pegawai" class="block font-medium text-gray-700">Nama Pegawai</label>
        <input type="text" name="nama_pegawai" id="nama_pegawai"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
          required autocomplete="off" value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}">
      </div>
      <div class="mb-4">
        <label for="nomor_induk_pegawai" class="block font-medium text-gray-700">Nomor Induk Pegawai</label>
        <input type="text" name="nomor_induk_pegawai" id="nomor_induk_pegawai"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
          autocomplete="off" value="{{ old('nomor_induk_pegawai', $pegawai->nomor_induk_pegawai) }}">
      </div>
      <div class="mb-4">
        <label for="nomor_telepon_pegawai" class="block font-medium text-gray-700">Nomor Telepon</label>
        <input type="text" name="nomor_telepon_pegawai" id="nomor_telepon_pegawai"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
          required autocomplete="off" value="{{ old('nomor_telepon_pegawai', $pegawai->nomor_telepon_pegawai) }}">
      </div>
      <div class="mb-4">
        <label for="golongan_pegawai" class="block font-medium text-gray-700">Golongan</label>
        <input type="text" name="golongan_pegawai" id="golongan_pegawai"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
          required autocomplete="off" value="{{ old('golongan_pegawai', $pegawai->golongan_pegawai) }}">
      </div>
      <div class="mb-4 relative">
        <label for="foto_pegawai" class="block font-medium text-gray-700">Foto Pegawai</label>
        <input type="file" name="foto_pegawai" id="foto_pegawai" class="mt-1" />
        <a type="button" id="edit-image-button" style="display:none;"
          class="p-1 bg-black border-2 border-white text-white rounded-full absolute left-1/2 transform -translate-x-1/2 bottom-7">
          <i class="fa-solid fa-pencil p-1"></i>
        </a>
      </div>
    </div>

    <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
      <h2 class="font-semibold text-2xl mb-5 md:text-3xl">
        Edit Akun Pegawai
      </h2>

      <div class="mb-4">
        <label for="username" class="block font-medium text-gray-700">Username</label>
        <input type="text" name="username" id="username"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
          required autocomplete="off" value="{{ old('username', $pegawai->user->name ?? '') }}">
      </div>
      <div class="mb-4">
        <label for="email" class="block font-medium text-gray-700">Email</label>
        <input type="email" name="email" id="email"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
          required autocomplete="off" value="{{ old('email', $pegawai->user->email ?? '') }}">
      </div>
      <div class="mb-4">
        <label for="password" class="block font-medium text-gray-700">Password <span
            class="text-xs text-gray-500">(Kosongkan jika tidak ingin mengubah)</span></label>
        <input type="password" name="password" id="password"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
          autocomplete="new-password">
      </div>
      <div class="mb-4">
        <label for="password_confirmation" class="block font-medium text-gray-700">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
          autocomplete="new-password">
      </div>

      <div>
        <button type="submit"
          class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Simpan Perubahan
        </button>
      </div>
    </div>
  </form>

  <!-- Modal -->
  <div id="cropperModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Crop Image
          </h3>
          <button type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-hide="cropperModal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5 space-y-4">
          <div>
            <img id="image-to-crop" src="" alt="Image to crop" />
          </div>
        </div>
        <!-- Modal footer -->
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
          <button type="button" id="crop-button"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Crop</button>
          <button type="button"
            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
            data-modal-hide="cropperModal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  @vite('resources/js/admin/pegawai.js')
@endsection
