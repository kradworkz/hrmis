<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelFundExpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_funds_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('travel_id')->unsigned();
            $table->foreign('travel_id')->references('id')->on('travels')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('fund_id')->unsigned();
            $table->foreign('fund_id')->references('id')->on('travel_funds')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('expense_id')->unsigned();
            $table->foreign('expense_id')->references('id')->on('travel_expenses')->onUpdate('cascade')->onDelete('cascade');
            $table->string('others')->nullable();
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
        Schema::dropIfExists('travel_fund_expense');
    }
}