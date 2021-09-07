<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelPassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_passengers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('travel_id')->unsigned();
            $table->foreign('travel_id')->references('id')->on('travels')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('tagged')->default(0);
            $table->tinyInteger('approved')->default(0);
            $table->tinyInteger('disapproved')->default(0);
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
        Schema::dropIfExists('travel_passengers');
    }
}
