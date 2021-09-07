<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLeaveDisapprovedField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave', function (Blueprint $table) {
            $table->string('recommending_disapproval')->nullable()->after('approval_notification');
            $table->string('approval_disapproval')->nullable()->after('recommending_disapproval');
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
            $table->dropColumn('recommending_disapproval');
            $table->dropColumn('approval_disapproval');
        });
    }
}
