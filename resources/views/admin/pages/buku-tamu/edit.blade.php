@extends('admin.layout')

@section('document.body')
  <form action="{{ route('admin.buku-tamu.update', $bukuTamu->id_buku_tamu) }}" method="POST">
    @csrf

    <div class="shadow-lg p-6 bg-white rounded-lg border">
      <h2 class="text-xl md:text-2xl font-semibold mb-4">
        Status Kunjungan
      </h2>
      <div class="mb-4">
        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
        <select id="status" name="status" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
          <option value="Pending" {{ $bukuTamu->status == 'Pending' ? 'selected' : '' }}>Pending</option>
          <option value="Diterima" {{ $bukuTamu->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
          <option value="Ditolak" {{ $bukuTamu->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
        <div class="text-gray-500 text-sm mt-1">
          Pilih status untuk menyetujui atau menolak kunjungan. Gunakan status 'Pending' jika permintaan kunjungan masih
          dalam antrean.
        </div>
      </div>
      <div class="mb-4">
        <label for="deskripsi_status" class="block text-sm font-medium text-gray-700">Deskripsi Status</label>
        <textarea id="deskripsi_status" name="deskripsi_status" rows="5"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md">{{ $bukuTamu->deskripsi_status }}
        </textarea>
        <div class="text-gray-500 text-sm mt-1">
          Tuliskan catatan atau alasan untuk memperjelas status kunjungan yang dipilih.
        </div>
      </div>
    </div>

    <div class="shadow-lg p-6 bg-white rounded-lg mt-6 border">
      <h2 class="text-xl md:text-2xl font-semibold mb-4">
        Detail Kunjungan
      </h2>

      <div class="mb-4">
        <label for="id_buku_tamu" class="block text-sm font-medium text-gray-700">Kode</label>
        <input type="text" id="id_buku_tamu" name="id_buku_tamu" value="{{ $bukuTamu->id_buku_tamu }}"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100" disabled />
        <div class="text-gray-500 text-sm mt-1">
          Kode ini bersifat unik untuk setiap permohonan kunjungan dan tidak dapat diubah.
        </div>
      </div>
      <div class="mb-4">
        <label for="nama_pengunjung" class="block text-sm font-medium text-gray-700">Nama Pengunjung</label>
        <input type="text" id="nama_pengunjung" name="nama_pengunjung" value="{{ $bukuTamu->nama_pengunjung }}"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100" disabled />
        <div class="text-gray-500 text-sm mt-1">
          Nama tamu yang mengajukan permohonan kunjungan.
        </div>
      </div>
      <div class="mb-4">
        <label for="nomor_telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon Pengunjung</label>
        <input type="text" id="nomor_telepon" name="nomor_telepon" value="{{ $bukuTamu->nomor_telepon }}"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100" disabled />
        <div class="text-gray-500 text-sm mt-1">
          Anda juga dapat menghubungi pengunjung melalui nomor telepon ini jika diperlukan.
        </div>
      </div>
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email Pengunjung</label>
        <input type="email" id="email" name="email" value="{{ $bukuTamu->email }}"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100" disabled />
        <div class="text-gray-500 text-sm mt-1">
          Email digunakan oleh sistem untuk mengirimkan informasi status kunjungan kepada pengunjung.
        </div>
      </div>
      <div class="mb-4 hidden lg:block">
        <label for="alamat-lg" class="block text-sm font-medium text-gray-700">Alamat Asal Pengunjung</label>
        <textarea id="alamat-lg" name="alamat_lg" rows="2"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100 resize-none" disabled>{{ $bukuTamu->alamat }}</textarea>
        <div class="text-gray-500 text-sm mt-1">
          Informasi alamat tempat tinggal atau instansi asal pengunjung.
        </div>
      </div>
      <div class="mb-4 hidden md:block lg:hidden">
        <label for="alamat-md" class="block text-sm font-medium text-gray-700">Alamat Asal Pengunjung</label>
        <textarea id="alamat-md" name="alamat_md" rows="3"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100 resize-none" disabled>{{ $bukuTamu->alamat }}</textarea>
        <div class="text-gray-500 text-sm mt-1">
          Informasi alamat tempat tinggal atau instansi asal pengunjung.
        </div>
      </div>
      <div class="mb-4 sm:block md:hidden">
        <label for="alamat-sm" class="block text-sm font-medium text-gray-700">Alamat Asal Pengunjung</label>
        <textarea id="alamat-sm" name="alamat_sm" rows="4"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100 resize-none" disabled>{{ $bukuTamu->alamat }}</textarea>
        <div class="text-gray-500 text-sm mt-1">
          Informasi alamat tempat tinggal atau instansi asal pengunjung.
        </div>
      </div>
      <div class="mb-4">
        <label for="susunan_organisasi_yang_dikunjungi" class="block text-sm font-medium text-gray-700">Bagian yang
          Dikunjungi</label>
        <input type="text" id="susunan_organisasi_yang_dikunjungi" name="susunan_organisasi_yang_dikunjungi"
          value="{{ $bukuTamu->susunanOrganisasi->nama_susunan_organisasi ?? '-' }}"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100" disabled />
        <div class="text-gray-500 text-sm mt-1">
          Struktur organisasi yang ingin dituju oleh pengunjung
        </div>
      </div>
      <div class="mb-4">
        <label for="maksud_dan_tujuan" class="block text-sm font-medium text-gray-700">Keperluan</label>
        <textarea id="maksud_dan_tujuan" name="maksud_dan_tujuan" rows="5"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-100" disabled>{{ $bukuTamu->maksud_dan_tujuan }}</textarea>
        <div class="text-gray-500 text-sm mt-1">
          Penjelasan mengenai maksud dan keperluan kunjungan dari pengunjung.
        </div>
      </div>
    </div>
    <div class="mt-6">
      <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md">Simpan</button>
    </div>
  </form>
@endsection
