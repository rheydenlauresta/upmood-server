<?php

namespace App\RestModel;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'contact_message';

    protected $hidden = [
        'updated_at'
    ];

    public function scopeStore($query)
    {
    	
    	$message = new $this;

    	$message->user_id = request()->user()->id;
    	$message->email = request('email');
    	$message->type = request('type');
    	$message->content = request('content');


    	if(!$message->save()){

    		return [
    			'status'   => (int) env('BAD_REQUEST'),
                'message' => 'something went wrong',
            ];

    	}

    	return [
			'status'  => (int) env('SUCCESS_RESPONSE_CODE'),
			'message' => 'success',
			'data'	  => $message->toArray()
        ];

    }
}
