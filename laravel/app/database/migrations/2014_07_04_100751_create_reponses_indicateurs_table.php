<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReponsesIndicateursTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reponses_indicateurs',function(Blueprint $table){
			$table->increments('id');
			$table->integer('indicateur_id')->unsigned();
			$table->text('contenu')->nullable();
			$table->text('type')->nullable();
			$table->timestamps();
		});
		Schema::table('reponses_indicateurs',function(Blueprint $table){
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
		Schema::drop('reponses_indicateurs');
	}

}