<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Pengunjung unik situs (satu baris per cookie visitor_id).
 *
 * Waktu kunjungan pertama disebar pada hari ini, minggu ini, dan bulan ini
 * karena beranda menampilkan tiga angka tersebut. Tanpa sebaran itu, ketiga
 * kartu statistik akan menampilkan angka yang sama.
 */
class VisitorsSeeder extends Seeder
{
  private const HARI_INI = 12;
  private const MINGGU_INI = 30;
  private const BULAN_INI = 65;

  public function run(): void
  {
    $baris = [];

    // Hari ini
    for ($i = 0; $i < self::HARI_INI; $i++) {
      $baris[] = $this->pengunjung(now()->startOfDay()->addMinutes(random_int(30, 1200)));
    }

    // Sisa minggu ini (di luar hari ini)
    for ($i = 0; $i < self::MINGGU_INI; $i++) {
      $hari = random_int(1, max(1, now()->dayOfWeekIso - 1));
      $baris[] = $this->pengunjung(now()->subDays($hari)->setTime(random_int(7, 21), random_int(0, 59)));
    }

    // Sisa bulan ini (di luar minggu ini)
    for ($i = 0; $i < self::BULAN_INI; $i++) {
      $hari = random_int(now()->dayOfWeekIso, max(now()->dayOfWeekIso, now()->day - 1));
      $baris[] = $this->pengunjung(now()->subDays($hari)->setTime(random_int(7, 21), random_int(0, 59)));
    }

    DB::table('visitors')->insert($baris);
  }

  private function pengunjung($waktu): array
  {
    $agen = [
      'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0 Safari/537.36',
      'Mozilla/5.0 (Linux; Android 13; SM-A536E) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0 Mobile Safari/537.36',
      'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1',
    ];

    return [
      'visitor_id' => (string) Str::uuid(),
      'ip_address' => '114.' . random_int(4, 125) . '.' . random_int(0, 255) . '.' . random_int(1, 254),
      'user_agent' => $agen[array_rand($agen)],
      'first_visit_at' => $waktu,
    ];
  }
}
