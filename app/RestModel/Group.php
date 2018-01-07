<?php

namespace App\RestModel;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

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

    	$group = new $this;

		$group->user_id           = request()->user()->id;
		$group->name              = request('name');
		$group->emotion           = request('emotion');
		$group->heartbeat         = request('heartbeat');
		$group->stress_level      = request('stress_level');
		$group->my_mood           = request('my_mood');
		$group->notification_type = request('notification_type');
		$group->type_data         = request('notification_type') == 'minutes' ? request('minutes') : request('time');
		$group->emotions          = request('emotions');
		$group->members           = request('members');

		if(!$group->save()){

    		return [
    			'status'   => (int) env('BAD_REQUEST'),
                'message' => 'something went wrong',
            ];

    	}

    	return [
			'status'  => (int) env('SUCCESS_RESPONSE_CODE'),
			'message' => 'success',
			'data'	  => $group->toArray()
        ];

    }

}