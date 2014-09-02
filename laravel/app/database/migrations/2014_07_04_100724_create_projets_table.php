<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projets',function(Blueprint $table){
			$table->increments('id');
			$table->integer('createur_id')->unsigned();
			$table->string('titre')->nullable();
			$table->string('acronyme')->nullable();
			$table->text('objectif')->nullable();
			$table->text('objectif_specifique')->nullable();
			$table->string('population_cible')->nullable();
			$table->date('date_debut')->nullable();
			$table->date('date_fin')->nullable();
			$table->string('status_createur')->nullable();
			$table->timestamps();
		});
		Schema::table('projets',function(Blueprint $table){
			$table->foreign('createur_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{	
        Schema::drop('projets');
	}

}
