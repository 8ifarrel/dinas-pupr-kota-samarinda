@extends('guest.layouts.buku-tamu')

@section('slot')
  <img class="fixed w-full h-full object-cover -z-10" src="{{ asset('image/buku-tamu/bg_form.png') }}" alt="Background Image" />
  <div class="min-h-screen flex justify-center items-center p-4">
    <div class="bg-white rounded-3xl p-8 lg:p-10 shadow-2xl w-full xl:max-w-6xl 2xl:max-w-7xl 3xl:max-w-[1600px]">
      <h1 class="text-2xl 2xl:text-3xl 3xl:text-4xl text-center font-bold mb-6">Form Buku Tamu</h1>
      <form method="POST" action="{{ route('guest.buku-tamu.store') }}" class="grid grid-cols-1 lg:grid-cols-4 gap-3 2xl:gap-5">
        @csrf
        {{-- Baris 1: Nama dan Nomor Telepon --}}
        <div class="lg:col-span-3">
          <label for="nama_pengunjung" class="block text-slate-700 text-lg 3xl:text-2xl font-semibold">Nama Pengunjung</label>
          <input type="text" id="nama_pengunjung" name="nama_pengunjung" class="mt-2 3xl:text-2xl block w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required />
        </div>
        <div class="lg:col-span-1">
          <label for="nomor_telepon" class="block text-slate-700 text-lg 3xl:text-2xl font-semibold">Nomor Telepon</label>
          <input type="text" id="nomor_telepon" name="nomor_telepon" class="mt-2 3xl:text-2xl block w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required />
        </div>
        {{-- Baris 2: Email dan Alamat Asal --}}
        <div class="lg:col-span-3">
          <label for="alamat" class="block text-slate-700 text-lg 3xl:text-2xl font-semibold">Alamat Asal</label>
          <input type="text" id="alamat" name="alamat" class="mt-2 3xl:text-2xl block w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required />
        </div>
        <div class="lg:col-span-1">
          <label for="email" class="block text-slate-700 text-lg 3xl:text-2xl font-semibold">Email</label>
          <input type="email" id="email" name="email" class="mt-2 3xl:text-2xl block w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required />
        </div>
        {{-- Baris 3: Jabatan yang ingin dikunjungi --}}
        <div class="lg:col-span-4">
          <label for="jabatan_yang_dikunjungi" class="block text-slate-700 text-lg 3xl:text-2xl font-semibold">Jabatan yang ingin dikunjungi</label>
          <select id="jabatan_yang_dikunjungi" name="jabatan_yang_dikunjungi" class="mt-2 3xl:text-2xl block w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @foreach ($jabatan as $item)
              <option value="{{ $item->id_jabatan }}">{{ $item->nama_jabatan }}</option>
            @endforeach
          </select>
        </div>
        {{-- Baris 4: Maksud dan Tujuan --}}
        <div class="lg:col-span-4">
          <label for="maksud_dan_tujuan" class="block text-slate-700 text-lg 3xl:text-2xl font-semibold">Maksud dan Tujuan</label>
          <textarea id="maksud_dan_tujuan" name="maksud_dan_tujuan" rows="5" class="mt-2 3xl:text-2xl block w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
        </div>
        {{-- Tombol Submit --}}
        <div class="lg:col-span-4">
          <button type="submit" class="w-full py-3 3xl:py-5 bg-blue text-white rounded-md font-semibold shadow-md text-lg 3xl:text-2xl">Ajukan Kunjungan</button>
        </div>
      </form>
    </div>
  </div>
@endsection