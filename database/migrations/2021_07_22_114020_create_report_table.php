<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->text('title');
            $table->longText('description');
            $table->integer('report_type')->comment('0=Custom, 1=Movie, 2=Web Series, 3=Live TV');
            $table->integer('status')->comment('0=Pending, 1=Solved, 2=Canceled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report');
    }
}
