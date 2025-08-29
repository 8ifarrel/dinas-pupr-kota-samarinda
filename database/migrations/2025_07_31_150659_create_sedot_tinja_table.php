<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sedot_tinja', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique(); 

            // Data pelanggan
            $table->string('nama_pelanggan', 150);
            $table->string('nomor_telepon_pelanggan', 15);
            $table->text('alamat');
            $table->text('alamat_detail')->nullable();

            // Jenis layanan & detail laporan
            $table->string('layanan', 50)->nullable();
            $table->text('detail_laporan')->nullable();

            // Lokasi administratif (dari API)
            $table->string('kabkota_id', 50);
            $table->string('kecamatan_id', 50);
            $table->string('kelurahan_id', 50);

            // Lokasi titik maps
            $table->decimal('latitude', 9, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Bangunan
            $table->string('jenis_bangunan', 50);
            $table->unsignedSmallInteger('nomor_bangunan');
            $table->unsignedSmallInteger('rt');

            // Feedback user
            $table->tinyInteger('rating')->nullable(); // 1–5
            $table->text('saran_masukan')->nullable();

            // Captcha (biasanya tidak perlu disimpan, tapi sesuai model kamu)
            $table->string('captcha', 50)->nullable();

            // Status pengerjaan
            $table->enum('status_pengerjaan', [
                'Belum dikerjakan',
                'Sedang dikerjakan',
                'Sudah dikerjakan'
            ])->default('Belum dikerjakan');

            // Checkbox setuju
            $table->boolean('setuju')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sedot_tinja');
    }
};
