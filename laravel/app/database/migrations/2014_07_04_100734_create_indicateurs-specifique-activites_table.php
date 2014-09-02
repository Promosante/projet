<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndicateursSpecifiqueActivitesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('indicateurs_specifique_activites',function(Blueprint $table){
			$table->increments('id');
			$table->integer('indicateur_id')->unsigned();
			$table->integer('activite_id')->unsigned();
			$table->timestamps();
		});
		Schema::table('indicateurs_specifique_activites',function(Blueprint $table){
			$table->foreign('indicateur_id')->references('id')->on('indicateurs');
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
		Schema::drop('indicateurs_specifique_activites');
	}

}
