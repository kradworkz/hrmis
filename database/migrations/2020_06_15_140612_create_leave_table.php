<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('time')->nullable();
            $table->string('type');
            $table->string('vacation_leave')->nullable();
            $table->string('vacation_leave_specify')->nullable();
            $table->string('vacation_location')->nullable();
            $table->string('vacation_location_specify')->nullable();
            $table->string('sick_leave')->nullable();
            $table->string('sick_leave_specify')->nullable();
            $table->string('sick_location')->nullable();
            $table->string('sick_location_specify')->nullable();
            $table->integer('number_of_working_days_applied');
            $table->string('commutation');
            $table->tinyInteger('hr_approval')->default(0);
            $table->tinyInteger('hr_approval_by')->unsigned()->nullable();
            $table->integer('sick_leave_credits')->unsigned();
            $table->integer('vacation_leave_credits')->unsigned();
            $table->integer('total_leave_credits')->unsigned();
            $table->date('as_of');
            $table->float('approved_sick_leave', 8,3)->unsigned();
            $table->float('approved_vacation_leave', 8,3)->unsigned();
            $table->float('approved_without_pay', 8,3)->unsigned();
            $table->string('approved_others')->nullable();
            $table->tinyInteger('chief_approval')->default(0);
            $table->tinyInteger('chief_approval_by')->unsigned()->nullable();
            $table->tinyInteger('recommending')->default(0);
            $table->tinyInteger('recommending_by')->unsigned()->nullable();
            $table->tinyInteger('approval')->default(0);
            $table->tinyInteger('approval_by')->unsigned()->nullable();
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
        Schema::dropIfExists('leave');
    }
}
