<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJoblevelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */

        public function up()
        {
            Schema::create('joblevel', function(Blueprint $table) {
                $table->increments('job_level');
                $table->string('description',80);
                $table->nullableTimestamps();
            });

        }
        

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('joblevel');
	}

}

