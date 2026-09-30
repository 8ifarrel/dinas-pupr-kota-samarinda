@extends('guest.layouts.portal')

@section('title'){{ $page_title }} | Hantu Banyu {{ config('app.nama_dinas') }}@endsection

@section('meta-extra')
  <meta name="robots" content="noindex, nofollow">
@endsection

@section('slot')
  <x-guest.login-kelurahan title="Login Hantu Banyu" :action="route('guest.hantu-banyu.login')">
    Masuk dengan <b>akun kelurahan</b> untuk melapor di wilayah Anda sendiri, atau dengan
    <b>akun admin E-Panel</b> untuk mengakses seluruh kelurahan.
  </x-guest.login-kelurahan>
@endsection
