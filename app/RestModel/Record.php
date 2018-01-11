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

    	return $query->select('records.id','records.type','records.heartbeat_count','records.stress_level','records.ppi',
                               'records.emotion_value','records.emotion_level','records.longitude','records.latitude',
                               'records.created_at','records.updated_at')
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
        $record->stress_level    = request('stress_level');
        $record->emotion_set     = request('emotion_set');
        $record->emotion_value   = request('emotion_value');
        $record->emotion_level   = request('emotion_level');
        $record->longitude       = request('longitude');
        $record->latitude        = request('latitude');
        $record->ppi             = request('ppi');

        $user->record_count    = $user->record_count + 1;
        $user->basic_emoji_set = request('emotion_set');

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
                'filePath'     => request('emotion_set').'/emoji/'.request('emotion_value').'.png',
            ]
        ];
    }

}
