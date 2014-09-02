<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLienMembresSousGroupesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lien_membres_sous_groupes',function(Blueprint $table){
			$table->increments('id');
			$table->integer('sous_groupe_id')->nullable()->unsigned();
			$table->integer('membre_id')->nullable()->unsigned();
			$table->timestamps();
		});
		Schema::table('lien_membres_sous_groupes',function(Blueprint $table){
			$table->foreign('sous_groupe_id')->references('id')->on('sous_groupes');
			$table->foreign('membre_id')->references('id')->on('membres');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lien_membres_sous_groupes');
	}

}