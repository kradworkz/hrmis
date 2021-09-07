<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OffsetCovidPositiveFilter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offset', function (Blueprint $table) {
            $table->tinyInteger('is_positive')->default(0)->after('approval_notification');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offset', function (Blueprint $table) {
            $table->dropColumn('is_positive');
        });
    }
}
