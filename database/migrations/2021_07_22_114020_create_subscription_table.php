<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('name');
            $table->integer('time')->comment('Days');
            $table->integer('amount');
            $table->integer('currency')->comment('0=INR,1=USD');
            $table->text('background');
            $table->integer('subscription_type')->default(0)->comment('0=Default, 1=Remove Ads, 2=Play Premium, 3=Download Premium');
            $table->integer('status')->comment('0=UnPublished, 1=Published');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription');
    }
}
