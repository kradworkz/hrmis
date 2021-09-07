<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMonitorHealthField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_quarantine', function (Blueprint $table) {
            $table->tinyInteger('monitor_health')->default(0)->after('medical_certificate');
            $table->tinyInteger('report_local')->default(0)->after('monitor_health');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_quarantine', function (Blueprint $table) {
            $table->dropColumn('monitor_health');
            $table->dropColumn('report_local');
        });
    }
}
