@extends('guest.layouts.buku-tamu')

@section('document.head')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('document.body')
  {{-- <img class="fixed w-full h-full object-cover -z-10 brightness-50" src="{{ asset('image/background/buku-tamu/isi-formulir.png') }}" alt="Background Image" /> --}}
  <div class="relative min-h-screen flex justify-center items-center p-4">
    <div class="absolute inset-0 z-0 pointer-events-none">
      <img src="{{ asset('image/hero/drainase-irigasi.jpeg') }}" alt="Peta Samarinda"
        class="w-full h-full object-cover opacity-25 blur-[2px]" />
      <div class="absolute inset-0 bg-gradient-to-b from-brand-blue/70 via-white/10 to-white"></div>
    </div>
    <div class="relative bg-white/75 rounded-3xl p-7 lg:p-9 shadow-xl w-full xl:max-w-6xl 2xl:max-w-7xl 3xl:max-w-[1600px]">
      <div class="flex justify-between items-center mb-5">
        <div>
          <h1 class="w-full text-3xl 2xl:text-4xl 3xl:text-5xl font-medium text-gray-800">
            Isi Formulir
            <span class="xl:text-4xl 2xl:text-5xl 3xl:text-6xl font-bold">Buku Tamu</span>
          </h1>
          <p class="text-xl text-gray-600">Silakan isi buku tamu digital ini sebagai tanda kunjungan Anda.</p>
        </div>
        <div class="flex gap-2.5">
          <img class="xl:h-14 2xl:h-16 3xl:h-20" src="{{ config('app.logo_pemkot') }}"
            alt="{{ config('app.nama_pemkot') }}" />
          <img class="xl:h-14 2xl:h-16 3xl:h-20" src="{{ config('app.logo_dinas') }}"
            alt="{{ config('app.nama_dinas') }}" />
        </div>
      </div>
      <form method="POST" action="{{ route('guest.buku-tamu.store') }}" autocomplete="off">
        @csrf

        {{-- Nama Pengunjung --}}
        <div class="mb-3">
          <label for="nama_pengunjung" class="block text-slate-700 text-xl font-semibold mb-1">Nama Pengunjung</label>
          <input type="text" id="nama_pengunjung" name="nama_pengunjung" value="{{ old('nama_pengunjung') }}" required
            class="mt-1 block w-full p-3 text-lg border border-gray-300 rounded-xl" />
          <div class="text-gray-500 mt-1 text-lg">Masukkan nama lengkap Anda</div>
        </div>

        {{-- Nomor Telepon --}}
        <div class="mb-3">
          <label for="nomor_telepon" class="block text-slate-700 text-xl font-semibold mb-1">Nomor Telepon
            Pengunjung</label>
          <input type="text" id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}" required
            class="mt-1 block w-full p-3 text-lg border border-gray-300 rounded-xl" />
          <div class="text-gray-500 mt-1 text-lg">Masukkan nomor telepon yang dapat dihubungi melalui WhatsApp</div>
        </div>

        {{-- Alamat Asal --}}
        <div class="mb-3">
          <label for="alamat" class="block text-slate-700 text-xl font-semibold mb-1">Alamat Asal Pengunjung</label>
          <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}" required
            class="mt-1 block w-full p-3 text-lg border border-gray-300 rounded-xl" />
          <div class="text-gray-500 mt-1 text-lg">Masukkan alamat asal Anda</div>
        </div>

        {{-- Bagian yang Akan Dikunjungi --}}
        <div class="mb-3">
          <label for="jabatan_yang_dikunjungi" class="block text-slate-700 text-xl font-semibold mb-1">
            Bagian yang Akan Dikunjungi
          </label>
          <select id="jabatan_yang_dikunjungi" name="jabatan_yang_dikunjungi" required
            class="mt-1 block w-full p-3 text-lg border border-gray-300 rounded-xl">
            <option value="">-- Pilih susunan organisasi --</option>
            @foreach ($jabatan as $item)
              <option value="{{ $item->id_susunan_organisasi }}"
                {{ old('jabatan_yang_dikunjungi') == $item->id_susunan_organisasi ? 'selected' : '' }}>
                {{ $item->nama_susunan_organisasi }}
              </option>
            @endforeach
          </select>
          <div class="text-gray-500 mt-1 text-lg">Pilih bagian (susunan organisasi) yang akan Anda kunjungi</div>
        </div>

        {{-- Keperluan --}}
        <div class="mb-5">
          <label for="maksud_dan_tujuan" class="block text-slate-700 text-xl font-semibold mb-1">Keperluan</label>
          <textarea id="maksud_dan_tujuan" name="maksud_dan_tujuan" rows="2" required
            class="mt-1 block w-full p-3 text-lg border border-gray-300 rounded-xl">{{ old('maksud_dan_tujuan') }}</textarea>
          <div class="text-gray-500 mt-1 text-lg">Jelaskan keperluan kunjungan Anda</div>
        </div>

        {{-- Tombol Submit --}}
        <div class="flex justify-between items-center">
          <button type="submit" class="py-3 px-6 bg-brand-blue text-white rounded-xl font-semibold shadow-md text-xl">
            Ajukan Kunjungan
          </button>

          <a href="{{ route('guest.buku-tamu.index') }}" class="text-lg">
            <i class="fa-solid fa-arrow-right-from-bracket me-1.5 text-blue-600"></i><span
              class="text-blue-600 underline">Kembali ke halaman utama</span>
          </a>
        </div>
      </form>
    </div>
  </div>
@endsection
