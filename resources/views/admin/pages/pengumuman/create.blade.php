@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/quill.css'])
@endsection

@section('document.body')
  <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data" id="form-pengumuman">
    @csrf

    <div class="mb-4">
      <label for="judul_pengumuman" class="block text-sm font-medium text-gray-700">Judul Pengumuman</label>
      <input type="text" name="judul_pengumuman" id="judul_pengumuman"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
    </div>

    <div class="mb-4">
      <label for="perihal" class="block text-sm font-medium text-gray-700 mb-1">Perihal</label>
      <input id="perihal" type="hidden" name="perihal">
      <div id="quill-editor"></div>
    </div>

    <div class="mb-4">
      <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_lampiran">File
        Lampiran</label>
      <input
        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
        aria-describedby="file_input_help" id="file_lampiran" type="file" name="file_lampiran">
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PDF, PNG, JPG, JPEG</p>
    </div>

    <div class="mb-4">
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
    </div>
  </form>
@endsection

@section('document.end')
  @vite(['resources/js/quill.js'])
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Tulis perihal pengumuman di sini...',
        modules: {
          toolbar: [
            [{ header: [1, 2, false] }],
            ['bold', 'italic', 'underline'],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['clean']
          ]
        }
      });

      document.getElementById('form-pengumuman').addEventListener('submit', function(e) {
        document.getElementById('perihal').value = quill.root.innerHTML;
      });
    });
  </script>
@endsection
