<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController as BaseController;
use App\RestModel\User;

class AuthenticateController extends BaseController
{

    public function __construct()
    {

    }

    public function login(Request $request, $type)
    {
        return $this->$type($request);
    }

    public function facebook($request)
    {

        // VALIDATE REQUEST REQUIREMENTS

        $validator = $this->validator($request->all(), [
            'facebook_id' => 'required',
            'name'        => 'required',
            'email'       => 'required|email',
            'image'       => 'required',
        ], 'facebook-login');

        if($validator['status'] == 422) return json_encode($validator);

        // CHECK OR CREATE USER BASED ON FACEBOOK_ID

        $user = User::update_create_user();

        $validator['data'] = $user->toArray();

        return json_encode($validator);

    }

    public function local()
    {
        
        return json_encode([

            'status'   => (int) env('NOT_IMPLEMENTED'),
            'messagge' => 'module_not_implemented',
            'module'   => 'local-login',
            'errors'   => (Object) [],
            'data'     => (Object) [],

        ]);

    }

}
