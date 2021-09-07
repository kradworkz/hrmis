<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeCocTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_coc', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->integer('beginning_hours')->nullable();
            $table->integer('beginning_minutes')->nullable();
            $table->integer('offset_id')->nullable();
            $table->integer('offset_hours')->nullable();
            $table->integer('end_hours')->nullable();
            $table->integer('end_minutes')->nullable();
            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
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
        Schema::dropIfExists('employee_coc');
    }
}
