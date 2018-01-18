<?php

namespace App\RestModel;

use Illuminate\Database\Eloquent\Model;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

use FCM;

class DeviceToken extends Model
{
    protected $fillable = [
        'user_id', 'device_id', 'token'
    ];

    protected $table = 'device_tokens';

    public function scopeStore($query)
    {

        $device = $this->where('device_id',request('device_id'))->first();

        if($device != null){

            $device->user_id           = request()->user()->id;
            $device->device_id         = request('device_id');
            $device->token             = request('token');


            if(!$device->update()){

                return [
                    'status'   => (int) env('BAD_REQUEST'),
                    'message' => 'something went wrong',
                ];

            }

        }else{
            $device = new $this;

            $device->user_id           = request()->user()->id;
            $device->device_id         = request('device_id');
            $device->token             = request('token');


            if(!$device->save()){

                return [
                    'status'   => (int) env('BAD_REQUEST'),
                    'message' => 'something went wrong',
                ];

            }

        }


    	return [
			'status'  => (int) env('SUCCESS_RESPONSE_CODE'),
			'message' => 'success',
			'data'	  => $device->toArray()
        ];

    }

    public function scopeFcmSend($query, $data, $user_id)
    {

        foreach($user_id as $key=>$value){
            Notification::store($value, $data['type_id'], $data);
        }

        // $optionBuilder = new OptionsBuilder();
        // $optionBuilder->setTimeToLive(60*20);

        // $notificationBuilder = new PayloadNotificationBuilder('my title');
        // $notificationBuilder->setBody('Hello world')
        //                     ->setSound('default');

        // $dataBuilder = new PayloadDataBuilder();
        // $dataBuilder->addData(['a_data' => 'my_data']);

        // $option = $optionBuilder->build();
        // $notification = $notificationBuilder->build();
        // $data = $dataBuilder->build();

        // $token = "a_registration_from_your_database";

        // $res = FCM::sendTo($token, $option, $notification, $data);

        $content = array('data'=>json_encode($data));

        $optionBuiler = new OptionsBuilder();
        $optionBuiler->setTimeToLive(1);

        $notificationBuilder = new PayloadNotificationBuilder($data['module']);
        $notificationBuilder->setBody($data['type'])
                            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($content);

        $option_builder = $optionBuiler->build();
        $notificationBuilder = $notificationBuilder->build();
        $data_builder = $dataBuilder->build();

        $tokens = DeviceToken::whereIn('user_id',$user_id)->pluck('token')->toArray();

        $res = FCM::sendTo($tokens, $option_builder, $notificationBuilder, $dataBuilder);

        $numberSuccess = $res->numberSuccess();
        $numberFailure = $res->numberFailure();
        $numberModification = $res->numberModification();

        $tokensToDelete = $res->tokensToDelete();
        $tokensToModify = $res->tokensToModify();
        $tokensToRetry = $res->tokensToRetry();
        $tokensWithError = $res->tokensWithError();

        $this->fcmLogs($user_id, $numberSuccess, $numberFailure, $numberModification, $tokensToDelete, $tokensToModify, $tokensToRetry, $tokensWithError);

    }

    public function fcmLogs($user_id, $numberSuccess, $numberFailure, $numberModification, $tokensToDelete, $tokensToModify, $tokensToRetry, $tokensWithError){

        foreach($user_id as $key=>$value){
            $fcmLogs = new FcmLog();

            $fcmLogs->user_id               = request()->user()->id;
            $fcmLogs->friend_id             = $value;
            $fcmLogs->numberSuccess         = $numberSuccess;
            $fcmLogs->numberFailure         = $numberFailure;
            $fcmLogs->numberModification    = $numberModification;
            $fcmLogs->tokensToDelete        = json_encode($tokensToDelete);
            $fcmLogs->tokensToModify        = json_encode($tokensToModify);
            $fcmLogs->tokensToRetry         = json_encode($tokensToRetry);
            $fcmLogs->tokensWithError       = json_encode($tokensWithError);
            $fcmLogs->save();
        }
    }
}
