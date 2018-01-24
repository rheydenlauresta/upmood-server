<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController as BaseController;
use App\RestModel\User;
use App\RestModel\Notification;

class NotificationController extends BaseController
{
    public function notification($type = null, $id = null)
    {

    	if(!$id) return $this->notificationFilter($type);

    	// CHECK FOR USER NOTIFICAION THEN MARK AS SEEN

    	$connection = Notification::checkAndMark(explode(',', $id));

		$connection['method'] = 'mark-as-seen';
		$connection['errors'] = (Object) [];
		$connection['data']   = [
            'notification_count' => $this->notificationCount(),
        ];

    	return json_encode($connection);

    }

    public function notificationFilter($type)
    {
    	
    	$notification = User::find(request()->user()->id)->notifications(0, $type);

    	$data = [];

    	if($notification->getCollection()->count() > 0){
    		$data['status'] = 200;
    		$data['message'] = 'success';
    	}else{
    		$data['status'] = 204;
    		$data['message'] = 'No Record Found';
    	}

    	$notification->getCollection()->transform(function ($value) {
		    $value['content'] = json_decode($value['content']);
		    return $value;
		});

		$data['errors'] = (Object) [];
		$data['data'] = $notification->toArray();

		return json_encode($data);

    }

    public function notificationCount()
    {
        return Notification::where('user_id', request()->user()->id)->where('seen',0)->count();
    }

}
