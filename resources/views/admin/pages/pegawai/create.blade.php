@extends('admin.layouts.pegawai')

@section('css')
  <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
  <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endsection

@section('slot')
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5 border">
    <form action="{{ route('admin.pegawai.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
      @csrf
      
      <h2 class="font-semibold text-2xl mb-5 md:text-3xl">
        Tambah Pegawai
      </h2>

      <div class="mb-4">
        <label for="id_jabatan" class="block font-medium text-gray-700">Jabatan</label>
        <select name="id_jabatan" id="id_jabatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" required>
          @foreach ($jabatan as $jabatanItem)
            <option value="{{ $jabatanItem->id_jabatan }}">{{ $jabatanItem->nama_jabatan }}</option>
          @endforeach
        </select>
      </div>
      <div class="mb-4">
        <label for="nama_pegawai" class="block font-medium text-gray-700">Nama Pegawai</label>
        <input type="text" name="nama_pegawai" id="nama_pegawai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" required autocomplete="off">
      </div>
      <div class="mb-4">
        <label for="nomor_induk_pegawai" class="block font-medium text-gray-700">Nomor Induk Pegawai</label>
        <input type="text" name="nomor_induk_pegawai" id="nomor_induk_pegawai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" autocomplete="off">
      </div>
      <div class="mb-4">
        <label for="nomor_telepon_pegawai" class="block font-medium text-gray-700">Nomor Telepon</label>
        <input type="text" name="nomor_telepon_pegawai" id="nomor_telepon_pegawai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" required autocomplete="off">
      </div>
      <div class="mb-4">
        <label for="golongan_pegawai" class="block font-medium text-gray-700">Golongan</label>
        <input type="text" name="golongan_pegawai" id="golongan_pegawai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" required autocomplete="off">
      </div>
      <div class="mb-4">
        <label for="foto_pegawai" class="block font-medium text-gray-700">Foto Pegawai</label>
        <input type="file" name="foto_pegawai" id="foto_pegawai" class="mt-1" />
      </div>

      <h2 class="font-semibold text-2xl my-5 md:text-3xl">
        Akun Pegawai
      </h2>
      
      <div class="mb-4">
        <label for="username" class="block font-medium text-gray-700">Username</label>
        <input type="text" name="username" id="username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" required autocomplete="off">
      </div>
      <div class="mb-4">
        <label for="email" class="block font-medium text-gray-700">Email</label>
        <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" required autocomplete="off">
      </div>
      <div class="mb-4">
        <label for="password" class="block font-medium text-gray-700">Password</label>
        <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" required autocomplete="new-password">
      </div>
      <div class="mb-4">
        <label for="password_confirmation" class="block font-medium text-gray-700">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" required autocomplete="new-password">
      </div>

      <div class="mb-4">
        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Tambah Pegawai
        </button>
      </div>
    </form>
  </div>
@endsection

@section('js')
  <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
  <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
  <script>
    FilePond.registerPlugin(FilePondPluginImagePreview);
    const inputElement = document.querySelector('input[name="foto_pegawai"]');
    const pond = FilePond.create(inputElement);
  </script>
@endsection
