<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHealthGroupField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_quarantine', function (Blueprint $table) {
            $table->integer('endorsed_by')->nullable()->after('medical_certificate');
            $table->tinyInteger('is_active')->default(1);
            $table->date('start_date')->nullable()->after('unit_id');
            $table->date('end_date')->nullable()->after('start_date');
        });

        Schema::drop('employee_quarantine_dates');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_quarantine', function (Blueprint $table) {
            $table->dropColumn('endorsed_by');
            $table->dropColumn('is_active');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
        });
    }
}
