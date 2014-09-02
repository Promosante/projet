<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLienMembresActivitesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lien_membres_activites',function(Blueprint $table){
			$table->increments('id');
			$table->integer('membre_id')->unsigned();
			$table->integer('activite_id')->nullable()->unsigned();
			$table->string('membre_status_pour_activite');
			$table->timestamps();
		});
		
		Schema::table('lien_membres_activites',function(Blueprint $table){
			$table->foreign('membre_id')->references('id')->on('membres');
			$table->foreign('activite_id')->references('id')->on('activites');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lien_membres_activites');
	}

}
