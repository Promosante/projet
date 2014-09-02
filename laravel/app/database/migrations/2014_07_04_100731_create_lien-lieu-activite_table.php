<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLienLieuActiviteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lien_lieu_activite',function(Blueprint $table){
			$table->increments('id');
			$table->integer('lieu_id')->unsigned();
			$table->integer('activite_id')->unsigned();
			$table->timestamps();
		});
		Schema::table('lien_lieu_activite',function(Blueprint $table){
			$table->foreign('lieu_id')->references('id')->on('lieux');
			$table->foreign('activite_id')->references('id')->on('activites');;
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lien_lieu_activite');
	}

}
