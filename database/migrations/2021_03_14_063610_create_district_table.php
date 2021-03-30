<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
    {
        Schema::create('districts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('shortName');
            $table->string('name');
            $table->double('Latitude')->nullable();
            $table->double('Longitude')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
    {
		//
	}

}
