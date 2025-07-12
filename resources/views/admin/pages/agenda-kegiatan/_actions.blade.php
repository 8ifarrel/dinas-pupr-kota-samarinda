<div class="flex gap-2">
  <a href="{{ route('admin.agenda-kegiatan.edit', $item->id) }}"
    class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
    <i class="fa-solid fa-pencil"></i>
  </a>
  <button type="button"
    class="btn-delete-agenda flex justify-center items-center w-10 h-10 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm p-2.5 focus:outline-none"
    data-id="{{ $item->id }}" data-nama="{{ $item->nama }}">
    <i class="fa-solid fa-trash-can"></i>
  </button>
</div>
@include('admin.pages.agenda-kegiatan._modal_delete', ['item' => $item])
