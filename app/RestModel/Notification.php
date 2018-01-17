<?php

namespace App\RestModel;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    public function notificationCheck($ids)
    {
    	return $this->whereIn('id', $ids)
    			    ->where('user_id', request()->user()->id);
    }

    public function scopeCheckAndMark($query, $ids)
    {
    	// CHECK IF VALID USER NOTIFICATION AND MARK AS SEEN

    	$notification = $this->notificationCheck($ids);

    	if($notification->get()->count() <= 0) return ['status' => (int) env('EMPTY_RESPONSE_CODE'), 'message' => 'No User Notification Found'];

    	// MARK VALID NOTIFICATION AS SEEN

    	$notification = $notification->update(['seen' => 1]);

    	return ['status' => (int) env('SUCCESS_RESPONSE_CODE'), 'message' => 'success'];

    }

    public function scopeStore($query, $user_id, $type, $content){
        $notification = new $this;

        $notification->user_id = request()->user()->id;
        $notification->friend_id = $user_id;
        $notification->type_id = $type;
        $notification->content = json_encode($content);
        $notification->seen = 0;

        if(!$notification->save()){

            return [
                'status'   => (int) env('BAD_REQUEST'),
                'message' => 'something went wrong',
            ];

        }
    }

}
