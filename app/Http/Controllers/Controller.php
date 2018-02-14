<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;
use Crypt;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function get_store($data,$model)
    {
        $model = new $model($data);

        $res = $model->save();
        
        if($res){
            $response = json_encode(['status'=>true,'response'=>'Saving was successful!']);

        }else{
            $response = json_encode(['status'=>false,'response'=>'Saving Failed!']);

        }

        return $response;
    }

    public function get_update($data,$model)
    {
        $data['id'] = Crypt::decrypt($data['id']);

        $model  = new $model($data);

        $res = $model->find($data['id'])->update($data);

        if($res){
            // 
            $response = json_encode(['status'=>true,'response'=>'Saving was successful!']);

        }else{
            $response = json_encode(['status'=>false,'response'=>'Saving Failed!']);

        }

        return $response;
    }

    public function get_destroy($form_data)
    {
        $data = array();
        foreach ($form_data['data'] as $key => $value) {
            array_push($data, Crypt::decrypt($value));
        }

        $res = DB::table($this->table)
                        ->whereIn('id',$data)
                        ->update(['deleted_at'=>date('Y-m-d H:i:s')]);

        if($res){ echo 'deleted'; }

    }

    public function methodCheckCms($defined, $required)
    {
        
        if(!in_array($defined, $required)) return [
            'status'  => (int) env('EMPTY_RESPONSE_CODE'),
            'message' => 'invalid value',
            'errors'  => (Object) [],
            'data'    => (Object) []
        ];

        return [
            'status'  => (int) env('SUCCESS_RESPONSE_CODE'),
            'message' => 'success',
            'errors'  => (Object) [],
            'data'    => (Object) []
        ];

    }

    public function validatorCms($request, $rules)
    {
    	
    	$validate = Validator::make($request, $rules);

    	if(!$validate->fails()){

    		return [
                'status'   => (int) env('SUCCESS_RESPONSE_CODE'),
                'message' => 'success',
                'errors'   => (Object) [],
                'data'     => (Object) [],
    		];

    	}

    	return [
            'status'   => (int) env('VALIDATION_ERROR_RESPONSE_CODE'),
            'message' => 'validation_error',
            'errors'   => $validate->errors()->toArray(),
            'data'     => (Object) [],
		];

    }
}
