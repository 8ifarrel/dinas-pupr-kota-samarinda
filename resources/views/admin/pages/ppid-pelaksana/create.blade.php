@extends('admin.layout')

@section('document.body')
    <form action="{{ route('admin.ppid-pelaksana.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="id_kategori" value="{{ request()->query('kategori') }}">

        <div class="mb-4">
            <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
            <input type="text" name="judul" id="judul"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
        </div>

        <div class="mb-4">
            <label for="file" class="block text-sm font-medium text-gray-700">File</label>
            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file" type="file" name="file" accept=".pdf,.png,.jpg,.jpeg" required>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PDF, PNG, JPG, JPEG</p>
        </div>

        <div class="mb-4">
            <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
        </div>
    </form>
@endsection


