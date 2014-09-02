<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLienProjetsMembresTable extends Migration {
 
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lien_projets_membres',function(Blueprint $table){
			$table->increments('id');
			$table->integer('projet_id')->nullable()->unsigned();
			$table->integer('membre_id')->nullable()->unsigned();
			$table->timestamps();
		});
		Schema::table('lien_projets_membres',function(Blueprint $table){
			$table->foreign('projet_id')->references('id')->on('projets');
			$table->foreign('membre_id')->references('id')->on('membres');
		});
	}
	

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lien_projets_membres');
	}

}
