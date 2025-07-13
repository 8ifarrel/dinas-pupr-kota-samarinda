@extends('admin.layout')

@section('document.head')
  @vite(['resources/css/lightbox.css', 'resources/css/datatables.css', 'resources/js/datatables.js']);
@endsection

@section('document.body')
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="kategori" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th class="w-[85px]">Ikon</th>
            <th>Nama</th>
            <th>Terakhir diperbarui</th>
            <th>Kelola</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($kategori as $item)
            <tr>
              <td>
                <a href="{{ Storage::url($item->ikon_berita_kategori) }}" data-lightbox="ikon_berita_kategori"
                  data-title="{{ $item->susunanOrganisasi->nama_susunan_organisasi ?? '-' }}">
                  <img src="{{ Storage::url($item->ikon_berita_kategori) }}">
                </a>
              </td>
              <td>{{ $item->susunanOrganisasi->nama_susunan_organisasi ?? '-' }}</td>
              <td>
                {{ $item->updated_at ? $item->updated_at->translatedFormat('l, d F Y (H:i)') : '-' }}
              </td>
              <td>
                <div class="flex gap-2">
                  <a href="{{ route('admin.berita.kategori.edit', $item->id_berita_kategori) }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  <a href="{{ route('admin.berita.index', ['id_kategori' => $item->id_berita_kategori]) }}"
                    class="flex justify-center items-center gap-1 h-10 font-medium text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-eye"></i> <span class="font-medium whitespace-nowrap text-sm sm:text-base">Lihat
                      berita</span>
                  </a>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>

        <tfoot>
          <tr>
            <th>Ikon</th>
            <th>Nama</th>
            <th>Terakhir diperbarui</th>
            <th>Kelola</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
@endsection

@section('document.end')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var table = $('#kategori').DataTable();

      document.body.addEventListener('click', function(e) {
        var toggleBtn = e.target.closest('[data-modal-toggle]');
        if (toggleBtn) {
          var modalId = toggleBtn.getAttribute('data-modal-toggle');
          var modalEl = document.getElementById(modalId);
          if (window.Modal && modalEl) {
            if (!modalEl.__flowbiteModal) {
              modalEl.__flowbiteModal = new window.Modal(modalEl);
            }
            modalEl.__flowbiteModal.show();
          }
        }
      });

      document.body.addEventListener('click', function(e) {
        var hideBtn = e.target.closest('[data-modal-hide]');
        if (hideBtn) {
          var modalId = hideBtn.getAttribute('data-modal-hide');
          var modalEl = document.getElementById(modalId);
          if (window.Modal && modalEl && modalEl.__flowbiteModal) {
            modalEl.__flowbiteModal.hide();
          }
        }
      });
    });
  </script>
@endsection