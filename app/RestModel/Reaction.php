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
		// $react->heartbeat_count      = request('heartbeat_count');
		// $react->emoji_resource_id    = request('emoji_resource_id');
		$react->reaction_resource_id = request('reaction_resource_id');
        $react->post_id              = request('post_id');
		$react->record_id            = request('record_id');

		$user->reaction_count = $user->reaction_count + 1;

		if(!$react->save() || !$user->save()){

    		return [
    			'status'   => (int) env('BAD_REQUEST'),
                'message' => 'something went wrong',
            ];

    	}

        // fcm notification
        $user = User::find(request('id'));

        $reaction = Resources::find(request('reaction_resource_id'));
        $record = Resources::find(request('record_id'));
        $post = Post::find(request('post_id'));
                            
        $data = [
            "module"=>"Push Notification",
            "type"=>"Reaction Send",
            "type_id"=>"4",
            'heartbeat'    => request('heartbeat_count'),
            'post'         => @$post->content,
            'emoji'        => [
                'emoji_id'    => $record->resources_id,
                'emoji_path' => $record->emotion_set.'/emoji/'.$record->filename.'.png'
            ],
            'reaction'     => [
                'reaction_id'   => $reaction->id,
                'reaction_path' => $reaction->set_name.'/'.$reaction->type.'/'.$reaction->filename
            ],
            "request_from"=> [
                "id"=>request()->user()->id,
                "name"=>request()->user()->name,
                "image"=>request()->user()->image,
            ],
            "request_to"=>  [
                "id"=>$user->id,
                "name"=>$user->name,
            ],
        ];


        DeviceToken::fcmSend($data, [$user->id]);
        // /fcm notification

    	return [
			'status'  => (int) env('SUCCESS_RESPONSE_CODE'),
			'message' => 'success',
			'data'    => [
				'reaction_count' => $user->reaction_count,
            ]
        ];

    }

}
