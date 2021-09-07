<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreSymptoms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_health_check', function (Blueprint $table) {
            $table->string('headache')->nullable()->after('diarrhea');
            $table->string('sore_throat')->nullable()->after('headache');
            $table->string('loss_of_taste')->nullable()->after('sore_throat');
        });
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
