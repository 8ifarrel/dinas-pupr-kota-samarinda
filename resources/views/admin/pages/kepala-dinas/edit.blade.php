{{-- filepath: /d:/Dinas PUPR Kota Samarinda/Website/dinas-pupr-kota-samarinda/resources/views/admin/pages/kepala-dinas/edit.blade.php --}}
@extends('admin.layouts.kepala-dinas')

@section('css')
    <link href="https://unpkg.com/trix/dist/trix.css" rel="stylesheet"/>
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet"/>
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
    <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>

    <style>
      trix-toolbar .trix-button-group--file-tools {
        display: none;
      }
    
      trix-toolbar .trix-button--icon-quote {
        display: none;
      }
    
      trix-toolbar .trix-button--icon-code {
        display: none;
      }

      trix-toolbar .trix-button--icon-heading-1 {
        display: none;
      }

      trix-toolbar .trix-button--icon-link {
        display: none;
      }

      trix-toolbar .trix-button--icon-strike {
        display: none;
      }
    
      trix-editor {
        height: 150px !important; 
        overflow-y: auto;
      }
    
      trix-editor h1 {
        font-size: 1.25rem !important;
        line-height: 1.25rem !important;
        margin-bottom: 1rem;
        font-weight: 600;
      }
    
      trix-editor a:not(.no-underline) {
        text-decoration: underline;
      }
    
      trix-editor a:visited {
        color: blue;
      }
    
      trix-editor ul { 
        list-style-type: disc !important; margin-left: 1rem !important; 
      }
      trix-editor ol { 
        list-style-type: decimal !important; margin-left: 1rem !important; 
      }
    </style>
@endsection

@section('slot')
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5 border">
    <form action="{{ route('admin.kepala-dinas.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      
      <h2 class="font-semibold text-2xl mb-5 md:text-3xl">
        Profil Pegawai
      </h2>

      <div class="mb-4">
        <label for="nama_pegawai" class="block font-medium text-gray-700">Nama Pegawai</label>
        <input type="text" name="nama_pegawai" id="nama_pegawai" value="{{ $kepalaDinas->nama_pegawai }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" required>
      </div>
      <div class="mb-4">
        <label for="nomor_induk_pegawai" class="block font-medium text-gray-700">Nomor Induk Pegawai</label>
        <input type="text" name="nomor_induk_pegawai" id="nomor_induk_pegawai" value="{{ $kepalaDinas->nomor_induk_pegawai }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50">
      </div>
      <div class="mb-4">
        <label for="nomor_telepon_pegawai" class="block font-medium text-gray-700">Nomor Telepon</label>
        <input type="text" name="nomor_telepon_pegawai" id="nomor_telepon_pegawai" value="{{ $kepalaDinas->nomor_telepon_pegawai }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50">
      </div>
      <div class="mb-4">
        <label for="golongan_pegawai" class="block font-medium text-gray-700">Golongan</label>
        <input type="text" name="golongan_pegawai" id="golongan_pegawai" value="{{ $kepalaDinas->golongan_pegawai }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50">
      </div>
      <div class="mb-4 relative">
        <label for="foto_pegawai" class="block font-medium text-gray-700">Foto Pegawai</label>
        <span class="text-xs text-gray-700">Kosongi bagian ini jika tetap ingin menggunakan foto sebelumnya</span>
        <input type="file" name="foto_pegawai" id="foto_pegawai" class="mt-1" />
        <a type="button" id="edit-image-button" style="display:none;" class="p-1 bg-black border-2 border-white text-white rounded-full absolute left-1/2 transform -translate-x-1/2 bottom-7">
          <i class="fa-solid fa-pencil p-1"></i>
        </a>
      </div>
      <div class="mb-4">
        <label for="deskripsi_jabatan" class="block font-medium text-gray-700">Deskripsi Jabatan</label>
        <textarea name="deskripsi_jabatan" id="deskripsi_jabatan" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ $kepalaDinas->jabatan->deskripsi_jabatan }}</textarea>
      </div>
      <div class="mb-4">
        <label for="tupoksi_jabatan" class="block font-medium text-gray-700">Tupoksi Jabatan</label>
        <input id="tupoksi_jabatan" type="hidden" name="tupoksi_jabatan" value="{{ $kepalaDinas->jabatan->tupoksi_jabatan }}">
        <trix-editor input="tupoksi_jabatan"></trix-editor>
      </div>
      <div class="mb-4">
        <label for="periode_jabatan" class="block font-medium text-gray-700">Periode Jabatan</label>
        <div class="flex gap-2 items-center">
          <input type="number" name="periode_mulai" id="periode_mulai" value="{{ $visi->first()->periode_mulai }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" min="1900" max="2100" required>
          <span>-</span>
          <input type="number" name="periode_selesai" id="periode_selesai" value="{{ $visi->first()->periode_selesai }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" min="1900" max="2100" required>
        </div>
      </div>
      <div class="mb-4">
        <label for="visi" class="block font-medium text-gray-700">Visi</label>
        <input type="text" name="visi" id="visi" value="{{ $visi->first()->deskripsi_visi }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50">
      </div>
      <div class="mb-4">
        <label for="misi" class="block font-medium text-gray-700">Misi</label>
        <ol id="misi-list" class="list-decimal pl-5">
          @foreach ($misi as $misiItem)
            <li class="mb-2">
              <input type="text" name="misi[]" value="{{ $misiItem->deskripsi_misi }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" required>
              <button type="button" class="mt-1 text-red-500 text-sm" onclick="removeField(this)">Hapus</button>
            </li>
          @endforeach
        </ol>
        <button type="button" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xs px-2.5 py-2 mt-2" onclick="addField('misi-list', 'misi[]')">
          <i class="fa-solid fa-plus me-1"></i>Tambah Misi
        </button>
      </div>
      <div class="mb-4">
        <label for="riwayat_pendidikan" class="block font-medium text-gray-700">Riwayat Pendidikan</label>
        <ul id="riwayat-pendidikan-list" class="list-disc pl-5">
          @foreach ($riwayatPendidikan->sortBy('tanggal_masuk') as $pendidikan)
            <li class="mb-2">
              <input type="text" name="riwayat_pendidikan[]" value="{{ $pendidikan->nama_pendidikan }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" required>
              <input type="date" name="tanggal_masuk_pendidikan[]" value="{{ $pendidikan->tanggal_masuk }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" required>
              <button type="button" class="mt-1 text-red-500 text-sm" onclick="removeField(this)">Hapus</button>
            </li>
          @endforeach
        </ul>
        <button type="button" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xs px-2.5 py-2 mt-2" onclick="addField('riwayat-pendidikan-list', 'riwayat_pendidikan[]', 'tanggal_masuk_pendidikan[]')">
          <i class="fa-solid fa-plus me-1"></i>Tambah Riwayat Pendidikan
        </button>
      </div>
      <div class="mb-4">
        <label for="jenjang_karir" class="block font-medium text-gray-700">Jenjang Karir</label>
        <ul id="jenjang-karir-list" class="list-disc pl-5">
          @foreach ($jenjangKarir->sortBy('tanggal_masuk') as $karir)
            <li class="mb-2">
              <input type="text" name="jenjang_karir[]" value="{{ $karir->nama_karir }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" required>
              <input type="date" name="tanggal_masuk_karir[]" value="{{ $karir->tanggal_masuk }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" required>
              <button type="button" class="mt-1 text-red-500 text-sm" onclick="removeField(this)">Hapus</button>
            </li>
          @endforeach
        </ul>
        <button type="button" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xs px-2.5 py-2 mt-2" onclick="addField('jenjang-karir-list', 'jenjang_karir[]', 'tanggal_masuk_karir[]')">
          <i class="fa-solid fa-plus me-1"></i>Tambah Jenjang Karir
        </button>
      </div>

      <h2 class="font-semibold text-2xl my-5 md:text-3xl">
        Akun Pegawai
      </h2>
      
      <div class="mb-4">
        <label for="current_password" class="block font-medium text-gray-700">Password Sekarang</label>
        <input type="password" name="current_password" id="current_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50">
        <span class="text-xs text-gray-700">Anda wajib mengisi ini jika ingin mengedit akun. Tidak perlu mengisi jika hanya mengedit profil.</span>
      </div>
      <div class="mb-4">
        <label for="username" class="block font-medium text-gray-700">Username</label>
        <input type="text" name="username" id="username" value="{{ $kepalaDinas->user->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" required>
      </div>
      <div class="mb-4">
        <label for="email" class="block font-medium text-gray-700">Email</label>
        <input type="email" name="email" id="email" value="{{ $kepalaDinas->user->email }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" required>
      </div>
      <div class="mb-4">
        <label for="password" class="block font-medium text-gray-700">Password Baru</label>
        <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50">
        <span class="text-xs text-gray-700">Kosongi bagian ini jika tidak ingin mengubah password</span>
      </div>

      <div class="mb-4">
        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Update
        </button>
      </div>
    </form>
  </div>

  <!-- Modal -->
  <div id="cropperModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Crop Image
          </h3>
          <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="cropperModal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5 space-y-4">
          <div>
            <img id="image-to-crop" src="" alt="Image to crop" />
          </div>
        </div>
        <!-- Modal footer -->
        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
          <button type="button" id="crop-button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Crop</button>
          <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" data-modal-hide="cropperModal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
    @vite('resources/js/admin/pegawai.js')

    <script src="https://unpkg.com/trix/dist/trix.umd.min.js"></script>
    
    <script>
        function addField(listId, name, dateName) {
            const list = document.getElementById(listId);
            const listItem = document.createElement('li');
            listItem.className = 'mb-2';
            listItem.innerHTML = `
                <input type="text" name="${name}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50">
                <input type="date" name="${dateName}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50">
                <button type="button" class="mt-1 text-red-500 text-sm" onclick="removeField(this)">Hapus</button>
            `;
            list.appendChild(listItem);
        }

        function removeField(button) {
            button.parentElement.remove();
        }
    </script>
@endsection