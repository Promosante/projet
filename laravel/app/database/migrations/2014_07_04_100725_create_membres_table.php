<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembresTable extends Migration {
 
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('membres',function(Blueprint $table){
			$table->increments('id');
			$table->integer('user_id')->nullable()->unsigned();
			$table->string('nom')->nullable();
			$table->string('prenom')->nullable();
			$table->string('structure')->nullable();
			$table->string('fonction')->nullable();
			$table->date('date_naissance')->nullable();
			$table->string('adresse')->nullable();
			$table->integer('codepostal')->nullable();
			$table->string('ville')->nullable();
			$table->string('pays')->nullable();
			$table->string('email_membre')->nullable();
			$table->timestamps();
		});
		Schema::table('membres',function(Blueprint $table){
			$table->foreign('user_id')->references('id')->on('users');
		});
	}
	

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('membres');
	}

}
