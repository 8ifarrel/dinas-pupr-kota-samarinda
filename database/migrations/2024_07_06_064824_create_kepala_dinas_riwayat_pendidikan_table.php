<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKepalaDinasRiwayatPendidikanTable extends Migration
{
	public function up()
	{
		Schema::create('kepala_dinas_riwayat_pendidikan', function (Blueprint $table) {
			$table->id('id_pendidikan');
			$table->string('nama_pendidikan');
			$table->date('tanggal_masuk');
			$table->unsignedBigInteger('id_pegawai');
			$table->timestamps();

			$table->foreign('id_pegawai')
				->references('id_pegawai')
				->on('pegawai')
				->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::dropIfExists('kepala_dinas_riwayat_pendidikan');
	}
}
