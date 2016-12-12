<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\projecthours;

class projecthourseeder extends Seeder {
    
    public function run(){
        
        $faker = Faker::create();
        
        foreach(range(1,2) as $index){
            
            projecthours::create([
                
                'fk1_employee_code' => $faker->numberbetween(1,4),
                'fk2_project_code' => $faker->numberBetween(1,2),
                'forecast_hours'=> $faker->numberBetween(10,50),
                'budget_hours'=> $faker->numberBetween(10,50),            
            ]);
            
        }
        
    }
}