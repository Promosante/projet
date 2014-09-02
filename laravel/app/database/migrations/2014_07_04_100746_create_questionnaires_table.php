<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionnairesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questionnaires',function(Blueprint $table){
			$table->increments('id');
			$table->integer('outil_id')->unsigned();
			$table->string('titre')->nullable();
			$table->timestamps();
		});
		
		Schema::table('questionnaires',function(Blueprint $table){
			$table->foreign('outil_id')->references('id')->on('outils');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('questionnaires');
	}

}
