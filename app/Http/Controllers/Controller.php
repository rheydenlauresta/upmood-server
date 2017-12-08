<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function validator($request, $rules)
    {
    	
    	$validate = Validator::make($request, $rules);

    	if(!$validate->fails()){

    		return [
    			'status' => 200,
				'module' => 'facebook-login',
				'errors' => [],
				'data'	 => [],
    		];

    	}

    	return [
			'status' => 422,
			'module' => 'facebook-login',
			'errors' => $validate->errors()->toArray(),
			'data'	 => [],
		];

    }

}
