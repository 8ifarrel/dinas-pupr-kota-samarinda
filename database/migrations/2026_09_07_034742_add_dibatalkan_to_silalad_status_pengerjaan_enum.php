<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Kolom status_pengerjaan dibuat sebagai ENUM 3 nilai saja (Belum/Sedang/
 * Sudah dikerjakan), padahal seluruh aplikasi (filter, badge, dropdown di
 * halaman edit admin) sudah memperlakukan "Dibatalkan" sebagai status ke-4
 * yang valid sejak awal. Tanpa migration ini, memilih "Dibatalkan" di
 * halaman edit akan gagal disimpan (data terpotong / query error) karena
 * nilainya ditolak ENUM.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE silalad MODIFY status_pengerjaan ENUM(
            'Belum dikerjakan',
            'Sedang dikerjakan',
            'Sudah dikerjakan',
            'Dibatalkan'
        ) NOT NULL DEFAULT 'Belum dikerjakan'");
    }

    public function down(): void
    {
        // Kembalikan ke 3 nilai semula. Baris yang sudah "Dibatalkan" perlu
        // diubah dulu secara manual sebelum rollback, kalau tidak MySQL akan
        // memotongnya jadi string kosong.
        DB::statement("ALTER TABLE silalad MODIFY status_pengerjaan ENUM(
            'Belum dikerjakan',
            'Sedang dikerjakan',
            'Sudah dikerjakan'
        ) NOT NULL DEFAULT 'Belum dikerjakan'");
    }
};
