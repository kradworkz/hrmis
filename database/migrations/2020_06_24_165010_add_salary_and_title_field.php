<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSalaryAndTitleField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('salary')->nullable()->after('email');
            $table->string('suffix')->nullable()->after('password');
            $table->string('prefix')->nullable()->after('suffix');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('salary');
            $table->dropColumn('suffix');
            $table->dropColumn('prefix');
        });
    }
}
