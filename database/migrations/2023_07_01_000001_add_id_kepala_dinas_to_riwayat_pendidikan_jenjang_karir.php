<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kepala_dinas_riwayat_pendidikan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kepala_dinas')->nullable()->after('id_pendidikan');
            $table->foreign('id_kepala_dinas')->references('id')->on('kepala_dinas')->nullOnDelete();
        });

        Schema::table('kepala_dinas_jenjang_karir', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kepala_dinas')->nullable()->after('id_karir');
            $table->foreign('id_kepala_dinas')->references('id')->on('kepala_dinas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('kepala_dinas_riwayat_pendidikan', function (Blueprint $table) {
            $table->dropForeign(['id_kepala_dinas']);
            $table->dropColumn('id_kepala_dinas');
        });

        Schema::table('kepala_dinas_jenjang_karir', function (Blueprint $table) {
            $table->dropForeign(['id_kepala_dinas']);
            $table->dropColumn('id_kepala_dinas');
        });
    }
};

