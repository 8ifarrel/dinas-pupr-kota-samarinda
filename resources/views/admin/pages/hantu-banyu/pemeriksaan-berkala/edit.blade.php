@extends('admin.layout')

@section('document.body')
  <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <a href="{{ route('admin.hantu-banyu.pemeriksaan-berkala.index') }}"
      class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg px-3 py-2">
      <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pemeriksaan Berkala
    </a>
  </div>

  <div class="bg-white rounded-lg shadow-lg border p-6">
    <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
      <i class="fa-solid fa-clipboard-check text-blue-600"></i>Edit Pemeriksaan Berkala
    </h3>

    <form method="POST" action="{{ route('admin.hantu-banyu.pemeriksaan-berkala.update', $pemeriksaan->id) }}">
      @csrf
      @method('PUT')

      @include('admin.pages.hantu-banyu.pemeriksaan-berkala._form')

      <div class="flex items-center gap-3 mt-6 pt-4 border-t">
        <button type="submit"
          class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
          Simpan Perubahan
        </button>
        <a href="{{ route('admin.hantu-banyu.pemeriksaan-berkala.index') }}"
          class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">
          Batal
        </a>
      </div>
    </form>
  </div>
@endsection

@section('document.end')
  @include('admin.pages.hantu-banyu.pemeriksaan-berkala._form-script')
@endsection
