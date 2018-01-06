<?php

namespace App\RestModel;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at'
    ];

    public function scopeStore($query)
    {
    	
    	$post = new $this;

    	$post->user_id = request()->user()->id;
    	$post->content = request('content');

    	$user = request()->user();

    	$user->profile_post = request('content');
    	$user->post_count = $user->post_count + 1;

    	if(!$post->save() || !$user->save()){

    		return [
    			'status'   => (int) env('BAD_REQUEST'),
                'message' => 'something went wrong',
            ];

    	}

    	return [
			'status'  => (int) env('SUCCESS_RESPONSE_CODE'),
			'message' => 'success',
			'data'    => [
				'post_count' => $user->post_count,
				'post'       => request('content')
            ]
        ];

    }

}
