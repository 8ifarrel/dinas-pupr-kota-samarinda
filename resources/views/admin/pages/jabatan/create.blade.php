@extends('admin.layouts.jabatan')

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
    <form action="{{ route('admin.jabatan.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="nama_jabatan" class="block text-sm font-medium text-gray-700">Nama Jabatan</label>
            <input type="text" name="nama_jabatan" id="nama_jabatan" value="{{ old('nama_jabatan') }}"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
            <span class="text-red-500">Jika ingin menambahkan <strong>Subbagian</strong> atau <strong>Jabatan Fungsional</strong>, harap menambahkannya di halaman pegawai dan bukan menambahkannya di halaman ini.</span>
        </div>

        <div class="mb-4">
            <label for="kelompok_jabatan" class="block text-sm font-medium text-gray-700">Kelompok Jabatan</label>
            <select name="kelompok_jabatan" id="kelompok_jabatan" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                <option value="Bidang">Bidang</option>
                <option value="UPTD">UPTD</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="deskripsi_jabatan" class="block text-sm font-medium text-gray-700">Deskripsi Jabatan</label>
            <textarea name="deskripsi_jabatan" id="deskripsi_jabatan" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">{{ old('deskripsi_jabatan') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="tupoksi_jabatan" class="block text-sm font-medium text-gray-700">Tupoksi Jabatan</label>
            <input id="tupoksi_jabatan" type="hidden" name="tupoksi_jabatan" value="{{ old('tupoksi_jabatan') }}">
            <trix-editor input="tupoksi_jabatan"></trix-editor>
        </div>

        <div class="mb-4">
            <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
        </div>
    </form>
@endsection

@section('js')
    <script src="https://unpkg.com/trix/dist/trix.umd.min.js"></script>
@endsection
