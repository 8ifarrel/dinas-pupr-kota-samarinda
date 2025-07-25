@extends('admin.layouts.app')

@section('title', 'Data LPSE')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar LPSE</h1>

    <a href="{{ route('admin.lpse.create') }}" class="btn btn-primary mb-3">+ Tambah LPSE</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Paket</th>
                <th>Nama Paket</th>
                <th>Jenis Paket</th>
                <th>URL</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($lpses as $lpse)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $lpse->kode_paket }}</td>
                    <td>{{ $lpse->nama_paket }}</td>
                    <td>{{ $lpse->jenis_paket }}</td>
                    <td><a href="{{ $lpse->url_informasi_paket }}" target="_blank">Lihat</a></td>
                    <td>Rp {{ number_format($lpse->nilai, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('admin.lpse.edit', $lpse->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.lpse.destroy', $lpse->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data LPSE</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection