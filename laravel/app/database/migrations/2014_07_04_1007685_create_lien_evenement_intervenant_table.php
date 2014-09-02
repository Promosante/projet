<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLienEvenementIntervenantTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lien_evenement_intervenant',function(Blueprint $table){
			$table->increments('id');
			$table->integer('evenement_id')->unsigned();
			$table->integer('intervenant_id')->unsigned();
			$table->timestamps();
		});
		
		Schema::table('lien_evenement_intervenant',function(Blueprint $table){
			$table->foreign('evenement_id')->references('id')->on('evenements');
			$table->foreign('intervenant_id')->references('id')->on('membres');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lien_evenement_intervenant');
	}

}
