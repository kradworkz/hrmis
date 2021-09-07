<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('password');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('name_suffix')->nullable();
            $table->string('designation')->nullable();
            $table->string('email')->nullable();
            $table->string('signature')->nullable();
            $table->string('picture')->nullable();
            $table->integer('employee_status_id')->unsigned();
            $table->foreign('employee_status_id')->references('id')->on('employee_status')->onUpdate('cascade');
            $table->tinyInteger('is_active')->default(1);
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('employees');
    }
}
