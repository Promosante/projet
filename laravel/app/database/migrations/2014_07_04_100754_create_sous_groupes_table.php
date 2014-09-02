<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSousGroupesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sous_groupes',function(Blueprint $table){
			$table->increments('id');
			$table->integer('groupe_id')->nullable()->unsigned();
			$table->text('nom')->nullable();
			$table->timestamps();
		});
		Schema::table('sous_groupes',function(Blueprint $table){
			$table->foreign('groupe_id')->references('id')->on('groupes');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('groupes');
	}

}