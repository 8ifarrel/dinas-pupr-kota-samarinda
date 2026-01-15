@extends('admin.layout')

@section('content')
<div class="max-w-3xl mx-auto text-sm leading-relaxed">

    <!-- {{-- ================= SURAT PERINTAH KERJA ================= --}}
    <div class="p-6 bg-white border rounded mb-10 page-break">
        <div class="text-right mb-4 no-print">
            <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                🖨 Print Surat
            </button>
        </div> -->

        <!-- <h2 class="text-center text-lg font-bold mb-2">SURAT PERINTAH KERJA</h2>

        <p class="mb-4">Kepada Yth.<br>
        Kepala UPTD Pengelolaan Air Limbah Domestik<br>
        Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda</p>

        <p class="mb-4">Dengan ini memberikan perintah kepada:</p>

        <ul class="mb-4">
            <li><strong>Nama Sopir:</strong> {{ $item->nama_operator ?? '..................' }}</li>
            <li><strong>Nomor Kendaraan:</strong> {{ $item->nomor_kendaraan ?? '..................' }}</li>
            <li><strong>Kapasitas Kendaraan:</strong> {{ $item->kapasitas_kendaraan ?? '..................' }}</li>
        </ul> --> 
<!-- 
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

        <div class="mt-8"> -->
            <!-- <p>Samarinda, {{ \Carbon\Carbon::parse($item->tanggal_perintah ?? now())->format('d-m-Y') }}</p>
            <p class="mt-6">Kepala UPTD Pengelolaan Air Limbah Domestik</p>
            <div class="mt-16 font-bold">Arwaddin, S.Sos</div>
            <p>NIP 19730811 199803 1 011</p>
        </div>
    </div> -->

     <!-- {{-- ================= SURAT JALAN ================= --}}
    <div class="p-6 bg-white border rounded mb-10 page-break">
        <h2 class="text-center text-lg font-bold mb-6">SURAT JALAN</h2>

        <div class="space-y-4">
            <div><strong>NAMA OPERATOR:</strong> {{ $item->nama_operator ?? '..................' }}</div>
            <div><strong>NAMA PELANGGAN:</strong> {{ $item->nama_pelanggan }}</div>

            <div>
                <strong>ALAMAT:</strong> {{ $item->alamat }}  
                <br>NO: {{ $item->nomor_rumah ?? '......' }} &nbsp;&nbsp; RT: {{ $item->rt ?? '......' }} -->
            <!-- </div> -->

            <!-- <div>
                <strong>KELURAHAN:</strong> {{ $item->kelurahan }}  
                <br><strong>KECAMATAN:</strong> {{ $item->kecamatan }}
            </div>

            <div><strong>NO. HP:</strong> {{ $item->nomor_telepon_pelanggan }}</div>
            <div><strong>JUMLAH RIT:</strong> {{ $item->jumlah_rit ?? '...........' }}</div>
        </div>

        <div class="mt-8"> -->
            <!-- <p>Samarinda, {{ \Carbon\Carbon::parse($item->tanggal_jalan ?? now())->format('d-m-Y') }}</p>
            <p class="mt-6">Mengetahui</p> -->

            <!-- <div class="grid grid-cols-2 gap-8 mt-12 text-center">
                <div>
                    <p>PETUGAS IPLT</p>
                    <div class="mt-16 border-t w-40 mx-auto"></div>
                </div>
                <div>
                    <p>PELANGGAN</p>
                    <div class="mt-16 border-t w-40 mx-auto"></div>
                </div>
            </div> --> 

            <!-- <div class="mt-12 text-center">
                <p class="font-semibold">M. Rijal Muttaqien</p>
            </div>
        </div>
    </div>  -->
<!-- 
     {{-- ================= SURAT PESANAN ================= --}}
    <div class="p-6 bg-white border rounded page-break">
        <h2 class="text-center text-lg font-bold mb-2">SURAT PESANAN</h2>
        <p class="text-center mb-6">Perihal: Penyedotan Tangki Septik</p>

        <p class="mb-4">Kepada Yth.<br>
        Kepala UPTD Pengelolaan Air Limbah Domestik<br>
        Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda</p>

        <p><strong>Mohon dilaksanakan Penyedotan Tangki Septik:</strong></p>
        <p>Nomor SPK: {{ $item->nomor_spk ?? '...................... / UPTD / .......... / 2025' }}</p>

        <div class="space-y-2 mt-4">
            <p><strong>Nama:</strong> {{ $item->nama_pelanggan }}</p> -->
            <!-- <p><strong>Alamat:</strong> {{ $item->alamat }}</p>
            <p><strong>No.:</strong> {{ $item->nomor_rumah ?? '......' }} &nbsp;&nbsp; <strong>RT:</strong> {{ $item->rt ?? '......' }}</p>
            <p><strong>Kelurahan:</strong> {{ $item->kelurahan }}</p>
            <p><strong>Kecamatan:</strong> {{ $item->kecamatan }}</p>
            <p><strong>Telp. Rumah / HP:</strong> {{ $item->nomor_telepon_pelanggan }}</p>
        </div>

        <div class="mt-6 space-y-2"> -->
            <!-- <p>1. <strong>Jarak Tangki Septik dengan mobil tinja:</strong> {{ $item->jarak_tangki ?? '......' }} meter</p>
            <p>2. <strong>Tangki Septik bisa disedot:</strong> {{ $item->bisa_disedot ?? 'Ya / Tidak' }}</p>
            <p><strong>Tersedia untuk pemenuhan selang penyedotan</strong></p>
        </div>

        <div class="mt-6">
            <p>Apabila kondisi tidak memungkinkan untuk teknis penyedotan, tidak bisa ditambahkan menjadi tanggung jawab kami sebagai pemesan.</p>
        </div> -->

        <!-- <div class="mt-8">
            <p>Samarinda, {{ \Carbon\Carbon::parse($item->tanggal_pesanan ?? now())->format('d-m-Y') }}</p>
            <p class="mt-6">Pemohon,</p>
            <div class="mt-16 font-bold">{{ $item->nama_pelanggan }}</div>
        </div>
    </div>
</div>  -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Surat Perintah Kerja</title>
    <style>
        /* Reset CSS untuk cetakan */
        @media print {
            @page {
                margin: 0;
                size: auto;
            }
            
            body {
                margin: 0;
                padding: 0;
                font-family: 'Times New Roman', Times, serif;
                font-size: 14px;
                line-height: 1.5;
                background: white;
                color: black;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .no-print, .hidden-print, [class*="print:hidden"], .breadcrumb, .page-title, .header-title {
                display: none !important;
            }
            
            .page-break {
                page-break-after: always;
            }
            
            .container {
                width: 100%;
                margin: 0;
                padding: 1.5cm;
                box-shadow: none;
            }
            
            /* Sembunyikan semua elemen yang tidak perlu saat cetak */
            header, footer, nav, aside, .navbar, .sidebar, .btn, .action-buttons,
            .card-header, .content-header, .print-controls {
                display: none !important;
            }
            
            /* Pastikan konten utama terlihat */
            .print-content {
                display: block !important;
                width: 100%;
            }
        }
        
        /* Tampilan untuk layar */
        @media screen {
            body {
                background-color: #f5f5f5;
                padding: 20px;
                font-family: Arial, sans-serif;
            }
            
            .container {
                width: 21cm;
                min-height: 29.7cm;
                margin: 10px auto;
                background: white;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                padding: 1.5cm;
                box-sizing: border-box;
            }
        }
        
        .border-bottom-dotted {
            border-bottom: 1px dotted black;
            display: inline-block;
            min-width: 200px;
            padding-bottom: 2px;
        }
        
        .signature-line {
            border-top: 1px solid black;
            width: 200px;
            margin-top: 60px;
        }
        
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 20px;
            text-decoration: underline;
        }
        
        .field-group {
            margin-bottom: 15px;
        }
        
        .field-group p {
            margin: 5px 0;
        }
        
        .print-section {
            margin-bottom: 30px;
            page-break-after: always;
        }
        
        .center-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container print-content">
        <!-- Tombol cetak hanya muncul di layar -->
        <div class="no-print" style="text-align: right; margin-bottom: 20px;">
            <button onclick="window.print()" style="background: #2563eb; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">
                🖨 Cetak Surat
            </button>
        </div>

        <!-- SURAT PERINTAH KERJA -->
        <div class="print-section">
            <h2 class="center-title">SURAT PERINTAH KERJA</h2>

            <p style="margin-bottom: 15px;">Kepada Yth.<br>
            Kepala UPTD Pengelolaan Air Limbah Domestik<br>
            Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda</p>

            <p style="margin-bottom: 15px;">Dengan ini memberikan perintah kepada:</p>

            <div class="field-group">
                <p><strong>Nama Sopir:</strong> <span class="border-bottom-dotted">{{ $item->nama_operator ?? '..................' }}</span></p>
                <p><strong>Nomor Kendaraan:</strong> <span class="border-bottom-dotted">{{ $item->nomor_kendaraan ?? '..................' }}</span></p>
                <p><strong>Kapasitas Kendaraan:</strong> <span class="border-bottom-dotted">{{ $item->kapasitas_kendaraan ?? '..................' }}</span></p>
            </div>

            <p style="margin-bottom: 15px;">Untuk melaksanakan tugas:</p>
            <p><strong>Penyedotan Limbah Tangki Septik</strong></p>

            <div class="field-group">
                <p><strong>Nama Pelanggan:</strong> <span class="border-bottom-dotted">{{ $item->nama_pelanggan ?? '..................' }}</span></p>
                <p><strong>Lokasi:</strong> <span class="border-bottom-dotted">{{ $item->alamat ?? '..................' }}</span></p>
                <p><strong>Nomor HP:</strong> <span class="border-bottom-dotted">{{ $item->nomor_telepon_pelanggan ?? '..................' }}</span></p>
            </div>

            <p style="margin-top: 20px;">
                Tugas ini harus dilaksanakan dengan baik dan penuh tanggung jawab. Hasil pelaksanaan tugas agar dilaporkan kepada pimpinan UPTD.
            </p>

            <div style="margin-top: 40px;">
                <p>Samarinda, {{ \Carbon\Carbon::parse($item->tanggal_perintah ?? now())->format('d-m-Y') }}</p>
                <p style="margin-top: 20px;">Kepala UPTD Pengelolaan Air Limbah Domestik</p>
                <div style="margin-top: 80px; font-weight: bold;">Arwaddin, S.Sos</div>
                <p>NIP 19730811 199803 1 011</p>
            </div>
        </div>

        <!-- SURAT JALAN -->
        <div class="print-section">
            <h2 class="center-title">SURAT JALAN</h2>

            <div class="field-group">
                <p><strong>NAMA OPERATOR:</strong> <span class="border-bottom-dotted">{{ $item->nama_operator ?? '..................' }}</span></p>
                <p><strong>NAMA PELANGGAN:</strong> <span class="border-bottom-dotted">{{ $item->nama_pelanggan ?? '..................' }}</span></p>
                <p><strong>ALAMAT:</strong> <span class="border-bottom-dotted">{{ $item->alamat ?? '..................' }}</span></p>
                
                <p>
                    NO: <span class="border-bottom-dotted">{{ $item->nomor_rumah ?? '..................' }}</span>
                    &nbsp;&nbsp;&nbsp;
                    RT: <span class="border-bottom-dotted">{{ $item->rt ?? '..................' }}</span>
                </p>

                <p><strong>KELURAHAN:</strong> <span class="border-bottom-dotted">{{ $item->kelurahan ?? '..................' }}</span></p>
                <p><strong>KECAMATAN:</strong> <span class="border-bottom-dotted">{{ $item->kecamatan ?? '..................' }}</span></p>
                <p><strong>NO. HP:</strong> <span class="border-bottom-dotted">{{ $item->nomor_telepon_pelanggan ?? '..................' }}</span></p>
                <p><strong>JUMLAH RIT:</strong> <span class="border-bottom-dotted">{{ $item->jumlah_rit ?? '..................' }}</span></p>
            </div>

            <div style="margin-top: 40px;">
                <p>Samarinda, {{ \Carbon\Carbon::parse($item->tanggal_jalan ?? now())->format('d-m-Y') }}</p>
                
                <div style="display: flex; justify-content: space-between; margin-top: 60px;">
                    <div style="text-align: center;">
                        <p>PETUGAS IPLT</p>
                        <div class="signature-line" style="margin: 0 auto;"></div>
                    </div>
                    <div style="text-align: center;">
                        <p>PELANGGAN</p>
                        <div class="signature-line" style="margin: 0 auto;"></div>
                    </div>
                </div>

                <div style="margin-top: 60px; text-align: center;">
                    <p style="font-weight: bold;">M. Rijal Muttaqien</p>
                </div>
                
                <div style="margin-top: 30px; text-align: center;">
                    <p style="font-weight: bold;">Pengaduan pelayanan : Zulkifli ( 0811-5515-808 )</p>
                </div>
            </div>
        </div>

        <!-- SURAT PESANAN -->
        <div>
            <h2 class="center-title">SURAT PESANAN</h2>
            <p style="text-align: center; margin-bottom: 20px;">Perihal: Penyedotan Tangki Septik</p>

            <p style="margin-bottom: 15px;">Kepada Yth.<br>
            Kepala UPTD Pengelolaan Air Limbah Domestik<br>
            Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda</p>

            <p><strong>Mohon dilaksanakan Penyedotan Tangki Septik:</strong></p>
            <p>Nomor SPK: <span class="border-bottom-dotted">{{ $item->nomor_spk ?? '...................... / UPTD / .......... / 2025' }}</span></p>

            <div class="field-group" style="margin-top: 15px;">
                <p><strong>Nama:</strong> <span class="border-bottom-dotted">{{ $item->nama_pelanggan ?? '..................' }}</span></p>
                <p><strong>Alamat:</strong> <span class="border-bottom-dotted">{{ $item->alamat ?? '..................' }}</span></p>
                <p>
                    <strong>No.:</strong> <span class="border-bottom-dotted">{{ $item->nomor_rumah ?? '......' }}</span>
                    &nbsp;&nbsp;&nbsp;
                    <strong>RT:</strong> <span class="border-bottom-dotted">{{ $item->rt ?? '......' }}</span>
                </p>
                <p><strong>Kelurahan:</strong> <span class="border-bottom-dotted">{{ $item->kelurahan ?? '..................' }}</span></p>
                <p><strong>Kecamatan:</strong> <span class="border-bottom-dotted">{{ $item->kecamatan ?? '..................' }}</span></p>
                <p><strong>Telp. Rumah / HP:</strong> <span class="border-bottom-dotted">{{ $item->nomor_telepon_pelanggan ?? '..................' }}</span></p>
            </div>

            <div class="field-group" style="margin-top: 20px;">
                <p>1. <strong>Jarak Tangki Septik dengan mobil tinja:</strong> <span class="border-bottom-dotted">{{ $item->jarak_tangki ?? '......' }}</span> meter</p>
                <p>2. <strong>Tangki Septik bisa disedot:</strong> <span class="border-bottom-dotted">{{ $item->bisa_disedot ?? 'Ya / Tidak' }}</span></p>
                <p><strong>Tersedia untuk pemenuhan selang penyedotan</strong></p>
            </div>

            <div style="margin-top: 20px;">
                <p>Apabila kondisi tidak memungkinkan untuk teknis penyedotan, tidak bisa ditambahkan menjadi tanggung jawab kami sebagai pemesan.</p>
            </div>

            <div style="margin-top: 40px;">
                <p>Samarinda, {{ \Carbon\Carbon::parse($item->tanggal_pesanan ?? now())->format('d-m-Y') }}</p>
                <p style="margin-top: 20px;">Pemohon,</p>
                <div style="margin-top: 80px; font-weight: bold;">{{ $item->nama_pelanggan ?? '..................' }}</div>
            </div>
        </div>
    </div>

    <script>
        // Pastikan halaman siap sebelum mencetak
        document.addEventListener('DOMContentLoaded', function() {
            // Jika parameter print ada di URL, langsung cetak
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('print')) {
                // Bersihkan URL dari parameter print untuk menghindari duplikasi
                window.history.replaceState({}, document.title, window.location.pathname);
                window.print();
            }
            
            // Sembunyikan elemen yang mungkin berisi "Cetak Pesanan"
            const elementsToHide = document.querySelectorAll('h1, h2, .content-title, .print-title, .page-title');
            elementsToHide.forEach(el => {
                if (el.textContent.includes('Cetak Pesanan')) {
                    el.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>

<style>
@media print {
    .no-print { display: none; }
    .page-break { page-break-after: always; }
}
</style>
@endsection
