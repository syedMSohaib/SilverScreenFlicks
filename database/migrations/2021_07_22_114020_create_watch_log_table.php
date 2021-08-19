<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWatchLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watch_log', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('user_id');
            $table->integer('content_id');
            $table->integer('content_type')->comment('1=Movie, 2=WebSeries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('watch_log');
    }
}
