@extends('admin.layouts.profil')

@section('css')
  <link href="https://unpkg.com/trix/dist/trix.css" rel="stylesheet" />
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

    /*
     * Fixing Trix Editor style when using Tailwind CSS
     * Based on solution by Muhammad Jamil
     * https://dev.to/fanreza/resolving-problem-when-using-trix-rich-editor-with-tailwind-13ca
     */

    trix-editor {
      @apply block w-full border border-gray-300 rounded-md p-3 prose prose-sm prose-slate dark:prose-invert;
      min-height: 200px;
      overflow-y: auto;
      background-color: white;
    }

    trix-editor h1 {
      font-size: 1.25rem !important;
      line-height: 1.75rem !important;
      margin-bottom: 1rem !important;
      font-weight: 600 !important;
    }

    trix-editor h2 {
      font-size: 1.125rem !important;
      line-height: 1.5rem !important;
      margin-bottom: 0.75rem !important;
      font-weight: 600 !important;
    }

    trix-editor h3 {
      font-size: 1rem !important;
      line-height: 1.5rem !important;
      margin-bottom: 0.5rem !important;
      font-weight: 500 !important;
    }

    trix-editor p {
      margin-bottom: 1rem !important;
      line-height: 1.625 !important;
    }

    trix-editor pre {
      background-color: #f3f4f6 !important;
      padding: 1rem !important;
      border-radius: 0.375rem !important;
      overflow-x: auto;
      font-family: monospace;
      font-size: 0.875rem;
    }

    trix-editor ul {
      list-style-type: disc !important;
      padding-left: 1.25rem !important;
      margin-bottom: 1rem !important;
    }

    trix-editor ol {
      list-style-type: decimal !important;
      padding-left: 1.25rem !important;
      margin-bottom: 1rem !important;
    }

    trix-editor li {
      margin-bottom: 0.5rem !important;
    }

    trix-editor blockquote {
      border-left: 4px solid #d1d5db !important;
      padding-left: 1rem !important;
      color: #6b7280 !important;
      font-style: italic !important;
      margin-bottom: 1rem !important;
    }

    trix-editor a:not(.no-underline) {
      text-decoration: underline !important;
      color: #3b82f6 !important;
    }

    trix-editor a:visited {
      color: #6366f1 !important;
    }

    trix-editor img {
      max-width: 100% !important;
      height: auto !important;
      display: block;
      margin: 1rem 0 !important;
      border-radius: 0.375rem;
    }

    trix-editor hr {
      border: none;
      border-top: 1px solid #e5e7eb;
      margin: 2rem 0;
    }

    trix-editor strong {
      font-weight: 600 !important;
    }

    trix-editor em {
      font-style: italic !important;
    }
  </style>
@endsection

@section('slot')
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

@section('js')
  <script src="https://unpkg.com/trix/dist/trix.umd.min.js"></script>
@endsection
