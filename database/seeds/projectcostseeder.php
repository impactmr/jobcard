<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\projectcost;

class projectcostseeder extends Seeder {
    
    public function run(){
        
        $faker = Faker::create();
        
        foreach(range(1,2) as $index){
            
            projectcost::create([
                
                'fk1_project_code' => $faker->numberBetween(1,2),
                'current_value' => $faker->numberBetween(5000,20000),
                'supplier_costs'=> $faker->numberBetween(1000,6000),
                'target_profit'=> $faker->randomFloat(2,0,1),  
                'estimated_completion'=> $faker->randomFloat(2,0,1)
            ]);
            
        }
        
    }
}

