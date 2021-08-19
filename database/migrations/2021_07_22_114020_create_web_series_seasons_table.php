<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebSeriesSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_series_seasons', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('Session_Name');
            $table->integer('season_order');
            $table->integer('web_series_id');
            $table->integer('status')->comment('0=Not Released, 1=Released');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_series_seasons');
    }
}
