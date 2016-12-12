<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeejobcodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
        
        public function up()
        {
            Schema::create('employeejobcode', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('fk1_employee_code')->unsigned();
                $table->integer('fk2_job_code')->unsigned();
                $table->timestamp('start_date')->nullable();
                $table->nullableTimestamps();
            });

           Schema::table('employeejobcode', function(Blueprint $table) {
               $table->foreign('fk1_employee_code')
                            ->references('employee_code')
                            ->on('employee');
                    
                $table->foreign('fk2_job_code')
                        ->references('job_code')
                        ->on('jobcode');

           });

        }
        
        

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('employeejobcode');
	}

}

