@extends('admin.layouts.profil')

@section('slot')
  <form action="{{ route('admin.profil.visi-dan-misi.update') }}" method="POST">
    @csrf

    <div class="mb-4">
      <label for="periode_mulai" class="block font-medium text-gray-700">Periode Mulai</label>
      <input type="number" name="periode_mulai" id="periode_mulai" value="{{ old('periode_mulai', $visi?->periode_mulai) }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
        min="1900" max="2100" required>
    </div>
    <div class="mb-4">
      <label for="periode_selesai" class="block font-medium text-gray-700">Periode Selesai</label>
      <input type="number" name="periode_selesai" id="periode_selesai"
        value="{{ old('periode_selesai', $visi?->periode_selesai) }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
        min="1900" max="2100" required>
    </div>
    <div class="mb-4">
      <label for="deskripsi_visi" class="block font-medium text-gray-700">Visi</label>
      <input type="text" name="deskripsi_visi" id="deskripsi_visi"
        value="{{ old('deskripsi_visi', $visi?->deskripsi_visi) }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
        required>
    </div>
    <div class="mb-4">
      <label for="misi" class="block font-medium text-gray-700">Misi</label>
      <ol id="misi-list" class="list-decimal pl-5">
        @foreach (old('misi', $misi?->pluck('deskripsi_misi')->toArray() ?? []) as $index => $misiItem)
          <li class="mb-2">
            <input type="text" name="misi[]" value="{{ $misiItem }}"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50"
              required>
            <button type="button" class="mt-1 text-red-500 text-sm" onclick="removeField(this)">Hapus</button>
          </li>
        @endforeach
      </ol>
      <button type="button"
        class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xs px-2.5 py-2 mt-2"
        onclick="addField('misi-list', 'misi[]')">
        <i class="fa-solid fa-plus me-1"></i>Tambah Misi
      </button>
    </div>
    <div class="mb-4">
      <button type="submit"
        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        Simpan
      </button>
      <a href="{{ route('admin.profil.visi-dan-misi.index') }}" class="ml-2 text-gray-700">Batal</a>
    </div>
  </form>
@endsection

@section('js')
  <script>
    function addField(listId, name) {
      const list = document.getElementById(listId);
      const listItem = document.createElement('li');
      listItem.className = 'mb-2';
      listItem.innerHTML = `
      <input type="text" name="${name}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-900 bg-gray-50" required>
      <button type="button" class="mt-1 text-red-500 text-sm" onclick="removeField(this)">Hapus</button>
    `;
      list.appendChild(listItem);
    }

    function removeField(button) {
      button.parentElement.remove();
    }
  </script>
@endsection
