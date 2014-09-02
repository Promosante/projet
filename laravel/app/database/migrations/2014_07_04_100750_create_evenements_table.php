<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvenementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('evenements',function(Blueprint $table){
			$table->increments('id');
			$table->integer('periode_id')->nullable()->unsigned();
			$table->integer('lieu_id')->nullable()->unsigned();
			$table->string('nom')->nullable();
			$table->string('infos_pratique')->nullable();
			$table->dateTime('date_debut')->nullable();
			$table->dateTime('date_fin')->nullable();
			$table->timestamps();
		});
		
		Schema::table('evenements',function(Blueprint $table){
			$table->foreign('periode_id')->references('id')->on('periodes');
			$table->foreign('lieu_id')->references('id')->on('lieux');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('evenements');
	}

}
