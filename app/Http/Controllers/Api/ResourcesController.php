<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RestModel\Resources;

class ResourcesController extends Controller
{
    
    public function resources($type = null, $mode = null, $set = null)
    {
    	
    	$res = Resources::collection($type, $mode, $set);

    	$grouped = $res->groupBy('type')->transform(function ($value) {
		    return $value->groupBy('set_name');
		});

		$data = [
			'status' => (int) env('SUCCESS_RESPONSE_CODE'),
			'message' => 'success',
			'module'	=> 'resources-list',
			'errors' => [],
			'data'	=> $grouped->toArray()
		];

		if($grouped->count() <= 0){ $data['status'] = (int) env('EMPTY_RESPONSE_CODE'); $data['message'] = 'No Record Found'; }

		return json_encode($data);

    }

}
