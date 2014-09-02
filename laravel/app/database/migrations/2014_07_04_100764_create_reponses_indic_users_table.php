<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReponsesIndicUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reponses_indic_users',function(Blueprint $table){
			$table->increments('id');
			$table->integer('evenement_id')->nullable()->unsigned();
			$table->integer('membre_id')->nullable()->unsigned();
			$table->integer('reponse_indic_id')->nullable()->unsigned();
			$table->string('contenu');
			$table->timestamps();
		});

		Schema::table('reponses_indic_users',function(Blueprint $table){
			$table->foreign('evenement_id')->references('id')->on('evenements');
			$table->foreign('membre_id')->references('id')->on('membres');
			$table->foreign('reponse_indic_id')->references('id')->on('reponses_indicateurs');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reponses_indic_users');
	}

} 