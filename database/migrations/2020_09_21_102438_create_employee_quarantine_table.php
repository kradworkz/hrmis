<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeQuarantineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_quarantine', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_health_check_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->string('remarks')->nullable();
            $table->tinyInteger('medical_certificate')->default(0);
            $table->tinyInteger('unit_head')->default(0);
            $table->integer('unit_head_by')->unsigned()->nullable();
            $table->tinyInteger('recommending_fas')->default(0);
            $table->integer('recommending_fas_by')->unsigned()->nullable();
            $table->tinyInteger('recommending_to')->default(0);
            $table->integer('recommending_to_by')->unsigned()->nullable();
            $table->tinyInteger('approval')->default(0);
            $table->integer('approval_by')->unsigned()->nullable();
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
        Schema::dropIfExists('employee_quarantine');
    }
}
