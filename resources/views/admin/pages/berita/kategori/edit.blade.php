{{-- 
NOTE(S):
1. Belum pakai FilePond dan Cropper.js
--}}

@extends('admin.layouts.partner')

@section('slot')
  <form action="{{ route('admin.berita.kategori.update', $kategori->id_berita_kategori) }}" method="POST">
    @csrf

    <div class="mb-4">
      <label for="nama_kategori" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
      <input type="text" name="nama_kategori" id="nama_kategori" value="{{ $kategori->nama_kategori }}"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
    </div>

    <div class="mb-4">
      <label for="ikon_kategori" class="block text-sm font-medium text-gray-700">Ikon Kategori</label>
      <input type="text" name="ikon_kategori" id="ikon_kategori" value="{{ $kategori->ikon_kategori }}"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" />
    </div>

    <div class="mb-4">
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
    </div>
  </form>
@endsection
