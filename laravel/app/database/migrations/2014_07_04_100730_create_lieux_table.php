<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLieuxTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lieux',function(Blueprint $table){
			$table->increments('id');
			$table->integer('projet_id')->unsigned();
			$table->string('nom')->nullable();
			$table->string('adresse')->nullable();
			$table->string('ville')->nullable();
			$table->string('code_postal')->nullable();
			$table->text('ressources_humaines')->nullable();
			$table->text('ressources_materielles')->nullable();
			$table->string('telephone')->nullable();
			$table->timestamps();
		});
		Schema::table('lieux',function(Blueprint $table){
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
		Schema::drop('lieux');
	}

}
