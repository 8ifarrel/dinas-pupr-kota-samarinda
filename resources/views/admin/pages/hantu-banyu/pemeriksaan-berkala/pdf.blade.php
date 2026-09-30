<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <title>Pemeriksaan Berkala Saluran Hantu Banyu</title>
  <style>
    @page {
      size: A4 landscape;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 8pt;
      line-height: 1.3;
      color: #1f2937;
    }

    h1 {
      font-size: 13pt;
      margin: 0 0 2px;
    }

    .sub {
      font-size: 8pt;
      color: #6b7280;
      margin: 0 0 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      border: 1px solid #d1d5db;
      padding: 4px 6px;
      text-align: left;
      vertical-align: top;
    }

    th {
      background: #f3f4f6;
      font-size: 8pt;
    }

    td.center {
      text-align: center;
    }

    .badge {
      display: inline-block;
      padding: 1px 6px;
      border-radius: 9999px;
      font-size: 7.5pt;
      font-weight: bold;
      white-space: nowrap;
    }
  </style>
</head>

<body>
  @php
    $alirColor = [
        'lancar' => '#166534;background:#dcfce7',
        'kurang_lancar' => '#92400e;background:#fef3c7',
        'tersumbat_sebagian' => '#9a3412;background:#ffedd5',
        'macet_total' => '#991b1b;background:#fee2e2',
    ];
    $sedimentasiColor = [
        'normal' => '#166534;background:#dcfce7',
        'sedang' => '#92400e;background:#fef3c7',
        'tinggi' => '#991b1b;background:#fee2e2',
    ];
  @endphp

  <h1>Pemeriksaan Berkala Saluran Drainase &amp; Irigasi &mdash; Hantu Banyu</h1>
  <p class="sub">{{ $judul_rentang }} &middot; Dicetak pada {{ $dicetak_pada }} &middot; {{ $pemeriksaan->count() }} catatan</p>

  <table>
    <thead>
      <tr>
        <th style="width:2%">No</th>
        <th style="width:6%">Tanggal</th>
        <th style="width:7%">Kecamatan</th>
        <th style="width:7%">Kelurahan</th>
        <th style="width:9%">Nama Jalan</th>
        <th style="width:8%">Nama Ruas Saluran</th>
        <th style="width:6%">Dimensi Eksisting (L x T)</th>
        <th style="width:11%">Kondisi Fisik Struktur (Dinding/Lantai)</th>
        <th style="width:9%">Sedimentasi &amp; Sampah</th>
        <th style="width:6%">Status Aliran Air</th>
        <th style="width:11%">Tindakan Pemeliharaan yang Dilakukan</th>
        <th style="width:9%">Hambatan / Kendala Lapangan</th>
        <th style="width:11%">Rekomendasi / Tindak Lanjut</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($pemeriksaan as $i => $p)
        <tr>
          <td class="center">{{ $i + 1 }}</td>
          <td>{{ $p->tanggal_pemeriksaan->translatedFormat('d M Y') }}</td>
          <td>{{ optional($p->kecamatan)->nama ?? '-' }}</td>
          <td>{{ optional($p->kelurahan)->nama ?? '-' }}</td>
          <td>{{ $p->nama_jalan }}</td>
          <td>{{ $ruas_saluran_label[$p->nama_ruas_saluran] ?? $p->nama_ruas_saluran }}</td>
          <td class="center">
            @if ($p->dimensi_lebar_m !== null && $p->dimensi_tinggi_m !== null)
              {{ number_format((float) $p->dimensi_lebar_m, 2) }} x {{ number_format((float) $p->dimensi_tinggi_m, 2) }} m
            @else
              -
            @endif
          </td>
          <td>{{ $p->kondisi_fisik_struktur }}</td>
          <td class="center">
            @if ($p->tingkat_sedimentasi_sampah_cm !== null)
              {{ rtrim(rtrim(number_format((float) $p->tingkat_sedimentasi_sampah_cm, 1), '0'), '.') }} cm<br>
            @endif
            @if ($p->persen_sedimentasi !== null)
              <span class="badge" style="color:{{ explode(';background:', $sedimentasiColor[$p->kategori_sedimentasi] ?? '#374151;background:#f3f4f6')[0] }};background:{{ explode(';background:', $sedimentasiColor[$p->kategori_sedimentasi] ?? '#374151;background:#f3f4f6')[1] }}">
                {{ $p->persen_sedimentasi }}% ({{ $kategori_sedimentasi_label[$p->kategori_sedimentasi] ?? '-' }})
              </span>
            @elseif ($p->tingkat_sedimentasi_sampah_cm === null)
              -
            @endif
          </td>
          <td class="center">
            <span class="badge" style="color:{{ explode(';background:', $alirColor[$p->status_aliran_air] ?? '#374151;background:#f3f4f6')[0] }};background:{{ explode(';background:', $alirColor[$p->status_aliran_air] ?? '#374151;background:#f3f4f6')[1] }}">
              {{ $status_aliran_label[$p->status_aliran_air] ?? ucwords(str_replace('_', ' ', $p->status_aliran_air)) }}
            </span>
          </td>
          <td>{{ $p->tindakan_pemeliharaan }}</td>
          <td>{{ $p->hambatan_kendala ?: '-' }}</td>
          <td>{{ $p->rekomendasi_tindak_lanjut ?: '-' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
