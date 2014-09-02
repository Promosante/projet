<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentairesProjetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('commentaires_projets',function(Blueprint $table){
			$table->increments('id');
			$table->integer('projet_id')->unsigned();
			$table->integer('source_id')->unsigned();
			$table->text('contenu')->nullable();
			$table->timestamps();
		});
		Schema::table('commentaires_projets',function(Blueprint $table){
			$table->foreign('projet_id')->references('id')->on('projets');
			$table->foreign('source_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('commentaires_projets');
	}

}