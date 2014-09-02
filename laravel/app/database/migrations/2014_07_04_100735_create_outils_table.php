<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutilsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('outils',function(Blueprint $table){
			$table->increments('id');
			$table->integer('projet_id')->unsigned();
			$table->string('nom');
			$table->timestamps();
		});
		Schema::table('outils',function(Blueprint $table){
			$table->foreign('projet_id')->references('id')->on('projets');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('outils');
	}

}
