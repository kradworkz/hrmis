<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOvertimeRequestPersonnel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtime_request_personnel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('overtime_request_id')->unsigned();
            $table->foreign('overtime_request_id')->references('id')->on('overtime_request')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('overtime_request_personnel');
    }
}
