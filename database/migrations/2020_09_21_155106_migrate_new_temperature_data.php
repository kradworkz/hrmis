<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateNewTemperatureData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("SET sql_mode = ''");
        \DB::statement("UPDATE `employee_health_check` SET new_temperature = CAST(temperature as DECIMAL(8,1))");
        \DB::statement("ALTER TABLE employee_health_check DROP COLUMN temperature");
        \DB::statement("ALTER TABLE employee_health_check CHANGE new_temperature temperature DECIMAL(8,1)");
        \DB::statement("SET sql_mode=default");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
