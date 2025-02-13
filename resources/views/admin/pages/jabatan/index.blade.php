@extends('admin.layouts.jabatan')

@section('css')
  {{-- DataTables --}}
  <link href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css" rel="stylesheet" />
@endsection

@section('slot')
  <a href="{{ route('admin.jabatan.create') }}"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5">
    <i class="fa-solid fa-plus me-1"></i>Tambah Jabatan
  </a>

  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="jabatan" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th></th>
            <th>#</th>
            <th>Nama Jabatan</th>
            <th>Deskripsi Jabatan</th>
            <th>Kelola</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($jabatan as $item)
            <tr data-children="{{ json_encode($item->children) }}">
              <td class="dt-control"></td>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $item->nama_jabatan }}</td>
              <td>
                @if ($item->deskripsi_jabatan)
                  <button type="button" class="inline-flex justify-center items-center gap-1 h-8 font-medium text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm p-2.5 focus:outline-none" data-modal-target="deskripsiModal-{{ $item->id_jabatan }}" data-modal-toggle="deskripsiModal-{{ $item->id_jabatan }}">
                    <i class="fa-solid fa-eye"></i> <span class="font-medium whitespace-nowrap text-xs sm:text-sm">Lihat</span>
                  </button>
                @else
                  <span class="bg-gray-100 text-gray-800 text-xs font-bold me-2 px-1 py-0.5 rounded border border-gray-500">
                    Belum diisi
                  </span>
                @endif
              </td>
              <td>
                <div class="flex gap-2">
                  <a href="{{ route('admin.jabatan.edit', $item->id_jabatan) }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  @if ($item->kelompok_jabatan != 'Subbagian' && $item->kelompok_jabatan != 'Jabatan Fungsional')
                    <a href="{{ route('admin.pegawai.index', ['jabatan' => $item->id_jabatan]) }}"
                      class="inline-flex justify-center items-center gap-1 font-medium text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm p-2.5 focus:outline-none">
                      <i class="fa-solid fa-users"></i> <span class="font-medium whitespace-nowrap text-xs sm:text-sm">Lihat Pegawai</span>
                    </a>
                  @endif
                </div>
              </td>
            </tr>

            <!-- Modal Deskripsi -->
            <div id="deskripsiModal-{{ $item->id_jabatan }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full" data-modal-target="deskripsiModal-{{ $item->id_jabatan }}">
              <div class="relative p-4 w-full max-w-4xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                  <!-- Modal header -->
                  <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Deskripsi Jabatan
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="deskripsiModal-{{ $item->id_jabatan }}">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                      </svg>
                      <span class="sr-only">Close modal</span>
                    </button>
                  </div>
                  <!-- Modal body -->
                  <div class="p-4 md:p-5 space-y-4">
                    <div>
                      {!! $item->deskripsi_jabatan !!}
                    </div>
                  </div>
                  <!-- Modal footer -->
                  <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" class="bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-400 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" data-modal-hide="deskripsiModal-{{ $item->id_jabatan }}">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th></th>
            <th>#</th>
            <th>Nama Jabatan</th>
            <th>Deskripsi Jabatan</th>
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
    const editRoute = "{{ route('admin.jabatan.edit', ':id') }}";

    // Formatting function for row details - modify as you need
    function format(d) {
        let filteredChildren = d.children.filter(child => ['Subbagian', 'Jabatan Fungsional'].some(value => child.kelompok_jabatan.includes(value)));
        
        if (filteredChildren.length === 0) {
            return '<div class="text-center p-4">Tidak ada subbagian atau jabatan fungsional</div>';
        }

        let children = filteredChildren.map((child, index) => `
            <tr>
                <td class="p-1">${String.fromCharCode(97 + index)}. ${child.nama_jabatan}</td>

                <td class="p-1">
                  <a href="${editRoute.replace(':id', child.id_jabatan)}" class="flex justify-center items-center w-9 h-9 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none"><i class="fa-solid fa-pencil"></i></a>
                </td>
            </tr>
        `).join('');

        return `<table class="table-auto w-full">${children}</table>`;
    }

    $(document).ready(function() {
        let table = $('#jabatan').DataTable({
            responsive: true,
            columns: [
                {
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: ''
                },
                { data: 'id' },
                { data: 'nama_jabatan' },
                { data: 'deskripsi_jabatan' },
                { data: 'kelola' }
            ],
            order: [[1, 'asc']]
        });

        // Add event listener for opening and closing details
        $('#jabatan tbody').on('click', 'td.dt-control', function () {
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let childrenData = JSON.parse(tr.attr('data-children'));

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format({ children: childrenData })).show();
                tr.addClass('shown');
            }
        });
    });
  </script>
@endsection
