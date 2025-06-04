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
			$table->text('tupoksi_jabatan')->nullable();
			$table->text('deskripsi_jabatan')->nullable();
			$table->enum('kelompok_jabatan', ['UPTD', 'Bidang', 'Kepala Dinas', 'Sekretariat']);
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
