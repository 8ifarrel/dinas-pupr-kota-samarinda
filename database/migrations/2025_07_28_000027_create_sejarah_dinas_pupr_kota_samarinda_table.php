<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sejarah_dinas_pupr_kota_samarinda', function (Blueprint $table) {
            $table->bigIncrements('id_sejarah_dinas_pupr_kota_samarinda');
            $table->text('deskripsi_sejarah_dinas_pupr_kota_samarinda');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sejarah_dinas_pupr_kota_samarinda');
    }
};
