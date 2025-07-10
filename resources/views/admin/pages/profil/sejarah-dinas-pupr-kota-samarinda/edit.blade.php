@extends('admin.layout')

@section('document.head')
  @vite('resources/css/trix.css')
  <style>
    trix-toolbar .trix-button-group--file-tools {
      display: none;
    }

    trix-toolbar .trix-button--icon-quote,
    trix-toolbar .trix-button--icon-code {
      display: none;
    }

    trix-editor {
      min-height: 250px;
      overflow-y: auto;
    }
  </style>
@endsection

@section('document.body')
  <form action="{{ route('admin.profil.sejarah-dinas-pupr-kota-samarinda.update') }}" method="POST">
    @csrf
    <div class="mb-4">
      <label for="deskripsi_sejarah_dinas_pupr_kota_samarinda" class="block text-sm font-medium text-gray-700">
        Deskripsi Sejarah Dinas PUPR Kota Samarinda
      </label>
      <input id="deskripsi_sejarah_dinas_pupr_kota_samarinda" type="hidden"
        name="deskripsi_sejarah_dinas_pupr_kota_samarinda"
        value="{{ old('deskripsi_sejarah_dinas_pupr_kota_samarinda', $sejarah->deskripsi_sejarah_dinas_pupr_kota_samarinda ?? '') }}">
      <trix-editor input="deskripsi_sejarah_dinas_pupr_kota_samarinda"></trix-editor>
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
  @vite('resources/js/trix.js')
@endsection
