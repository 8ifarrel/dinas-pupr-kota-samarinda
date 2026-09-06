@extends('admin.layout')

@section('document.body')
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="sm:flex sm:justify-between mb-5">
      <h2 class="font-semibold text-2xl md:text-3xl mb-5 sm:mb-0">
        Organigram
      </h2>

      <a href="{{ route('admin.struktur-organisasi.organigram.edit', 1) }}"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
        <i class="fa-solid fa-pencil me-1.5"></i>Edit
      </a>
    </div>

    <img src="{{ Storage::url($organigram->diagram_struktur_organisasi) }}" alt="Struktur Organisasi"
      class="border  sm:border-2 md:border-4 border-black p-3">
  </div>
@endsection
