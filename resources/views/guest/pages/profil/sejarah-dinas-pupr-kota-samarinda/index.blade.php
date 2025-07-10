@extends('guest.layouts.profil')

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

<div class="px-5 sm:px-10 py-5 md:py-12 lg:px-24 3xl:px-48">
	@if ($sejarah_dinas_pupr_kota_samarinda)
		<div class="first-letter-custom column-container">
			{!! $sejarah_dinas_pupr_kota_samarinda->deskripsi_sejarah_dinas_pupr_kota_samarinda !!}
		</div>
	@endif
</div>

@endsection


