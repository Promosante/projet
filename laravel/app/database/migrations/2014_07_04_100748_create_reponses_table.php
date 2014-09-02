<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReponsesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reponses',function(Blueprint $table){
			$table->increments('id');
			$table->integer('question_id')->unsigned();
			$table->text('reponse')->nullable();
			$table->timestamps();
		});
		
		Schema::table('reponses',function(Blueprint $table){
			$table->foreign('question_id')->references('id')->on('questions');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reponses');
	}

}
