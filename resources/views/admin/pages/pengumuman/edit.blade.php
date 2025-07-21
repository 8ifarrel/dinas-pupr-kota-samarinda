@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/quill.css'])
@endsection

@section('document.body')
  <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data"
    id="form-pengumuman">
    @csrf
    @method('POST')

    <div class="mb-4">
      <label for="judul_pengumuman" class="block text-sm font-medium text-gray-700">Judul Pengumuman</label>
      <input type="text" name="judul_pengumuman" id="judul_pengumuman" value="{{ $pengumuman->judul_pengumuman }}"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
    </div>

    <div class="mb-4">
      <label for="perihal" class="block text-sm font-medium text-gray-700 mb-1">Perihal</label>
      <input id="perihal" type="hidden" name="perihal" value="{{ $pengumuman->perihal }}">
      <div id="quill-editor"></div>
    </div>

    <div class="mb-4">
      <label for="foto_berita" class="block text-sm font-medium text-gray-700">File Lampiran</label>
      <span class="text-xs text-gray-700">Kosongi bagian ini jika tetap ingin menggunakan lampiran sebelumnya</span>
      <input
        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
        aria-describedby="file_input_help" id="file_lampiran" type="file" name="file_lampiran">
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PDF, PNG, JPG, JPEG</p>
      @if ($pengumuman->file_lampiran)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Current file: <a
            href="{{ Storage::url($pengumuman->file_lampiran) }}" target="_blank"
            class="text-blue-700 hover:underline">View</a></p>
      @endif
    </div>

    <div class="mb-4">
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Perbarui</button>
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
            [{
              header: [1, 2, false]
            }],
            ['bold', 'italic', 'underline'],
            [{
              list: 'ordered'
            }, {
              list: 'bullet'
            }],
            ['clean']
          ]
        }
      });

      // Isi value awal dari database
      var isiPerihal = document.getElementById('perihal').value;
      if (isiPerihal) {
        quill.clipboard.dangerouslyPasteHTML(isiPerihal);
      }

      document.getElementById('form-pengumuman').addEventListener('submit', function(e) {
        document.getElementById('perihal').value = quill.root.innerHTML;
      });
    });
  </script>
@endsection
