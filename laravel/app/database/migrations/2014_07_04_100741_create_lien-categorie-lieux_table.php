<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLienCategorieLieuxTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lien_categories_lieux',function(Blueprint $table){
			$table->increments('id');
			$table->integer('categorie_id')->unsigned();
			$table->integer('lieux_id')->unsigned();
			$table->timestamps();
		});
		
		Schema::table('lien_categories_lieux',function(Blueprint $table){
				$table->foreign('lieux_id')->references('id')->on('lieux');
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
		Schema::drop('lien_categories_lieux');
	}

}