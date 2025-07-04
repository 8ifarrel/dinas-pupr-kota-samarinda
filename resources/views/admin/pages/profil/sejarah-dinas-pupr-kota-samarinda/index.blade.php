@extends('admin.layouts.profil')

@section('css')
  <style>
    .first-letter-custom div:first-of-type::first-letter {
      text-transform: capitalize;
      font-size: 4.5rem;
      font-weight: 600;
      letter-spacing: 0.1em;
      line-height: 1;
      display: inline-block;
      float: left;
    }

    .column-container {
      text-align: justify;
    }

    .column-container p {
      margin-bottom: 1rem;
    }

    @media (min-width: 768px) {
      .column-container {
        column-count: 2;
        column-gap: 2rem;
      }

      .column-container p {
        break-inside: avoid;
        margin-bottom: 2rem;
      }
    }
  </style>
@endsection

@section('slot')
  <a href="{{ route('admin.profil.sejarah-dinas-pupr-kota-samarinda.edit') }}"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
    <i class="fa-solid fa-pencil me-1.5"></i>Edit Sejarah
  </a>

  <div class="mt-10 mb-10">
    @if ($sejarah_dinas_pupr_kota_samarinda)
      <div class="first-letter-custom column-container">
        {!! $sejarah_dinas_pupr_kota_samarinda->deskripsi_sejarah_dinas_pupr_kota_samarinda !!}
      </div>
    @endif
  </div>
@endsection
