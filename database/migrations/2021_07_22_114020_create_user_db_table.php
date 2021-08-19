<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_db', function (Blueprint $table) {
            $table->integer('id', true);
            $table->mediumText('name');
            $table->mediumText('email');
            $table->mediumText('password');
            $table->integer('role')->default(0)->comment('0=User, 1=Admin, 2=SubAdmin, 3=Manager, 4=Editor');
            $table->text('active_subscription');
            $table->integer('subscription_type')->default(0)->comment('0=Default, 1=Remove Ads, 2=Play Premium, 3=Download Premium');
            $table->integer('time')->default(0);
            $table->integer('amount')->default(0);
            $table->date('subscription_start');
            $table->date('subscription_exp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_db');
    }
}
