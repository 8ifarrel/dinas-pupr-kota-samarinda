<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSejarahKotaSamarindaTable extends Migration
{
	public function up()
	{
		Schema::create('sejarah_kota_samarinda', function (Blueprint $table) {
			$table->id('id_sejarah_kota_samarinda');
			$table->text('deskripsi_sejarah_kota_samarinda');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('sejarah_kota_samarinda');
	}
}
