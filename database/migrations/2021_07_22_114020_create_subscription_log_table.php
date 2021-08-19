<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_log', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('name');
            $table->integer('amount');
            $table->integer('time');
            $table->date('subscription_start');
            $table->date('subscription_exp');
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_log');
    }
}
