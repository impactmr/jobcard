<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjecthoursTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
        public function up()
        {
            Schema::create('projecthours', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('fk1_employee_code')->unsigned();
                $table->integer('fk2_project_code')->unsigned();
                $table->decimal('forecast_hours',38,2)->nullable();
                $table->decimal('budget_hours',38,2)->nullable();
                $table->nullableTimestamps();
            });

           Schema::table('projecthours', function(Blueprint $table) {
               $table->foreign('fk1_employee_code')
                        ->references('employee_code')
                        ->on('employee');

                $table->foreign('fk2_project_code')
                        ->references('project_code')
                        ->on('project');
           });

        }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('projecthours');
	}

}
