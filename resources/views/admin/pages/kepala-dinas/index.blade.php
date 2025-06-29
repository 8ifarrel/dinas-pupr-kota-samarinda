{{-- filepath: /d:/Dinas PUPR Kota Samarinda/Website/dinas-pupr-kota-samarinda/resources/views/admin/pages/kepala-dinas/index.blade.php --}}
@extends('admin.layouts.kepala-dinas')

@section('slot')
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5 border">
    @foreach ($kepalaDinas as $item)
      <div class="flex flex-col md:flex-row items-center mb-4">
        <img src="{{ asset('storage/' . $item->foto_pegawai) }}" alt="Foto Pegawai" class="w-32 h-32 md:w-40 md:h-40 mr-4">
        <div class="w-full">
          <div class="text-center md:text-left">
            <h2 class="text-2xl font-bold">{{ $item->nama_pegawai }}</h2>
            @foreach ($visi as $periode)
              <span class="text-gray-600 font-semibold">Periode {{ $periode->periode_mulai }} - {{ $periode->periode_selesai }}</span>
            @endforeach
          </div>
          <div class="mt-2">
            <p class="text-gray-600">NIP: {{ $item->nomor_induk_pegawai }}</p>
            <p class="text-gray-600">Golongan: {{ $item->golongan_pegawai }}</p>
            <p class="text-gray-600">Telepon: {{ $item->nomor_telepon_pegawai }}</p>
            <p class="text-gray-600">Email: {{ $item->user->email }}</p>
            <p class="text-gray-600">Username: {{ $item->user->name }}</p>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <h3 class="text-xl font-semibold">Deskripsi Jabatan</h3>
        <p>{!! $item->jabatan->deskripsi_susunan_organisasi !!}</p>
      </div>
      <div class="mb-4">
        <h3 class="text-xl font-semibold">Tupoksi Jabatan</h3>
        <p>{!! $item->jabatan->tupoksi_jabatan !!}</p>
      </div>
    @endforeach

    <div class="mb-4">
      <h3 class="text-xl font-semibold">Visi</h3>
      @foreach ($visi as $item)
        <p>{{ $item->deskripsi_visi }}</p>
      @endforeach
    </div>

    <div class="mb-4">
      <h3 class="text-xl font-semibold">Misi</h3>
      <ul class="list-decimal pl-5">
        @foreach ($misi as $item)
          <li>{!! $item->deskripsi_misi !!}</li>
        @endforeach
      </ul>
    </div>

    <div class="mb-4">
      <h3 class="text-xl font-semibold">Riwayat Pendidikan</h3>
      <ul class="list-disc pl-5">
        @foreach ($riwayatPendidikan as $item)
          <li>{{ $item->nama_pendidikan }} ({{ $item->tanggal_masuk }})</li>
        @endforeach
      </ul>
    </div>

    <div class="mb-4">
      <h3 class="text-xl font-semibold">Jenjang Karir</h3>
      <ul class="list-disc pl-5">
        @foreach ($jenjangKarir as $karir)
          <li>{{ $karir->nama_karir }} ({{ $karir->tanggal_masuk }})</li>
        @endforeach
      </ul>
    </div>
  </div>
@endsection