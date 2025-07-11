@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/cropperjs.css', 'resources/css/viewerjs.css'])
@endsection

@section('document.body')
  <form action="{{ route('admin.album-kegiatan.store', $album->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
      <label for="foto" class="block text-sm font-medium text-gray-700">Foto Kegiatan</label>
      <input type="file" name="foto" id="foto" accept="image/*" required>
    </div>
    <div class="mb-4">
      <label for="caption" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
      <textarea name="caption" id="caption" rows="3" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-xs resize-none" placeholder="Deskripsi singkat (opsional)"></textarea>
    </div>
    <div class="mb-4">
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
      <a href="{{ route('admin.album-kegiatan.show', $album->id) }}" class="ml-2 px-4 py-2 bg-gray-300 rounded-md">Batal</a>
    </div>
  </form>
@endsection

@section('document.end')
  @vite(['resources/js/cropperjs.js', 'resources/js/viewerjs.js'])
@endsection
