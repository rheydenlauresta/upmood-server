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
        // $optionBuiler = new OptionsBuilder();
        // $optionBuiler->setTimeToLive(1);

        // $dataBuilder = new PayloadDataBuilder();
        // $dataBuilder->addData($data);

        // $option_builder = $optionBuiler->build();
        // $data_builder = $dataBuilder->build();

        // $tokens = DeviceToken::whereIn('user_id',$user_id)->pluck('token')->toArray();
        
        // foreach($user_id as $key=>$value){
        //     Notification::store($value, $data['type_id'], $data);
        // }

        // $res = FCM::sendTo($tokens, $option_builder, $notification = null, $data_builder);

        // return $res->numberSuccess();

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('Restaurant reply to your comment');
        $notificationBuilder->setBody($data)->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($data);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $tokens = DeviceToken::whereIn('user_id',$user_id)->pluck('token')->toArray();

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();
        //return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();
        //return Array (key : oldToken, value : new token - you must change the token in your database )
        $downstreamResponse->tokensToModify();
        //return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

    }
}
