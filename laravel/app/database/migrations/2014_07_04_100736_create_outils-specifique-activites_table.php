<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutilsSpecifiqueActivitesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('outils_specifique_activites',function(Blueprint $table){
			$table->increments('id');
			$table->integer('outils_id')->unsigned();
			$table->integer('activite_id')->unsigned();
			$table->timestamps();
		});
		Schema::table('outils_specifique_activites',function(Blueprint $table){
			$table->foreign('outils_id')->references('id')->on('outils');
			$table->foreign('activite_id')->references('id')->on('activites');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('outils_specifique_activites');
	}

}
