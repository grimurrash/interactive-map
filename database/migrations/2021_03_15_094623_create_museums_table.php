<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMuseumsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
    {
		Schema::create('museums', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('code');

			$table->string('name');
            $table->text('description');
            $table->unsignedInteger('typeId');
            $table->unsignedInteger('districtId');

            $table->double('Latitude');
            $table->double('Longitude');


            $table->string('website');

            $table->string('location');
            $table->string('phone');
            $table->string('address');
            $table->string('email');

            $table->string('directorFio');
            $table->string('directorPhone');
            $table->string('directorEmail');

            $table->string('founderFIO');
            $table->string('createDate');

            $table->foreign('typeId')->references('id')->on('museum_types')->onDelete('cascade');
            $table->foreign('districtId')->references('id')->on('districts')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
    {
		Schema::drop('museums');
	}

}
