<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('periodes',function(Blueprint $table){
			$table->increments('id');
			$table->integer('activite_id')->unsigned();
			$table->string('nom')->nullable();
			$table->date('date_debut')->nullable();
			$table->date('date_fin')->nullable();
			$table->timestamps();
		});
		
		Schema::table('periodes',function(Blueprint $table){
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
		Schema::drop('periodes');
	}

}
