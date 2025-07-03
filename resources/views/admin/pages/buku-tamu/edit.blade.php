@extends('admin.layouts.buku-tamu')

@section('slot')
  <form action="{{ route('admin.buku-tamu.update', $bukuTamu->id_buku_tamu) }}" method="POST">
    @csrf
    <div class="mb-4">
      <label for="id_buku_tamu" class="block text-sm font-medium text-gray-700">ID Buku Tamu</label>
      <input type="text" id="id_buku_tamu" name="id_buku_tamu" value="{{ $bukuTamu->id_buku_tamu }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100" disabled />
    </div>
    <div class="mb-4">
      <label for="nama_pengunjung" class="block text-sm font-medium text-gray-700">Nama Pengunjung</label>
      <input type="text" id="nama_pengunjung" name="nama_pengunjung" value="{{ $bukuTamu->nama_pengunjung }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100" disabled />
    </div>
    <div class="mb-4">
      <label for="nomor_telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
      <input type="text" id="nomor_telepon" name="nomor_telepon" value="{{ $bukuTamu->nomor_telepon }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100" disabled />
    </div>
    <div class="mb-4">
      <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
      <input type="email" id="email" name="email" value="{{ $bukuTamu->email }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100" disabled />
    </div>
    <div class="mb-4">
      <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
      <input type="text" id="alamat" name="alamat" value="{{ $bukuTamu->alamat }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100" disabled />
    </div>
    <div class="mb-4">
      <label for="jabatan_yang_dikunjungi" class="block text-sm font-medium text-gray-700">Jabatan yang Dikunjungi</label>
      <input type="text" id="jabatan_yang_dikunjungi" name="jabatan_yang_dikunjungi" value="{{ $bukuTamu->jabatan->nama_jabatan }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100" disabled />
    </div>
    <div class="mb-4">
      <label for="maksud_dan_tujuan" class="block text-sm font-medium text-gray-700">Maksud dan Tujuan</label>
      <textarea id="maksud_dan_tujuan" name="maksud_dan_tujuan" rows="5" class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100" disabled>{{ $bukuTamu->maksud_dan_tujuan }}</textarea>
    </div>
    <div class="mb-4">
      <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
      <select id="status" name="status" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        <option value="Pending" {{ $bukuTamu->status == 'Pending' ? 'selected' : '' }}>Pending</option>
        <option value="Diterima" {{ $bukuTamu->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
        <option value="Ditolak" {{ $bukuTamu->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
      </select>
    </div>
    <div class="mb-4">
      <label for="deskripsi_status" class="block text-sm font-medium text-gray-700">Deskripsi Status</label>
      <textarea id="deskripsi_status" name="deskripsi_status" rows="5" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">{{ $bukuTamu->deskripsi_status }}</textarea>
    </div>
    <div class="mb-4">
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
    </div>
  </form>
@endsection
