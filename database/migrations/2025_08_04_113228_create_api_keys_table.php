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
        Schema::create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->string('key', 255)->unique();
            $table->string('name', 255);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('generated_by_user_id')->nullable();
            $table->timestamps();
            
            $table->foreign('generated_by_user_id')->references('id')->on('users')->onDelete('set null');
            $table->index(['key', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_keys');
    }
};
