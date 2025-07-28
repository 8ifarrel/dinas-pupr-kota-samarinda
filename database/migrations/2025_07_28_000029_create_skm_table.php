<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('skm', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nilai')->nullable()->check('nilai >= 1 and nilai <= 4');
            $table->string('ip_address', 45);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skm');
    }
};
