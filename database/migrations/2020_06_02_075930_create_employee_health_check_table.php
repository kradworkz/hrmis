<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeHealthCheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_health_check', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('employee_id')->unsigned()->nullable();
            $table->datetime('date');
            $table->string('full_name')->nullable();
            $table->string('temperature')->nullable();
            $table->string('gender')->nullable();
            $table->string('age')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('residence')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('nature_of_visit_official')->nullable();
            $table->string('nature_of_visit_personal')->nullable();
            $table->string('nature_of_official_business_employee')->nullable();
            $table->string('nature_of_official_business_client')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('fever')->nullable();
            $table->string('cough')->nullable();
            $table->string('fatigue')->nullable();
            $table->string('ache')->nullable();
            $table->string('runny_nose')->nullable();
            $table->string('shortness_of_breath')->nullable();
            $table->string('diarrhea')->nullable();
            $table->string('q2')->nullable();
            $table->string('q3')->nullable();
            $table->string('q4')->nullable();
            $table->string('q5')->nullable();
            $table->string('location')->nullable();
            $table->string('customer_type')->nullable();
            $table->integer('encoded_by')->unsigned()->nullable();
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
        Schema::dropIfExists('employee_health_check');
    }
}
