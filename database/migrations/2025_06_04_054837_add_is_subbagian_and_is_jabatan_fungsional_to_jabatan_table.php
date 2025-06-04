<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up()
	{
		Schema::table('jabatan', function (Blueprint $table) {
			$table->boolean('is_subbagian')->default(false)->after('kelompok_jabatan');
			$table->boolean('is_jabatan_fungsional')->default(false)->after('is_subbagian');
		});
	}

	public function down()
	{
		Schema::table('jabatan', function (Blueprint $table) {
			$table->dropColumn(['is_subbagian', 'is_jabatan_fungsional']);
		});
	}
};
