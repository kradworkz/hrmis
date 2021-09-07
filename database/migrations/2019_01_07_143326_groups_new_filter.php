<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupsNewFilter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->tinyInteger('travel_recommending')->default(1)->after('approval');
            $table->tinyInteger('travel_approval')->default(1)->after('travel_recommending');
            $table->tinyInteger('offset_recommending')->default(1)->after('travel_approval');
            $table->tinyInteger('offset_approval')->default(1)->after('offset_recommending');
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
