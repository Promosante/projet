<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLienCategoriesMembresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lien_categories_membres',function(Blueprint $table){
			$table->increments('id');
			$table->integer('membre_id')->unsigned();
			$table->integer('categorie_id')->unsigned();
			$table->string('membre_status_pour_future_activite');
			$table->timestamps();
		});
		
		Schema::table('lien_categories_membres',function(Blueprint $table){
			$table->foreign('membre_id')->references('id')->on('membres');
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
		Schema::drop('lien_categories_membres');
	}

}
