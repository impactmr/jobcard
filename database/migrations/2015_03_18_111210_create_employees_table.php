<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */

        public function up()
        {
            Schema::create('employee', function(Blueprint $table) {
                $table->increments('employee_code');
                $table->string('first_name',60);
                $table->string('last_name',60);
                $table->timestamps();
            });

        }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('employee');
	}

}

