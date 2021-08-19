<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveTvChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_tv_channels', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('name');
            $table->text('banner');
            $table->text('stream_type');
            $table->text('url');
            $table->integer('content_type')->default(3)->comment('	1=Movie, 2=WebSeries, 3=LiveTV');
            $table->integer('type')->default(0)->comment('	0=NotPremium, 1=Premium');
            $table->integer('status')->default(1)->comment('0=No, 1=Yes');
            $table->integer('featured')->default(0)->comment('0=No, 1=Yes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('live_tv_channels');
    }
}
