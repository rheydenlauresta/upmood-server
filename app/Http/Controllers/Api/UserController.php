<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RestModel\User;

class UserController extends Controller
{
    
    public function __construct()
    {

        $this->middleware('user-access');
        $this->middleware('account-status');

    }

    public function search(Request $request)
    {
    	// VALIDATE REQUEST REQUIREMENTS

        $validator = $this->validator($request->all(), [
            'keyword' => 'required',
        ], 'search-user');

        if($validator['status'] == 422) return json_encode($validator);

        // SEARCH USER BY NAME OR EMAIL

        $user = User::search();

        if($user->toArray()['total'] <= 0){ $validator['status'] = (int) env('EMPTY_RESPONSE_CODE'); $validator['messagge'] = 'No Record Found'; }

        $validator['data'] = $user->toArray();

	    return json_encode($validator);

    }



}
