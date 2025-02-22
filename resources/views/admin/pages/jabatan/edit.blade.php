@extends('admin.layouts.jabatan')

@section('css')
    {{-- <link href="https://unpkg.com/trix/dist/trix.css" rel="stylesheet"/>
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
    </style> --}}
@endsection

@section('slot')
    <form action="{{ route('admin.jabatan.update', $jabatan->id_jabatan) }}" method="POST">
        @csrf
        @method('POST')

        <div class="mb-4">
            <label for="nama_jabatan" class="block text-sm font-medium text-gray-700">Nama Jabatan</label>
            <input type="text" name="nama_jabatan" id="nama_jabatan" value="{{ $jabatan->nama_jabatan }}"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
        </div>

        <div class="mb-4">
            <label for="kelompok_jabatan" class="block text-sm font-medium text-gray-700">Kelompok Jabatan</label>
            <select name="kelompok_jabatan" id="kelompok_jabatan" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                <option value="Kepala Dinas" {{ $jabatan->kelompok_jabatan == 'Kepala Dinas' ? 'selected' : '' }}>Kepala Dinas</option>
                <option value="Sekretariat" {{ $jabatan->kelompok_jabatan == 'Sekretariat' ? 'selected' : '' }}>Sekretariat</option>
                <option value="Bidang" {{ $jabatan->kelompok_jabatan == 'Bidang' ? 'selected' : '' }}>Bidang</option>
                <option value="UPTD" {{ $jabatan->kelompok_jabatan == 'UPTD' ? 'selected' : '' }}>UPTD</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="deskripsi_jabatan" class="block text-sm font-medium text-gray-700">Deskripsi Jabatan</label>
            <textarea name="deskripsi_jabatan" id="deskripsi_jabatan" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">{{ $jabatan->deskripsi_jabatan }}</textarea>
        </div>

        {{-- <div class="mb-4">
            <label for="tupoksi_jabatan" class="block text-sm font-medium text-gray-700">Tupoksi Jabatan</label>
            <input id="tupoksi_jabatan" type="hidden" name="tupoksi_jabatan" value="{{ $jabatan->tupoksi_jabatan }}">
            <trix-editor input="tupoksi_jabatan"></trix-editor>
        </div> --}}

        <div class="mb-4">
            <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Perbarui</button>
        </div>
    </form>
@endsection

@section('js')
    {{-- <script src="https://unpkg.com/trix/dist/trix.umd.min.js"></script> --}}
@endsection
