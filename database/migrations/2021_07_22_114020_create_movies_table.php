<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('TMDB_ID')->unique('TMDB_ID');
            $table->integer('IMDB_ID')->nullable();
            $table->text('name');
            $table->longText('description');
            $table->string('imdb_rating')->nullable();
            $table->mediumText('genres');
            $table->mediumText('release_date');
            $table->mediumText('runtime');
            $table->mediumText('poster');
            $table->mediumText('banner');
            $table->mediumText('youtube_trailer');
            $table->integer('downloadable')->comment('0=Not Downloadable, 1=Downloadable');
            $table->integer('type')->comment('0=NotPremium, 1=Premium');
            $table->integer('status')->comment('0=UnPublished, 1=Published');
            $table->integer('content_type')->default(1)->comment('1=Movie, 2=WebSeries');
            $table->timestamps();
            $table->longText('payload')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
