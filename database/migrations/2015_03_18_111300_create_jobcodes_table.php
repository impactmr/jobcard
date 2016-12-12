<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobcodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
        public function up()
        {
            Schema::create('jobcode', function(Blueprint $table) {
                $table->increments('job_code');
                $table->integer('fk1_job_level')->unsigned();
                $table->decimal('rate',38,2);
                $table->timestamp('start_date')->nullable();
                $table->nullableTimestamps();
            });

           Schema::table('jobcode', function(Blueprint $table) {
               $table->foreign('fk1_job_level')
                        ->references('job_level')
                        ->on('joblevel');   

           });

        }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('jobcode');
	}

}