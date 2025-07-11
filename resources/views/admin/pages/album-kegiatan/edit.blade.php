@extends('admin.layout')

@section('document.head')
@endsection

@section('document.body')
  <form action="{{ route('admin.album-kegiatan.update', $album->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-4">
      <label for="judul" class="block text-sm font-medium text-gray-700">Judul Album Kegiatan</label>
      <input type="text" name="judul" id="judul" value="{{ $album->judul }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
    </div>
    <div class="mb-4">
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
    </div>
  </form>
@endsection

@section('document.end')
@endsection
