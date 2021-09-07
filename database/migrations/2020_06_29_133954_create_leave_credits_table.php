<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_credits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->integer('leave_id')->nullable();
            $table->float('vl_earned', 8,3)->nullable();
            $table->float('vl_deduct', 8,3)->nullable();
            $table->float('vl_deduct_without_pay', 8,3)->nullable();
            $table->float('vl_balance', 8,3)->nullable();
            $table->float('sl_earned', 8,3)->nullable();
            $table->float('sl_deduct', 8,3)->nullable();
            $table->float('sl_deduct_without_pay', 8,3)->nullable();
            $table->float('sl_balance', 8,3)->nullable();
            $table->float('latest_balance', 8,3)->nullable();
            $table->integer('month')->unsigned();
            $table->integer('year')->unsigned();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('leave_credits');
    }
}
