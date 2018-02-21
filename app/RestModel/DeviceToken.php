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
        if($data['type_id'] != 3){
            
            foreach($user_id as $key=>$value){
                Notification::store($value, $data['type_id'], $data);
            }
        }
        // dd($user_id);
        $optionBuiler = new OptionsBuilder();
        $optionBuiler->setTimeToLive(1);

        $notificationBuilder = new PayloadNotificationBuilder($data['module']);
        $notificationBuilder->setBody($data['type'])
                            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($data);

        $option_builder = $optionBuiler->build();
        $notification_builder = $notificationBuilder->build();
        $data_builder = $dataBuilder->build();

        $tokens = DeviceToken::whereIn('user_id',$user_id)->pluck('token')->toArray();

        $res = FCM::sendTo($tokens, $option_builder, $notification_builder, $data_builder);

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