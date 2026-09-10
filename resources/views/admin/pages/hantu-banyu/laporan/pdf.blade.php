<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <title>Rekap Laporan Hantu Banyu</title>
  @php
    $statusLabels = [
        'pending' => 'Menunggu Verifikasi',
        'diterima' => 'Diterima',
        'menunggu_survei' => 'Menunggu Survei',
        'sudah_disurvei' => 'Sudah Disurvei',
        'menunggu_jadwal_pengerjaan' => 'Menunggu Jadwal Pengerjaan',
        'sedang_dikerjakan' => 'Sedang Dikerjakan',
        'selesai' => 'Selesai',
    ];
    $statusColor = [
        'pending' => '#92400e;background:#fef3c7',
        'diterima' => '#1e40af;background:#dbeafe',
        'menunggu_survei' => '#9d174d;background:#fce7f3',
        'sudah_disurvei' => '#6b21a8;background:#f3e8ff',
        'menunggu_jadwal_pengerjaan' => '#9a3412;background:#ffedd5',
        'sedang_dikerjakan' => '#3730a3;background:#e0e7ff',
        'selesai' => '#166534;background:#dcfce7',
    ];
    $jenisLabels = [
        'belum_diklasifikasikan' => 'Belum Diklasifikasikan',
        'darurat' => 'Penanganan Darurat',
        'biasa' => 'Penanganan Biasa',
        'rutin' => 'Pemeliharaan Rutin',
    ];
    $jenisColor = [
        'belum_diklasifikasikan' => '#374151;background:#f3f4f6',
        'darurat' => '#991b1b;background:#fee2e2',
        'biasa' => '#115e59;background:#ccfbf1',
        'rutin' => '#1e40af;background:#dbeafe',
    ];
    $urutStatus = array_flip($daftar_status);

    $fotoPath = function ($foto) {
        $rel = ltrim(str_replace('storage/', '', (string) $foto), '/');
        $abs = public_path('storage/' . $rel);
        return is_file($abs) ? $abs : null;
    };
  @endphp
  <style>
    @page {
      size: A4;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 9pt;
      line-height: 1.25;
      color: #1f2937;
      padding-bottom: 30px;
      /* ruang untuk footer tetap */
    }

    .page {
      page-break-after: always;
    }

    .page:last-child {
      page-break-after: auto;
    }

    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: baseline;
      flex-wrap: wrap;
      column-gap: 10px;
      border-bottom: 2px solid #223468;
      padding-bottom: 3px;
      margin-bottom: 5px;
      color: #223468;
    }

    .topbar .brand-group {
      display: flex;
      align-items: baseline;
      column-gap: 0;
      flex-wrap: wrap;
    }

    .topbar .brand {
      font-weight: bold;
      font-size: 9pt;
      letter-spacing: .04em;
      /* imbangi letter-spacing yang menempel di huruf terakhir */
      margin-right: -.04em;
      text-transform: uppercase;
    }

    .topbar .range {
      font-size: 9pt;
      color: #374151;
    }

    .topbar .range::before {
      content: "\00b7";
      margin: 0 6px;
    }

    .topbar .stamp {
      font-size: 7.5pt;
      color: #6b7280;
      white-space: nowrap;
    }

    h1.laporan-title {
      font-size: 12.5pt;
      margin: 0 0 2px;
      color: #223468;
    }

    .meta {
      margin-bottom: 5px;
      font-size: 8pt;
      color: #4b5563;
    }

    .badge {
      display: inline-block;
      padding: 1px 6px;
      border-radius: 8px;
      font-size: 7.5pt;
      font-weight: bold;
      color: #374151;
      background: #f3f4f6;
    }

    .section {
      margin-bottom: 4px;
    }

    .section-title {
      background: #223468;
      color: #fff;
      font-weight: bold;
      font-size: 8pt;
      letter-spacing: .03em;
      text-transform: uppercase;
      padding: 2px 6px;
      margin-bottom: 2px;
    }

    table.kv {
      width: 100%;
      border-collapse: collapse;
    }

    table.kv td {
      padding: 1px 4px;
      vertical-align: top;
    }

    table.kv td.k {
      width: 130px;
      font-weight: bold;
      color: #374151;
    }

    table.kv td.s {
      width: 10px;
    }

    .desc {
      padding: 1px 4px;
      text-align: justify;
      white-space: pre-line;
    }

    .thumbs {
      display: flex;
      flex-wrap: wrap;
      gap: 4px;
      padding: 2px 4px 1px;
    }

    .thumbs img {
      height: 60px;
      width: auto;
      border: 1px solid #d1d5db;
      border-radius: 3px;
    }

    .tl-item {
      border: 1px solid #d1d5db;
      border-left: 3px solid #223468;
      border-radius: 3px;
      padding: 3px 6px;
      margin-bottom: 3px;
      page-break-inside: avoid;
    }

    .tl-head {
      display: flex;
      justify-content: space-between;
      align-items: baseline;
      margin-bottom: 1px;
    }

    .tl-head .stage {
      font-weight: bold;
      color: #223468;
      font-size: 8.5pt;
    }

    .tl-head .when {
      font-size: 7.5pt;
      color: #6b7280;
    }

    .tl-desc {
      white-space: pre-line;
      text-align: justify;
    }

    .tl-item .thumbs img {
      height: 50px;
    }

    .muted {
      color: #6b7280;
      padding: 1px 4px;
    }

    .page-footer {
      position: fixed;
      left: 0;
      right: 0;
      bottom: 0;
      background: #fff;
      border-top: 1px solid #e5e7eb;
      padding-top: 3px;
      font-size: 7pt;
      color: #9ca3af;
      text-align: center;
    }
  </style>
</head>

<body>
  @foreach ($laporan as $item)
    @php
      $status = $item->status_terkini;
      $jenis = $item->jenis_laporan;
      $riwayat = $item->tindakLanjut->sortBy(fn($t) => $urutStatus[$t->status] ?? 99)->values();
    @endphp
    <div class="page">
      <div class="topbar">
        <span class="brand-group">
          <span class="brand">Rekap Laporan Hantu Banyu</span><span class="range">{{ $judul_rentang }}</span>
        </span>
        <span class="stamp">Dicetak {{ $dicetak_pada }}</span>
      </div>

      <h1 class="laporan-title">Laporan Nomor {{ $item->kode }}</h1>
      <div class="meta">
        Waktu masuk: {{ $item->created_at->translatedFormat('d F Y, H.i') }} WITA
        &nbsp;&bull;&nbsp;
        Status terkini:
        <span class="badge" style="color:{{ $status ? ($statusColor[$status] ?? '#374151;background:#f3f4f6') : '#374151;background:#f3f4f6' }}">
          {{ $status ? ($statusLabels[$status] ?? $status) : 'Belum ada' }}
        </span>
        &nbsp;&bull;&nbsp;
        Jenis:
        <span class="badge" style="color:{{ $jenisColor[$jenis] ?? '#374151;background:#f3f4f6' }}">
          {{ $jenisLabels[$jenis] ?? $jenis }}
        </span>
      </div>

      <div class="section">
        <div class="section-title">Data Pelapor</div>
        <table class="kv">
          <tr>
            <td class="k">Nama Lengkap</td>
            <td class="s">:</td>
            <td>{{ $item->pelapor->nama_lengkap ?? '-' }}</td>
          </tr>
          <tr>
            <td class="k">Asal Kelurahan</td>
            <td class="s">:</td>
            <td>{{ optional($item->pelapor->kelurahanAsal)->nama ?? '-' }}</td>
          </tr>
          <tr>
            <td class="k">Nomor Telepon</td>
            <td class="s">:</td>
            <td>{{ $item->pelapor->nomor_telepon ?? '-' }}</td>
          </tr>
          <tr>
            <td class="k">Alamat</td>
            <td class="s">:</td>
            <td>{{ $item->pelapor->alamat ?? '-' }}</td>
          </tr>
        </table>
      </div>

      <div class="section">
        <div class="section-title">Lokasi Pengaduan</div>
        <table class="kv">
          <tr>
            <td class="k">Kecamatan</td>
            <td class="s">:</td>
            <td>{{ $item->kecamatan->nama ?? '-' }}</td>
          </tr>
          <tr>
            <td class="k">Kelurahan</td>
            <td class="s">:</td>
            <td>{{ $item->kelurahan->nama ?? '-' }}</td>
          </tr>
          <tr>
            <td class="k">Nama Jalan</td>
            <td class="s">:</td>
            <td>{{ $item->nama_jalan }}</td>
          </tr>
          <tr>
            <td class="k">Detail Lokasi</td>
            <td class="s">:</td>
            <td>{{ $item->detail_lokasi }}</td>
          </tr>
          <tr>
            <td class="k">Koordinat</td>
            <td class="s">:</td>
            <td>{{ $item->latitude }}, {{ $item->longitude }}
              &nbsp;(<a
                href="https://maps.google.com/?q={{ $item->latitude }},{{ $item->longitude }}">maps.google.com/?q={{ $item->latitude }},{{ $item->longitude }}</a>)
            </td>
          </tr>
        </table>
      </div>

      <div class="section">
        <div class="section-title">Deskripsi Pengaduan</div>
        <div class="desc">{{ $item->deskripsi_pengaduan ?: '-' }}</div>
      </div>

      <div class="section">
        <div class="section-title">Foto Pengaduan</div>
        @php $fotoLaporan = $item->foto->take(6); @endphp
        @if ($fotoLaporan->isEmpty())
          <div class="muted">Tidak ada foto.</div>
        @else
          <div class="thumbs">
            @foreach ($fotoLaporan as $f)
              @php $src = $fotoPath($f->foto); @endphp
              @if ($src)
                <img src="{{ $src }}" alt="Foto pengaduan {{ $loop->iteration }}">
              @endif
            @endforeach
          </div>
        @endif
      </div>

      <div class="section">
        <div class="section-title">Riwayat Tindak Lanjut</div>
        @if ($riwayat->isEmpty())
          <div class="muted">Belum ada tindak lanjut.</div>
        @else
          @foreach ($riwayat as $tl)
            <div class="tl-item">
              <div class="tl-head">
                <span class="stage">{{ $loop->iteration }}. {{ $statusLabels[$tl->status] ?? $tl->status }}</span>
                <span class="when">{{ optional($tl->updated_at ?? $tl->created_at)->translatedFormat('d M Y, H.i') }} WITA</span>
              </div>
              <div class="tl-desc">{{ $tl->deskripsi ?: '-' }}</div>
              @php $tlFoto = $tl->foto->take(3); @endphp
              @if ($tlFoto->isNotEmpty())
                <div class="thumbs">
                  @foreach ($tlFoto as $f)
                    @php $src = $fotoPath($f->foto); @endphp
                    @if ($src)
                      <img src="{{ $src }}" alt="Foto tindak lanjut {{ $loop->iteration }}">
                    @endif
                  @endforeach
                </div>
              @endif
            </div>
          @endforeach
        @endif
      </div>
    </div>
  @endforeach

  <div class="page-footer">
    UPTD Pemeliharaan Saluran Drainase dan Irigasi &mdash; Dinas Pekerjaan Umum dan Penataan Ruang Kota Samarinda
  </div>
</body>

</html>
