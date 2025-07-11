@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/cropperjs.css', 'resources/css/viewerjs.css'])
@endsection

@section('document.body')
  <form action="{{ route('admin.album-kegiatan.update', [$album->id, $foto->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700">Foto Kegiatan Saat Ini</label>
      <img src="{{ Storage::url($foto->foto) }}" alt="Foto Kegiatan" class="w-[200px] h-auto object-cover rounded mb-2" />
      <input type="file" name="foto" id="foto" accept="image/*">
      <div class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti foto.</div>
    </div>
    <div class="mb-4">
      <label for="caption" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
      <textarea name="caption" id="caption" rows="3" class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-xs resize-none" placeholder="Deskripsi singkat (opsional)">{{ $foto->caption }}</textarea>
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
