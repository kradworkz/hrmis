<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('travel_id')->unsigned();
            $table->foreign('travel_id')->references('id')->on('travels')->onUpdate('cascade')->onDelete('cascade');
            $table->string('filename');
            $table->string('title');
            $table->string('document_path');
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
        Schema::dropIfExists('travel_documents');
    }
}
