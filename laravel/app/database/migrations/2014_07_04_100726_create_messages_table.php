<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages',function(Blueprint $table){
			$table->increments('id');
			$table->integer('source_id')->unsigned();
			$table->integer('dest_id')->unsigned();
			$table->string('source_login')->nullable();
			$table->string('dest_login')->nullable();
			$table->string('sujet')->nullable();
			$table->text('contenu')->nullable();
			$table->string('source_id_status')->nullable();
			$table->string('dest_id_status')->nullable();
			$table->timestamps();
		});
		
		Schema::table('messages',function(Blueprint $table){
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
		Schema::drop('messages');
	}

}
