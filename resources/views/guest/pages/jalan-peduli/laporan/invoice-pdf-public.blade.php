<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bukti Laporan (Publik) {{ $laporan->id_laporan }}</title>
    <style>
        @page {
            margin: 0;
            size: A4;
        }

        body {
            font-family: 'Helvetica', DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 11pt;
            background-color: #f4f7f6;
        }

        .header-section {
            background-color: #1e3a8a;
            color: white;
            padding: 30px 1in;
            position: relative;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .header-title {
            display: table-cell;
            vertical-align: middle;
        }

        .header-id {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
            width: 180px;
        }

        .header-title h1 {
            font-size: 20pt;
            font-weight: bold;
            margin: 0;
            line-height: 1.2;
        }

        .header-title p {
            font-size: 12pt;
            margin: 5px 0 0 0;
            opacity: 0.9;
        }

        .header-id-badge {
            background-color: #f59e0b;
            color: #1e3a8a;
            border-radius: 6px;
            padding: 10px 15px;
            display: inline-block;
            text-align: center;
        }

        .header-id-badge .label {
            font-size: 9pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .header-id-badge .value {
            font-size: 14pt;
            font-weight: bold;
            margin: 3px 0 0 0;
            letter-spacing: 1px;
        }

        .content-section {
            padding: 1in;
            background-color: #ffffff;
        }

        .content-title {
            font-size: 16pt;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
        }

        .section-subtitle {
            font-size: 12pt;
            font-weight: bold;
            color: #374151;
            margin: 25px 0 10px;
        }

        .block-title {
            font-size: 12pt;
            font-weight: bold;
            margin: 18px 0 8px;
            padding: 8px 10px;
            background: #f3f4f6;
            border-left: 4px solid #1e3a8a;
            color: #111827;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: top;
        }

        .details-table tr:last-child td {
            border-bottom: none;
        }

        .details-table .label {
            color: #6b7280;
            width: 180px;
        }

        .details-table .value {
            font-weight: bold;
            color: #1f2937;
        }

        .footer-section {
            text-align: center;
            padding: 20px 1in;
            font-size: 9pt;
            color: #6b7280;
            position: fixed;
            bottom: 0.5in;
            left: 0;
            right: 0;
        }

        .footer-section p {
            margin: 0;
        }

        /* Grid Foto (3 kolom) - sederhana agar kompatibel dengan DomPDF */
        .photo-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px;
            margin-top: 8px;
        }

        .photo-grid td {
            width: 33.33%;
            background: #fafafa;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 6px;
            text-align: center;
        }

        .photo-grid img {
            width: 100%;
            height: 120px;
            /* object-fit belum sepenuhnya didukung, tapi kita set ukuran agar proporsional */
        }
    </style>
</head>

<body>
    <div class="header-section">
        <div class="header-content">
            <div class="header-title">
                <h1>Bukti Laporan (Publik)</h1>
                <p>Sistem Pelaporan Kerusakan Jalan</p>
            </div>
            <div class="header-id">
                <div class="header-id-badge">
                    <p class="label">ID Laporan</p>
                    <p class="value">{{ $laporan->id_laporan }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="content-section">
        <h2 class="content-title">Detail Laporan</h2>
        @php
            $photos = [];
            if (!empty($laporan->foto_kerusakan)) {
                $arr = is_array($laporan->foto_kerusakan)
                    ? $laporan->foto_kerusakan
                    : json_decode($laporan->foto_kerusakan, true);
                $photos = is_array($arr) ? $arr : [];
            }
            $petugasPhotos = [];
            if (!empty($laporan->foto_lanjutan)) {
                $arr2 = is_array($laporan->foto_lanjutan)
                    ? $laporan->foto_lanjutan
                    : json_decode($laporan->foto_lanjutan, true);
                if (!is_array($arr2) && is_string($laporan->foto_lanjutan)) {
                    $arr2 = [$laporan->foto_lanjutan];
                }
                $petugasPhotos = is_array($arr2) ? $arr2 : [];
            }
        @endphp
        <div class="block-title">Informasi Laporan (User)</div>
        <table class="details-table">
            <tr>
                <td class="label">ID Laporan</td>
                <td class="value">{{ $laporan->id_laporan }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Lapor</td>
                <td class="value">
                    {{ \Carbon\Carbon::parse($laporan->created_at)->locale('id')->isoFormat('DD MMMM YYYY, HH:mm') }}
                    WITA</td>
            </tr>
            <tr>
                <td class="label">Kecamatan</td>
                <td class="value">
                    {{ optional($laporan->kecamatan)->nama ?? (optional($laporan->kecamatan)->nama_kecamatan ?? '-') }}
                </td>
            </tr>
            <tr>
                <td class="label">Kelurahan</td>
                <td class="value">
                    {{ optional($laporan->kelurahan)->nama ?? (optional($laporan->kelurahan)->nama_kelurahan ?? '-') }}
                </td>
            </tr>
            <tr>
                <td class="label">Alamat Lokasi</td>
                <td class="value">{{ $laporan->alamat_lengkap_kerusakan }}</td>
            </tr>
            <tr>
                <td class="label">Deskripsi Laporan</td>
                <td class="value">{{ $laporan->deskripsi_laporan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kerusakan</td>
                <td class="value">{{ $laporan->jenis_kerusakan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tingkat Kerusakan</td>
                <td class="value">{{ $laporan->tingkat_kerusakan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Koordinat</td>
                <td class="value">{{ $laporan->latitude }}, {{ $laporan->longitude }}</td>
            </tr>
            <tr>
                <td class="label">Link Peta</td>
                <td class="value">{{ $laporan->link_koordinat }}</td>
            </tr>
            @if ($laporan->dokumen_pendukung)
                <tr>
                    <td class="label">Dokumen Pendukung</td>
                    <td class="value">
                        <span>
                            <a href="{{ asset('storage/jalan_peduli/' . $laporan->id_laporan . '/' . $laporan->dokumen_pendukung) }}"
                                style="color:#1e3a8a; text-decoration: none;">
                                Lihat Dokumen (PDF)
                            </a>
                        </span>
                    </td>
                </tr>
            @endif
            @if ($laporan->dokumen_petugas)
                <tr>
                    <td class="label">Dokumen Petugas</td>
                    <td class="value">
                        <span>
                            <a href="{{ asset('storage/dokumen_petugas/' . $laporan->dokumen_petugas) }}"
                                style="color:#1e3a8a; text-decoration: none;">
                                Lihat Dokumen (PDF)
                            </a>
                        </span>
                    </td>
                </tr>
            @endif
            <tr>
                <td class="label">Jumlah Foto</td>
                <td class="value">{{ count($photos) }} Foto</td>
            </tr>
        </table>

        @if (count($photos))
            <h3 class="section-subtitle">Dokumentasi Kerusakan (User)</h3>
            <table class="photo-grid">
                @foreach ($photos as $i => $photo)
                    @if ($i % 3 === 0)
                        <tr>
                    @endif
                    <td>
                        @php
                            if (isset($photo_datauris[$i])) {
                                $src = $photo_datauris[$i];
                            } elseif (isset($photo_urls[$i])) {
                                $src = $photo_urls[$i];
                            } elseif (isset($photo_paths[$i])) {
                                $src = $photo_paths[$i];
                            } else {
                                $abs = storage_path('app/public/jalan_peduli/' . $laporan->id_laporan . '/' . $photo);
                                $real = realpath($abs) ?: $abs;
                                $normalized = str_replace('\\\\', '/', $real);
                                $normalized = str_replace(' ', '%20', $normalized);
                                $src = 'file:///' . $normalized;
                            }
                        @endphp
                        <img src="{{ $src }}" alt="Foto Kerusakan {{ $i + 1 }}">
                        <div style="font-size:9pt; color:#6b7280; margin-top:4px;">Foto {{ $i + 1 }}</div>
                    </td>
                    @if ($i % 3 === 2)
                        </tr>
                    @endif
                @endforeach
                @if (count($photos) % 3 !== 0)
                    @for ($k = 0; $k < 3 - (count($photos) % 3); $k++)
                        <td></td>
                    @endfor
                    </tr>
                @endif
            </table>
        @endif

        <div class="block-title" style="border-left-color:#059669;">Informasi Tindak Lanjut Petugas</div>
        <table class="details-table">
            <tr>
                <td class="label">Status</td>
                <td class="value">
                    {{ optional($laporan->status)->nama_status ? ucwords(str_replace('_', ' ', $laporan->status->nama_status)) : 'Tidak diketahui' }}
                </td>
            </tr>
            @if (!empty($laporan->keterangan))
                <tr>
                    <td class="label">Keterangan Petugas</td>
                    <td class="value">{{ $laporan->keterangan }}</td>
                </tr>
            @endif
            <tr>
                <td class="label">Jumlah Foto Petugas</td>
                <td class="value">{{ count($petugasPhotos) }} Foto</td>
            </tr>
        </table>



        @if (count($petugasPhotos))
            <h3 class="section-subtitle">Dokumentasi Tindak Lanjut (Petugas)</h3>
            <table class="photo-grid">
                @foreach ($petugasPhotos as $i => $photo)
                    @if ($i % 3 === 0)
                        <tr>
                    @endif
                    <td>
                        @php
                            if (isset($petugas_datauris[$i])) {
                                $src = $petugas_datauris[$i];
                            } elseif (isset($petugas_urls[$i])) {
                                $src = $petugas_urls[$i];
                            } elseif (isset($petugas_paths[$i])) {
                                $src = $petugas_paths[$i];
                            } else {
                                $abs = storage_path('app/public/foto_lanjutan/' . $photo);
                                $real = realpath($abs) ?: $abs;
                                $normalized = str_replace('\\\\', '/', $real);
                                $normalized = str_replace(' ', '%20', $normalized);
                                $src = 'file:///' . $normalized;
                            }
                        @endphp
                        <img src="{{ $src }}" alt="Dokumentasi Petugas {{ $i + 1 }}">
                        <div style="font-size:9pt; color:#6b7280; margin-top:4px;">Foto {{ $i + 1 }}</div>
                    </td>
                    @if ($i % 3 === 2)
                        </tr>
                    @endif
                @endforeach
                @if (count($petugasPhotos) % 3 !== 0)
                    @for ($k = 0; $k < 3 - (count($petugasPhotos) % 3); $k++)
                        <td></td>
                    @endfor
                    </tr>
                @endif
            </table>
        @endif
    </div>

    <div class="footer-section">
        <p>Dokumen publik ini dibuat otomatis pada {{ now()->locale('id')->isoFormat('D MMMM YYYY') }}.</p>
    </div>
</body>

</html>
