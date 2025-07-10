@extends('admin.layout')

@section('document.body')
  <a href="{{ route('admin.profil.sejarah-dinas-pupr-kota-samarinda.edit') }}"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
    <i class="fa-solid fa-pencil me-1.5"></i>Edit Sejarah
  </a>

  <div class="mt-10 mb-10">
    @if ($sejarah_dinas_pupr_kota_samarinda)
      <div class="font-dropcap text-multicol">
        {!! $sejarah_dinas_pupr_kota_samarinda->deskripsi_sejarah_dinas_pupr_kota_samarinda !!}
      </div>
    @endif
  </div>
@endsection


