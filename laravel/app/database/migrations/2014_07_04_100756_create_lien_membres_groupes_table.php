<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLienMembresGroupesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lien_membres_groupes',function(Blueprint $table){
			$table->increments('id');
			$table->integer('groupe_id')->nullable()->unsigned();
			$table->integer('membre_id')->nullable()->unsigned();
			$table->timestamps();
		});
		Schema::table('lien_membres_groupes',function(Blueprint $table){
			$table->foreign('groupe_id')->references('id')->on('groupes');
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
		Schema::drop('lien_membres_groupes');
	}

}