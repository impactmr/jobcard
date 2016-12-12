<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\timesheethours;

class timesheethoursSeeder extends Seeder {
    
    public function run(){
        
        $faker = Faker::create();
        
        foreach(range(1,10) as $index){
            
            timesheethours::create([
                
                
                'input_date' => $faker->dateTimeBetween($startDate = 'now', $endDate = 'now'),
                'fk1_employee_code' => $faker->numberBetween(1,4),
                'fk2_project_code' => $faker->numberBetween(1,2),
                'worked_hours' => $faker->numberBetween(1,50)

            ]);
            
        }
        
    }
}