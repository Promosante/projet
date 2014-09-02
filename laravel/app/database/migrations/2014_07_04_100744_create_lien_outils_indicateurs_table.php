<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLienOutilsIndicateursTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lien_outils_indicateurs',function(Blueprint $table){
			$table->increments('id');
			$table->integer('outil_id')->unsigned();
			$table->integer('indicateur_id')->unsigned();
			$table->timestamps();
		});
		
		Schema::table('lien_outils_indicateurs',function(Blueprint $table){
			$table->foreign('outil_id')->references('id')->on('outils');
			$table->foreign('indicateur_id')->references('id')->on('indicateurs');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lien_outils_indicateurs');
	}

}
