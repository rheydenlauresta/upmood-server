<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Carbon\Carbon;
use App\RestModel\User;
use App\RestModel\Posts;

class PostCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        
    	// RANDOM USER ACCOUNT
        
    	for ($i=0; $i < 500; $i++) {

    		$data[] = [

				'user_id'    => User::all()->random()->id,
				'content'    => $faker->realText($maxNbChars = 100),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),

    		];

    	}

    	$user = Posts::insert($data);

    	echo 'Post Collection Seeder Success!';

    }
}
