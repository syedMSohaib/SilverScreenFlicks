<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviePlayLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_play_links', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('name');
            $table->text('size');
            $table->text('quality');
            $table->integer('link_order');
            $table->integer('movie_id');
            $table->text('url');
            $table->text('type');
            $table->integer('status')->comment('0=Not Released, 1=Released');
            $table->integer('skip_available')->default(0)->comment('0=No, 1=Yes');
            $table->text('intro_start')->nullable();
            $table->text('intro_end')->nullable();
            $table->text('end_credits_marker')->nullable();
            $table->longText('srt_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_play_links');
    }
}
