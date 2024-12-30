@extends('admin.layouts.slider')

@section('css')
  @vite('resources/css/admin/slider.css')
@endsection

@section('slot')
  <div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4">Tambah Slider</h2>

    <form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="mb-4">
        <label for="judul_slider" class="block text-sm font-medium text-gray-700">Judul Slider</label>
        <input type="text" name="judul_slider" id="judul_slider"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
      </div>

      <div class="mb-4 relative">
        <label for="foto_slider" class="block text-sm font-medium text-gray-700">Foto Slider</label>
        <input type="file" name="foto_slider" id="filepond" class="mt-1" />

        <button id="edit-image-button" style="display:none;"
          class="p-1 bg-black border-2 border-white text-white rounded-full absolute left-1/2 transform -translate-x-1/2 bottom-7">
          <i class="fa-solid fa-pencil p-1"></i>
        </button>
      </div>


      <div class="mb-4">
        <label for="is_visible" class="block text-sm font-medium text-gray-700">Status</label>
        <select name="is_visible" id="is_visible" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
          required>
          <option value="1">Ditampilkan</option>
          <option value="0">Disembunyikan</option>
        </select>
      </div>

      <div class="mb-4">
        <button type="submit" class="px-4 py-2 bg-blue text-white rounded-md">Simpan</button>
      </div>
    </form>
  </div>
@endsection

@section('js')
  @vite('resources/js/admin/slider.js')
@endsection
