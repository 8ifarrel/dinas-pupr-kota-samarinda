<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJabatanTable extends Migration
{
    public function up()
    {
        Schema::create('jabatan', function (Blueprint $table) {
            $table->id('id_jabatan');
            $table->string('nama_jabatan')->unique();
            $table->unsignedBigInteger('id_jabatan_parent')->nullable();
            $table->string('slug_jabatan')->unique();
            $table->text('tupoksi_jabatan');
            $table->text('deskripsi_jabatan');
            $table->set('kelompok_jabatan', ['Subbagian', 'UPTD', 'Bidang', 'PLT', 'Kepala Dinas', 'Sekretariat', 'Jabatan Fungsional']);
            $table->timestamps();

            $table->foreign('id_jabatan_parent')
                  ->references('id_jabatan')
                  ->on('jabatan')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jabatan');
    }
}
