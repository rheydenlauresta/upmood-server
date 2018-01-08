<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController as BaseController;
use App\RestModel\Resources;

class ResourcesController extends BaseController
{
    
    public function resources($type = null, $mode = null, $set = null)
    {
    	
    	$res = Resources::collection($type, $mode, $set);

    	$grouped = $res->groupBy('type')->transform(function ($value) {
		    return $value->groupBy('set_name');
		});

		$data = [
			'status'  => (int) env('SUCCESS_RESPONSE_CODE'),
			'message' => 'success',
			'module'  => 'resources-list',
			'errors'  => (Object) [],
			'data'    => $grouped->toArray()
		];

		if($grouped->count() <= 0){ $data['status'] = (int) env('EMPTY_RESPONSE_CODE'); $data['message'] = 'No Record Found'; }

		return json_encode($data);

    }

}
