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
@if (session('success'))
  <div id="alert-success" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-100" role="alert">
    <svg class="flex-shrink-0 w-4 h-4 me-2" fill="currentColor" viewBox="0 0 20 20">
      <path d="M16.707 5.293a1 1 0 0 0-1.414 0L8 12.586l-3.293-3.293A1 1 0 0 0 3.293 10.707l4 4a1 1 0 0 0 1.414 0l8-8a1 1 0 0 0 0-1.414z" />
    </svg>
    <div class="ms-3 text-sm font-medium">
      {{ session('success') }}
    </div>
    <button type="button" class="ms-auto bg-green-100 text-green-500 rounded-lg p-1.5 hover:bg-green-200" data-dismiss-target="#alert-success" aria-label="Close">
      <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
        <path stroke="currentColor" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
      </svg>
    </button>
  </div>
@endif

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
