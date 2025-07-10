@extends('admin.layout')

@section('document.body')
    <form action="{{ route('admin.ppid-pelaksana.kategori.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
            <input type="text" name="nama" id="nama"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
        </div>

        <div class="mb-4">
            <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
        </div>
    </form>
@endsection

