@extends('admin.layouts.app')

@section('content')
<div class="p-6 bg-white border rounded max-w-3xl mx-auto text-sm leading-relaxed">

    <!-- Tombol Print -->
    <div class="text-right mb-4 no-print">
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            🖨 Print Surat
        </button>
    </div>

    <h2 class="text-center text-lg font-bold mb-6">SURAT JALAN</h2>

    <div class="space-y-4">
        <div><strong>NAMA OPERATOR:</strong> {{ $item->nama_operator ?? '..................' }}</div>
        <div><strong>NAMA PELANGGAN:</strong> {{ $item->nama_pelanggan }}</div>

        <div>
            <strong>ALAMAT:</strong> {{ $item->alamat }}  
            <br>NO: {{ $item->nomor_rumah ?? '......' }} &nbsp;&nbsp; RT: {{ $item->rt ?? '......' }}
        </div>

        <div>
            <strong>KELURAHAN:</strong> {{ $item->kelurahan }}  
            <br><strong>KECAMATAN:</strong> {{ $item->kecamatan }}
        </div>

        <div><strong>NO. HP:</strong> {{ $item->nomor_telepon_pelanggan }}</div>
        <div><strong>JUMLAH RIT:</strong> {{ $item->jumlah_rit ?? '...........' }}</div>
    </div>

    <div class="mt-8">
        <p>Samarinda, {{ \Carbon\Carbon::parse($item->tanggal_jalan ?? now())->format('d-m-Y') }}</p>
        <p class="mt-6">Mengetahui</p>

        <div class="grid grid-cols-2 gap-8 mt-12 text-center">
            <div>
                <p>PETUGAS IPLT</p>
                <div class="mt-16 border-t w-40 mx-auto"></div>
            </div>
            <div>
                <p>PELANGGAN</p>
                <div class="mt-16 border-t w-40 mx-auto"></div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="font-semibold">M. Rijal Muttaqien</p>
        </div>
    </div>
</div>

<style>
/* Supaya tombol print tidak muncul di hasil cetakan */
@media print {
    .no-print {
        display: none;
    }
}
</style>
@endsection
