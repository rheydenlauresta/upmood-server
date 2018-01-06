<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController as BaseController;
use App\RestModel\User;

class ConnectionController extends BaseController
{

    public function connection(Request $request, $type = null)
    {

    	if(!$type) return $this->connectionList();

    	// VALIDATE REQUEST REQUIREMENTS

        $validator = $this->validator($request->all(), [
            'id' => 'required|integer',
        ], 'connect-user');

        if($validator['status'] == 422) return json_encode($validator);

        // CHECK IF ID IS EXISTING THEN CONTINUE PROCCESS

        $user = User::checkUser($type);

        if(!$user['status']){ $validator['status'] = (int) env('EMPTY_RESPONSE_CODE'); $validator['message'] = $user['message']; }

        if($user['status']){ $validator['data'] = $user['data']; }

        return json_encode($validator);

    }

    public function connectionList()
    {
    	$connection = User::find(request()->user()->id)->connections()->simplePaginate(20);

    	$data = [];

    	if($connection->items()){
    		$data['status'] = 200;
    		$data['message'] = 'success';
    	}else{
    		$data['status'] = 204;
    		$data['message'] = 'No Record Found';
    	}

    	$data['errors'] = [];
    	$data['data'] = $connection->toArray();

    	return json_encode($data);

    }

}
