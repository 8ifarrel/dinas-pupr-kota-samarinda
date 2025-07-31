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
            $table->string('nama_pelanggan', 150);
            $table->string('nomor_telepon_pelanggan', 15);
            $table->text('alamat');
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('latitude', 9, 7)->nullable();
            $table->unsignedSmallInteger('kabkota');
            $table->unsignedSmallInteger('kecamatan');
            $table->unsignedSmallInteger('kelurahan');
            $table->string('jenis_bangunan', 20);
            $table->unsignedSmallInteger('nomor_bangunan');
            $table->unsignedSmallInteger('rt');
            $table->enum('status_pengerjaan', ['Belum dikerjakan', 'Sedang dikerjakan', 'Sudah dikerjakan'])->default('Belum dikerjakan');
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
