<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveToComicStripsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('comic_strips', function(Blueprint $table)
		{
			$table->enum('active', ['Y','N'])->default('Y');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('comic_strips', function(Blueprint $table)
		{
      $table->dropColumn('active');
		});
	}

}
