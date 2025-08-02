<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jalan_peduli_ip_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelapor_id')->constrained('jalan_peduli_pelapor')->cascadeOnDelete();
            $table->string('laporan_id');
            $table->foreign('laporan_id')
                ->references('id_laporan')
                ->on('jalan_peduli_laporan')
                ->cascadeOnDelete();
            $table->string('ip_address');
            $table->decimal('latitude', 9, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jalan_peduli_ip_log');
    }
};
