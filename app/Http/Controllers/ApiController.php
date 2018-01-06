<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Validator;

class ApiController extends Controller
{
	
    public function validator($request, $rules, $module)
    {
    	
    	$validate = Validator::make($request, $rules);

    	if(!$validate->fails()){

    		return [
                'status'   => (int) env('SUCCESS_RESPONSE_CODE'),
                'message' => 'success',
                'module'   => $module,
                'errors'   => (Object) [],
                'data'     => (Object) [],
    		];

    	}

    	return [
            'status'   => (int) env('VALIDATION_ERROR_RESPONSE_CODE'),
            'message' => 'validation_error',
            'module'   => $module,
            'errors'   => $validate->errors()->toArray(),
            'data'     => (Object) [],
		];

    }

    public function methodCheck($defined, $required, $module)
    {
        
        if(!in_array($defined, $required)) return [
            'status'  => (int) env('EMPTY_RESPONSE_CODE'),
            'message' => 'invalid value',
            'module'  => $module,
            'errors'  => (Object) [],
            'data'    => (Object) []
        ];

        return [
            'status'  => (int) env('SUCCESS_RESPONSE_CODE'),
            'message' => 'success',
            'module'  => $module,
            'errors'  => (Object) [],
            'data'    => (Object) []
        ];

    }

}
