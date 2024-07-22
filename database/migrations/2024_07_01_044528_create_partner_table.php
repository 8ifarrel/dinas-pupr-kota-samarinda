<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerTable extends Migration
{
    public function up()
    {
        Schema::create('partner', function (Blueprint $table) {
            $table->id('id_partner');
            $table->string('foto_partner');
            $table->string('nama_partner');
            $table->string('url_partner');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('partner');
    }
}
