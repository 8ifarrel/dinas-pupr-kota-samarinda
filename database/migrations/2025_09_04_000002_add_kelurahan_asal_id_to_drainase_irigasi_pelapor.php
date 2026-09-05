<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('drainase_irigasi_pelapor', function (Blueprint $table) {
            $table->unsignedSmallInteger('kelurahan_asal_id')->nullable()->after('nama_lengkap');
            $table->foreign('kelurahan_asal_id')->references('id')->on('kelurahan')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('drainase_irigasi_pelapor', function (Blueprint $table) {
            $table->dropForeign(['kelurahan_asal_id']);
            $table->dropColumn('kelurahan_asal_id');
        });
    }
};
