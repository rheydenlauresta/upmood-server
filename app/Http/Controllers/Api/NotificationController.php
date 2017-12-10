<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RestModel\User;
use App\RestModel\Notification;

class NotificationController extends Controller
{
    public function notification($type = null, $id = null)
    {

    	if(!$id) return $this->notificationFilter($type);

    	// CHECK FOR USER NOTIFICAION THEN MARK AS SEEN

    	$connection = Notification::checkAndMark(explode(',', $id));

		$connection['method'] = 'mark-as-seen';
		$connection['errors'] = [];
		$connection['data']   = [];

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

		$data['errors'] = [];
		$data['data'] = $notification->toArray();

		return json_encode($data);

    }

}
