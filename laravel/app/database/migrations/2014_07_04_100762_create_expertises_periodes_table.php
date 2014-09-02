<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertisesPeriodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('expertises_periodes',function(Blueprint $table){
			$table->increments('id');
			$table->integer('expertise_id')->nullable()->unsigned();
			$table->string('nom')->nullable();
			$table->date('date_debut')->nullable();
			$table->date('date_fin')->nullable();
			$table->timestamps();
		});

		Schema::table('expertises_periodes',function(Blueprint $table){
			$table->foreign('expertise_id')->references('id')->on('expertises');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('expertises_periodes');
	}

}