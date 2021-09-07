<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmergencyContactToEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('emergency_contact_person')->nullable()->after('salary');
            $table->string('emergency_contact_number')->nullable()->after('emergency_contact_person');
            $table->string('religion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('emergency_contact_person');
            $table->dropColumn('emergency_contact_number');
            $table->dropColumn('religion');
        });
    }
}
