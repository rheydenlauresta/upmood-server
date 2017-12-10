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

    public function validator($request, $rules, $module)
    {
    	
    	$validate = Validator::make($request, $rules);

    	if(!$validate->fails()){

    		return [
                'status'   => (int) env('SUCCESS_RESPONSE_CODE'),
                'message' => 'success',
                'module'   => $module,
                'errors'   => [],
                'data'     => [],
    		];

    	}

    	return [
            'status'   => (int) env('VALIDATION_ERROR_RESPONSE_CODE'),
            'message' => 'validation_error',
            'module'   => $module,
            'errors'   => $validate->errors()->toArray(),
            'data'     => [],
		];

    }

}
