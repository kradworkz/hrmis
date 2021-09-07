<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffsetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offset', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->date('date');
            $table->string('time');
            $table->integer('hours')->unsigned();
            $table->string('remarks');
            $table->tinyInteger('recommending')->default(0);
            $table->tinyInteger('approval')->default(0);
            $table->tinyInteger('recommending_by')->default(0);
            $table->tinyInteger('approval_by')->default(0);
            $table->tinyInteger('recommending_notification')->default(0);
            $table->tinyInteger('approval_notification')->default(0);
            $table->tinyInteger('is_active')->default(1);
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
        Schema::dropIfExists('offset');
    }
}
