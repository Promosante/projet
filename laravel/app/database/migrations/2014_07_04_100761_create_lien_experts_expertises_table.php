<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLienExpertsExpertisesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lien_experts_expertises',function(Blueprint $table){
			$table->increments('id');
			$table->integer('membre_id')->nullable()->unsigned();
			$table->integer('expertise_id')->nullable()->unsigned();
			$table->timestamps();
		});

		Schema::table('lien_experts_expertises',function(Blueprint $table){
			$table->foreign('membre_id')->references('id')->on('membres');
			$table->foreign('expertise_id')->references('id')->on('expertises');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lien_experts_expertises');
	}

}