<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebSeriesEpisoadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_series_episoade', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('Episoade_Name');
            $table->text('episoade_image');
            $table->text('episoade_description');
            $table->integer('episoade_order');
            $table->integer('season_id');
            $table->integer('downloadable')->comment('0=No, 1=Yes');
            $table->integer('type')->comment('0=NotPremium, 1=Premium');
            $table->integer('status')->comment('0=Not Released, 1=Released');
            $table->text('source');
            $table->text('url');
            $table->integer('skip_available')->default(0)->comment('0=No, 1=Yes');
            $table->text('intro_start');
            $table->text('intro_end');
            $table->text('end_credits_marker');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_series_episoade');
    }
}
