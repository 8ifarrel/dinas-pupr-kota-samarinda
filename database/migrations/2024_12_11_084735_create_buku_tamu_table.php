<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukuTamuTable extends Migration
{
    public function up()
    {
        Schema::create('buku_tamu', function (Blueprint $table) {
            $table->string('id_buku_tamu');
            $table->string('nama_pengunjung');
            $table->string('nomor_telepon');
            $table->string('email');
            $table->text('alamat');
            $table->unsignedBigInteger('jabatan_yang_dikunjungi');
            $table->text('maksud_dan_tujuan');
            $table->enum('status', ['Pending', 'Diterima', 'Ditolak'])
                  ->default('Pending');
            $table->text('deskripsi_status');
            $table->timestamps();

            $table->foreign('jabatan_yang_dikunjungi')
                  ->references('id_jabatan')
                  ->on('jabatan')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('buku_tamu');
    }
}
