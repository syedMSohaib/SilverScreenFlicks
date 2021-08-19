<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('name');
            $table->text('coupon_code');
            $table->integer('time')->comment('Days');
            $table->integer('amount');
            $table->integer('subscription_type')->default(0)->comment('1=Remove Ads, 2=Play Premium, 3=Download Premium	');
            $table->integer('status')->comment('0=Expired, 1=Valid');
            $table->integer('max_use')->default(1);
            $table->integer('used')->default(0);
            $table->text('used_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon');
    }
}
