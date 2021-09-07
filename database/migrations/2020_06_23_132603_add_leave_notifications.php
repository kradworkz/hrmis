<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLeaveNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave', function (Blueprint $table) {
            $table->tinyInteger('hr_notification')->default(0)->after('approval_by');
            $table->tinyInteger('chief_notification')->default(0)->after('hr_notification');
            $table->tinyInteger('recommending_notification')->default(0)->after('chief_notification');
            $table->tinyInteger('approval_notification')->default(0)->after('recommending_notification');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leave', function (Blueprint $table) {
            $table->dropColumn('hr_notification');
            $table->dropColumn('chief_notification');
            $table->dropColumn('recommending_notification');
            $table->dropColumn('approval_notification');
        });
    }
}
