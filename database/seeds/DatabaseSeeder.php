<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\project;
use App\projectcost;
use App\projecthours;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{       
                
		Model::unguard();

		$this->call('projectseeder');
                $this->call('projecthourseeder');
                $this->call('projectcostseeder');
                $this->call('timesheethoursSeeder');
	}

}
