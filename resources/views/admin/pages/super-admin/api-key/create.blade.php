@extends('admin.layout')

@section('document.head')
@endsection

@section('document.body')
  <form action="{{ route('admin.super.api-key.store') }}" method="POST">
    @csrf

    <div class="mb-4">
      <label for="name" class="block text-sm font-medium text-gray-700">Nama API</label>
      <input type="text" name="name" id="name"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
      <div class="text-gray-500 text-xs mt-1">Masukkan nama deskriptif untuk memudahkan super admin mengidentifikasikan API ini.</div>
    </div>

    <div class="mb-4">
      <label for="jenis" class="block text-sm font-medium text-gray-700">Jenis API</label>
      <select name="jenis" id="jenis" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
        <option value="1">Jalan Peduli</option>
        <option value="2">Drainase Irigasi</option>
        <option value="3">Sedot Tinja</option>
        <option value="4">Sijakon</option>
      </select>
      <div class="text-gray-500 text-xs mt-1">Pilih layanan yang ingin digunakan.</div>
    </div>

    <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Buat API</button>
  </form>
@endsection

@section('document.end')
@endsection
