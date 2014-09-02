<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLienActiviteCategorieTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lien_activite_categories',function(Blueprint $table){
			$table->increments('id');
			$table->integer('activite_id')->unsigned();
			$table->integer('categorie_id')->unsigned();
			$table->timestamps();
		});
		Schema::table('lien_activite_categories',function(Blueprint $table){
				$table->foreign('categorie_id')->references('id')->on('categories_activite');
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
		Schema::drop('lien_activite_categories');
	}

}
