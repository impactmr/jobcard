<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimesheethoursTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	 public function up()
        {
            Schema::create('timesheethours', function(Blueprint $table) {
                $table->increments('id');
                $table->date('input_date');
                $table->integer('fk1_employee_code')->unsigned();
                $table->integer('fk2_project_code')->unsigned();
                $table->decimal('worked_hours',38,2)->nullable();
                $table->timestamps();
            });

           Schema::table('timesheethours', function(Blueprint $table) {
                $table->foreign('fk2_project_code')
                        ->references('project_code')
                        ->on('project');
                
                $table->foreign('fk1_employee_code')
                       ->references('employee_code')
                       ->on('employee');
           });

        }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('timesheethours');
	}

}
