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
        	
			$user_id   = User::where('id','!=', 1)->inRandomOrder()->first();
			$friend_id = User::where('id','!=', 1)->where('id','!=', $user_id)->inRandomOrder()->first();

    		$typeId = [1,2,4];
    		$typeId = $typeId[array_rand($typeId, 1)];

    		if($typeId == 1){

    			$content = [
					'module'       => 'Push Notification',
					'type'         => 'Connect Request',
					'type_id'      => 1,
					'request_from' => [
						'user_id'    => $friend_id->id,
						'user_name'  => $friend_id->name,
						'user_image' => $friend_id->image,
					],
					'request_to'   => [
						'user_id'   => $user_id->id,
						'user_name' => $user_id->name,
					]
				];

    		}else if($typeId == 2){

    			$content = [
					'module'       => 'Push Notification',
					'type'         => 'Approved Request',
					'type_id'      => 1,
					'request_from' => [
						'user_id'    => $friend_id->id,
						'user_name'  => $friend_id->name,
						'user_image' => $friend_id->image,
					],
					'request_to'   => [
						'user_id'   => $user_id->id,
						'user_name' => $user_id->name,
					]
				];

    		}else if($typeId == 4){

    			$reaction = Resources::where('type', 'sticker')->inRandomOrder()->first();
				$emoji    = Resources::where('type', 'emoji')->inRandomOrder()->first();

    			$content = [
					'module'       => 'Push Notification',
	                'type'         => 'Reaction Send',
	                'type_id'      => 4,
	                'heartbeat'    => $faker->numberBetween(60,200),
	                'post'         => $faker->realText($maxNbChars = 100),
	                'emoji'        => [
						'emoji_id'    => $emoji->id,
						'emoji_pathh' => $emoji->type.'/'.$emoji->set_name.'/'.$emoji->filename
	                ],
	                'reaction'     => [
						'reaction_id'   => $reaction->id,
						'reaction_path' => $reaction->type.'/'.$reaction->set_name.'/'.$reaction->filename
	                ],
	                'request_from' => [
						'user_id'    => $friend_id->id,
						'user_name'  => $friend_id->name,
						'user_image' => $friend_id->image,
	                ],
	                'request_to'   => [
						'user_id'   => $user_id->id,
						'user_name' => $user_id->name,
	                ]
				];

    		}

        	$data[] = [

				'user_id'    => $user_id->id,
				'friend_id'  => $friend_id->id,
				'type_id'    => $typeId,
				'content'    => json_encode($content),
				'seen'       => 0,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),

        	];

        }

        Notification::insert($data);

        echo 'Notification Collection Seeder Success!';

    }
}
