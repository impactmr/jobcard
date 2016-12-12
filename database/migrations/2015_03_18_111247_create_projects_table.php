<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
        
        public function up()
        {
            Schema::create('project', function(Blueprint $table) {
                $table->increments('project_code');
                $table->string('name', 150);
                $table->string('client',60);
                $table->string('project_manager',60);
                $table->date('proposal_date');
                $table->date('won_date');
                $table->string('sector',60);
                $table->integer('adhoc');
                $table->integer('quant')->nullable();
                $table->integer('qual')->nullable();
                $table->integer('time_only')->nullable();
                $table->integer('tracking')->nullable();
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
		Schema::drop('project');
	}

}