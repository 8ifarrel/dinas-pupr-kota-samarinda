@extends('guest.layouts.buku-tamu')

@section('slot')
  <div class="h-screen overflow-hidden">
    <img class="absolute h-[40rem] object-cover -z-10" src="{{ asset('image/buku-tamu/sidel_layer.png') }}"
      alt="Background Image" />
    <div class="relative min-h-screen flex px-24 justify-center items-center">
      <div class="flex flex-row mx-10 justify-between items-center translate-x-14">
        <div class="w-1/2 translate-y-10">
          <div class="flex gap-2 mb-2.5">
            <img class="h-[60px]" src="{{ asset('image/logo/pemkot-samarinda.png') }}" alt="Pemerintah Kota Samarinda" />
            <img class="h-[60px]" src="{{ config('app.logo_dinas') }}" alt="{{ config('app.nama_dinas') }}" />
          </div>
          <p class="font-bold text-8xl font-sans mb-8">Buku Tamu <span class="text-brand-yellow">Digital</span></p>
          <p class="text-3xl font-sans mb-8">Selamat Datang di Buku Tamu Digital Dinas Pekerjaan Umum dan Penataan Ruang Kota
            Samarinda</p>
          <div class="pt-4">
            <a href="{{ route('guest.buku-tamu.create') }}"
              class="bg-brand-blue hover:bg-slate-600 text-white text-lg p-4 px-6 rounded-lg font-semibold">Form
              Buku Tamu</a>
          </div>
        </div>
        <div class="flex justify-center items-center -translate-y-10">
          <img class="w-[95%] h-[95%]" src="{{ asset('image/buku-tamu/buble3.png') }}" alt="Sample Image" />
        </div>
      </div>
      <div class="absolute right-0 bottom-[-36rem]">
        <img class="h-auto w-auto object-cover" src="{{ asset('image/buku-tamu/right_side.png') }}" alt="Group Image" />
      </div>
    </div>
  </div>

  {{-- <div class="flex justify-center bg-slate-100 h-screen pt-14">
    <div class="flex flex-col items-center space-y-6">
      <p class="text-3xl font-sans">SAMBUTAN</p>
      <p class="text-7xl font-bold">KEPALA DINAS</p>
      <p class="text-7xl">PUPR KOTA SAMARINDA</p>

      <div class="h-52 w-[70rem] p-10 mt-5 bg-white rounded-3xl flex justify-center pt-10">
        <p class="text-3xl text-center">Kami menampilkan Informasi dalam bentuk <span
            class="text-brand-blue font-semibold">Pelayanan E-Government</span>, sehingga seluruh masyarakat, dapat mengakses
          data terkait Perdagangan.</p>
      </div>
      <div
        class="h-56 w-56 rounded-full overflow-hidden -translate-y-20 p-3 bg-slate-100 border-2 border-brand-blue border-dashed">
        <img class="object-cover h-full w-full rounded-full border-2 border-brand-yellow border-dashed"
          src="{{ asset('image/buku-tamu/budesi.jpg') }}" alt="" />
      </div>
    </div>
  </div>
  <div class="absolute translate-y-[58rem] bottom-[-36rem]">
    <img class="h-auto w-auto object-cover" src="{{ asset('image/buku-tamu/side_yellow.png') }}" alt="Group Image" />
  </div> --}}

  {{-- <div class="container flex mx-auto max-w-screen-lg bg-white pt-14 flex-col text-center items-center space-y-10 ">
    <div class="translate-x-10">
      <p class="text-7xl font-semibold font-sans flex items-center justify-center  ">
        Statistik Kunjungan
        <span class="flex items-center">
          Tamu
          <img src="{{ asset('image/buku-tamu/Highlight 13.png') }}" class="ml-2 inline-block -translate-x-11 -translate-y-5" alt="Highlight">
        </span>
      </p>
    </div>

    <p class="text-3xl font-sans pt-5">Di sini, Anda akan menemukan berbagai data dan informasi menarik mengenai
      pengunjung kami. Mari kita lihat bagaimana interaksi dan keterlibatan pengunjung berkembang dari waktu ke waktu</p>

  </div>

  <div class="flex justify-center items-center space-x-10 pt-14">
    <div class="bg-white border-2 p-3 h-auto w-80 font-semibold font-sans text-2xl">Jumlah Pengunjung
      <p class="text-5xl">1200</p>
    </div>
    <div class="bg-white border-2 p-3 h-auto w-80 font-semibold font-sans text-2xl">Pengunjung Bulan ini
      <p class="text-5xl">1200</p>
    </div>
    <div class="bg-white border-2 p-3 h-auto w-80 font-semibold font-sans text-2xl">Rata-rata Ulasan
      <p class="text-5xl">1200</p>
    </div>
  </div>
  <div class="absolute right-0 bottom-[-138rem]">
    <img class="h-auto w-auto object-cover" src="{{ asset('image/buku-tamu/right_side.png') }}" alt="Group Image" />
  </div> --}}
@endsection


