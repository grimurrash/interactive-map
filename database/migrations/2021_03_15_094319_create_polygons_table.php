<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolygonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
    {
		Schema::create('polygons', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('zonal');
			$table->unsignedInteger('districtId');
			$table->string('name');
			$table->string('color');
			$table->text('coordinates');

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
		Schema::drop('polygons');
	}

}
