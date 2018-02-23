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
            ->selectraw('users.id,users.name,users.email,users.image,posts.id as post_id,posts.content as profile_post,CONCAT(r.emotion_set,"/emoji/",r.emotion_value,".png") as emotion_value,r.heartbeat_count,r.stress_level,r.id as record_id,features.order')
    		->join('users','users.id','=','features.friend_id')
            ->leftJoin('records as r',function($qry){
                $qry->on('r.user_id', '=', 'users.id')->where('r.id','=',DB::raw('(select max(records.id) from records where records.user_id = users.id)'));
            })
            ->leftJoin('posts',function($qry){
                $qry->on('posts.user_id', '=', 'users.id')->where('posts.id','=',DB::raw('(select max(posts.id) from posts where posts.user_id = users.id)'));
            })
    		->selectraw('users.id,users.name,users.email,users.image')->orderBy('order','ASC')
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
                'data'     => [],
            ];
        }

    	return $data;

    }

    public function scopeStore($query)
    {
    	$count_featured = $this->where('user_id',request()->user()->id)->count();
        $check_featured = $this->where('user_id',request()->user()->id)->where('friend_id',request('friend_id'))->first();

    	if($count_featured >= '5'){
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

        if(request('friend_id')){
            $id = request('friend_id');
        }else{
            $id = request('id');
        }

        $featured = $this->where('user_id',request()->user()->id)
                  ->where('friend_id',$id)
                  ->delete();

        if($featured == 0){

            return [
                'status'   => (int) env('BAD_REQUEST'),
                'message' => 'something went wrong',
            ];
        }

        return [
            'status'   => (int) env('SUCCESS_RESPONSE_CODE'),
            'message' => 'success',
        ];
    }
}
