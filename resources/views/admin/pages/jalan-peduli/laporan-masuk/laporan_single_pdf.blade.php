<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Detail Laporan {{ $laporan->id_laporan }}</title>
    <style>
        @page {
            margin: 0.5in;
            size: A4;
        }
        
        body {
            font-family: DejaVu Sans, sans-serif; /* DejaVu Sans untuk karakter UTF-8 */
            margin: 0;
            padding: 0;
            /* background-color: #f8f9fa; /* Tidak relevan untuk PDF */
            color: #1f2937;
            font-size: 9pt;
            line-height: 1.4;
        }

        /* Header Section */
        .header-section {
            background-color: #1e3a8a;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .header-content { display: table; width: 100%; }
        .header-title { display: table-cell; vertical-align: middle; }
        .header-id { display: table-cell; text-align: right; vertical-align: middle; width: 150px; }
        .header-title h1 { color: white; font-size: 18pt; font-weight: bold; margin: 0 0 5px 0; }
        .header-title p { color: white; font-size: 11pt; margin: 0; }
        .header-id-badge { background-color: rgba(245, 158, 11, 0.2); border-radius: 6px; padding: 8px 12px; display: inline-block; }
        .header-id-badge .label { font-size: 8pt; color: white; margin: 0; }
        .header-id-badge .value { font-size: 12pt; font-weight: bold; color: #f59e0b; margin: 0; }

        /* Card Styling */
        .card { background-color: white; border: 1px solid #e5e7eb; padding: 15px; margin-bottom: 15px; page-break-inside: avoid; }

        /* Status Section */
        .status-section { margin-bottom: 15px; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px; }
        .status-content { display: table; width: 100%; }
        .status-left { display: table-cell; }
        .status-right { display: table-cell; text-align: right; vertical-align: top; }
        .status-badge { padding: 4px 10px; border-radius: 15px; font-size: 8pt; font-weight: 500; display: inline-block; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-accept { background-color: #d1fae5; color: #065f46; }
        .status-reject { background-color: #fee2e2; color: #991b1b; }
        .date-text { font-size: 8pt; color: #6b7280; margin: 0; }
        .date-value { font-weight: 600; color: #1f2937; }

        /* Section Titles */
        .section-title { font-size: 12pt; font-weight: bold; color: #1e3a8a; margin-bottom: 10px; padding-bottom: 5px; border-bottom: 2px solid #1e3a8a; }

        /* Two Column Layout */
        .two-column { display: table; width: 100%; margin-bottom: 15px; }
        .column-left, .column-right { display: table-cell; width: 48%; vertical-align: top; padding-right: 2%; }
        .column-right { padding-right: 0; padding-left: 2%; }

        /* Info Box */
        .info-box { background-color: #f3f4f6; padding: 12px; margin-bottom: 10px; }
        .info-item { margin-bottom: 6px; font-size: 9pt; }
        .info-item:last-child { margin-bottom: 0; }
        .info-label { color: #4b5563; display: inline-block; width: 90px; font-weight: normal; }
        .info-value { font-weight: 500; color: #1f2937; }
        .info-value.text-blue { color: #1e3a8a; }
        .info-value.text-red { color: #dc2626; }

        /* Description & Keterangan Block */
        .main-description-block { margin-top: 8px; margin-bottom: 15px; }
        .description-label { display: block; margin-bottom: 4px; color: #4b5563; font-size: 9pt; font-weight: bold; }
        .description-text { font-size: 9pt; background-color: #f9fafb; padding: 10px; border-left: 3px solid #f59e0b; margin: 0; }
        .keterangan-disposisi-text { font-size: 9pt; background-color: #f3e8ff; color: #581c87; padding: 10px; border-left: 3px solid #7e22ce; margin-top: 10px; font-style: italic; }

        /* Rating and Feedback */
        .rating-feedback-section { margin-bottom: 15px; page-break-inside: avoid; }
        .rating-feedback-title { font-size: 12pt; font-weight: bold; color: #1e3a8a; margin-bottom: 10px; padding-bottom: 5px; border-bottom: 2px solid #1e3a8a;}
        .rating-feedback-container { display: table; width: 100%; }
        .rating-box, .feedback-box { display: table-cell; width: 48%; vertical-align: top; padding: 12px; }
        .rating-box { background-color: #fef3c7; margin-right: 2%; }
        .feedback-box { background-color: #f3f4f6; }
        .box-subtitle { font-weight: bold; color: #1f2937; margin-bottom: 8px; font-size: 10pt; }
        .rating-display { font-size: 11pt; font-weight: bold; color: #1f2937; }
        .feedback-display-text { font-size: 9pt; color: #374151; font-style: italic; line-height: 1.4; }
        .placeholder-text { color: #6b7280; font-style: italic; }

        /* Photo Documentation */
        .photo-section { margin-bottom: 15px; page-break-inside: avoid; }
        .photo-grid { display: table; width: 100%; }
        .photo-row { display: table-row; }
        .photo-cell { display: table-cell; width: 23%; padding: 5px; vertical-align: top; }
        .photo-item { background-color: #f3f4f6; border: 1px solid #d1d5db; height: 100px; text-align: center; overflow: hidden; }
        .photo-item img { max-width: 100%; max-height: 100%; width: auto; height: auto; }
        .photo-placeholder { padding: 20px; text-align: center; color: #6b7280; font-size: 8pt; }
        .no-photo { background-color: #f9fafb; border: 1px dashed #d1d5db; padding: 20px; text-align: center; color: #6b7280; }

        /* Reporter Section */
        .reporter-header { margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #e5e7eb; }
        .reporter-title { font-size: 14pt; font-weight: bold; color: #1e3a8a; margin: 0; }

        /* Footer */
        .footer-section { background-color: #1e3a8a; color: white; padding: 15px; text-align: center; margin-top: 20px; }
        .footer-text { color: white; font-size: 8pt; margin: 0 0 5px 0; }
        .print-date { color: white; font-size: 7pt; margin: 0; }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header-section">
        <div class="header-content">
            <div class="header-title">
                <h1>Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda</h1>
                <p>Laporan Kerusakan Jalan</p>
            </div>
            <div class="header-id">
                <div class="header-id-badge">
                    <p class="label">ID Laporan</p>
                    <p class="value">{{ $laporan->id_laporan }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Report Card -->
    <div class="card">
        <!-- Status Section -->
        <div class="status-section">
            <div class="status-content">
                <div class="status-left">
                    <p class="date-text">Tanggal Laporan</p>
                    <p class="date-text date-value">
                        {{ \Carbon\Carbon::parse($laporan->created_at)->locale('id')->isoFormat('DD MMMM YYYY, HH:mm') }} WITA
                    </p>
                </div>
                <div class="status-right">
                    @php
                        $statusName = $laporan->status ? $laporan->status->nama_status : 'tidak_diketahui';
                        $statusText = ucfirst(str_replace('_', ' ', $statusName));
                        $statusBadgeClass = 'status-' . strtolower($statusName); // Membuat class CSS dinamis
                        // Fallback jika class CSS tidak ada
                        if (!in_array($statusBadgeClass, ['status-pending', 'status-disposisi', 'status-telah_disurvei', 'status-belum_dikerjakan', 'status-sedang_dikerjakan', 'status-telah_dikerjakan', 'status-reject'])) {
                            $statusBadgeClass = 'status-default';
                        }
                    @endphp
                    <span class="status-badge {{ $statusBadgeClass }}">{{ $statusText }}</span>
                </div>
            </div>
        </div>

        <!-- Location and Damage Details (Columnar) -->
        <div class="two-column">
            <div class="column-left">
                <h3 class="section-title">📍 Lokasi Kerusakan</h3>
                <div class="info-box">
                    <div class="info-item">
                        <span class="info-label">Alamat:</span>
                        <span class="info-value">{{ $laporan->alamat_lengkap_kerusakan }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kecamatan:</span>
                        <span class="info-value">{{ $laporan->kecamatan->nama ?? ($laporan->kecamatan->nama_kecamatan ?? '-') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kelurahan:</span>
                        <span class="info-value">{{ $laporan->kelurahan->nama ?? ($laporan->kelurahan->nama_kelurahan ?? '-') }}</span>
                    </div>
                    @if($laporan->latitude && $laporan->longitude)
                    <div class="info-item">
                        <span class="info-label">Koordinat:</span>
                        <span class="info-value text-blue">
                            {{ $laporan->latitude }}, {{ $laporan->longitude }}
                            @if($laporan->link_koordinat)
                                <br>
                                <a href="{{ $laporan->link_koordinat }}" target="_blank" style="color:#1e3a8a;text-decoration:underline;">
                                    Lihat di Google Maps
                                </a>
                            @elseif($laporan->latitude && $laporan->longitude)
                                <br>
                                <a href="https://maps.google.com/?q={{ $laporan->latitude }},{{ $laporan->longitude }}" target="_blank" style="color:#1e3a8a;text-decoration:underline;">
                                    Lihat di Google Maps
                                </a>
                            @endif
                        </span>
                    </div>
                    @endif
                </div>
            </div>
            <div class="column-right">
                <h3 class="section-title">⚠️ Detail Kerusakan</h3>
                <div class="info-box">
                    <div class="info-item">
                        <span class="info-label">Jenis:</span>
                        <span class="info-value text-red">{{ $laporan->jenis_kerusakan ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Description and Keterangan Disposisi (Full Width) -->
        <div class="main-description-block">
            <span class="description-label">Deskripsi Laporan:</span>
            <p class="description-text">{{ $laporan->deskripsi_laporan ?: 'Tidak ada deskripsi.' }}</p>

            {{-- $disposisiStatusId dikirim dari controller --}}
            @if ($laporan->status_id == $disposisiStatusId && !empty($laporan->keterangan))
                <span class="description-label" style="margin-top:10px;">Keterangan Disposisi:</span>
                <p class="keterangan-disposisi-text">{{ $laporan->keterangan }}</p>
            @endif
        </div>


        <!-- Rating and Feedback Pelapor -->
        <div class="rating-feedback-section">
            <h3 class="rating-feedback-title">⭐ Ulasan Pelapor</h3>
            <div class="rating-feedback-container">
                <div class="rating-box">
                    <div class="box-subtitle">Rating Kepuasan Layanan</div>
                    @if($laporan->rating_kepuasan)
                        @php
                            // Sesuaikan teks rating ini jika makna angka 1-5 berbeda
                            $ratingTextPdf = match((int)$laporan->rating_kepuasan) {
                                1 => 'Sangat Tidak Puas',
                                2 => 'Tidak Puas',
                                3 => 'Netral',
                                4 => 'Puas',
                                5 => 'Sangat Puas',
                                default => 'N/A'
                            };
                        @endphp
                        <div class="rating-display">{{ $ratingTextPdf }} ({{ $laporan->rating_kepuasan }}/5)</div>
                    @else
                        <p class="placeholder-text">Belum ada rating</p>
                    @endif
                </div>
                <div class="feedback-box">
                    <div class="box-subtitle">Feedback dari Pelapor</div>
                    @if($laporan->feedback)
                        <p class="feedback-display-text">"{{ $laporan->feedback }}"</p>
                    @else
                        <p class="placeholder-text">Belum ada feedback</p>
                    @endif
                </div>
            </div>
        </div>


        <!-- Photo Documentation -->
        <div class="photo-section">
            <h3 class="section-title">📷 Dokumentasi Foto Kerusakan</h3>
            @php
                $fotoArray = $laporan->foto_kerusakan ? json_decode($laporan->foto_kerusakan, true) : [];
                $fotoArray = is_array($fotoArray) ? $fotoArray : [];
            @endphp
            @if(!empty($fotoArray))
                <div class="photo-grid">
                    @foreach(array_chunk($fotoArray, 4) as $fotoChunk)
                        <div class="photo-row">
                            @foreach($fotoChunk as $foto)
                                <div class="photo-cell">
                                    @php
                                        $imagePath = storage_path('app/public/foto_kerusakan/' . $foto);
                                    @endphp
                                    @if(file_exists($imagePath))
                                        <div class="photo-item">
                                            <img src="{{ $imagePath }}" alt="Foto Kerusakan">
                                        </div>
                                    @else
                                        <div class="photo-item">
                                            <div class="photo-placeholder">
                                                Foto hilang
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            @for($i = count($fotoChunk); $i < 4; $i++)
                                <div class="photo-cell"> </div>
                            @endfor
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-photo">
                    <p>Tidak ada foto kerusakan</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Reporter Information -->
    <div class="card">
        <div class="reporter-header">
            <h2 class="reporter-title">👤 Data Pelapor</h2>
        </div>
        <div class="two-column">
            <div class="column-left">
                <div class="info-box">
                    <div class="info-item">
                        <span class="info-label">Nama:</span>
                        <span class="info-value">{{ $laporan->pelapor->nama_lengkap ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">No. Ponsel:</span>
                        <span class="info-value">{{ $laporan->pelapor->nomor_ponsel ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value text-blue">{{ $laporan->pelapor->email ?? '-' }}</span>
                    </div>
                </div>
            </div>
            <div class="column-right">
                <div class="info-box">
                    <div class="info-item">
                        <span class="info-label">Alamat:</span>
                        <span class="info-value">{{ $laporan->pelapor->alamat_pelapor ?? ($laporan->pelapor->alamat_lengkap ?? '-') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Rt/Rw:</span>
                        <span class="info-value">
                            {{ $laporan->pelapor->rt ?? '-' }}/{{ $laporan->pelapor->rw ?? '-' }}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kecamatan:</span>
                        <span class="info-value">{{ $laporan->pelapor->kecamatan->nama ?? ($laporan->pelapor->kecamatan->nama_kecamatan ?? '-') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kelurahan:</span>
                        <span class="info-value">{{ $laporan->pelapor->kelurahan->nama ?? ($laporan->pelapor->kelurahan->nama_kelurahan ?? '-') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-section">
        <p class="footer-text">Dokumen ini dibuat secara otomatis oleh Sistem Pelaporan</p>
        <p class="print-date">Dicetak pada: {{ now()->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }} WITA</p>
    </div>
</body>
</html>