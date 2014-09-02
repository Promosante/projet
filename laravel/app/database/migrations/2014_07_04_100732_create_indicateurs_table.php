<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndicateursTable extends Migration {

	/**
	 * Run the migrations. 
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('indicateurs',function(Blueprint $table){
			$table->increments('id');
			$table->integer('projet_id')->unsigned();
			$table->string('nom')->nullable();
			$table->string('predefini_ou_non')->nullable();
			$table->string('declinaison')->nullable();
			$table->string('domaine')->nullable();
			$table->string('destinataire')->nullable(); 
			$table->string('question')->nullable();
			$table->timestamps();
		});
		Schema::table('indicateurs',function(Blueprint $table){
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
		Schema::drop('indicateurs');
	}

}
