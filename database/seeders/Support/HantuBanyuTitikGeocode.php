<?php

/**
 * Titik koordinat + nama jalan nyata untuk tiap laporan contoh Hantu Banyu:
 * 7 titik per kelurahan Samarinda (satu untuk tiap tahap penanganan).
 *
 * Cara pengambilannya (lihat HantuBanyuSeeder::titikDiJalanSekitar()):
 *  1. Titik pusat & batas wilayah kelurahan diambil dari Nominatim, sekalian
 *     dengan poligon batasnya (parameter polygon_geojson).
 *  2. SATU panggilan Overpass API (OverpassJalanTerdekat::jalanDalamArea())
 *     mengambil seluruh ruas jalan bernama yang berada DI DALAM batas
 *     wilayah itu - bukan sekadar dalam radius, yang mau tidak mau ikut
 *     menjaring jalan milik kelurahan tetangga.
 *  3. Titik laporan diletakkan TEPAT pada simpul ruas jalan tersebut, dengan
 *     tiga syarat: simpulnya berada di dalam poligon kelurahan, berjarak
 *     minimal 120 m dari titik lain di kelurahan yang sama, dan minimal 30 m
 *     dari titik milik kelurahan lain (ruas jalan yang jadi batas wilayah
 *     bisa terambil dua kali).
 *
 * Hasilnya: nama jalan dan koordinat pasti sinkron - titiknya memang simpul
 * jalan itu sendiri, bukan tebakan reverse-geocode - tidak ada dua laporan
 * yang menumpuk di koordinat sama, dan titiknya berada di kelurahan yang
 * benar (diuji dengan sampel acak lewat reverse-geocode Nominatim).
 *
 * Dibekukan (bukan dipanggil ulang tiap db:seed) karena Nominatim & Overpass
 * dibatasi ~1 request/detik. Kelurahan yang belum ada di sini akan
 * di-geocode langsung oleh seeder sebagai cadangan.
 *
 * Kelurahan pemekaran yang tidak punya batas wilayah tersendiri di OSM
 * (kelompok "Sungai Pinang ...", Serijabo, Penyandingan, dll.) tidak bisa
 * disaring seakurat itu: titiknya diambil dari sekitar pusat kecamatan yang
 * digeser tetap per id kelurahan. Keterbatasan data sumber, bukan bug.
 *
 * Format: [kelurahan_id => [ ['lat'=>, 'lon'=>, 'jalan'=>], ... 7 titik ] ]
 */
return array (
  44461 => 
  array (
    0 => 
    array (
      'lat' => -0.5896719,
      'lon' => 117.1038857,
      'jalan' => 'HAMM Rifaddin',
    ),
    1 => 
    array (
      'lat' => -0.5760483,
      'lon' => 117.0970501,
      'jalan' => 'Jalan Taman Siswa',
    ),
    2 => 
    array (
      'lat' => -0.575432,
      'lon' => 117.0979465,
      'jalan' => 'Jalan Emas Raya',
    ),
    3 => 
    array (
      'lat' => -0.57437,
      'lon' => 117.0976942,
      'jalan' => 'Jalan Soekarno-Hatta',
    ),
    4 => 
    array (
      'lat' => -0.585687,
      'lon' => 117.1108525,
      'jalan' => 'Jalan Stadion',
    ),
    5 => 
    array (
      'lat' => -0.5908171,
      'lon' => 117.1029,
      'jalan' => 'HAMM Rifaddin',
    ),
    6 => 
    array (
      'lat' => -0.592008,
      'lon' => 117.1023703,
      'jalan' => 'HAMM Rifaddin',
    ),
  ),
  44462 => 
  array (
    0 => 
    array (
      'lat' => -0.5549216,
      'lon' => 117.0874867,
      'jalan' => 'Padang Golf',
    ),
    1 => 
    array (
      'lat' => -0.5563935,
      'lon' => 117.0865081,
      'jalan' => 'Jembatan Mahakam Ulu',
    ),
    2 => 
    array (
      'lat' => -0.5567584,
      'lon' => 117.0885519,
      'jalan' => 'Jembatan Mahulu',
    ),
    3 => 
    array (
      'lat' => -0.5570138,
      'lon' => 117.0896351,
      'jalan' => 'Bundaran Mahulu',
    ),
    4 => 
    array (
      'lat' => -0.5575501,
      'lon' => 117.0910446,
      'jalan' => 'Moeis Hasan',
    ),
    5 => 
    array (
      'lat' => -0.5661737,
      'lon' => 117.0884449,
      'jalan' => 'Sumber Mas',
    ),
    6 => 
    array (
      'lat' => -0.5529717,
      'lon' => 117.1021261,
      'jalan' => 'Jati 2',
    ),
  ),
  44463 => 
  array (
    0 => 
    array (
      'lat' => -0.5743037,
      'lon' => 117.0945131,
      'jalan' => 'Barito',
    ),
    1 => 
    array (
      'lat' => -0.5751897,
      'lon' => 117.0954247,
      'jalan' => 'Jalan Swadaya 2',
    ),
    2 => 
    array (
      'lat' => -0.5759484,
      'lon' => 117.0962233,
      'jalan' => 'Jalan Swadaya',
    ),
    3 => 
    array (
      'lat' => -0.5772307,
      'lon' => 117.0959784,
      'jalan' => 'Jalan Taman Siswa',
    ),
    4 => 
    array (
      'lat' => -0.5764143,
      'lon' => 117.090109,
      'jalan' => 'Manunggal',
    ),
    5 => 
    array (
      'lat' => -0.5699611,
      'lon' => 117.0977472,
      'jalan' => 'Jalan Achmad Barkanie',
    ),
    6 => 
    array (
      'lat' => -0.5685198,
      'lon' => 117.0893233,
      'jalan' => 'Batuah',
    ),
  ),
  44464 => 
  array (
    0 => 
    array (
      'lat' => -0.5359062,
      'lon' => 117.1326531,
      'jalan' => 'Jalan K.H. Harun Nafsi',
    ),
    1 => 
    array (
      'lat' => -0.5338216,
      'lon' => 117.1344401,
      'jalan' => 'Jalan Aji Pangeran Tumenggung Pranoto',
    ),
    2 => 
    array (
      'lat' => -0.539863,
      'lon' => 117.1276783,
      'jalan' => 'Perumahan Samarinda Hill',
    ),
    3 => 
    array (
      'lat' => -0.5340093,
      'lon' => 117.1398997,
      'jalan' => 'Jalan SMP 8',
    ),
    4 => 
    array (
      'lat' => -0.5416989,
      'lon' => 117.1250738,
      'jalan' => 'Teluk Merindu',
    ),
    5 => 
    array (
      'lat' => -0.5276392,
      'lon' => 117.1381492,
      'jalan' => 'Jalan Perumahan Gemilang',
    ),
    6 => 
    array (
      'lat' => -0.5303404,
      'lon' => 117.1417494,
      'jalan' => 'Jalan Firdaus',
    ),
  ),
  44465 => 
  array (
    0 => 
    array (
      'lat' => -0.5451065,
      'lon' => 117.1060905,
      'jalan' => 'Bina Bersama',
    ),
    1 => 
    array (
      'lat' => -0.5427387,
      'lon' => 117.1062938,
      'jalan' => 'Jalan Haji Ramli HS',
    ),
    2 => 
    array (
      'lat' => -0.5426971,
      'lon' => 117.1074125,
      'jalan' => 'Jalan Manunggal 3',
    ),
    3 => 
    array (
      'lat' => -0.5442295,
      'lon' => 117.1046971,
      'jalan' => 'Jalan Kurnia Makmur',
    ),
    4 => 
    array (
      'lat' => -0.5460493,
      'lon' => 117.10485,
      'jalan' => 'Jati 1',
    ),
    5 => 
    array (
      'lat' => -0.5452781,
      'lon' => 117.1038696,
      'jalan' => 'Pelita',
    ),
    6 => 
    array (
      'lat' => -0.5436002,
      'lon' => 117.1030047,
      'jalan' => 'Pelita III',
    ),
  ),
  44466 => 
  array (
    0 => 
    array (
      'lat' => -0.6461568,
      'lon' => 117.2142271,
      'jalan' => 'Jalan Provinsi',
    ),
    1 => 
    array (
      'lat' => -0.6452543,
      'lon' => 117.2114359,
      'jalan' => 'Jalan Al-Hasnie',
    ),
    2 => 
    array (
      'lat' => -0.6597257,
      'lon' => 117.2255447,
      'jalan' => 'Jembatan 27 Januari',
    ),
    3 => 
    array (
      'lat' => -0.6687713,
      'lon' => 117.1794257,
      'jalan' => 'Jalan Delima',
    ),
    4 => 
    array (
      'lat' => -0.7023487,
      'lon' => 117.162899,
      'jalan' => 'Jalan Tani Harapan',
    ),
    5 => 
    array (
      'lat' => -0.6458888,
      'lon' => 117.2131275,
      'jalan' => 'Jalan Provinsi',
    ),
    6 => 
    array (
      'lat' => -0.6453691,
      'lon' => 117.2102784,
      'jalan' => 'Jalan Al-Hasnie',
    ),
  ),
  44467 => 
  array (
    0 => 
    array (
      'lat' => -0.5695578,
      'lon' => 117.1755325,
      'jalan' => 'Jalan Ampera',
    ),
    1 => 
    array (
      'lat' => -0.5669548,
      'lon' => 117.1776378,
      'jalan' => 'Jalan S. Parman',
    ),
    2 => 
    array (
      'lat' => -0.5717189,
      'lon' => 117.1767103,
      'jalan' => 'Jalan Kenanga',
    ),
    3 => 
    array (
      'lat' => -0.5694251,
      'lon' => 117.1800564,
      'jalan' => 'Jalan Melanti',
    ),
    4 => 
    array (
      'lat' => -0.5668381,
      'lon' => 117.1746813,
      'jalan' => 'Jalan Palaran Indah',
    ),
    5 => 
    array (
      'lat' => -0.5679803,
      'lon' => 117.1737368,
      'jalan' => 'Jalan M. Noor',
    ),
    6 => 
    array (
      'lat' => -0.5726877,
      'lon' => 117.1773212,
      'jalan' => 'Jalan Mulawarman',
    ),
  ),
  44468 => 
  array (
    0 => 
    array (
      'lat' => -0.5748508,
      'lon' => 117.1397147,
      'jalan' => 'Jalan Surabaya',
    ),
    1 => 
    array (
      'lat' => -0.5764581,
      'lon' => 117.1395967,
      'jalan' => 'Gotong Royong',
    ),
    2 => 
    array (
      'lat' => -0.5721901,
      'lon' => 117.1429534,
      'jalan' => 'Jalan Niaga 1',
    ),
    3 => 
    array (
      'lat' => -0.57926,
      'lon' => 117.1354972,
      'jalan' => 'Jalan Jambu',
    ),
    4 => 
    array (
      'lat' => -0.5669742,
      'lon' => 117.1491743,
      'jalan' => 'Jalan Teratai',
    ),
    5 => 
    array (
      'lat' => -0.5681197,
      'lon' => 117.1542599,
      'jalan' => 'Jalan Kembang Kuning',
    ),
    6 => 
    array (
      'lat' => -0.5861862,
      'lon' => 117.125205,
      'jalan' => 'Jalan Stadion',
    ),
  ),
  44469 => 
  array (
    0 => 
    array (
      'lat' => -0.5808398,
      'lon' => 117.2106143,
      'jalan' => 'Diponegoro',
    ),
    1 => 
    array (
      'lat' => -0.5822023,
      'lon' => 117.2129698,
      'jalan' => 'Cendana',
    ),
    2 => 
    array (
      'lat' => -0.5809364,
      'lon' => 117.2064037,
      'jalan' => 'Mayor Ngoedio',
    ),
    3 => 
    array (
      'lat' => -0.5829511,
      'lon' => 117.2060039,
      'jalan' => 'Inpres 3',
    ),
    4 => 
    array (
      'lat' => -0.585873,
      'lon' => 117.2177809,
      'jalan' => 'Jalan AMD',
    ),
    5 => 
    array (
      'lat' => -0.5789326,
      'lon' => 117.2006419,
      'jalan' => 'Nahkoda',
    ),
    6 => 
    array (
      'lat' => -0.5779944,
      'lon' => 117.1993829,
      'jalan' => 'Sirsak',
    ),
  ),
  44470 => 
  array (
    0 => 
    array (
      'lat' => -0.5890402,
      'lon' => 117.1764934,
      'jalan' => 'Jalan Parikesit II',
    ),
    1 => 
    array (
      'lat' => -0.589514,
      'lon' => 117.1748731,
      'jalan' => 'Karya Bakti',
    ),
    2 => 
    array (
      'lat' => -0.5896427,
      'lon' => 117.1649363,
      'jalan' => 'Jalan Irigasi',
    ),
    3 => 
    array (
      'lat' => -0.6000314,
      'lon' => 117.1929243,
      'jalan' => 'Jalan Provinsi',
    ),
    4 => 
    array (
      'lat' => -0.5696154,
      'lon' => 117.1537992,
      'jalan' => 'Jalan Kembang Kuning',
    ),
    5 => 
    array (
      'lat' => -0.5659529,
      'lon' => 117.1564087,
      'jalan' => 'Jalan Padat Karya',
    ),
    6 => 
    array (
      'lat' => -0.5600036,
      'lon' => 117.1618517,
      'jalan' => 'Jalan Anggur',
    ),
  ),
  44471 => 
  array (
    0 => 
    array (
      'lat' => -0.4948829,
      'lon' => 117.163246,
      'jalan' => 'Jalan Kapas',
    ),
    1 => 
    array (
      'lat' => -0.495492,
      'lon' => 117.1623376,
      'jalan' => 'Jalan Biawan',
    ),
    2 => 
    array (
      'lat' => -0.4955767,
      'lon' => 117.1643521,
      'jalan' => 'Jalan Rumbia',
    ),
    3 => 
    array (
      'lat' => -0.4944304,
      'lon' => 117.1643991,
      'jalan' => 'Jalan Palma',
    ),
    4 => 
    array (
      'lat' => -0.4941709,
      'lon' => 117.1623682,
      'jalan' => 'Jalan Marsda A. Saleh',
    ),
    5 => 
    array (
      'lat' => -0.4929683,
      'lon' => 117.1622805,
      'jalan' => 'Jalan Urip Sumoharjo',
    ),
    6 => 
    array (
      'lat' => -0.4953496,
      'lon' => 117.1656972,
      'jalan' => 'Jalan Rumbia 2',
    ),
  ),
  44472 => 
  array (
    0 => 
    array (
      'lat' => -0.487618,
      'lon' => 117.1594642,
      'jalan' => 'Jalan K.H. Usman Ibrahim',
    ),
    1 => 
    array (
      'lat' => -0.4893736,
      'lon' => 117.1598981,
      'jalan' => 'Jalan Lambung Mangkurat 2',
    ),
    2 => 
    array (
      'lat' => -0.485808,
      'lon' => 117.1583831,
      'jalan' => 'L',
    ),
    3 => 
    array (
      'lat' => -0.488533,
      'lon' => 117.1563999,
      'jalan' => 'Jalan Azis Samad',
    ),
    4 => 
    array (
      'lat' => -0.4850607,
      'lon' => 117.1592793,
      'jalan' => 'Jalan Dirgantara 4',
    ),
    5 => 
    array (
      'lat' => -0.4846011,
      'lon' => 117.1611015,
      'jalan' => 'Jalan K.H. Samanhudi',
    ),
    6 => 
    array (
      'lat' => -0.48909,
      'lon' => 117.1624027,
      'jalan' => 'Jalan Urip Sumoharjo',
    ),
  ),
  44473 => 
  array (
    0 => 
    array (
      'lat' => -0.5034754,
      'lon' => 117.1653829,
      'jalan' => 'Jalan Damai',
    ),
    1 => 
    array (
      'lat' => -0.5049354,
      'lon' => 117.1637317,
      'jalan' => 'Jalan Otto Iskandardinata',
    ),
    2 => 
    array (
      'lat' => -0.5012354,
      'lon' => 117.1596564,
      'jalan' => 'Jalan Jelawat',
    ),
    3 => 
    array (
      'lat' => -0.4920552,
      'lon' => 117.1726709,
      'jalan' => 'Jalan Damai-Sambutan',
    ),
    4 => 
    array (
      'lat' => -0.5027891,
      'lon' => 117.1663094,
      'jalan' => 'Jalan Damai',
    ),
    5 => 
    array (
      'lat' => -0.5048666,
      'lon' => 117.162612,
      'jalan' => 'Jalan Otto Iskandardinata',
    ),
    6 => 
    array (
      'lat' => -0.5001149,
      'lon' => 117.1598548,
      'jalan' => 'Jalan Jelawat',
    ),
  ),
  44474 => 
  array (
    0 => 
    array (
      'lat' => -0.5070422,
      'lon' => 117.1613509,
      'jalan' => 'Terowongan Selili',
    ),
    1 => 
    array (
      'lat' => -0.5064944,
      'lon' => 117.1600452,
      'jalan' => 'Kakap',
    ),
    2 => 
    array (
      'lat' => -0.5072527,
      'lon' => 117.1591077,
      'jalan' => 'Jalan Gurami',
    ),
    3 => 
    array (
      'lat' => -0.5082904,
      'lon' => 117.1585163,
      'jalan' => 'Jalan Udang',
    ),
    4 => 
    array (
      'lat' => -0.5040128,
      'lon' => 117.1611844,
      'jalan' => 'Jalan Otto Iskandardinata',
    ),
    5 => 
    array (
      'lat' => -0.5064115,
      'lon' => 117.1578659,
      'jalan' => 'Jalan Tongkol',
    ),
    6 => 
    array (
      'lat' => -0.5052039,
      'lon' => 117.1581736,
      'jalan' => 'Pesut',
    ),
  ),
  44475 => 
  array (
    0 => 
    array (
      'lat' => -0.5192085,
      'lon' => 117.1603178,
      'jalan' => 'Jalan Lumba-lumba',
    ),
    1 => 
    array (
      'lat' => -0.5180294,
      'lon' => 117.163188,
      'jalan' => 'Jalan Sultan Alimuddin',
    ),
    2 => 
    array (
      'lat' => -0.5195529,
      'lon' => 117.1629802,
      'jalan' => 'Jalan Sejati',
    ),
    3 => 
    array (
      'lat' => -0.5206819,
      'lon' => 117.1624814,
      'jalan' => 'Cumi-cumi',
    ),
    4 => 
    array (
      'lat' => -0.5223396,
      'lon' => 117.163711,
      'jalan' => 'Haji Marhusin',
    ),
    5 => 
    array (
      'lat' => -0.5243885,
      'lon' => 117.1622861,
      'jalan' => 'Jalan Arwana 2',
    ),
    6 => 
    array (
      'lat' => -0.5250418,
      'lon' => 117.1600397,
      'jalan' => 'Jalan Keramat',
    ),
  ),
  44476 => 
  array (
    0 => 
    array (
      'lat' => -0.4972799,
      'lon' => 117.1446206,
      'jalan' => 'Jalan K.H. Abdurrasyid',
    ),
    1 => 
    array (
      'lat' => -0.4962307,
      'lon' => 117.144264,
      'jalan' => 'Jalan Taman Samarendah',
    ),
    2 => 
    array (
      'lat' => -0.4981389,
      'lon' => 117.1438735,
      'jalan' => 'Jalan Awang Long',
    ),
    3 => 
    array (
      'lat' => -0.4991081,
      'lon' => 117.1453098,
      'jalan' => 'Nilam',
    ),
    4 => 
    array (
      'lat' => -0.4981784,
      'lon' => 117.1458607,
      'jalan' => 'Jalan Asrama Type K Dalam',
    ),
    5 => 
    array (
      'lat' => -0.4952396,
      'lon' => 117.1452427,
      'jalan' => 'Jalan Cempaka',
    ),
    6 => 
    array (
      'lat' => -0.4972449,
      'lon' => 117.1431283,
      'jalan' => 'Jalan Milono',
    ),
  ),
  44477 => 
  array (
    0 => 
    array (
      'lat' => -0.4922181,
      'lon' => 117.1537323,
      'jalan' => 'Jalan Danau Maninjau',
    ),
    1 => 
    array (
      'lat' => -0.4935088,
      'lon' => 117.1538807,
      'jalan' => 'Jalan Danau Poso',
    ),
    2 => 
    array (
      'lat' => -0.4919938,
      'lon' => 117.1547988,
      'jalan' => 'Jalan Tarmidi',
    ),
    3 => 
    array (
      'lat' => -0.4945801,
      'lon' => 117.1543252,
      'jalan' => 'Jalan Danau Melintang',
    ),
    4 => 
    array (
      'lat' => -0.4933547,
      'lon' => 117.1525919,
      'jalan' => 'Jalan Danau Jempang',
    ),
    5 => 
    array (
      'lat' => -0.4942284,
      'lon' => 117.1516961,
      'jalan' => 'Jalan Danau Semayang',
    ),
    6 => 
    array (
      'lat' => -0.4935086,
      'lon' => 117.155315,
      'jalan' => 'Jalan Kyai Haji Ahmad Dachlan',
    ),
  ),
  44478 => 
  array (
    0 => 
    array (
      'lat' => -0.5041006,
      'lon' => 117.1567152,
      'jalan' => 'Jalan Pulau Banda',
    ),
    1 => 
    array (
      'lat' => -0.503125,
      'lon' => 117.1555739,
      'jalan' => 'Jalan Pulau Samosir',
    ),
    2 => 
    array (
      'lat' => -0.5047825,
      'lon' => 117.1555383,
      'jalan' => 'Jalan Mulawarman',
    ),
    3 => 
    array (
      'lat' => -0.5024384,
      'lon' => 117.1567916,
      'jalan' => 'Jalan Pangeran Hidayatullah',
    ),
    4 => 
    array (
      'lat' => -0.5045076,
      'lon' => 117.157839,
      'jalan' => 'Jalan Pangeran Suriansyah',
    ),
    5 => 
    array (
      'lat' => -0.5059328,
      'lon' => 117.1574477,
      'jalan' => 'Jembatan S',
    ),
    6 => 
    array (
      'lat' => -0.5029547,
      'lon' => 117.1584479,
      'jalan' => 'Jalan Muso Salim',
    ),
  ),
  44479 => 
  array (
    0 => 
    array (
      'lat' => -0.5010068,
      'lon' => 117.1471659,
      'jalan' => 'Jalan K.H. Khalid',
    ),
    1 => 
    array (
      'lat' => -0.4999141,
      'lon' => 117.1462457,
      'jalan' => 'Jalan Mutiara',
    ),
    2 => 
    array (
      'lat' => -0.5018638,
      'lon' => 117.1478344,
      'jalan' => 'Jalan Panglima Batur',
    ),
    3 => 
    array (
      'lat' => -0.5030968,
      'lon' => 117.1470129,
      'jalan' => 'Jalan Mas Temenggung',
    ),
    4 => 
    array (
      'lat' => -0.5018413,
      'lon' => 117.146457,
      'jalan' => 'Jalan Jenderal Sudirman',
    ),
    5 => 
    array (
      'lat' => -0.5006878,
      'lon' => 117.1454694,
      'jalan' => 'Jalan Jamrud',
    ),
    6 => 
    array (
      'lat' => -0.4996763,
      'lon' => 117.1477697,
      'jalan' => 'Jalan Pangeran Diponegoro',
    ),
  ),
  44480 => 
  array (
    0 => 
    array (
      'lat' => -0.5042099,
      'lon' => 117.1526094,
      'jalan' => 'Pelabuhan',
    ),
    1 => 
    array (
      'lat' => -0.5033047,
      'lon' => 117.1532263,
      'jalan' => 'Jalan Mulawarman',
    ),
    2 => 
    array (
      'lat' => -0.5019261,
      'lon' => 117.1542884,
      'jalan' => 'Jalan Pulau Flores',
    ),
    3 => 
    array (
      'lat' => -0.5053176,
      'lon' => 117.1528079,
      'jalan' => 'Dermaga',
    ),
    4 => 
    array (
      'lat' => -0.5032041,
      'lon' => 117.1515215,
      'jalan' => 'Jalan Niaga Timur',
    ),
    5 => 
    array (
      'lat' => -0.5027936,
      'lon' => 117.1499795,
      'jalan' => 'Jalan Niaga Utara',
    ),
    6 => 
    array (
      'lat' => -0.5019522,
      'lon' => 117.1519265,
      'jalan' => 'Jalan Pulau Sebatik',
    ),
  ),
  44481 => 
  array (
    0 => 
    array (
      'lat' => -0.5183998,
      'lon' => 117.1503071,
      'jalan' => 'Abdul Rasyid',
    ),
    1 => 
    array (
      'lat' => -0.5198935,
      'lon' => 117.1502731,
      'jalan' => 'Jalan Hajah Aminah Amin 5',
    ),
    2 => 
    array (
      'lat' => -0.5197316,
      'lon' => 117.1491836,
      'jalan' => 'Perumahan Uka',
    ),
    3 => 
    array (
      'lat' => -0.5174045,
      'lon' => 117.149563,
      'jalan' => 'Mas Penghulu',
    ),
    4 => 
    array (
      'lat' => -0.5204032,
      'lon' => 117.1517767,
      'jalan' => 'Mangkupalas',
    ),
    5 => 
    array (
      'lat' => -0.5198358,
      'lon' => 117.1478485,
      'jalan' => 'Jalan Teluk Bayur',
    ),
    6 => 
    array (
      'lat' => -0.5191264,
      'lon' => 117.1532437,
      'jalan' => 'Jalan Mangkupalas',
    ),
  ),
  44482 => 
  array (
    0 => 
    array (
      'lat' => -0.5169952,
      'lon' => 117.1258846,
      'jalan' => 'Abdul Sani Gani',
    ),
    1 => 
    array (
      'lat' => -0.5171081,
      'lon' => 117.1238702,
      'jalan' => 'Bung Tomo',
    ),
    2 => 
    array (
      'lat' => -0.5183334,
      'lon' => 117.1266682,
      'jalan' => 'Reel 6',
    ),
    3 => 
    array (
      'lat' => -0.5160239,
      'lon' => 117.1249306,
      'jalan' => 'Haji Jahrah',
    ),
    4 => 
    array (
      'lat' => -0.5180105,
      'lon' => 117.1277664,
      'jalan' => 'Rel 10',
    ),
    5 => 
    array (
      'lat' => -0.5200262,
      'lon' => 117.126161,
      'jalan' => 'Perumahan Sumalindo',
    ),
    6 => 
    array (
      'lat' => -0.518895,
      'lon' => 117.1286085,
      'jalan' => 'Reel 14',
    ),
  ),
  44483 => 
  array (
    0 => 
    array (
      'lat' => -0.5110177,
      'lon' => 117.1385315,
      'jalan' => 'Sultan Hasanuddin',
    ),
    1 => 
    array (
      'lat' => -0.5104727,
      'lon' => 117.1368022,
      'jalan' => 'Bung Tomo',
    ),
    2 => 
    array (
      'lat' => -0.5093646,
      'lon' => 117.1368006,
      'jalan' => 'PU',
    ),
    3 => 
    array (
      'lat' => -0.5091511,
      'lon' => 117.1355001,
      'jalan' => 'Padat Karya',
    ),
    4 => 
    array (
      'lat' => -0.5097764,
      'lon' => 117.1392228,
      'jalan' => 'Jalan Sutra Murni',
    ),
    5 => 
    array (
      'lat' => -0.5129757,
      'lon' => 117.1408774,
      'jalan' => 'Tirta Mahakam',
    ),
    6 => 
    array (
      'lat' => -0.5115884,
      'lon' => 117.1411067,
      'jalan' => 'La Maddu Kelleng',
    ),
  ),
  44484 => 
  array (
    0 => 
    array (
      'lat' => -0.4813012,
      'lon' => 117.1404899,
      'jalan' => 'Jalan Anggur',
    ),
    1 => 
    array (
      'lat' => -0.4827208,
      'lon' => 117.1402793,
      'jalan' => 'Jalan Ontel',
    ),
    2 => 
    array (
      'lat' => -0.4793239,
      'lon' => 117.1413562,
      'jalan' => 'Jalan Delima Dalam Blok E',
    ),
    3 => 
    array (
      'lat' => -0.4799917,
      'lon' => 117.1394679,
      'jalan' => 'Perumahan Griya Anggur',
    ),
    4 => 
    array (
      'lat' => -0.4788422,
      'lon' => 117.1397877,
      'jalan' => 'Delima Dalam',
    ),
    5 => 
    array (
      'lat' => -0.4782625,
      'lon' => 117.141667,
      'jalan' => 'Jalan Sawo',
    ),
    6 => 
    array (
      'lat' => -0.4834007,
      'lon' => 117.1411188,
      'jalan' => 'Jalan Wiratirta',
    ),
  ),
  44485 => 
  array (
    0 => 
    array (
      'lat' => -0.4936786,
      'lon' => 117.132639,
      'jalan' => 'Jalan Raudah',
    ),
    1 => 
    array (
      'lat' => -0.491442,
      'lon' => 117.1334145,
      'jalan' => 'Jalan Haji Muhammad Basoe',
    ),
    2 => 
    array (
      'lat' => -0.4950981,
      'lon' => 117.1324479,
      'jalan' => 'Jalan Raudah 5',
    ),
    3 => 
    array (
      'lat' => -0.4948829,
      'lon' => 117.1348451,
      'jalan' => 'Jalan Siti Aisyah',
    ),
    4 => 
    array (
      'lat' => -0.4928167,
      'lon' => 117.1312412,
      'jalan' => 'Jalan Pangeran Antasari II',
    ),
    5 => 
    array (
      'lat' => -0.4960427,
      'lon' => 117.131861,
      'jalan' => 'Jalan Raudah IV',
    ),
    6 => 
    array (
      'lat' => -0.4917304,
      'lon' => 117.1346281,
      'jalan' => 'Jalan Siraj Salman',
    ),
  ),
  44486 => 
  array (
    0 => 
    array (
      'lat' => -0.4706003,
      'lon' => 117.1086205,
      'jalan' => 'Jalan Rejang Raya',
    ),
    1 => 
    array (
      'lat' => -0.4705856,
      'lon' => 117.1133244,
      'jalan' => 'Jalan Ringroad (Nusyirwan Ismail)',
    ),
    2 => 
    array (
      'lat' => -0.4620189,
      'lon' => 117.1153615,
      'jalan' => 'Jalan Pangeran Suryanata',
    ),
    3 => 
    array (
      'lat' => -0.4711598,
      'lon' => 117.1095609,
      'jalan' => 'Jalan Rejang Raya',
    ),
    4 => 
    array (
      'lat' => -0.472162,
      'lon' => 117.1117473,
      'jalan' => 'Jalan Ringroad (Nusyirwan Ismail)',
    ),
    5 => 
    array (
      'lat' => -0.4696287,
      'lon' => 117.1142344,
      'jalan' => 'Jalan Ringroad (Nusyirwan Ismail)',
    ),
    6 => 
    array (
      'lat' => -0.4746745,
      'lon' => 117.1103813,
      'jalan' => 'Jalan Ringroad (Nusyirwan Ismail)',
    ),
  ),
  44487 => 
  array (
    0 => 
    array (
      'lat' => -0.4670626,
      'lon' => 117.1348438,
      'jalan' => 'Jalan Polder 1',
    ),
    1 => 
    array (
      'lat' => -0.4680967,
      'lon' => 117.1344996,
      'jalan' => 'Jalan Polder Air Hitam',
    ),
    2 => 
    array (
      'lat' => -0.4671994,
      'lon' => 117.1336696,
      'jalan' => 'Jalan Polder 2',
    ),
    3 => 
    array (
      'lat' => -0.4659201,
      'lon' => 117.1324593,
      'jalan' => 'Perumahan PWI Blok D',
    ),
    4 => 
    array (
      'lat' => -0.4661963,
      'lon' => 117.1314145,
      'jalan' => 'Perumahan PWI Blok C',
    ),
    5 => 
    array (
      'lat' => -0.4648942,
      'lon' => 117.137762,
      'jalan' => 'Jalan Abdul Wahab Syahranie',
    ),
    6 => 
    array (
      'lat' => -0.4666959,
      'lon' => 117.1303372,
      'jalan' => 'Perumahan PWI Blok A',
    ),
  ),
  44488 => 
  array (
    0 => 
    array (
      'lat' => -0.483496,
      'lon' => 117.1271981,
      'jalan' => 'Jalan Anggrek Hitam 1',
    ),
    1 => 
    array (
      'lat' => -0.4824486,
      'lon' => 117.1265571,
      'jalan' => 'Jalan Pangeran Suryanata',
    ),
    2 => 
    array (
      'lat' => -0.482541,
      'lon' => 117.1247798,
      'jalan' => 'Jalan Graha Wiratama',
    ),
    3 => 
    array (
      'lat' => -0.4845263,
      'lon' => 117.1266179,
      'jalan' => 'Jalan M.T. Haryono',
    ),
    4 => 
    array (
      'lat' => -0.4828295,
      'lon' => 117.1280926,
      'jalan' => 'Jalan Anggrek Hitam 2',
    ),
    5 => 
    array (
      'lat' => -0.4841145,
      'lon' => 117.1251517,
      'jalan' => 'Jalan Rawasari 5 Blok A',
    ),
    6 => 
    array (
      'lat' => -0.4828468,
      'lon' => 117.1291783,
      'jalan' => 'Jalan Anggrek Bulan',
    ),
  ),
  44489 => 
  array (
    0 => 
    array (
      'lat' => -0.4880713,
      'lon' => 117.1449057,
      'jalan' => 'Jalan Wolter Monginsidi',
    ),
    1 => 
    array (
      'lat' => -0.4900752,
      'lon' => 117.1455914,
      'jalan' => 'Jalan Bhayangkara',
    ),
    2 => 
    array (
      'lat' => -0.4892842,
      'lon' => 117.1463387,
      'jalan' => 'Jalan Pahlawan',
    ),
    3 => 
    array (
      'lat' => -0.4888374,
      'lon' => 117.1475078,
      'jalan' => 'Jalan Harmonika',
    ),
    4 => 
    array (
      'lat' => -0.4901227,
      'lon' => 117.147128,
      'jalan' => 'Jalan Kesuma Bangsa',
    ),
    5 => 
    array (
      'lat' => -0.4890637,
      'lon' => 117.1412313,
      'jalan' => 'Jalan Wahidin Sudiro Husodo',
    ),
    6 => 
    array (
      'lat' => -0.4855016,
      'lon' => 117.1460627,
      'jalan' => 'Pahlawan 3',
    ),
  ),
  44490 => 
  array (
    0 => 
    array (
      'lat' => -0.4689151,
      'lon' => 117.1462516,
      'jalan' => 'Limau',
    ),
    1 => 
    array (
      'lat' => -0.4687111,
      'lon' => 117.1480663,
      'jalan' => 'Jalan Mohammad Yamin',
    ),
    2 => 
    array (
      'lat' => -0.4675116,
      'lon' => 117.1461211,
      'jalan' => 'Jalan Suwandi 5',
    ),
    3 => 
    array (
      'lat' => -0.4662352,
      'lon' => 117.1468758,
      'jalan' => 'Jalan Haji Suwandi',
    ),
    4 => 
    array (
      'lat' => -0.4713237,
      'lon' => 117.1454897,
      'jalan' => 'Jalan Kedondong',
    ),
    5 => 
    array (
      'lat' => -0.4701925,
      'lon' => 117.1465188,
      'jalan' => 'Rambai',
    ),
    6 => 
    array (
      'lat' => -0.4652092,
      'lon' => 117.146408,
      'jalan' => 'Jalan Suwandi 3',
    ),
  ),
  44491 => 
  array (
    0 => 
    array (
      'lat' => -0.4972458,
      'lon' => 117.1362908,
      'jalan' => 'Jalan Pasundan',
    ),
    1 => 
    array (
      'lat' => -0.4989452,
      'lon' => 117.1368617,
      'jalan' => 'Gunung Merbabu',
    ),
    2 => 
    array (
      'lat' => -0.4986505,
      'lon' => 117.13568,
      'jalan' => 'Jalan Gunung Cermai',
    ),
    3 => 
    array (
      'lat' => -0.4978773,
      'lon' => 117.1392962,
      'jalan' => 'Bukit Barisan',
    ),
    4 => 
    array (
      'lat' => -0.4990563,
      'lon' => 117.1391101,
      'jalan' => 'Gunung Semeru',
    ),
    5 => 
    array (
      'lat' => -0.4991541,
      'lon' => 117.1402987,
      'jalan' => 'Gunung Arjuna',
    ),
    6 => 
    array (
      'lat' => -0.5005728,
      'lon' => 117.1387272,
      'jalan' => 'Jenderal Sudirman',
    ),
  ),
  44492 => 
  array (
    0 => 
    array (
      'lat' => -0.436564,
      'lon' => 117.2190443,
      'jalan' => 'Jalan Girimukti',
    ),
    1 => 
    array (
      'lat' => -0.4366947,
      'lon' => 117.2202441,
      'jalan' => 'Jalan Girimulyo',
    ),
    2 => 
    array (
      'lat' => -0.4380287,
      'lon' => 117.2190681,
      'jalan' => 'Jalan Merapi',
    ),
    3 => 
    array (
      'lat' => -0.4379828,
      'lon' => 117.2172127,
      'jalan' => 'Jalan Merbabu',
    ),
    4 => 
    array (
      'lat' => -0.4353714,
      'lon' => 117.2199009,
      'jalan' => 'Jalan Citanduy',
    ),
    5 => 
    array (
      'lat' => -0.4343718,
      'lon' => 117.2191168,
      'jalan' => 'Jalan Serayu',
    ),
    6 => 
    array (
      'lat' => -0.4381137,
      'lon' => 117.2215528,
      'jalan' => 'Jalan Ternak',
    ),
  ),
  44493 => 
  array (
    0 => 
    array (
      'lat' => -0.4579475,
      'lon' => 117.1550783,
      'jalan' => 'Erry Suparjan',
    ),
    1 => 
    array (
      'lat' => -0.4591843,
      'lon' => 117.155026,
      'jalan' => 'Alam Segar 4',
    ),
    2 => 
    array (
      'lat' => -0.4584651,
      'lon' => 117.1532083,
      'jalan' => 'Jalan Ery Suparjan',
    ),
    3 => 
    array (
      'lat' => -0.4559769,
      'lon' => 117.1523896,
      'jalan' => 'Jalan K.H. Wahid Hasyim I',
    ),
    4 => 
    array (
      'lat' => -0.4590364,
      'lon' => 117.152178,
      'jalan' => 'Jalan TVRI',
    ),
    5 => 
    array (
      'lat' => -0.4547307,
      'lon' => 117.1529744,
      'jalan' => 'Jalan Kenyah',
    ),
    6 => 
    array (
      'lat' => -0.4600542,
      'lon' => 117.1543213,
      'jalan' => 'Jalan Gangsar Raya',
    ),
  ),
  44494 => 
  array (
    0 => 
    array (
      'lat' => -0.3941529,
      'lon' => 117.1704711,
      'jalan' => 'Jalan Padat Karya',
    ),
    1 => 
    array (
      'lat' => -0.3945418,
      'lon' => 117.1715324,
      'jalan' => 'Jalan Mulawarman',
    ),
    2 => 
    array (
      'lat' => -0.393068,
      'lon' => 117.1705064,
      'jalan' => 'Jalan Haji Maksum',
    ),
    3 => 
    array (
      'lat' => -0.3935883,
      'lon' => 117.1722586,
      'jalan' => 'Jalan Muang Ilir',
    ),
    4 => 
    array (
      'lat' => -0.3924545,
      'lon' => 117.1716993,
      'jalan' => 'Jalan Teluk Kedondong',
    ),
    5 => 
    array (
      'lat' => -0.3970117,
      'lon' => 117.1711837,
      'jalan' => 'Jalan Mansostra I',
    ),
    6 => 
    array (
      'lat' => -0.3936432,
      'lon' => 117.1736499,
      'jalan' => 'Jalan Majelis',
    ),
  ),
  44495 => 
  array (
    0 => 
    array (
      'lat' => -0.3949146,
      'lon' => 117.2492936,
      'jalan' => 'Jalan Kurnia Jaya',
    ),
    1 => 
    array (
      'lat' => -0.4014261,
      'lon' => 117.2427711,
      'jalan' => 'Jalan Bukit Seribu',
    ),
    2 => 
    array (
      'lat' => -0.3985752,
      'lon' => 117.2412386,
      'jalan' => 'Jalan Pampang Muara',
    ),
    3 => 
    array (
      'lat' => -0.3731148,
      'lon' => 117.2595558,
      'jalan' => 'Jalan Bandara',
    ),
    4 => 
    array (
      'lat' => -0.3934676,
      'lon' => 117.2488578,
      'jalan' => 'Jalan Kurnia Jaya',
    ),
    5 => 
    array (
      'lat' => -0.4029431,
      'lon' => 117.2426868,
      'jalan' => 'Jalan Bukit Seribu',
    ),
    6 => 
    array (
      'lat' => -0.3946263,
      'lon' => 117.240266,
      'jalan' => 'Jalan Pampang Muara',
    ),
  ),
  44496 => 
  array (
    0 => 
    array (
      'lat' => -0.417976,
      'lon' => 117.1827794,
      'jalan' => 'Jalan Belimau',
    ),
    1 => 
    array (
      'lat' => -0.4171866,
      'lon' => 117.182025,
      'jalan' => 'Jalan Betapus',
    ),
    2 => 
    array (
      'lat' => -0.4166788,
      'lon' => 117.1830652,
      'jalan' => 'Jalan Girirejo',
    ),
    3 => 
    array (
      'lat' => -0.4169846,
      'lon' => 117.1841441,
      'jalan' => 'Jalan Tagur 1',
    ),
    4 => 
    array (
      'lat' => -0.4189106,
      'lon' => 117.1845557,
      'jalan' => 'Giri Makmur',
    ),
    5 => 
    array (
      'lat' => -0.4169013,
      'lon' => 117.1854223,
      'jalan' => 'Jalan Tagur 2',
    ),
    6 => 
    array (
      'lat' => -0.421745,
      'lon' => 117.1850271,
      'jalan' => 'Bukit Belimau Asri',
    ),
  ),
  44497 => 
  array (
    0 => 
    array (
      'lat' => -0.5391119,
      'lon' => 117.2272559,
      'jalan' => 'Kelurahan',
    ),
    1 => 
    array (
      'lat' => -0.5382967,
      'lon' => 117.2263002,
      'jalan' => 'Jalan Sultan Sulaiman',
    ),
    2 => 
    array (
      'lat' => -0.5393974,
      'lon' => 117.2283026,
      'jalan' => 'Jalan Provinsi',
    ),
    3 => 
    array (
      'lat' => -0.5373936,
      'lon' => 117.223396,
      'jalan' => 'Jalan Sukorejo',
    ),
    4 => 
    array (
      'lat' => -0.5335184,
      'lon' => 117.2234839,
      'jalan' => 'Jalan Lupa Namanya',
    ),
    5 => 
    array (
      'lat' => -0.5554513,
      'lon' => 117.2187553,
      'jalan' => 'Jalan Tri Darma',
    ),
    6 => 
    array (
      'lat' => -0.5540469,
      'lon' => 117.224059,
      'jalan' => 'Jalan Mawar',
    ),
  ),
  44498 => 
  array (
    0 => 
    array (
      'lat' => -0.5055281,
      'lon' => 117.1938148,
      'jalan' => 'Jalan Kapten Soedjono AJ',
    ),
    1 => 
    array (
      'lat' => -0.5004528,
      'lon' => 117.1959441,
      'jalan' => 'Jalan Bendungan',
    ),
    2 => 
    array (
      'lat' => -0.5016007,
      'lon' => 117.1911672,
      'jalan' => 'Jalan Handil Kopi',
    ),
    3 => 
    array (
      'lat' => -0.5044915,
      'lon' => 117.1894442,
      'jalan' => 'Jalan Pelita 4',
    ),
    4 => 
    array (
      'lat' => -0.5099757,
      'lon' => 117.2015443,
      'jalan' => 'Jalan Pelita 6',
    ),
    5 => 
    array (
      'lat' => -0.4977524,
      'lon' => 117.1949548,
      'jalan' => 'Jalan Keluarga',
    ),
    6 => 
    array (
      'lat' => -0.5022949,
      'lon' => 117.1871514,
      'jalan' => 'Jalan Bumi Sambutan Asri',
    ),
  ),
  44499 => 
  array (
    0 => 
    array (
      'lat' => -0.5594254,
      'lon' => 117.2330619,
      'jalan' => 'Jalan Masaji',
    ),
    1 => 
    array (
      'lat' => -0.5580507,
      'lon' => 117.2312744,
      'jalan' => 'Jalan Karya Bakti',
    ),
    2 => 
    array (
      'lat' => -0.5562747,
      'lon' => 117.2332782,
      'jalan' => 'Jalan Pasundan',
    ),
    3 => 
    array (
      'lat' => -0.5561965,
      'lon' => 117.2313689,
      'jalan' => 'Jalan Tri Bakti',
    ),
    4 => 
    array (
      'lat' => -0.5608513,
      'lon' => 117.2348936,
      'jalan' => 'Jalan Dahlia',
    ),
    5 => 
    array (
      'lat' => -0.5621226,
      'lon' => 117.2311308,
      'jalan' => 'Jalan Provinsi',
    ),
    6 => 
    array (
      'lat' => -0.559389,
      'lon' => 117.2317813,
      'jalan' => 'Jalan Masaji',
    ),
  ),
  44500 => 
  array (
    0 => 
    array (
      'lat' => -0.5527355,
      'lon' => 117.1967675,
      'jalan' => 'Jalan Olah Bebaya',
    ),
    1 => 
    array (
      'lat' => -0.5460055,
      'lon' => 117.2034791,
      'jalan' => 'Jalan Tambang',
    ),
    2 => 
    array (
      'lat' => -0.5350892,
      'lon' => 117.1976792,
      'jalan' => 'Jalan Telkom',
    ),
    3 => 
    array (
      'lat' => -0.5593988,
      'lon' => 117.213638,
      'jalan' => 'Olah Bebaya',
    ),
    4 => 
    array (
      'lat' => -0.551459,
      'lon' => 117.2182846,
      'jalan' => 'Jalan Tri Darma',
    ),
    5 => 
    array (
      'lat' => -0.5547888,
      'lon' => 117.2187602,
      'jalan' => 'Jalan Mawar',
    ),
    6 => 
    array (
      'lat' => -0.5585858,
      'lon' => 117.2200164,
      'jalan' => 'Jalan SMP 32',
    ),
  ),
  44501 => 
  array (
    0 => 
    array (
      'lat' => -0.5372602,
      'lon' => 117.1758154,
      'jalan' => 'Jalan Kehewanan',
    ),
    1 => 
    array (
      'lat' => -0.5361395,
      'lon' => 117.1758043,
      'jalan' => 'Jalan Tatako',
    ),
    2 => 
    array (
      'lat' => -0.5387345,
      'lon' => 117.173298,
      'jalan' => 'Jalan H.M. Saleh Arsyad',
    ),
    3 => 
    array (
      'lat' => -0.5402391,
      'lon' => 117.1791348,
      'jalan' => 'Jalan Kehewanan II',
    ),
    4 => 
    array (
      'lat' => -0.5314118,
      'lon' => 117.1717287,
      'jalan' => 'Jalan Baru Lestari',
    ),
    5 => 
    array (
      'lat' => -0.5355354,
      'lon' => 117.1685309,
      'jalan' => 'Jalan Sungai Kapih',
    ),
    6 => 
    array (
      'lat' => -0.5335427,
      'lon' => 117.1691116,
      'jalan' => 'Jalan Manggis',
    ),
  ),
  44502 => 
  array (
    0 => 
    array (
      'lat' => -0.5531621,
      'lon' => 117.0741695,
      'jalan' => 'Sendawar',
    ),
    1 => 
    array (
      'lat' => -0.5550949,
      'lon' => 117.0730393,
      'jalan' => 'Flamboyan',
    ),
    2 => 
    array (
      'lat' => -0.5558166,
      'lon' => 117.0769283,
      'jalan' => 'Teratai',
    ),
    3 => 
    array (
      'lat' => -0.5523899,
      'lon' => 117.0681572,
      'jalan' => 'Jalan Lobang Tiga',
    ),
    4 => 
    array (
      'lat' => -0.5552337,
      'lon' => 117.0786136,
      'jalan' => 'Jembatan Mahakam Ulu',
    ),
    5 => 
    array (
      'lat' => -0.5571481,
      'lon' => 117.0788241,
      'jalan' => 'Ekonomi',
    ),
    6 => 
    array (
      'lat' => -0.5514454,
      'lon' => 117.0648548,
      'jalan' => 'Jl. Gunung Intan',
    ),
  ),
  44503 => 
  array (
    0 => 
    array (
      'lat' => -0.4980615,
      'lon' => 117.1261437,
      'jalan' => 'Jalan Cendana',
    ),
    1 => 
    array (
      'lat' => -0.4981075,
      'lon' => 117.127261,
      'jalan' => 'Jalan Nusa Indah',
    ),
    2 => 
    array (
      'lat' => -0.4970683,
      'lon' => 117.1256921,
      'jalan' => 'Jalan Cendana Gang 3',
    ),
    3 => 
    array (
      'lat' => -0.4972797,
      'lon' => 117.1244016,
      'jalan' => 'Banggeris',
    ),
    4 => 
    array (
      'lat' => -0.4991882,
      'lon' => 117.1236399,
      'jalan' => 'Jalan Manunggal Gang 6',
    ),
    5 => 
    array (
      'lat' => -0.494433,
      'lon' => 117.1270666,
      'jalan' => 'Jalan Pondok Wira 1',
    ),
    6 => 
    array (
      'lat' => -0.4938194,
      'lon' => 117.1257225,
      'jalan' => 'Jalan Pondok Wira 2',
    ),
  ),
  44504 => 
  array (
    0 => 
    array (
      'lat' => -0.5106392,
      'lon' => 117.1154336,
      'jalan' => 'Jalan Budiman',
    ),
    1 => 
    array (
      'lat' => -0.508775,
      'lon' => 117.1176082,
      'jalan' => 'Jalan Ulin',
    ),
    2 => 
    array (
      'lat' => -0.5130809,
      'lon' => 117.1124527,
      'jalan' => 'Jalan Adam Malik',
    ),
    3 => 
    array (
      'lat' => -0.5143275,
      'lon' => 117.1140788,
      'jalan' => 'Jalan Adam Malik 2',
    ),
    4 => 
    array (
      'lat' => -0.508272,
      'lon' => 117.1084615,
      'jalan' => 'Jalan Teuku Umar',
    ),
    5 => 
    array (
      'lat' => -0.5064712,
      'lon' => 117.1090295,
      'jalan' => 'Jalan Suroboyo',
    ),
    6 => 
    array (
      'lat' => -0.5040334,
      'lon' => 117.1084319,
      'jalan' => 'Jalan Rapak Indah',
    ),
  ),
  44505 => 
  array (
    0 => 
    array (
      'lat' => -0.5181047,
      'lon' => 117.1121627,
      'jalan' => 'Jalan Adam Malik 2',
    ),
    1 => 
    array (
      'lat' => -0.5208334,
      'lon' => 117.1115747,
      'jalan' => 'Jalan Insinyur Sutami',
    ),
    2 => 
    array (
      'lat' => -0.5214186,
      'lon' => 117.1137077,
      'jalan' => 'Jalan Kemangi',
    ),
    3 => 
    array (
      'lat' => -0.519346,
      'lon' => 117.1163437,
      'jalan' => 'Jalan Untung Suropati',
    ),
    4 => 
    array (
      'lat' => -0.5170836,
      'lon' => 117.1074398,
      'jalan' => 'Jalan Teuku Umar',
    ),
    5 => 
    array (
      'lat' => -0.5195636,
      'lon' => 117.1064834,
      'jalan' => 'Gunung Tunggal',
    ),
    6 => 
    array (
      'lat' => -0.5229418,
      'lon' => 117.1080124,
      'jalan' => 'Jalan Latsitarda 1',
    ),
  ),
  44506 => 
  array (
    0 => 
    array (
      'lat' => -0.5279924,
      'lon' => 117.0970303,
      'jalan' => 'Jalan Gunung Tunggal',
    ),
    1 => 
    array (
      'lat' => -0.5300555,
      'lon' => 117.0950488,
      'jalan' => 'Jalan Swadaya',
    ),
    2 => 
    array (
      'lat' => -0.5274385,
      'lon' => 117.0920553,
      'jalan' => 'Jalan Jakarta',
    ),
    3 => 
    array (
      'lat' => -0.5319806,
      'lon' => 117.0946469,
      'jalan' => 'Kemuning',
    ),
    4 => 
    array (
      'lat' => -0.5297475,
      'lon' => 117.0915382,
      'jalan' => 'Bloki AC',
    ),
    5 => 
    array (
      'lat' => -0.5232917,
      'lon' => 117.0979312,
      'jalan' => 'Adam Usin',
    ),
    6 => 
    array (
      'lat' => -0.5315814,
      'lon' => 117.0915636,
      'jalan' => 'Jalan Padat Karya',
    ),
  ),
  44507 => 
  array (
    0 => 
    array (
      'lat' => -0.5002082,
      'lon' => 117.1149679,
      'jalan' => 'Jalan Toros 3',
    ),
    1 => 
    array (
      'lat' => -0.4993126,
      'lon' => 117.1155819,
      'jalan' => 'Jalan Kelapa Gading 7',
    ),
    2 => 
    array (
      'lat' => -0.5013762,
      'lon' => 117.1149337,
      'jalan' => 'Jalan Kelapa Gading',
    ),
    3 => 
    array (
      'lat' => -0.5006574,
      'lon' => 117.1165873,
      'jalan' => 'Jalan Kelapa Gading Gang 5',
    ),
    4 => 
    array (
      'lat' => -0.4981604,
      'lon' => 117.1155681,
      'jalan' => 'Jalan Kelapa Gading 12',
    ),
    5 => 
    array (
      'lat' => -0.4994553,
      'lon' => 117.1167864,
      'jalan' => 'Jalan Kelapa Gading 9',
    ),
    6 => 
    array (
      'lat' => -0.5011825,
      'lon' => 117.1136481,
      'jalan' => 'Jalan Tengkawang',
    ),
  ),
  44508 => 
  array (
    0 => 
    array (
      'lat' => -0.4983522,
      'lon' => 117.0948037,
      'jalan' => 'Jalan Taqwa',
    ),
    1 => 
    array (
      'lat' => -0.4960461,
      'lon' => 117.0974337,
      'jalan' => 'Jalan Revolusi 1',
    ),
    2 => 
    array (
      'lat' => -0.4958632,
      'lon' => 117.094329,
      'jalan' => 'Jalan Mohammad Said',
    ),
    3 => 
    array (
      'lat' => -0.4956848,
      'lon' => 117.100022,
      'jalan' => 'Jalan Pesantren',
    ),
    4 => 
    array (
      'lat' => -0.4944739,
      'lon' => 117.1005289,
      'jalan' => 'Jalan Revolusi 2',
    ),
    5 => 
    array (
      'lat' => -0.501898,
      'lon' => 117.0975799,
      'jalan' => 'Jalan Martapura',
    ),
    6 => 
    array (
      'lat' => -0.5025001,
      'lon' => 117.0947072,
      'jalan' => 'Rapak Indah 3',
    ),
  ),
  44509 => 
  array (
    0 => 
    array (
      'lat' => -0.4722386,
      'lon' => 117.162924,
      'jalan' => 'Jalan Gelatik 1',
    ),
    1 => 
    array (
      'lat' => -0.471127,
      'lon' => 117.1627713,
      'jalan' => 'Jalan Pondok Gelatik Dalam',
    ),
    2 => 
    array (
      'lat' => -0.4717619,
      'lon' => 117.1646857,
      'jalan' => 'Jalan Pemuda II',
    ),
    3 => 
    array (
      'lat' => -0.4733745,
      'lon' => 117.162869,
      'jalan' => 'Jalan Pemuda 1',
    ),
    4 => 
    array (
      'lat' => -0.4729101,
      'lon' => 117.1644907,
      'jalan' => 'Jalan Pemuda 2',
    ),
    5 => 
    array (
      'lat' => -0.4707501,
      'lon' => 117.1654459,
      'jalan' => 'Jalan Kesehatan Dalam',
    ),
    6 => 
    array (
      'lat' => -0.471372,
      'lon' => 117.1616122,
      'jalan' => 'Jalan Gelatik II',
    ),
  ),
  44510 => 
  array (
    0 => 
    array (
      'lat' => -0.4480972,
      'lon' => 117.1761687,
      'jalan' => 'Jalan Gunung Lingai',
    ),
    1 => 
    array (
      'lat' => -0.4495081,
      'lon' => 117.176253,
      'jalan' => 'Jalan Cluster Etam',
    ),
    2 => 
    array (
      'lat' => -0.4480336,
      'lon' => 117.1715344,
      'jalan' => 'Jalan Pipit Raya',
    ),
    3 => 
    array (
      'lat' => -0.4395655,
      'lon' => 117.1770073,
      'jalan' => 'Cluster A/B',
    ),
    4 => 
    array (
      'lat' => -0.4422704,
      'lon' => 117.183904,
      'jalan' => 'Jalan Perumahan Grha Mandiri 2',
    ),
    5 => 
    array (
      'lat' => -0.4556824,
      'lon' => 117.1822758,
      'jalan' => 'Citraland City',
    ),
    6 => 
    array (
      'lat' => -0.4383682,
      'lon' => 117.1705495,
      'jalan' => 'Jalan Lempake Tepian',
    ),
  ),
  44511 => 
  array (
    0 => 
    array (
      'lat' => -0.4789726,
      'lon' => 117.2053845,
      'jalan' => 'Jalan Mugirejo',
    ),
    1 => 
    array (
      'lat' => -0.4783745,
      'lon' => 117.2067538,
      'jalan' => 'Jalan Assa\'adah',
    ),
    2 => 
    array (
      'lat' => -0.4801285,
      'lon' => 117.2054489,
      'jalan' => 'Jalan H.S. Abdurahman',
    ),
    3 => 
    array (
      'lat' => -0.4796925,
      'lon' => 117.2068321,
      'jalan' => 'Jalan Mardiansjah Marhad',
    ),
    4 => 
    array (
      'lat' => -0.4756414,
      'lon' => 117.2019768,
      'jalan' => 'Jalan Lubuk Sawa',
    ),
    5 => 
    array (
      'lat' => -0.4839867,
      'lon' => 117.2101439,
      'jalan' => 'Permata 2',
    ),
    6 => 
    array (
      'lat' => -0.4827865,
      'lon' => 117.2121558,
      'jalan' => 'Jalan Perumahan Bukit Mulya 3',
    ),
  ),
  44512 => 
  array (
    0 => 
    array (
      'lat' => -0.4825531,
      'lon' => 117.1535866,
      'jalan' => 'Tantina',
    ),
    1 => 
    array (
      'lat' => -0.481473,
      'lon' => 117.1530224,
      'jalan' => 'Tantina 4',
    ),
    2 => 
    array (
      'lat' => -0.4832809,
      'lon' => 117.1544902,
      'jalan' => 'Jalan Gatot Subroto',
    ),
    3 => 
    array (
      'lat' => -0.4824443,
      'lon' => 117.1524693,
      'jalan' => 'Tantina 2',
    ),
    4 => 
    array (
      'lat' => -0.4820749,
      'lon' => 117.1546402,
      'jalan' => 'Jalan Serindit 1',
    ),
    5 => 
    array (
      'lat' => -0.480509,
      'lon' => 117.153788,
      'jalan' => 'Serindit 2',
    ),
    6 => 
    array (
      'lat' => -0.4809563,
      'lon' => 117.152012,
      'jalan' => 'Jalan Komplek Mekar Indah',
    ),
  ),
  44513 => 
  array (
    0 => 
    array (
      'lat' => -0.4812081,
      'lon' => 117.17354,
      'jalan' => 'Jalan Proklamasi 2',
    ),
    1 => 
    array (
      'lat' => -0.4823467,
      'lon' => 117.1728989,
      'jalan' => 'Jalan Proklamasi I',
    ),
    2 => 
    array (
      'lat' => -0.4824782,
      'lon' => 117.1762673,
      'jalan' => 'Jalan KH. Damanhuri 1',
    ),
    3 => 
    array (
      'lat' => -0.4840104,
      'lon' => 117.1741319,
      'jalan' => 'Jalan Gerilya',
    ),
    4 => 
    array (
      'lat' => -0.4867152,
      'lon' => 117.1768693,
      'jalan' => 'Jalan Perjuangan',
    ),
    5 => 
    array (
      'lat' => -0.4798067,
      'lon' => 117.1722794,
      'jalan' => 'Jalan Sentosa Dalam 3',
    ),
    6 => 
    array (
      'lat' => -0.482327,
      'lon' => 117.1776093,
      'jalan' => 'Jalan Damanhuri',
    ),
  ),
  44514 => 
  array (
    0 => 
    array (
      'lat' => -0.4606773,
      'lon' => 117.1947827,
      'jalan' => 'Jalan Meranti Talang Sari',
    ),
    1 => 
    array (
      'lat' => -0.464811,
      'lon' => 117.1907839,
      'jalan' => 'Jalan Mugirejo',
    ),
    2 => 
    array (
      'lat' => -0.457559,
      'lon' => 117.2002694,
      'jalan' => 'Jalan Assa\'adah',
    ),
    3 => 
    array (
      'lat' => -0.4599297,
      'lon' => 117.1875401,
      'jalan' => 'Citraland City',
    ),
    4 => 
    array (
      'lat' => -0.4532034,
      'lon' => 117.1912908,
      'jalan' => 'Jalan Poros Kebon Agung',
    ),
    5 => 
    array (
      'lat' => -0.4623864,
      'lon' => 117.186591,
      'jalan' => 'Jalan Perumahan Mugirejo',
    ),
    6 => 
    array (
      'lat' => -0.4662013,
      'lon' => 117.1877656,
      'jalan' => 'Jalan Perintis',
    ),
  ),
  44515 => 
  array (
    0 => 
    array (
      'lat' => -0.4599884,
      'lon' => 117.1780342,
      'jalan' => 'Jalan Haji Achmad Amins',
    ),
    1 => 
    array (
      'lat' => -0.4601005,
      'lon' => 117.1761035,
      'jalan' => 'Jalan Tridarma',
    ),
    2 => 
    array (
      'lat' => -0.4598991,
      'lon' => 117.1750117,
      'jalan' => 'Jalan Gunung Lingai',
    ),
    3 => 
    array (
      'lat' => -0.4617427,
      'lon' => 117.1782794,
      'jalan' => 'Jalan Perumahan',
    ),
    4 => 
    array (
      'lat' => -0.4621383,
      'lon' => 117.17676,
      'jalan' => 'Jalan Pondok Shangrila',
    ),
    5 => 
    array (
      'lat' => -0.4631132,
      'lon' => 117.1760626,
      'jalan' => 'Jalan Bukit Alaya',
    ),
    6 => 
    array (
      'lat' => -0.4616514,
      'lon' => 117.1744875,
      'jalan' => 'Jalan D.I. Pandjaitan',
    ),
  ),
  44516 => 
  array (
    0 => 
    array (
      'lat' => -0.4710892,
      'lon' => 117.1885321,
      'jalan' => 'Jalan Bhineka',
    ),
    1 => 
    array (
      'lat' => -0.46998,
      'lon' => 117.1888951,
      'jalan' => 'Jalan Perintis',
    ),
    2 => 
    array (
      'lat' => -0.4767431,
      'lon' => 117.1886668,
      'jalan' => 'Jalan Damanhuri 2',
    ),
    3 => 
    array (
      'lat' => -0.4731993,
      'lon' => 117.1938349,
      'jalan' => 'Jalan Mugirejo',
    ),
    4 => 
    array (
      'lat' => -0.4772882,
      'lon' => 117.1896359,
      'jalan' => 'Jalan SKM 1',
    ),
    5 => 
    array (
      'lat' => -0.4735654,
      'lon' => 117.1858205,
      'jalan' => 'Jalan Bhinneka 10',
    ),
    6 => 
    array (
      'lat' => -0.4685876,
      'lon' => 117.1878572,
      'jalan' => 'Jalan Raylia',
    ),
  ),
  44517 => 
  array (
    0 => 
    array (
      'lat' => -0.4714737,
      'lon' => 117.1787734,
      'jalan' => 'Lorong Borneo 5',
    ),
    1 => 
    array (
      'lat' => -0.4711717,
      'lon' => 117.1803609,
      'jalan' => 'Jalan Damanhuri',
    ),
    2 => 
    array (
      'lat' => -0.4737784,
      'lon' => 117.1809462,
      'jalan' => 'Jalan Damanhuri 2',
    ),
    3 => 
    array (
      'lat' => -0.4679796,
      'lon' => 117.1783784,
      'jalan' => 'Jalan Banyan 1',
    ),
    4 => 
    array (
      'lat' => -0.4749548,
      'lon' => 117.1810676,
      'jalan' => 'Jalan Perintis',
    ),
    5 => 
    array (
      'lat' => -0.4675508,
      'lon' => 117.1771891,
      'jalan' => 'Jalan Banyan 2',
    ),
    6 => 
    array (
      'lat' => -0.4722487,
      'lon' => 117.1744086,
      'jalan' => 'Jalan Kenangan 9',
    ),
  ),
  44518 => 
  array (
    0 => 
    array (
      'lat' => -0.4683804,
      'lon' => 117.1746509,
      'jalan' => 'Jalan Bukit Alaya',
    ),
    1 => 
    array (
      'lat' => -0.4671082,
      'lon' => 117.1771703,
      'jalan' => 'Jalan Banyan 2',
    ),
    2 => 
    array (
      'lat' => -0.4676286,
      'lon' => 117.1783425,
      'jalan' => 'Jalan Banyan 1',
    ),
    3 => 
    array (
      'lat' => -0.4722952,
      'lon' => 117.1740662,
      'jalan' => 'Jalan Kenangan 9',
    ),
    4 => 
    array (
      'lat' => -0.4673845,
      'lon' => 117.1721392,
      'jalan' => 'Jalan D.I. Pandjaitan',
    ),
    5 => 
    array (
      'lat' => -0.471063,
      'lon' => 117.1724108,
      'jalan' => 'Jalan Kenangan 9 Dalam',
    ),
    6 => 
    array (
      'lat' => -0.4710053,
      'lon' => 117.1788387,
      'jalan' => 'Lorong Borneo 4',
    ),
  ),
  44519 => 
  array (
    0 => 
    array (
      'lat' => -0.468395,
      'lon' => 117.1927534,
      'jalan' => 'Jalan Mugirejo',
    ),
    1 => 
    array (
      'lat' => -0.4608736,
      'lon' => 117.1987714,
      'jalan' => 'Jalan Meranti Talang Sari',
    ),
    2 => 
    array (
      'lat' => -0.4742118,
      'lon' => 117.2014323,
      'jalan' => 'Jalan Lubuk Sawa',
    ),
    3 => 
    array (
      'lat' => -0.4688456,
      'lon' => 117.1890881,
      'jalan' => 'Jalan Perintis',
    ),
    4 => 
    array (
      'lat' => -0.468684,
      'lon' => 117.187592,
      'jalan' => 'Jalan Raylia',
    ),
    5 => 
    array (
      'lat' => -0.4607831,
      'lon' => 117.2049934,
      'jalan' => 'Jalan Assa\'adah',
    ),
    6 => 
    array (
      'lat' => -0.4612442,
      'lon' => 117.2067078,
      'jalan' => 'Jalan PGRI VI',
    ),
  ),
  44520 => 
  array (
    0 => 
    array (
      'lat' => -0.4637274,
      'lon' => 117.1862215,
      'jalan' => 'Jalan Perumahan Mugirejo',
    ),
    1 => 
    array (
      'lat' => -0.4630133,
      'lon' => 117.1853839,
      'jalan' => 'Jalan Bugis Mugirejo',
    ),
    2 => 
    array (
      'lat' => -0.462592,
      'lon' => 117.1868885,
      'jalan' => 'Jalan Mugirejo',
    ),
    3 => 
    array (
      'lat' => -0.4655089,
      'lon' => 117.1867759,
      'jalan' => 'Jalan Perintis',
    ),
    4 => 
    array (
      'lat' => -0.4667321,
      'lon' => 117.1865246,
      'jalan' => 'Jalan Aziziyah III',
    ),
    5 => 
    array (
      'lat' => -0.4660354,
      'lon' => 117.1855,
      'jalan' => 'Jalan Aziziyah I',
    ),
    6 => 
    array (
      'lat' => -0.4613904,
      'lon' => 117.1837698,
      'jalan' => 'Jalan Perumahan Sejahtera',
    ),
  ),
  44521 => 
  array (
    0 => 
    array (
      'lat' => -0.4876613,
      'lon' => 117.1729955,
      'jalan' => 'Jalan Sepakat 10',
    ),
    1 => 
    array (
      'lat' => -0.4878436,
      'lon' => 117.1716074,
      'jalan' => 'Jalan Damai',
    ),
    2 => 
    array (
      'lat' => -0.485246,
      'lon' => 117.1754537,
      'jalan' => 'Jalan Perjuangan',
    ),
    3 => 
    array (
      'lat' => -0.4842697,
      'lon' => 117.1749049,
      'jalan' => 'Jalan Gerilya',
    ),
    4 => 
    array (
      'lat' => -0.487782,
      'lon' => 117.1692678,
      'jalan' => 'Jalan Merdeka 5',
    ),
    5 => 
    array (
      'lat' => -0.4881485,
      'lon' => 117.1679706,
      'jalan' => 'Jalan Merdeka 4',
    ),
    6 => 
    array (
      'lat' => -0.4913621,
      'lon' => 117.1721756,
      'jalan' => 'Jalan Damai 2 Ujung',
    ),
  ),
  44522 => 
  array (
    0 => 
    array (
      'lat' => -0.4591611,
      'lon' => 117.1925555,
      'jalan' => 'Jalan Meranti Talang Sari',
    ),
    1 => 
    array (
      'lat' => -0.4591216,
      'lon' => 117.1867344,
      'jalan' => 'Citraland City',
    ),
    2 => 
    array (
      'lat' => -0.4641201,
      'lon' => 117.189953,
      'jalan' => 'Jalan Mugirejo',
    ),
    3 => 
    array (
      'lat' => -0.4625865,
      'lon' => 117.1863922,
      'jalan' => 'Jalan Perumahan Mugirejo',
    ),
    4 => 
    array (
      'lat' => -0.462596,
      'lon' => 117.1852722,
      'jalan' => 'Jalan Bugis Mugirejo',
    ),
    5 => 
    array (
      'lat' => -0.4655465,
      'lon' => 117.1872561,
      'jalan' => 'Jalan Perintis',
    ),
    6 => 
    array (
      'lat' => -0.4528029,
      'lon' => 117.1913001,
      'jalan' => 'Jalan Poros Kebon Agung',
    ),
  ),
  44523 => 
  array (
    0 => 
    array (
      'lat' => -0.4626063,
      'lon' => 117.1783596,
      'jalan' => 'Jalan Perumahan',
    ),
    1 => 
    array (
      'lat' => -0.4610923,
      'lon' => 117.1781856,
      'jalan' => 'Jalan Haji Achmad Amins',
    ),
    2 => 
    array (
      'lat' => -0.4635451,
      'lon' => 117.1769683,
      'jalan' => 'Jalan Pondok Shangrila',
    ),
    3 => 
    array (
      'lat' => -0.4618111,
      'lon' => 117.1765625,
      'jalan' => 'Jalan Tridarma',
    ),
    4 => 
    array (
      'lat' => -0.4636195,
      'lon' => 117.1820781,
      'jalan' => 'Jalan Damanhuri',
    ),
    5 => 
    array (
      'lat' => -0.4638655,
      'lon' => 117.1758065,
      'jalan' => 'Jalan Bukit Alaya',
    ),
    6 => 
    array (
      'lat' => -0.4619961,
      'lon' => 117.1836136,
      'jalan' => 'Jalan Perumahan Sejahtera',
    ),
  ),
  44524 => 
  array (
    0 => 
    array (
      'lat' => -0.4435397,
      'lon' => 117.154661,
      'jalan' => 'Jalan Perumahan Pinang Mas',
    ),
    1 => 
    array (
      'lat' => -0.4437161,
      'lon' => 117.1557556,
      'jalan' => 'Jalan Kyai Haji Wahid Hasyim II',
    ),
    2 => 
    array (
      'lat' => -0.4449606,
      'lon' => 117.1567145,
      'jalan' => 'Jalan Thoyib Hadiwijaya',
    ),
    3 => 
    array (
      'lat' => -0.4459632,
      'lon' => 117.1552419,
      'jalan' => 'Jalan Ahim',
    ),
    4 => 
    array (
      'lat' => -0.4424834,
      'lon' => 117.1518097,
      'jalan' => 'Jalan Perumahan Kayu Manis',
    ),
    5 => 
    array (
      'lat' => -0.4405793,
      'lon' => 117.1526362,
      'jalan' => 'Jalan Unggul',
    ),
    6 => 
    array (
      'lat' => -0.4438311,
      'lon' => 117.1584316,
      'jalan' => 'Jalan Sempaja Lestari Indah 8',
    ),
  ),
  44525 => 
  array (
    0 => 
    array (
      'lat' => -0.454517,
      'lon' => 117.1849877,
      'jalan' => 'Citraland City',
    ),
    1 => 
    array (
      'lat' => -0.4563019,
      'lon' => 117.1899444,
      'jalan' => 'Jalan Meranti Talang Sari',
    ),
    2 => 
    array (
      'lat' => -0.4577229,
      'lon' => 117.1840286,
      'jalan' => 'Jalan Perumahan Sejahtera',
    ),
    3 => 
    array (
      'lat' => -0.4524357,
      'lon' => 117.1913405,
      'jalan' => 'Jalan Poros Kebon Agung',
    ),
    4 => 
    array (
      'lat' => -0.4615497,
      'lon' => 117.1858298,
      'jalan' => 'Jalan Mugirejo',
    ),
    5 => 
    array (
      'lat' => -0.4619848,
      'lon' => 117.1848303,
      'jalan' => 'Jalan Bugis Mugirejo',
    ),
    6 => 
    array (
      'lat' => -0.4630376,
      'lon' => 117.1858856,
      'jalan' => 'Jalan Perumahan Mugirejo',
    ),
  ),
  44526 => 
  array (
    0 => 
    array (
      'lat' => -0.49577,
      'lon' => 117.1589279,
      'jalan' => 'Abdul Muthalib',
    ),
    1 => 
    array (
      'lat' => -0.4948225,
      'lon' => 117.1594866,
      'jalan' => 'Jalan Tepian Sholawat',
    ),
    2 => 
    array (
      'lat' => -0.497101,
      'lon' => 117.1588617,
      'jalan' => 'Jalan Muso Salim',
    ),
    3 => 
    array (
      'lat' => -0.4970057,
      'lon' => 117.1576765,
      'jalan' => 'Jalan Arif Rahman Hakim',
    ),
    4 => 
    array (
      'lat' => -0.496877,
      'lon' => 117.159921,
      'jalan' => 'Jalan Biawan',
    ),
    5 => 
    array (
      'lat' => -0.4980684,
      'lon' => 117.159836,
      'jalan' => 'Jalan Jelawat',
    ),
    6 => 
    array (
      'lat' => -0.494185,
      'lon' => 117.1585665,
      'jalan' => 'Jembatan Kehewanan',
    ),
  ),
);
