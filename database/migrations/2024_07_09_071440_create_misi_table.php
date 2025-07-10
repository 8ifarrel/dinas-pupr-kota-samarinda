<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('misi', function (Blueprint $table) {
            $table->id('id_misi');
            $table->integer('nomor_urut');
            $table->text('deskripsi_misi');
            $table->year('periode_mulai');
            $table->year('periode_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('misi');
    }
}

