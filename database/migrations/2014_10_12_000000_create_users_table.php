<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('fbid')->nullable();
			$table->bigInteger('gid')->nullable();
			$table->bigInteger('twid')->nullable();
			$table->bigInteger('gitid')->nullable();
			$table->string('username')->index()->unique();
			$table->string('name')->nullable();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('email')->index()->unique();
			$table->string('password', 60);
			$table->boolean('status')->default(0);
			$table->boolean('chat_status')->default(0);
			$table->enum('gender',array('M','F','N'));
			$table->date('dob')->nullable();
			$table->string('avatar')->nullable();
			$table->integer('country')->default(1);
			$table->string('url')->nullable();
			$table->string('fb_link')->nullable();
			$table->string('tw_link')->nullable();
			$table->string('insta_link')->nullable();
			$table->string('skype')->nullable();
			$table->string('phone')->nullable();
			$table->string('mobile')->nullable();
			$table->text('bio')->nullable()->nullable();
			$table->date('last_login');
			$table->boolean('verified')->default(0);
			$table->boolean('tour')->default(0);
			$table->rememberToken();
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
		Schema::drop('users');
	}

}
