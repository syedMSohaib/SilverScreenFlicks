<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageSliderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_slider', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('title');
            $table->text('banner');
            $table->integer('content_type')->comment('0=Movie,1=WebSeries,2=WebView,3=External Browser');
            $table->integer('content_id');
            $table->text('url');
            $table->integer('status')->comment('	0=UnPublished, 1=Published');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_slider');
    }
}
