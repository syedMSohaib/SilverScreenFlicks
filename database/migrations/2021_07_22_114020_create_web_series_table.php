<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_series', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('TMDB_ID');
            $table->text('name');
            $table->longText('description');
            $table->text('genres');
            $table->text('release_date');
            $table->text('poster');
            $table->text('banner');
            $table->text('youtube_trailer');
            $table->integer('downloadable');
            $table->integer('type');
            $table->integer('status');
            $table->integer('content_type')->default(2)->comment('1=Movie, 2=WebSeries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_series');
    }
}
