<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class AuthenticateController extends Controller
{

    public function login(Request $request, $type)
    {
        $this->$type($request);
    }

    public function facebook($request)
    {
        $validator = $this->validator($request->all(), [
            'facebook_id' => 'required',
            'name'        => 'required',
            'email'       => 'required|email',
        ]);

        if($validator['status'] == 422) return json_encode($validator);

        // CHECK OR CREATE USER BASED ON FACEBOOK_ID

        $user = User::firstOrCreate(
            ['facebook_id' => request('facebook_id')],
            [
                'facebook_id'     => request('facebook_id'),
                'name'            => request('name'),
                'gender'          => request('gender'),
                'age'             => request('age'),
                'birthday'        => request('birthday'),
                'phonenumber'     => request('phonenumber'),
                'image'           => 'default.png',
                'profile_post'    => null,
                'paid_emoji_set'  => null,
                'basic_emoji_set' => null,
                'api_token'       => 'UpmoodUserAPI-'.str_random(60).uniqid(),
                'email'           => request('email'),
                'status'          => request('status'),
                'is_online'       => request('is_online'),
                'deleted'         => request('deleted')
            ]
        );

        // UPDATE OR INSERT INFORMATION FOR USER

        dd($user->toArray());
    }

    public function local()
    {
        
    }

}
