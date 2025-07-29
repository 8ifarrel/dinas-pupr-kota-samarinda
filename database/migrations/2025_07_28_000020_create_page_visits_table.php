<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('page_visits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('visitor_id', 64);
            $table->string('visited_page_context', 255);
            $table->timestamp('visited_at')->useCurrent();
            $table->index('visitor_id', 'page_visits_visitor_id_index');
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_visits');
    }
};
