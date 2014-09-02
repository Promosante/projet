<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultatsExpertiseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('resultats_expertise',function(Blueprint $table){
			$table->increments('id');
			$table->integer('projet_id')->nullable()->unsigned();
			$table->integer('expertise_id')->nullable()->unsigned();
			$table->integer('periode_id')->nullable()->unsigned();
			$table->integer('activite_id')->nullable()->unsigned();
			$table->integer('expert_id')->nullable()->unsigned();
			$table->text('note_quant_part')->nullable();
			$table->text('note_qual_part')->nullable();
			$table->text('note_quant_real')->nullable();
			$table->text('note_qual_real')->nullable();
			$table->timestamps();
		});

		Schema::table('resultats_expertise',function(Blueprint $table){
			$table->foreign('expertise_id')->references('id')->on('expertises');
			$table->foreign('projet_id')->references('id')->on('projets');
			$table->foreign('periode_id')->references('id')->on('expertises_periodes');
			$table->foreign('activite_id')->references('id')->on('activites');
			$table->foreign('expert_id')->references('id')->on('membres');
		});
	}
 
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('resultats_expertise');
	}

}