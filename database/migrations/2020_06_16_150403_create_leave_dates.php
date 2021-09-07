<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('leave_id')->unsigned();
            $table->date('date');
            $table->tinyInteger('chief_approval')->default(0);
            $table->tinyInteger('chief_approval_by')->unsigned()->nullable();
            $table->tinyInteger('recommending')->default(0);
            $table->tinyInteger('recommending_by')->unsigned()->nullable();
            $table->tinyInteger('approval')->default(0);
            $table->tinyInteger('approval_by')->unsigned()->nullable();
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
        Schema::dropIfExists('leave_dates');
    }
}
