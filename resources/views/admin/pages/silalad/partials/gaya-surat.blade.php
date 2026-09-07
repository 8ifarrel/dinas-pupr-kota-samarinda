{{--
  Gaya bersama untuk ketiga surat SILALAD (Surat Pesanan, Surat Perintah
  Kerja, Surat Jalan). Dipisah ke sini supaya CSS-nya tidak disalin tiga kali
  dan tampilan ketiganya dijamin seragam.
--}}
<style>
  * {
    box-sizing: border-box;
  }

  body {
    font-family: 'Times New Roman', Times, serif;
    font-size: 14px;
    line-height: 1.7;
    color: #111;
    background: #f5f5f5;
    margin: 0;
    padding: 20px;
  }

  .container {
    width: 21cm;
    min-height: 29.7cm;
    margin: 0 auto;
    background: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    padding: 1.5cm;
  }

  .no-print {
    text-align: right;
    margin-bottom: 20px;
  }

  .no-print button {
    background: #223468;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-family: Arial, sans-serif;
  }

  h1 {
    text-align: center;
    font-size: 18px;
    text-decoration: underline;
    margin-bottom: 4px;
  }

  .subtitle {
    text-align: center;
    margin-top: 0;
    margin-bottom: 24px;
  }

  .tujuan {
    margin-bottom: 16px;
  }

  .kelompok {
    margin: 16px 0;
  }

  .kelompok p {
    margin: 6px 0;
  }

  /* Isian yang belum terisi tetap tampak sebagai tempat menulis tangan. */
  .isian {
    border-bottom: 1px dotted #333;
    padding: 0 6px;
    display: inline-block;
    min-width: 120px;
  }

  .catatan {
    margin-top: 20px;
  }

  .ttd-kanan {
    margin-top: 48px;
    text-align: right;
  }

  .ttd-kanan p {
    margin: 4px 0;
  }

  .garis-ttd {
    margin-top: 80px;
    font-weight: bold;
    border-top: 1px solid #333;
    display: inline-block;
    padding-top: 4px;
    min-width: 220px;
  }

  .ttd-dua {
    display: flex;
    justify-content: space-between;
    margin-top: 48px;
    gap: 40px;
  }

  .ttd-dua > div {
    text-align: center;
    flex: 1;
  }

  .kontak {
    margin-top: 40px;
    text-align: center;
    font-weight: bold;
  }

  @media print {
    body {
      background: white;
      padding: 0;
    }

    .container {
      box-shadow: none;
      width: auto;
      min-height: 0;
      padding: 1.5cm;
    }

    .no-print {
      display: none !important;
    }
  }
</style>
