@extends('admin.layout')

@section('document.body')
  <form action="{{ route('admin.agenda-kegiatan.update', $agenda->id) }}" method="POST">
    @csrf
    @method('POST')

    <div class="mb-4">
      <label for="nama" class="block text-sm font-medium text-gray-700">Nama Agenda</label>
      <input type="text" name="nama" id="nama" value="{{ $agenda->nama }}"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
    </div>

    <div class="mb-4">
      <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
      <input type="date" name="tanggal" id="tanggal" value="{{ $agenda->tanggal }}"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
    </div>

    <div class="mb-4">
      <label for="waktu_mulai" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
      <input type="time" name="waktu_mulai" id="waktu_mulai" value="{{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }}"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
    </div>

    <div class="mb-4">
      <label for="tempat" class="block text-sm font-medium text-gray-700">Tempat</label>
      <input type="text" name="tempat" id="tempat" value="{{ $agenda->tempat }}"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
    </div>

    <div class="mb-4">
      <label for="pelaksana" class="block text-sm font-medium text-gray-700">Pelaksana</label>
      <input type="text" name="pelaksana" id="pelaksana" value="{{ $agenda->pelaksana }}"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
    </div>

    <div class="mb-4">
      <label for="dihadiri_oleh" class="block text-sm font-medium text-gray-700">Dihadiri Oleh</label>
      <input type="text" name="dihadiri_oleh" id="dihadiri_oleh" value="{{ $agenda->dihadiri_oleh }}"
        class="mt-1 block w-full p-2 border border-gray-300 rounded-md" />
    </div>

    <div class="mb-4">
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Perbarui</button>
    </div>
  </form>
@endsection
