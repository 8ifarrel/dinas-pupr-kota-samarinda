<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('hantu_banyu_pelapor', function (Blueprint $table) {
      $table->dropColumn('pekerjaan');
    });
  }

  public function down(): void
  {
    Schema::table('hantu_banyu_pelapor', function (Blueprint $table) {
      $table->string('pekerjaan', 50)->after('nama_lengkap');
    });
  }
};
