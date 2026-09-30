<?php

/**
 * Isi ulang database pupr_smr_test dengan HantuBanyuFixture untuk uji browser
 * dan benchmark. Jumlah laporan bisa diatur lewat argumen pertama.
 *
 *   DB_DATABASE=pupr_smr_test php tests/Browser/isi-data.php [jumlah_laporan]
 */

use Illuminate\Support\Facades\Artisan;
use Tests\Support\HantuBanyu\HantuBanyuFixture;

require __DIR__ . '/../../vendor/autoload.php';
$app = require __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

HantuBanyuFixture::pastikanDatabaseTest();
Artisan::call('migrate:fresh', ['--force' => true]);
HantuBanyuFixture::seed((int) ($argv[1] ?? 36), null, (int) ($argv[2] ?? 14));

echo 'Terisi: ' . DB::table('hantu_banyu_laporan')->count() . " laporan\n";
