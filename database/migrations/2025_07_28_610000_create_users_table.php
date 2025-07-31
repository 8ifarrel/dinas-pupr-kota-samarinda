<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_susunan_organisasi')->nullable();
            $table->string('fullname', 255);
            $table->string('name', 255)->unique();
            $table->string('email', 255)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->boolean('is_super_admin')->default(0);
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->foreign('id_susunan_organisasi')->references('id_susunan_organisasi')->on('susunan_organisasi');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
