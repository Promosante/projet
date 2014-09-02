<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications',function(Blueprint $table){
			$table->increments('id');
			$table->integer('source_id')->unsigned();
			$table->integer('dest_id')->unsigned();
			$table->string('type')->nullable();
			$table->string('contenu')->nullable();
			$table->string('read_or_not')->nullable();
			$table->string('message')->nullable();
			$table->timestamps();
		});
		
		Schema::table('notifications',function(Blueprint $table){
			$table->foreign('source_id')->references('id')->on('users');
			$table->foreign('dest_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notifications');
	}

}
