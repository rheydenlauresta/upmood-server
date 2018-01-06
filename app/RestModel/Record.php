<?php

namespace App\RestModel;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Record extends Model
{
    protected $table = 'records';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at'
    ];

    public function scopeSort($query, $type, $id = null){

    	$userID = $id != null ? $id : request()->user()->id;

    	if($type == 'daily'){
    		$from = Carbon::today()->toDateString();
        	$to = Carbon::today()->toDateString();
    	}else if($type == 'weekly'){
    		$from = Carbon::now()->startOfWeek()->toDateString();
        	$to = Carbon::now()->endOfWeek()->toDateString();
    	}else if($type == 'monthly'){
			$from = Carbon::now()->startOfMonth()->toDateString();
	        $to = Carbon::now()->endOfMonth()->toDateString();
    	}else{
    		$from = substr(request('date'), 0, 10);
	        $to = substr(request('date'), 11, 10);
    	}

    	return $query->select('records.id','records.type','records.heartbeat_count','records.stress_level',
                               'resources.id as resource_id','resources.type as resource_type','resources.set_name as resource_set_name',
                               'resources.filename as resource_filename',
                               'records.created_at','records.updated_at')
                    ->join('resources', 'records.resources_id','=', 'resources.id')
                    ->where('records.user_id', $userID)->where('records.type', 'automated')
                    ->whereRaw('DATE(records.created_at) BETWEEN "'.$from.'" AND "'.$to.'"')
                    ->orderBy('records.id', 'desc')->get();

    }

    public function scopeStore($query)
    {

    	$record = new $this;
    	$user = request()->user();

		$record->user_id         = $user->id;
		$record->heartbeat_count = request('heartbeat_count');
		$record->resources_id    = request('resources_id');
		$record->stress_level    = request('stress_level');

		$user->record_count = $user->record_count + 1;

		if(!$record->save() || !$user->save()){

    		return [
    			'status'   => (int) env('BAD_REQUEST'),
                'message' => 'something went wrong',
            ];

    	}

    	return [
			'status'  => (int) env('SUCCESS_RESPONSE_CODE'),
			'message' => 'success',
			'data'    => [
				'record_count' => $user->record_count,
            ]
        ];
    }

}
