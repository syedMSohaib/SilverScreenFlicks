<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieDownloadLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_download_links', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('name');
            $table->text('size');
            $table->text('quality');
            $table->integer('link_order');
            $table->integer('movie_id');
            $table->text('url');
            $table->text('type');
            $table->text('download_type');
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
        Schema::dropIfExists('movie_download_links');
    }
}
