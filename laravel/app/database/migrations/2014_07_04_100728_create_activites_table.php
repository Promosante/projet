<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitesTable extends Migration {

	/**
	 * Run the migrations.
	 * 
	 * @return void
	 */
	public function up()
	{
		Schema::create('activites',function(Blueprint $table){
			$table->increments('id');
			$table->integer('projet_id')->unsigned();
			$table->string('nom')->nullable();
			$table->text('objectif')->nullable();
			$table->date('date_debut')->nullable();
			$table->date('date_fin')->nullable();
			$table->timestamps();});
	
	Schema::table('activites',function(Blueprint $table){
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
		Schema::drop('activites');
	}

}
