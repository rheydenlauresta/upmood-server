<?php

namespace App\RestModel;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    //
    protected $table = 'user_groups';

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

    	$userGroup = new $this;

		$userGroup->friend_id         = request('friend_id');
		$userGroup->user_id           = request()->user()->id;
		$userGroup->group_id          = request('group_id');

		if(!$userGroup->save()){

    		return [
    			'status'   => (int) env('BAD_REQUEST'),
                'message' => 'something went wrong',
            ];

    	}

    	return [
			'status'  => (int) env('SUCCESS_RESPONSE_CODE'),
			'message' => 'success',
			'data'	  => $userGroup->toArray()
        ];

    }
}
