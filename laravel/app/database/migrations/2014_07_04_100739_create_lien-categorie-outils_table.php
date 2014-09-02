<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLienCategorieOutilsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lien_categories_outils',function(Blueprint $table){
			$table->increments('id');
			$table->integer('outil_id')->unsigned();
			$table->integer('categorie_id')->unsigned();
			$table->timestamps();
		});
		Schema::table('lien_categories_outils',function(Blueprint $table){
				$table->foreign('outil_id')->references('id')->on('outils');
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
		Schema::drop('lien_categories_outils');
	}

}
