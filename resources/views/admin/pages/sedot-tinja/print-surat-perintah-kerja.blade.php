@extends('admin.layouts.app')

@section('content')
<div class="p-6 bg-white border rounded max-w-3xl mx-auto text-sm leading-relaxed">

    <!-- Tombol Print -->
    <div class="text-right mb-4 no-print">
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            🖨 Print Surat
        </button>
    </div>

    <h2 class="text-center text-lg font-bold mb-2">SURAT PERINTAH KERJA</h2>

    <p class="mb-4">Kepada Yth.<br>
    Kepala UPTD Pengelolaan Air Limbah Domestik<br>
    Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda</p>

    <p class="mb-4">Dengan ini memberikan perintah kepada:</p>

    <ul class="mb-4">
        <li><strong>Nama Sopir:</strong> {{ $item->nama_operator ?? '..................' }}</li>
        <li><strong>Nomor Kendaraan:</strong> {{ $item->nomor_kendaraan ?? '..................' }}</li>
        <li><strong>Kapasitas Kendaraan:</strong> {{ $item->kapasitas_kendaraan ?? '..................' }}</li>
    </ul>

    <p class="mb-4">Untuk melaksanakan tugas:</p>
    <p><strong>Penyedotan Limbah Tangki Septik</strong></p>

    <ul class="mb-4">
        <li><strong>Nama Pelanggan:</strong> {{ $item->nama_pelanggan }}</li>
        <li><strong>Lokasi:</strong> {{ $item->alamat }}</li>
        <li><strong>Nomor HP:</strong> {{ $item->nomor_telepon_pelanggan }}</li>
    </ul>

    <p class="mt-6">
        Tugas ini harus dilaksanakan dengan baik dan penuh tanggung jawab. Hasil pelaksanaan tugas agar dilaporkan kepada pimpinan UPTD.
    </p>

    <div class="mt-8">
        <p>Samarinda, {{ \Carbon\Carbon::parse($item->tanggal_perintah ?? now())->format('d-m-Y') }}</p>
        <p class="mt-6">Kepala UPTD Pengelolaan Air Limbah Domestik</p>
        <div class="mt-16 font-bold">Arwaddin, S.Sos</div>
        <p>NIP 19730811 199803 1 011</p>
    </div>
</div>

<style>
@media print {
    .no-print { display: none; }
}
</style>
@endsection
