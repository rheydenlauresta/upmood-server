<?php

use Illuminate\Database\Seeder;
use App\RestModel\User, App\RestModel\Connection;
use Faker\Generator as Faker;
use Carbon\Carbon;

class ConnectionCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 30; $i++) {
        	
    		$user = User::where('id','!=', 1)->inRandomOrder()->first();
    		$friend = User::where('id','!=', 1)->where('id','!=', $user->id)->inRandomOrder()->first();

        	$data[] = [

				'user_id'    => $user->id,
				'friend_id'  => $friend->id,
				'status'     => $faker->numberBetween(0,1),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),

        	];

        }

        Connection::insert($data);

        echo 'Connection Collection Seeder Success!';
    }
}
