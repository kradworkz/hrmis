<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_of_service', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->string('agency_head_name');
            $table->string('agency_head_designation');
            $table->string('employment_title');
            $table->string('contract_duration');
            $table->string('salary_rate');
            $table->text('charging');
            $table->text('duties_and_responsibilities');
            $table->string('first_party_name');
            $table->string('second_party_name');
            $table->string('first_witness_name');
            $table->string('first_witness_designation');
            $table->string('second_witness_name');
            $table->string('second_witness_designation');
            $table->string('current_budget_officer_name');
            $table->string('current_budget_officer_designation');
            $table->string('current_accountant_name');
            $table->string('current_accountant_designation');
            $table->string('agency_head_id_name');
            $table->string('agency_head_id_number');
            $table->string('agency_head_id_date_issued');
            $table->string('second_party_id_name');
            $table->string('second_party_id_number');
            $table->string('second_party_id_date_issued');
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
        Schema::dropIfExists('contract_of_service');
    }
}
