<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groupes',function(Blueprint $table){
			$table->increments('id');
			$table->integer('projet_id')->nullable()->unsigned();
			$table->text('nom')->nullable();
			$table->timestamps();
		});
		Schema::table('groupes',function(Blueprint $table){
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
		Schema::drop('groupes');
	}

}