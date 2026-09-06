<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Third Party Services
  |--------------------------------------------------------------------------
  |
  | This file is for storing the credentials for third party services such
  | as Mailgun, Postmark, AWS and more. This file provides the de facto
  | location for this type of information, allowing packages to have
  | a conventional file to locate the various service credentials.
  |
  */

  'postmark' => [
    'token' => env('POSTMARK_TOKEN'),
  ],

  'ses' => [
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
  ],

  'resend' => [
    'key' => env('RESEND_KEY'),
  ],

  'slack' => [
    'notifications' => [
      'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
      'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
    ],
  ],
  
  'maptiler' => [
    'token' => env('MAPTILER_TOKEN'),
  ],

  // Browsershot (generator PDF Hantu Banyu). Di Linux biarkan kosong agar
  // binary Node/npm dideteksi otomatis dari PATH; di Windows isi lewat .env.
  'browsershot' => [
    'node_binary' => env('BROWSERSHOT_NODE_BINARY'),
    'npm_binary' => env('BROWSERSHOT_NPM_BINARY'),
  ],

  // IPInfo, dipakai statistik pengunjung untuk mengenali lalu lintas dari
  // penyedia cloud/datacenter supaya tidak ikut terhitung sebagai pengunjung.
  // Token WAJIB dibaca lewat config, bukan env() langsung: begitu
  // "php artisan config:cache" dijalankan di produksi, env() mengembalikan
  // null dan penyaringnya akan mati tanpa suara.
  'ipinfo' => [
    'token' => env('IPINFO_TOKEN'),
    'base_url' => env('IPINFO_BASE_URL', 'https://api.ipinfo.io/lite'),
  ],

  // Nominatim & Overpass (OpenStreetMap), dipakai Hantu Banyu untuk mengubah
  // koordinat menjadi nama jalan dan untuk autocomplete nama jalan.
  //
  // Sengaja dibuat bisa ditukar lewat .env: instans publik OSM punya batas
  // pemakaian yang ketat dan rutin memblokir IP yang dianggap kelebihan beban,
  // sedangkan Overpass publik sering membalas 429/504 saat ramai. Bila itu
  // terjadi, pindah ke mirror cukup mengganti satu baris .env lalu
  // "php artisan config:cache", tanpa perlu menyunting kode dan deploy ulang.
  // Nilai bawaan di bawah adalah instans resmi, jadi tanpa .env pun tetap jalan.
  'nominatim' => [
    'base_url' => env('NOMINATIM_BASE_URL', 'https://nominatim.openstreetmap.org'),
  ],

  'overpass' => [
    'url' => env('OVERPASS_URL', 'https://overpass-api.de/api/interpreter'),
  ],

];

