@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/quill.css'])
  <style>
    #quill-editor {
      min-height: 250px;
    }
  </style>
@endsection

@section('document.body')
  <form action="{{ route('admin.profil.sejarah-dinas-pupr-kota-samarinda.update') }}" method="POST"
    id="form-sejarah-dinas">
    @csrf
    <div class="mb-4">
      <label for="deskripsi_sejarah_dinas_pupr_kota_samarinda" class="block text-sm font-medium text-gray-700 mb-1">
        Deskripsi Sejarah Dinas PUPR Kota Samarinda
      </label>
      <input id="deskripsi_sejarah_dinas_pupr_kota_samarinda" type="hidden"
        name="deskripsi_sejarah_dinas_pupr_kota_samarinda"
        value="{{ old('deskripsi_sejarah_dinas_pupr_kota_samarinda', $sejarah->deskripsi_sejarah_dinas_pupr_kota_samarinda ?? '') }}">
      <div id="quill-editor"></div>
      @error('deskripsi_sejarah_dinas_pupr_kota_samarinda')
        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-4">
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
      <a href="{{ route('admin.profil.sejarah-dinas-pupr-kota-samarinda.index') }}"
        class="px-4 py-2 bg-gray-400 text-white rounded-md">Batal</a>
    </div>
  </form>
@endsection

@section('document.end')
  @vite(['resources/js/quill.js'])
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Tulis sejarah Dinas PUPR Kota Samarinda di sini...',
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
      var isiSejarah = document.getElementById('deskripsi_sejarah_dinas_pupr_kota_samarinda').value;
      if (isiSejarah) {
        quill.clipboard.dangerouslyPasteHTML(isiSejarah);
      }

      document.getElementById('form-sejarah-dinas').addEventListener('submit', function(e) {
        document.getElementById('deskripsi_sejarah_dinas_pupr_kota_samarinda').value = quill.root.innerHTML;
      });
    });
  </script>
@endsection
