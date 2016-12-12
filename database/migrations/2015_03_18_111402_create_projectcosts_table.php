<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectcostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	
        public function up()
        {
            Schema::create('projectcost', function(Blueprint $table) {
                $table->integer('fk1_project_code')->unsigned();
                $table->decimal('current_value',38,2)->nullable();
                $table->decimal('supplier_costs',38,2)->nullable();
                $table->decimal('target_profit',38,2)->nullable();
                $table->decimal('estimated_completion',38,2)->nullable();
                $table->timestamps();
            });

           Schema::table('projectcost', function(Blueprint $table) {
               $table->foreign('fk1_project_code')
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
		Schema::drop('projectcost');
	}

}

