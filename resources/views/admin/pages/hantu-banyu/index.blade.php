@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/datatables.css'])
@endsection

@section('document.body')
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    test ini isi konten
  </div>
@endsection

@section('document.end')
  @vite(['resources/js/datatables.js'])
@endsection
