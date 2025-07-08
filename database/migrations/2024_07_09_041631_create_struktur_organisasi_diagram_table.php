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
        Schema::create('struktur_organisasi_diagram', function (Blueprint $table) {
            $table->id('id_struktur_organisasi_diagram');
            $table->unsignedInteger('id_struktur_organisasi')->nullable();
            $table->string('diagram_struktur_organisasi');
            $table->timestamps();

            $table->foreign('id_struktur_organisasi')
                  ->references('id_struktur_organisasi')
                  ->on('struktur_organisasi')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('struktur_organisasi_diagram', function (Blueprint $table) {
            $table->dropForeign(['id_struktur_organisasi']);
        });

        Schema::dropIfExists('struktur_organisasi_diagram');
    }
};
