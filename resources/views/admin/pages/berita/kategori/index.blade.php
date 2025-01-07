@extends('admin.layouts.partner')

@section('slot')
  <div class="w-full p-4 rounded-lg shadow-xl sm:p-8 mt-5">
    <div class="relative overflow-x-auto text-sm md:text-base">
      <table id="kategori" class="stripe hover row-border table-auto" style="width:100%">
        <thead>
          <tr>
            <th>Nama Kategori</th>
            <th>Ikon</th>
            <th>Kelola</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($kategori as $item)
            <tr>
              <td>{{ $item->nama_kategori }}</td>
              <td>
                <i class="{{ $item->ikon_kategori }}"></i>
              </td>
              <td>
                <div class="flex gap-2">
                  <a href="{{ route('admin.berita.kategori.edit', $item->id_berita_kategori) }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  <a href="{{ route('admin.berita.kategori.show', $item->id_berita_kategori) }}"
                    class="flex justify-center items-center w-10 h-10 text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm p-2.5 focus:outline-none">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>

        <tfoot>
          <tr>
            <th>Nama Kategori</th>
            <th>Ikon</th>
            <th>Kelola</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(function() {
      $('#kategori').DataTable({
        responsive: true
      });
    });
  </script>
@endsection
