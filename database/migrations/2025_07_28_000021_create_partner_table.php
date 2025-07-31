<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('partner', function (Blueprint $table) {
            $table->bigIncrements('id_partner');
            $table->string('foto_partner', 255);
            $table->string('nama_partner', 255);
            $table->string('url_partner', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('partner');
    }
};
