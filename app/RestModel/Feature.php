<?php

namespace App\RestModel;

use Illuminate\Database\Eloquent\Model;
use DB;
class Feature extends Model
{
    protected $fillable = [
        'user_id', 'friend_id'
    ];

    protected $table = 'features';

    public function scopeListAll($query)
    {

    	$query = $this->where('features.user_id',request()->user()->id)
            ->selectraw('users.id,users.name,users.email,users.image,r.emotion_value,r.heartbeat_count,r.stress_level')
    		->join('users','users.id','=','features.friend_id')
            ->leftJoin('records as r',function($qry){
                $qry->on('r.user_id', '=', 'users.id')->where('r.id','=',DB::raw('(select max(records.id) from records where records.user_id = users.id)'));
            })
    		->selectraw('users.id,users.name,users.email,users.image')
    		->get()->toArray();

        if($query != null) {

            $data = [
                'status'   => (int) env('SUCCESS_RESPONSE_CODE'),
                'message' => 'success',
                'module'   => 'featured-friends',
                'errors'   => (Object) [],
                'data'     => $query,
            ];
        }else{
            $data = [
                'status' => 204,
                'message' => 'No Record Found',
                'module'   => 'featured-friends',
                'errors'   => (Object) [],
                'data'     => (Object) [],
            ];
        }


    	return $data;

    }

    public function scopeStore($query)
    {
    	$count_featured = $this->where('user_id',request()->user()->id)->count();
        $check_featured = $this->where('user_id',request()->user()->id)->where('friend_id',request('friend_id'))->first();

    	if($count_featured >= '4'){
    		return ['status' => false, 'message' => 'Featured friend have reached the limit(4).'];
    	}

        if($check_featured != null){
            $check_featured->friend_id   = request('friend_id');
            $check_featured->order       = request('order');

            if(!$check_featured->update()){

                return [
                    'status'   => (int) env('BAD_REQUEST'),
                    'message' => 'something went wrong',
                ];

            }

            return [
                'status'  => (int) env('SUCCESS_RESPONSE_CODE'),
                'message' => 'success',
                'data'    => $check_featured->toArray()
            ];
        }else{

        	$featured = new $this;

    		$featured->user_id           = request()->user()->id;
            $featured->friend_id         = request('friend_id');
    		$featured->order             = request('order');

    		if(!$featured->save()){

        		return [
        			'status'   => (int) env('BAD_REQUEST'),
                    'message' => 'something went wrong',
                ];

        	}

        	return [
    			'status'  => (int) env('SUCCESS_RESPONSE_CODE'),
    			'message' => 'success',
    			'data'	  => $featured->toArray()
            ];
        }


    }

    public function scopeRemove($query)
    {
    	$featured = new $this;

        $featured->where('user_id',request()->user()->id)
                  ->where('friend_id',request('friend_id'))
                  ->delete();

        if(!$featured){

            return [
                'status'   => (int) env('BAD_REQUEST'),
                'message' => 'something went wrong',
            ];

        }
    }
}
