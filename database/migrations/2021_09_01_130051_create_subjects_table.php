<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->text('description');
            $table->unsignedInteger('typeId');
            $table->unsignedInteger('districtId');

            $table->double('Latitude');
            $table->double('Longitude');
            $table->string('address');

            $table->string('website');
            $table->string('video');

            $table->string('founderFIO');
            $table->string('createDate');

            $table->foreign('typeId')->references('id')->on('subject_types')->onDelete('cascade');
            $table->foreign('districtId')->references('id')->on('districts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}
