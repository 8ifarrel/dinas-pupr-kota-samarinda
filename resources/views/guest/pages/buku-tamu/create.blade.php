@extends('guest.layouts.buku-tamu')

@section('slot')
  <img class="fixed w-full h-full object-cover -z-10" src="{{ asset('image/buku-tamu/bg_form.png') }}"
    alt="Background Image" />
  <div class="min-h-screen flex justify-center items-center p-4">
    <div class="bg-white border rounded-xl p-7 lg:p-9 shadow-2xl w-full xl:max-w-6xl 2xl:max-w-7xl 3xl:max-w-[1600px]">
      <h1
        class="w-full relative inline-block text-2xl 2xl:text-3xl 3xl:text-4xl text-center font-bold mb-5 text-gray-800
         before:content-[''] before:inline-block before:h-[3px] before:bg-black before:align-middle before:mr-1 before:min-w-[225px]
         after:content-[''] after:inline-block after:h-[3px] after:bg-black after:align-middle after:ml-1 after:min-w-[225px]">
        Formulir Buku Tamu Dinas PUPR Kota Samarinda
      </h1>
      <form method="POST" action="{{ route('guest.buku-tamu.store') }}" autocomplete="off">
        @csrf

        {{-- Nama Pengunjung --}}
        <div class="mb-3">
          <label for="nama_pengunjung" class="block text-slate-700 text-lg font-semibold mb-1">Nama Pengunjung</label>
          <input type="text" id="nama_pengunjung" name="nama_pengunjung" value="{{ old('nama_pengunjung') }}" required
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md" />
          <div class="text-gray-500 mt-1">Masukkan nama lengkap Anda</div>
        </div>

        {{-- Nomor Telepon --}}
        <div class="flex gap-3">
          <div class="mb-3 w-1/2">
            <label for="nomor_telepon" class="block text-slate-700 text-lg font-semibold mb-1">Nomor Telepon Pengunjung</label>
            <input type="text" id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}" required
              class="mt-1 block w-full p-2 border border-gray-300 rounded-md" />
            <div class="text-gray-500 mt-1">Masukkan nomor telepon yang dapat dihubungi melalui WhatsApp</div>
          </div>

          {{-- Email --}}
          <div class="mb-3 w-1/2">
            <label for="email" class="block text-slate-700 text-lg font-semibold mb-1">Email Pengunjung</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
              class="mt-1 block w-full p-2 border border-gray-300 rounded-md" />
            <div class="text-gray-500 mt-1">Masukkan email yang aktif agar Anda dapat memantau status kunjungan</div>
          </div>
        </div>

        {{-- Alamat Asal --}}
        <div class="mb-3">
          <label for="alamat" class="block text-slate-700 text-lg font-semibold mb-1">Alamat Asal Pengunjung</label>
          <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}" required
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md" />
          <div class="text-gray-500 mt-1">Masukkan alamat asal Anda</div>
        </div>

        {{-- Bagian yang Akan Dikunjungi --}}
        <div class="mb-3">
          <label for="jabatan_yang_dikunjungi" class="block text-slate-700 text-lg font-semibold mb-1">
            Bagian yang Akan Dikunjungi
          </label>
          <select id="jabatan_yang_dikunjungi" name="jabatan_yang_dikunjungi" required
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            <option value="">-- Pilih susunan organisasi --</option>
            @foreach ($jabatan as $item)
              <option value="{{ $item->id_susunan_organisasi }}"
                {{ old('jabatan_yang_dikunjungi') == $item->id_susunan_organisasi ? 'selected' : '' }}>
                {{ $item->nama_susunan_organisasi }}
              </option>
            @endforeach
          </select>
          <div class="text-gray-500 mt-1">Pilih bagian (susunan organisasi) yang akan Anda kunjungi</div>
        </div>

        {{-- Keperluan --}}
        <div class="mb-3">
          <label for="maksud_dan_tujuan" class="block text-slate-700 text-lg font-semibold mb-1">Keperluan</label>
          <textarea id="maksud_dan_tujuan" name="maksud_dan_tujuan" rows="2" required
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">{{ old('maksud_dan_tujuan') }}</textarea>
          <div class="text-gray-500 mt-1">Jelaskan keperluan kunjungan Anda</div>
        </div>

        {{-- Tombol Submit --}}
        <div class="flex justify-between items-center">
          <button type="submit" class="py-3 px-6 bg-brand-blue text-white rounded-md font-semibold shadow-md text-lg ">
            Ajukan kunjungan
          </button>

          <a href="{{ route('guest.buku-tamu.index') }}" class="text-lg">
            <i class="fa-solid fa-arrow-right-from-bracket me-1.5"></i>Kembali ke halaman utama
          </a>
        </div>
      </form>
    </div>
  </div>
@endsection


