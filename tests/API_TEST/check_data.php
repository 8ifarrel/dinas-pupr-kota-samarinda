<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Kecamatan;
use App\Models\Kelurahan;

echo "=== Data untuk Test API ===\n";

echo "\nKecamatan:\n";
$kecamatans = Kecamatan::select('id', 'nama')->take(3)->get();
foreach ($kecamatans as $k) {
    echo "ID: {$k->id} - {$k->nama}\n";
}

echo "\nKelurahan:\n";
$kelurahans = Kelurahan::select('id', 'nama', 'kecamatan_id')->take(3)->get();
foreach ($kelurahans as $k) {
    echo "ID: {$k->id} - {$k->nama} (Kecamatan ID: {$k->kecamatan_id})\n";
}

echo "\n=== End ===\n";
