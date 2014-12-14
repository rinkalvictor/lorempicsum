<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePicturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pictures', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('url');
			$table->string('large_url')->nullable();
			$table->integer('source_id')->nullable();
			$table->string('copyright', 20)->nullable();
			$table->string('site', 20)->nullable();
			$table->integer('width')->nullable();
			$table->integer('height')->nullable();
			$table->boolean('downloaded')->default(0);
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
		Schema::drop('pictures');
	}

}
