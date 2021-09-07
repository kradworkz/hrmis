<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParticularsField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave_credits', function (Blueprint $table) {
            $table->string('particulars')->nullable()->after('leave_id');
            $table->integer('days')->unsigned()->after('particulars');
            $table->integer('hours')->unsigned()->after('days');
            $table->integer('minutes')->unsigned()->after('hours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leave_credits', function (Blueprint $table) {
            $table->dropColumn('particulars');
            $table->dropColumn('days');
            $table->dropColumn('hours');
            $table->dropColumn('minutes');
        });
    }
}
