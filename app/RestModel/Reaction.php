<?php

namespace App\RestModel;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    protected $table = 'reactions';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at'
    ];

    public function scopeSend($query)
    {
    	
    	$user = User::find(request('id'));

    	if(!isset($user->id)){

    		return [
    			'status'   => (int) env('BAD_REQUEST'),
                'message' => 'something went wrong',
            ];

    	}

    	$react = new $this;

		$react->user_id              = request()->user()->id;
		$react->friend_id            = request('id');
		$react->heartbeat_count      = request('heartbeat_count');
		$react->emoji_resource_id    = request('emoji_resource_id');
		$react->reaction_resource_id = request('reaction_resource_id');
		$react->post_id              = request('post_id');

		$user->reaction_count = $user->reaction_count + 1;

		if(!$react->save() || !$user->save()){

    		return [
    			'status'   => (int) env('BAD_REQUEST'),
                'message' => 'something went wrong',
            ];

    	}

    	return [
			'status'  => (int) env('SUCCESS_RESPONSE_CODE'),
			'message' => 'success',
			'data'    => [
				'reaction_count' => $user->reaction_count,
            ]
        ];

    }

}
