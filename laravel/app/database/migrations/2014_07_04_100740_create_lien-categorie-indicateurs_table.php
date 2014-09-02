<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLienCategorieIndicateursTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lien_categories_indicateurs',function(Blueprint $table){
			$table->increments('id');
			$table->integer('indicateur_id')->unsigned();
			$table->integer('categorie_id')->unsigned();
			$table->timestamps();
		});
		Schema::table('lien_categories_indicateurs',function(Blueprint $table){
				$table->foreign('indicateur_id')->references('id')->on('indicateurs');
				$table->foreign('categorie_id')->references('id')->on('categories_activite');
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lien_categories_indicateurs');
	}

}