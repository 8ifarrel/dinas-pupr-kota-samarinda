<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('kecamatans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 255);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kecamatan');
    }
};
