@extends('admin.layouts.pengumuman')

@section('css')
    <link href="https://unpkg.com/trix/dist/trix.css" rel="stylesheet"/>
    <style>
        trix-toolbar .trix-button-group--file-tools {
            display: none;
        }
        trix-toolbar .trix-button--icon-quote {
            display: none;
        }
        trix-toolbar .trix-button--icon-code {
            display: none;
        }
        trix-editor {
            height: 270px !important; 
            overflow-y: auto;
        }
        trix-editor h1 {
            font-size: 1.25rem !important;
            line-height: 1.25rem !important;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        trix-editor a:not(.no-underline) {
            text-decoration: underline;
        }
        trix-editor a:visited {
            color: blue;
        }
        trix-editor ul { 
            list-style-type: disc !important; margin-left: 1rem !important; 
        }
        trix-editor ol { 
            list-style-type: decimal !important; margin-left: 1rem !important; 
        }
    </style>
@endsection

@section('slot')
    <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="mb-4">
            <label for="judul_pengumuman" class="block text-sm font-medium text-gray-700">Judul Pengumuman</label>
            <input type="text" name="judul_pengumuman" id="judul_pengumuman" value="{{ $pengumuman->judul_pengumuman }}"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
        </div>

        <div class="mb-4">
            <label for="perihal" class="block text-sm font-medium text-gray-700">Perihal</label>
            <input id="perihal" type="hidden" name="perihal" value="{{ $pengumuman->perihal }}">
            <trix-editor input="perihal"></trix-editor>
        </div>

        <div class="mb-4">
          <label for="foto_berita" class="block text-sm font-medium text-gray-700">File Lampiran</label>
          <span class="text-xs text-gray-700">Kosongi bagian ini jika tetap ingin menggunakan lampiran sebelumnya</span>
            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_lampiran" type="file" name="file_lampiran">
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PDF, PNG, JPG, JPEG</p>
            @if ($pengumuman->file_lampiran)
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Current file: <a href="{{ Storage::url($pengumuman->file_lampiran) }}" target="_blank" class="text-blue-700 hover:underline">View</a></p>
            @endif
        </div>

        <div class="mb-4">
            <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Perbarui</button>
        </div>
    </form>
@endsection

@section('js')
    <script src="https://unpkg.com/trix/dist/trix.umd.min.js"></script>
@endsection