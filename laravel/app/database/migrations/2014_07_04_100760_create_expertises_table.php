<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertisesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('expertises',function(Blueprint $table){
			$table->increments('id');
			$table->integer('projet_id')->nullable()->unsigned();
			$table->string('niveau_exp')->nullable();
			$table->string('periode_exp')->nullable();
			$table->string('quant_part')->nullable();
			$table->string('quant_real')->nullable();
			$table->string('qual_part')->nullable();
			$table->string('qual_real')->nullable();
			$table->timestamps();
		});
		Schema::table('expertises',function(Blueprint $table){
			$table->foreign('projet_id')->references('id')->on('projets');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('expertises');
	}

}