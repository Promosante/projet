<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministrateursTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('administrateurs',function(Blueprint $table){
			$table->increments('id');
			$table->integer('compte_id')->unsigned();
			$table->text('nom')->nullable();
			$table->timestamps();
		});

		Schema::table('administrateurs',function(Blueprint $table){
			$table->foreign('compte_id')->references('id')->on('users');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('administrateurs');
	}

}