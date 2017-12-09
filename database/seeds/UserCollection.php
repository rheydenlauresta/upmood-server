<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Carbon\Carbon;
use App\RestModel\User;

class UserCollection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

    	// ADMIN ACCOUNT

    	if(User::all()->count() <= 0){

	    	$data[] = [

				'facebook_id'     => null,
				'name'            => 'Taison Digital Ltd.',
				'gender'          => 'male',
				'age'             => $faker->numberBetween(15,30),
				'birthday'        => $faker->date($format = 'Y-m-d', $max = 'now'),
				'phonenumber'     => $faker->e164PhoneNumber,
				'image'           => 'default.png',
				'profile_post'    => null,
				'paid_emoji_set'  => null,
				'basic_emoji_set' => null,
				'password'        => bcrypt('111111'),
				'api_token'       => 'TaisonAPI-a0XbCZeTxi1zW9sU5Y2GoQf1M0G55m3JNPrHNH96JSJNpj2SOwaMUggW5V9U',
				'email'           => 'admin@upmood.com',
				'status'          => 0,
				'is_online'       => 0,
				'deleted'         => 0,
				'remember_token'  => str_random(60).uniqid(),
				'created_at'      => Carbon::now(),
				'updated_at'      => Carbon::now(),

			];

    	}

		// RANDOM USER ACCOUNT

		$gender = ['male', 'female'];
        
    	for ($i=0; $i < 500; $i++) {

			$gender = $gender[array_rand($gender, 1)];

    		$data[] = [

				'facebook_id'     => uniqid(),
				'name'            => $faker->name($gender),
				'gender'          => $gender,
				'age'             => $faker->numberBetween(15,30),
				'birthday'        => $faker->date($format = 'Y-m-d', $max = 'now'),
				'phonenumber'     => $faker->e164PhoneNumber,
				'image'           => 'default.png',
				'profile_post'    => null,
				'paid_emoji_set'  => null,
				'basic_emoji_set' => null,
				'password'        => bcrypt('111111'),
				'api_token'       => 'UpmoodUserAPI-'.str_random(60).uniqid(),
				'email'           => $faker->unique()->safeEmail,
				'status'          => 1,
				'is_online'       => 0,
				'deleted'         => 0,
				'remember_token'  => str_random(60).uniqid(),
				'created_at'      => Carbon::now(),
				'updated_at'      => Carbon::now(),

    		];

    	}

    	$user = User::insert($data);

    	echo 'User Collection Seeder Success!';

    }
}
