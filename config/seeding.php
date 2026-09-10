<?php

/**
 * Nilai yang dipakai database seeder saat membuat akun bawaan.
 *
 * Setiap kunci wajib diisi lewat .env (lihat .env.example). Setelah mengubah
 * .env, jalankan ulang "php artisan config:cache" bila konfigurasi sedang
 * di-cache.
 *
 * Akses dari seeder: config('seeding.password_admin').
 */

return [

  // Kata sandi (plain text, di-hash oleh seeder) untuk akun panel admin
  // tingkat unit kerja.
  'password_admin' => env('SEEDER_PASSWORD_ADMIN'),

  // Kata sandi untuk akun super admin.
  'password_super_admin' => env('SEEDER_PASSWORD_SUPER_ADMIN'),

  // Kata sandi untuk akun operator kelurahan.
  'password_kelurahan' => env('SEEDER_PASSWORD_KELURAHAN'),

];
