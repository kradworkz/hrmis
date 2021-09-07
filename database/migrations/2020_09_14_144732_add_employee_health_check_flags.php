<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployeeHealthCheckFlags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_health_check', function (Blueprint $table) {
            $table->float('new_temperature', 8,1)->nullable()->unsigned()->after('temperature');
            $table->tinyInteger('listed')->default(1)->after('encoded_by');
            $table->tinyInteger('verified')->default(0);
            $table->integer('verified_by')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_health_check', function (Blueprint $table) {
            // $table->dropColumn('new_temperature');
            $table->dropColumn('listed');
            $table->dropColumn('verified');
            $table->dropColumn('verified_by');
        });
    }
}
