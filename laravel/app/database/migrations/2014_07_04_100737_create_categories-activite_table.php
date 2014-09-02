<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesActiviteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories_activite',function(Blueprint $table){
			$table->increments('id');
			$table->integer('projet_id')->nullable()->unsigned();
			$table->string('predefini_ou_non')->nullable();
			$table->string('nom')->nullable();
			$table->string('descriptif')->nullable();
			$table->timestamps();
		});
		Schema::table('categories_activite',function(Blueprint $table){
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
		Schema::drop('categories_activite');
	}

}
