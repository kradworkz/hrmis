<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHrToUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->tinyInteger('hr_approval')->default(1)->after('travel_approval');
            $table->tinyInteger('chief_approval')->default(1)->after('hr_approval');
            $table->tinyInteger('leave_recommending')->default(1)->after('chief_approval');
            $table->tinyInteger('leave_approval')->default(1)->after('leave_recommending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn('hr_approval');
            $table->dropColumn('chief_approval');
            $table->dropColumn('leave_recommending');
            $table->dropColumn('leave_approval');
        });
    }
}
