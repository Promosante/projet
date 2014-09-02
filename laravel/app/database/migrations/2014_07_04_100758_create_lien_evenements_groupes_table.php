<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLienEvenementsGroupesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lien_evenements_groupes',function(Blueprint $table){
			$table->increments('id');
			$table->integer('evenement_id')->nullable()->unsigned();
			$table->integer('groupe_id')->nullable()->unsigned();
			$table->timestamps();
		});
		Schema::table('lien_evenements_groupes',function(Blueprint $table){
			$table->foreign('groupe_id')->references('id')->on('groupes');
			$table->foreign('evenement_id')->references('id')->on('evenements');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lien_evenements_groupes');
	}

}