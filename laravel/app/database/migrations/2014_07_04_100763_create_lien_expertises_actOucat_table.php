<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLienExpertisesactOuCatTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lien_expertises_actoucat',function(Blueprint $table){
			$table->increments('id');
			$table->integer('activite_id')->nullable()->unsigned();
			$table->integer('categorie_id')->nullable()->unsigned();
			$table->integer('expertise_id')->nullable()->unsigned();
			$table->timestamps();
		});

		Schema::table('lien_expertises_actoucat',function(Blueprint $table){
			$table->foreign('activite_id')->references('id')->on('activites');
			$table->foreign('categorie_id')->references('id')->on('categories_activite');
			$table->foreign('expertise_id')->references('id')->on('expertises');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lien_expertises_actoucat');
	}

}