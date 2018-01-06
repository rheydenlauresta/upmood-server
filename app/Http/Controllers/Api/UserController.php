<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController as BaseController;
use App\RestModel\User;

class UserController extends BaseController
{

    public function search(Request $request)
    {
    	// VALIDATE REQUEST REQUIREMENTS

        $validator = $this->validator($request->all(), [
            'keyword' => 'required',
        ], 'search-user');

        if($validator['status'] == 422) return json_encode($validator);

        // SEARCH USER BY NAME OR EMAIL

        $user = User::search();

        if($user->toArray()['total'] <= 0){ $validator['status'] = (int) env('EMPTY_RESPONSE_CODE'); $validator['message'] = 'No Record Found'; }

        $validator['data'] = $user->toArray();

	    return json_encode($validator);

    }

}
