@extends('admin.layouts.susunan-organisasi')

@section('css')
  {{-- DataTables --}}
  <link href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css" rel="stylesheet" />
@endsection

@section('slot')
  <a href="{{ route('admin.susunan-organisasi.create') }}"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
    <i class="fa-solid fa-plus me-1"></i>Tambah Susunan Organisasi
  </a>

  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="susunan-organisasi" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th></th>
            <th>#</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Kelola</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($susunan_organisasi as $item)
            @if (empty($item->id_susunan_organisasi_parent) || $item->id_susunan_organisasi_parent == 0 || $item->id_susunan_organisasi_parent == 1)
              <tr 
                @if($item->children && count($item->children) > 0 && $item->kelompok_susunan_organisasi !== 'Kepala Dinas')
                  data-children="{{ json_encode($item->children) }}"
                @endif
              >
                <td class="{{ ($item->children && count($item->children) > 0 && $item->kelompok_susunan_organisasi !== 'Kepala Dinas') ? 'dt-control' : '' }}"></td>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_susunan_organisasi }}</td>
                <td>
                  @if ($item->deskripsi_susunan_organisasi)
                    <button type="button"
                      class="inline-flex justify-center items-center gap-1 h-8 font-medium text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm p-2.5 focus:outline-none"
                      data-modal-target="deskripsiModal-{{ $item->id_susunan_organisasi }}"
                      data-modal-toggle="deskripsiModal-{{ $item->id_susunan_organisasi }}">
                      <i class="fa-solid fa-eye"></i> <span
                        class="font-medium whitespace-nowrap text-xs sm:text-sm">Lihat</span>
                    </button>
                  @else
                    <span
                      class="bg-gray-100 text-gray-800 text-xs font-bold me-2 px-1 py-0.5 rounded border border-gray-500">
                      Belum diisi
                    </span>
                  @endif
                </td>
                <td>
                  <div class="flex gap-2">
                    <a href="{{ route('admin.susunan-organisasi.edit', $item->id_susunan_organisasi) }}"
                      class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
                      <i class="fa-solid fa-pencil"></i>
                    </a>
                    @if ($item->id_susunan_organisasi != 1)
                      <button data-modal-target="deleteModal-{{ $item->id_susunan_organisasi }}"
                        data-modal-toggle="deleteModal-{{ $item->id_susunan_organisasi }}"
                        class="flex justify-center items-center w-10 h-10 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm p-2.5 focus:outline-none">
                        <i class="fa-solid fa-trash-can"></i>
                      </button>
                    @endif
                  </div>
                </td>
              </tr>

              <!-- Modal Deskripsi -->
              <div id="deskripsiModal-{{ $item->id_susunan_organisasi }}" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
                data-modal-target="deskripsiModal-{{ $item->id_susunan_organisasi }}">
                <div class="relative p-4 w-full max-w-4xl max-h-full">
                  <!-- Modal content -->
                  <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                      <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Deskripsi Susunan
                      </h3>
                      <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="deskripsiModal-{{ $item->id_susunan_organisasi }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                          viewBox="0 0 14 14">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                      </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                      <div>
                        {!! $item->deskripsi_susunan_organisasi !!}
                      </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                      <button type="button"
                        class="bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-400 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                        data-modal-hide="deskripsiModal-{{ $item->id_susunan_organisasi }}">Tutup</button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal Konfirmasi Hapus -->
              @if ($item->id_susunan_organisasi != 1)
                <div id="deleteModal-{{ $item->id_susunan_organisasi }}" data-modal-backdrop="static" tabindex="-1"
                  aria-hidden="true"
                  class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                  <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                      <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                          Konfirmasi Penghapusan
                        </h3>
                        <button type="button"
                          class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                          data-modal-hide="deleteModal-{{ $item->id_susunan_organisasi }}">
                          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                          </svg>
                          <span class="sr-only">Close modal</span>
                        </button>
                      </div>
                      <div class="p-4 md:p-5 space-y-4">
                        <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                          Apakah Anda yakin ingin menghapus susunan-organisasi
                          <strong>{{ $item->nama_susunan_organisasi }}</strong>? Anda secara
                          otomatis akan juga menghapus pegawai, subbagian, dan susunan-organisasi fungsional yang ada pada
                          {{ $item->nama_susunan_organisasi }}
                        </p>
                      </div>
                      <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <form action="{{ route('admin.susunan-organisasi.destroy', $item->id_susunan_organisasi) }}"
                          method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Hapus</button>
                        </form>
                        <button type="button"
                          class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                          data-modal-hide="deleteModal-{{ $item->id_susunan_organisasi }}">
                          Tidak
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            @endif
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th></th>
            <th>#</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Kelola</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
@endsection

@section('js')
  {{-- DataTables --}}
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>

  <script>
    const editRoute = "{{ route('admin.susunan-organisasi.edit', ':id') }}";

    function format(d) {
      let filteredChildren = (d.children || []).filter(child => child.is_subbagian || child.is_susunan_organisasi_fungsional);

      if (filteredChildren.length === 0) {
        return '<div class="text-center p-4">Tidak ada subbagian atau susunan-organisasi fungsional</div>';
      }

      let children = filteredChildren.map((child, index) => `
          <tr class="flex justify-between items-center">
              <td class="p-1">${String.fromCharCode(97 + index)}. ${child.nama_susunan_organisasi}</td>

              <td class="p-1 flex gap-x-2">
                <a href="${editRoute.replace(':id', child.id_susunan_organisasi)}" class="flex justify-center items-center w-9 h-9 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
                  <i class="fa-solid fa-pencil"></i>
                </a>
                <button data-modal-target="deleteModal-${child.id_susunan_organisasi}"
                  data-modal-toggle="deleteModal-${child.id_susunan_organisasi}"
                  class="flex justify-center items-center w-9 h-9 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg text-sm p-2.5 focus:outline-none">
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </td>
          </tr>

          <div id="deleteModal-${child.id_susunan_organisasi}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
              <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Konfirmasi Penghapusan
                  </h3>
                  <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="deleteModal-${child.id_susunan_organisasi}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                      viewBox="0 0 14 14">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                  </button>
                </div>
                <div class="p-4 md:p-5 space-y-4">
                  <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    Apakah Anda yakin ingin menghapus susunan-organisasi <strong>${child.nama_susunan_organisasi}</strong>? Anda secara otomatis akan juga menghapus pegawai yang ada pada ${child.nama_susunan_organisasi}
                  </p>
                </div>
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                  <form action="{{ route('admin.susunan-organisasi.destroy', 'child.id_susunan_organisasi') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                      class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Hapus</button>
                  </form>
                  <button type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                    data-modal-hide="deleteModal-${child.id_susunan_organisasi}">
                    Tidak
                  </button>
                </div>  
              </div>
            </div>
          </div>
      `).join('');

      return `<table class="table-auto w-full">${children}</table>`;
    }

    $(document).ready(function() {
      let table = $('#susunan-organisasi').DataTable({
        responsive: true,
        pageLength: 15,
        columns: [{
            orderable: false,
            data: null,
            defaultContent: ''
          },
          {
            data: 'id'
          },
          {
            data: 'nama_susunan_organisasi'
          },
          {
            data: 'deskripsi_susunan_organisasi'
          },
          {
            data: 'kelola'
          }
        ],
        order: [
          [1, 'asc']
        ]
      });

      // Add event listener for opening and closing details
      $('#susunan-organisasi tbody').on('click', 'td.dt-control', function() {
        let tr = $(this).closest('tr');
        let row = table.row(tr);
        let childrenData = tr.attr('data-children') ? JSON.parse(tr.attr('data-children')) : [];

        if (row.child.isShown()) {
          row.child.hide();
          tr.removeClass('shown');
        } else {
          row.child(format({
            children: childrenData
          })).show();
          tr.addClass('shown');
        }
      });
    });
  </script>
@endsection
