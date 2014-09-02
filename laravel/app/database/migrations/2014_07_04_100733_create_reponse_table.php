<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReponseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reponse_indic',function(Blueprint $table){
			$table->increments('id');
			$table->integer('indicateur_id')->unsigned();
			$table->string('contenu')->nullable();
			$table->timestamps();
		});
		Schema::table('reponse_indic',function(Blueprint $table){
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
		Schema::drop('reponse_indic');
	}

}
