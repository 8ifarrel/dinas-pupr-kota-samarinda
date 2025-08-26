@extends('admin.layouts.app')

@section('content')
<div class="p-6 bg-white border rounded max-w-3xl mx-auto text-sm leading-relaxed">

    <!-- Tombol Print -->
    <div class="text-right mb-4 no-print">
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            🖨 Print Surat
        </button>
    </div>

    <h2 class="text-center text-lg font-bold mb-2">SURAT PESANAN</h2>
    <p class="text-center mb-6">Perihal: Penyedotan Tangki Septik</p>

    <p class="mb-4">Kepada Yth.<br>
    Kepala UPTD Pengelolaan Air Limbah Domestik<br>
    Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda</p>

    <p><strong>Mohon dilaksanakan Penyedotan Tangki Septik:</strong></p>
    <p>Nomor SPK: {{ $item->nomor_spk ?? '...................... / UPTD / .......... / 2025' }}</p>

    <div class="space-y-2 mt-4">
        <p><strong>Nama:</strong> {{ $item->nama_pelanggan }}</p>
        <p><strong>Alamat:</strong> {{ $item->alamat }}</p>
        <p><strong>No.:</strong> {{ $item->nomor_rumah ?? '......' }} &nbsp;&nbsp; <strong>RT:</strong> {{ $item->rt ?? '......' }}</p>
        <p><strong>Kelurahan:</strong> {{ $item->kelurahan }}</p>
        <p><strong>Kecamatan:</strong> {{ $item->kecamatan }}</p>
        <p><strong>Telp. Rumah / HP:</strong> {{ $item->nomor_telepon_pelanggan }}</p>
    </div>

    <div class="mt-6 space-y-2">
        <p>1. <strong>Jarak Tangki Septik dengan mobil tinja:</strong> {{ $item->jarak_tangki ?? '......' }} meter</p>
        <p>2. <strong>Tangki Septik bisa disedot:</strong> {{ $item->bisa_disedot ?? 'Ya / Tidak' }}</p>
        <p><strong>Tersedia untuk pemenuhan selang penyedotan</strong></p>
    </div>

    <div class="mt-6">
        <p>Apabila kondisi tidak memungkinkan untuk teknis penyedotan, tidak bisa ditambahkan menjadi tanggung jawab kami sebagai pemesan.</p>
    </div>

    <div class="mt-8">
        <p>Samarinda, {{ \Carbon\Carbon::parse($item->tanggal_pesanan ?? now())->format('d-m-Y') }}</p>
        <p class="mt-6">Pemohon,</p>
        <div class="mt-16 font-bold">{{ $item->nama_pelanggan }}</div>
    </div>
</div>

<style>
@media print {
    .no-print { display: none; }
}
</style>
@endsection
