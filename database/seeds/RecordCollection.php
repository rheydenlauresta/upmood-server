<?php

use Illuminate\Database\Seeder;
use App\RestModel\User, App\RestModel\Resources, App\RestModel\Records;
use Faker\Generator as Faker;
use Carbon\Carbon;

class RecordCollection extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

    	$type = ['automated', 'manual'];
        	
        for ($i=0; $i < 500; $i++) { 
        	
        	$data[] = [

				'type'            => $type[array_rand($type, 1)],
				'user_id'         => User::where('id','!=', 1)->inRandomOrder()->first()->id,
				'resources_id'    => Resources::where('type', 'emoji')->inRandomOrder()->first()->id,
				'heartbeat_count' => $faker->numberBetween(60,200),
				'created_at'      => Carbon::now(),
				'updated_at'      => Carbon::now(),

        	];

        }

        Records::insert($data);

        echo 'Record Collection Seeder Success!';

    }

}
