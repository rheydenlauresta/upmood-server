<?php

use Illuminate\Database\Seeder;
use App\RestModel\User, App\RestModel\Notification, App\RestModel\Resources;
use Faker\Generator as Faker;
use Carbon\Carbon;

class NotiCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(Faker $faker)
    {

        for ($i=0; $i < 500; $i++) {
        	
    		$user_id = User::where('id','!=', 1)->inRandomOrder()->first();
    		$friend_id = User::where('id','!=', 1)->where('id','!=', $user_id)->inRandomOrder()->first();

        	$data[] = [

				'user_id'    => $user_id->id,
				'friend_id'  => $friend_id->id,
				'type_id'    => 4,
				'content'    => json_encode([
	                'type'         => 'Reaction Send',
	                'type_id'      => 4,
	                'heartbeat'    => $faker->numberBetween(60,200),
	                'post'         => $faker->realText($maxNbChars = 100),
	                'emoji'        => Resources::where('type', 'emoji')->inRandomOrder()->first()->id,
	                'reaction'     => Resources::where('type', 'sticker')->inRandomOrder()->first()->id,
	                'request_from' => [
	                    'user_id' => $user_id->id,
	                    'user_name' => $user_id->name,
	                    'user_image' => $user_id->image,
	                ],
	                'request_to'   => [
	                    'user_id' => $friend_id->id,
	                    'user_name' => $friend_id->name,
	                ]
				]),
				'seen'       => 0,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),

        	];

        }

        Notification::insert($data);

        echo 'Notification Collection Seeder Success!';

    }
}
