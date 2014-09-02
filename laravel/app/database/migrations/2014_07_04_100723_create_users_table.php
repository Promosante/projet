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
		Schema::create('users',function(Blueprint $table){
			$table->increments('id');
			$table->string('login')->unique();
			$table->string('password');
			$table->string('email_compte')->unique();
			$table->string('type_compte')->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();});
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
