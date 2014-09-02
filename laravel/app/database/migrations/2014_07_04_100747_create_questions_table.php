<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions',function(Blueprint $table){
			$table->increments('id');
			$table->integer('questionnaire_id')->unsigned();
			$table->text('question')->nullable();
			$table->timestamps();
		});
		
		Schema::table('questions',function(Blueprint $table){
			$table->foreign('questionnaire_id')->references('id')->on('questionnaires');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('questions');
	}

}
