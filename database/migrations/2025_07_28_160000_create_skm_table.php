<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('skm', function (Blueprint $table) {
      $table->id();
      $table->integer('nilai')
        ->nullable()
        ->check('nilai >= 1 and nilai <= 4');
      $table->string('ip_address', 45);
      $table->text('kritik')->nullable();
      $table->text('saran')->nullable();

      $table->unsignedTinyInteger('layanan_id')->nullable();
      $table->foreign('layanan_id')->references('id')->on('layanan')->onDelete('set null');

      $table->timestamp('created_at')->useCurrent();
      $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('skm');
  }
};
