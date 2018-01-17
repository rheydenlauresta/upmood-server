<?php

namespace App\RestModel;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = [
        'user_id', 'friend_id'
    ];

    protected $table = 'features';

    public function scopeListAll($query)
    {

    	$query = $this->where('user_id',request()->user()->id)
    		->join('users','users.id','=','features.friend_id')
    		->selectraw('users.id,users.name,users.email,users.image')
    		->get()->toArray();

    	$data = [
    		'id'=>request()->user()->id,
    		'name'=>request()->user()->name,
    		'image'=>request()->user()->image,
    		'featured'=>$query,
    	];

    	return $data;

    }

    public function scopeStore($query)
    {
    	$count_featured = $this->where('user_id',request()->user()->id)->count();

    	if($count_featured >= '4'){
    		return ['status' => false, 'message' => 'Featured friend have reached the limit(4).'];
    	}

    	$featured = new $this;

		$featured->user_id           = request()->user()->id;
		$featured->friend_id         = request('friend_id');

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
