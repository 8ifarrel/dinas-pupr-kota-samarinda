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
        Schema::create('drainase_irigasi_pelapor', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 100);
            $table->string('pekerjaan', 50);
            $table->text('alamat');
            $table->string('nomor_telepon', 20);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drainase_irigasi_pelapor');
    }
};
