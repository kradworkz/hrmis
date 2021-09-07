<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned()->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('vehicle_id')->unsigned()->nullable();
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onUpdate('cascade')->onDelete('cascade');
            $table->string('trip_ticket')->nullable();
            $table->string('driver_name')->nullable();
            $table->text('purpose');
            $table->text('destination');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('time')->nullable();
            $table->string('remarks')->nullable();
            $table->string('others')->nullable();
            $table->string('requested_by')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('recommending')->default(0);
            $table->tinyInteger('approval')->default(0);
            $table->tinyInteger('status_by')->unsigned()->nullable();
            $table->tinyInteger('recommending_by')->unsigned()->nullable();
            $table->tinyInteger('approval_by')->unsigned()->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_read')->default(0);
            $table->tinyInteger('is_printed')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
