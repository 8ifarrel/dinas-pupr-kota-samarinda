<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Daftar Laporan Kerusakan</title>
    <style>
        @page {
            margin: 0.6in 0.5in; /* Margin halaman */
            size: A4; /* Portrait lebih cocok untuk daftar linear */
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9pt;
            line-height: 1.4;
            color: #333;
        }
        .document-title {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 10px;
            color: #1e3a8a;
        }
        .filter-info {
            text-align: center;
            font-size: 8pt;
            margin-bottom: 20px;
            color: #555;
        }
        .report-entry {
            border: 1px solid #e0e0e0;
            padding: 12px;
            margin-bottom: 18px; /* Jarak antar laporan */
            page-break-inside: avoid; /* Usahakan tidak memotong satu entri laporan */
            background-color: #fdfdfd;
        }
        .report-header {
            border-bottom: 1px solid #1e3a8a;
            padding-bottom: 8px;
            margin-bottom: 10px;
            display: table;
            width: 100%;
        }
        .report-id {
            font-size: 11pt;
            font-weight: bold;
            color: #1e3a8a;
            display: table-cell;
        }
        .report-date-status {
            display: table-cell;
            text-align: right;
            font-size: 8pt;
        }
        .status-badge {
            padding: 3px 7px;
            border-radius: 4px;
            font-size: 7.5pt;
            font-weight: bold;
            display: inline-block;
            margin-left: 8px;
        }
        /* Warna status (sesuaikan dengan kebutuhan) */
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-disposisi { background-color: #ede9fe; color: #5b21b6; }
        .status-belum_dikerjakan { background-color: #f3e8ff; color: #6b21a8; }
        .status-telah_disurvei { background-color: #e0f2fe; color: #0ea5e9; }
        .status-sedang_dikerjakan { background-color: #dcfce7; color: #16a34a; }
        .status-telah_dikerjakan { background-color: #d1fae5; color: #065f46; }
        .status-reject { background-color: #fee2e2; color: #991b1b; }
        .status-default { background-color: #e9ecef; color: #495057; }

        .section {
            margin-bottom: 12px;
        }
        .section-title {
            font-size: 10pt;
            font-weight: bold;
            color: #337ab7; /* Biru lebih muda */
            margin-bottom: 5px;
            padding-bottom: 3px;
            border-bottom: 1px dotted #ccc;
        }
        .info-line {
            margin-bottom: 4px;
            padding-left: 10px;
        }
        .info-line strong {
            font-weight: bold;
            color: #555;
            min-width: 120px; /* Untuk alignment label */
            display: inline-block;
        }
        .description-text, .keterangan-text, .feedback-text {
            background-color: #f8f8f8;
            padding: 8px;
            border-left: 3px solid #ccc;
            margin-top: 3px;
            font-style: italic;
        }
        .keterangan-text { border-left-color: #7e22ce; color: #581c87; }
        .feedback-text { border-left-color: #666; }


        .photo-gallery {
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px dashed #eee;
        }
        .photo-gallery img {
            max-width: 80px; /* Ukuran foto lebih kecil */
            max-height: 80px;
            border: 1px solid #ccc;
            margin-right: 5px;
            margin-bottom: 5px;
            vertical-align: top;
        }
        .no-photos {
            font-style: italic;
            color: #777;
            font-size: 8pt;
        }

        .footer {
            position: fixed;
            bottom: -0.4in; /* Sesuaikan dengan margin bottom @page */
            left: 0;
            right: 0;
            height: 0.4in;
            text-align: center;
            font-size: 8pt;
            color: #777;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
        .page-number:before {
            content: "Halaman " counter(page);
        }
        .no-data {
            text-align: center;
            padding: 20px;
            font-style: italic;
        }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="document-title">Laporan Kerusakan Infrastruktur</div>
    {{-- <div class="filter-info">
        Dicetak pada: {{ now()->format('d F Y, H:i') }}
        (Filter aktif: ...)
    </div> --}}

    @forelse($laporans as $laporan)
        <div class="report-entry">
            <div class="report-header">
                <div class="report-id">Laporan ID: {{ $laporan->id_laporan }}</div>
                <div class="report-date-status">
                    <span>{{ \Carbon\Carbon::parse($laporan->created_at)->locale('id')->isoFormat('DD MMMM YYYY, HH:mm') }} WITA</span>
                    @php
                        $statusName = $laporan->status ? $laporan->status->nama_status : 'tidak_diketahui';
                        $statusText = ucfirst(str_replace('_', ' ', $statusName));
                        $statusBadgeClass = 'status-' . strtolower($statusName);
                        if (!in_array($statusBadgeClass, ['status-pending', 'status-disposisi', 'status-telah_disurvei', 'status-belum_dikerjakan', 'status-sedang_dikerjakan', 'status-telah_dikerjakan', 'status-reject'])) {
                            $statusBadgeClass = 'status-default';
                        }
                    @endphp
                    <span class="status-badge {{ $statusBadgeClass }}">{{ $statusText }}</span>
                </div>
            </div>

            <div class="section">
                <div class="section-title">Detail Lokasi & Kerusakan</div>
                <p class="info-line"><strong>Alamat Kerusakan:</strong> {{ $laporan->alamat_lengkap_kerusakan }}</p>
                <p class="info-line"><strong>Kecamatan:</strong> {{ $laporan->kecamatan->nama ?? ($laporan->kecamatan->nama_kecamatan ?? '-') }}</p>
                <p class="info-line"><strong>Kelurahan:</strong> {{ $laporan->kelurahan->nama ?? ($laporan->kelurahan->nama_kelurahan ?? '-') }}</p>
                @if($laporan->latitude && $laporan->longitude)
                <p class="info-line"><strong>Koordinat:</strong> {{ $laporan->latitude }}, {{ $laporan->longitude }}
                    @if($laporan->link_koordinat)
                        (<a href="{{ $laporan->link_koordinat }}" target="_blank">Lihat Peta</a>)
                    @elseif($laporan->latitude && $laporan->longitude)
                         (<a href="https://maps.google.com/?q={{ $laporan->latitude }},{{ $laporan->longitude }}" target="_blank">Lihat Peta</a>)
                    @endif
                </p>
                @endif
                <p class="info-line"><strong>Jenis Kerusakan:</strong> <span style="color: #dc2626; font-weight:bold;">{{ $laporan->jenis_kerusakan ?? '-' }}</span></p>
                <p class="info-line"><strong>Deskripsi:</strong></p>
                <p class="description-text">{{ $laporan->deskripsi_laporan ?: 'Tidak ada deskripsi.' }}</p>

                {{-- Keterangan Disposisi --}}
                @if ($laporan->status_id == $disposisiStatusId && !empty($laporan->keterangan))
                    <p class="info-line" style="margin-top: 5px;"><strong>Keterangan Disposisi:</strong></p>
                    <p class="keterangan-text">{{ $laporan->keterangan }}</p>
                @endif
            </div>

            <div class="section">
                <div class="section-title">Ulasan Pelapor</div>
                <p class="info-line"><strong>Rating Kepuasan:</strong>
                    @if($laporan->rating_kepuasan)
                        @php
                            $ratingTextPdf = match((int)$laporan->rating_kepuasan) {
                                1 => 'Sangat Tidak Puas', 2 => 'Tidak Puas',
                                3 => 'Netral', 4 => 'Puas', 5 => 'Sangat Puas',
                                default => 'N/A'
                            };
                        @endphp
                        {{ $ratingTextPdf }} ({{ $laporan->rating_kepuasan }}/5)
                    @else
                        <span style="font-style: italic; color: #777;">Belum ada rating</span>
                    @endif
                </p>
                <p class="info-line"><strong>Feedback Pelapor:</strong></p>
                @if($laporan->feedback)
                    <p class="feedback-text">"{{ $laporan->feedback }}"</p>
                @else
                    <p class="feedback-text" style="color: #777;">Belum ada feedback.</p>
                @endif
            </div>

            <div class="section">
                <div class="section-title">Data Pelapor</div>
                <p class="info-line"><strong>Nama:</strong> {{ $laporan->pelapor->nama_lengkap ?? '-' }}</p>
                <p class="info-line"><strong>No. Ponsel:</strong> {{ $laporan->pelapor->nomor_ponsel ?? '-' }}</p>
                <p class="info-line"><strong>Email:</strong> {{ $laporan->pelapor->email ?? '-' }}</p>
                <p class="info-line"><strong>Rt/Rw:</strong> {{
                    ($laporan->pelapor->rt ?? '-') .
                    '/' .
                    ($laporan->pelapor->rw ?? '-')
                    }}
                </p>
                <p class="info-line"><strong>Alamat Pelapor:</strong> {{ $laporan->pelapor->alamat_pelapor ?? ($laporan->pelapor->alamat_lengkap ?? '-') }}</p>
                <p class="info-line"><strong>Kec. Pelapor:</strong> {{ $laporan->pelapor->kecamatan->nama ?? ($laporan->pelapor->kecamatan->nama_kecamatan ?? '-') }}</p>
                <p class="info-line"><strong>Kel. Pelapor:</strong> {{ $laporan->pelapor->kelurahan->nama ?? ($laporan->pelapor->kelurahan->nama_kelurahan ?? '-') }}</p>
            </div>

            @php
                $fotoArray = $laporan->foto_kerusakan ? json_decode($laporan->foto_kerusakan, true) : [];
                $fotoArray = is_array($fotoArray) ? $fotoArray : [];
            @endphp
            @if(!empty($fotoArray))
                <div class="section photo-gallery">
                    <div class="section-title" style="font-size:9pt; margin-bottom:3px;">Foto Kerusakan</div>
                    @foreach($fotoArray as $foto)
                        @php
                            $imagePath = storage_path('app/public/foto_kerusakan/' . $foto);
                        @endphp
                        @if(file_exists($imagePath))
                            <img src="{{ $imagePath }}" alt="Foto">
                        @endif
                    @endforeach
                </div>
            @else
                <div class="section photo-gallery">
                     <div class="section-title" style="font-size:9pt; margin-bottom:3px;">Foto Kerusakan</div>
                    <p class="no-photos">Tidak ada foto kerusakan.</p>
                </div>
            @endif

        </div> <!-- .report-entry -->

        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @empty
        <p class="no-data">Tidak ada data laporan yang sesuai dengan filter.</p>
    @endforelse

    <div class="footer">
        Dokumen ini digenerate oleh sistem pada {{ now()->locale('id')->isoFormat('DD MMMM YYYY HH:mm:ss') }} - <span class="page-number"></span>
    </div>
</body>
</html>