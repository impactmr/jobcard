<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\project;

class projectseeder extends Seeder {
    
    public function run(){
        
        $faker = Faker::create();
        
        foreach(range(1,2) as $index){
            
            project::create([
                
                'client' => $faker->company(),
                'name' => $faker->sentence(1),
                'project_manager' => $faker->name(),
                'proposal_date' => $faker->dateTimeBetween($startDate = 'now', $endDate = 'now'),
                'won_date' => $faker->dateTimeBetween($startDate = 'now', $endDate = 'now'),
                'sector'=>$faker->sentence(1),
                'adhoc'=>$faker->numberBetween(0,1),
                'quant' =>$faker->numberBetween(0,1),
                'qual' => $faker->numberBetween(0,1),
                'time_only'=> $faker->numberBetween(0,1),
                'tracking' => $faker->numberBetween(0,1)              
            ]);
            
        }
        
    }
}