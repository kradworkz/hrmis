<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePdsPersonalInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pds_personal_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('name_extension')->nullable();
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->string('citizenship');
            $table->string('gender');
            $table->string('civil_status');
            $table->integer('height')->unsigned()->nullable();
            $table->integer('weight')->unsigned()->nullable();
            $table->string('blood_type')->nullable();
            $table->string('gsis_id')->nullable();
            $table->string('pagibig_id')->nullable();
            $table->string('philhealth_id')->nullable();
            $table->string('sss_id')->nullable();
            $table->string('tin_id')->nullable();
            $table->string('agency_employee_number')->nullable();
            $table->string('residential_house_info')->nullable();
            $table->string('residential_street')->nullable();
            $table->string('residential_subdivision')->nullable();
            $table->string('residential_barangay')->nullable();
            $table->string('residential_city')->nullable();
            $table->string('residential_province')->nullable();
            $table->string('residential_zip_code')->nullable();
            $table->string('permanent_house_info')->nullable();
            $table->string('permanent_street')->nullable();
            $table->string('permanent_subdivision')->nullable();
            $table->string('permanent_barangay')->nullable();
            $table->string('permanent_city')->nullable();
            $table->string('permanent_province')->nullable();
            $table->string('permanent_zip_code')->nullable();
            $table->string('telephone_number')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('pds_personal_information');
    }
}
